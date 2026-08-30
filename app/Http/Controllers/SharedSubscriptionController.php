<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionShare;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SharedSubscriptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        foreach ($user->subscriptions as $sub) {
            if (empty($sub->invite_code)) {
                $sub->update(['invite_code' => 'GRP-' . strtoupper(Str::random(6))]);
            }
        }

        $mySharedSubscriptions = Subscription::where('user_id', $user->id)
            ->active()
            ->where(function ($q) {
                $q->has('shares')->orWhere('is_public', true);
            })
            ->with(['shares.friendUser', 'shares.owner', 'category', 'user'])
            ->latest()
            ->get()
            ->map(function ($sub) {
                $sub->pending_proofs_count = $sub->shares->filter(function ($s) {
                    return !empty($s->payment_proof_path) && $s->payment_status === 'pending';
                })->count();
                return $sub;
            });

        $mySubscriptions = Subscription::where('user_id', $user->id)->active()->with('shares')->get();

        $acceptedFriendships = \App\Models\Friendship::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)->orWhere('friend_id', $user->id);
        })->where('status', 'accepted')->get();

        $friendIds = $acceptedFriendships->map(fn($f) => $f->user_id === $user->id ? $f->friend_id : $f->user_id);
        $friends = User::whereIn('id', $friendIds)->get();

        $sharedWithMe = SubscriptionShare::where('friend_user_id', $user->id)
            ->with(['subscription.category', 'subscription.user', 'owner', 'subscription.shares.friendUser'])
            ->latest('updated_at')
            ->get();

        $relevantShareIds = SubscriptionShare::where('owner_id', $user->id)
            ->orWhere('friend_user_id', $user->id)
            ->pluck('id');

        $activities = collect();
        $recentShares = SubscriptionShare::whereIn('id', $relevantShareIds)
            ->with(['subscription', 'friendUser', 'owner'])
            ->latest('updated_at')
            ->take(10)
            ->get();

        foreach ($recentShares as $share) {
            $friendName = $share->friendUser->name ?? $share->friend_name ?? 'Anggota';
            $subName = $share->subscription->name ?? 'Langganan';

            if ($share->payment_status === 'paid' && $share->paid_at) {
                $activities->push([
                    'type' => 'paid',
                    'title' => 'Pembayaran ' . $friendName . ' dikonfirmasi',
                    'desc' => $subName,
                    'time' => $share->paid_at->diffForHumans(),
                    'raw_time' => $share->paid_at,
                ]);
            } elseif ($share->payment_proof_path && $share->payment_status === 'pending') {
                $activities->push([
                    'type' => 'proof',
                    'title' => $friendName . ' mengunggah bukti bayar',
                    'desc' => $subName,
                    'time' => $share->updated_at->diffForHumans(),
                    'raw_time' => $share->updated_at,
                ]);
            } elseif ($share->rejection_reason && $share->payment_status === 'pending') {
                $activities->push([
                    'type' => 'rejected',
                    'title' => 'Bukti bayar ' . $friendName . ' ditolak',
                    'desc' => $subName,
                    'time' => $share->updated_at->diffForHumans(),
                    'raw_time' => $share->updated_at,
                ]);
            } else {
                $activities->push([
                    'type' => 'joined',
                    'title' => $friendName . ' bergabung dalam patungan',
                    'desc' => $subName,
                    'time' => $share->created_at->diffForHumans(),
                    'raw_time' => $share->created_at,
                ]);
            }
        }

        $activities = $activities->sortByDesc('raw_time')->values()->take(5);

        return view('shares.index', compact('mySharedSubscriptions', 'mySubscriptions', 'friends', 'sharedWithMe', 'activities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'friend_user_ids' => 'required|array|min:1',
            'friend_user_ids.*' => 'exists:users,id',
            'is_public' => 'nullable|boolean',
        ]);

        $sub = Subscription::where('id', $request->subscription_id)->where('user_id', Auth::id())->firstOrFail();

        if ($request->has('is_public')) {
            $sub->update(['is_public' => $request->boolean('is_public')]);
        }

        if ($sub->is_personal) {
            return back()->with('error', 'Layanan ini bersifat personal dan tidak dapat dibagikan.');
        }

        $friendUsers = User::whereIn('id', $request->friend_user_ids)->get();
        $addedCount = 0;

        foreach ($friendUsers as $friendUser) {
            $existing = SubscriptionShare::where('subscription_id', $sub->id)
                ->where('friend_user_id', $friendUser->id)
                ->exists();

            if ($existing) continue;

            $isFriend = \App\Models\Friendship::where('status', 'accepted')
                ->where(function($q) use ($friendUser) {
                    $q->where('user_id', Auth::id())->where('friend_id', $friendUser->id);
                })->orWhere(function($q) use ($friendUser) {
                    $q->where('friend_id', Auth::id())->where('user_id', $friendUser->id);
                })->exists();

            if (!$isFriend) continue;

            SubscriptionShare::create([
                'subscription_id' => $sub->id,
                'owner_id' => Auth::id(),
                'friend_user_id' => $friendUser->id,
                'friend_name' => $friendUser->name,
                'split_amount' => 0,
                'payment_status' => 'pending',
                'due_date' => $sub->next_payment_date->format('Y-m-d'),
            ]);

            $addedCount++;
        }

        if ($addedCount > 0) {
            $this->recalculateAutoSplits($sub->fresh());
            return back()->with('success', "Berhasil menambahkan {$addedCount} teman. Biaya telah dibagi ulang secara otomatis.");
        }

        return back()->with('error', 'Tidak ada teman baru yang ditambahkan.');
    }

    public function uploadProof(Request $request, $id)
    {
        $share = SubscriptionShare::where('id', $id)->where('friend_user_id', Auth::id())->firstOrFail();

        $request->validate([
            'proof' => 'required|image|max:3072',
        ]);

        if ($request->hasFile('proof')) {
            if ($share->payment_proof_path) {
                Storage::disk('public')->delete($share->payment_proof_path);
            }
            $path = $request->file('proof')->store('proofs', 'public');

            $share->update([
                'payment_proof_path' => $path,
                'payment_status' => 'pending',
                'rejection_reason' => null,
                'paid_at' => null,
            ]);

            return back()->with('success', 'Bukti transfer berhasil diunggah. Menunggu konfirmasi dari ketua.');
        }

        return back()->with('error', 'Gagal mengunggah bukti transfer.');
    }

    public function rejectProof(Request $request, $id)
    {
        $share = SubscriptionShare::where('id', $id)->where('owner_id', Auth::id())->firstOrFail();

        $request->validate([
            'rejection_reason' => 'nullable|string|max:255',
        ]);

        if ($share->payment_proof_path) {
            Storage::disk('public')->delete($share->payment_proof_path);
        }

        $reason = $request->input('rejection_reason', 'Bukti transfer tidak valid atau tidak terbaca.');

        $share->update([
            'payment_proof_path' => null,
            'payment_status' => 'pending',
            'paid_at' => null,
            'rejection_reason' => $reason,
        ]);

        return back()->with('success', "Bukti transfer dari {$share->friend_name} telah ditolak.");
    }

    public function markPaid($id)
    {
        $share = SubscriptionShare::where('id', $id)->where('owner_id', Auth::id())->firstOrFail();
        $share->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
            'rejection_reason' => null,
        ]);

        return back()->with('success', "Status patungan {$share->friend_name} berhasil ditandai Lunas.");
    }

    public function resetCycle($id)
    {
        $subscription = Subscription::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        foreach ($subscription->shares as $share) {
            if ($share->payment_proof_path) {
                Storage::disk('public')->delete($share->payment_proof_path);
            }
            $share->update([
                'payment_status' => 'pending',
                'payment_proof_path' => null,
                'paid_at' => null,
                'rejection_reason' => null,
                'due_date' => $subscription->next_payment_date->format('Y-m-d'),
            ]);
        }

        return back()->with('success', "Periode tagihan baru untuk {$subscription->name} berhasil dimulai.");
    }

    public function updatePaymentInfo(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:50',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:100',
        ]);

        Auth::user()->update([
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder' => $request->account_holder,
        ]);

        return back()->with('success', 'Informasi rekening pembayaran berhasil disimpan.');
    }

    public function sendReminder($id, TelegramService $telegramService)
    {
        $share = SubscriptionShare::where('id', $id)->where('owner_id', Auth::id())->with(['friendUser', 'subscription', 'owner'])->firstOrFail();

        if ($share->friendUser && $share->friendUser->telegram_chat_id) {
            $ownerName = Auth::user()->name;
            $bankInfo = '';
            if (Auth::user()->account_number) {
                $bankInfo = "\nPembayaran: " . Auth::user()->bank_name . " - " . Auth::user()->account_number . " (" . Auth::user()->account_holder . ")";
            }

            $message = "<b>Pengingat Patungan Tatagih</b>\n\n"
                . "Halo <b>{$share->friend_name}</b>, Anda memiliki tagihan patungan:\n\n"
                . "Layanan: <b>{$share->subscription->name}</b>\n"
                . "Bagian Anda: <b>{$share->formatted_split_amount}</b>\n"
                . "Ketua: <b>{$ownerName}</b>"
                . $bankInfo . "\n\n"
                . "Mohon segera melakukan transfer dan konfirmasi pembayaran.\n\n"
                . "QRIS / QR Payment: " . $share->payment_qr_url;

            $sent = $telegramService->sendMessage($share->friendUser->telegram_chat_id, $message);

            if ($sent) {
                return back()->with('success', "Pengingat berhasil dikirim via Telegram ke {$share->friend_name}.");
            }
        }

        return back()->with('error', "Gagal mengirim pesan Telegram. Pastikan {$share->friend_name} telah menghubungkan akun Telegram.");
    }

    public function joinGroup($code)
    {
        $subscription = Subscription::where('invite_code', $code)->with(['user', 'category', 'shares'])->firstOrFail();

        $totalMembers = $subscription->shares->count() + 2;
        $splitAmount = round($subscription->amount / $totalMembers);

        return view('shares.join', compact('subscription', 'splitAmount', 'totalMembers'));
    }

    public function confirmJoinGroup(Request $request, $code)
    {
        $subscription = Subscription::where('invite_code', $code)->firstOrFail();
        $user = Auth::user();

        if ($subscription->user_id === $user->id) {
            return back()->with('error', 'Anda adalah pemilik langganan ini.');
        }

        $existing = SubscriptionShare::where('subscription_id', $subscription->id)
            ->where('friend_user_id', $user->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah bergabung dalam grup patungan ini.');
        }

        if ($subscription->is_personal) {
            return back()->with('error', 'Layanan ini bersifat personal dan tidak dapat dibagikan.');
        }

        $totalMembers = $subscription->shares()->count() + 2;
        $splitAmount = round($subscription->amount / $totalMembers);

        SubscriptionShare::create([
            'subscription_id' => $subscription->id,
            'owner_id' => $subscription->user_id,
            'friend_user_id' => $user->id,
            'friend_name' => $user->name,
            'split_amount' => $splitAmount,
            'payment_status' => 'pending',
            'due_date' => $subscription->next_payment_date->format('Y-m-d'),
        ]);

        $this->recalculateAutoSplits($subscription->fresh());

        return back()->with('success', "Berhasil bergabung dalam grup patungan {$subscription->name}. Porsi patungan: Rp" . number_format($splitAmount, 0, ',', '.') . ".");
    }

    public function destroy($id)
    {
        $share = SubscriptionShare::where('id', $id)
            ->where(function($q) {
                $q->where('owner_id', Auth::id())
                  ->orWhere('friend_user_id', Auth::id());
            })->firstOrFail();

        $isOwner = $share->owner_id === Auth::id();
        $subscription = $share->subscription;

        if ($share->payment_proof_path) {
            Storage::disk('public')->delete($share->payment_proof_path);
        }

        $share->delete();

        if ($subscription) {
            $this->recalculateAutoSplits($subscription->fresh());
        }

        $message = $isOwner 
            ? 'Anggota patungan berhasil dihapus dan porsi patungan dihitung ulang.' 
            : 'Anda berhasil keluar dari grup patungan.';

        return back()->with('success', $message);
    }

    public function togglePublic($id)
    {
        $subscription = Subscription::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $subscription->update(['is_public' => !$subscription->is_public]);

        $status = $subscription->is_public ? 'Publik' : 'Privat';
        return back()->with('success', "Grup patungan {$subscription->name} sekarang diset menjadi {$status}.");
    }

    private function recalculateAutoSplits(Subscription $subscription): void
    {
        $shares = $subscription->shares;
        if ($shares->isEmpty()) return;

        $totalMembers = $shares->count() + 1;
        $autoSplitAmount = round($subscription->amount / $totalMembers);

        foreach ($shares as $s) {
            $s->update(['split_amount' => $autoSplitAmount]);
        }
    }
}

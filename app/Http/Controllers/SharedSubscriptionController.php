<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionShare;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SharedSubscriptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        
        foreach ($user->subscriptions as $sub) {
            if (empty($sub->invite_code)) {
                $sub->update(['invite_code' => 'GRP-' . strtoupper(\Illuminate\Support\Str::random(6))]);
            }
        }

        
        $mySharedSubscriptions = Subscription::where('user_id', $user->id)
            ->active()
            ->with(['shares.friendUser', 'category'])
            ->get();

        
        $mySubscriptions = Subscription::where('user_id', $user->id)->active()->with('shares')->get();

        
        $acceptedFriendships = \App\Models\Friendship::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)->orWhere('friend_id', $user->id);
        })->where('status', 'accepted')->get();

        $friendIds = $acceptedFriendships->map(fn($f) => $f->user_id === $user->id ? $f->friend_id : $f->user_id);
        $friends = User::whereIn('id', $friendIds)->get();

        
        $sharedWithMe = SubscriptionShare::where('friend_user_id', $user->id)
            ->with(['subscription.category', 'owner', 'subscription.shares'])
            ->get();

        return view('shares.index', compact('mySharedSubscriptions', 'mySubscriptions', 'friends', 'sharedWithMe'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'friend_user_id' => 'required|exists:users,id',
            'split_amount' => 'required|numeric|min:0',
        ]);

        $sub = Subscription::where('id', $request->subscription_id)->where('user_id', Auth::id())->firstOrFail();
        $friendUser = User::findOrFail($request->friend_user_id);

        
        $isFriend = \App\Models\Friendship::where('status', 'accepted')
            ->where(function($q) use ($friendUser) {
                $q->where('user_id', Auth::id())->where('friend_id', $friendUser->id);
            })->orWhere(function($q) use ($friendUser) {
                $q->where('friend_id', Auth::id())->where('user_id', $friendUser->id);
            })->exists();
        
        if (!$isFriend) {
            return back()->withErrors(['friend_user_id' => 'Anggota harus dari daftar teman Anda.']);
        }

        if ($sub->is_personal) {
            return back()->with('error', 'Maaf, layanan ini bersifat personal/pribadi (seperti BPJS atau Asuransi) dan tidak dapat di-share/patungan dengan orang lain.');
        }

        
        $totalMembers = $sub->shares()->count() + 2;
        $autoSplitAmount = round($sub->amount / $totalMembers);
        $finalSplitAmount = $autoSplitAmount;

        SubscriptionShare::create([
            'subscription_id' => $sub->id,
            'owner_id' => Auth::id(),
            'friend_user_id' => $friendUser->id,
            'friend_name' => $friendUser->name,
            'split_amount' => $finalSplitAmount,
            'payment_status' => 'pending',
            'due_date' => $sub->next_payment_date->format('Y-m-d'),
        ]);

        
        $this->recalculateAutoSplits($sub);

        return back()->with('success', "Berhasil menambahkan {$friendUser->name}! Tagihan terhitung otomatis: Rp" . number_format($finalSplitAmount, 0, ',', '.') . " / orang ({$totalMembers} anggota termasuk Ketua).");
    }

    public function uploadProof(Request $request, $id)
    {
        $share = SubscriptionShare::where('id', $id)->where('friend_user_id', Auth::id())->firstOrFail();

        $request->validate([
            'proof' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('proof')) {
            if ($share->payment_proof_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($share->payment_proof_path);
            }
            $path = $request->file('proof')->store('proofs', 'public');
            
            $share->update([
                'payment_proof_path' => $path,
            ]);

            return back()->with('success', 'Bukti transfer berhasil diunggah! Menunggu validasi dari Ketua.');
        }

        return back()->with('error', 'Gagal mengunggah bukti transfer.');
    }

    public function rejectProof($id)
    {
        $share = SubscriptionShare::where('id', $id)->where('owner_id', Auth::id())->firstOrFail();
        
        if ($share->payment_proof_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($share->payment_proof_path);
        }

        $share->update([
            'payment_proof_path' => null,
            'payment_status' => 'pending',
        ]);

        return back()->with('success', "Bukti bayar dari {$share->friend_name} telah ditolak. Mereka harus mengunggah ulang.");
    }

    public function markPaid($id)
    {
        $share = SubscriptionShare::where('id', $id)->where('owner_id', Auth::id())->firstOrFail();
        $share->update(['payment_status' => 'paid']);

        return back()->with('success', "Status patungan {$share->friend_name} berhasil ditandai LUNAS!");
    }

    public function sendReminder($id, TelegramService $telegramService)
    {
        $share = SubscriptionShare::where('id', $id)->where('owner_id', Auth::id())->with('friendUser', 'subscription')->firstOrFail();

        if ($share->friendUser && $share->friendUser->telegram_chat_id) {
            $message = "<b>Reminder Patungan Tatagih</b>\n\n"
                . "Halo <b>{$share->friend_name}</b>, Anda memiliki tagihan patungan subscription:\n\n"
                . "Layanan: <b>{$share->subscription->name}</b>\n"
                . "Bagian Anda: <b>{$share->formatted_split_amount}</b>\n"
                . "Pemilik Tagihan: <b>" . Auth::user()->name . "</b>\n\n"
                . "Mohon segera melakukan transfer/pembayaran patungan.\n\n"
                . "QRIS / QR Payment: " . $share->payment_qr_url;

            $sent = $telegramService->sendMessage($share->friendUser->telegram_chat_id, $message);

            if ($sent) {
                return back()->with('success', "Reminder patungan & QR Code berhasil dikirim via Telegram ke {$share->friend_name}!");
            }
        }

        return back()->with('error', "Gagal mengirim pesan Telegram. Pastikan {$share->friend_name} telah menghubungkan akun Telegram.");
    }

    public function joinGroup($code)
    {
        $subscription = Subscription::where('invite_code', $code)->with('user', 'category', 'shares')->firstOrFail();

        
        $totalMembers = $subscription->shares->count() + 2;
        $splitAmount = round($subscription->amount / $totalMembers);

        return view('shares.join', compact('subscription', 'splitAmount', 'totalMembers'));
    }

    public function confirmJoinGroup(Request $request, $code)
    {
        $subscription = Subscription::where('invite_code', $code)->firstOrFail();
        $user = Auth::user();

        if ($subscription->user_id === $user->id) {
            return redirect()->route('shares.index')->with('error', 'Anda adalah pemilik/ketua dari subscription ini.');
        }

        $existing = SubscriptionShare::where('subscription_id', $subscription->id)
            ->where('friend_user_id', $user->id)
            ->first();

        if ($existing) {
            return redirect()->route('shares.index')->with('error', 'Anda sudah bergabung dalam grup patungan ini.');
        }

        if ($subscription->is_personal) {
            return redirect()->route('shares.index')->with('error', 'Maaf, layanan ini bersifat personal/pribadi (seperti BPJS atau Asuransi) dan tidak dapat di-share/patungan dengan orang lain.');
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

        $this->recalculateAutoSplits($subscription);

        return redirect()->route('shares.index')->with('success', "Selamat! Anda berhasil bergabung dalam grup patungan {$subscription->name}! Porsi patungan: Rp" . number_format($splitAmount, 0, ',', '.') . " ({$totalMembers} anggota termasuk Ketua).");
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
        $share->delete();

        if ($subscription) {
            $this->recalculateAutoSplits($subscription);
        }

        $message = $isOwner 
            ? 'Anggota patungan berhasil dihapus dan porsi patungan dihitung ulang!' 
            : 'Anda berhasil menolak/keluar dari grup patungan tersebut!';

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

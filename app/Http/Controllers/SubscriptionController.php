<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Category;
use App\Models\PaymentHistory;
use App\Http\Requests\SubscriptionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscription::where('user_id', Auth::id())->with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Fetch ALL without pagination for dashboard stats
        $subscriptions = $query->latest()->get();
        $categories = Category::all();
        
        $activeSubs = $subscriptions->where('status', 'active');
        $totalActiveCount = $activeSubs->count();
        $monthlySpending = $activeSubs->sum('amount');
        
        // Tagihan jatuh tempo dalam 7 hari ke depan
        $upcomingCount = $activeSubs->filter(function($sub) {
            return $sub->days_until_payment <= 7;
        })->count();

        // Data dummy: Total penghematan (misalnya dari patungan/tips hemat)
        $totalSavings = 248000;

        // Ambil semua kategori untuk dihitung statistik popularitas (Aktif)
        $popularCategories = $categories->map(function($cat) use ($activeSubs) {
            $cat->active_count = $activeSubs->where('category_id', $cat->id)->count();
            return $cat;
        })->filter(function($cat) {
            return $cat->active_count > 0;
        })->sortByDesc('active_count')->values();

        // Pembayaran mendatang diurutkan berdasarkan hari terdekat
        $upcomingPayments = $activeSubs->sortBy('days_until_payment')->take(5)->values();

        return view('subscriptions.index', compact(
            'subscriptions', 
            'categories', 
            'totalActiveCount', 
            'monthlySpending', 
            'upcomingCount', 
            'totalSavings',
            'popularCategories',
            'upcomingPayments'
        ));
    }

    public function create(\App\Services\SubscriptionTemplateService $templateService)
    {
        $categories = Category::all();
        $templates = $templateService->getTemplates();
        return view('subscriptions.create', compact('categories', 'templates'));
    }

    public function store(SubscriptionRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        Subscription::create($data);

        return redirect()->route('subscriptions.index')
            ->with('success', 'Subscription berhasil ditambahkan!');
    }

    public function show(Subscription $subscription)
    {
        $this->authorize('view', $subscription);

        $subscription->load(['category', 'paymentHistories' => function ($q) {
            $q->latest()->take(10);
        }]);

        return view('subscriptions.show', compact('subscription'));
    }

    public function edit(Subscription $subscription)
    {
        $this->authorize('update', $subscription);
        $categories = Category::all();

        return view('subscriptions.edit', compact('subscription', 'categories'));
    }

    public function update(SubscriptionRequest $request, Subscription $subscription)
    {
        $this->authorize('update', $subscription);

        $subscription->update($request->validated());

        return redirect()->route('subscriptions.index')
            ->with('success', 'Subscription berhasil diperbarui!');
    }

    public function destroy(Subscription $subscription)
    {
        $this->authorize('delete', $subscription);

        $subscription->delete();

        return redirect()->route('subscriptions.index')
            ->with('success', 'Subscription berhasil dihapus!');
    }

    public function markPaid(Subscription $subscription)
    {
        $this->authorize('update', $subscription);

        PaymentHistory::create([
            'user_id' => Auth::id(),
            'subscription_id' => $subscription->id,
            'amount' => $subscription->amount,
            'payment_date' => now()->format('Y-m-d'),
            'status' => 'paid',
            'note' => 'Pembayaran dikonfirmasi via Quick Action',
        ]);

        return back()->with('success', "Pembayaran untuk {$subscription->name} berhasil dicatat sebagai Lunas!");
    }

    public function toggleStatus(Subscription $subscription)
    {
        $this->authorize('update', $subscription);

        $newStatus = $subscription->status === 'active' ? 'cancelled' : 'active';
        $subscription->update(['status' => $newStatus]);

        $statusText = $newStatus === 'active' ? 'diaktifkan kembali' : 'dibatalkan';
        return back()->with('success', "Status subscription {$subscription->name} berhasil {$statusText}.");
    }

    public function export()
    {
        $subscriptions = Subscription::where('user_id', Auth::id())->with('category')->get();

        $filename = 'subscriptions_tatagih_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($subscriptions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Nama', 'Kategori', 'Nominal', 'Mata Uang', 'Siklus Billing', 'Tanggal Pembayaran', 'Auto Renew', 'Status', 'Tanggal Mulai']);

            foreach ($subscriptions as $sub) {
                fputcsv($file, [
                    $sub->id,
                    $sub->name,
                    $sub->category->name ?? 'Uncategorized',
                    $sub->amount,
                    $sub->currency,
                    $sub->billing_cycle,
                    $sub->payment_date,
                    $sub->auto_renew ? 'Ya' : 'Tidak',
                    $sub->status,
                    $sub->start_date->format('Y-m-d'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

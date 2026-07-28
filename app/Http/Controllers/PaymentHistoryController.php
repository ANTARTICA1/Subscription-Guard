<?php

namespace App\Http\Controllers;

use App\Models\PaymentHistory;
use App\Models\Subscription;
use App\Http\Requests\PaymentHistoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PaymentHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = PaymentHistory::where('user_id', Auth::id())->with('subscription.category');

        if ($request->filled('subscription_id')) {
            $query->where('subscription_id', $request->subscription_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $payments = $query->latest('payment_date')->paginate(15);
        $subscriptions = Subscription::where('user_id', Auth::id())->get();

        
        $chartLabels = [];
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartLabels[] = $month->translatedFormat('M Y');
            $chartData[] = PaymentHistory::where('user_id', Auth::id())
                ->whereMonth('payment_date', $month->month)
                ->whereYear('payment_date', $month->year)
                ->where('status', 'paid')
                ->sum('amount');
        }

        $totalPaid = PaymentHistory::where('user_id', Auth::id())
            ->where('status', 'paid')
            ->sum('amount');

        // Fetch Split Bill Validations
        $pendingVerifications = \App\Models\SubscriptionShare::where('owner_id', Auth::id())
            ->whereNotNull('payment_proof_path')
            ->where('payment_status', 'pending')
            ->with(['subscription.category', 'friendUser'])
            ->latest('updated_at')
            ->get();

        $historyValidations = \App\Models\SubscriptionShare::where('owner_id', Auth::id())
            ->whereNotNull('payment_proof_path')
            ->where('payment_status', 'paid')
            ->with(['subscription.category', 'friendUser'])
            ->latest('updated_at')
            ->take(15)
            ->get();

        return view('payments.index', compact(
            'payments', 'subscriptions', 'chartLabels', 'chartData', 'totalPaid', 
            'pendingVerifications', 'historyValidations'
        ));
    }

    public function store(PaymentHistoryRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        PaymentHistory::create($data);

        return redirect()->route('payments.index')
            ->with('success', 'Pembayaran berhasil dicatat!');
    }

    public function destroy($id)
    {
        $payment = PaymentHistory::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Catatan pembayaran berhasil dihapus!');
    }
}

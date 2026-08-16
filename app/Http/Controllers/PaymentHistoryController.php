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
        $chartCountData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartLabels[] = $month->translatedFormat('M Y');
            $sum = PaymentHistory::where('user_id', Auth::id())
                ->whereMonth('payment_date', $month->month)
                ->whereYear('payment_date', $month->year)
                ->where('status', 'paid')
                ->sum('amount');
            $count = PaymentHistory::where('user_id', Auth::id())
                ->whereMonth('payment_date', $month->month)
                ->whereYear('payment_date', $month->year)
                ->where('status', 'paid')
                ->count();
            $chartData[] = (float)$sum;
            $chartCountData[] = $count;
        }

        $totalPaid = PaymentHistory::where('user_id', Auth::id())
            ->where('status', 'paid')
            ->sum('amount');

        $categoryData = PaymentHistory::where('payment_histories.user_id', Auth::id())
            ->where('payment_histories.status', 'paid')
            ->join('subscriptions', 'payment_histories.subscription_id', '=', 'subscriptions.id')
            ->join('categories', 'subscriptions.category_id', '=', 'categories.id')
            ->selectRaw('categories.name as category_name, categories.color, SUM(payment_histories.amount) as total')
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->get();

        $totalCategorySum = $categoryData->sum('total');
        $donutLabels = [];
        $donutData = [];
        $donutColors = [];
        $donutPercentages = [];
        foreach ($categoryData as $cat) {
            $donutLabels[] = $cat->category_name;
            $donutData[] = $cat->total;
            $donutColors[] = $cat->color ?? '#3b82f6';
            $donutPercentages[] = $totalCategorySum > 0 ? round(($cat->total / $totalCategorySum) * 100) : 0;
        }

        $totalPaidSparkline = $this->generateSparklinePath($chartData);
        $transactionCountSparkline = $this->generateSparklinePath($chartCountData);
        $activeSubCountData = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
            $monthEnd = Carbon::now()->subMonths($i)->endOfMonth();
            
            $count = $subscriptions->filter(function($sub) use ($monthStart, $monthEnd) {
                $start = $sub->start_date ? Carbon::parse($sub->start_date) : $sub->created_at;
                if ($start > $monthEnd) return false;
                
                if ($sub->status !== 'active') {
                   $end = $sub->end_date ? Carbon::parse($sub->end_date) : $sub->updated_at;
                   if ($end < $monthStart) return false;
                }
                return true;
            })->count();
            
            $activeSubCountData[] = $count;
        }

        $activeSubCount = $activeSubCountData[5] ?? 0;
        $lastMonthActiveSubCount = $activeSubCountData[4] ?? 0;
        $activeSubDiff = $activeSubCount - $lastMonthActiveSubCount;
        $activeSubSparkline = $this->generateSparklinePath($activeSubCountData);

        $thisMonthSum = $chartData[5] ?? 0;
        $lastMonthSum = $chartData[4] ?? 0;
        $totalPaidDiffPct = 0;
        if ($lastMonthSum > 0) {
            $totalPaidDiffPct = round((($thisMonthSum - $lastMonthSum) / $lastMonthSum) * 100, 1);
        } elseif ($thisMonthSum > 0) {
            $totalPaidDiffPct = 100;
        }

        $thisMonthCount = $chartCountData[5] ?? 0;
        $lastMonthCount = $chartCountData[4] ?? 0;
        $trxCountDiff = $thisMonthCount - $lastMonthCount;

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
            'pendingVerifications', 'historyValidations',
            'donutLabels', 'donutData', 'donutColors', 'donutPercentages', 'totalCategorySum',
            'totalPaidSparkline', 'transactionCountSparkline', 'activeSubSparkline',
            'totalPaidDiffPct', 'thisMonthCount', 'trxCountDiff', 'activeSubCount', 'activeSubDiff'
        ));
    }

    private function generateSparklinePath(array $data)
    {
        if (empty($data)) return 'M0,15 L100,15';
        $min = min($data);
        $max = max($data);
        $range = $max - $min;
        if ($range == 0) return 'M0,15 L100,15';

        $count = count($data);
        $step = 100 / max(1, $count - 1);
        
        $path = '';
        $prevX = 0;
        $prevY = 0;

        foreach (array_values($data) as $i => $value) {
            $x = $i * $step;
            $y = 28 - ((($value - $min) / $range) * 24); 
            
            if ($i === 0) {
                $path .= 'M' . round($x, 1) . ',' . round($y, 1);
            } else {
                $cp1x = $prevX + ($step * 0.4);
                $cp2x = $x - ($step * 0.4);
                $path .= ' C' . round($cp1x, 1) . ',' . round($prevY, 1) . ' ' 
                         . round($cp2x, 1) . ',' . round($y, 1) . ' ' 
                         . round($x, 1) . ',' . round($y, 1);
            }
            
            $prevX = $x;
            $prevY = $y;
        }
        return $path;
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

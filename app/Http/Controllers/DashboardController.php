<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\PaymentHistory;
use App\Models\Notification;
use App\Services\HealthScoreService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(HealthScoreService $healthScoreService)
    {
        $user = Auth::user();
        $user->load('activeSubscriptions.category');

        $activeCount = $user->activeSubscriptions->count();
        $monthlyExpense = $user->monthlyExpense();
        $yearlyExpense = $user->yearlyExpense();
        $categoryCount = $user->activeSubscriptions->pluck('category_id')->unique()->count();

        // Upcoming payments (next 7 days)
        $upcoming = $user->activeSubscriptions
            ->filter(fn($s) => $s->days_until_payment >= 0 && $s->days_until_payment <= 7)
            ->sortBy('days_until_payment')
            ->take(5);

        // Monthly spending chart data (last 6 months)
        $chartLabels = [];
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartLabels[] = $month->translatedFormat('M Y');
            $chartData[] = PaymentHistory::where('user_id', $user->id)
                ->whereMonth('payment_date', $month->month)
                ->whereYear('payment_date', $month->year)
                ->sum('amount');
        }

        // Category distribution
        $categoryData = $user->activeSubscriptions->groupBy('category.name')->map(function ($items) {
            return $items->sum(fn($s) => $s->monthly_amount);
        });

        // Health score
        $healthScore = $healthScoreService->calculate($user);

        // Recent notifications
        $recentNotifications = Notification::where('user_id', $user->id)
            ->with('subscription')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'user',
            'activeCount',
            'monthlyExpense',
            'yearlyExpense',
            'categoryCount',
            'upcoming',
            'chartLabels',
            'chartData',
            'categoryData',
            'healthScore',
            'recentNotifications'
        ));
    }
}

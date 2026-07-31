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
    private function generateSparklinePath(array $data)
    {
        if (empty($data)) return 'M0,15 L100,15';
        $min = min($data);
        $max = max($data);
        $range = $max - $min;
        if ($range == 0) return 'M0,15 L100,15';

        $points = [];
        $count = count($data);
        $step = 100 / max(1, $count - 1);
        
        foreach ($data as $i => $value) {
            $x = $i * $step;
            $y = 25 - ((($value - $min) / $range) * 20);
            $points[] = ($i === 0 ? 'M' : 'L') . round($x) . ',' . round($y);
        }
        return implode(' ', $points);
    }

    public function index(HealthScoreService $healthScoreService)
    {
        $user = Auth::user();
        $user->load('activeSubscriptions.category');

        $activeCount = $user->activeSubscriptions->count();
        $monthlyExpense = $user->monthlyExpense();
        $yearlyExpense = $user->yearlyExpense();
        $categoryCount = $user->activeSubscriptions->pluck('category_id')->unique()->count();

        
        $upcoming = $user->activeSubscriptions
            ->filter(fn($s) => $s->days_until_payment >= 0 && $s->days_until_payment <= 7)
            ->sortBy('days_until_payment')
            ->take(5);

        
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

        
        $categoryData = $user->activeSubscriptions->groupBy('category.name')->map(function ($items) {
            return $items->sum(fn($s) => $s->monthly_amount);
        });

        
        $healthScore = $healthScoreService->calculate($user);

        
        $recentNotifications = Notification::where('user_id', $user->id)
            ->with('subscription')
            ->latest()
            ->take(5)
            ->get();

        $now = Carbon::now();
        $calendarEvents = [];
        foreach ($user->activeSubscriptions as $sub) {
            $day = $sub->payment_date;
            if ($sub->billing_cycle === 'monthly') {
                $lastDay = $now->copy()->endOfMonth()->day;
                $payDay = min($day, $lastDay);
                $calendarEvents[] = [
                    'title' => $sub->name,
                    'date' => $now->copy()->day($payDay)->format('Y-m-d'),
                    'color' => $sub->category->color ?? '#6366f1',
                ];
            } elseif ($sub->billing_cycle === 'yearly') {
                $yearlyDate = Carbon::createFromDate($now->year, 1, 1)->addDays($day - 1);
                if ($yearlyDate->month === $now->month) {
                    $calendarEvents[] = [
                        'title' => $sub->name,
                        'date' => $yearlyDate->format('Y-m-d'),
                        'color' => $sub->category->color ?? '#6366f1',
                    ];
                }
            } elseif ($sub->billing_cycle === 'weekly') {
                $startOfMonth = $now->copy()->startOfMonth();
                $endOfMonth = $now->copy()->endOfMonth();
                $current = $startOfMonth->copy();
                while ($current <= $endOfMonth) {
                    if ($current->dayOfWeek === ($day % 7)) {
                        $calendarEvents[] = [
                            'title' => $sub->name,
                            'date' => $current->format('Y-m-d'),
                            'color' => $sub->category->color ?? '#6366f1',
                        ];
                    }
                    $current->addDay();
                }
            }
        }

        // Generate dynamic sparklines based on real payment history trend
        $maxExpense = max($chartData) ?: 1;
        $activeSparkline = $this->generateSparklinePath(array_map(fn($v) => round(($v / $maxExpense) * $activeCount), $chartData));
        $monthlySparkline = $this->generateSparklinePath($chartData);
        $yearlySparkline = $this->generateSparklinePath(array_map(fn($v) => $v * 12, $chartData));
        $categorySparkline = $this->generateSparklinePath(array_map(fn($v) => round(($v / $maxExpense) * $categoryCount), $chartData));

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
            'recentNotifications',
            'calendarEvents',
            'activeSparkline',
            'monthlySparkline',
            'yearlySparkline',
            'categorySparkline'
        ));
    }
}

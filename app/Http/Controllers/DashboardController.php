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
        if ($range == 0) return 'M0,20 Q25,5 50,20 T100,20';

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

    public function index(HealthScoreService $healthScoreService, \App\Services\FinancialAssistantService $assistantService)
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

        
        $analysis = $assistantService->analyze($user);
        $healthScore = $healthScoreService->formatScore($analysis['health_score']);

        
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

        $activeSparkline = $this->generateSparklinePath([$activeCount * 0.6, $activeCount * 0.8, $activeCount * 0.5, $activeCount * 0.9, $activeCount * 0.7, $activeCount]);
        $monthlySparkline = $this->generateSparklinePath([$monthlyExpense * 0.5, $monthlyExpense * 0.7, $monthlyExpense * 0.4, $monthlyExpense * 0.8, $monthlyExpense * 0.6, $monthlyExpense]);
        $yearlySparkline = $this->generateSparklinePath([$yearlyExpense * 0.4, $yearlyExpense * 0.8, $yearlyExpense * 0.6, $yearlyExpense * 0.9, $yearlyExpense * 0.7, $yearlyExpense]);
        $categorySparkline = $this->generateSparklinePath([$categoryCount * 0.7, $categoryCount * 0.5, $categoryCount * 0.8, $categoryCount * 0.6, $categoryCount * 0.9, $categoryCount]);

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

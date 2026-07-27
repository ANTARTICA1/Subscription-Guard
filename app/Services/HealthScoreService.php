<?php

namespace App\Services;

use App\Models\User;
use App\Models\Subscription;
use App\Models\PaymentHistory;

class HealthScoreService
{
    public function calculate(User $user): array
    {
        $subscriptions = $user->activeSubscriptions()->with('category')->get();

        if ($subscriptions->isEmpty()) {
            return [
                'score' => 100,
                'label' => 'Sempurna',
                'color' => '#10b981',
                'recommendations' => ['Anda belum memiliki subscription aktif.'],
                'breakdown' => [],
            ];
        }

        $totalMonthly = $user->monthlyExpense();
        $subCount = $subscriptions->count();

        // Factor 1: Number of subscriptions (0-25 points)
        $countScore = 25;
        if ($subCount > 15) $countScore = 5;
        elseif ($subCount > 10) $countScore = 10;
        elseif ($subCount > 7) $countScore = 15;
        elseif ($subCount > 5) $countScore = 20;

        // Factor 2: Total monthly cost relative to reasonable budget (0-25 points)
        $costScore = 25;
        if ($totalMonthly > 2000000) $costScore = 5;
        elseif ($totalMonthly > 1500000) $costScore = 10;
        elseif ($totalMonthly > 1000000) $costScore = 15;
        elseif ($totalMonthly > 500000) $costScore = 20;

        // Factor 3: Spending increase trend (0-25 points)
        $trendScore = 25;
        $lastMonth = PaymentHistory::where('user_id', $user->id)
            ->where('payment_date', '>=', now()->subMonths(2)->startOfMonth())
            ->where('payment_date', '<', now()->subMonth()->startOfMonth())
            ->sum('amount');
        $thisMonth = PaymentHistory::where('user_id', $user->id)
            ->where('payment_date', '>=', now()->subMonth()->startOfMonth())
            ->sum('amount');

        if ($lastMonth > 0 && $thisMonth > $lastMonth) {
            $increase = (($thisMonth - $lastMonth) / $lastMonth) * 100;
            if ($increase > 50) $trendScore = 5;
            elseif ($increase > 30) $trendScore = 10;
            elseif ($increase > 15) $trendScore = 15;
            elseif ($increase > 5) $trendScore = 20;
        }

        // Factor 4: Expensive subscriptions ratio (0-25 points)
        $expensiveScore = 25;
        $expensive = $subscriptions->filter(fn($s) => $s->monthly_amount > 100000)->count();
        $ratio = $subCount > 0 ? ($expensive / $subCount) * 100 : 0;
        if ($ratio > 75) $expensiveScore = 5;
        elseif ($ratio > 50) $expensiveScore = 10;
        elseif ($ratio > 35) $expensiveScore = 15;
        elseif ($ratio > 20) $expensiveScore = 20;

        $totalScore = $countScore + $costScore + $trendScore + $expensiveScore;

        // Generate recommendations
        $recommendations = [];
        if ($subCount > 7) {
            $recommendations[] = "Anda memiliki {$subCount} subscription aktif. Pertimbangkan untuk mengevaluasi mana yang masih benar-benar diperlukan.";
        }
        if ($totalMonthly > 500000) {
            $formatted = 'Rp' . number_format($totalMonthly, 0, ',', '.');
            $recommendations[] = "Total pengeluaran bulanan Anda {$formatted}. Cari alternatif lebih hemat untuk layanan yang jarang digunakan.";
        }

        $expensiveSubs = $subscriptions->filter(fn($s) => $s->monthly_amount > 100000)
            ->sortByDesc('monthly_amount')
            ->take(3);
        foreach ($expensiveSubs as $sub) {
            $recommendations[] = "{$sub->name} memiliki biaya " . $sub->formatted_amount . "/{$sub->billing_cycle}. Evaluasi apakah layanan ini masih sering digunakan.";
        }

        $autoRenewCount = $subscriptions->where('auto_renew', true)->count();
        if ($autoRenewCount > 3) {
            $recommendations[] = "{$autoRenewCount} subscription memiliki auto-renewal aktif. Pastikan semua masih dibutuhkan.";
        }

        if (empty($recommendations)) {
            $recommendations[] = 'Pengelolaan subscription Anda sudah baik! Tetap pantau secara berkala.';
        }

        $label = match (true) {
            $totalScore >= 90 => 'Sempurna',
            $totalScore >= 75 => 'Baik',
            $totalScore >= 50 => 'Perlu Perhatian',
            $totalScore >= 25 => 'Kurang Baik',
            default => 'Kritis',
        };

        $color = match (true) {
            $totalScore >= 90 => '#10b981',
            $totalScore >= 75 => '#3b82f6',
            $totalScore >= 50 => '#f59e0b',
            $totalScore >= 25 => '#f97316',
            default => '#ef4444',
        };

        return [
            'score' => $totalScore,
            'label' => $label,
            'color' => $color,
            'recommendations' => $recommendations,
            'breakdown' => [
                ['name' => 'Jumlah Subscription', 'score' => $countScore, 'max' => 25],
                ['name' => 'Total Biaya', 'score' => $costScore, 'max' => 25],
                ['name' => 'Tren Pengeluaran', 'score' => $trendScore, 'max' => 25],
                ['name' => 'Rasio Biaya Tinggi', 'score' => $expensiveScore, 'max' => 25],
            ],
        ];
    }
}

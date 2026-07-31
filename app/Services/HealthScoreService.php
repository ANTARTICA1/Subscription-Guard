<?php

namespace App\Services;

use App\Models\User;

class HealthScoreService
{
    public function calculate(User $user): array
    {
        $unified = $this->calculateUnifiedScore($user, 0);
        $score = $unified['score'];
        
        $label = match (true) {
            $score >= 90 => 'Sempurna',
            $score >= 75 => 'Baik',
            $score >= 50 => 'Perlu Perhatian',
            $score >= 25 => 'Kurang Baik',
            default => 'Kritis',
        };

        $color = match (true) {
            $score >= 90 => '#10b981',
            $score >= 75 => '#3b82f6',
            $score >= 50 => '#f59e0b',
            $score >= 25 => '#f97316',
            default => '#ef4444',
        };

        return [
            'score' => $score,
            'label' => $label,
            'color' => $color,
            'recommendations' => [
                'Buka halaman Tata Asisten untuk melihat detail breakdown skor Anda.'
            ]
        ];
    }

    public function calculateUnifiedScore(User $user, float $potentialSavings): array
    {
        $subs = $user->activeSubscriptions()->with('category')->get();
        $totalMonthly = $user->monthlyExpense();
        $subCount = $subs->count();

        if ($subCount === 0 || $totalMonthly == 0) {
            return [
                'score' => 0,
                'breakdown' => [
                    ['name' => 'Data Tidak Tersedia', 'score' => 0, 'max' => 0, 'desc' => 'Belum ada langganan untuk dianalisis.']
                ]
            ];
        }

        $wasteRatio = $totalMonthly > 0 ? ($potentialSavings / $totalMonthly) : 0;
        $wasteScore = 40 - ($wasteRatio * 40); 
        $wasteScore = max(0, min(40, $wasteScore));

        $categoryGroups = $subs->groupBy('category_id');
        $maxCategoryConcentration = 0;
        foreach ($categoryGroups as $items) {
            $catTotal = $items->sum('monthly_amount');
            $ratio = $catTotal / $totalMonthly;
            if ($ratio > $maxCategoryConcentration) $maxCategoryConcentration = $ratio;
        }
        
        $concentrationScore = 25;
        if ($maxCategoryConcentration > 0.5) {
            $concentrationScore -= (($maxCategoryConcentration - 0.5) * 50); 
        }
        $concentrationScore = max(0, min(25, $concentrationScore));

        $countScore = 20;
        if ($subCount > 7) {
            $countScore -= ($subCount - 7) * 2;
        }
        $countScore = max(0, min(20, $countScore));

        $yearlyCount = $subs->where('billing_cycle', 'yearly')->count();
        $yearlyRatio = $yearlyCount / $subCount;
        $yearlyScore = $yearlyRatio * 15;
        $yearlyScore = max(0, min(15, $yearlyScore));

        $totalScore = (int) round($wasteScore + $concentrationScore + $countScore + $yearlyScore);

        return [
            'score' => $totalScore,
            'breakdown' => [
                [
                    'name' => 'Efisiensi Tagihan', 
                    'score' => (int) round($wasteScore), 
                    'max' => 40,
                    'desc' => $wasteScore < 30 ? 'Terdapat banyak indikasi pemborosan.' : 'Sangat efisien tanpa kebocoran.'
                ],
                [
                    'name' => 'Diversifikasi Kategori', 
                    'score' => (int) round($concentrationScore), 
                    'max' => 25,
                    'desc' => $concentrationScore < 20 ? 'Pengeluaran terlalu menumpuk di 1 kategori.' : 'Alokasi dana tersebar dengan sehat.'
                ],
                [
                    'name' => 'Beban Kuantitas', 
                    'score' => (int) round($countScore), 
                    'max' => 20,
                    'desc' => $countScore < 15 ? 'Terlalu banyak layanan aktif (Fatigue).' : 'Jumlah langganan terkendali.'
                ],
                [
                    'name' => 'Perencanaan Jangka Panjang', 
                    'score' => (int) round($yearlyScore), 
                    'max' => 15,
                    'desc' => $yearlyScore < 5 ? 'Mayoritas siklus bulanan (kurang hemat).' : 'Optimalisasi diskon tahunan.'
                ],
            ]
        ];
    }
}

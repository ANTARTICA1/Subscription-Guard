<?php

namespace App\Services;

use App\Models\User;

class HealthScoreService
{
    public function calculate(User $user): array
    {
        $unified = $this->calculateUnifiedScore($user, 0);
        return $this->formatScore($unified['score']);
    }

    public function formatScore(int $score): array
    {
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

    public function calculateUnifiedScore(User $user, float $potentialSavings, array $context = []): array
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

        $redundancyCount = $context['redundancy_count'] ?? 0;
        $hasCashflowRisk = $context['has_cashflow_risk'] ?? false;

        $wasteRatio = $totalMonthly > 0 ? ($potentialSavings / $totalMonthly) : 0;
        $wasteScore = 30 - ($wasteRatio * 30); 
        $wasteScore = max(0, min(30, $wasteScore));

        $redundancyScore = 15;
        if ($redundancyCount > 0) {
            $redundancyScore -= ($redundancyCount * 5);
        }
        $redundancyScore = max(0, min(15, $redundancyScore));

        $cashflowScore = $hasCashflowRisk ? 5 : 15;

        $categoryGroups = $subs->groupBy('category_id');
        $maxCategoryConcentration = 0;
        foreach ($categoryGroups as $items) {
            $catTotal = $items->sum('monthly_amount');
            $ratio = $catTotal / $totalMonthly;
            if ($ratio > $maxCategoryConcentration) $maxCategoryConcentration = $ratio;
        }
        $concentrationScore = 10;
        if ($maxCategoryConcentration > 0.5) {
            $concentrationScore -= (($maxCategoryConcentration - 0.5) * 20); 
        }
        $concentrationScore = max(0, min(10, $concentrationScore));

        $countScore = 15;
        if ($subCount > 7) {
            $countScore -= ($subCount - 7) * 2;
        }
        $countScore = max(0, min(15, $countScore));

        $yearlyCount = $subs->where('billing_cycle', 'yearly')->count();
        $yearlyRatio = $yearlyCount / $subCount;
        $yearlyScore = $yearlyRatio * 15;
        $yearlyScore = max(0, min(15, $yearlyScore));

        $totalScore = (int) round($wasteScore + $redundancyScore + $cashflowScore + $concentrationScore + $countScore + $yearlyScore);

        return [
            'score' => $totalScore,
            'breakdown' => [
                [
                    'name' => 'Efisiensi Tagihan', 
                    'score' => (int) round($wasteScore), 
                    'max' => 30,
                    'desc' => $wasteScore < 20 ? 'Terdapat indikasi pemborosan.' : 'Sangat efisien tanpa kebocoran.'
                ],
                [
                    'name' => 'Redundansi Layanan', 
                    'score' => (int) round($redundancyScore), 
                    'max' => 15,
                    'desc' => $redundancyScore < 15 ? 'Terdeteksi layanan langganan tumpang tindih.' : 'Tidak ada duplikasi layanan.'
                ],
                [
                    'name' => 'Distribusi Arus Kas', 
                    'score' => (int) round($cashflowScore), 
                    'max' => 15,
                    'desc' => $cashflowScore < 15 ? 'Jadwal penagihan menumpuk berdekatan (risiko tinggi).' : 'Arus kas sehat, jadwal tersebar.'
                ],
                [
                    'name' => 'Konsentrasi Kategori', 
                    'score' => (int) round($concentrationScore), 
                    'max' => 10,
                    'desc' => $concentrationScore < 7 ? 'Pengeluaran terlalu menumpuk di 1 kategori.' : 'Alokasi dana tersebar dengan baik.'
                ],
                [
                    'name' => 'Beban Kuantitas', 
                    'score' => (int) round($countScore), 
                    'max' => 15,
                    'desc' => $countScore < 10 ? 'Terlalu banyak layanan aktif (Fatigue).' : 'Jumlah langganan terkendali.'
                ],
                [
                    'name' => 'Perencanaan Jangka Panjang', 
                    'score' => (int) round($yearlyScore), 
                    'max' => 15,
                    'desc' => $yearlyScore < 5 ? 'Sebagian besar siklus bulanan (kurang hemat).' : 'Optimalisasi diskon tahunan yang baik.'
                ],
            ]
        ];
    }
}

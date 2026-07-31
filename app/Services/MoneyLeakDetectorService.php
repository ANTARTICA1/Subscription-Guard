<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class MoneyLeakDetectorService
{
    public function detect(User $user, bool $calculateScore = true): array
    {
        $subs = $user->activeSubscriptions()->with('category')->get();
        $leaks = [];
        $totalPotentialSavings = 0;
        $monthlyExpense = $user->monthlyExpense();

        $byCategory = $subs->groupBy('category_id');
        foreach ($byCategory as $categoryId => $categorySubs) {
            if ($categorySubs->count() > 1) {
                $categoryName = $categorySubs->first()->category->name ?? 'Kategori Sama';
                $names = $categorySubs->pluck('name')->join(' + ');
                
                $cheapest = $categorySubs->sortBy('monthly_amount')->first();
                $savings = $categorySubs->sum(fn($s) => $s->monthly_amount) - $cheapest->monthly_amount;
                
                $totalPotentialSavings += $savings;

                $leaks[] = [
                    'type' => 'overlapping',
                    'icon' => 'layers',
                    'title' => 'Tumpang Tindih Kategori: ' . $categoryName,
                    'description' => "Terdeteksi langganan ganda dengan utilitas serupa: <b>{$names}</b>.",
                    'recommendation' => "Konsolidasi ke satu layanan (rekomendasi: <b>{$cheapest->name}</b>) untuk memotong pemborosan.",
                    'potential_savings' => $savings,
                    'severity' => $savings > 100000 ? 'high' : 'medium'
                ];
            }
        }

        $vampireSubs = $subs->filter(fn($s) => $s->monthly_amount > 0 && $s->monthly_amount <= 35000);
        if ($vampireSubs->count() > 0) {
            $totalVampire = $vampireSubs->sum(fn($s) => $s->monthly_amount);
            $fiveYearCost = $totalVampire * 12 * 5;
            $names = $vampireSubs->pluck('name')->join(', ');

            $leaks[] = [
                'type' => 'vampire',
                'icon' => 'droplet',
                'title' => 'Vampire Spend Terdeteksi',
                'description' => "Pengeluaran mikro (<b>{$names}</b>) tampak kecil (Total Rp" . number_format($totalVampire, 0, ',', '.') . "/bln), namun akan menguras <b>Rp" . number_format($fiveYearCost, 0, ',', '.') . "</b> dalam 5 tahun.",
                'recommendation' => "Evaluasi ketat apakah layanan mikro ini memberikan ROI yang sepadan dengan biaya jangka panjangnya.",
                'potential_savings' => $totalVampire,
                'severity' => 'medium'
            ];
        }

        $monthlyPremiumSubs = $subs->filter(fn($s) => $s->billing_cycle === 'monthly' && $s->amount >= 60000);
        foreach ($monthlyPremiumSubs as $sub) {
            $yearlySavings = ($sub->amount * 12) * 0.15; 
            $totalPotentialSavings += ($yearlySavings / 12); 

            $leaks[] = [
                'type' => 'cycle',
                'icon' => 'refresh-cw',
                'title' => "Peluang Optimasi Tagihan: {$sub->name}",
                'description' => "Anda membayar <b>{$sub->name}</b> secara bulanan (Rp" . number_format($sub->amount, 0, ',', '.') . "/bln). Beralih ke paket tahunan secara historis dapat menghemat 15-20%.",
                'recommendation' => "Ubah siklus tagihan ke tahunan untuk menghemat sekitar <b>Rp" . number_format($yearlySavings, 0, ',', '.') . "</b> per tahun.",
                'potential_savings' => round($yearlySavings / 12),
                'severity' => 'low'
            ];
        }

        $now = Carbon::now();
        $suspiciousSubs = $subs->filter(function($s) use ($now) {
            return $s->auto_renew && $s->created_at && $s->created_at->diffInDays($now) > 180;
        });

        if ($suspiciousSubs->count() > 0) {
            $names = $suspiciousSubs->pluck('name')->join(', ');
            $leaks[] = [
                'type' => 'zombie',
                'icon' => 'ghost',
                'title' => 'Indikasi Langganan Pasif (Zombie)',
                'description' => "Layanan <b>{$names}</b> berstatus auto-renew dan sudah aktif lebih dari 6 bulan.",
                'recommendation' => "Verifikasi apakah Anda masih aktif menggunakan layanan ini. Jika tidak, batalkan untuk mencegah aliran dana pasif.",
                'potential_savings' => 0,
                'severity' => 'medium'
            ];
        }

        $efficiencyScore = 100;
        if ($calculateScore && $monthlyExpense > 0) {
            $wasteRatio = $totalPotentialSavings / $monthlyExpense;
            $efficiencyScore = max(10, min(100, 100 - ($wasteRatio * 100)));
        }

        return [
            'leaks' => collect($leaks)->sortByDesc('potential_savings')->values()->toArray(),
            'total_potential_savings' => $totalPotentialSavings,
            'efficiency_score' => (int) $efficiencyScore
        ];
    }
}

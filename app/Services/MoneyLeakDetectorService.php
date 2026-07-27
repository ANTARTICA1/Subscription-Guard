<?php

namespace App\Services;

use App\Models\User;

class MoneyLeakDetectorService
{
    public function detect(User $user): array
    {
        $subscriptions = $user->activeSubscriptions()->with('category', 'paymentHistories')->get();
        $leaks = [];
        $totalMonthlyLeak = 0;

        foreach ($subscriptions as $sub) {
            // 1. Auto-Renewal Trap Alert
            if ($sub->auto_renew && $sub->monthly_amount >= 100000) {
                $leaks[] = [
                    'severity' => 'high',
                    'icon' => '🚨',
                    'subscription' => $sub->name,
                    'title' => 'Auto-Renewal Risiko Tinggi',
                    'description' => "{$sub->name} bernilai {$sub->formatted_amount}/{$sub->billing_cycle} akan terpotong otomatis tanpa konfirmasi.",
                    'amount' => $sub->monthly_amount,
                    'action' => 'Evaluasi matikan auto-renewal atau jadwalkan pembatalan sebelum tanggal ' . $sub->next_payment_date->format('d M Y'),
                ];
                $totalMonthlyLeak += $sub->monthly_amount * 0.5; // Estimated partial leak
            }

            // 2. High Cost Dormant Alert (No payments recorded recently)
            $lastPayment = $sub->paymentHistories()->latest('payment_date')->first();
            if (!$lastPayment && $sub->monthly_amount > 50000) {
                $leaks[] = [
                    'severity' => 'medium',
                    'icon' => '⚠️',
                    'subscription' => $sub->name,
                    'title' => 'Tanpa Catatan Penggunaan (Dormant)',
                    'description' => "Layanan {$sub->name} belum pernah dicatat penggunaannya di riwayat pembayaran.",
                    'amount' => $sub->monthly_amount,
                    'action' => 'Pastikan Anda masih aktif memakai layanan ini, atau catat pembayaran pertamanya.',
                ];
                $totalMonthlyLeak += $sub->monthly_amount * 0.3;
            }
        }

        // 3. Category Overlap Leaks (e.g. multiple streaming or music subs)
        $categoryGroups = $subscriptions->groupBy('category_id');
        foreach ($categoryGroups as $catId => $group) {
            if ($group->count() > 1) {
                $categoryName = $group->first()->category->name ?? 'Kategori';
                $names = $group->pluck('name')->join(', ');
                $cheapest = $group->sortBy('monthly_amount')->first();
                $extraCost = $group->sum('monthly_amount') - $cheapest->monthly_amount;

                $leaks[] = [
                    'severity' => 'high',
                    'icon' => '💸',
                    'subscription' => $names,
                    'title' => "Tumpang Tindih Kategori {$categoryName}",
                    'description' => "Anda berlangganan {$group->count()} layanan di kategori {$categoryName} sekaligus ({$names}).",
                    'amount' => $extraCost,
                    'action' => "Pertimbangkan untuk menyisakan 1 layanan terbaik dan hemat Rp" . number_format($extraCost, 0, ',', '.') . "/bulan.",
                ];
                $totalMonthlyLeak += $extraCost;
            }
        }

        return [
            'leaks' => $leaks,
            'total_monthly_leak' => round($totalMonthlyLeak),
            'total_yearly_leak' => round($totalMonthlyLeak * 12),
            'leak_count' => count($leaks),
            'health_grade' => count($leaks) === 0 ? 'A+' : (count($leaks) <= 2 ? 'B' : 'D'),
        ];
    }
}

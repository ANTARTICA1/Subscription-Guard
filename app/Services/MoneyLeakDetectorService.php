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
            
            if ($sub->auto_renew && $sub->monthly_amount >= 100000) {
                $leaks[] = [
                    'severity' => 'high',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>',
                    'subscription' => $sub->name,
                    'title' => 'Auto-Renewal Risiko Tinggi',
                    'description' => "{$sub->name} bernilai {$sub->formatted_amount}/{$sub->billing_cycle} akan terpotong otomatis tanpa konfirmasi.",
                    'amount' => $sub->monthly_amount,
                    'action' => 'Evaluasi matikan auto-renewal atau jadwalkan pembatalan sebelum tanggal ' . $sub->next_payment_date->format('d M Y'),
                ];
                $totalMonthlyLeak += $sub->monthly_amount * 0.5; 
            }

            
            $lastPayment = $sub->paymentHistories()->latest('payment_date')->first();
            if (!$lastPayment && $sub->monthly_amount > 50000) {
                $leaks[] = [
                    'severity' => 'medium',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>',
                    'subscription' => $sub->name,
                    'title' => 'Tanpa Catatan Penggunaan (Dormant)',
                    'description' => "Layanan {$sub->name} belum pernah dicatat penggunaannya di riwayat pembayaran.",
                    'amount' => $sub->monthly_amount,
                    'action' => 'Pastikan Anda masih aktif memakai layanan ini, atau catat pembayaran pertamanya.',
                ];
                $totalMonthlyLeak += $sub->monthly_amount * 0.3;
            }
        }

        
        $categoryGroups = $subscriptions->groupBy('category_id');
        foreach ($categoryGroups as $catId => $group) {
            if ($group->count() > 1) {
                $categoryName = $group->first()->category->name ?? 'Kategori';
                $names = $group->pluck('name')->join(', ');
                $cheapest = $group->sortBy('monthly_amount')->first();
                $extraCost = $group->sum('monthly_amount') - $cheapest->monthly_amount;

                $leaks[] = [
                    'severity' => 'high',
                    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>',
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

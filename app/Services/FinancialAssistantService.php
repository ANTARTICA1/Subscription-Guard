<?php

namespace App\Services;

use App\Models\User;

class FinancialAssistantService
{
    



    public function analyze(User $user): array
    {
        $subscriptions = $user->activeSubscriptions()->with('category')->get();
        $totalMonthly = $user->monthlyExpense();
        $totalYearly = $user->yearlyExpense();
        $subCount = $subscriptions->count();

        if ($subCount === 0) {
            return [
                'summary' => 'Anda belum memiliki subscription aktif.',
                'total_monthly' => 0,
                'total_yearly' => 0,
                'potential_savings' => 0,
                'insights' => [],
                'recommendations' => ['Mulai catat subscription Anda untuk mendapatkan analisis keuangan.'],
                'category_breakdown' => [],
            ];
        }

        
        $categoryBreakdown = $subscriptions->groupBy('category.name')->map(function ($items, $category) {
            $total = $items->sum(fn($s) => $s->monthly_amount);
            return [
                'category' => $category,
                'count' => $items->count(),
                'monthly_total' => $total,
                'formatted_total' => 'Rp' . number_format($total, 0, ',', '.'),
                'items' => $items->pluck('name')->toArray(),
            ];
        })->sortByDesc('monthly_total')->values()->toArray();

        
        $insights = [];

        
        if (!empty($categoryBreakdown)) {
            $topCategory = $categoryBreakdown[0];
            $percentage = $totalMonthly > 0 ? round(($topCategory['monthly_total'] / $totalMonthly) * 100) : 0;
            $insights[] = [
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>',
                'title' => 'Kategori Terbesar',
                'description' => "{$topCategory['category']} menghabiskan {$topCategory['formatted_total']}/bulan ({$percentage}% dari total).",
            ];
        }

        
        $mostExpensive = $subscriptions->sortByDesc('monthly_amount')->first();
        if ($mostExpensive) {
            $insights[] = [
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>',
                'title' => 'Subscription Termahal',
                'description' => "{$mostExpensive->name} dengan biaya {$mostExpensive->formatted_amount}/{$mostExpensive->billing_cycle}.",
            ];
        }

        
        $autoRenewSubs = $subscriptions->where('auto_renew', true);
        $autoRenewTotal = $autoRenewSubs->sum(fn($s) => $s->monthly_amount);
        if ($autoRenewSubs->count() > 0) {
            $insights[] = [
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>',
                'title' => 'Auto-Renewal Aktif',
                'description' => "{$autoRenewSubs->count()} subscription dengan auto-renewal. Total Rp" . number_format($autoRenewTotal, 0, ',', '.') . '/bulan akan terpotong otomatis.',
            ];
        }

        
        $insights[] = [
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>',
            'title' => 'Proyeksi Tahunan',
            'description' => 'Estimasi pengeluaran subscription tahun ini: Rp' . number_format($totalYearly, 0, ',', '.') . '.',
        ];

        
        $recommendations = [];
        $potentialSavings = 0;

        
        $duplicateCategories = $subscriptions->groupBy('category_id')->filter(fn($items) => $items->count() > 1);
        foreach ($duplicateCategories as $items) {
            $names = $items->pluck('name')->join(', ');
            $cheapest = $items->sortBy('monthly_amount')->first();
            $savings = $items->sum(fn($s) => $s->monthly_amount) - $cheapest->monthly_amount;
            if ($savings > 0) {
                $potentialSavings += $savings;
                $recommendations[] = "Anda memiliki beberapa subscription di kategori yang sama ({$names}). Pertimbangkan untuk memilih salah satu dan hemat Rp" . number_format($savings, 0, ',', '.') . '/bulan.';
            }
        }

        
        $expensiveSubs = $subscriptions->filter(fn($s) => $s->monthly_amount > 150000)->sortByDesc('monthly_amount');
        foreach ($expensiveSubs->take(2) as $sub) {
            $recommendations[] = "{$sub->name} ({$sub->formatted_amount}/{$sub->billing_cycle}) termasuk subscription premium. Evaluasi apakah fitur premium benar-benar diperlukan atau bisa downgrade ke paket lebih murah.";
            $potentialSavings += $sub->monthly_amount * 0.3; 
        }

        
        if ($totalMonthly > 1000000) {
            $recommendations[] = 'Total pengeluaran subscription Anda melebihi Rp1.000.000/bulan. Ini setara dengan ' . round($totalYearly / 1000000, 1) . ' juta/tahun. Pertimbangkan untuk mengurangi subscription yang jarang digunakan.';
        }

        
        $monthlySubs = $subscriptions->where('billing_cycle', 'monthly');
        $yearlySavings = 0;
        foreach ($monthlySubs as $sub) {
            $yearlyEstimate = $sub->amount * 12 * 0.15; 
            $yearlySavings += $yearlyEstimate;
        }
        if ($yearlySavings > 50000) {
            $recommendations[] = 'Beralih ke paket tahunan untuk beberapa subscription bisa menghemat hingga Rp' . number_format($yearlySavings, 0, ',', '.') . '/tahun (estimasi diskon 15%).';
            $potentialSavings += $yearlySavings / 12;
        }

        if (empty($recommendations)) {
            $recommendations[] = 'Pengelolaan subscription Anda sudah baik! Tetap pantau secara berkala.';
        }

        return [
            'summary' => "Anda memiliki {$subCount} subscription aktif dengan total Rp" . number_format($totalMonthly, 0, ',', '.') . '/bulan.',
            'total_monthly' => $totalMonthly,
            'total_yearly' => $totalYearly,
            'potential_savings' => round($potentialSavings),
            'insights' => $insights,
            'recommendations' => $recommendations,
            'category_breakdown' => $categoryBreakdown,
        ];
    }
}

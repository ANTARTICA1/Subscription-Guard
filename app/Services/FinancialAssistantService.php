<?php

namespace App\Services;

use App\Models\User;

class FinancialAssistantService
{
    /**
     * Rule-based "AI" financial assistant that analyzes subscription data
     * and provides personalized recommendations without external API calls.
     */
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

        // Category analysis
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

        // Generate insights
        $insights = [];

        // Insight 1: Most expensive category
        if (!empty($categoryBreakdown)) {
            $topCategory = $categoryBreakdown[0];
            $percentage = $totalMonthly > 0 ? round(($topCategory['monthly_total'] / $totalMonthly) * 100) : 0;
            $insights[] = [
                'icon' => '📊',
                'title' => 'Kategori Terbesar',
                'description' => "{$topCategory['category']} menghabiskan {$topCategory['formatted_total']}/bulan ({$percentage}% dari total).",
            ];
        }

        // Insight 2: Most expensive subscription
        $mostExpensive = $subscriptions->sortByDesc('monthly_amount')->first();
        if ($mostExpensive) {
            $insights[] = [
                'icon' => '💎',
                'title' => 'Subscription Termahal',
                'description' => "{$mostExpensive->name} dengan biaya {$mostExpensive->formatted_amount}/{$mostExpensive->billing_cycle}.",
            ];
        }

        // Insight 3: Auto-renew analysis
        $autoRenewSubs = $subscriptions->where('auto_renew', true);
        $autoRenewTotal = $autoRenewSubs->sum(fn($s) => $s->monthly_amount);
        if ($autoRenewSubs->count() > 0) {
            $insights[] = [
                'icon' => '🔄',
                'title' => 'Auto-Renewal Aktif',
                'description' => "{$autoRenewSubs->count()} subscription dengan auto-renewal. Total Rp" . number_format($autoRenewTotal, 0, ',', '.') . '/bulan akan terpotong otomatis.',
            ];
        }

        // Insight 4: Yearly projection
        $insights[] = [
            'icon' => '📅',
            'title' => 'Proyeksi Tahunan',
            'description' => 'Estimasi pengeluaran subscription tahun ini: Rp' . number_format($totalYearly, 0, ',', '.') . '.',
        ];

        // Generate recommendations
        $recommendations = [];
        $potentialSavings = 0;

        // Check for duplicate categories
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

        // Check expensive subscriptions
        $expensiveSubs = $subscriptions->filter(fn($s) => $s->monthly_amount > 150000)->sortByDesc('monthly_amount');
        foreach ($expensiveSubs->take(2) as $sub) {
            $recommendations[] = "{$sub->name} ({$sub->formatted_amount}/{$sub->billing_cycle}) termasuk subscription premium. Evaluasi apakah fitur premium benar-benar diperlukan atau bisa downgrade ke paket lebih murah.";
            $potentialSavings += $sub->monthly_amount * 0.3; // Assume 30% potential saving
        }

        // Check total spending threshold
        if ($totalMonthly > 1000000) {
            $recommendations[] = 'Total pengeluaran subscription Anda melebihi Rp1.000.000/bulan. Ini setara dengan ' . round($totalYearly / 1000000, 1) . ' juta/tahun. Pertimbangkan untuk mengurangi subscription yang jarang digunakan.';
        }

        // Billing cycle optimization
        $monthlySubs = $subscriptions->where('billing_cycle', 'monthly');
        $yearlySavings = 0;
        foreach ($monthlySubs as $sub) {
            $yearlyEstimate = $sub->amount * 12 * 0.15; // Assume 15% discount for yearly
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

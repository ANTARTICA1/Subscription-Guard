<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;

class FinancialAssistantService
{
    private HealthScoreService $healthScoreService;

    public function __construct(HealthScoreService $healthScoreService)
    {
        $this->healthScoreService = $healthScoreService;
    }

    public function analyze(User $user): array
    {
        $subscriptions = $user->activeSubscriptions()->with('category')->get();
        $totalMonthly = $user->monthlyExpense();
        $totalYearly = $user->yearlyExpense();
        $subCount = $subscriptions->count();

        if ($subCount === 0) {
            return [
                'summary' => 'Anda belum memiliki subscription aktif. Data tidak cukup untuk dianalisis.',
                'total_monthly' => 0,
                'total_yearly' => 0,
                'health_score' => 0,
                'health_data' => $this->healthScoreService->calculateUnifiedScore($user, 0),
                'personality' => 'Belum Ada Data',
                'potential_savings' => 0,
                'insights' => [],
                'recommendations' => ['Mulai catat subscription Anda untuk mendapatkan analisis keuangan intelijen.'],
                'category_breakdown' => [],
            ];
        }

        $healthData = $this->healthScoreService->calculateUnifiedScore($user, 0);
        $healthScore = $healthData['score'];

        $categoryGroups = $subscriptions->groupBy('category_id');
        $maxCategoryConcentration = 0;
        
        $categoryBreakdown = $subscriptions->groupBy('category.name')->map(function ($items, $category) use (&$maxCategoryConcentration, $totalMonthly) {
            $total = $items->sum(fn($s) => $s->monthly_amount);
            $ratio = $totalMonthly > 0 ? ($total / $totalMonthly) : 0;
            if ($ratio > $maxCategoryConcentration) $maxCategoryConcentration = $ratio;
            return [
                'category' => $category ?: 'Lainnya',
                'count' => $items->count(),
                'monthly_total' => $total,
                'formatted_total' => 'Rp' . number_format($total, 0, ',', '.'),
                'items' => $items->pluck('name')->toArray(),
                'percentage' => round($ratio * 100)
            ];
        })->sortByDesc('monthly_total')->values()->toArray();

        $personality = 'Balanced Subscriber';
        $topCategoryName = !empty($categoryBreakdown) ? $categoryBreakdown[0]['category'] : '';
        if ($maxCategoryConcentration > 0.5) {
            if (stripos($topCategoryName, 'Entertainment') !== false || stripos($topCategoryName, 'Streaming') !== false) {
                $personality = 'Entertainment Junkie';
            } elseif (stripos($topCategoryName, 'Software') !== false || stripos($topCategoryName, 'Productivity') !== false) {
                $personality = 'Productivity Hacker';
            } elseif (stripos($topCategoryName, 'Gaming') !== false) {
                $personality = 'Hardcore Gamer';
            }
        } elseif ($subCount > 10) {
            $personality = 'Subscription Collector';
        } elseif ($subCount <= 2 && $totalMonthly > 0) {
            $personality = 'Minimalist';
        }

        
        $insights = [];

        $fiveYearProjection = $totalYearly * 5;
        $insights[] = [
            'icon' => 'trending-up',
            'title' => 'Proyeksi 5 Tahun (Trajectory)',
            'description' => "Jika Anda mempertahankan pola saat ini, Anda akan menghabiskan <b>Rp " . number_format($fiveYearProjection, 0, ',', '.') . "</b> dalam 5 tahun ke depan hanya untuk langganan.",
        ];

        if (!empty($categoryBreakdown)) {
            $topCat = $categoryBreakdown[0];
            $insights[] = [
                'icon' => 'pie-chart',
                'title' => 'Konsentrasi Ekstrim',
                'description' => "<b>{$topCat['percentage']}%</b> dari pengeluaran Anda tersedot ke kategori {$topCat['category']}. Ini indikator kuat untuk melakukan pemangkasan.",
            ];
        }

        $mostExpensive = $subscriptions->sortByDesc('monthly_amount')->first();
        if ($mostExpensive && $mostExpensive->monthly_amount > ($totalMonthly * 0.3)) {
            $insights[] = [
                'icon' => 'alert-triangle',
                'title' => 'Beban Mayoritas',
                'description' => "<b>{$mostExpensive->name}</b> memakan porsi sangat besar (" . round(($mostExpensive->monthly_amount/$totalMonthly)*100) . "% dari total). Pertimbangkan untuk downgrade atau patungan.",
            ];
        }

        $recommendations = [];
        $potentialSavings = 0;

        $musicSubs = $subscriptions->filter(fn($s) => stripos($s->name, 'Music') !== false || stripos($s->name, 'Spotify') !== false);
        $cloudSubs = $subscriptions->filter(fn($s) => stripos($s->name, 'iCloud') !== false || stripos($s->name, 'Google One') !== false);
        $tvSubs = $subscriptions->filter(fn($s) => stripos($s->name, 'Apple TV') !== false || stripos($s->name, 'Netflix') !== false);

        if ($musicSubs->count() > 0 && $cloudSubs->count() > 0 && $tvSubs->count() > 0) {
            $recommendations[] = "Terdeteksi pola langganan terpisah (Musik + Cloud + TV). Ekosistem Bundle seperti <b>Apple One</b> atau <b>Google One Premium</b> dapat memangkas tagihan Anda secara radikal.";
            $potentialSavings += 50000;
        }

        $expensiveSubs = $subscriptions->filter(fn($s) => $s->monthly_amount > 150000)->sortByDesc('monthly_amount');
        if ($expensiveSubs->count() > 0) {
            $recommendations[] = "Beberapa langganan Anda (seperti {$expensiveSubs->first()->name}) berada di tier Premium. Pastikan tingkat utilitas (penggunaan) Anda harian. Jika jarang dipakai, segera batalkan.";
            $potentialSavings += $expensiveSubs->first()->monthly_amount * 0.3; 
        }

        $monthlySubs = $subscriptions->where('billing_cycle', 'monthly');
        $yearlySavings = 0;
        foreach ($monthlySubs as $sub) {
            $yearlyEstimate = $sub->amount * 12 * 0.15; 
            $yearlySavings += $yearlyEstimate;
        }
        if ($yearlySavings > 50000) {
            $recommendations[] = "Sistem menemukan potensi penghematan <b>Rp" . number_format($yearlySavings, 0, ',', '.') . "/tahun</b> dengan beralih ke siklus pembayaran tahunan (asumsi diskon 15%).";
            $potentialSavings += $yearlySavings / 12;
        }

        if ($totalMonthly > 500000) {
            $insights[] = [
                'icon' => 'alert-triangle',
                'title' => 'Inflasi Gaya Hidup',
                'description' => "Beban langganan mencapai <b>Rp " . number_format($totalMonthly, 0, ',', '.') . "</b>/bulan. Angka ini cukup tinggi, awasi agar tidak mengganggu rasio tabungan (saving rate) Anda.",
            ];
        }

        $hasCashflowRisk = false;
        $monthlyPaymentDates = $subscriptions->where('billing_cycle', 'monthly')->pluck('payment_date')->toArray();
        $dateCounts = array_count_values($monthlyPaymentDates);
        foreach ($dateCounts as $date => $count) {
            if ($count >= 3) {
                $hasCashflowRisk = true;
                $insights[] = [
                    'icon' => 'calendar',
                    'title' => 'Tsunami Tagihan',
                    'description' => "Ada <b>{$count} tagihan</b> yang jatuh tempo di tanggal <b>{$date}</b>. Hati-hati dengan risiko arus kas tersendat di pertengahan bulan. Pertimbangkan geser tanggal tagihan jika memungkinkan.",
                ];
                break;
            }
        }

        $redundancyCount = 0;
        
        $videoStreamers = $subscriptions->filter(fn($s) => preg_match('/netflix|disney|prime|hbo|vidio|viu|apple tv|wetv|iqiyi|catchplay|crunchyroll/i', $s->name));
        if ($videoStreamers->count() > 1) {
            $redundancyCount++;
            $names = $videoStreamers->pluck('name')->implode(' & ');
            $recommendations[] = "Redundansi Streaming Video: <b>{$names}</b>. Sebaiknya Anda berlangganan bergilir (ganti-ganti aplikasi tiap bulan) daripada berlangganan semuanya sekaligus.";
            $cheapest = $videoStreamers->sortBy('monthly_amount')->first();
            $potentialSavings += $cheapest->monthly_amount;
        }

        $aiTools = $subscriptions->filter(fn($s) => preg_match('/chatgpt|claude|gemini|perplexity|copilot|openai|midjourney/i', $s->name));
        if ($aiTools->count() > 1) {
            $redundancyCount++;
            $names = $aiTools->pluck('name')->implode(' & ');
            $recommendations[] = "Tumpang tindih Layanan AI: <b>{$names}</b>. Sebagian besar AI pintar memiliki kemampuan yang mirip. Pilih satu yang paling sesuai untuk alur kerja Anda.";
            $cheapest = $aiTools->sortBy('monthly_amount')->first();
            $potentialSavings += $cheapest->monthly_amount;
        }

        $musicStreamers = $subscriptions->filter(fn($s) => preg_match('/spotify|apple music|youtube music|joox/i', $s->name));
        if ($musicStreamers->count() > 1) {
            $redundancyCount++;
            $names = $musicStreamers->pluck('name')->implode(' & ');
            $recommendations[] = "Tumpang tindih Layanan Musik: <b>{$names}</b>. Katalog lagu mayoritas identik. Batalkan salah satu untuk penghematan instan.";
            $cheapest = $musicStreamers->sortBy('monthly_amount')->first();
            $potentialSavings += $cheapest->monthly_amount;
        }

        if (empty($recommendations)) {
            $recommendations[] = 'Skor kesehatan finansial Anda luar biasa. Tidak ada anomali atau pemborosan yang terdeteksi.';
        }

        $healthData = $this->healthScoreService->calculateUnifiedScore($user, $potentialSavings, [
            'redundancy_count' => $redundancyCount,
            'has_cashflow_risk' => $hasCashflowRisk
        ]);

        return [
            'summary' => "Anda mengelola {$subCount} langganan dengan akumulasi beban Rp" . number_format($totalMonthly, 0, ',', '.') . '/bulan.',
            'total_monthly' => $totalMonthly,
            'total_yearly' => $totalYearly,
            'health_score' => $healthData['score'],
            'health_data' => $healthData,
            'personality' => $personality,
            'potential_savings' => round($potentialSavings),
            'insights' => $insights,
            'recommendations' => $recommendations,
            'category_breakdown' => $categoryBreakdown,
        ];
    }
}

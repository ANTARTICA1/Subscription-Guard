<?php

namespace App\Services;

use App\Models\User;

class FinancialAssistantService
{
    public function calculateSubscriptionHash(User $user): string
    {
        $subs = $user->activeSubscriptions()->orderBy('id')->get();
        if ($subs->isEmpty()) {
            return 'empty';
        }

        $serialized = $subs->map(function ($s) {
            $updatedAt = $s->updated_at ? $s->updated_at->timestamp : 0;
            return "{$s->id}:{$s->name}:{$s->amount}:{$s->billing_cycle}:{$s->status}:{$updatedAt}";
        })->join('|');

        return md5($serialized);
    }

    public function checkSyncStatus(User $user): array
    {
        $currentHash = $this->calculateSubscriptionHash($user);
        $cachedData = $user->tata_assistant_data;
        $scannedAt = $user->tata_assistant_scanned_at;
        $savedHash = $user->tata_assistant_hash;

        $hasNeverScanned = empty($cachedData);
        $isSynced = !$hasNeverScanned && ($savedHash === $currentHash);

        return [
            'is_synced' => $isSynced,
            'has_never_scanned' => $hasNeverScanned,
            'scanned_at' => $scannedAt,
            'current_hash' => $currentHash,
            'saved_hash' => $savedHash,
        ];
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
                'health_data' => [
                    'score' => 0,
                    'label' => 'Belum Ada Data',
                    'color' => '#64748b',
                    'breakdown' => []
                ],
                'personality' => 'Belum Ada Data',
                'potential_savings' => 0,
                'insights' => [],
                'recommendations' => ['Mulai catat subscription Anda untuk mendapatkan analisis keuangan intelijen.'],
                'category_breakdown' => [],
            ];
        }

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

        $brandCounts = [];
        foreach ($subscriptions as $s) {
            $normalizedName = strtolower(trim(preg_replace('/\b(mobile|basic|standard|premium|family|student|individual|vip|ultra|plus|starter|pro|paket|langganan|kelas \d+)\b/i', '', $s->name)));
            $normalizedName = preg_replace('/[^a-z0-9]/', '', $normalizedName);
            if (!empty($normalizedName)) {
                $brandCounts[$normalizedName][] = $s;
            }
        }

        foreach ($brandCounts as $brand => $items) {
            if (count($items) > 1) {
                $names = collect($items)->pluck('name')->join(' & ');
                $recommendations[] = "Duplikasi Terdeteksi: <b>{$names}</b>. Anda memiliki lebih dari satu langganan untuk penyedia yang sama.";
                $sorted = collect($items)->sortBy('monthly_amount');
                $potentialSavings += $sorted->slice(0, count($items) - 1)->sum('monthly_amount');
            }
        }

        $musicSubs = $subscriptions->filter(fn($s) => stripos($s->name, 'Music') !== false || stripos($s->name, 'Spotify') !== false);
        $cloudSubs = $subscriptions->filter(fn($s) => stripos($s->name, 'iCloud') !== false || stripos($s->name, 'Google One') !== false);
        $tvSubs = $subscriptions->filter(fn($s) => stripos($s->name, 'Apple TV') !== false || stripos($s->name, 'Netflix') !== false);

        if ($musicSubs->count() > 0 && $cloudSubs->count() > 0 && $tvSubs->count() > 0) {
            $recommendations[] = "Terdeteksi pola langganan terpisah (Musik + Cloud + TV). Ekosistem bundle seperti <b>Apple One</b> atau <b>Google One</b> dapat dipertimbangkan jika ingin menyatukan layanan.";
        }

        $expensiveSubs = $subscriptions->filter(fn($s) => $s->monthly_amount > 150000)->sortByDesc('monthly_amount');
        if ($expensiveSubs->count() > 0) {
            $recommendations[] = "Layanan <b>{$expensiveSubs->first()->name}</b> memiliki biaya bulanan tertinggi. Pastikan Anda menggunakannya secara rutin agar tetap bernilai sepadan.";
        }

        $monthlySubs = $subscriptions->where('billing_cycle', 'monthly');
        if ($monthlySubs->count() >= 3) {
            $recommendations[] = "Untuk langganan yang sudah pasti Anda pakai dalam jangka panjang, cek apakah penyedia layanan resmi menyediakan opsi paket tahunan berdiskon.";
        }

        if ($totalMonthly > 500000) {
            $insights[] = [
                'icon' => 'alert-triangle',
                'title' => 'Tinjauan Pengeluaran Rutin',
                'description' => "Beban langganan mencapai <b>Rp " . number_format($totalMonthly, 0, ',', '.') . "</b>/bulan. Pastikan alokasi ini sesuai dengan rasio anggaran bulanan Anda.",
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
                    'title' => 'Konsentrasi Tanggal Tagihan',
                    'description' => "Ada <b>{$count} tagihan</b> yang jatuh tempo di tanggal <b>{$date}</b>. Pastikan saldo rekening mencukupi menjelang tanggal tersebut.",
                ];
                break;
            }
        }

        $videoStreamers = $subscriptions->filter(fn($s) => preg_match('/netflix|disney|prime|hbo|vidio|viu|apple tv|wetv|iqiyi|catchplay|crunchyroll/i', $s->name));
        if ($videoStreamers->count() > 2) {
            $names = $videoStreamers->pluck('name')->implode(' & ');
            $recommendations[] = "Beberapa Layanan Streaming Aktif: <b>{$names}</b>. Anda dapat mempertimbangkan sistem rotasi bulanan jika waktu menonton terbatas.";
        }

        $aiTools = $subscriptions->filter(fn($s) => preg_match('/chatgpt|claude|gemini|perplexity|copilot|openai|midjourney/i', $s->name));
        if ($aiTools->count() > 1) {
            $names = $aiTools->pluck('name')->implode(' & ');
            $recommendations[] = "Multi-Layanan AI: <b>{$names}</b>. Evaluasi model yang paling produktif untuk kebutuhan sehari-hari Anda.";
        }

        $musicStreamers = $subscriptions->filter(fn($s) => preg_match('/spotify|apple music|youtube music|joox/i', $s->name));
        if ($musicStreamers->count() > 1) {
            $names = $musicStreamers->pluck('name')->implode(' & ');
            $recommendations[] = "Multi-Layanan Musik: <b>{$names}</b>. Pertimbangkan mempertahankan satu katalog utama.";
        }

        if (empty($recommendations)) {
            $recommendations[] = 'Portofolio langganan Anda rapi. Pindai Tata Asisten untuk evaluasi mendalam oleh AI.';
        }

        return [
            'summary' => "Anda mengelola {$subCount} langganan dengan akumulasi beban Rp" . number_format($totalMonthly, 0, ',', '.') . '/bulan.',
            'total_monthly' => $totalMonthly,
            'total_yearly' => $totalYearly,
            'health_score' => 0,
            'health_data' => [
                'score' => 0,
                'label' => 'Belum Dipindai',
                'color' => '#64748b',
                'breakdown' => []
            ],
            'personality' => $personality,
            'potential_savings' => round($potentialSavings),
            'insights' => $insights,
            'recommendations' => $recommendations,
            'category_breakdown' => $categoryBreakdown,
        ];
    }
}

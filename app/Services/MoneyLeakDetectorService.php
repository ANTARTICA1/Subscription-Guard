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

        if ($subs->isEmpty()) {
            return [
                'leaks' => [],
                'total_potential_savings' => 0,
                'efficiency_score' => 100,
            ];
        }

        $brandGroups = [];
        foreach ($subs as $sub) {
            $normalized = $this->normalizeServiceName($sub->name);
            $brandGroups[$normalized][] = $sub;
        }

        $duplicateDetectedSubIds = [];
        foreach ($brandGroups as $normalizedName => $group) {
            if (count($group) > 1 && !empty($normalizedName)) {
                $groupCollection = collect($group);
                $names = $groupCollection->pluck('name')->join(' + ');

                $sorted = $groupCollection->sortBy('monthly_amount');
                $duplicates = $sorted->slice(0, count($group) - 1);
                $dupSavings = $duplicates->sum('monthly_amount');

                foreach ($groupCollection as $s) {
                    $duplicateDetectedSubIds[] = $s->id;
                }

                $totalPotentialSavings += $dupSavings;

                $leaks[] = [
                    'type' => 'duplicate',
                    'icon' => 'copy',
                    'title' => 'Duplikasi Layanan: ' . $group[0]->name,
                    'description' => "Terdeteksi lebih dari satu langganan aktif untuk penyedia yang sama: <b>{$names}</b>.",
                    'recommendation' => "Batalkan salah satu akun atau paket jika Anda tidak sengaja berlangganan ganda.",
                    'potential_savings' => $dupSavings,
                    'severity' => 'high'
                ];
            }
        }

        $byCategory = $subs->groupBy('category_id');
        foreach ($byCategory as $categoryId => $categorySubs) {
            if ($categorySubs->count() >= 2) {
                $categoryName = $categorySubs->first()->category->name ?? 'Kategori Sama';
                $names = $categorySubs->pluck('name')->join(' + ');

                $leaks[] = [
                    'type' => 'overlapping',
                    'icon' => 'layers',
                    'title' => 'Banyak Layanan: Kategori ' . $categoryName,
                    'description' => "Anda memiliki {$categorySubs->count()} langganan aktif dalam kategori ini: <b>{$names}</b>.",
                    'recommendation' => "Tinjau apakah seluruh layanan ini masih aktif digunakan setiap bulan. Pertimbangkan berlangganan bergantian jika waktu luang terbatas.",
                    'potential_savings' => 0,
                    'severity' => $categorySubs->count() >= 3 ? 'medium' : 'low'
                ];
            }
        }

        $now = Carbon::now();
        $suspiciousSubs = $subs->filter(function ($s) use ($now) {
            return $s->auto_renew && $s->created_at && $s->created_at->diffInDays($now) > 180;
        });

        if ($suspiciousSubs->count() > 0) {
            $names = $suspiciousSubs->pluck('name')->join(', ');
            $leaks[] = [
                'type' => 'zombie',
                'icon' => 'ghost',
                'title' => 'Langganan Auto-Renew Lama (> 6 Bulan)',
                'description' => "Layanan <b>{$names}</b> aktif dengan perpanjangan otomatis selama lebih dari 6 bulan.",
                'recommendation' => "Pastikan Anda masih menggunakan fasilitas layanan ini secara berkala agar tidak menjadi pengeluaran pasif.",
                'potential_savings' => 0,
                'severity' => 'low'
            ];
        }

        $vampireSubs = $subs->filter(fn($s) => $s->monthly_amount > 0 && $s->monthly_amount <= 35000);
        if ($vampireSubs->count() > 1) {
            $totalVampire = $vampireSubs->sum(fn($s) => $s->monthly_amount);
            $names = $vampireSubs->pluck('name')->join(', ');

            $leaks[] = [
                'type' => 'vampire',
                'icon' => 'droplet',
                'title' => 'Akumulasi Langganan Mikro',
                'description' => "Anda memiliki beberapa langganan mikro (<b>{$names}</b>) dengan total Rp" . number_format($totalVampire, 0, ',', '.') . "/bln.",
                'recommendation' => "Pastikan setiap langganan mikro ini tetap memberikan nilai nyata sebanding dengan pengeluaran rutin Anda.",
                'potential_savings' => 0,
                'severity' => 'low'
            ];
        }

        $efficiencyScore = 100;
        if ($calculateScore && $monthlyExpense > 0 && $totalPotentialSavings > 0) {
            $wasteRatio = $totalPotentialSavings / $monthlyExpense;
            $efficiencyScore = max(10, min(100, 100 - round($wasteRatio * 100)));
        }

        return [
            'leaks' => collect($leaks)->values()->toArray(),
            'total_potential_savings' => $totalPotentialSavings,
            'efficiency_score' => (int) $efficiencyScore
        ];
    }

    private function normalizeServiceName(string $name): string
    {
        $clean = strtolower($name);
        $clean = preg_replace('/\b(mobile|basic|standard|premium|family|student|individual|vip|ultra|plus|starter|pro|paket|langganan|bulan|tahun|kelas \d+)\b/i', '', $clean);
        $clean = preg_replace('/[^a-z0-9]/', '', $clean);
        return trim($clean);
    }
}

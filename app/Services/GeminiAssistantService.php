<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiAssistantService
{
    private string $apiKey;
    private string $model;
    private array $fallbackModels = ['gemini-2.5-flash-lite', 'gemini-3.6-flash', 'gemini-3.5-flash-lite'];

    public function __construct()
    {
        $this->apiKey = (string) config('services.gemini.api_key', '');
        $this->model = (string) config('services.gemini.model', 'gemini-2.5-flash-lite');
    }

    public function analyze(User $user): array
    {
        if (empty($this->apiKey)) {
            return [
                'success' => false,
                'error_code' => 'NO_API_KEY',
                'error_message' => 'API Key Gemini belum dikonfigurasi pada sistem.',
            ];
        }

        $subscriptions = $user->activeSubscriptions()->with('category')->get();
        $totalMonthly = $user->monthlyExpense();
        $totalYearly = $user->yearlyExpense();
        $subCount = $subscriptions->count();

        if ($subCount === 0) {
            return [
                'success' => true,
                'data' => [
                    'summary' => 'Anda belum memiliki langganan aktif.',
                    'total_monthly' => 0,
                    'total_yearly' => 0,
                    'health_score' => 0,
                    'personality' => 'Belum Ada Data',
                    'potential_savings' => 0,
                    'insights' => [],
                    'recommendations' => ['Tambahkan langganan aktif Anda untuk mendapatkan audit finansial cerdas.'],
                    'health_data' => [
                        'score' => 0,
                        'label' => 'Belum Ada Data',
                        'color' => '#64748b',
                        'breakdown' => []
                    ],
                    'category_breakdown' => [],
                ]
            ];
        }

        $subscriptionList = [];
        foreach ($subscriptions as $s) {
            $subscriptionList[] = [
                'name' => $s->name,
                'category' => $s->category->name ?? 'Lainnya',
                'amount' => (float) $s->amount,
                'monthly_amount' => (float) $s->monthly_amount,
                'billing_cycle' => $s->billing_cycle,
                'payment_date' => $s->payment_date,
                'auto_renew' => (bool) $s->auto_renew,
                'is_personal' => (bool) $s->is_personal,
            ];
        }

        $prompt = "Bertindaklah sebagai Senior Financial Auditor profesional khusus langganan digital (Subscription Manager). "
            . "Analisis data portofolio langganan pengguna berikut dengan standar audit yang ketat dan kritis:\n\n"
            . "Jumlah Langganan: {$subCount}\n"
            . "Total Beban Bulanan: Rp " . number_format($totalMonthly, 0, ',', '.') . "\n"
            . "Total Beban Tahunan: Rp " . number_format($totalYearly, 0, ',', '.') . "\n"
            . "Daftar Langganan:\n" . json_encode($subscriptionList, JSON_PRETTY_PRINT) . "\n\n"
            . "Pedoman Penilaian Skor Kesehatan Finansial (Health Score 0-100):\n"
            . "- Nilai awal adalah 100.\n"
            . "- Tumpang Tindih / Redundansi Layanan: Jika pengguna memiliki >1 layanan dengan fungsi sejenis (misal: berlangganan beberapa streaming film seperti Netflix + WeTV + Disney+ + Apple TV+, atau beberapa AI tools seperti ChatGPT + Claude + Gemini, atau beberapa streaming musik), potong 15 sampai 30 poin tergantung tingkat keparahannya.\n"
            . "- Siklus Tagihan: Jika semua atau mayoritas langganan masih memakai siklus bulanan padahal sering dipakai dan ada opsi diskon tahunan 15-20%, potong 10 sampai 15 poin.\n"
            . "- Konsentrasi Biaya & Dominasi: Jika ada 1 layanan yang menyedot >35% total anggaran tanpa pembagian porsi yang jelas, potong 5 sampai 10 poin.\n"
            . "- Kriteria Label Skor: 90-100 (Sempurna, warna #10b981), 75-89 (Baik, warna #3b82f6), 50-74 (Perlu Perhatian, warna #f59e0b), <50 (Kritis, warna #ef4444).\n\n"
            . "Kembalikan HANYA JSON murni tanpa pembungkus markdown apapun dengan skema berikut:\n"
            . "{\n"
            . '  "personality": "Nama julukan profil finansial yang kreatif dan deskriptif (misal: The Redundant Streamer, The Multi-AI Collector, Productivity Hacker, The Digital Connoisseur, Minimalist, dsb)",' . "\n"
            . '  "summary": "Ringkasan eksekutif 1-2 kalimat tentang kondisi portofolio pengguna dan kelemahan utamanya.",' . "\n"
            . '  "health_score": 65,' . "\n"
            . '  "potential_savings": 150000,' . "\n"
            . '  "insights": [' . "\n"
            . '    {' . "\n"
            . '      "icon": "trending-up|pie-chart|alert-triangle",' . "\n"
            . '      "title": "Judul insight singkat padat",' . "\n"
            . '      "description": "Penjelasan mendalam dengan tag b untuk penekanan angka atau nama layanan."' . "\n"
            . '    }' . "\n"
            . '  ],' . "\n"
            . '  "recommendations": [' . "\n"
            . '    "Langkah pemangkasan/optimasi konkret nomor 1 dengan tag b",' . "\n"
            . '    "Langkah pemangkasan/optimasi konkret nomor 2 dengan tag b"' . "\n"
            . '  ],' . "\n"
            . '  "health_data": {' . "\n"
            . '    "score": 65,' . "\n"
            . '    "label": "Perlu Perhatian",' . "\n"
            . '    "color": "#f59e0b",' . "\n"
            . '    "breakdown": [' . "\n"
            . '      {"name": "Efisiensi Biaya", "score": 20, "max": 30, "desc": "Penilaian rasio beban pengeluaran"},' . "\n"
            . '      {"name": "Diversifikasi Layanan", "score": 15, "max": 25, "desc": "Evaluasi tumpang tindih kategori"},' . "\n"
            . '      {"name": "Optimalisasi Siklus", "score": 15, "max": 25, "desc": "Pemanfaatan diskon tahunan"},' . "\n"
            . '      {"name": "Manajemen Arus Kas", "score": 15, "max": 20, "desc": "Penyebaran tanggal tagihan"}' . "\n"
            . '    ]' . "\n"
            . '  }' . "\n"
            . '}';

        $modelsToTry = array_unique(array_merge([$this->model], $this->fallbackModels));
        $lastError = 'Terjadi kesalahan saat memanggil server AI.';
        $lastStatusCode = 500;

        foreach ($modelsToTry as $currentModel) {
            $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$currentModel}:generateContent?key={$this->apiKey}";

            try {
                $response = Http::withoutVerifying()->timeout(25)->post($endpoint, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.2,
                        'responseMimeType' => 'application/json',
                    ]
                ]);

                if ($response->successful()) {
                    $jsonResponse = $response->json();
                    $rawText = $jsonResponse['candidates'][0]['content']['parts'][0]['text'] ?? '';

                    $rawText = trim($rawText);
                    if (str_starts_with($rawText, '```json')) {
                        $rawText = substr($rawText, 7);
                    } elseif (str_starts_with($rawText, '```')) {
                        $rawText = substr($rawText, 3);
                    }
                    if (str_ends_with($rawText, '```')) {
                        $rawText = substr($rawText, 0, -3);
                    }
                    $rawText = trim($rawText);

                    $parsed = json_decode($rawText, true);

                    if (is_array($parsed) && isset($parsed['personality']) && isset($parsed['health_score'])) {
                        $parsed['total_monthly'] = $totalMonthly;
                        $parsed['total_yearly'] = $totalYearly;

                        return [
                            'success' => true,
                            'data' => $parsed,
                            'model_used' => $currentModel,
                        ];
                    }
                }

                $lastStatusCode = $response->status();
                $body = $response->json();
                $lastError = $body['error']['message'] ?? $response->body();
                Log::warning("Gemini Assistant Model {$currentModel} Failed: " . $lastError);
            } catch (\Throwable $e) {
                $lastError = $e->getMessage();
                Log::error("Gemini Assistant Exception on {$currentModel}: " . $lastError);
            }
        }

        return [
            'success' => false,
            'error_code' => $lastStatusCode,
            'error_message' => $lastStatusCode === 429
                ? 'Batas kuota harian/menit API Gemini tercapai (Rate Limit 429).'
                : "Gangguan server AI Gemini (HTTP {$lastStatusCode}): {$lastError}",
        ];
    }
}

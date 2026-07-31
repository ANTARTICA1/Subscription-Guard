<?php

namespace App\Services;

class SubscriptionComparisonService
{
    public function getComparisons(): array
    {
        return [
            [
                'category' => 'Streaming Video / Entertainment',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>',
                'description' => 'Perbandingan platform streaming film dan serial populer di Indonesia berdasarkan ROI (Return on Investment) dan fitur.',
                'items' => [
                    [
                        'name' => 'Netflix',
                        'logo' => 'https://icon.horse/icon/netflix.com',
                        'price_monthly' => 'Rp186.000 (Premium 4K)',
                        'price_value' => 186000,
                        'features' => ['4K UHD + HDR', '4 Layar Bersamaan', 'Katalog Seribu Film & Drama'],
                        'value_score' => 82,
                        'best_for' => 'Keluarga besar & Penggemar Originals',
                        'analytics' => [
                            'cost_per_feature' => 'Rp 46.500 / layar',
                            'switching_roi' => 'Pindah ke opsi termurah menghemat Rp 1.524.000/tahun (Setara staycation bintang 4).',
                        ]
                    ],
                    [
                        'name' => 'Disney+ Hotstar',
                        'logo' => 'https://img.icons8.com/?size=512&id=o7YMV0TFYOgR&format=png',
                        'price_monthly' => 'Rp119.000 / bln (Premium 4K)',
                        'price_value' => 119000,
                        'features' => ['4K Ultra HD', 'Marvel & Disney Originals', 'Bioskop Indonesia'],
                        'value_score' => 92,
                        'best_for' => 'Pecinta Marvel, Star Wars & Film Bioskop',
                        'analytics' => [
                            'cost_per_feature' => 'Rp 29.750 / layar',
                            'switching_roi' => 'Opsi premium paling berimbang (Balance of Price & Content).',
                        ]
                    ],
                    [
                        'name' => 'Prime Video',
                        'logo' => 'https://img.icons8.com/?size=100&id=mJTj7Q9EPSVn&format=png&color=000000',
                        'price_monthly' => 'Rp59.000 / bulan',
                        'price_value' => 59000,
                        'features' => ['HD / 4K', 'Original Exclusive Series', 'Harga Paling Terjangkau'],
                        'value_score' => 88,
                        'best_for' => 'Hemat biaya dengan serial berkualitas',
                        'analytics' => [
                            'cost_per_feature' => 'Cost-efficiency tertinggi (100%)',
                            'switching_roi' => 'Opsi termurah. Menghemat Rp 1.524.000/tahun dibanding Netflix.',
                        ]
                    ],
                ]
            ],
            [
                'category' => 'Music Streaming',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>',
                'description' => 'Analisis platform musik tanpa iklan dengan perbandingan kualitas audio vs harga.',
                'items' => [
                    [
                        'name' => 'Spotify Individual',
                        'logo' => 'https://icon.horse/icon/spotify.com',
                        'price_monthly' => 'Rp54.990 / bulan',
                        'price_value' => 54990,
                        'features' => ['Algoritma Rekomendasi #1', 'Podcast Terintegrasi', 'Spotify Connect'],
                        'value_score' => 95,
                        'best_for' => 'Daily listener & eksplorasi musik baru',
                        'analytics' => [
                            'cost_per_feature' => 'Standar industri musik',
                            'switching_roi' => 'Pindah ke paket Family (6 akun) menurunkan cost menjadi Rp 15.800/orang.',
                        ]
                    ],
                    [
                        'name' => 'Apple Music',
                        'logo' => 'https://icon.horse/icon/music.apple.com',
                        'price_monthly' => 'Rp55.000 / bulan',
                        'price_value' => 55000,
                        'features' => ['Lossless Audio', 'Dolby Atmos / Spatial', 'Integrasi Ekosistem Apple'],
                        'value_score' => 92,
                        'best_for' => 'Audiophile & Pengguna iPhone/Mac',
                        'analytics' => [
                            'cost_per_feature' => 'Value tertinggi untuk kualitas Audio (Lossless gratis)',
                            'switching_roi' => 'Sangat direkomendasikan bundle Apple One jika langganan iCloud juga.',
                        ]
                    ],
                    [
                        'name' => 'YouTube Music',
                        'logo' => 'https://icon.horse/icon/music.youtube.com',
                        'price_monthly' => 'Rp49.000 / bulan',
                        'price_value' => 49000,
                        'features' => ['Video Cover & Live Concerts', 'Smart Downloads', 'Katalog Paling Lengkap'],
                        'value_score' => 89,
                        'best_for' => 'Mendengarkan cover & lagu indie',
                        'analytics' => [
                            'cost_per_feature' => 'Sedikit lebih murah (hemat 10% dibanding kompetitor)',
                            'switching_roi' => 'Upgrade ke YouTube Premium (Rp 69rb) jauh lebih tinggi ROI-nya.',
                        ]
                    ],
                ]
            ],
            [
                'category' => 'AI Assistant & Productivity Tools',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
                'description' => 'Komparasi alat kecerdasan buatan (AI) terkemuka dengan analisis efisiensi kerja.',
                'items' => [
                    [
                        'name' => 'ChatGPT Plus',
                        'logo' => 'https://icon.horse/icon/chatgpt.com',
                        'price_monthly' => 'Rp320.000 ($20 / bulan)',
                        'price_value' => 320000,
                        'features' => ['GPT-4o Access', 'DALL-E 3 Image', 'Advanced Data Analysis'],
                        'value_score' => 94,
                        'best_for' => 'General Purpose, Coding & Visuals',
                        'analytics' => [
                            'cost_per_feature' => 'Rp 10.600/hari untuk AI terdepan',
                            'switching_roi' => 'ROI sangat tinggi jika menggantikan 1 jam kerja per hari.',
                        ]
                    ],
                    [
                        'name' => 'Claude Pro (Anthropic)',
                        'logo' => 'https://icon.horse/icon/claude.ai',
                        'price_monthly' => 'Rp320.000 ($20 / bulan)',
                        'price_value' => 320000,
                        'features' => ['Claude 3.5 Sonnet', '200k Context Window', 'Natural Writing'],
                        'value_score' => 97,
                        'best_for' => 'Programmer & Penulis Buku/Artikel Panjang',
                        'analytics' => [
                            'cost_per_feature' => 'Performa coding #1 saat ini',
                            'switching_roi' => 'Pindah dari ChatGPT Plus direkomendasikan jika fokus pada Coding.',
                        ]
                    ],
                    [
                        'name' => 'Google Gemini Advanced',
                        'logo' => 'https://icon.horse/icon/gemini.google.com',
                        'price_monthly' => 'Rp319.000 / bulan',
                        'price_value' => 319000,
                        'features' => ['Gemini 1.5 Pro', '1 Juta Context Token', 'Bonus Google One 2TB'],
                        'value_score' => 91,
                        'best_for' => 'Pengguna berat Ekosistem Google (Drive, Docs)',
                        'analytics' => [
                            'cost_per_feature' => 'Mendapatkan Cloud 2TB senilai Rp 135.000 secara gratis.',
                            'switching_roi' => 'Opsi paling menguntungkan (Ecosystem Bundle Detection aktif).',
                        ]
                    ],
                ]
            ],
        ];
    }
}

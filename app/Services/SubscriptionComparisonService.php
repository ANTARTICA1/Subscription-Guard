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
                'description' => 'Perbandingan platform streaming film dan serial populer di Indonesia',
                'items' => [
                    [
                        'name' => 'Netflix',
                        'logo' => 'https://icon.horse/icon/netflix.com',
                        'price_monthly' => 'Rp186.000 (Premium 4K)',
                        'price_value' => 186000,
                        'features' => ['4K UHD + HDR', '4 Layar Bersamaan', 'Katalog Seribu Film & Drama'],
                        'value_score' => 88,
                        'best_for' => 'Keluarga & Penggemar Drama Korea / Originals',
                    ],
                    [
                        'name' => 'Disney+ Hotstar',
                        'logo' => 'https://icon.horse/icon/hotstar.com',
                        'price_monthly' => 'Rp65.000 / bln (atau Rp799k/thn)',
                        'price_value' => 65000,
                        'features' => ['4K Ultra HD', 'Marvel & Disney Originals', 'Bioskop Indonesia'],
                        'value_score' => 92,
                        'best_for' => 'Pecinta Marvel, Star Wars & Film Bioskop',
                    ],
                    [
                        'name' => 'Prime Video',
                        'logo' => 'https://icon.horse/icon/primevideo.com',
                        'price_monthly' => 'Rp59.000 / bulan',
                        'price_value' => 59000,
                        'features' => ['HD / 4K', 'Original Exclusive Series', 'Harga Paling Terjangkau'],
                        'value_score' => 85,
                        'best_for' => 'Hemat biaya dengan serial berkualitas',
                    ],
                ]
            ],
            [
                'category' => 'Music Streaming',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>',
                'description' => 'Perbandingan platform musik & podcast tanpa iklan',
                'items' => [
                    [
                        'name' => 'Spotify Individual',
                        'logo' => 'https://icon.horse/icon/spotify.com',
                        'price_monthly' => 'Rp54.990 / bulan',
                        'price_value' => 54990,
                        'features' => ['Lagu Bebas Iklan', 'Offline Downloads', 'Rekomendasi Algoritma Terbaik'],
                        'value_score' => 95,
                        'best_for' => 'Pencinta Musik & Podcast Terpopuler',
                    ],
                    [
                        'name' => 'Apple Music',
                        'logo' => 'https://icon.horse/icon/music.apple.com',
                        'price_monthly' => 'Rp55.000 / bulan',
                        'price_value' => 55000,
                        'features' => ['Lossless Audio & Spatial Audio', 'Dolby Atmos', 'Lirik Real-Time'],
                        'value_score' => 90,
                        'best_for' => 'Pengguna Audiophile & Ekosistem Apple',
                    ],
                    [
                        'name' => 'YouTube Music',
                        'logo' => 'https://icon.horse/icon/music.youtube.com',
                        'price_monthly' => 'Rp49.000 / bulan',
                        'price_value' => 49000,
                        'features' => ['Termasuk Video Cover & Live Concerts', 'Integrasi YouTube', 'Background Play'],
                        'value_score' => 89,
                        'best_for' => 'Suka mendengarkan lagu langka & remix YouTube',
                    ],
                ]
            ],
            [
                'category' => 'AI Assistant & Productivity Tools',
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
                'description' => 'Perbandingan langganan AI premium untuk efisiensi kerja',
                'items' => [
                    [
                        'name' => 'ChatGPT Plus (GPT-4o)',
                        'logo' => 'https://icon.horse/icon/chatgpt.com',
                        'price_monthly' => 'Rp315.000 ($20 / bulan)',
                        'price_value' => 315000,
                        'features' => ['GPT-4o Access', 'DALL-E 3 Image Generator', 'Custom GPTs & Memory'],
                        'value_score' => 94,
                        'best_for' => 'Productivity All-Rounder & Content Creator',
                    ],
                    [
                        'name' => 'Claude Pro (Anthropic)',
                        'logo' => 'https://icon.horse/icon/claude.ai',
                        'price_monthly' => 'Rp315.000 ($20 / bulan)',
                        'price_value' => 315000,
                        'features' => ['Claude 3.5 Sonnet', '200k Context Window', 'Coding & Writing Unggul'],
                        'value_score' => 96,
                        'best_for' => 'Programmer, Penulis & Analis Dokumen Panjang',
                    ],
                    [
                        'name' => 'Google Gemini Advanced',
                        'logo' => 'https://icon.horse/icon/gemini.google.com',
                        'price_monthly' => 'Rp309.000 / bulan (Gratis 2TB Drive)',
                        'price_value' => 309000,
                        'features' => ['Gemini 1.5 Pro', '1 Juta Context Token', 'Bonus Google One 2TB'],
                        'value_score' => 91,
                        'best_for' => 'Pengguna Google Workspace & Cloud Storage Heavy User',
                    ],
                ]
            ],
        ];
    }
}

<?php

namespace App\Services;

class SubscriptionTemplateService
{
    public function getTemplates(): array
    {
        return [
            'Film & Streaming' => [
                [
                    'name' => 'Netflix',
                    'logo' => 'https://icon.horse/icon/netflix.com',
                    'category' => 'Entertainment',
                    'plans' => [
                        ['name' => 'Mobile', 'price' => 54000],
                        ['name' => 'Basic', 'price' => 65000],
                        ['name' => 'Standard', 'price' => 120000],
                        ['name' => 'Premium', 'price' => 186000],
                    ],
                ],
                [
                    'name' => 'YouTube Premium',
                    'logo' => 'https://icon.horse/icon/youtube.com',
                    'category' => 'Entertainment',
                    'plans' => [
                        ['name' => 'Student', 'price' => 41500],
                        ['name' => 'Individual', 'price' => 69000],
                        ['name' => 'Family', 'price' => 139000],
                    ],
                ],
                [
                    'name' => 'Disney+ Hotstar',
                    'logo' => 'https://icon.horse/icon/hotstar.com',
                    'category' => 'Entertainment',
                    'plans' => [
                        ['name' => 'Basic', 'price' => 65000],
                        ['name' => 'Premium', 'price' => 119000],
                    ],
                ],
                [
                    'name' => 'Vidio',
                    'logo' => 'https://icon.horse/icon/vidio.com',
                    'category' => 'Entertainment',
                    'plans' => [
                        ['name' => 'Platinum', 'price' => 43000],
                    ],
                ],
                [
                    'name' => 'Vision+',
                    'logo' => 'https://icon.horse/icon/visionplus.id',
                    'category' => 'Entertainment',
                    'plans' => [
                        ['name' => 'Premium', 'price' => 20000],
                        ['name' => 'Premium Sports', 'price' => 40000],
                    ],
                ],
                [
                    'name' => 'Prime Video',
                    'logo' => 'https://icon.horse/icon/primevideo.com',
                    'category' => 'Entertainment',
                    'plans' => [
                        ['name' => 'Mobile', 'price' => 39000],
                        ['name' => 'Standar', 'price' => 59000],
                    ],
                ],
                [
                    'name' => 'HBO / Max',
                    'logo' => 'https://icon.horse/icon/max.com',
                    'category' => 'Entertainment',
                    'plans' => [
                        ['name' => 'Standard', 'price' => 79000],
                    ],
                ],
                [
                    'name' => 'WeTV',
                    'logo' => 'https://icon.horse/icon/wetv.vip',
                    'category' => 'Entertainment',
                    'plans' => [
                        ['name' => 'VIP', 'price' => 53000],
                    ],
                ],
                [
                    'name' => 'Viu',
                    'logo' => 'https://icon.horse/icon/viu.com',
                    'category' => 'Entertainment',
                    'plans' => [
                        ['name' => 'Premium', 'price' => 43290],
                    ],
                ],
                [
                    'name' => 'iQIYI',
                    'logo' => 'https://icon.horse/icon/iq.com',
                    'category' => 'Entertainment',
                    'plans' => [
                        ['name' => 'VIP Standard', 'price' => 39000],
                        ['name' => 'VIP Premium', 'price' => 99000],
                    ],
                ],
                [
                    'name' => 'Apple TV+',
                    'logo' => 'https://icon.horse/icon/tv.apple.com',
                    'category' => 'Entertainment',
                    'plans' => [
                        ['name' => 'Standard', 'price' => 99000],
                    ],
                ],
            ],
            
            'Music' => [
                [
                    'name' => 'Spotify',
                    'logo' => 'https://icon.horse/icon/spotify.com',
                    'category' => 'Entertainment',
                    'plans' => [
                        ['name' => 'Student', 'price' => 29999],
                        ['name' => 'Individual', 'price' => 59000],
                        ['name' => 'Duo', 'price' => 79900],
                        ['name' => 'Family', 'price' => 94900],
                    ],
                ],
                [
                    'name' => 'YouTube Music',
                    'logo' => 'https://icon.horse/icon/music.youtube.com',
                    'category' => 'Entertainment',
                    'plans' => [
                        ['name' => 'Student', 'price' => 24990],
                        ['name' => 'Individual', 'price' => 49000],
                        ['name' => 'Family', 'price' => 75000],
                    ],
                ],
                [
                    'name' => 'Apple Music',
                    'logo' => 'https://icon.horse/icon/music.apple.com',
                    'category' => 'Entertainment',
                    'plans' => [
                        ['name' => 'Student', 'price' => 35000],
                        ['name' => 'Individual', 'price' => 59000],
                        ['name' => 'Family', 'price' => 99000],
                    ],
                ],
                [
                    'name' => 'Joox',
                    'logo' => 'https://icon.horse/icon/joox.com',
                    'category' => 'Entertainment',
                    'plans' => [
                        ['name' => 'VIP', 'price' => 49000],
                    ],
                ],
            ],
            
            'AI & Productivity' => [
                [
                    'name' => 'ChatGPT',
                    'logo' => 'https://icon.horse/icon/chatgpt.com',
                    'category' => 'Software',
                    'plans' => [
                        ['name' => 'Plus', 'price' => 349000],
                        ['name' => 'Pro', 'price' => 1889000],
                    ],
                ],
                [
                    'name' => 'Gemini',
                    'logo' => 'https://icon.horse/icon/gemini.google.com',
                    'category' => 'Software',
                    'plans' => [
                        ['name' => 'Plus', 'price' => 75000],
                        ['name' => 'Pro', 'price' => 309000],
                        ['name' => 'Ultra', 'price' => 1579000],
                    ],
                ],
                [
                    'name' => 'Claude',
                    'logo' => 'https://icon.horse/icon/claude.ai',
                    'category' => 'Software',
                    'plans' => [
                        ['name' => 'Pro', 'price' => 320000],
                    ],
                ],
                [
                    'name' => 'Perplexity',
                    'logo' => 'https://icon.horse/icon/perplexity.ai',
                    'category' => 'Software',
                    'plans' => [
                        ['name' => 'Pro', 'price' => 320000],
                    ],
                ],
                [
                    'name' => 'Grok',
                    'logo' => 'https://icon.horse/icon/x.com',
                    'category' => 'Software',
                    'plans' => [
                        ['name' => 'Premium', 'price' => 256000],
                        ['name' => 'Premium+', 'price' => 352000],
                    ],
                ],
                [
                    'name' => 'Cursor',
                    'logo' => 'https://icon.horse/icon/cursor.com',
                    'category' => 'Software',
                    'plans' => [
                        ['name' => 'Pro', 'price' => 320000],
                    ],
                ],
                [
                    'name' => 'GitHub Copilot',
                    'logo' => 'https://icon.horse/icon/github.com',
                    'category' => 'Software',
                    'plans' => [
                        ['name' => 'Individual', 'price' => 160000],
                    ],
                ],
                [
                    'name' => 'Microsoft Copilot Pro',
                    'logo' => 'https://icon.horse/icon/copilot.microsoft.com',
                    'category' => 'Software',
                    'plans' => [
                        ['name' => 'Pro', 'price' => 320000],
                    ],
                ],
            ],

            'Design' => [
                [
                    'name' => 'Canva',
                    'logo' => 'https://icon.horse/icon/canva.com',
                    'category' => 'Software',
                    'plans' => [
                        ['name' => 'Pro Individual', 'price' => 95000],
                        ['name' => 'Pro Teams', 'price' => 124000],
                    ],
                ],
                [
                    'name' => 'Figma',
                    'logo' => 'https://icon.horse/icon/figma.com',
                    'category' => 'Software',
                    'plans' => [
                        ['name' => 'Professional', 'price' => 195000],
                    ],
                ],
                [
                    'name' => 'CorelDRAW',
                    'logo' => 'https://icon.horse/icon/coreldraw.com',
                    'category' => 'Software',
                    'plans' => [
                        ['name' => 'Graphics Suite', 'price' => 400000],
                    ],
                ],
            ],

            'Cloud Storage' => [
                [
                    'name' => 'Google One',
                    'logo' => 'https://icon.horse/icon/one.google.com',
                    'category' => 'Internet',
                    'plans' => [
                        ['name' => '100GB', 'price' => 26900],
                        ['name' => '200GB', 'price' => 43000],
                        ['name' => '2TB', 'price' => 135000],
                        ['name' => 'AI Premium 2TB', 'price' => 319000],
                    ],
                ],
                [
                    'name' => 'iCloud+',
                    'logo' => 'https://icon.horse/icon/icloud.com',
                    'category' => 'Internet',
                    'plans' => [
                        ['name' => '50GB', 'price' => 15000],
                        ['name' => '200GB', 'price' => 59000],
                        ['name' => '2TB', 'price' => 199000],
                    ],
                ],
                [
                    'name' => 'Dropbox',
                    'logo' => 'https://icon.horse/icon/dropbox.com',
                    'category' => 'Internet',
                    'plans' => [
                        ['name' => 'Plus 2TB', 'price' => 195000],
                        ['name' => 'Professional 3TB', 'price' => 320000],
                    ],
                ],
                [
                    'name' => 'OneDrive',
                    'logo' => 'https://icon.horse/icon/onedrive.live.com',
                    'category' => 'Internet',
                    'plans' => [
                        ['name' => 'Standalone 100GB', 'price' => 28999],
                        ['name' => 'Personal 1TB', 'price' => 87999],
                        ['name' => 'Family 6TB', 'price' => 119999],
                    ],
                ],
                [
                    'name' => 'MEGA',
                    'logo' => 'https://icon.horse/icon/mega.io',
                    'category' => 'Internet',
                    'plans' => [
                        ['name' => 'Pro I 2TB', 'price' => 160000],
                        ['name' => 'Pro II 8TB', 'price' => 320000],
                    ],
                ],
            ],

            'Gaming' => [
                [
                    'name' => 'Xbox Game Pass',
                    'logo' => 'https://icon.horse/icon/xbox.com',
                    'category' => 'Gaming',
                    'plans' => [
                        ['name' => 'Core', 'price' => 79000],
                        ['name' => 'PC', 'price' => 79000],
                        ['name' => 'Console', 'price' => 109000],
                        ['name' => 'Ultimate', 'price' => 169000],
                    ],
                ],
                [
                    'name' => 'PlayStation Plus',
                    'logo' => 'https://icon.horse/icon/playstation.com',
                    'category' => 'Gaming',
                    'plans' => [
                        ['name' => 'Essential', 'price' => 89000],
                        ['name' => 'Extra', 'price' => 139000],
                        ['name' => 'Deluxe', 'price' => 159000],
                    ],
                ],
                [
                    'name' => 'Nintendo Switch Online',
                    'logo' => 'https://icon.horse/icon/nintendo.com',
                    'category' => 'Gaming',
                    'plans' => [
                        ['name' => 'Individual', 'price' => 65000],
                    ],
                ],
                [
                    'name' => 'EA Play',
                    'logo' => 'https://icon.horse/icon/ea.com',
                    'category' => 'Gaming',
                    'plans' => [
                        ['name' => 'Standard', 'price' => 87000],
                    ],
                ],
                [
                    'name' => 'Ubisoft+',
                    'logo' => 'https://icon.horse/icon/ubisoft.com',
                    'category' => 'Gaming',
                    'plans' => [
                        ['name' => 'PC Access', 'price' => 275000],
                    ],
                ],
                [
                    'name' => 'GeForce NOW',
                    'logo' => 'https://icon.horse/icon/nvidia.com',
                    'category' => 'Gaming',
                    'plans' => [
                        ['name' => 'Priority', 'price' => 150000],
                    ],
                ],
            ],

            'Podcast & Audio' => [
                [
                    'name' => 'Noice',
                    'logo' => 'https://icon.horse/icon/noice.id',
                    'category' => 'Entertainment',
                    'plans' => [
                        ['name' => 'Premium', 'price' => 40000],
                    ],
                ],
            ],

            'Meeting & Workspace' => [
                [
                    'name' => 'Zoom',
                    'logo' => 'https://icon.horse/icon/zoom.us',
                    'category' => 'Software',
                    'plans' => [
                        ['name' => 'Pro', 'price' => 240000],
                        ['name' => 'Business', 'price' => 350000],
                    ],
                ],
                [
                    'name' => 'Google Workspace',
                    'logo' => 'https://icon.horse/icon/workspace.google.com',
                    'category' => 'Software',
                    'plans' => [
                        ['name' => 'Starter', 'price' => 96000],
                        ['name' => 'Standard', 'price' => 192000],
                        ['name' => 'Plus', 'price' => 288000],
                    ],
                ],
                [
                    'name' => 'Microsoft Teams',
                    'logo' => 'https://icon.horse/icon/teams.microsoft.com',
                    'category' => 'Software',
                    'plans' => [
                        ['name' => 'Essentials', 'price' => 64000],
                    ],
                ],
            ],

            'Custom / Bulanan' => [
                [
                    'name' => 'Gym Membership',
                    'logo' => 'https://icon.horse/icon/fitnessfirst.com',
                    'category' => 'Health',
                    'plans' => [
                        ['name' => 'Standard Gym', 'price' => 350000],
                        ['name' => 'Mega Gym', 'price' => 600000],
                    ],
                ],
                [
                    'name' => 'BPJS Kesehatan',
                    'logo' => 'https://icon.horse/icon/bpjs-kesehatan.go.id',
                    'category' => 'Health',
                    'plans' => [
                        ['name' => 'Kelas 3', 'price' => 35000],
                        ['name' => 'Kelas 2', 'price' => 100000],
                        ['name' => 'Kelas 1', 'price' => 150000],
                    ],
                ],
                [
                    'name' => 'Domain Pribadi',
                    'logo' => 'https://icon.horse/icon/namecheap.com',
                    'category' => 'Internet',
                    'plans' => [
                        ['name' => '.com (dibayar bulanan)', 'price' => 20833],
                        ['name' => '.com (tahunan Rp250.000)', 'price' => 250000, 'cycle' => 'yearly'],
                    ],
                ],
            ],
        ];
    }
}

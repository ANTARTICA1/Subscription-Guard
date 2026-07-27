<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\PaymentHistory;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'user@tatagih.app')->first();
        if (!$user) return;

        $entertainment = Category::where('name', 'Entertainment')->first();
        $internet = Category::where('name', 'Internet')->first();
        $software = Category::where('name', 'Software')->first();
        $gaming = Category::where('name', 'Gaming')->first();
        $education = Category::where('name', 'Education')->first();

        $subscriptions = [
            [
                'user_id' => $user->id,
                'category_id' => $entertainment->id,
                'name' => 'Netflix',
                'description' => 'Premium streaming 4K',
                'amount' => 186000,
                'billing_cycle' => 'monthly',
                'payment_date' => 25,
                'start_date' => '2024-01-01',
                'auto_renew' => true,
                'reminder_days' => 3,
                'status' => 'active',
            ],
            [
                'user_id' => $user->id,
                'category_id' => $entertainment->id,
                'name' => 'Spotify',
                'description' => 'Music streaming tanpa iklan',
                'amount' => 54990,
                'billing_cycle' => 'monthly',
                'payment_date' => 28,
                'start_date' => '2024-02-01',
                'auto_renew' => true,
                'reminder_days' => 3,
                'status' => 'active',
            ],
            [
                'user_id' => $user->id,
                'category_id' => $entertainment->id,
                'name' => 'Disney+',
                'description' => 'Disney & Marvel streaming',
                'amount' => 159000,
                'billing_cycle' => 'yearly',
                'payment_date' => 15,
                'start_date' => '2024-03-01',
                'auto_renew' => true,
                'reminder_days' => 7,
                'status' => 'active',
            ],
            [
                'user_id' => $user->id,
                'category_id' => $internet->id,
                'name' => 'IndiHome',
                'description' => 'Internet rumah 100Mbps',
                'amount' => 330000,
                'billing_cycle' => 'monthly',
                'payment_date' => 1,
                'start_date' => '2024-01-01',
                'auto_renew' => true,
                'reminder_days' => 3,
                'status' => 'active',
            ],
            [
                'user_id' => $user->id,
                'category_id' => $software->id,
                'name' => 'Figma',
                'description' => 'Design tool professional',
                'amount' => 192000,
                'billing_cycle' => 'monthly',
                'payment_date' => 15,
                'start_date' => '2024-04-01',
                'auto_renew' => true,
                'reminder_days' => 3,
                'status' => 'active',
            ],
            [
                'user_id' => $user->id,
                'category_id' => $software->id,
                'name' => 'GitHub Pro',
                'description' => 'Code hosting & CI/CD',
                'amount' => 60000,
                'billing_cycle' => 'monthly',
                'payment_date' => 10,
                'start_date' => '2024-05-01',
                'auto_renew' => true,
                'reminder_days' => 3,
                'status' => 'active',
            ],
            [
                'user_id' => $user->id,
                'category_id' => $gaming->id,
                'name' => 'Xbox Game Pass',
                'description' => 'Game subscription',
                'amount' => 169000,
                'billing_cycle' => 'monthly',
                'payment_date' => 20,
                'start_date' => '2024-06-01',
                'auto_renew' => true,
                'reminder_days' => 3,
                'status' => 'active',
            ],
            [
                'user_id' => $user->id,
                'category_id' => $education->id,
                'name' => 'Coursera Plus',
                'description' => 'Online learning platform',
                'amount' => 450000,
                'billing_cycle' => 'monthly',
                'payment_date' => 5,
                'start_date' => '2024-07-01',
                'auto_renew' => false,
                'reminder_days' => 7,
                'status' => 'active',
            ],
        ];

        foreach ($subscriptions as $subData) {
            $sub = Subscription::updateOrCreate(
                ['user_id' => $subData['user_id'], 'name' => $subData['name']],
                $subData
            );

            
            for ($i = 5; $i >= 0; $i--) {
                $payDate = Carbon::now()->subMonths($i)->day(min($sub->payment_date, 28));
                PaymentHistory::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'subscription_id' => $sub->id,
                        'payment_date' => $payDate->format('Y-m-d'),
                    ],
                    [
                        'amount' => $sub->amount,
                        'status' => 'paid',
                        'note' => 'Pembayaran otomatis terverifikasi sistem',
                    ]
                );
            }
        }
    }
}

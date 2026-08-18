<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            SubscriptionsTableSeeder::class,
            PaymentHistoriesTableSeeder::class,
            NotificationsTableSeeder::class,
            FriendshipsTableSeeder::class,
            SubscriptionSharesTableSeeder::class,
        ]);
    }
}

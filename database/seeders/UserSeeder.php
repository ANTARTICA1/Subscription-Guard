<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@tatagih.app'],
            [
                'name' => 'Admin Tatagih',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'timezone' => 'Asia/Jakarta',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@tatagih.app'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
                'role' => 'user',
                'timezone' => 'Asia/Jakarta',
            ]
        );
    }
}

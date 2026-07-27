<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Entertainment', 'icon' => '🎬', 'color' => '#ef4444'],
            ['name' => 'Internet', 'icon' => '🌐', 'color' => '#3b82f6'],
            ['name' => 'Education', 'icon' => '📚', 'color' => '#10b981'],
            ['name' => 'Housing', 'icon' => '🏠', 'color' => '#f59e0b'],
            ['name' => 'Gaming', 'icon' => '🎮', 'color' => '#8b5cf6'],
            ['name' => 'Software', 'icon' => '💻', 'color' => '#06b6d4'],
            ['name' => 'Health', 'icon' => '🏥', 'color' => '#ec4899'],
            ['name' => 'Other', 'icon' => '📦', 'color' => '#6b7280'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['name' => $category['name']], $category);
        }
    }
}

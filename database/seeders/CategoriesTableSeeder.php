<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Entertainment',
                'icon' => '🎬',
                'color' => '#ef4444',
                'created_at' => '2026-07-26 14:48:39',
                'updated_at' => '2026-07-26 14:48:39',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Internet',
                'icon' => '🌐',
                'color' => '#3b82f6',
                'created_at' => '2026-07-26 14:48:39',
                'updated_at' => '2026-07-26 14:48:39',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Education',
                'icon' => '📚',
                'color' => '#10b981',
                'created_at' => '2026-07-26 14:48:39',
                'updated_at' => '2026-07-26 14:48:39',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Housing',
                'icon' => '🏠',
                'color' => '#f59e0b',
                'created_at' => '2026-07-26 14:48:39',
                'updated_at' => '2026-07-26 14:48:39',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Gaming',
                'icon' => '🎮',
                'color' => '#8b5cf6',
                'created_at' => '2026-07-26 14:48:39',
                'updated_at' => '2026-07-26 14:48:39',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Software',
                'icon' => '💻',
                'color' => '#06b6d4',
                'created_at' => '2026-07-26 14:48:39',
                'updated_at' => '2026-07-26 14:48:39',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Health',
                'icon' => '🏥',
                'color' => '#ec4899',
                'created_at' => '2026-07-26 14:48:39',
                'updated_at' => '2026-07-26 14:48:39',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Other',
                'icon' => '📦',
                'color' => '#6b7280',
                'created_at' => '2026-07-26 14:48:39',
                'updated_at' => '2026-07-26 14:48:39',
            ),
        ));
        
        
    }
}
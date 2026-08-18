<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FriendshipsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('friendships')->delete();
        
        \DB::table('friendships')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 3,
                'friend_id' => 4,
                'status' => 'accepted',
                'created_at' => '2026-07-27 12:06:53',
                'updated_at' => '2026-07-27 12:06:53',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 2,
                'friend_id' => 4,
                'status' => 'accepted',
                'created_at' => '2026-08-18 11:21:30',
                'updated_at' => '2026-08-18 11:21:30',
            ),
        ));
        
        
    }
}
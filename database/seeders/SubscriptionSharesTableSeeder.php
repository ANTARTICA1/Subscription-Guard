<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubscriptionSharesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('subscription_shares')->delete();
        
        \DB::table('subscription_shares')->insert(array (
            0 => 
            array (
                'id' => 10,
                'subscription_id' => 14,
                'owner_id' => 3,
                'friend_user_id' => 4,
                'friend_name' => 'Artha',
                'split_amount' => '54500.00',
                'payment_proof_path' => NULL,
                'payment_status' => 'pending',
                'due_date' => '2026-08-01',
                'created_at' => '2026-07-29 08:40:16',
                'updated_at' => '2026-07-29 08:40:16',
            ),
            1 => 
            array (
                'id' => 12,
                'subscription_id' => 24,
                'owner_id' => 3,
                'friend_user_id' => 4,
                'friend_name' => 'Artha',
                'split_amount' => '19500.00',
                'payment_proof_path' => NULL,
                'payment_status' => 'pending',
                'due_date' => '2026-08-19',
                'created_at' => '2026-08-16 10:15:11',
                'updated_at' => '2026-08-16 10:15:11',
            ),
            2 => 
            array (
                'id' => 13,
                'subscription_id' => 15,
                'owner_id' => 3,
                'friend_user_id' => 4,
                'friend_name' => 'Artha',
                'split_amount' => '18000.00',
                'payment_proof_path' => NULL,
                'payment_status' => 'pending',
                'due_date' => '2026-08-29',
                'created_at' => '2026-08-16 10:27:00',
                'updated_at' => '2026-08-18 11:19:14',
            ),
            3 => 
            array (
                'id' => 14,
                'subscription_id' => 15,
                'owner_id' => 3,
                'friend_user_id' => 2,
                'friend_name' => 'Demo User',
                'split_amount' => '18000.00',
                'payment_proof_path' => NULL,
                'payment_status' => 'pending',
                'due_date' => '2026-08-29',
                'created_at' => '2026-08-18 11:19:14',
                'updated_at' => '2026-08-18 11:19:14',
            ),
            4 => 
            array (
                'id' => 15,
                'subscription_id' => 30,
                'owner_id' => 2,
                'friend_user_id' => 4,
                'friend_name' => 'Artha',
                'split_amount' => '84500.00',
                'payment_proof_path' => NULL,
                'payment_status' => 'pending',
                'due_date' => '2026-09-11',
                'created_at' => '2026-08-18 11:28:12',
                'updated_at' => '2026-08-18 11:28:12',
            ),
        ));
        
        
    }
}
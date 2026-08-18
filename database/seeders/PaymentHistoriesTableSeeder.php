<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PaymentHistoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('payment_histories')->delete();
        
        \DB::table('payment_histories')->insert(array (
            0 => 
            array (
                'id' => 55,
                'user_id' => 3,
                'subscription_id' => 14,
                'amount' => '109000.00',
                'payment_date' => '2026-07-28',
                'status' => 'paid',
                'note' => 'Pembayaran dikonfirmasi via Quick Action',
                'created_at' => '2026-07-28 02:25:46',
                'updated_at' => '2026-07-28 02:25:46',
            ),
            1 => 
            array (
                'id' => 56,
                'user_id' => 3,
                'subscription_id' => 14,
                'amount' => '109000.00',
                'payment_date' => '2026-07-30',
                'status' => 'paid',
                'note' => 'Pembayaran dikonfirmasi via Quick Action',
                'created_at' => '2026-07-30 03:30:55',
                'updated_at' => '2026-07-30 03:30:55',
            ),
            2 => 
            array (
                'id' => 57,
                'user_id' => 3,
                'subscription_id' => 14,
                'amount' => '109000.00',
                'payment_date' => '2026-07-30',
                'status' => 'paid',
                'note' => 'Pembayaran dikonfirmasi via Quick Action',
                'created_at' => '2026-07-30 03:31:17',
                'updated_at' => '2026-07-30 03:31:17',
            ),
            3 => 
            array (
                'id' => 58,
                'user_id' => 3,
                'subscription_id' => 14,
                'amount' => '12.00',
                'payment_date' => '2026-08-03',
                'status' => 'paid',
                'note' => NULL,
                'created_at' => '2026-08-03 00:11:29',
                'updated_at' => '2026-08-03 00:11:29',
            ),
            4 => 
            array (
                'id' => 59,
                'user_id' => 3,
                'subscription_id' => 17,
                'amount' => '1222222.00',
                'payment_date' => '2026-08-03',
                'status' => 'paid',
                'note' => NULL,
                'created_at' => '2026-08-03 00:13:17',
                'updated_at' => '2026-08-03 00:13:17',
            ),
            5 => 
            array (
                'id' => 60,
                'user_id' => 3,
                'subscription_id' => 24,
                'amount' => '39000.00',
                'payment_date' => '2026-08-16',
                'status' => 'paid',
                'note' => 'Pembayaran dikonfirmasi via Quick Action',
                'created_at' => '2026-08-16 09:46:44',
                'updated_at' => '2026-08-16 09:46:44',
            ),
            6 => 
            array (
                'id' => 61,
                'user_id' => 6,
                'subscription_id' => 25,
                'amount' => '24990.00',
                'payment_date' => '2026-08-16',
                'status' => 'paid',
                'note' => NULL,
                'created_at' => '2026-08-16 10:51:22',
                'updated_at' => '2026-08-16 10:51:22',
            ),
            7 => 
            array (
                'id' => 62,
                'user_id' => 6,
                'subscription_id' => 25,
                'amount' => '24990.00',
                'payment_date' => '2026-08-16',
                'status' => 'paid',
                'note' => 'Pembayaran dikonfirmasi via Quick Action',
                'created_at' => '2026-08-16 10:55:42',
                'updated_at' => '2026-08-16 10:55:42',
            ),
            8 => 
            array (
                'id' => 65,
                'user_id' => 2,
                'subscription_id' => 33,
                'amount' => '120000.00',
                'payment_date' => '2026-08-18',
                'status' => 'paid',
                'note' => 'Pembayaran dikonfirmasi via Quick Action',
                'created_at' => '2026-08-18 11:40:08',
                'updated_at' => '2026-08-18 11:40:08',
            ),
            9 => 
            array (
                'id' => 66,
                'user_id' => 2,
                'subscription_id' => 32,
                'amount' => '75000.00',
                'payment_date' => '2026-08-18',
                'status' => 'paid',
                'note' => 'Pembayaran dikonfirmasi via Quick Action',
                'created_at' => '2026-08-18 11:40:27',
                'updated_at' => '2026-08-18 11:40:27',
            ),
            10 => 
            array (
                'id' => 67,
                'user_id' => 2,
                'subscription_id' => 34,
                'amount' => '99000.00',
                'payment_date' => '2026-08-18',
                'status' => 'paid',
                'note' => 'Pembayaran dikonfirmasi via Quick Action',
                'created_at' => '2026-08-18 11:42:24',
                'updated_at' => '2026-08-18 11:42:24',
            ),
            11 => 
            array (
                'id' => 68,
                'user_id' => 2,
                'subscription_id' => 34,
                'amount' => '99000.00',
                'payment_date' => '2026-08-18',
                'status' => 'paid',
                'note' => 'Pembayaran dikonfirmasi via Quick Action',
                'created_at' => '2026-08-18 11:42:26',
                'updated_at' => '2026-08-18 11:42:26',
            ),
        ));
        
        
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
{

    public function run()
    {

        \DB::table('notifications')->delete();

    }
}
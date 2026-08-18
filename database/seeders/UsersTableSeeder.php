<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_tag' => NULL,
                'name' => 'Admin Tatagih',
                'email' => 'admin@tatagih.app',
                'email_verified_at' => NULL,
                'password' => '$2y$12$JmGXNfiqiRCYnTjVGVz.V.aUJ51MB4ZkyCwbZUf7YlLMY.wQESfPu',
                'avatar' => NULL,
                'telegram_chat_id' => NULL,
                'timezone' => 'Asia/Jakarta',
                'role' => 'admin',
                'remember_token' => NULL,
                'created_at' => '2026-07-26 14:48:40',
                'updated_at' => '2026-07-26 15:22:09',
            ),
            1 => 
            array (
                'id' => 2,
                'user_tag' => NULL,
                'name' => 'Demo User',
                'email' => 'user@tatagih.app',
                'email_verified_at' => NULL,
                'password' => '$2y$12$bTt0VW0Ya0PCyifCykR3I.Xu/qj01XTxQ0MmUWQn7srd1uFyRp8V6',
                'avatar' => NULL,
                'telegram_chat_id' => NULL,
                'timezone' => 'Asia/Jakarta',
                'role' => 'user',
                'remember_token' => NULL,
                'created_at' => '2026-07-26 14:48:40',
                'updated_at' => '2026-07-26 15:22:09',
            ),
            2 => 
            array (
                'id' => 3,
                'user_tag' => 'TAG-TLTPB7',
                'name' => 'Geka',
                'email' => 'anakagungarthawibawa22@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$jP1pJg4bkMs1y9OU2gTMiOdmO3agNFDniyuFqv/uLdfJ/VjRanS6a',
                'avatar' => 'avatars/C1OtqYn4HxbuhqsHCIn7f0RKyd5yq447MLOmvs46.jpg',
                'telegram_chat_id' => '1121898124',
                'timezone' => 'Asia/Jakarta',
                'role' => 'user',
                'remember_token' => 'OhsRrOwdyJ5YXcCKmdQIdEWJWL8BoeYZrU37qy0YvL03ISYiP4WGfjSGxSSv',
                'created_at' => '2026-07-27 04:21:55',
                'updated_at' => '2026-08-15 03:46:19',
            ),
            3 => 
            array (
                'id' => 4,
                'user_tag' => 'TAG-APSZ6Y',
                'name' => 'Artha',
                'email' => 'gekaartha@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$w0Gaw7ycDh18XoXU86iG/eqQFV6ceMcJakXHQVJCfOdY.RBs7S9tC',
                'avatar' => NULL,
                'telegram_chat_id' => NULL,
                'timezone' => 'Asia/Jakarta',
                'role' => 'user',
                'remember_token' => NULL,
                'created_at' => '2026-07-27 12:05:44',
                'updated_at' => '2026-07-29 05:17:14',
            ),
            4 => 
            array (
                'id' => 5,
                'user_tag' => 'TAG-2F6ZYH',
                'name' => 'Artha Wibawa',
                'email' => 'kresnaartha3@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$3ANagwTHYWD/qGD0kVEzcujPszoYEzoOP09IksGiPBNvqaY/RisqW',
                'avatar' => NULL,
                'telegram_chat_id' => NULL,
                'timezone' => 'Asia/Jakarta',
                'role' => 'user',
                'remember_token' => 'JtcE5CWGknO4mCVLjCfG1nQGPdWAbGlScVaA7QnENxh6LoZ4EeP1eKBTqX6j',
                'created_at' => '2026-08-14 13:36:51',
                'updated_at' => '2026-08-14 13:38:21',
            ),
            5 => 
            array (
                'id' => 6,
                'user_tag' => 'TAG-HXLJN1',
                'name' => 'Krisna',
                'email' => 'krisnaartha3@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$pDP0CTCKCMVtTaQz4tJ8H.rJ8TUNBY4w0qsCykhejSeSgJGUtDhie',
                'avatar' => NULL,
                'telegram_chat_id' => NULL,
                'timezone' => 'Asia/Jakarta',
                'role' => 'user',
                'remember_token' => NULL,
                'created_at' => '2026-08-16 10:19:39',
                'updated_at' => '2026-08-16 10:19:39',
            ),
        ));
        
        
    }
}
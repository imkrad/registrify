<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
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
                'username' => 'administrator',
                'email' => 'registrify@admin.com',
                'password' => '$2y$12$/yNP2jb68Ko.ubv7EVozkOc6MoVYGdjJA2D4yvQ6TUd0IuVnktwxG',
                'role' => 'Administrator',
                'is_active' => 1,
                'is_new' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => '2024-05-15 08:46:33',
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2024-09-01 22:12:52',
                'updated_at' => '2024-09-01 22:12:52',
            ),
            1 => 
            array (
                'id' => 2,
                'username' => 'RUserss',
                'email' => 'registrar@gmail.com',
                'password' => '$2y$12$ML0kxo2t9Q97Eu3VPKWOyuVx4R.LXUG/TqPIzI6q6JBQdBsQT.fjK',
                'role' => 'Registrar',
                'is_active' => 1,
                'is_new' => 0,
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'email_verified_at' => '2024-10-11 10:10:41',
                'password_changed_at' => NULL,
                'two_factor_confirmed_at' => NULL,
                'created_at' => '2024-10-11 10:10:18',
                'updated_at' => '2024-10-11 10:10:18',
            ),
        ));

        
    }
}
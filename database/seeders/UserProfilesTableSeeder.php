<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserProfilesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_profiles')->delete();
        
        \DB::table('user_profiles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'firstname' => 'Prince Salman',
                'lastname' => 'Cabirss',
                'middlename' => 'M',
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09123456789',
                'avatar' => 'avatar.jpg',
                'user_id' => 1,
                'created_at' => '2024-09-01 22:12:52',
                'updated_at' => '2024-10-09 20:03:36',
            ),
            1 => 
            array (
                'id' => 2,
                'firstname' => 'Registrar',
                'lastname' => 'Testuser',
                'middlename' => 'A',
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09123456987',
                'avatar' => 'avatar',
                'user_id' => 2,
                'created_at' => '2024-10-09 20:07:01',
                'updated_at' => '2024-10-09 20:07:01',
            )
        ));

        
    }
}
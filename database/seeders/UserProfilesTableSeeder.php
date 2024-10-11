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
        

        \DB::table('user_profiles')->truncate();
        
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
                'id' => 5,
                'firstname' => 'Receiver',
                'lastname' => 'User',
                'middlename' => 'A',
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09123456987',
                'avatar' => 'avatar',
                'user_id' => 8,
                'created_at' => '2024-10-09 20:07:01',
                'updated_at' => '2024-10-09 20:07:01',
            ),
            2 => 
            array (
                'id' => 6,
                'firstname' => 'Processor',
                'lastname' => 'User',
                'middlename' => 'C',
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09123654456',
                'avatar' => 'avatar',
                'user_id' => 9,
                'created_at' => '2024-10-09 20:07:29',
                'updated_at' => '2024-10-09 20:07:29',
            ),
            3 => 
            array (
                'id' => 7,
                'firstname' => 'Releaser',
                'lastname' => 'Users',
                'middlename' => 'D',
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09123321123',
                'avatar' => 'avatar',
                'user_id' => 14,
                'created_at' => '2024-10-09 20:08:34',
                'updated_at' => '2024-10-09 20:08:34',
            ),
            4 => 
            array (
                'id' => 8,
                'firstname' => 'User',
                'lastname' => 'Cashier',
                'middlename' => 'D',
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09123456987',
                'avatar' => 'avatar',
                'user_id' => 15,
                'created_at' => '2024-10-11 09:53:29',
                'updated_at' => '2024-10-11 09:53:29',
            ),
            5 => 
            array (
                'id' => 9,
                'firstname' => 'Registrar',
                'lastname' => 'Userss',
                'middlename' => 'A',
                'suffix' => NULL,
                'gender' => 'Male',
                'mobile' => '09123654456',
                'avatar' => 'avatar',
                'user_id' => 17,
                'created_at' => '2024-10-11 10:10:18',
                'updated_at' => '2024-10-11 10:10:18',
            ),
        ));

        
    }
}
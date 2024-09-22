<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListStatusesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_statuses')->delete();
        
        \DB::table('list_statuses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Pending',
                'type' => 'Student',
                'color' => 'bg-warning',
                'others' => 'text-warning',
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Confirmed',
                'type' => 'Student',
                'color' => 'bg-success',
                'others' => 'text-success',
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
            2 => 
            array (
                'id' => 5,
                'name' => 'Pending',
                'type' => 'Request',
                'color' => 'bg-warning',
                'others' => 'text-warning',
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
            3 => 
            array (
                'id' => 6,
                'name' => 'Ongoing',
                'type' => 'Request',
                'color' => 'bg-info',
                'others' => 'text-info',
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
            4 => 
            array (
                'id' => 7,
                'name' => 'Completed',
                'type' => 'Request',
                'color' => 'bg-success',
                'others' => 'text-success',
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
        ));

        
    }
}
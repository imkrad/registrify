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
            5 => 
            array (
                'id' => 8,
                'name' => 'Unpaid',
                'type' => 'Payment',
                'color' => 'bg-danger-subtle',
                'others' => 'text-danger',
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
            6 => 
            array (
                'id' => 9,
                'name' => 'Paid',
                'type' => 'Payment',
                'color' => 'bg-success-subtle',
                'others' => 'text-success',
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
            7 => 
            array (
                'id' => 10,
                'name' => 'Pending',
                'type' => 'Document',
                'color' => 'bg-warning',
                'others' => 'text-warning',
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
            8 => 
            array (
                'id' => 11,
                'name' => 'Ongoing',
                'type' => 'Document',
                'color' => 'bg-info',
                'others' => 'text-info',
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
            9 => 
            array (
                'id' => 12,
                'name' => 'Completed',
                'type' => 'Document',
                'color' => 'bg-success',
                'others' => 'text-success',
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
            10 => 
            array (
                'id' => 13,
                'name' => 'Confirmed',
                'type' => 'Request',
                'color' => 'bg-dark',
                'others' => 'text-dark',
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
            11 => 
            array (
                'id' => 14,
                'name' => 'Released',
                'type' => 'Request',
                'color' => 'bg-light',
                'others' => 'text-light',
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
            12 => 
            array (
                'id' => 15,
                'name' => 'For Review',
                'type' => 'Student',
                'color' => 'bg-info',
                'others' => 'text-info',
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
        ));

        
    }
}
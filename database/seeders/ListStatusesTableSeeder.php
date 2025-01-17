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
                'step' => 0,
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
                'step' => 0,
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
                'step' => 1,
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
            3 => 
            array (
                'id' => 6,
                'name' => 'Confirmed',
                'type' => 'Request',
                'color' => 'bg-dark',
                'others' => 'text-dark',
                'step' => 2,
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
            4 => 
            array (
                'id' => 7,
                'name' => 'Processing',
                'type' => 'Request',
                'color' => 'bg-info',
                'others' => 'text-info',
                'step' => 4,
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
                'step' => 0,
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
                'step' => 0,
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
                'step' => 0,
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
                'step' => 0,
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
                'step' => 0,
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
            10 => 
            array (
                'id' => 13,
                'name' => 'Completed',
                'type' => 'Request',
                'color' => 'bg-success',
                'others' => 'text-success',
                'step' => 5,
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
            11 => 
            array (
                'id' => 14,
                'name' => 'Released',
                'type' => 'Request',
                'color' => 'bg-primary',
                'others' => 'text-primary',
                'step' => 6,
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
                'step' => 0,
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
            13 => 
            array (
                'id' => 16,
                'name' => 'Waiting',
                'type' => 'Request',
                'color' => 'bg-danger',
                'others' => 'text-dark',
                'step' => 3,
                'is_active' => 1,
                'created_at' => '2024-08-18 15:57:50',
                'updated_at' => '2024-08-18 15:57:50',
            ),
        ));

        
    }
}
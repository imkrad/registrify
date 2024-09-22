<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('documents')->delete();
        
        \DB::table('documents')->insert(array (
            0 => 
            array (
                'id' => 1,
                'is_perpage' => 1,
                'name_id' => 1,
                'type_id' => 2,
                'is_primary' => 1,
                'created_at' => '2024-09-01 21:40:36',
                'updated_at' => '2024-09-01 21:40:36',
            ),
            1 => 
            array (
                'id' => 2,
                'is_perpage' => 1,
                'name_id' => 2,
                'type_id' => 2,
                'is_primary' => 1,
                'created_at' => '2024-09-01 21:40:56',
                'updated_at' => '2024-09-01 21:40:56',
            ),
            2 => 
            array (
                'id' => 3,
                'is_perpage' => 1,
                'name_id' => 3,
                'type_id' => 2,
                'is_primary' => 1,
                'created_at' => '2024-09-01 21:41:13',
                'updated_at' => '2024-09-01 21:41:13',
            ),
            3 => 
            array (
                'id' => 4,
                'is_perpage' => 0,
                'name_id' => 4,
                'type_id' => 2,
                'is_primary' => 1,
                'created_at' => '2024-09-01 21:41:38',
                'updated_at' => '2024-09-01 21:41:38',
            ),
            4 => 
            array (
                'id' => 5,
                'is_perpage' => 1,
                'name_id' => 5,
                'type_id' => 2,
                'is_primary' => 1,
                'created_at' => '2024-09-01 21:41:54',
                'updated_at' => '2024-09-01 21:41:54',
            ),
            5 => 
            array (
                'id' => 6,
                'is_perpage' => 0,
                'name_id' => 6,
                'type_id' => 2,
                'is_primary' => 1,
                'created_at' => '2024-09-01 21:44:06',
                'updated_at' => '2024-09-01 21:44:06',
            ),
            6 => 
            array (
                'id' => 7,
                'is_perpage' => 0,
                'name_id' => 7,
                'type_id' => 2,
                'is_primary' => 0,
                'created_at' => '2024-09-01 21:44:24',
                'updated_at' => '2024-09-01 21:44:24',
            ),
            7 => 
            array (
                'id' => 8,
                'is_perpage' => 0,
                'name_id' => 8,
                'type_id' => 2,
                'is_primary' => 0,
                'created_at' => '2024-09-01 21:44:47',
                'updated_at' => '2024-09-01 21:44:47',
            ),
            8 => 
            array (
                'id' => 9,
                'is_perpage' => 0,
                'name_id' => 9,
                'type_id' => 2,
                'is_primary' => 0,
                'created_at' => '2024-09-01 21:45:14',
                'updated_at' => '2024-09-01 21:45:14',
            ),
            9 => 
            array (
                'id' => 10,
                'is_perpage' => 0,
                'name_id' => 10,
                'type_id' => 2,
                'is_primary' => 0,
                'created_at' => '2024-09-01 21:45:32',
                'updated_at' => '2024-09-01 21:45:32',
            ),
            10 => 
            array (
                'id' => 11,
                'is_perpage' => 0,
                'name_id' => 11,
                'type_id' => 2,
                'is_primary' => 0,
                'created_at' => '2024-09-01 21:45:49',
                'updated_at' => '2024-09-01 21:45:49',
            ),
            11 => 
            array (
                'id' => 12,
                'is_perpage' => 1,
                'name_id' => 13,
                'type_id' => 2,
                'is_primary' => 0,
                'created_at' => '2024-09-01 21:46:11',
                'updated_at' => '2024-09-01 21:46:11',
            ),
            12 => 
            array (
                'id' => 13,
                'is_perpage' => 1,
                'name_id' => 1,
                'type_id' => 3,
                'is_primary' => 1,
                'created_at' => '2024-09-01 21:46:36',
                'updated_at' => '2024-09-01 21:46:36',
            ),
            13 => 
            array (
                'id' => 14,
                'is_perpage' => 1,
                'name_id' => 2,
                'type_id' => 3,
                'is_primary' => 1,
                'created_at' => '2024-09-01 21:46:53',
                'updated_at' => '2024-09-01 21:46:53',
            ),
            14 => 
            array (
                'id' => 15,
                'is_perpage' => 0,
                'name_id' => 3,
                'type_id' => 3,
                'is_primary' => 1,
                'created_at' => '2024-09-01 21:47:05',
                'updated_at' => '2024-09-01 21:47:05',
            ),
            15 => 
            array (
                'id' => 16,
                'is_perpage' => 1,
                'name_id' => 4,
                'type_id' => 3,
                'is_primary' => 1,
                'created_at' => '2024-09-01 21:47:21',
                'updated_at' => '2024-09-01 21:47:21',
            ),
            16 => 
            array (
                'id' => 17,
                'is_perpage' => 1,
                'name_id' => 5,
                'type_id' => 3,
                'is_primary' => 1,
                'created_at' => '2024-09-01 21:47:42',
                'updated_at' => '2024-09-01 21:47:42',
            ),
            17 => 
            array (
                'id' => 18,
                'is_perpage' => 0,
                'name_id' => 6,
                'type_id' => 3,
                'is_primary' => 1,
                'created_at' => '2024-09-01 21:47:58',
                'updated_at' => '2024-09-01 21:47:58',
            ),
        ));

        
    }
}
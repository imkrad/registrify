<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DocumentFeesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('document_fees')->delete();
        
        \DB::table('document_fees')->insert(array (
            0 => 
            array (
                'id' => 1,
                'fee' => '120.00',
                'type_id' => 4,
                'document_id' => 1,
                'created_at' => '2024-09-01 21:40:36',
                'updated_at' => '2024-09-01 21:40:36',
            ),
            1 => 
            array (
                'id' => 2,
                'fee' => '200.00',
                'type_id' => 5,
                'document_id' => 1,
                'created_at' => '2024-09-01 21:40:36',
                'updated_at' => '2024-09-01 21:40:36',
            ),
            2 => 
            array (
                'id' => 3,
                'fee' => '100.00',
                'type_id' => 4,
                'document_id' => 2,
                'created_at' => '2024-09-01 21:40:56',
                'updated_at' => '2024-09-01 21:40:56',
            ),
            3 => 
            array (
                'id' => 4,
                'fee' => '180.00',
                'type_id' => 5,
                'document_id' => 2,
                'created_at' => '2024-09-01 21:40:56',
                'updated_at' => '2024-09-01 21:40:56',
            ),
            4 => 
            array (
                'id' => 5,
                'fee' => '1500.00',
                'type_id' => 4,
                'document_id' => 3,
                'created_at' => '2024-09-01 21:41:13',
                'updated_at' => '2024-09-01 21:41:13',
            ),
            5 => 
            array (
                'id' => 6,
                'fee' => '0.00',
                'type_id' => 5,
                'document_id' => 3,
                'created_at' => '2024-09-01 21:41:13',
                'updated_at' => '2024-09-01 21:41:13',
            ),
            6 => 
            array (
                'id' => 7,
                'fee' => '100.00',
                'type_id' => 4,
                'document_id' => 4,
                'created_at' => '2024-09-01 21:41:38',
                'updated_at' => '2024-09-01 21:41:38',
            ),
            7 => 
            array (
                'id' => 8,
                'fee' => '180.00',
                'type_id' => 5,
                'document_id' => 4,
                'created_at' => '2024-09-01 21:41:38',
                'updated_at' => '2024-09-01 21:41:38',
            ),
            8 => 
            array (
                'id' => 9,
                'fee' => '25.00',
                'type_id' => 4,
                'document_id' => 5,
                'created_at' => '2024-09-01 21:41:54',
                'updated_at' => '2024-09-01 21:41:54',
            ),
            9 => 
            array (
                'id' => 10,
                'fee' => '0.00',
                'type_id' => 5,
                'document_id' => 5,
                'created_at' => '2024-09-01 21:41:54',
                'updated_at' => '2024-09-01 21:41:54',
            ),
            10 => 
            array (
                'id' => 11,
                'fee' => '300.00',
                'type_id' => 4,
                'document_id' => 6,
                'created_at' => '2024-09-01 21:44:06',
                'updated_at' => '2024-09-01 21:44:06',
            ),
            11 => 
            array (
                'id' => 12,
                'fee' => '300.00',
                'type_id' => 5,
                'document_id' => 6,
                'created_at' => '2024-09-01 21:44:06',
                'updated_at' => '2024-09-01 21:44:06',
            ),
            12 => 
            array (
                'id' => 13,
                'fee' => '2135.00',
                'type_id' => 4,
                'document_id' => 7,
                'created_at' => '2024-09-01 21:44:24',
                'updated_at' => '2024-09-01 21:44:24',
            ),
            13 => 
            array (
                'id' => 14,
                'fee' => '0.00',
                'type_id' => 5,
                'document_id' => 7,
                'created_at' => '2024-09-01 21:44:24',
                'updated_at' => '2024-09-01 21:44:24',
            ),
            14 => 
            array (
                'id' => 15,
                'fee' => '735.00',
                'type_id' => 4,
                'document_id' => 8,
                'created_at' => '2024-09-01 21:44:47',
                'updated_at' => '2024-09-01 21:44:47',
            ),
            15 => 
            array (
                'id' => 16,
                'fee' => '1215.00',
                'type_id' => 5,
                'document_id' => 8,
                'created_at' => '2024-09-01 21:44:47',
                'updated_at' => '2024-09-01 21:44:47',
            ),
            16 => 
            array (
                'id' => 17,
                'fee' => '835.00',
                'type_id' => 4,
                'document_id' => 9,
                'created_at' => '2024-09-01 21:45:14',
                'updated_at' => '2024-09-01 21:45:14',
            ),
            17 => 
            array (
                'id' => 18,
                'fee' => '1370.00',
                'type_id' => 5,
                'document_id' => 9,
                'created_at' => '2024-09-01 21:45:14',
                'updated_at' => '2024-09-01 21:45:14',
            ),
            18 => 
            array (
                'id' => 19,
                'fee' => '2135.00',
                'type_id' => 4,
                'document_id' => 10,
                'created_at' => '2024-09-01 21:45:32',
                'updated_at' => '2024-09-01 21:45:32',
            ),
            19 => 
            array (
                'id' => 20,
                'fee' => '0.00',
                'type_id' => 5,
                'document_id' => 10,
                'created_at' => '2024-09-01 21:45:32',
                'updated_at' => '2024-09-01 21:45:32',
            ),
            20 => 
            array (
                'id' => 21,
                'fee' => '2135.00',
                'type_id' => 4,
                'document_id' => 11,
                'created_at' => '2024-09-01 21:45:49',
                'updated_at' => '2024-09-01 21:45:49',
            ),
            21 => 
            array (
                'id' => 22,
                'fee' => '0.00',
                'type_id' => 5,
                'document_id' => 11,
                'created_at' => '2024-09-01 21:45:49',
                'updated_at' => '2024-09-01 21:45:49',
            ),
            22 => 
            array (
                'id' => 23,
                'fee' => '100.00',
                'type_id' => 4,
                'document_id' => 12,
                'created_at' => '2024-09-01 21:46:11',
                'updated_at' => '2024-09-01 21:46:11',
            ),
            23 => 
            array (
                'id' => 24,
                'fee' => '180.00',
                'type_id' => 5,
                'document_id' => 12,
                'created_at' => '2024-09-01 21:46:11',
                'updated_at' => '2024-09-01 21:46:11',
            ),
            24 => 
            array (
                'id' => 25,
                'fee' => '200.00',
                'type_id' => 4,
                'document_id' => 13,
                'created_at' => '2024-09-01 21:46:36',
                'updated_at' => '2024-09-01 21:46:36',
            ),
            25 => 
            array (
                'id' => 26,
                'fee' => '350.00',
                'type_id' => 5,
                'document_id' => 13,
                'created_at' => '2024-09-01 21:46:36',
                'updated_at' => '2024-09-01 21:46:36',
            ),
            26 => 
            array (
                'id' => 27,
                'fee' => '150.00',
                'type_id' => 4,
                'document_id' => 14,
                'created_at' => '2024-09-01 21:46:53',
                'updated_at' => '2024-09-01 21:46:53',
            ),
            27 => 
            array (
                'id' => 28,
                'fee' => '250.00',
                'type_id' => 5,
                'document_id' => 14,
                'created_at' => '2024-09-01 21:46:53',
                'updated_at' => '2024-09-01 21:46:53',
            ),
            28 => 
            array (
                'id' => 29,
                'fee' => '1500.00',
                'type_id' => 4,
                'document_id' => 15,
                'created_at' => '2024-09-01 21:47:05',
                'updated_at' => '2024-09-01 21:47:05',
            ),
            29 => 
            array (
                'id' => 30,
                'fee' => '0.00',
                'type_id' => 5,
                'document_id' => 15,
                'created_at' => '2024-09-01 21:47:05',
                'updated_at' => '2024-09-01 21:47:05',
            ),
            30 => 
            array (
                'id' => 31,
                'fee' => '150.00',
                'type_id' => 4,
                'document_id' => 16,
                'created_at' => '2024-09-01 21:47:21',
                'updated_at' => '2024-09-01 21:47:21',
            ),
            31 => 
            array (
                'id' => 32,
                'fee' => '250.00',
                'type_id' => 5,
                'document_id' => 16,
                'created_at' => '2024-09-01 21:47:21',
                'updated_at' => '2024-09-01 21:47:21',
            ),
            32 => 
            array (
                'id' => 33,
                'fee' => '25.00',
                'type_id' => 4,
                'document_id' => 17,
                'created_at' => '2024-09-01 21:47:42',
                'updated_at' => '2024-09-01 21:47:42',
            ),
            33 => 
            array (
                'id' => 34,
                'fee' => '0.00',
                'type_id' => 5,
                'document_id' => 17,
                'created_at' => '2024-09-01 21:47:42',
                'updated_at' => '2024-09-01 21:47:42',
            ),
            34 => 
            array (
                'id' => 35,
                'fee' => '300.00',
                'type_id' => 4,
                'document_id' => 18,
                'created_at' => '2024-09-01 21:47:58',
                'updated_at' => '2024-09-01 21:47:58',
            ),
            35 => 
            array (
                'id' => 36,
                'fee' => '300.00',
                'type_id' => 5,
                'document_id' => 18,
                'created_at' => '2024-09-01 21:47:58',
                'updated_at' => '2024-09-01 21:47:58',
            ),
        ));

        
    }
}
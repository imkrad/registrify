<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListNamesTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_names')->delete();
        
        \DB::table('list_names')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Transcript of Records',
                'subname' => NULL,
                'is_document' => 1,
                'is_addon' => 1,
                'is_active' => 1,
                'created_at' => '2024-09-01 13:08:18',
                'updated_at' => '2024-09-01 13:08:18',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Certificate of Graduation',
                'subname' => NULL,
                'is_document' => 1,
                'is_addon' => 1,
                'is_active' => 1,
                'created_at' => '2024-09-01 13:08:18',
                'updated_at' => '2024-09-01 13:08:18',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Diploma',
                'subname' => 'Second Copy',
                'is_document' => 1,
                'is_addon' => 0,
                'is_active' => 1,
                'created_at' => '2024-09-01 13:08:18',
                'updated_at' => '2024-09-01 13:08:18',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Honorable Dismissal',
                'subname' => NULL,
                'is_document' => 1,
                'is_addon' => 1,
                'is_active' => 1,
                'created_at' => '2024-09-01 13:08:18',
                'updated_at' => '2024-09-01 13:08:18',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Authentication',
                'subname' => NULL,
                'is_document' => 1,
                'is_addon' => 1,
                'is_active' => 1,
                'created_at' => '2024-09-01 13:08:18',
                'updated_at' => '2024-09-01 13:08:18',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'CAV - Red Ribbon',
                'subname' => NULL,
                'is_document' => 1,
                'is_addon' => 0,
                'is_active' => 1,
                'created_at' => '2024-09-01 13:08:18',
                'updated_at' => '2024-09-01 13:08:18',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'CGFNS',
                'subname' => NULL,
                'is_document' => 1,
                'is_addon' => 0,
                'is_active' => 1,
                'created_at' => '2024-09-01 13:08:18',
                'updated_at' => '2024-09-01 13:08:18',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'WES',
                'subname' => NULL,
                'is_document' => 1,
                'is_addon' => 0,
                'is_active' => 1,
                'created_at' => '2024-09-01 13:08:18',
                'updated_at' => '2024-09-01 13:08:18',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Certification of Foreign Nursing Education',
                'subname' => 'N2F',
                'is_document' => 1,
                'is_addon' => 0,
                'is_active' => 1,
                'created_at' => '2024-09-01 13:08:18',
                'updated_at' => '2024-09-01 13:08:18',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'National Nursing Assessment Service Form',
                'subname' => 'NNAS',
                'is_document' => 1,
                'is_addon' => 0,
                'is_active' => 1,
                'created_at' => '2024-09-01 13:08:18',
                'updated_at' => '2024-09-01 13:08:18',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'DCA Form',
                'subname' => 'Board of Registered Nursing',
                'is_document' => 1,
                'is_addon' => 0,
                'is_active' => 1,
                'created_at' => '2024-09-01 13:08:18',
                'updated_at' => '2024-09-01 13:08:18',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Document Stamp',
                'subname' => '',
                'is_document' => 0,
                'is_addon' => 1,
                'is_active' => 1,
                'created_at' => '2024-09-01 13:08:18',
                'updated_at' => '2024-09-01 13:08:18',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Other Certifications',
                'subname' => '',
                'is_document' => 1,
                'is_addon' => 0,
                'is_active' => 1,
                'created_at' => '2024-09-01 13:08:18',
                'updated_at' => '2024-09-01 13:08:18',
            ),
        ));

        
    }
}
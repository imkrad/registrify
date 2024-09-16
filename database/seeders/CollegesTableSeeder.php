<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CollegesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('colleges')->delete();
        
        \DB::table('colleges')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'College of Science and Information Technology',
                'acronym' => 'CSIT',
                'is_active' => 1,
                'created_at' => '2023-01-26 15:19:19',
                'updated_at' => '2023-01-26 15:19:19',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'School of Management and Accountancy',
                'acronym' => 'SMA',
                'is_active' => 1,
                'created_at' => '2023-01-26 15:19:19',
                'updated_at' => '2023-01-26 15:19:19',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'College of Nursing',
                'acronym' => 'CON',
                'is_active' => 1,
                'created_at' => '2023-01-26 15:20:34',
                'updated_at' => '2023-01-26 15:20:34',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'School of Education ',
                'acronym' => 'SEd',
                'is_active' => 1,
                'created_at' => '2023-01-26 15:20:34',
                'updated_at' => '2023-01-26 15:20:34',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'School of Liberal Arts',
                'acronym' => 'SLA',
                'is_active' => 1,
                'created_at' => '2023-01-26 15:23:22',
                'updated_at' => '2023-01-26 15:23:24',
            ),
        ));
        
        
    }
}
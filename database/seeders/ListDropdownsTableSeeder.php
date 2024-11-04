<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListDropdownsTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_dropdowns')->delete();
        
        \DB::table('list_dropdowns')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'n/a',
                'classification' => 'n/a',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
                'is_active' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'College Unit',
                'classification' => 'Document Type',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
                'is_active' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Graduate School',
                'classification' => 'Document Type',
                'type' => 'n/a',
                'color' => 'n/a',
                'others' => 'n/a',
                'is_active' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Regular Processing Fee',
                'classification' => 'Fee Type',
                'type' => 'Regular',
                'color' => 'n/a',
                'others' => '5-7 days',
                'is_active' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Express Processing Fee',
                'classification' => 'Fee Type',
                'type' => 'Express',
                'color' => 'n/a',
                'others' => '1-3 days',
                'is_active' => 1,
            ),
        ));

        
    }
}
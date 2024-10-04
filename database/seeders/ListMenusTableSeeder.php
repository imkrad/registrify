<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ListMenusTableSeeder extends Seeder
{
    /**
     * Auto generated seeder file.
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('list_menus')->delete();
        
        \DB::table('list_menus')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Dashboard',
                'icon' => 'ri-apps-line',
                'route' => '/dashboard',
                'path' => 'Dashboard',
                'group' => 'Menu',
                'module' => 'Executive',
                'order' => 1,
                'has_child' => 0,
                'is_mother' => 1,
                'is_active' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Documents',
                'icon' => 'ri-file-text-fill',
                'route' => '/documents',
                'path' => 'Documents',
                'group' => 'Menu',
                'module' => 'Executive',
                'order' => 4,
                'has_child' => 0,
                'is_mother' => 1,
                'is_active' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Requests',
                'icon' => 'ri-git-repository-commits-line',
                'route' => '/requests',
                'path' => 'Requests',
                'group' => 'Menu',
                'module' => 'Executive',
                'order' => 2,
                'has_child' => 0,
                'is_mother' => 1,
                'is_active' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Students',
                'icon' => 'ri-account-circle-fill',
                'route' => '/students',
                'path' => 'Students',
                'group' => 'Menu',
                'module' => 'Executive',
                'order' => 3,
                'has_child' => 0,
                'is_mother' => 1,
                'is_active' => 1,
            ),
        ));

        
    }
}
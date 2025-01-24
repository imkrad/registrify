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
                'icon' => 'ri-team-fill',
                'route' => '/students',
                'path' => 'Students',
                'group' => 'Menu',
                'module' => 'Executive',
                'order' => 3,
                'has_child' => 0,
                'is_mother' => 1,
                'is_active' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Users',
                'icon' => 'ri-account-circle-fill',
                'route' => '/users',
                'path' => 'Users',
                'group' => 'Menu',
                'module' => 'Executive',
                'order' => 5,
                'has_child' => 0,
                'is_mother' => 1,
                'is_active' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Dashboard',
                'icon' => 'ri-apps-line',
                'route' => '/dashboard',
                'path' => 'Dashboard',
                'group' => 'Menu',
                'module' => 'Main',
                'order' => 1,
                'has_child' => 0,
                'is_mother' => 1,
                'is_active' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Requests',
                'icon' => 'ri-git-repository-commits-line',
                'route' => '/requests',
                'path' => 'Requests',
                'group' => 'Menu',
                'module' => 'Main',
                'order' => 2,
                'has_child' => 0,
                'is_mother' => 1,
                'is_active' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Documents',
                'icon' => 'ri-file-text-fill',
                'route' => '/documents',
                'path' => 'Documents',
                'group' => 'Menu',
                'module' => 'Main',
                'order' => 4,
                'has_child' => 0,
                'is_mother' => 1,
                'is_active' => 1,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Students',
                'icon' => 'ri-team-fill',
                'route' => '/students',
                'path' => 'Students',
                'group' => 'Menu',
                'module' => 'Main',
                'order' => 3,
                'has_child' => 0,
                'is_mother' => 1,
                'is_active' => 1,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Onsite',
                'icon' => 'ri-walk-fill',
                'route' => '/onsites',
                'path' => 'Onsites',
                'group' => 'Menu',
                'module' => 'Main',
                'order' => 2,
                'has_child' => 0,
                'is_mother' => 1,
                'is_active' => 1,
            ),
        ));

        
    }
}
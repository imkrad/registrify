<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('courses')->delete();
        
        \DB::table('courses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Bachelor of Science in Information Technology',
                'acronym' => 'BSIT',
                'is_active' => 1,
                'college_id' => 1,
                'created_at' => '2023-01-26 15:24:06',
                'updated_at' => '2023-01-26 15:24:06',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Bachelor of Science in Bio Medical Engineering',
                'acronym' => 'BSBME',
                'is_active' => 1,
                'college_id' => 1,
                'created_at' => '2023-05-04 21:42:21',
                'updated_at' => '2023-05-04 21:42:21',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Bachelor of Science in Computer Science',
                'acronym' => 'BSCS',
                'is_active' => 1,
                'college_id' => 1,
                'created_at' => '2023-05-04 21:42:38',
                'updated_at' => '2023-05-04 21:42:38',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Bachelor of Science in Computer Engineering',
                'acronym' => 'BSCoE',
                'is_active' => 1,
                'college_id' => 1,
                'created_at' => '2023-05-04 21:42:47',
                'updated_at' => '2023-05-04 21:42:47',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Bachelor of Science in Electronics Communications Engineering',
                'acronym' => 'BSECE',
                'is_active' => 1,
                'college_id' => 1,
                'created_at' => '2023-05-04 21:42:56',
                'updated_at' => '2023-05-04 21:42:56',
            ),
            5 => 
            array (
                'id' => 7,
                'name' => 'Bachelor of Science in New Media & Computer Animation',
                'acronym' => 'BSNMCA',
                'is_active' => 1,
                'college_id' => 1,
                'created_at' => '2023-05-04 21:43:03',
                'updated_at' => '2023-05-04 21:43:03',
            ),
            6 => 
            array (
                'id' => 8,
                'name' => 'Associate in Electronics Engineering Technology',
                'acronym' => 'AEET',
                'is_active' => 1,
                'college_id' => 1,
                'created_at' => '2023-05-04 21:43:12',
                'updated_at' => '2023-05-04 21:43:12',
            ),
            7 => 
            array (
                'id' => 9,
                'name' => 'Bachelor of Science in Biology',
                'acronym' => 'BSBio',
                'is_active' => 1,
                'college_id' => 1,
                'created_at' => '2023-05-04 21:43:21',
                'updated_at' => '2023-05-04 21:43:21',
            ),
            8 => 
            array (
                'id' => 10,
                'name' => 'Bachelor of Science in Mathematics',
                'acronym' => 'BSMath',
                'is_active' => 1,
                'college_id' => 1,
                'created_at' => '2023-05-04 21:43:28',
                'updated_at' => '2023-05-04 21:43:28',
            ),
            9 => 
            array (
                'id' => 11,
                'name' => 'Bachelor of Science in Statistics',
                'acronym' => 'BS STAT',
                'is_active' => 1,
                'college_id' => 1,
                'created_at' => '2023-05-04 21:43:35',
                'updated_at' => '2023-05-04 21:43:35',
            ),
            10 => 
            array (
                'id' => 12,
                'name' => 'Bachelor of Science in Office Administration',
                'acronym' => 'BSOA',
                'is_active' => 1,
                'college_id' => 2,
                'created_at' => '2023-05-04 21:43:43',
                'updated_at' => '2023-05-04 21:43:43',
            ),
            11 => 
            array (
                'id' => 13,
                'name' => 'Bachelor of Science in Managment Accounting',
                'acronym' => 'BSMA',
                'is_active' => 1,
                'college_id' => 2,
                'created_at' => '2023-05-04 21:43:52',
                'updated_at' => '2023-05-04 21:43:52',
            ),
            12 => 
            array (
                'id' => 14,
                'name' => 'Bachelor of Science in Accountancy',
                'acronym' => 'BSAc',
                'is_active' => 1,
                'college_id' => 2,
                'created_at' => '2023-05-04 21:43:59',
                'updated_at' => '2023-05-04 21:43:59',
            ),
            13 => 
            array (
                'id' => 15,
                'name' => 'Bachelor of Science in Business Administration',
                'acronym' => 'BSBA',
                'is_active' => 1,
                'college_id' => 2,
                'created_at' => '2023-05-04 21:44:07',
                'updated_at' => '2023-05-04 21:44:07',
            ),
            14 => 
            array (
                'id' => 16,
                'name' => 'Bachelor of Science in Internal Auditing',
                'acronym' => 'BSIA',
                'is_active' => 1,
                'college_id' => 2,
                'created_at' => '2023-05-04 21:44:14',
                'updated_at' => '2023-05-04 21:44:14',
            ),
            15 => 
            array (
                'id' => 17,
                'name' => 'Bachelor of Science in Nursing',
                'acronym' => 'BSN',
                'is_active' => 1,
                'college_id' => 3,
                'created_at' => '2023-05-04 21:44:23',
                'updated_at' => '2023-05-04 21:44:23',
            ),
            16 => 
            array (
                'id' => 18,
                'name' => 'Bachelor of Arts in Interdisciplinary Studies',
                'acronym' => 'BA INDIS',
                'is_active' => 1,
                'college_id' => 5,
                'created_at' => '2023-05-04 21:44:30',
                'updated_at' => '2023-05-04 21:44:30',
            ),
            17 => 
            array (
                'id' => 19,
                'name' => 'Bachelor of Arts in English',
                'acronym' => 'BA ELS',
                'is_active' => 1,
                'college_id' => 5,
                'created_at' => '2023-05-04 21:44:37',
                'updated_at' => '2023-05-04 21:44:37',
            ),
            18 => 
            array (
                'id' => 20,
                'name' => 'Bachelor of Arts in Communication',
                'acronym' => 'BA Comm',
                'is_active' => 1,
                'college_id' => 5,
                'created_at' => '2023-05-04 21:45:36',
                'updated_at' => '2023-05-04 21:45:36',
            ),
            19 => 
            array (
                'id' => 21,
                'name' => 'Bachelor of Arts in International Studies',
                'acronym' => 'BA INTS',
                'is_active' => 1,
                'college_id' => 5,
                'created_at' => '2023-05-04 21:45:30',
                'updated_at' => '2023-05-04 21:45:30',
            ),
            20 => 
            array (
                'id' => 22,
                'name' => 'Bachelor of Arts in Philosophy',
                'acronym' => 'BA PHILO',
                'is_active' => 1,
                'college_id' => 5,
                'created_at' => '2023-05-04 21:45:23',
                'updated_at' => '2023-05-04 21:45:23',
            ),
            21 => 
            array (
                'id' => 23,
                'name' => 'Bachelor of Science in Psychology',
                'acronym' => 'BS PSY',
                'is_active' => 1,
                'college_id' => 5,
                'created_at' => '2023-05-04 21:45:16',
                'updated_at' => '2023-05-04 21:45:16',
            ),
            22 => 
            array (
                'id' => 24,
                'name' => 'Bachelor of Arts in Economics',
                'acronym' => 'BA ECON',
                'is_active' => 1,
                'college_id' => 5,
                'created_at' => '2023-05-04 21:45:08',
                'updated_at' => '2023-05-04 21:45:08',
            ),
            23 => 
            array (
                'id' => 25,
                'name' => 'Bachelor of Elementary Education',
                'acronym' => 'BEEd',
                'is_active' => 1,
                'college_id' => 4,
                'created_at' => '2023-05-04 21:45:02',
                'updated_at' => '2023-05-04 21:45:02',
            ),
            24 => 
            array (
                'id' => 26,
                'name' => 'Bachelor of Early Childhood Education',
                'acronym' => 'BECEd',
                'is_active' => 1,
                'college_id' => 4,
                'created_at' => '2023-05-04 21:44:56',
                'updated_at' => '2023-05-04 21:44:56',
            ),
            25 => 
            array (
                'id' => 27,
                'name' => 'Bachelor of Physical Education',
                'acronym' => 'BPEd',
                'is_active' => 1,
                'college_id' => 4,
                'created_at' => '2023-05-04 21:44:49',
                'updated_at' => '2023-05-04 21:44:49',
            ),
            26 => 
            array (
                'id' => 28,
                'name' => 'Bachelor of Secondary Education',
                'acronym' => 'BSEd',
                'is_active' => 1,
                'college_id' => 4,
                'created_at' => '2023-05-04 21:44:44',
                'updated_at' => '2023-05-04 21:44:44',
            ),
            27 => 
            array (
                'id' => 29,
                'name' => 'Bachelor of Science in legal management',
                'acronym' => 'BSLM',
                'is_active' => 1,
                'college_id' => 2,
                'created_at' => '2023-05-04 22:15:49',
                'updated_at' => '2023-05-04 22:15:52',
            ),
        ));
        
        
    }
}
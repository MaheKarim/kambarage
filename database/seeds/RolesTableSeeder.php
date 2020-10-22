<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'display_name' => 'Super Admin',
                'description' => 'The root user, with all access',
                'is_default' => 0,
                'is_hidden' => 0,
                'enabled' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'subadmin',
                'display_name' => 'Sub Admin',
                'description' => 'Sub Admin with Access to college, Tutor, and student function.',
                'is_default' => 0,
                'is_hidden' => 0,
                'enabled' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'tutor',
                'display_name' => 'Tutor',
                'description' => 'The Tutor, with restricted access.',
                'is_default' => 0,
                'is_hidden' => 0,
                'enabled' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'student',
                'display_name' => 'Student',
                'description' => 'The Student, with restricted access.',
                'is_default' => 0,
                'is_hidden' => 0,
                'enabled' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'admin_assistant',
                'display_name' => 'Admin Assistant',
                'description' => 'Admin Assistant, with roles defined by Admin.',
                'is_default' => 0,
                'is_hidden' => 0,
                'enabled' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}
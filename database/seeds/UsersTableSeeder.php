<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            0 =>
            array (
                'id' => 1,
                'username' => 'admin',
                'name' => 'Admin User',
                'email' => 'admin@kambarage.com',
                'contact_number' => '987654321',
                'email_verified_at' => '2019-09-18 11:27:03',
                'password' => bcrypt('12345678'),
                'remember_token' => NULL,
                'activation_token' => NULL,
                'user_type' => 'admin',
                'registration_id' => NULL,
                'device_id' => NULL,
                'image' => NULL,
                'deleted_at' => NULL,
                'status' => 'active',
                'created_at' => '2019-09-18 11:27:03',
                'updated_at' => '2019-09-18 11:27:03',
                'role_id' => 1,
            ),
        ));

        \DB::table('users')->insert(array (
            0 =>
            array (
                'id' => 3,
                'username' => 'teacher',
                'name' => 'teacher',
                'email' => 'teacher@kambarage.com',
                'contact_number' => '01778966356',
                'email_verified_at' => '2019-09-18 11:27:05',
                'password' => bcrypt('12345678'),
                'remember_token' => NULL,
                'activation_token' => NULL,
                'user_type' => 'tutor',
                'registration_id' => NULL,
                'device_id' => NULL,
                'image' => NULL,
                'deleted_at' => NULL,
                'status' => 'active',
                'created_at' => '2019-09-18 11:27:05',
                'updated_at' => '2019-09-18 11:27:05',
                'role_id' => 3,
            ),
        ));

        \DB::table('users')->insert(array (
            0 =>
            array (
                'id' => 4,
                'username' => 'student',
                'name' => 'student',
                'email' => 'student@kambarage.com',
                'contact_number' => '01773966356',
                'email_verified_at' => '2019-09-18 11:27:05',
                'password' => bcrypt('12345678'),
                'remember_token' => NULL,
                'activation_token' => NULL,
                'user_type' => 'student',
                'registration_id' => NULL,
                'device_id' => NULL,
                'image' => NULL,
                'deleted_at' => NULL,
                'status' => 'active',
                'created_at' => '2019-09-18 11:27:05',
                'updated_at' => '2019-09-18 11:27:05',
                'role_id' => 4,
            ),
        ));
       


    }
}

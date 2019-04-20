<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /*
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
           'username' => 'superadmin',
           'name' => 'Super',
           'middlename' => ' ',
           'lastname' => 'Admin',
           'accesslevel' => 100,
           'email' => 'superadmin@gmail.com',
           'password' => bcrypt('password1234'),
           'is_first_login' => 0
        ]);
        
        \App\User::create([
           'username' => 'admin',
           'name' => 'Admin',
           'middlename' => ' ',
           'lastname' => 'Admin',
           'accesslevel' => 0,
           'email' => 'admin@gmail.com',
           'password' => bcrypt('password1234'),
           'is_first_login' => 0
        ]);
    }
}

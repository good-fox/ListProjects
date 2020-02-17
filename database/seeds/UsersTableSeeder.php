<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$dOdA0orx2AOsLsAf7DyvLugs8JuOEc66ugTdjzCnRXf2LVsDp9Iqq', // password 01234567
            'is_admin' => true,
        ]);

    }
}

<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('userr')->insert([
            'name' => 'Haluk Yel',
            'email' => 'haluk@yel.com',
            'password' => Hash::make('password')
        ]);
    }
}

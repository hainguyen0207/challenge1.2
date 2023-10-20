<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'username' => 'demo',
            'password' => Hash::make('demo'),
            'fullname' => 'Demo',
            'email' => 'demo@gmail.com',
            'phoneNumber' => '0987891209',
            'role' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

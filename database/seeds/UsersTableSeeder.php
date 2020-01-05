<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('1234'),
                'role_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Lembaga',
                'email' => 'lembaga@example.com',
                'password' => Hash::make('1234'),
                'role_id' => 2,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Donatur',
                'email' => 'donatur@example.com',
                'password' => Hash::make('1234'),
                'role_id' => 3,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Driver',
                'email' => 'driver@example.com',
                'password' => Hash::make('1234'),
                'role_id' => 4,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}

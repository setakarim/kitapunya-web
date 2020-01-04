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
                'path_photo' => null,
                'role_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Lembaga',
                'email' => 'lembaga@example.com',
                'password' => Hash::make('1234'),
                'path_photo' => null,
                'role_id' => 2,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Donatur',
                'email' => 'donatur@example.com',
                'password' => Hash::make('1234'),
                'path_photo' => 'http://3.bp.blogspot.com/-e3LOwI9ziUc/U_X3JyKYHWI/AAAAAAAAAKQ/AgMfbYvR7Tk/s1600/jjj.jpg',
                'role_id' => 3,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Driver',
                'email' => 'driver@example.com',
                'password' => Hash::make('1234'),
                'path_photo' => null,
                'role_id' => 4,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}

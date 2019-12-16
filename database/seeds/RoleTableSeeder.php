<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('role')->insert([
            'name' => 'Admin',
            'description' => 'Admin',
            'created_at' => Carbon::now(),
        ]);

        DB::table('role')->insert([
            'name' => 'Lembaga',
            'description' => 'Lembaga',
            'created_at' => Carbon::now(),
        ]);

        DB::table('role')->insert([
            'name' => 'Donatur',
            'description' => 'Donatur',
            'created_at' => Carbon::now(),
        ]);

        DB::table('role')->insert([
            'name' => 'Driver',
            'description' => 'Driver',
            'created_at' => Carbon::now(),
        ]);
    }
}

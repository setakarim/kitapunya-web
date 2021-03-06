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
            [
                'name' => 'Admin',
                'description' => 'Admin',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Campaigner',
                'description' => 'Campaigner',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Donatur',
                'description' => 'Donatur',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Driver',
                'description' => 'Driver',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}

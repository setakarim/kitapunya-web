<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('category')->insert([
            ['name' => 'Bencana Alam', 'created_at' => Carbon::now()],
            ['name' => 'Rumah Ibadah', 'created_at' => Carbon::now()],
            ['name' => 'Pendidikan', 'created_at' => Carbon::now()],
            ['name' => 'Panti Asuhan', 'created_at' => Carbon::now()],
            ['name' => 'Personal', 'created_at' => Carbon::now()],
        ]);
    }
}

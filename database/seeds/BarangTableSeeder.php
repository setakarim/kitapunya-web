<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('barang')->insert([
            ['name' => 'Baju', 'created_at' => Carbon::now()],
            ['name' => 'Celana', 'created_at' => Carbon::now()],
            ['name' => 'Selimut', 'created_at' => Carbon::now()],
            ['name' => 'Sajadah', 'created_at' => Carbon::now()],
            ['name' => 'Mukena', 'created_at' => Carbon::now()],
            ['name' => 'Buku Tulis', 'created_at' => Carbon::now()],
            ['name' => 'Buku Baca', 'created_at' => Carbon::now()],
            ['name' => 'Kursi Roda', 'created_at' => Carbon::now()],
        ]);
    }
}

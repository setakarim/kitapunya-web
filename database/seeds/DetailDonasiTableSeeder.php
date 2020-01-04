<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DetailDonasiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('detail_donasi')->insert([
            ['qty' => 10, 'donasi_id' => 1, 'barang_campaign_id' => 1, 'created_at' => Carbon::now()],
            ['qty' => 10, 'donasi_id' => 2, 'barang_campaign_id' => 2, 'created_at' => Carbon::now()],
            ['qty' => 15, 'donasi_id' => 3, 'barang_campaign_id' => 5, 'created_at' => Carbon::now()],
        ]);
    }
}

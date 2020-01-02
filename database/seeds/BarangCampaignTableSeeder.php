<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BarangCampaignTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('barang_campaign')->insert([
            ['max_qty' => 100, 'real_qty' => 0, 'barang_id' => 1, 'campaign_id' => 1, 'created_at' => Carbon::now()],
            ['max_qty' => 100, 'real_qty' => 0, 'barang_id' => 2, 'campaign_id' => 1, 'created_at' => Carbon::now()],
            ['max_qty' => 50, 'real_qty' => 0, 'barang_id' => 3, 'campaign_id' => 1, 'created_at' => Carbon::now()],
            ['max_qty' => 50, 'real_qty' => 0, 'barang_id' => 4, 'campaign_id' => 2, 'created_at' => Carbon::now()],
            ['max_qty' => 100, 'real_qty' => 0, 'barang_id' => 5, 'campaign_id' => 2, 'created_at' => Carbon::now()],
            ['max_qty' => 200, 'real_qty' => 0, 'barang_id' => 6, 'campaign_id' => 3, 'created_at' => Carbon::now()],
            ['max_qty' => 150, 'real_qty' => 0, 'barang_id' => 7, 'campaign_id' => 3, 'created_at' => Carbon::now()],
            ['max_qty' => 100, 'real_qty' => 0, 'barang_id' => 1, 'campaign_id' => 4, 'created_at' => Carbon::now()],
            ['max_qty' => 100, 'real_qty' => 0, 'barang_id' => 2, 'campaign_id' => 4, 'created_at' => Carbon::now()],
            ['max_qty' => 200, 'real_qty' => 0, 'barang_id' => 6, 'campaign_id' => 4, 'created_at' => Carbon::now()],
            ['max_qty' => 150, 'real_qty' => 0, 'barang_id' => 7, 'campaign_id' => 4, 'created_at' => Carbon::now()],
            ['max_qty' => 10, 'real_qty' => 0, 'barang_id' => 8, 'campaign_id' => 5, 'created_at' => Carbon::now()],
        ]);
    }
}

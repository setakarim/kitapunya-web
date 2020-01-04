<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonasiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('donasi')->insert([
            ['no_transaksi' => 'DON123456', 'status' => 2, 'location' => 'Komp. Timah Block CCV No.51, Kelurahan Tugu, Cimanggis, Depok', 'long' => '106.819750', 'lat' => '-6.412040', 'anonim' => 0, 'campaign_id' => 1, 'users_id' => 3, 'created_at' => Carbon::now()],
            ['no_transaksi' => 'DON987654', 'status' => 1, 'location' => 'Komp. Timah Block CCV No.51, Kelurahan Tugu, Cimanggis, Depok', 'long' => '106.819750', 'lat' => '-6.412040', 'anonim' => 1, 'campaign_id' => 1, 'users_id' => 3, 'created_at' => Carbon::now()],
            ['no_transaksi' => 'DON789012', 'status' => 1, 'location' => 'Komp. Timah Block CCV No.51, Kelurahan Tugu, Cimanggis, Depok', 'long' => '106.819750', 'lat' => '-6.412040', 'anonim' => 0, 'campaign_id' => 2, 'users_id' => 3, 'created_at' => Carbon::now()],
        ]);
    }
}

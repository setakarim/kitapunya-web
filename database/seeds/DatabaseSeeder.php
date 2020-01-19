<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(BarangTableSeeder::class);
        // $this->call(CampaignTableSeeder::class);
        // $this->call(BarangCampaignTableSeeder::class);
    }
}

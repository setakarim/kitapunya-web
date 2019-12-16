<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailDonasiTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('detail_donasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('qty')->default(0);
            $table->string('path_photo')->nullable();
            $table->unsignedBigInteger('donasi_id');
            $table->unsignedBigInteger('barang_campaign_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('detail_donasi');
    }
}

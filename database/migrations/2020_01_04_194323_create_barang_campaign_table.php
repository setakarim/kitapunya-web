<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangCampaignTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('barang_campaign', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('max_qty');
            $table->integer('real_qty')->default(0);
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('campaign_id');
            $table->timestamps();

            $table->foreign('barang_id')->on('barang')->references('id')->onDelete('cascade');
            $table->foreign('campaign_id')->on('campaign')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('barang_campaign');
    }
}

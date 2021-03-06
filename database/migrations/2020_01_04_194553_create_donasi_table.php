<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonasiTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('donasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_transaksi');
            $table->tinyInteger('status')->default(0);
            $table->string('location')->nullable();
            $table->string('long')->nullable();
            $table->string('lat')->nullable();
            $table->tinyInteger('anonim')->default(0);
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('users_id');
            $table->timestamps();

            $table->foreign('campaign_id')->on('campaign')->references('id')->onDelete('cascade');
            $table->foreign('users_id')->on('users')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('donasi');
    }
}

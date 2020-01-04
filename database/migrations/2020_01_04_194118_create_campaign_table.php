<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('campaign', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_transaksi');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('time_limit');
            $table->string('path_image')->nullable();
            $table->string('location')->nullable();
            $table->string('long')->nullable();
            $table->string('lat')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('users_id');
            $table->timestamps();

            $table->foreign('category_id')->on('category')->references('id')->onDelete('cascade');
            $table->foreign('users_id')->on('users')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('campaign');
    }
}

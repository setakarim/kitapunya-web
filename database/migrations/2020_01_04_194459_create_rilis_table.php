<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRilisTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('rilis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('campaign_id');
            $table->timestamps();

            $table->foreign('campaign_id')->on('campaign')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('rilis');
    }
}

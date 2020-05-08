<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharityAuctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charity_auction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('object_id');
            $table->unsignedBigInteger('highest_bid_user_id')->nullable();
            $table->double('goal', 8, 2)->default(0);
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('finished_at')->nullable();

            $table->foreign('object_id')->references('id')->on('auction_object');
            $table->foreign('highest_bid_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charity_auction');
    }
}

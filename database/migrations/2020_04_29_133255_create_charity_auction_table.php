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
            $table->double('highest_bid', 8, 2);
            $table->double('goal', 8, 2);
            $table->double('current_amount', 8, 2);
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('finished_at');

            $table->foreign('object_id')->references('id')->on('auction_object');
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

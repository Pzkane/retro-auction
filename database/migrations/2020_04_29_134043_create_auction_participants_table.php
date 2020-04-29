<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auction_participants', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('auction_id');
            $table->enum('auction_type', ['commercial', 'charity']);
            $table->double('amount', 8, 2);

            $table->foreign('user_id')->references('id')->on('object_type');
            $table->foreign('auction_id', 'charity')->references('id')->on('charity_auction');
            $table->foreign('auction_id', 'commercial')->references('id')->on('commercial_auction');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auction_participants');
    }
}

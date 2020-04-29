<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionObjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auction_object', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('object_type');
            $table->string('name', 24);

            $table->foreign('object_type')->references('id')->on('object_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auction_object');
    }
}

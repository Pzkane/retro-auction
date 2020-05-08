<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers_parts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('part', 32);
            $table->unsignedBigInteger('category');
            $table->unsignedBigInteger('offer_id');

            $table->foreign('category')->references('id')->on('parts_category')->onUpdate('cascade');
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers_parts');
    }
}

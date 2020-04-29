<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->string('username', 16)->unique();
            $table->text('avatar_path');
            $table->string('name', 24);
            $table->string('surname', 24);
            $table->enum('gender', ['male', 'female']);
            $table->string('password');
            $table->timestamps();
            $table->enum('role', ['super_admin', 'admin', 'user']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

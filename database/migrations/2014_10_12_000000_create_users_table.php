<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name')->nullable();
            $table->enum('level', ['user', 'admin'])->default('user');
            $table->string('email');
            // $table->float('balance', 10, 2)->default('0');
            $table->string('timezone')->nullable();
            $table->enum('smiles', ['true', 'false'])->default('true');
            $table->enum('links', ['true', 'false'])->default('false');
            $table->mediumText('black_list_words')->nullable();
            $table->string('avatar')->default('/assets/user.png');
            $table->string('token')->nullable();
            $table->rememberToken();
            $table->timestamps();
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

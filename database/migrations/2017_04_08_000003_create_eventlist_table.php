<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventlist_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('message_status')->default('success|user');
            $table->enum('limit', [ '10', '25', '50', '100' ])->default('25');
            $table->enum('theme', [ 'standard', 'dark' ])->default('standard');
            $table->string('token')->nullable();
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
        Schema::dropIfExists('eventlist_settings');
    }
}

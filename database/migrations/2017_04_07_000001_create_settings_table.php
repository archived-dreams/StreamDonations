<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->float('amount_minimum', 10, 2)->default(5);
            $table->float('amount_placeholder', 10, 2)->default(5);
            $table->integer('max_message_length')->default(5);
            $table->string('button_color')->default('#32c3a2');
            $table->mediumText('memo')->nullable();
            $table->string('banner')->nullable();
            $table->string('background')->nullable();
            $table->string('paypal')->nullable();
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
        Schema::dropIfExists('settings');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonationgoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donationgoal_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title')->nullable();
            $table->float('goal_amount', 10, 2)->nullable();
            $table->float('manual_goal_amount', 10, 2)->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->enum('layout', ['standard', 'condensed'])->default('standard');
            $table->string('background_color')->nullable();
            $table->string('font_color')->nullable();
            $table->string('bar_text_color')->nullable();
            $table->string('bar_color')->nullable();
            $table->string('bar_background_color')->nullable();
            $table->integer('bar_thickness');
            $table->string('font')->nullable();
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
        Schema::dropIfExists('donationgoal_settings');
    }
}

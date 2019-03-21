<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertboxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alertbox_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('message_template')->nullable();
            $table->string('image')->nullable();
            $table->string('text_animation')->nullable();
            $table->string('sound')->nullable();
            $table->integer('sound_volume');
            $table->enum('voice', ['true', 'false'])->default('true');
            $table->enum('voice_language', [
                'en-US', 'ru-RU', 'uk-UA', 'tr-TR', 'it_IT', 'fr_FR', 'es_ES',
                'de_DE', 'pl_PL', 'cs_CZ', 'sv_SE', 'pt_PT', 'fi_FI', 'ar_AE',
                'ca_ES', 'da_DK', 'nl_NL', 'el_GR', 'no_NO', 'zh_CN', 'ja_JP'
                ])->default('en-US');
            $table->enum('voice_speaker', [
                'levitan', 'ermilov', 'zahar', 'silaerkan', 'oksana', 'jane',
                'omazh', 'kolya', 'kostya', 'nastya', 'sasha', 'nick',
                'erkanyavas', 'zhenya', 'tanya', 'ermil', 'anton_samokhvalov',
                'tatyana_abramova', 'voicesearch', 'alyss', 'ermil_with_tuning',
                'robot', 'dude', 'zombie', 'smoky', 'Acapela'
                ])->default('smoky');
            $table->enum('voice_emotion', ['neutral', 'good', 'evil'])->default('neutral');
            $table->integer('duration');
            $table->integer('font_size');
            $table->string('font')->nullable();
            $table->string('background_color')->nullable();
            $table->string('font_color')->nullable();
            $table->string('font_color2')->nullable();
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
        Schema::dropIfExists('alertbox_settings');
    }
}

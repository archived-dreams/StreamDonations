<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlertboxSettings extends Model
{

    protected $fillable = [
        'id', 'user_id', 'message_template', 'image', 'text_animation', 'sound',
        'sound_volume', 'duration', 'font', 'font_color', 'font_color2', 'token',
        'voice', 'voice_language', 'voice_speaker', 'voice_emotion', 'background_color',
        'font_size'
    ];


    public static function user($user_id)
    {
        $settings = AlertboxSettings::where('user_id', $user_id)->first();
        if (!$settings)
            $settings = AlertboxSettings::create([
                'user_id' => $user_id,
                'message_template' => trans('widgets.alertbox.default_template'),
                'image' => 'library/default.gif',
                'text_animation' => 'tada',
                'sound' => 'library/default.mp3',
                'sound_volume' => '85',
                'voice' => 'true',
                'voice_language' => 'en-US',
                'voice_emotion' => 'neutral',
                'voice_speaker' => 'smoky',
                'duration' => '10',
                'font' => 'Open Sans',
                'font_size' => '64',
                'font_color' => '#ffffff',
                'font_color2' => '#32c3a2',
                'background_color' => '#00ff00',
                'token' => str_random(45)
            ]);
        return $settings;
    }

    public static function text_animations()
    {
        return [
            'bounce' => trans('widgets.alertbox.animation.bounce'),
            'pulse' => trans('widgets.alertbox.animation.pulse'),
            'rubberBand' => trans('widgets.alertbox.animation.rubberBand'),
            'tada' => trans('widgets.alertbox.animation.tada'),
            'wave' => trans('widgets.alertbox.animation.wave'),
            'wiggle' => trans('widgets.alertbox.animation.wiggle'),
            'wobble' => trans('widgets.alertbox.animation.wobble')
            ];
    }

    public static function voice_languages()
    {
        return [
                'en-US' => trans('widgets.alertbox.languages.en-US'),
                'ru-RU' => trans('widgets.alertbox.languages.ru-RU'),
                'uk-UA' => trans('widgets.alertbox.languages.uk-UA'),
                'tr-TR' => trans('widgets.alertbox.languages.tr-TR'),
                'it_IT' => trans('widgets.alertbox.languages.it_IT'),
                'fr_FR' => trans('widgets.alertbox.languages.fr_FR'),
                'es_ES' => trans('widgets.alertbox.languages.es_ES'),
                'de_DE' => trans('widgets.alertbox.languages.de_DE'),
                'pl_PL' => trans('widgets.alertbox.languages.pl_PL'),
                'cs_CZ' => trans('widgets.alertbox.languages.cs_CZ'),
                'sv_SE' => trans('widgets.alertbox.languages.sv_SE'),
                'pt_PT' => trans('widgets.alertbox.languages.pt_PT'),
                'fi_FI' => trans('widgets.alertbox.languages.fi_FI'),
                'ar_AE' => trans('widgets.alertbox.languages.ar_AE'),
                'ca_ES' => trans('widgets.alertbox.languages.ca_ES'),
                'da_DK' => trans('widgets.alertbox.languages.da_DK'),
                'nl_NL' => trans('widgets.alertbox.languages.nl_NL'),
                'el_GR' => trans('widgets.alertbox.languages.el_GR'),
                'no_NO' => trans('widgets.alertbox.languages.no_NO'),
                'zh_CN' => trans('widgets.alertbox.languages.zh_CN'),
                'ja_JP' => trans('widgets.alertbox.languages.ja_JP')
                ];
    }

    public static function voice_speakers()
    {
        return [
                'levitan' => trans('widgets.alertbox.speakers.levitan'),
                'ermilov' => trans('widgets.alertbox.speakers.ermilov'),
                'zahar' => trans('widgets.alertbox.speakers.zahar'),
                'silaerkan' => trans('widgets.alertbox.speakers.silaerkan'),
                'oksana' => trans('widgets.alertbox.speakers.oksana'),
                'jane' => trans('widgets.alertbox.speakers.jane'),
                'omazh' => trans('widgets.alertbox.speakers.omazh'),
                'kolya' => trans('widgets.alertbox.speakers.kolya'),
                'kostya' => trans('widgets.alertbox.speakers.kostya'),
                'nastya' => trans('widgets.alertbox.speakers.nastya'),
                'sasha' => trans('widgets.alertbox.speakers.sasha'),
                'nick' => trans('widgets.alertbox.speakers.nick'),
                'erkanyavas' => trans('widgets.alertbox.speakers.erkanyavas'),
                'zhenya' => trans('widgets.alertbox.speakers.zhenya'),
                'tanya' => trans('widgets.alertbox.speakers.tanya'),
                'ermil' => trans('widgets.alertbox.speakers.ermil'),
                'anton_samokhvalov' => trans('widgets.alertbox.speakers.anton_samokhvalov'),
                'tatyana_abramova' => trans('widgets.alertbox.speakers.tatyana_abramova'),
                'voicesearch' => trans('widgets.alertbox.speakers.voicesearch'),
                'alyss' => trans('widgets.alertbox.speakers.alyss'),
                'ermil_with_tuning' => trans('widgets.alertbox.speakers.ermil_with_tuning'),
                'robot' => trans('widgets.alertbox.speakers.robot'),
                'dude' => trans('widgets.alertbox.speakers.dude'),
                'zombie' => trans('widgets.alertbox.speakers.zombie'),
                'smoky' => trans('widgets.alertbox.speakers.smoky'),
                'Acapela' => trans('widgets.alertbox.speakers.Acapela')
                ];
    }

}

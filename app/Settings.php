<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    
    protected $fillable = [
        'id', 'user_id', 'amount_minimum', 'max_message_length', 'amount_placeholder', 'button_color', 'memo', 'banner', 'background'
    ];
    
    
    public static function user($user_id)
    {
        $settings = Settings::where('user_id', $user_id)->first();
        if (!$settings)
            $settings = Settings::create([
                'user_id' => $user_id,
                'amount_minimum' => '5',
                'max_message_length' => '255',
                'amount_placeholder' => '15',
                'button_color' => '#32c3a2',
                'memo' => '',
                'banner' => 'default.jpg',
                'background' => 'patterns/default.png'
            ]);
        return $settings;
    }

}
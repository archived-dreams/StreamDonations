<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventlistSettings extends Model
{
    
    protected $fillable = [
        'id', 'user_id', 'message_status', 'limit', 'theme', 'token'
    ];
    
    
    public static function user($user_id)
    {
        $settings = EventlistSettings::where('user_id', $user_id)->first();
        if (!$settings)
            $settings = EventlistSettings::create([
                'user_id' => $user_id,
                'message_status' => 'success|user',
                'limit' => '25',
                'theme' => 'standard',
                'token' => str_random(45)
            ]);
        $settings['message_status'] = explode('|', $settings['message_status']);
        return $settings;
    }

}
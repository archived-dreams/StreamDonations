<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DonationgoalSettings extends Model
{
    
    protected $fillable = [
        'id', 'user_id', 'title', 'goal_amount', 'manual_goal_amount', 'layout', 
        'background_color', 'font_color', 'bar_text_color', 'bar_background_color', 
        'bar_thickness', 'bar_color', 'font', 'token'
    ];
    
    
    public static function user($user_id)
    {
        $settings = DonationgoalSettings::where('user_id', $user_id)->first();
        if (!$settings)
            $settings = DonationgoalSettings::create([
                'user_id' => $user_id,
                'title' => '', 
                'goal_amount' => '150', 
                'manual_goal_amount' => '75', 
                'layout' => 'standard', 
                'background_color' => '#00ff00', 
                'font_color' => '#ffffff', 
                'bar_text_color' => '#000000', 
                'bar_color' => '#32c3a2',
                'bar_background_color' => '#dddddd',
                'bar_thickness' => '48', 
                'font' => 'Open Sans',
                'token' => str_random(45)
            ]);
        return $settings;
    }

}
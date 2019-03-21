<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Messages extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'id', 'user_id', 'amount', 'commission', 'message', 'name', 'billing_system', 'billing_data', 'status', 'view_status', 'updated_at'
    ];
    
    public static function smileys($message) {
        $emotes = Storage::disk('public')->allFiles('emotes');
        foreach ($emotes as $patch) {
            $emotion = basename($patch, '.png');
            $message = str_replace($emotion, '<img src="' . asset(Storage::url($patch)) . '">', $message);
        }
        return $message;
    }

}
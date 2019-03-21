<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Configuration extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'key', 'val'
    ];

    // Reload configuration from database
    public static function reload() {
        $configs = Configuration::get();
        $configs_array = [];
        foreach ($configs as $config) {
            $configs_array[$config->key] = $config->value;
        }
        config($configs_array);
    }
    
}
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    
    /// Auth
    'twitch' => [
        'client_id' => env('TWITCH_KEY'),
        'client_secret' => env('TWITCH_SECRET'),
        'redirect' => env('TWITCH_REDIRECT_URI'),  
    ], 
    
    'youtube' => [
        'client_id' => env('YOUTUBE_KEY'),
        'client_secret' => env('YOUTUBE_SECRET'),
        'redirect' => env('YOUTUBE_REDIRECT_URI'),  
    ],
    
    'mixer' => [
        'client_id' => env('MIXER_KEY'),
        'client_secret' => env('MIXER_SECRET'),
        'redirect' => env('MIXER_REDIRECT_URI'),  
    ], 

];

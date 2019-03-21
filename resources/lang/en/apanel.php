<?php
return [
    'configurations' => [
        'title' => 'Configurations',
        'enter' => 'Enter :what',
        'success' => 'Configuration successfully updated',
        'application' => [
            'title' => 'Application',
        ],
        'auth' => [
            'title' => 'Authorization'
        ],
        'payments' => [
            'title' => 'Payments'
        ],
        'other' => [
            'title' => 'Other'
        ],
        'keys' => [
            'app_name' => 'Application Name',
            'app_title' => 'Application Title',
            'app_timezone' => 'Default TimeZone',
            'app_currency_icon' => 'Currency Icon',
            'app_currency' => 'Currency Code',
            'app_yandex_api_key' => 'Yandex.SpeechKit Api Key',
            'app_yandex_api_key_info' => 'Create Account (https://passport.yandex.com/registration/mail), Create Api key (https://developer.tech.yandex.ru/keys/)',
            'app_contact_email' => 'Contact form Email',
            
            'auth_default_avatar' => 'Default Avatar',
            'auth_twitch_status' => 'Twitch',
            'auth_youtube_status' => 'Youtube',
            'auth_mixer_status' => 'Mixer',
    
            'paypal_commission' => 'Commission for each donation (%)',
            'paypal_info' => '<a href="https://github.com/srmklive/laravel-paypal">GitHub repository</a>. ' . 
                             '<a href="https://www.paypal-apps.com/user/my-account/applications">Applications</a>. ' . 
                             '<a href="https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNIntro/">IPN Instruction</a> (<a href="https://developer.paypal.com/developer/ipnSimulator/">Simulator</a>).' . 
                             '<a href="https://developer.paypal.com/docs/classic/api/apiCredentials/#create-an-api-signature">How to get Username, Password, Secret (API)</a>',
            'paypal_sandbox' => 'Sandbox',
            'paypal_live' => 'Live',
            'paypal_basic' => 'Basic Settings',
            'paypal_status' => 'Status',
            'paypal_mode' => 'Mode',
            'paypal_currency' => 'Currency',
            'paypal_notify_url' => 'Notify URL (For IPN)',
            'paypal_sandbox_username' => 'Username (API)',
            'paypal_sandbox_password' => 'Password (API)',
            'paypal_sandbox_secret' => 'Secret (API)',
            'paypal_sandbox_email' => 'Account for commission',
            'paypal_live_username' => 'Username (API)',
            'paypal_live_password' => 'Password (API)',
            'paypal_live_secret' => 'Secret (API)',
            'paypal_live_email' => 'Account for commission',
            'paypal_live_app_id' => 'Application ID'
            
            
    
        ]
    ],
    'statistics' => [
        'title' => 'Statistics',
        'message_statistics' => 'Statistics of the last 7 days',
        'amount' => 'Amount',
        'amount_info' => 'Amount of donations (Last 7 days)',
        'commission' => 'Commission',
        'commission_info' => 'Amount of commissions (Last 7 days)',
        'counters' => [
            'messages' => 'Total messages',
            'paid_messages' => 'Total Paid Messages',
            'users' => 'Total Users',
            'today_users' => 'Today New Users',
            'amount' => 'Amount of donations',
            'commission' => 'Amount of commission',
            'refunds' => 'Number of refunds',
            'amount_refunds' => 'Refund amount'
            ]
        ],
    'donations' => [
        'title' => 'Donations',
        'user_id' => 'User'
    ],
    'users' => [
        'title' => 'Users',
        'id' => 'ID',
        'balance' => 'Balance',
        'email' => 'Email',
        'name' => 'Username',
        'timezone' => 'Timezone',
        'token' => 'Token', 
        'created_at' => 'Date of registration',
        'avatar' => 'Avatar',
        'level' => [
            'title' => 'Rights',
            'user' => 'User',
            'admin' => 'Admin'
            ],
        'edit' => [
            'title' => 'Edit User #:id'
            ]
        ]
];
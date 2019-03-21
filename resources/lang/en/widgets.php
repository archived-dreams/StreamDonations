<?php

return [

    'guard_info' => 'Click To Show Widget URL',
    'url' => 'Widget URL',
    'launch' => 'Launch',
    'new' => 'Create new',
    'success' => 'Settings updated.',
    'link-replacment-text' => '(Link deleted)',
    
    // Event List
    'eventlist' => [
        // Home
        'home' => [
            'title' => 'Event List',
            'info' => 'Did they miss or did not have time to read the user\'s message? No problems! With this widget, you can easily track the latest messages.',
            'save' => 'Save Settings',
            'limit' => 'Amount of elements',
            'theme' => [
                'title' => 'Theme',
                'standard' => 'Standard',
                'dark' => 'Dark'
                ],
            'types' => [
                'title' => 'Types of donations',
                'success' => 'Donation',
                'user' => 'Added manually'
                ],
            'new-token' => 'Generate new widget link'
            ],
        // Widget
        'widget' => [
            'title' => 'Event List',
            'donated' => 'donated'
            ]
        ],
    // Alerbox
    'alertbox' => [
        'default_template' => '{name} donated {amount}!',
        'home' => [
            'title' => 'Alert Box',
            'info' => 'Reward your loyal viewers by thanking them with attractive, on-stream notification popups.',
            'save' => 'Save Settings',
            'background_color' => 'Background',
            'sections' => [
                'message' => 'Message',
                'sound' => 'Sound',
                'voice' => 'Voice',
                'other' => 'Other'
                ],
            'new-token' => 'Generate new widget link',
            'message_template' => [
                'title' => 'Message Template',
                'info' => 'When a donation alert shows up, this will be the format of the message. Available Tokens, {name} The name of the donator, {amount} The amount that was donated.'
                ],
            'text_animation' => 'Text Animation',
            'font' => 'Font',
            'font_color' => 'Text Color',
            'font_color2' => 'Text Highlight Color',
            'image' => [ 'title' => 'Image' ],
            'sound' => [ 'title' => 'Sound' ],
            'sound_volume' => [
                'title' => 'Volume',
                'info' => 'Volume: :volume%.',
                'disabled' => 'Disabled'
                ],
            'duration' => [
                'title' => 'Alert Duration',
                'info' => 'Duration: :duration sec.'
                ],

            'font_size' => [
                'title' => 'Font Size',
                'info' => 'Size: :size px.'
                ],
            'voice' => [
                'title' => 'Voice',
                'true' => 'Yes',
                'false' => 'No',
                'language' => 'Language',
                'voice_volume' => [
                    'title' => 'Volume',
                    'info' => 'Volume: :volume%.'
                ],
                'speaker' => 'Speaker',
                'emotion' => [
                    'title' => 'Emotion',
                    'neutral' => 'Neutral',
                    'good' => 'Good',
                    'evil' => 'Evil'
                    ]
                ]
            ],
        'animation' => [
            'bounce' => 'Bounce',
            'pulse' => 'Pulse',
            'rubberBand' => 'Rubber Band',
            'tada' => 'Tada',
            'wave' => 'Wave',
            'wiggle' => 'Wiggle',
            'wobble' => 'Wobble'
            ],
        'languages' => [
                'en-US' => 'English',
                'ru-RU' => 'Russian',
                'uk-UA' => 'Ukrainian',
                'tr-TR' => 'Turkish',
                'it_IT' => 'Italian',
                'fr_FR' => 'French',
                'es_ES' => 'Spanish',
                'de_DE' => 'German',
                'pl_PL' => 'Polish',
                'cs_CZ' => 'Czech',
                'sv_SE' => 'Swedish',
                'pt_PT' => 'Portuguese',
                'fi_FI' => 'Finnish',
                'ar_AE' => 'Arabic',
                'ca_ES' => 'Catalan',
                'da_DK' => 'Danish',
                'nl_NL' => 'Dutch',
                'el_GR' => 'Greek',
                'no_NO' => 'Norwegian',
                'zh_CN' => 'Chinese',
                'ja_JP' => 'Japanese'
            ],
        'speakers' => [
                'robot' => 'Robot',
                'dude' => 'Dude',
                'zombie' => 'Zombie',
                'smoky' => 'Smoky',
                'nick' => 'Nick',
                'zahar' => 'Zahar',
                'silaerkan' => 'Silaerkan',
                'oksana' => 'Oksana',
                'jane' => 'Jane',
                'omazh' => 'Mozhara',
                'kolya' => 'Kolya',
                'levitan' => 'Levitan',
                'ermilov' => 'Ermilov',
                'voicesearch' => 'VoiceSearch',
                'kostya' => 'Kostya',
                'nastya' => 'Nastya',
                'sasha' => 'Sasha',
                'erkanyavas' => 'Erkanyavas',
                'zhenya' => 'Zhenya',
                'tanya' => 'Tanya',
                'ermil' => 'Ermilov',
                'ermil_with_tuning' => 'Ermil',
                'Acapela' => 'Aca',
                'anton_samokhvalov' => 'Samokhvalov',
                'tatyana_abramova' => 'Abramova',
                'alyss' => 'Alyss'
            ]
        ],

    // Donation Goal
    'donationgoal' => [
        'home' => [
            'title' => 'Donation Goal',
            'info' => 'Set a goal for your viewers to help you reach below. Click the launch button below and use a window capture to place it in your stream.',
            'save' => 'Save Donation Goal',
            'new' => 'New Donation Goal',
            'created_at' => 'Started at',
            'new-token' => 'Generate new widget link',
            'sections' => [
                'manage' => 'Manage Goal',
                'settings' => 'Settings'
                ],
            '_title' => 'Title',
            'goal_amount' => 'Goal Amount',
            'manual_goal_amount' => 'Starting Amount',
            'ends_at' => 'End After',
            'layout' => [
                'title' => 'Layout',
                'standard' => 'Standard',
                'condensed' => 'Condensed'
                ],
            'background_color' => 'Background Color',
            'font_color' => 'Text Color',
            'bar_text_color' => 'Bar Text Color',
            'bar_color' => 'Bar Color',
            'bar_background_color' => 'Bar Background Color',
            'bar_thickness' => [
                'title' => 'Bar Thickness',
                'info' => 'Size: :size px.'
                ],
            'font' => 'Font'

        ]

    ]

];

@extends('layouts.blank')

@section('head')
    <link href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/vendor/animate/animate.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family={{ urlencode($settings['font']) }}:400,700&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" settings-font="{{ $settings['font'] }}" type="text/css" />
    <script src="https://webasr.yandex.net/jsapi/v1/webspeechkit.js" type="text/javascript"></script>
    <script src="https://webasr.yandex.net/jsapi/v1/webspeechkit-settings.js" type="text/javascript"></script>
    <link href="{{ asset('assets/css/alertbox.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('css')
    <style>
        body {
            background-color: {{ $settings['background_color'] }};
        }
    </style>
@endsection

@section('content')
    <div id="defender"></div>
    <div id="content" class="animated">
        {{-- Image --}}
        <div class="image-row">
            <div class="image-cell">
                <img src="{{ asset(Storage::url('alertbox/images/' . $settings['image'])) }}" settings-data="image">
            </div>
        </div>
        {{-- Text --}}
        <div class="text-row">
            <div class="text-cell word-container">
                {{-- Header --}}
                <div class="text-header font font-color" style="color: {{ $settings['font_color'] }}; font-size: {{ $settings['font_size'] }}px; font-family: {{ $settings['font'] }};">
                    @php
                        $message_template = e($settings['message_template']);
                        $message_template = str_replace('{name}', '<span class="font-color2" style="color: ' . $settings['font_color2'] . ';" data-name></span>', $message_template);
                        $message_template = str_replace('{amount}', '<span class="font-color2" style="color: ' . $settings['font_color2'] . ';" data-amount></span>', $message_template);
                    @endphp
                    {!! $message_template !!}
                </div>
                {{-- Message --}}
                <div class="text-message font-color font" style="color: {{ $settings['font_color'] }}; font-family: {{ $settings['font'] }};" data-message></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var _show = {}, sounds = {},
            settings = JSON.parse(`{!! json_encode($settings) !!}`),
            bad_words = JSON.parse(`{!! json_encode($user->black_list_words) !!}`).toString().split(' '),
            anti_spam = {{ $user->links == 'true' ? 'true' : 'false' }},
            duration_timeout_id = false, messages = [], message, voice,
            steap_3_access = false;
        
        window['link-replacment-text'] = "{{ trans('widgets.link-replacment-text') }}";
            
        window.ya.speechkit.settings.lang = `{{ $settings['voice_language'] }}`;
        window.ya.speechkit.settings.apikey = `{{ config('app.yandex.api_key') }}`;
        window.ya.speechkit.settings.model = 'notes';
        var voice = new ya.speechkit.Tts(
              {
                emotion: `{{ $settings['voice_emotion'] }}`,
                speaker: `{{ $settings['voice_speaker'] }}` 
              }
            );
            
            
        $(function() {
            // Set sound
            sounds[`{{ $settings['sound'] }}`] = new Howl({ 
                src: [`{{ asset(Storage::url('alertbox/sounds/' . $settings['sound'])) }}`],
                volume: {{ $settings['sound_volume'] / 100 }},
                onend: function() { _show.steap_2(); }
            });
            
            // Animate text
            function animate(string, html_prefix) {
                var letters = string.toString().trim().split('');
                $.each(letters, function(key, letter) {
                    letters[key] = `<span class="char${(key + 2)} animated animated-letter infinite ${settings.text_animation}">${escapeHtml(letter)}</span>`;
                })
                
                var result = letters.join('');
                
                if (typeof html_prefix != 'undefined')
                    result = `<span class="char1 animated animated-letter infinite ${settings.text_animation}">${html_prefix}</span>${result}`;
                
                return result;
            }
            
            // Settings
            var load_settings = function() {
                $.ajax({
                    dataType: "json",
                    url: "{{ route('widgets.alertbox.widget.settings', [ 'token' => $settings['token'] ]) }}?" + Math.random(),
                    success: function(data) {
                        
                        setTimeout(load_settings, 4000);
                        
                        // No changes
                        if (data.updated_at == settings.updated_at)
                            return;
                        
                        // Black Words
                        if (data.black_list_words != black_list_words.join(' '))
                            bad_words = data.black_list_words.toString().split(' ');
                        // Stop Spam
                        if (data.anti_spam != anti_spam)
                            anti_spam = (data.anti_spam == 'true');
                        // Background
                        if (data.background_color != settings.background_color)
                            $('body').css('background-color', data.background_color);
                        // Image
                        if (data.image != settings.image)
                            $('[settings-data="image"]').attr('src', `{{ asset(Storage::url('alertbox/images')) }}/${data.image}`);
                        // Text Animation
                        if (data.text_animation != settings.text_animation) {
                            $(`.${settings.text_animation}`).removeClass(settings.text_animation).addClass(data.text_animation);
                        }
                        // Font
                        if (data.font != settings.font) {
                            if ($(`[settings-font="${data.font}"]`).length == 0) {
                                var link = `https://fonts.googleapis.com/css?family=${encodeURIComponent(data.font)}:400,700&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese`;
                                $('head').append(`<link rel="stylesheet" href="${link}" settings-font="${data.font}" type="text/css" />`);
                            }
                            $('.font').css("font-family", data.font);
                        }
                        // Font Size
                        if (data.font_size != settings.font_size)
                            $('.text-header').css('font-size', data.font_size);
                        // Font Color #1
                        if (data.font_color != settings.font_color)
                            $('.font-color').css('color', data.font_color);
                        // Font Color #2
                        if (data.font_color2 != settings.font_color2)
                            $('.font-color2').css('color', data.font_color2);
                        // Sound
                        if (data.sound != settings.sound) {
                            if (typeof sounds[data.sound] == 'undefined')
                                sounds[data.sound] = new Howl({ src: [`{{ asset(Storage::url('alertbox/sounds')) }}/${data.sound}`] });
                        }
                        // Volume
                        if (data.sound_volume != settings.sound_volume) {
                            $.each(sounds, function(key) {
                                sounds[key].volume(data.sound_volume / 100);
                            });
                        }
                        // Duration
                        if (data.sound_volume != settings.sound_volume) {
                            if (duration_timeout_id != false)
                                clearTimeout(duration_timeout_id);
                        }
                        // Message Template
                        if (data.message_template != settings.message_template) {
                            var html = data.message_template.replaceAll('{name}', `<span class="font-color2" style="color: ${data.font_color2};" data-name>${$('[data-name]').html()}</span>`)
                                                            .replaceAll('{amount}', `<span class="font-color2" style="color: ${data.font_color2};" data-amount>${$('[data-amount]').html()}</span>`);
                            $('.text-header').html(html);
                        }
                        // Voice Language
                        if (data.voice_language != settings.voice_language)
                            window.ya.speechkit.settings.lang = voice_language;
                        
                        settings = data;
                    }
                });
            };
            
            // Get messages
            var get_messages = function() {
                $.ajax({
                    dataType: "json",
                    url: "{{ route('widgets.alertbox.widget.get', [ 'token' => $settings['token'] ]) }}?" + Math.random(),
                    success: function(data) {
                        messages = data;
                    },
                    error: function() {
                        setTimeout(get_messages, 4000);
                    }
                });
            };
            
            // Get and mark message as read
            var get_and_read = function() {
                message = messages.shift(); 
                $.ajax({
                    type: "POST",
                    url: "{{ route('widgets.alertbox.widget.read', [ 'token' => $settings['token'] ]) }}?" + Math.random(),
                    data: {
                        id: message.id,
                        _token: '{{ csrf_token() }}'
                    }
                });
                return message;
            }
            
            // Show message
            var show_message = function() {
                // If no messages
                if (messages.length == 0) {
                    get_messages();
                    setTimeout(show_message, 3500);
                    return;
                }
                // Message
                message = get_and_read();
                
                // Steap :: 1
                _show.steap_1();
            }
            
            // Show :: Steap 1
            _show.steap_1 = function() {
                // Name
                $('[data-name]').html(animate(removeLink(removeBadWords(message.name), anti_spam)));
                // Amount
                $('[data-amount]').html(`${animate(message.amount, '{!! config("app.currency_icon") !!}')}`);
                // Message 
                $('[data-message').html(removeLink(removeBadWords(message.message)), anti_spam);
                // Show
                $('#content').removeClass('fadeOut').addClass('fadeIn');
                // Music
                if (message.volume == 0)
                    _show.steap_2();
                else
                    sounds[settings.sound].play();
            };
            
            // Show :: Steap 2
            _show.steap_2 = function() {
                _show.steap_2_1();
                _show.steap_2_2();
            };
            
            // Show :: Steap 2.1
            _show.steap_2_1 = function() {
                if (message.message.toString().trim() == '' || settings.voice == 'false')
                    return steap_3_access = true;
                voice.speak(removeLink(removeBadWords(message.voice_message, true), anti_spam), {
                    speaker: settings.speaker,
                    emotion: settings.emotion,
                    stopCallback: function () { 
                        if (steap_3_access)
                            return _show.steap_3(); 
                        steap_3_access = true;
                    }
                });
            };
            
            // Show :: Steap 2.2
            _show.steap_2_2 = function() {
                // Sound duration
                var sound_duration = 0;
                if (message.volume > 0) 
                    sound_duration = Math.ceil(sounds[settings.sound]._duration * 10) / 10;
                
                var hide = function() {
                    $('#content').removeClass('fadeIn').addClass('fadeOut');
                    if (steap_3_access)
                        return _show.steap_3();
                    steap_3_access = true;
                };
                
                if (settings.duration > sound_duration)
                    return setTimeout(hide, (settings.duration - sound_duration) * 1000);
                hide();
            }
            
            // Show :: Steap 3
            _show.steap_3 = function() {
                steap_3_access = false;
                message = [];
                setTimeout(show_message, 1000);
            };
            
            // Start
            setTimeout(load_settings, 4500);
            get_messages();
            show_message();
        });
    </script>
@endsection
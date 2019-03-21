@extends('layouts.blank')

@section('head')
    <link href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/vendor/animate/animate.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family={{ urlencode($settings['font']) }}:400,700&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" settings-font="{{ $settings['font'] }}" type="text/css" />
@endsection

@section('css')
    <style>
        body {
            overflow: hidden;
            background-color: {{ $settings['background_color'] }};
            padding: 10px 20px;
        }
        
        #content {
            display: table;
            position: fixed;
            top: 0px;
            right: 0px;
            left: 0px;
            bottom: 0px;
            height: 100%;
            width: 100%;
            opacity: 1;
            z-index: 3;
        }
        
        #defender {
            position: fixed;
            top: 0px;
            left: 0px;
            right:0px;
            bottom: 0px;
            height: 100%;
            width: 100%;
            z-index: 10;
            opacity: 0;
        }
        
        .title {
            text-align: center;
            text-shadow: 0 0 1px #222;
            margin-bottom: 10px;
            color: {{ $settings['font_color'] }};
            font: 800 22px/1 {{ $settings['font'] }};
        }
        
        .container {
            width: 100%;
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 3px #222;
            height: {{ $settings['bar_thickness'] }}px;
            background: {{ $settings['bar_background_color'] }};
        }
        
        .amount {
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 11;
            text-align: center;
            vertical-align: middle;
            color: {{ $settings['bar_text_color'] }};
            font: 800 28px/48px {{ $settings['font'] }};
        }
        
        .shadow {
            height: 100%;
            width: 100%;
            position: absolute;
            top: 0px;
            left: 0px;
            z-index: 10;
            box-shadow: 0px 0px 2px rgb(0, 0, 0) inset;
        }
        
        .bar {
            height: 100%;
            background: {{ $settings['bar_color'] }} linear-gradient(transparent, rgba(0, 0, 0, 0.15)) repeat scroll 0% 0%;
        }
        
        .start {
            text-align: center;
            text-transform: uppercase;
            height: 32px;
            text-shadow: 0 0 1px #222;
            color: {{ $settings['font_color'] }};
            font: 800 18px/32px {{ $settings['font'] }};
        }

        .manual {
            float: left;
            color: {{ $settings['font_color'] }};
            font: 800 28px/32px {{ $settings['font'] }};
        }
        
        .goal-amount {
            float: right;
            color: {{ $settings['font_color'] }};
            font: 800 18px/32px {{ $settings['font'] }};
        }
    </style>
@endsection

@section('content')
    <div id="defender"></div>
    <div id="content" class="animated">
        <div style="padding: 10px 20px;">
            {{-- Title --}}
            <div class="title">{{ $settings['title'] }}</div>
            {{-- Container --}}
            <div class="container">
                {{-- Amount --}}
                <div class="amount"></div>
                {{-- Shadow --}}
                <div class="shadow"></div>
                {{-- Bar --}}
                <div class="bar" style="width: 10%"></div>
            </div>
            <div class="start font" style="color: {{ $settings['font_color'] }}; font: 800 22px/1 {{ $settings['font'] }};">
                <div class="manual" settings-data="manual_goal_amount">{{ $settings['manual_goal_amount'] }} {!! config('app.currency_icon') !!}</div>
                <div class="goal-amount" settings-data="goal_amount">{{ $settings['goal_amount'] }} {!! config('app.currency_icon') !!}</div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var settings = JSON.parse(`{!! json_encode($settings) !!}`);
            
        $(function() {
            
            // Get data
            var get_data = function() {
                $.ajax({
                    dataType: "json",
                    url: "{{ route('widgets.donationgoal.widget.get', [ 'token' => $settings['token'] ]) }}?" + Math.random(),
                    success: function(data) {
                        if (data.settings.updated_at != `{{ $settings['updated_at'] }}`)
                             location.reload();
                        var precent = (100 / (settings.goal_amount - settings.manual_goal_amount)) * data.amount;
                        $('.amount').html(`${data.amount} {!! config('app.currency_icon') !!} (${number_format(precent, 2, '.')}%)`);
                        $('.bar').css('width', `${precent}%`);
                        setTimeout(get_data, 3500);
                    },
                    error: function() {
                        setTimeout(get_data, 4000);
                    }
                });
            };
            
            // Start
            get_data();
        });
    </script>
@endsection
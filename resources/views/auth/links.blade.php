<div id="authLinks">
    {{-- Youtube --}}
    @if (config('auth.youtube.status') != 'disabled')
        <a class="btn btn-danger btn-block" href="{{ route('auth.redirect', ['slug' => 'youtube']) }}">
            <i class="fa fa-youtube-play" aria-hidden="true"></i> @lang('auth.services.youtube')
        </a>
    @endif
    {{-- Twitch --}}
    @if (config('auth.twitch.status') != 'disabled')
        <a class="btn btn-primary btn-block" href="{{ route('auth.redirect', ['slug' => 'twitch']) }}">
            <i class="fa fa-twitch" aria-hidden="true"></i> @lang('auth.services.twitch')
        </a>
    @endif
    {{-- Mixer --}}
    @if (config('auth.mixer.status') != 'disabled')
        <a class="btn btn-info btn-mixer btn-block" href="{{ route('auth.redirect', ['slug' => 'mixer']) }}">
            <i class="fa fa-xing" aria-hidden="true"></i> @lang('auth.services.mixer')
        </a>
    @endif
    {{-- Wait for redirect --}}
    <h4 class="box-placeholder auth-wait">
        <i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><br>
        @lang('auth.redirect')
    </h4>
    {{-- Iframe --}}
    <div style="display: none;" id="authIframe"></div>
</div>

@section('css')
    @parent
    <style>
        .btn-mixer, .btn-mixer[disabled]:focus, .btn-mixer[disabled]:hover, 
        .btn-mixer[disabled]:active, .btn-mixer[disabled]:active:focus {
            background: #2199e8 !important;
            border-color: #2199e8 !important;
        }
        .btn-mixer:hover {
            background: #018fff !important;
            border-color: #2199e8 !important; 
        }
        .btn-mixer:focus, .btn-mixer:active, .btn-mixer:active:focus {
            background: #2199e8 !important;
            border-color: #2199e8 !important;
        }
        #authLinks {
            display: block;
            text-align: center;
        }
        #authLinks a {
            margin-bottom: 5px;
            position: relative;
            padding-left: calc(2.3rem);
        }
        #authLinks a i {
            position: absolute;
            left: 0px;
            background: rgba(0, 0, 0, 0.26);
            width: 2.3rem;
            padding: 0.5rem 0.5rem;
            top: 0px;
            line-height: 1.25;
            border-top-left-radius: 3px;
            border-bottom-left-radius: 3px;
        }
        .auth-wait {
            display: none;
            margin-top: 25px;
            padding: 13px 5px;
            border-radius: 3px;
        }
        .auth-wait i {
            margin-bottom: 8px;
            color: #59438c;
        }
    </style>
@endsection

@section('scripts')
    @parent
    <script>
        $(function() {
            // Select auth method
            $('#authLinks a').on('click', function(event) {
                event.preventDefault();
                if ($(this).attr('disabled'))
                    return;
                var link = $(this).attr('href');
                var interval_id = false;
                $('#authLinks a').attr('disabled', 'disabled');
                $('.auth-wait').slideDown('fast');
                $('#authIframe').html('<iframe src="' + link + '"></iframe>');
                setTimeout(function() {
                    window.location = link;
                }, 5000);
                setTimeout(function() {
                    interval_id = setInterval(function() {
                        $('#authLinks a').attr('disabled', false);
                        $('.auth-wait').hide('fast');
                        clearInterval(interval_id);
                    }, 2000);
                }, 2000);
            });
            // Check auth status
            var notify = true;
            setInterval(function() {
                $.getJSON("{{ route('auth.check') }}", function( data ) {
                    if (data.status) {
                        window.location = "{{ route('home') }}";
                        if (notify == true) {
                            $.notify({ message: `@lang('auth.messages.success')` }, { type: 'success' });
                            setTimeout(function() { notify = true }, 3000);
                        }
                        notify = false;
                    }
                });
            }, 1500);
        });
    </script>
@endsection
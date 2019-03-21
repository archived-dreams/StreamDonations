@extends('layouts.blank')

@section('css')
    <link href="{{ asset('assets/css/donate.css') }}" rel="stylesheet">
    <style>
        body {
            background: rgba(0, 0, 0, 0) url("{{ asset(Storage::url('backgrounds/' . $settings['background'])) }}") repeat scroll center center;
        }
        .container .banner {
            background: rgba(0, 0, 0, 0) url("{{ asset(Storage::url('banners/' . $settings['banner'])) }}") repeat scroll center center;
        }
        @if ($user->smiles == 'false') 
            .maxlength {
                right: 14px;
            }
            .kappa {
                display: none;
            }
        @endif
        #submit {
            background-color: {{ $settings->button_color }} !important;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        {{-- Banner --}}
        <div class="banner">
            {{-- Avatar --}}
            <img src="{{ $user->avatar }}" class="avatar">
            {{-- Name --}}
            <h1 class="name">{{ $user->name }}</h1>
            {{-- Link --}}
            @if ($user->service() == 'twitch')
                <a href="https://twitch.tv/{{ $user->name }}" class="link" target="_blank"><i class="fa fa-twitch"></i> /{{ $user->name }}</a>
            @elseif ($user->service() == 'youtube')
                <a href="https://youtube.com/channel/{{ $user->service_id() }}" class="link" target="_blank"><i class="fa fa-youtube-play"></i> /channel/{{ $user->name }}</a>
            @elseif ($user->service() == 'mixer')
                <a href="https://mixer.com/{{ $user->name }}" class="link" target="_blank"><i class="fa fa-xing"></i> /id{{ $user->service_id() }}</a>
            @endif
        </div>
        {{-- Content --}}
        <div class="content">
            
            {{-- Donate form --}}
            {!! Form::open(['route' => ['donate.post', $user->service(), $user->service_id()], 'id' => 'postDonate', 'autocomplete' => 'off']) !!}
                {{-- Memo --}}
                {!! nl2br(e($settings->memo)) !!}<hr>
                {{-- Name --}}
                <div class="form-group">
                    {!! Form::text('name', '', ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('donations.donate.name.title')]) !!}
                </div>
                {{-- Amount --}}
                <div class="input-group">
                    <span class="input-group-addon">{!! config('app.currency_icon') !!}</span>
                    {!! Form::text('amount', $settings['amount_placeholder'], ['class' => 'form-control', 'id' => 'amount', 'placeholder' => trans('donations.donate.amount.title')]) !!}
                </div>
                <p class="help-block">@lang('donations.donate.amount.info', ['amount_minimum' => $settings->amount_minimum . ' ' . config('app.currency_icon')])</p>
                {{-- Message --}}
                <div style="position: relative">
                    {!! Form::textarea('message', '', ['class' => 'form-control', 'rows' => '4', 'maxlength' => $settings->max_message_length, 'id' => 'message', 'placeholder' => trans('donations.donate.message.title')]) !!}
                    <span class="maxlength">{{ $settings->max_message_length }}</span>
                    <a href="#" class="kappa"><img src="{{ asset(Storage::url('emotes/Kappa.png')) }}"></a>
                </div>
                
                {{-- Submit --}}
                <div class="form-footer">
                    {!! Form::button('<i class="fa fa-gift" aria-hidden="true"></i> ' . trans('donations.donate.submit'), ['class' => 'btn btn-primary btn-lg', 'type' => 'submit', 'id' => 'submit']) !!}
                </div>
            {!! Form::close() !!}
            
            {{-- Pay form --}}
            <div id="payForm">
                {{-- Back --}}
                <button class="back"><i aria-hidden="true" class="fa fa-long-arrow-left"></i> @lang('donations.donate.back')</button>
                {{-- Total --}}
                <div class="total"><span class="total-span"></span> {!! config('app.currency_icon') !!}</div>
                <div class="total-label">@lang('donations.donate.subtotal')</div>
                {{-- Methods --}}
                <div class="list-group payment-methods">
                    {{-- PayPal --}}
                    @if(config('paypal.status') == 'enabled' && $settings->paypal != '')
                        @include('donations.elements.paypal')
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="donation-footer">
        @lang('donations.donate.terms', ['modal' => 'termsAndConditionsModal'])
         <br><br>
        &copy; <a href="{{ route('home') }}">{{ config('app.title') }}</a> {{ date('Y') }}
    </div>
@endsection

@section('modals')

    {{-- Terms & Conditions --}}
    <div class="modal fade" id="termsAndConditionsModal" tabindex="-1" role="dialog" aria-labelledby="termsAndConditionsModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="termsAndConditionsModalLabel">@lang('donations.donate.conditions')</h4>
          </div>
          <div class="modal-body">
            <div class="element-select">
                {!! $conditions !!}
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('global.close')</button>
          </div>
        </div>
      </div>
    </div>

@endsection

@section('scripts')
    @parent
    <script>
        var _length = {{ $settings->max_message_length }};
        $(function() {
            // message length
            var message_trigger = function() {
                _length = {{ $settings->max_message_length }} - $(this).val().length;
                $('.maxlength').text(_length);
            }
            $('#message').on('keypress', message_trigger);
            $('#message').on('keyup', message_trigger);
            $('#message').on('change', message_trigger);
            // Emotes
            $('.kappa').popover({
                html: true,
                placement: 'top',
                trigger: 'click',
                content: `
                    <div class="emotes">
                        @foreach ($emotes as $emotion)
                            <img src="{{ asset(Storage::url($emotion)) }}" onclick="emotion('{{ basename($emotion, '.png') }}')">
                        @endforeach
                    </div>`
            });
            // Form
            $('#postDonate').ajaxForm({
                dataType: 'json', 
                success: function(data) { 
                    auto_notify(data); 
                    if (typeof data.id != 'undefined') {
                        $('#postDonate').fadeOut('slow');
                        $('#payForm').fadeIn('slow');
                        $('.total-span').text(number_format(data.amount, 2, '.', ''));
                        $('.payment-methods a').each(function() {
                            $(this).attr('href', $(this).attr('default-href').replace('0000', data.id));
                        });
                    }
                },
                error: function(data) { error_notify(data.responseJSON); }
            }); 
            // Back
            $('.back').on('click', function() {
                $('#postDonate').fadeIn('slow');
                $('#payForm').fadeOut('slow');
            });
        });
        function emotion(emotion) {
            if (_length < emotion.length) {
                $.notify({ message: `@lang('donations.donate.emotion_error')` },{ type: 'danger' });
                return;
            }
            $('#message').val(`${$('#message').val()} ${emotion}`);
            $('#message').trigger('change');
        }
        
    </script>
@endsection
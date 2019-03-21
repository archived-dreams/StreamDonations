@extends('layouts.app')

@section('content')

    {{-- Info --}}
    @if ($settings['paypal'] == '')
        <div class="alert alert-danger">
            @lang('settings.donation.paypal.not_activated')
        </div>
    @endif

    {{-- Donation Link --}}
    <div class="alert alert-info">
        @lang('settings.donation.link.info') 
        <a href="{{ Auth::user()->donation_link() }}" target="_blank">{{ Auth::user()->donation_link() }}</a>
    </div>

    {!! Form::open(['route' => 'settings.donation.save', 'id' => 'settingsDonationForm', 'files' => true, 'autocomplete' => 'off']) !!}
        {{-- PayPal Account --}}
        <div class="form-group">
            {!! Form::label('amount_minimum', trans('settings.donation.paypal.title')) !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-paypal" aria-hidden="true"></i></span>
                {!! Form::email('paypal', $settings['paypal'], ['class' => 'form-control', 'id' => 'paypal']) !!}
            </div>
        </div>
        {{-- Minimum Amount --}}
        <div class="form-group">
            {!! Form::label('amount_minimum', trans('settings.donation.amount_minimum.title')) !!}
            <div class="input-group">
                <span class="input-group-addon">{!! config('app.currency_icon') !!}</span>
                {!! Form::number('amount_minimum', $settings['amount_minimum'], ['class' => 'form-control', 'id' => 'amount_minimum', 'step' => '0.01', 'min' => '0.01', 'max' => '10000']) !!}
            </div>
            <p class="help-block">@lang('settings.donation.amount_minimum.info')</p>
        </div>
        {{-- Maximum Message Length --}}
        <div class="form-group">
            {!! Form::label('max_message_length', trans('settings.donation.max_message_length.title')) !!}
            {!! Form::number('max_message_length', $settings['max_message_length'], ['class' => 'form-control', 'id' => 'max_message_length', 'step' => '1', 'min' => '25', 'max' => '255']) !!}
            <p class="help-block">@lang('settings.donation.max_message_length.info')</p>
        </div>
        {{-- Suggested Amount --}}
        <div class="form-group">
            {!! Form::label('amount_placeholder', trans('settings.donation.amount_placeholder.title')) !!}
            <div class="input-group">
                <span class="input-group-addon">{!! config('app.currency_icon') !!}</span>
                {!! Form::number('amount_placeholder', $settings['amount_placeholder'], ['class' => 'form-control', 'id' => 'amount_placeholder', 'step' => '0.01', 'min' => '0.01', 'max' => '10000']) !!}
            </div>
            <p class="help-block">@lang('settings.donation.amount_placeholder.info')</p>
        </div>
        {{-- Your Page --}}
        <div class="form-group">
            <label>@lang('settings.donation.your_page')</label><br>
            <a href="{{ Auth::user()->donation_link() }}" target="_blank">{{ Auth::user()->donation_link() }}</a>
        </div>
        {{-- Button Color --}}
        <div class="form-group">
            {!! Form::label('button_color', trans('settings.donation.button_color.title')) !!}
            <div class="input-group colorpicker">
                {!! Form::text('button_color', $settings['button_color'], ['class' => 'form-control', 'id' => 'button_color']) !!}
                <span class="input-group-addon"><i></i></span>
            </div>
            <p class="help-block">@lang('settings.donation.button_color.info')</p>
        </div>
        {{-- Donation Memo --}}
        <div class="form-group">
            {!! Form::label('memo', trans('settings.donation.memo.title')) !!}
            {!! Form::textarea('memo', $settings['memo'], ['class' => 'form-control', 'id' => 'memo']) !!}
            <p class="help-block">@lang('settings.donation.memo.info')</p>
        </div>
        {{-- Banner Override --}}
        <div class="form-group">
            {!! Form::label('donation_banner', trans('settings.donation.donation_banner.title')) !!}
            <div style="border: 1px dashed #aaa; max-width: 640px; width: 100%; height: 190px; border-radius: 4px; text-align: center; background: rgba(0, 0, 0, 0) url(&quot;{{ asset(Storage::url('banners/' . $settings['banner'])) }}&quot;) repeat scroll center center;" id="bannerBlock">
                <div class="input-group">
                    <label class="input-group-btn">
                        <span class="btn btn-primary" style="border-radius: 0px;">
                            @lang('global.browse') {!! Form::file('donation_banner', ['id' => 'donation_banner', 'accept' => 'image/*']) !!}
                        </span>
                    </label>
                    <input type="text" class="form-control" style="opacity: 0.8;" readonly>
                </div>
            </div>
            <p class="help-block">@lang('settings.donation.donation_banner.info')</p>
        </div>
        {{-- Background --}}
        <div class="form-group">
            {!! Form::label('background', trans('settings.donation.background.title')) !!}
            {!! Form::hidden('background', $settings['background'], ['id' => 'background']) !!}
            <div style="border: 1px dashed #aaa; padding: 50px; border-radius: 4px; text-align: center; background: rgba(0, 0, 0, 0) url(&quot;{{ asset(Storage::url('backgrounds/' . $settings['background'])) }}&quot;) repeat scroll center center;" id="backgroundBlock">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-primary" tabindex="-1" data-toggle="modal" data-target="#backgroundModal">@lang('global.select_from_library')</button>
                    </span>
                    <div class="input-group">
                        <label class="input-group-btn">
                            <span class="btn btn-secondary" style="border-radius: 0px;">
                                @lang('global.browse') {!! Form::file('background_file', ['accept' => 'image/*', 'id' => 'background_file']) !!}
                            </span>
                        </label>
                        <input type="text" class="form-control" style="opacity: 0.8;" readonly>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Submit --}}
        {!! Form::submit(trans('settings.donation.save'), ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
    
@endsection

@section('modals')

    {{-- Background library --}}
    <div class="modal fade" id="backgroundModal" tabindex="-1" role="dialog" aria-labelledby="backgroundModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="backgroundModalLabel">@lang('settings.donation.background.title')</h4>
          </div>
          <div class="modal-body">
            <div class="element-select">
                @foreach ($patterns as $file)
                    <span class="pattern" onclick="setBackground('{{ basename($file) }}', '{{ asset(Storage::url($file)) }}');" style="background: rgba(0, 0, 0, 0) url(&quot;{{ asset(Storage::url($file)) }}&quot;) repeat scroll 0% 0%;"></span>
                @endforeach
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('global.cancel')</button>
          </div>
        </div>
      </div>
    </div>
    
@endsection

@section('css')
    <style>
        #donation_banner, #background_file {
            display: none;
        }
        #bannerBlock .input-group {
            margin: 50px;
            margin-top: 80px;
            width: 80%;
        }
    </style>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#settingsDonationForm').ajaxForm({ 
                dataType: 'json', 
                success: function(data) {
                    auto_notify(data);
                    if (data.success) {
                        $('#backgroundBlock').html($('#backgroundBlock').html());
                        $('#bannerBlock').html($('#bannerBlock').html());
                        triggers();
                    }
                },
                error: function(data) {
                    error_notify(data.responseJSON);
                }
            }); 
        });
        // Select background from library
        function setBackground(file, link) {
            $('#backgroundBlock').html($('#backgroundBlock').html());
            $('#background').val('patterns/' + file);
            $('#backgroundModal').modal('hide');
            $('#backgroundBlock').css('background-image', `url(${link})`);
            $('#backgroundBlock .form-control').val( file );
            triggers();
        }
        
        var triggers = function() {
            // Set background
            $('#backgroundBlock [type="file"]').on('change', function() {
                $('#background').val('user');
                var input = this;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#backgroundBlock').css('background-image', `url(${e.target.result})`);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
            // Set banner
            $('#bannerBlock [type="file"]').on('change', function() {
                var input = this;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#bannerBlock').css('background-image', `url(${e.target.result})`);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
            file_set_trigger();
        }
        
        
        $(function() {
            // start triggers
            triggers();
        });
    </script>
@endsection
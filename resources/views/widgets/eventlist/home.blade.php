@extends('layouts.app')

@section('content')

    {{-- Donation Link --}}
    <div class="alert alert-info">
        @lang('widgets.eventlist.home.info')<br>
        <div class="input-group">
            <span class="input-group-addon">@lang('widgets.url')</span>
            <div class="form-guard">
                <div class="form-guard-info"><i class="fa fa-lock"></i> @lang('widgets.guard_info')</div>
                {{ Form::text('', route('widgets.eventlist.widget', [ 'token' => $settings['token']]), [ 'autocomplete' => 'off', 'type' => 'text', 'class' => 'form-control', 'id' => 'widget-link' ]) }}
            </div>
            <div class="input-group-btn">
                <button type="button" class="btn btn-primary launch-widget" data-width="500" data-height="750" tabindex="-1">@lang('widgets.launch')</button>
            </div>
        </div>
    </div>
    
    {{-- Settings --}}
    {!! Form::open(['route' => 'widgets.eventlist.save', 'id' => 'widgetsEventlistForm']) !!}
    
        {{-- Amount of elements --}}
        <div class="form-group">
            {!! Form::label('limit', trans('widgets.eventlist.home.limit')) !!}
            {!! Form::select('limit', [10 => 10, 25 => 25, 50 => 50, 100 => 100], $settings['limit'], ['class' => 'form-control selectpicker', 'id' => 'limit']) !!}
        </div>
        {{-- Theme --}}
        <div class="form-group">
            {!! Form::label('theme', trans('widgets.eventlist.home.theme.title')) !!}
            {!! Form::select('theme', ['standard' => trans('widgets.eventlist.home.theme.standard'), 'dark' => trans('widgets.eventlist.home.theme.dark')], $settings['theme'], ['class' => 'form-control selectpicker', 'id' => 'theme']) !!}
        </div>
        {{-- Types of donations --}}
        <div class="form-group">
            {!! Form::label('message-status', trans('widgets.eventlist.home.types.title')) !!}
            {!! Form::select('message_status[]', ['success' => trans('widgets.eventlist.home.types.success'), 'user' => trans('widgets.eventlist.home.types.user')], $settings['message_status'], ['class' => 'form-control selectpicker', 'id' => 'message-status', 'multiple' => 'multiple', 'data-actions-box' => 'true']) !!}
        </div>
        {{-- New Token --}}
        <div class="form-group">
            <label>
                {!! Form::checkbox('new-token', 'true', false, ['class' => 'checkbox', 'id' => 'new-token']) !!}
                <span>@lang('widgets.eventlist.home.new-token')</span>
            </label>
        </div>

        {{-- Submit --}}
        {!! Form::submit(trans('widgets.eventlist.home.save'), ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}


@endsection

@section('scripts')
    <script>
        $(function() {
            $('#widgetsEventlistForm').ajaxForm({ 
                dataType: 'json', 
                success: function(data) {
                    auto_notify(data);
                    if ($('#new-token').prop('checked')) {
                        $('#widget-link').val(data.widget);
                        $('#new-token').prop('checked', false);
                        if (typeof window.launched_widget !== 'undefined') {
                            window.launched_widget.location.href = data.widget;
                        }
                    }
                },
                error: function(data) {
                    error_notify(data.responseJSON);
                }
            }); 
        });
    </script>
@endsection
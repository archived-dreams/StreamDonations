@extends('layouts.app')

@section('content')

    {{-- Widget Link --}}
    <div class="alert alert-info">
        @lang('widgets.donationgoal.home.info')<br>
        <div class="input-group">
            <span class="input-group-addon">@lang('widgets.url')</span>
            <div class="form-guard">
                <div class="form-guard-info"><i class="fa fa-lock"></i> @lang('widgets.guard_info')</div>
                {{ Form::text('', route('widgets.donationgoal.widget', [ 'token' => $settings['token']]), [ 'autocomplete' => 'off', 'type' => 'text', 'class' => 'form-control', 'id' => 'widget-link' ]) }}
            </div>
            <div class="input-group-btn"> 
                <button type="button" class="btn btn-primary launch-widget" data-width="900" data-height="650" tabindex="-1">@lang('widgets.launch')</button>
            </div>
        </div>
    </div>
    
    {{-- Settings --}}
    {!! Form::open(['route' => 'widgets.donationgoal.save', 'id' => 'widgetsDonationgoalForm', 'autocomplete' => 'off']) !!}
    
        {{-- Sections --}}
        <ul class="nav nav-tabs nav-tabs-bordered">
            <li class="nav-item"><a href="#manage-sections" class="nav-link active" data-toggle="tab">@lang('widgets.donationgoal.home.sections.manage')</a></li>
            <li class="nav-item"><a href="#settings-sections" class="nav-link" data-toggle="tab">@lang('widgets.donationgoal.home.sections.settings')</a></li>
        </ul>
        <div class="tab-content tabs-bordered">
            
            {{-- SECTION :: Manage Goal --}}
            <div class="tab-pane fade in active" id="manage-sections">
                            
                {{-- Title --}}
                <div class="form-group">
                    {!! Form::label('title', trans('widgets.donationgoal.home._title')) !!}
                    {!! Form::text('title', $settings['title'], ['class' => 'form-control', 'id' => 'title']) !!}
                </div>
                
                {{-- Created at --}}
                <div class="form-group">
                    {!! Form::label('created_at', trans('widgets.donationgoal.home.created_at')) !!}
                    {!! Form::text('created_at', $settings['created_at'], ['class' => 'form-control', 'id' => 'created_at', 'disabled' => 'disabled']) !!}
                </div>
                
                {{-- Goal Amount --}}
                <div class="form-group">
                    {!! Form::label('goal_amount', trans('widgets.donationgoal.home.goal_amount')) !!}
                    {!! Form::number('goal_amount', $settings['goal_amount'], ['class' => 'form-control', 'id' => 'goal_amount', 'step' => '0.01', 'min' => '0.01']) !!}
                </div>
                
                {{-- Starting Amount --}}
                <div class="form-group">
                    {!! Form::label('manual_goal_amount', trans('widgets.donationgoal.home.manual_goal_amount')) !!}
                    {!! Form::number('manual_goal_amount', $settings['manual_goal_amount'], ['class' => 'form-control', 'id' => 'manual_goal_amount', 'step' => '0.01', 'min' => '0.01']) !!}
                </div>
                
            </div>

            
            {{-- SECTION :: Settings --}}
            <div class="tab-pane fade" id="settings-sections">
                
                {{-- Layout --}}
                <div class="form-group">
                    {!! Form::label('layout', trans('widgets.donationgoal.home.layout.title')) !!}
                    {!! Form::select('layout', [
                        'standard' => trans('widgets.donationgoal.home.layout.standard'),
                        'condensed' => trans('widgets.donationgoal.home.layout.condensed')
                        ], $settings['layout'], ['class' => 'form-control selectpicker', 'id' => 'layout']) !!}
                </div>
        
                {{-- Background --}}
                <div class="form-group">
                    {!! Form::label('background_color', trans('widgets.donationgoal.home.background_color')) !!}
                    <div class="input-group colorpicker">
                        {!! Form::text('background_color', $settings['background_color'], ['class' => 'form-control', 'id' => 'background_color']) !!}
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
        
                {{-- Text Color --}}
                <div class="form-group">
                    {!! Form::label('font_color', trans('widgets.donationgoal.home.font_color')) !!}
                    <div class="input-group colorpicker">
                        {!! Form::text('font_color', $settings['font_color'], ['class' => 'form-control', 'id' => 'font_color']) !!}
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
        
                {{-- Bar Text Color --}}
                <div class="form-group">
                    {!! Form::label('bar_text_color', trans('widgets.donationgoal.home.bar_text_color')) !!}
                    <div class="input-group colorpicker">
                        {!! Form::text('bar_text_color', $settings['bar_text_color'], ['class' => 'form-control', 'id' => 'bar_text_color']) !!}
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
        
                {{-- Bar Color --}}
                <div class="form-group">
                    {!! Form::label('bar_color', trans('widgets.donationgoal.home.bar_color')) !!}
                    <div class="input-group colorpicker">
                        {!! Form::text('bar_color', $settings['bar_color'], ['class' => 'form-control', 'id' => 'bar_color']) !!}
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
        
                {{-- Bar Background Color --}}
                <div class="form-group">
                    {!! Form::label('bar_background_color', trans('widgets.donationgoal.home.bar_background_color')) !!}
                    <div class="input-group colorpicker">
                        {!! Form::text('bar_background_color', $settings['bar_background_color'], ['class' => 'form-control', 'id' => 'bar_background_color']) !!}
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
                
                {{-- Bar Thickness --}}
                <div class="form-group">
                    {!! Form::label('bar_thickness', trans('widgets.donationgoal.home.bar_thickness.title')) !!}
                    {!! Form::hidden('bar_thickness', $settings['bar_thickness'], ['id' => 'bar_thickness']) !!}
                    <div id="bar_thickness-slider"></div>
                    <p class="help-block" id="bar_thickness-info">@lang('widgets.donationgoal.home.bar_thickness.info', ['size' => $settings['bar_thickness']])</p>
                </div>
                
                {{-- Font --}}
                <div class="form-group">
                    {!! Form::label('font', trans('widgets.donationgoal.home.font')) !!}
                    {!! Form::select('font', $fonts, $settings['font'], ['class' => 'form-control selectpicker', 'id' => 'font', 'data-live-search' => 'true']) !!}
                </div>
                
                {{-- New Token --}}
                <div class="form-group">
                    <label>
                        {!! Form::checkbox('new-token', 'true', false, ['class' => 'checkbox', 'id' => 'new-token']) !!}
                        <span>@lang('widgets.alertbox.home.new-token')</span>
                    </label>
                </div>
                
            </div>
        </div>
        <br>
        {{-- Submit --}}
        {!! Form::submit(trans('widgets.donationgoal.home.save'), ['class' => 'btn btn-primary']) !!}
        {{-- New goal --}}
        {!! Form::hidden('new_goal', 'false', ['id' => 'new_goal']) !!}
        {!! Form::button(trans('widgets.donationgoal.home.new'), ['class' => 'btn btn-danger', 'onclick' => '$("#new_goal").val("true"); $("#widgetsDonationgoalForm").submit();']) !!}
    {!! Form::close() !!}


@endsection

@section('scripts')
    <script>
        /* Form */
        $(function() {
            $('#widgetsDonationgoalForm').ajaxForm({ 
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
                    if ($('#new_goal').val() == 'true') {
                        $('#new_goal').val('false');
                        $('#created_at').val(data.created_at);
                    }
                },
                error: function(data) {
                    error_notify(data.responseJSON);
                }
            });
        });
        
        // Bar Thickness
        noUiSlider.create(document.getElementById('bar_thickness-slider'), {
        	start: {{ $settings['bar_thickness'] }},
        	connect: true,
        	step: 1,
        	range: { 'min': 32, 'max': 128 }
        }).on('update', function( values, handle ) {
            $('#bar_thickness').val(parseInt(values[handle]));
            $('#bar_thickness-info').text(`@lang('widgets.donationgoal.home.bar_thickness.info')`.replace(':size', parseInt(values[handle])));
        });
        



    </script>
@endsection
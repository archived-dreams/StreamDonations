@extends('layouts.app')

@section('content')

    {{-- Widget Link --}}
    <div class="alert alert-info">
        @lang('widgets.alertbox.home.info')<br>
        <div class="input-group">
            <span class="input-group-addon">@lang('widgets.url')</span>
            <div class="form-guard">
                <div class="form-guard-info"><i class="fa fa-lock"></i> @lang('widgets.guard_info')</div>
                {{ Form::text('', route('widgets.alertbox.widget', [ 'token' => $settings['token']]), [ 'autocomplete' => 'off', 'type' => 'text', 'class' => 'form-control', 'id' => 'widget-link' ]) }}
            </div>
            <div class="input-group-btn">
                <button type="button" class="btn btn-default launch-widget" data-width="900" data-height="650" tabindex="-1">@lang('widgets.launch')</button>
            </div>
        </div>
    </div>
    
    {{-- Settings --}}
    {!! Form::open(['route' => 'widgets.alertbox.save', 'id' => 'widgetsAlertboxForm', 'autocomplete' => 'off']) !!}
    
        {{-- Sections --}}
        <ul class="nav nav-tabs nav-tabs-bordered">
            <li class="nav-item"><a href="#message-sections" class="nav-link active" data-toggle="tab">@lang('widgets.alertbox.home.sections.message')</a></li>
            <li class="nav-item"><a href="#sound-sections" class="nav-link" data-toggle="tab">@lang('widgets.alertbox.home.sections.sound')</a></li>
            <li class="nav-item"><a href="#voice-sections" class="nav-link" data-toggle="tab">@lang('widgets.alertbox.home.sections.voice')</a></li>
            <li class="nav-item"><a href="#other-sections" class="nav-link" data-toggle="tab">@lang('widgets.alertbox.home.sections.other')</a></li>
        </ul>
        <div class="tab-content tabs-bordered">
            
            {{-- SECTION :: Message --}}
            <div class="tab-pane fade in active" id="message-sections">
                            
                {{-- Message Template --}}
                <div class="form-group">
                    {!! Form::label('message_template', trans('widgets.alertbox.home.message_template.title')) !!}
                    {!! Form::text('message_template', $settings['message_template'], ['class' => 'form-control', 'id' => 'message_template']) !!}
                    <p class="help-block">@lang('widgets.alertbox.home.message_template.info')</p>
                </div>
        
                {{-- Text Animation --}}
                <div class="form-group">
                    {!! Form::label('text_animation', trans('widgets.alertbox.home.text_animation')) !!}
                    {!! Form::select('text_animation', $text_animations, $settings['text_animation'], ['class' => 'form-control selectpicker', 'id' => 'text_animation']) !!}
                </div>
        
                {{-- Font --}}
                <div class="form-group">
                    {!! Form::label('font', trans('widgets.alertbox.home.font')) !!}
                    {!! Form::select('font', $fonts, $settings['font'], ['class' => 'form-control selectpicker', 'id' => 'font', 'data-live-search' => 'true']) !!}
                </div>
                
                {{-- Font Size --}}
                <div class="form-group">
                    {!! Form::label('font_size', trans('widgets.alertbox.home.font_size.title')) !!}
                    {!! Form::hidden('font_size', $settings['font_size'], ['id' => 'font_size']) !!}
                    <div id="font_size-slider"></div>
                    <p class="help-block" id="font_size-info">@lang('widgets.alertbox.home.font_size.info', ['size' => $settings['font_size']])</p>
                </div>
        
                {{-- Font #1 Color --}}
                <div class="form-group">
                    {!! Form::label('font_color', trans('widgets.alertbox.home.font_color')) !!}
                    <div class="input-group colorpicker">
                        {!! Form::text('font_color', $settings['font_color'], ['class' => 'form-control', 'id' => 'font_color']) !!}
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
        
                {{-- Font #2 Color --}}
                <div class="form-group">
                    {!! Form::label('font_color2', trans('widgets.alertbox.home.font_color2')) !!}
                    <div class="input-group colorpicker">
                        {!! Form::text('font_color2', $settings['font_color2'], ['class' => 'form-control', 'id' => 'font_color2']) !!}
                        <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
                
                {{-- Image --}}
                <div class="form-group">
                    {!! Form::label('background', trans('widgets.alertbox.home.image.title')) !!}
                    {!! Form::hidden('image', $settings['image'], ['id' => 'image']) !!}
                    <div id="imageBlock">
                        <img src="{{ asset(Storage::url('alertbox/images/' . $settings['image'])) }}" id="imagePreview">
                        <div class="input-group form-position">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" tabindex="-1" data-toggle="modal" data-target="#imagesModal">@lang('global.select_from_library')</button>
                            </span>
                            <div class="input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-secondary" style="border-radius: 0px;">
                                        @lang('global.browse') {!! Form::file('image_file', ['accept' => 'image/*', 'id' => 'image_file']) !!}
                                    </span>
                                </label>
                                <input type="text" class="form-control" style="opacity: 0.8;" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
            {{-- SECTION :: Sound --}}
            <div class="tab-pane fade" id="sound-sections">
        
                {{-- Sound --}}
                <div class="form-group">
                    {!! Form::label('background', trans('widgets.alertbox.home.sound.title')) !!}
                    {!! Form::hidden('sound', $settings['sound'], ['id' => 'sound']) !!}
                    <div id="soundBlock">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" tabindex="-1" data-toggle="modal" data-target="#soundsModal">@lang('global.select_from_library')</button>
                            </span>
                            <div class="input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-secondary" style="border-radius: 0px;">
                                        @lang('global.browse') {!! Form::file('sound_file', ['accept' => 'audio/*', 'id' => 'sound_file']) !!}
                                    </span>
                                </label>
                                <input type="text" class="form-control" readonly>
                            </div>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" tabindex="-1" onclick="playSelected();">
                                    <i class="fa fa-play" aria-hidden="true"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                
                {{-- Sound Volume --}}
                <div class="form-group">
                    {!! Form::label('sound_volume', trans('widgets.alertbox.home.sound_volume.title')) !!}
                    {!! Form::hidden('sound_volume', $settings['sound_volume'], ['id' => 'sound_volume']) !!}
                    <div id="sound_volume-slider"></div>
                    <p class="help-block" id="sound_volume-info">@lang('widgets.alertbox.home.sound_volume.info', ['volume' => $settings['sound_volume']])</p>
                </div>
            
            </div>
            
            {{-- SECTION :: Voice --}}
            <div class="tab-pane fade" id="voice-sections">
                
                {{-- Voice --}}
                <div class="form-group">
                    {!! Form::label('voice', trans('widgets.alertbox.home.voice.title')) !!}
                    {!! Form::select('voice', [ 
                        'true' => trans('widgets.alertbox.home.voice.true'), 
                        'false' => trans('widgets.alertbox.home.voice.false')
                        ], $settings['voice'], ['class' => 'form-control selectpicker', 'id' => 'voice']) !!}
                </div>
        
                {{-- Language --}}
                <div class="form-group">
                    {!! Form::label('voice_language', trans('widgets.alertbox.home.voice.language')) !!}
                    {!! Form::select('voice_language', $voice_languages, $settings['voice_language'], ['class' => 'form-control selectpicker', 'id' => 'voice_language']) !!}
                </div>
        
                {{-- Voice --}}
                <div class="form-group">
                    {!! Form::label('voice_speaker', trans('widgets.alertbox.home.voice.speaker')) !!}
                    {!! Form::select('voice_speaker', $voice_speakers, $settings['voice_speaker'], ['class' => 'form-control selectpicker', 'id' => 'voice_speaker']) !!}
                </div>
        
                {{-- Emotion --}}
                <div class="form-group">
                    {!! Form::label('voice_emotion', trans('widgets.alertbox.home.voice.emotion.title')) !!}
                    {!! Form::select('voice_emotion', [ 
                        'neutral' => trans('widgets.alertbox.home.voice.emotion.neutral'),
                        'good' => trans('widgets.alertbox.home.voice.emotion.good'),
                        'evil' => trans('widgets.alertbox.home.voice.emotion.evil')
                        ], $settings['voice_emotion'], ['class' => 'form-control selectpicker', 'id' => 'voice_emotion']) !!}
                </div>
                
            </div>
            
            {{-- SECTION :: Other --}}
            <div class="tab-pane fade" id="other-sections">
                
                {{-- Duration --}}
                <div class="form-group">
                    {!! Form::label('duration', trans('widgets.alertbox.home.duration.title')) !!}
                    {!! Form::hidden('duration', $settings['duration'], ['id' => 'duration']) !!}
                    <div id="duration-slider"></div>
                    <p class="help-block" id="duration-info">@lang('widgets.alertbox.home.duration.info', ['duration' => $settings['duration']])</p>
                </div>
        
                {{-- Background --}}
                <div class="form-group">
                    {!! Form::label('background_color', trans('widgets.alertbox.home.background_color')) !!}
                    <div class="input-group colorpicker">
                        {!! Form::text('background_color', $settings['background_color'], ['class' => 'form-control', 'id' => 'background_color']) !!}
                        <span class="input-group-addon"><i></i></span>
                    </div>
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


        {{-- Submit --}}
        {!! Form::submit(trans('widgets.alertbox.home.save'), ['class' => 'btn btn-primary', 'style' => 'margin-top: 15px']) !!}
    {!! Form::close() !!}


@endsection

@section('modals')

    {{-- Images library --}}
    <div class="modal fade" id="imagesModal" tabindex="-1" role="dialog" aria-labelledby="imagesModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="imagesModalLabel">@lang('widgets.alertbox.home.image.title')</h4>
          </div>
          <div class="modal-body">
            <div class="element-select">
                @foreach ($images as $file)
                    <div class="image-block" onclick="setImage('{{ basename($file) }}', '{{ asset(Storage::url($file)) }}');">
                        <img src="{{ asset(Storage::url($file)) }}">
                    </div>
                @endforeach
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('global.cancel')</button>
          </div>
        </div>
      </div>
    </div>

    {{-- Sounds library --}}
    <div class="modal fade" id="soundsModal" tabindex="-1" role="dialog" aria-labelledby="soundsModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="soundsModalLabel">@lang('widgets.alertbox.home.sound.title')</h4>
          </div>
          <div class="modal-body">
            <div class="element-select">
                <div class="list-group">
                    @foreach ($sounds as $file)
                        <div class="list-group-item sound" onclick="setSound('{{ basename($file) }}', '{{ $file }}');">
                            <i class="fa fa-music fa-fw"></i> {{ basename($file) }}
                            <span onclick="sound_library[`{{ $file }}`].play();" class="pull-right">
                                <i class="fa fa-play" aria-hidden="true"></i>
                            </span>
                        </div>
                    @endforeach
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('global.cancel')</button>
          </div>
        </div>
      </div>
    </div>

@endsection

@section('css')
    <style>
        #image_file, #sound_file {
            display: none;
        }
        #imageBlock {
            border: 1px dashed #aaa; 
            height: 220px; 
            position: relative; 
            border-radius: 4px; 
            text-align: center; 
            background: rgba(0, 0, 0, 0);
            overflow: hidden;
        }
        #imageBlock .form-position {
            position: absolute;
            max-width: 400px;
            padding: 7px;
            top: 50%; 
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
        }
        #imagePreview {
            position: absolute;
            max-height: 200px;
            max-width: 100%;
            top: 50%; 
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
        }
    </style>
@endsection

@section('scripts')
    <script>
        /* Form */
        $(function() {
            $('#widgetsAlertboxForm').ajaxForm({ 
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
        
        
        
        /* Image */    
        
        // Image :: Trigger
        var image_trigger = function() {
            $('#imageBlock [type="file"]').on('change', function() {
                $('#image').val('user');
                var input = this;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#imagePreview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
            file_set_trigger();
        }
            
        // Image :: Set From Library
        function setImage(file, link) {
            $('#imageBlock').html($('#imageBlock').html());
            $('#image').val('library/' + file);
            $('#imagesModal').modal('hide');
            $('#imagePreview').attr('src', link);
            $('#imageBlock .form-control').val( file );
            file_set_trigger();
            image_trigger();
        }
    
        
        /* Sound */
        
        // Sound :: Trigger
        var sound_trigger = function() {
            $('#soundBlock [type="file"]').on('change', function() {
                $('#sound').val('user');
                var input = this;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        sound_library['user'] = new Howl({ src: [e.target.result] });
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
            file_set_trigger();
        }
        
        // Sound :: Set From Library
        function setSound(file, link) {
            $('#soundBlock').html($('#soundBlock').html());
            $('#sound').val('library/' + file);
            $('#soundsModal').modal('hide');
            $('#soundBlock .form-control').val( file );
            sound_set_trigger();
        }
            
        // Sounds
        var sound_library = {};
        @foreach ($sounds as $file)
            sound_library[`{{ $file }}`] = new Howl({ src: [`{{ asset(Storage::url($file)) }}`] });
        @endforeach
        if (typeof sound_library[`alertbox/sounds/{{ $settings['sound'] }}`] === 'undefined')
            sound_library[`alertbox/sounds/{{ $settings['sound'] }}`] = new Howl({ src: [`{{ asset(Storage::url('alertbox/sounds/' . $settings['sound'])) }}`] });
            
        // Play selected sound
        function playSelected() {
            var sound = $('#sound').val();
            if (sound != 'user')
                sound = 'alertbox/sounds/' + sound;
            if (typeof sound_library[sound] !== 'undefined')
                sound_library[sound].play();
            else 
                console.error('Sound :: ' + sound);
        }
        
        // Sound :: Volume
        noUiSlider.create(document.getElementById('sound_volume-slider'), {
        	start: {{ $settings['sound_volume'] }},
        	connect: true,
        	step: 1,
        	range: { 'min': 0, 'max': 100 }
        }).on('update', function( values, handle ) {
            $('#sound_volume').val(parseInt(values[handle]));
            if (parseInt(values[handle]) != 0)
                $('#sound_volume-info').text(`@lang('widgets.alertbox.home.sound_volume.info')`.replace(':volume', parseInt(values[handle])));
            else
                $('#sound_volume-info').html(`<span class="label label-danger">@lang('widgets.alertbox.home.sound_volume.disabled')</span>`);
        });
        
        // Font Size
        noUiSlider.create(document.getElementById('font_size-slider'), {
        	start: {{ $settings['font_size'] }},
        	connect: true,
        	step: 1,
        	range: { 'min': 12, 'max': 80 }
        }).on('update', function( values, handle ) {
            $('#font_size').val(parseInt(values[handle]));
            $('#font_size-info').text(`@lang('widgets.alertbox.home.font_size.info')`.replace(':size', parseInt(values[handle])));
        });
        
        
        /* Duration */
        noUiSlider.create(document.getElementById('duration-slider'), {
        	start: {{ $settings['duration'] }},
        	connect: true,
        	step: 1,
        	range: { 'min': 1, 'max': 25 }
        }).on('update', function( values, handle ) {
            $('#duration').val(parseInt(values[handle]));
            $('#duration-info').text(`@lang('widgets.alertbox.home.duration.info')`.replace(':duration', parseInt(values[handle])));
        });
            

        /* Triggers */
        $(function() {
            image_trigger();
            sound_trigger();
        });
        

    </script>
@endsection
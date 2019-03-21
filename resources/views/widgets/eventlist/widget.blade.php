@extends('layouts.blank')

@section('css')
    <style>
        .theme-dark {
            filter: invert(100%);
        }
        .theme-dark img, .theme-dark .text-primary {
            filter: invert(100%);
        }
        .theme-dark-html {
            background: black;
        }
        #loading {
            position: fixed;
            top: 0px;
            top: 50%;
            left: 50%;
            bottom: 0px;
            transform: translate(-50%,-50%);
        }
        .panel {
            border-radius: 0px;
            margin: 0px;
            border-width: 0px;
        }
        body {
            background-color: #fff;
            overflow-x: hidden;
            max-width: 100%;
            color: black;
        }
        .panel-heading {
            padding: 10px 15px;
        }
        .list-group-item {
            border-right-width: 0px;
            border-left-width: 0px;
        }
    </style>
@endsection

@section('content')
    <div id="content" style="filter: blur(5px);">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-newspaper-o fa-fw"></i> @yield('title', $title)
            </div>
            <div class="panel-body">
                <div class="list-group" id="messages"></div>
            </div>
        </div>
    </div>
    <div id="loading"><i class="fa fa-spinner fa-spin fa-5x fa-fw"></i></div>
@endsection

@section('scripts')
    <script>
        var settings = {};
        var first_check = true;
        $(function() {
            // Get data
            var get_data = function() {
                $.ajax({
                  dataType: "json",
                  url: "{{ route('widgets.eventlist.widget.get', [ 'token' => $settings['token'] ]) }}?" + Math.random(),
                  success: function(data) {
                      // First check
                      if (first_check) {
                          $('#content').css('filter', 'none');
                          $('#loading').remove();
                          first_check = false;
                      }
                      // Update settings
                      settings(data.settings);
                      // Update messages
                      messages(data.messages);
                      setTimeout(get_data, 4000);
                  },
                  error: function() {
                      setTimeout(get_data, 4000);
                  }
                });
            };
            // Settings
            var settings = function(new_settings) {
                $.each(new_settings, function( key, val ) {
                    if (typeof settings[key] == 'undefined' || settings[key] != val) {
                        settings[key] = val;
                        if (key == 'theme') {
                            $('body').attr('class', `theme-${val}`);
                            $('html').attr('class', `theme-${val}-html`);
                        }
                    }
                });
            };
            // Messages
            var messages = function(data) {
                $('#messages > div').attr('data-check', 'false');
                var previous = 0;
                $.each(data, function( key, message ) {
                    if ($(`#messages [data-id="${message.id}"]`).length > 0) {
                        $(`#messages [data-id="${message.id}"]`).attr('data-check', 'true');
                        previous = message.id;
                        return;
                    } else {
                        var html = `
                        <div class="list-group-item" data-id="${message.id}">
                            <i class="fa fa-credit-card fa-fw"></i> ${escapeHtml(message.name)} <span class="text-primary">@lang('widgets.eventlist.widget.donated')</span> ${number_format(message.amount, 2, '.', '')} {!! config('app.currency_icon') !!}
                            <span class="pull-right text-muted small"><em>${message.updated_at}</em></span><br>
                            ${message.message}
                        </div>`;
                        if (previous === 0)
                            $('#messages').html(html);
                        else
                            $(`#messages [data-id="${previous}"]`).after(html);
                        previous = message.id;
                    }
                });
                $('#messages > div[data-check="false"]').remove();
            };
            // Start
            get_data();
        });
    </script>
@endsection
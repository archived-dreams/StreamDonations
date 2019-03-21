@extends('layouts.app')

@section('css')
    <style>
        @media screen and (max-width: 480px) { 
            #usersTable {
                margin-left: -30px !important;
            }
        }
        #usersTable td {
            position: relative;
            overflow: hidden;
        }
        #usersTable img.avatar {
            width: 36px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
        }
        #usersTable img.avatar-background {
            position: absolute;
            margin-top: -15px;
            margin-left: -12px;
            z-index: 1;
            width: 76px;
            height: 60px;
            filter: blur(5px);
        }
    </style>
@endsection

@section('content')

    {{-- Messages --}}
    <table id="usersTable" class="table table-striped table-bordered table-hover">
        <thead> 
        <tr>
            <th style="max-width: 25px;"></th>
            <th>@lang('apanel.users.id')</th>
            <th>@lang('apanel.users.name')</th>
            {{-- <th>@lang('apanel.users.balance')</th> --}}
            <th>@lang('apanel.users.email')</th>
            <th>@lang('apanel.users.timezone')</th>
            <th>@lang('apanel.users.token')</th>
            <th>@lang('apanel.users.created_at')</th>
            <th></th>
        </tr>
        </thead>
    </table>
    
@endsection

@section('scripts')
    <script>
        var usersTable;
        $(function() {
                
            usersTable = $('#usersTable').DataTable({
                serverSide: true,
                processing: true,
                iDisplayLength: -1,
                bAutoWidth: false,
                bScrollAutoCss: true,
                order: [[ 1, "desc" ]],
                ajax: `{{ route('apanel.users.data') }}`,
                columns: [
                    { 
                        data: "avatar", 
                        render: function(data) {
                            if (data == '')
                                data = "{{ config('auth.default_avatar') }}";
                            return `<img src="${data}" class="avatar"><img src="${data}" class="avatar-background">`;
                        } 
                    },
                    { data: "id" },
                    {
                        data: "name",
                        render: function(data, type, full) {
                            return `<a href="{{ route('apanel.users.edit', ['id' => '0000']) }}">${data}</a>`.replace('0000', full.id);
                        }
                    },
                    {{-- { 
                        data: "balance", 
                        render: function (data, type, full, meta) {
                            return `${data} {!! config('app.currency_icon') !!}`;
                        }
                    },--}}
                    { 
                        data: "email", 
                        render: function (data, type, full, meta) {
                            return `<a href="mailto:${data}">${data}</a>`;
                        }
                    },
                    { 
                        data: "timezone", 
                        render: function (data, type, full, meta) {
                            if (data != null)
                                return data;
                            else
                                return `<i>{{ config('app.timezone') }}</i>`;
                        }
                    },
                    { data: "token" },
                    { data: "created_at" },
                    {
                        render: function (data, type, full, meta) {
                            var data = full.token.split('::');
                            var html = '<div class="btn-group">';
                            // Social Link
                            if (data[0] == 'twitch')
                                html += `<a href="https://twitch.tv/${full.name}" class="btn btn-primary" target="_blank"><i class="fa fa-twitch"></i></a>`;
                            else if (data[0] == 'mixer')
                                html += `<a href="https://mixer.com/${full.name}" class="btn btn-primary" target="_blank"><i class="fa fa-xing"></i></a>`;
                            else if (data[0] == 'youtube')
                                html += `<a href="https://youtube.com/channel/${data[1]}" class="btn btn-primary" target="_blank"><i class="fa fa-youtube-play"></i></a>`;
                            // Edit button
                            html += `<a href="{{ route('apanel.users.edit', ['id' => '0000']) }}" class="btn btn-default"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>`.replace('0000', full.id);
                            return html + '</div>';
                        }
                    }
                ]
            });

        });
    </script>
@endsection
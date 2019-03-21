@extends('layouts.payment')

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
        .paymethod-buttons a {
            margin-bottom: 5px;
            position: relative;
            padding-left: calc(3.2rem);
        }
        .paymethod-buttons a i {
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
    </style>
@endsection

@section('buttons')
    {{-- Donate page --}}
    <a class="btn btn-primary" href="{{ route('donate', ['service' => $user->service(), 'id' => $user->service_id()]) }}">
        <i class="fa fa-refresh" aria-hidden="true"></i>
        @lang('payments.status.return')
    </a>
    {{-- Return --}}
    @if ($user->service() == 'twitch')
        <a href="https://twitch.tv/{{ $user->name }}" class="btn btn-primary" target="_blank"><i class="fa fa-twitch"></i> /{{ $user->name }}</a>
    @elseif ($user->service() == 'youtube')
        <a href="https://youtube.com/channel/{{ $user->service_id() }}" class="btn btn-danger" target="_blank"><i class="fa fa-youtube-play"></i> /channel/{{ $user->name }}</a>
    @elseif ($user->service() == 'mixer')
        <a href="https://mixer.com/{{ $user->name }}" class="btn btn-info btn-mixer" target="_blank"><i class="fa fa-xing"></i> /id{{ $user->service_id() }}</a>
    @endif
    
@endsection
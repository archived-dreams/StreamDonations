@extends('layouts.blank')

@section('css')
    @parent
    <link href="{{ asset('assets/css/auth.css') }}" rel="stylesheet">
@endsection

@section('content')
    {{-- Content --}}
    <div class="auth" id="content">
        <div class="auth-container">
            <div class="card">
                <img src="{{ asset('assets/img/logo-clean.png') }}" class="logo">
                <div class="auth-content">
                    <h3>
                        @lang('auth.home.title')
                    </h3><br>
                     @include('auth.links')
                </div>
            </div>
            <div class="text-xs-center footer-copy">
                &copy; {{ date('Y') }} {{ config('app.title') }}
            </div>
        </div>
    </div>
@endsection

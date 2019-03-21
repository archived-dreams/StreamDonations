@extends('layouts.blank')

@section('css')
    <style>
        body {
            background: #59438c;
        }
        .spinner {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: block;
            text-align: center;
            color: #d7cceb;
        }
    </style>
@endsection

@section('content')
    <meta http-equiv="refresh" content="3;url={{ route('home') }}" />
    <div class="spinner">
        <i class="fa fa-spinner fa-spin fa-4x fa-fw"></i>
    </div>
@endsection
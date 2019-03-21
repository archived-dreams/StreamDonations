@extends('layouts.app')

@section('content')
    {!! Form::open(['route' => ['apanel.users.save', $user['id']], 'id' => 'settingsAccountForm', 'autocomplete' => 'off']) !!}
        {{-- ID --}}
        <div class="form-group">
            {!! Form::label('id', trans('apanel.users.id')) !!}
            {!! Form::text('id', $user['id'], [ 'class' => 'form-control', 'disabled' => 'disabled' ]) !!}
        </div>
        {{-- Balance --}}
        {{-- <div class="form-group">
            {!! Form::label('balance', trans('apanel.users.balance')) !!}
            <div class="input-group">
                <span class="input-group-addon">{!! config('app.currency_icon') !!}</span>
                {!! Form::number('balance', $user['balance'], ['class' => 'form-control', 'id' => 'balance', 'step' => '0.01', 'min' => '0.01', 'max' => '10000']) !!}
            </div>
        </div>--}}
        {{-- Name --}}
        <div class="form-group">
            {!! Form::label('name', trans('apanel.users.name')) !!}
            {!! Form::text('name', $user['name'], [ 'class' => 'form-control' ]) !!}
        </div>
        {{-- Token --}}
        <div class="form-group">
            {!! Form::label('token', trans('apanel.users.token')) !!}
            {!! Form::text('token', $user['token'], [ 'class' => 'form-control' ]) !!}
        </div>
        {{-- Avatar --}}
        <div class="form-group">
            {!! Form::label('avatar', trans('apanel.users.avatar')) !!}
            {!! Form::text('avatar', $user['avatar'], [ 'class' => 'form-control', 'disabled' => 'disabled' ]) !!}
        </div>
        {{-- Level --}}
        <div class="form-group">
            {!! Form::label('level', trans('apanel.users.level.title')) !!}
            {!! Form::select('level', ['user' => trans('apanel.users.level.user'), 'admin' => trans('apanel.users.level.admin')], $user['level'], ['class' => 'form-control selectpicker', 'id' => 'level']) !!}
        </div>
        {{-- Email --}}
        <div class="form-group">
            {!! Form::label('email', trans('apanel.users.email')) !!}
            {!! Form::text('email', $user['email'], [ 'class' => 'form-control' ]) !!}
        </div>
        {{-- Timezone --}}
        <div class="form-group">
            {!! Form::label('timezone', trans('apanel.users.timezone')) !!}
            {!! Form::select('timezone', $user->timezone_list(), $user->timezone_get(), ['class' => 'form-control selectpicker', 'data-live-search' => 'true', 'id' => 'timezone']) !!}
        </div>
        {{-- Smileys --}}
        <div class="form-group">
            {!! Form::label('smiles', trans('settings.account.smiles')) !!}
            {!! Form::select('smiles', ['true' => trans('settings.account.yes'), 'false' => trans('settings.account.no')], $user['smiles'], ['class' => 'form-control selectpicker', 'id' => 'smiles']) !!}
        </div>
        {{-- Links --}}
        <div class="form-group">
            {!! Form::label('links', trans('settings.account.links')) !!}
            {!! Form::select('links', ['true' => trans('settings.account.yes'), 'false' => trans('settings.account.no')], $user['links'], ['class' => 'form-control selectpicker', 'id' => 'links']) !!}
        </div>
        {{-- Black List Words --}}
        <div class="form-group">
            {!! Form::label('black_list_words', trans('settings.account.black_list_words.title')) !!}
            {!! Form::textarea('black_list_words', $user->black_list_words, [ 'class' => 'form-control' ]) !!}
        </div>
        {{-- Created at --}}
        <div class="form-group">
            {!! Form::label('created_at', trans('apanel.users.created_at')) !!}
            {!! Form::text('created_at', $user['created_at'], [ 'class' => 'form-control' ]) !!}
        </div>
        <br>
        {{-- Submit --}}
        {!! Form::submit(trans('settings.account.save'), ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#settingsAccountForm').ajaxForm({ 
                dataType: 'json', 
                success: function(data) {
                    auto_notify(data);
                },
                error: function(data) {
                    error_notify(data.responseJSON);
                }
            }); 
        });
    </script>
@endsection
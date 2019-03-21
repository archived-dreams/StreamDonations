@extends('layouts.app')

@section('content')
    {!! Form::open(['route' => 'settings.account.save', 'id' => 'settingsAccountForm']) !!}
        {{-- Timezone --}}
        <div class="form-group">
            {!! Form::label('timezone', trans('settings.account.timezone')) !!}
            {!! Form::select('timezone', Auth::user()->timezone_list(), Auth::user()->timezone_get(), ['class' => 'form-control selectpicker', 'data-live-search' => 'true', 'id' => 'timezone']) !!}
        </div>
        {{-- Smileys --}}
        <div class="form-group">
            {!! Form::label('smiles', trans('settings.account.smiles')) !!}
            {!! Form::select('smiles', ['true' => trans('settings.account.yes'), 'false' => trans('settings.account.no')], Auth::user()->smiles, ['class' => 'form-control selectpicker', 'id' => 'smiles']) !!}
        </div>
        {{-- Links --}}
        <div class="form-group">
            {!! Form::label('links', trans('settings.account.links')) !!}
            {!! Form::select('links', ['true' => trans('settings.account.yes'), 'false' => trans('settings.account.no')], Auth::user()->links, ['class' => 'form-control selectpicker', 'id' => 'links']) !!}
        </div>
        {{-- Black List Words --}}
        <div class="form-group">
            {!! Form::label('black_list_words', trans('settings.account.black_list_words.title')) !!}
            {!! Form::textarea('black_list_words', Auth::user()->black_list_words, [ 'class' => 'form-control' ]) !!}
            <p class="help-block">@lang('settings.account.black_list_words.info')</p>
        </div>
        
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
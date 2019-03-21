@extends('layouts.app')

@section('content')
    {!! Form::open(['route' => 'pages.contact.post', 'id' => 'contactForm', 'autocomplete' => 'off']) !!}
        {{-- From --}}
        <div class="form-group">
            {!! Form::label('from', trans('pages.contact.from')) !!}
            {!! Form::text('from', Auth::user()->name, ['class' => 'form-control', 'id' => 'from', 'required' => 'required']) !!}
        </div>
        {{-- Reply email --}}
        <div class="form-group">
            {!! Form::label('email', trans('pages.contact.email')) !!}
            {!! Form::email('email', Auth::user()->email, ['class' => 'form-control', 'id' => 'email', 'required' => 'required']) !!}
        </div>
        {{-- Subject --}}
        <div class="form-group">
            {!! Form::label('subject', trans('pages.contact.subject')) !!}
            {!! Form::text('subject', '', ['class' => 'form-control', 'id' => 'subject', 'required' => 'required']) !!}
        </div>
        {{-- Category --}}
        <div class="form-group">
            {!! Form::label('category', trans('pages.contact.category')) !!}
            {!! Form::select('category', trans('pages.contact.categories'), '', ['class' => 'form-control selectpicker', 'id' => 'category']) !!}
        </div>
        {{-- Description --}}
        <div class="form-group">
            {!! Form::label('description', trans('pages.contact.description')) !!}
            {!! Form::textarea('description', '', ['class' => 'form-control selectpicker', 'id' => 'category']) !!}
        </div>
        {{-- Submit --}}
        {!! Form::submit(trans('pages.contact.submit'), ['class' => 'btn btn-primary', 'style' => 'margin-top: 15px']) !!}
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script>
        /* Form */
        $(function() {
            $('#contactForm').ajaxForm({ 
                dataType: 'json', 
                success: function(data) {
                    auto_notify(data);
                    $('#subject, #category').val('');
                },
                error: function(data) {
                    error_notify(data.responseJSON);
                }
            });
        });
    </script>
@endsection
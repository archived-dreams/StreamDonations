@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(Auth::user()->level == 'admin')
                @section('content')
                    {!! Form::open(['url' => route('pages.static.save', [ 'slug' => $slug ]), 'id' => 'conditionsForm', 'autocomplete' => 'off']) !!}
                        {{-- Text --}}
                        {!! Form::textarea('content', $content, ['class' => 'form-control', 'id' => 'content', 'style' => 'min-height: 500px;', 'autocomplete' => 'off']) !!}

                        {{-- Submit --}}
                        {!! Form::submit(trans('pages.static.save'), ['class' => 'btn btn-primary', 'style' => 'margin-top: 10px;']) !!}
                    {!! Form::close() !!}
                @endsection
            @else
                {!! $content !!} 
            @endif 
        </div>
    </div>
@endsection

@section('scripts')
        @if(Auth::user()->level == 'admin')
        <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
        <script>
            // WYSIWYG
            tinymce.init({
                selector: 'textarea',
                auto_focus: 'content'
            });
            // Form
            $(function() {
                $('#conditionsForm').ajaxForm({ 
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
    @endif
@endsection
@extends('layouts.emails')

@section('content')
    <strong>@lang('emails.contact.name'):</strong> {{ $from }} (#{{ $user_id }})<br>
    <strong>@lang('emails.contact.email'):</strong> <a href="mailto:{{ $email }}">{{ $email }}</a><br>
    <strong>@lang('emails.contact.subject'):</strong> {{ $subject }}<br>
    <strong>@lang('emails.contact.category'):</strong> @lang('pages.contact.categories.' . $category)<br>
    <strong>@lang('emails.contact.description'):</strong><br>
    {!! nl2br(trim(e($description))) !!}
@endsection
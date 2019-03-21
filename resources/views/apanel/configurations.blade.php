@extends('layouts.app')

@php
    // Array Filter
    $configurations = function ($patch) use (&$data) {
        $result = array_filter($data, function($var) use ($patch) {
            return preg_match("/^" . preg_quote($patch, '/') . "/", $var);
        }, ARRAY_FILTER_USE_KEY);
        foreach ($result as $key => $val)
            unset($data[$key]);
        return $result;
    };

    // Translate string
    function tpatch ($patch) {
        return 'apanel.configurations.keys.' . str_replace('.', '_', $patch);
    };
@endphp

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                {!! Form::open(['route' => ['apanel.configurations.save'], 'id' => 'configurationsForm', 'autocomplete' => 'off', 'class' => 'panel-body']) !!}
                    {{-- Menu --}}
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        {{-- Application --}}
                        <li class="nav-item">
                            <a href="#configurations-application" class="nav-link active" data-toggle="tab" aria-expanded="true">
                                @lang('apanel.configurations.application.title')
                            </a>
                        </li>
                        {{-- Auth --}}
                        <li class="nav-item">
                            <a href="#configurations-auth" class="nav-link" data-toggle="tab" aria-expanded="false">
                                @lang('apanel.configurations.auth.title')
                            </a>
                        </li>
                        {{-- Payments --}}
                        <li class="nav-item">
                            <a href="#configurations-payments" class="nav-link" data-toggle="tab" aria-expanded="false">
                                @lang('apanel.configurations.payments.title')
                            </a>
                        </li>
                        {{-- Other --}}
                        <li class="nav-item">
                            <a href="#configurations-other" class="nav-link" data-toggle="tab" aria-expanded="false">
                                @lang('apanel.configurations.other.title')
                            </a>
                        </li>
                    </ul>
                    
                    {{-- Configurations --}}
                    <div class="tab-content tabs-bordered">
                        {{-- Application --}}
                        <div class="tab-pane fade active in" id="configurations-application">
                            <table id="user" class="table table-bordered table-striped" style="clear: both">
                                <tbody> 
                                    @foreach ($configurations('app.') as $key => $value)
                                        <tr>
                                            <td width="35%">
                                                @lang(tpatch($key))
                                                @if (trans(tpatch($key . '_info')) != tpatch($key . '_info'))
                                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="popover" title="@lang(tpatch($key))" data-content="{{ trans(tpatch($key . '_info')) }}" style="cursor: pointer;"></i>
                                                @endif
                                            </td>
                                            <td width="65%">
                                                {!! Form::text(base64_encode($key), $value, [ 'class' => 'form-control' ]) !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- Auth --}}
                        <div class="tab-pane fade" id="configurations-auth">
                            <table id="user" class="table table-bordered table-striped" style="clear: both">
                                <tbody> 
                                    @foreach ($configurations('auth.') as $key => $value)
                                        <tr>
                                            <td width="35%">
                                                @lang(tpatch($key))
                                                @if (trans(tpatch($key . '_info')) != tpatch($key . '_info'))
                                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="popover" title="@lang(tpatch($key))" data-content="{{ trans(tpatch($key . '_info')) }}" style="cursor: pointer;"></i>
                                                @endif
                                            </td>
                                            <td width="65%">
                                                @if(in_array($key, ['auth.twitch.status', 'auth.youtube.status', 'auth.mixer.status']))
                                                    {!! Form::select(base64_encode($key), ['enabled' => 'enabled', 'disabled' => 'disabled'], $value, [ 'class' => 'form-control selectpicker' ]) !!}
                                                @else
                                                    {!! Form::text(base64_encode($key), $value, [ 'class' => 'form-control' ]) !!}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- Payments --}}
                        <div class="tab-pane fade" id="configurations-payments">
                            {{-- PayPal --}}
                            <h4>PayPal</h4>
                            <div class="alert alert-info alert-dismissable">
                                @lang('apanel.configurations.keys.paypal_info')
                            </div>
                            <table id="user" class="table table-bordered table-striped" style="clear: both">
                                <tbody>
                                    {{-- Basic Settings --}}
                                    <tr>
                                        <td colspan="2"><b>@lang('apanel.configurations.keys.paypal_basic')</b></td>
                                    </tr>
                                    {{-- Status --}}
                                    <tr>
                                        <td width="35%">
                                            @lang(tpatch('paypal.status'))
                                        </td>
                                        <td width="65%">
                                            {!! Form::select(base64_encode('paypal.status'), ['enabled' => 'enabled', 'disabled' => 'disabled'], ($configurations('paypal.status'))['paypal.status'], [ 'class' => 'form-control selectpicker' ]) !!}
                                        </td>
                                    </tr>
                                    {{-- Mode --}}
                                    <tr>
                                        <td width="35%">
                                            @lang(tpatch('paypal.mode'))
                                        </td>
                                        <td width="65%">
                                            {!! Form::select(base64_encode('paypal.mode'), ['sandbox' => 'sandbox', 'live' => 'live'], ($configurations('paypal.mode'))['paypal.mode'], [ 'class' => 'form-control selectpicker' ]) !!}
                                        </td>
                                    </tr>
                                    {{-- Notify URL --}}
                                    <tr>
                                        <td width="35%">
                                            @lang(tpatch('paypal.notify_url'))
                                            <i class="fa fa-info-circle" aria-hidden="true" data-toggle="popover" title="{{ trans(tpatch('paypal.notify_url')) }}" data-content="{{ route('payments.paypal.notify') }}" style="cursor: pointer;"></i>
                                        </td>
                                        <td width="65%">
                                            {!! Form::text(base64_encode('paypal.notify_url'), ($configurations('paypal.notify_url'))['paypal.notify_url'], [ 'class' => 'form-control' ]) !!}
                                        </td>
                                    </tr>
                                    {{-- Commission --}}
                                    <tr>
                                        <td width="35%">
                                            @lang(tpatch('paypal.commission'))
                                        </td>
                                        <td width="65%">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-percent" aria-hidden="true"></i></span>
                                                {!! Form::text(base64_encode('paypal.commission'), ($configurations('paypal.commission'))['paypal.commission'], [ 'class' => 'form-control' ]) !!}
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Currency --}}
                                    <tr>
                                        <td width="35%">
                                            @lang(tpatch('paypal.currency'))
                                        </td>
                                        <td width="65%">
                                            <div class="input-group">
                                                <span class="input-group-addon">{!! config('app.currency_icon') !!}</span>
                                                {!! Form::text(base64_encode('paypal.currency'), ($configurations('paypal.currency'))['paypal.currency'], [ 'class' => 'form-control' ]) !!}
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- Sandbox --}}
                                    <tr>
                                        <td colspan="2"><b>@lang('apanel.configurations.keys.paypal_sandbox')</b></td>
                                    </tr>
                                    @foreach ($configurations('paypal.sandbox.') as $key => $value)
                                        <tr>
                                            <td width="35%">
                                                @lang(tpatch($key))
                                                @if (trans(tpatch($key . '_info')) != tpatch($key . '_info'))
                                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="popover" title="@lang(tpatch($key))" data-content="{{ trans(tpatch($key . '_info')) }}" style="cursor: pointer;"></i>
                                                @endif
                                            </td>
                                            <td width="65%">
                                                {!! Form::text(base64_encode($key), $value, [ 'class' => 'form-control' ]) !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{-- Live --}}
                                    <tr>
                                        <td colspan="2"><b>@lang('apanel.configurations.keys.paypal_live')</b></td>
                                    </tr>
                                    @foreach ($configurations('paypal.live.') as $key => $value)
                                        <tr>
                                            <td width="35%">
                                                @lang(tpatch($key))
                                                @if (trans(tpatch($key . '_info')) != tpatch($key . '_info'))
                                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="popover" title="@lang(tpatch($key))" data-content="{{ trans(tpatch($key . '_info')) }}" style="cursor: pointer;"></i>
                                                @endif
                                            </td>
                                            <td width="65%">
                                                {!! Form::text(base64_encode($key), $value, [ 'class' => 'form-control' ]) !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                        </div>
                        {{-- Other --}}
                        <div class="tab-pane fade" id="configurations-other">
                            <table id="user" class="table table-bordered table-striped" style="clear: both">
                                <tbody> 
                                    @foreach ($data as $key => $value)
                                        <tr>
                                            <td width="35%">
                                                @lang(tpatch($key))
                                                @if (trans(tpatch($key . '_info')) != tpatch($key . '_info'))
                                                    <i class="fa fa-info-circle" aria-hidden="true" data-toggle="popover" title="@lang(tpatch($key))" data-content="{{ trans(tpatch($key . '_info')) }}" style="cursor: pointer;"></i>
                                                @endif
                                            </td>
                                            <td width="65%">
                                                {!! Form::text(base64_encode($key), $value, [ 'class' => 'form-control' ]) !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- End Configurations --}}
                    <br> 
                    {{-- Submit --}}
                    {!! Form::submit(trans('settings.account.save'), ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>


    
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#configurationsForm').ajaxForm({ 
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


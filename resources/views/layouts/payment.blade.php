<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    {{-- Style --}}
    @section('css')
        <link href="{{ asset('assets/css/pay.css') }}" rel="stylesheet">
    @endsection
    {{-- Head --}}
    @include('layouts.app.head', [ 'title' => trans('donations.donate.title') ])
</head>
<body>
    {{-- Content --}}
    <div class="container">
        {{-- Info --}}
        <div class="row">
            <div class="col-md-12">
                {{-- ID --}}
                <h3 class="pay-header">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i> @lang('donations.donate.pay.title', [ 'invoice' => str_pad($message->id, 7, 0, STR_PAD_LEFT) ])
                </h3>
                <div class="invoice-info">
                    {{-- Streamer --}}
                    <div class="form-group">
                        <label>@lang('donations.donate.pay.streamer')</label>
                        <input class="form-control" type="text" value="{{ $user->name }}" disabled>
                    </div>
                    {{-- Method --}}
                    @if (isset($method)):
                        <div class="form-group">
                            <label>@lang('donations.donate.pay.method')</label>
                            <input class="form-control" type="text" value="{{ $method }}" disabled>
                        </div>
                    @endif
                    {{-- Amount --}}
                    <div class="form-group">
                        <label>@lang('donations.donate.pay.amount')</label>
                        <div class="input-group">
                            <span class="input-group-addon">{!! config('app.currency_icon') !!}</span>
                            <input class="form-control" type="text" value="{{ $message->amount }}" disabled>
                        </div>
                    </div>
                    {{-- Message --}}
                    <div class="form-group">
                        <label>@lang('donations.donate.pay.message')</label>
                        <textarea class="form-control" disabled>{{ $message->message }}</textarea>
                    </div>
                    {{-- Created At --}}
                    <div class="form-group">
                        <label>@lang('donations.donate.pay.created_at')</label>
                        <input class="form-control" type="text" value="{{ $message->created_at }}" disabled>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-container">
            @yield('content')
        </div>
        {{-- Status --}}
        <div class="status">
            {{-- Loader --}}
            <i class="fa fa-spinner fa-spin fa-3x fa-fw text-primary status-loading"></i>
            {{-- Success --}}
            <i class="fa fa-check fa-3x fa-fw text-success status-success" style="display: none;"></i>
            {{-- Cancel --}}
            <i class="fa fa-times fa-3x fa-fw text-danger status-cancel" style="display: none;"></i>
        </div>
        
        <div class="paymethod-buttons">
            @yield('buttons')
        </div>
    </div>
    {{-- Footer --}}
    <div class="pay-footer">
        @lang('donations.donate.terms', ['modal' => 'termsAndConditionsModal'])
        <br><br>
        &copy; <a href="{{ route('home') }}">{{ config('app.title') }}</a> {{ date('Y') }}
    </div>
    
    {{-- Modals --}}
    @section('modals')
        {{-- Terms & Conditions --}}
        <div class="modal fade" id="termsAndConditionsModal" tabindex="-1" role="dialog" aria-labelledby="termsAndConditionsModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="termsAndConditionsModalLabel">@lang('donations.donate.conditions')</h4>
              </div>
              <div class="modal-body">
                <div class="element-select">
                    {!! Storage::get("pages/" . \Lang::locale() . "/terms-and-conditions.html") !!}
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('global.close')</button>
              </div>
            </div>
          </div>
        </div>
    @endsection
    {{-- Scripts --}}
    @section('scripts')
        @parent
        <script>
            $(function() {
                // Status Check
                var paymentCheckId = false;
                var paymentCheck = function() {
                    $.get( "{{ route('payments.status.ajax', [ 'id' => $message->id ]) }}", function( status ) {
                        if (status == 'success') {
                            $('.status-loading').fadeOut("fast");
                            $('.status-cancel').fadeOut("fast");
                            $('.status-success').fadeIn("fast");
                        } else if (status == 'refund') {
                            $('.status-loading').fadeOut("fast");
                            $('.status-success').fadeOut("fast");
                            $('.status-cancel').fadeIn("fast");
                        }

                        if (status == 'success' || status == 'refund') {
                            @if ($message->status == 'wait' && isset($method))
                                setTimeout(function() {
                                    window.location = "{{ route('payments.return', [ 'id' => $message->id ]) }}";
                                }, 1000);
                            @endif
                            return;
                        }

                        setTimeout(paymentCheck, 2000);
                    });
                }
                @if (isset($method) && $message->status == 'wait')
                    paymentCheckId = setTimeout(paymentCheck, 7000);
                @else
                    paymentCheck();
                @endif
            });
        </script>
    @endsection
    {{-- Foot --}}
    @include('layouts.app.foot')
</body>
</html>
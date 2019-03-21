@extends('layouts.payment')

@section('content')
    {{-- Payment Form --}}
    <form action="Link" method="POST" target="_blank" id="paymentForm">
        <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="Amount">
        <input type="hidden" name="LMI_PAYMENT_DESC" value="{{ base64_encode(trans('donations.donate.payment_description', [ 'name' => $user->name ])) }}">
        <input type="hidden" name="LMI_PAYEE_PURSE" value="Purse">
        <input type="hidden" name="LMI_PAYMENT_NO" value="{{ $message['id'] }}">
        <input type="hidden" name="LMI_SUCCESS_URL" value="{{ route('payments.status', [ 'id' => $message['id'] ]) }}"> 
        <input type="hidden" name="LMI_FAIL_URL" value="{{ route('payments.status', [ 'id' => $message['id'] ]) }}"> 
        {{-- Submit button --}}
        <button type="submit" class="btn btn-primary btn-lg pay-button">
            <i class="fa fa-credit-card" aria-hidden="true"></i> @lang('donations.donate.pay.button')
        </button>
    </form>
@endsection

@section('buttons')
    {{-- Buttons (Logos etc) --}}
@endsection

@section('scripts')
    @parent
    <script>
        $(function() {
            $('#paymentForm').submit();
        });
    </script>
@endsection
@extends('layouts.app')

@section('content')
    <form method="post" id="payuForm" action="https://sandbox.gateway.payulatam.com/ppp-web-gateway/">
        <input name="amount" type="hidden" value="{{number_format($amount, 2)}}">
        <input name="merchantId" type="hidden" value="{{$merchantId}}">
        <input name="referenceCode" type="hidden" value="{{$referenceCode}}">
        <input name="accountId" type="hidden" value="{{$accountId}}">
        <input name="description" type="hidden" value="{{$description}}">
        <input name="tax" type="hidden" value="{{number_format($tax, 2)}}">
        <input name="taxReturnBase" type="hidden" value="{{number_format($taxReturnBase, 2)}}">
        <input name="currency" type="hidden" value="{{$currency}}">
        <input name="signature" type="hidden" value="{{$signature}}">
        <input name="test" type="hidden" value="{{$test}}">
        <input name="buyerEmail" type="hidden" value="{{$buyerEmail}}">
        <input name="lng" type="hidden" value="{{$lng}}">
        <input name="responseUrl" type="hidden" value="{{$responseUrl}}">
        <input name="confirmationUrl" type="hidden" value="{{$confirmationUrl}}">
        <input name="payerFullName" type="hidden" value="{{$payerFullName}}">
        <input name="payerDocument" type="hidden" value="{{$payerDocument}}">
        <input name="mobilePhone" type="hidden" value="{{$mobilePhone}}">
        <input name="billingAddress" type="hidden" value="{{$billingAddress}}">
        <input name="shippingAddress" type="hidden" value="{{$shippingAddress}}">
        <input name="telephone" type="hidden" value="{{$telephone}}">
        <input name="officeTelephone" type="hidden" value="{{$officeTelephone}}">
        <input name="algorithmSignature" type="hidden" value="{{$algorithmSignature}}">
        <input name="extra3" type="hidden" value="{{$extra3}}">
        <input name="billingCity" type="hidden" value="{{$billingCity}}">
        <input name="shippingCity" type="hidden" value="{{$shippingCity}}">
        <input name="zipCode" type="hidden" value="{{$zipCode}}">
        <input name="billingCountry" type="hidden" value="{{$billingCountry}}">
        <input name="shippingCountry" type="hidden" value="{{$shippingCountry}}">
        <input name="buyerFullName" type="hidden" value="{{$buyerFullName}}">
        <input name="payerEmail" type="hidden" value="{{$payerEmail}}">
        <input name="payerPhone" type="hidden" value="{{$payerPhone}}">
        <input name="payerOfficePhone" type="hidden" value="{{$payerOfficePhone}}">
        <input name="payerMobilePhone" type="hidden" value="{{$payerMobilePhone}}">
    </form>
@endsection



@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('account') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Withdraw</div>
</div>

<div id="page-content">
    <div class="custom-form-group">
        <div class="input-group">
            <div class="input-group-text">Withdraw Amount</div>
            <input class="form-control" type="text" placeholder="Please enter the withdrawal">
        </div>
    </div>

    <div class="help-text text-end small">
        Withdrawal Limit:<span class="text-primary">MYR 300.00 - MYR 10,000.00</span>
        <br>
        Maximum Daily Withdrawal Amount: <span class="text-primary">MYR 100,000.00</span>
    </div>

    <div class="custom-form-group">
        <div class="input-group">
            <div class="input-group-text">Fund Password</div>
            <input class="form-control" type="password" placeholder="Please enter Fund Password">
        </div>
    </div>

    <div class="custom-form-group">
        <div class="input-group">
            <div class="input-group-text">Select a Bank Account</div>
            <select class="form-select"></select>
        </div>
    </div>
    
    <div class="btn-wrapper" style="padding-left:0.5rem;padding-right:0.5rem">
        <button class="btn btn-md btn-primary w-100 text-uppercase" style="margin-top:1rem" type="button">
            <span class="me-3">Submit</span>
        </button>
    </div>
</div>
@endsection

@section('custom')
<script>
    $('.menu-item').removeClass('active');
</script>
@endsection
@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('bank_account') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Add Bank Account</div>
</div>

<div id="page-content">
    <div class="custom-form-group">
        <div class="input-group">
            <div class="input-group-text">Bank Name</div>
            <select class="form-select">
                <option value="MBB">Maybank</option>
                <option value="CIMB">CIMB Bank</option>
                <option value="PBB">Public Bank</option>
                <option value="RHB">RHB Bank</option>
            </select>
        </div>
    </div>

    <div class="divider"></div>

    <div class="custom-form-group">
        <div class="input-group">
            <div class="input-group-text">Bank Account Number</div>
            <input class="form-control" type="number">
        </div>
    </div>

    <div class="divider"></div>

    <div class="custom-form-group">
        <div class="input-group">
            <div class="input-group-text">Bank Holder Name</div>
            <input id="f2c0018f986fe" class="form-control" type="text">
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
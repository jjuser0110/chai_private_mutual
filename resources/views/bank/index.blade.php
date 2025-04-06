@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('account') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Bank Account</div>
</div>

<div id="page-content">
    <div style="display:flex;flex-direction:column;height:100%;">
    <div class="no-data">
        <div class="icon">
            <img src="{{ asset('img/no-data.png') }}" alt="No Data"></div>
            <div class="label">No Data</div>
        </div>
    </div>
    <div class="btn-wrapper" style="padding-left:0.5rem;padding-right:0.5rem">
        <a class="btn btn-primary w-100" onclick="loadPage('{{ route('add_bank_account') }}')">Add Bank Account</a>
    </div>
</div>
@endsection

@section('custom')
<script>
    $('.menu-item').removeClass('active');
</script>
@endsection
@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('index') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">News</div>
</div>

<div id="page-content">
    <div class="no-data">
        <div class="icon">
            <img src="{{ asset('img/no-data.png') }}" alt="No Data">
        </div>
        <div class="label">No Data</div>
    </div>
</div>
@endsection
@section('custom')
<script>
    $('.menu-item').removeClass('active');
@endsection

@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('account') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Information Edit</div>
</div>

<div id="page-content">
    <div class="custom-form-group">
        <div class="input-group" role="group">
            <div class="input-group-text">
                <span class="icon">
                    <div class="image-icon menu-item-icon">
                        <img src="{{ asset('img/profile/mobile.png') }}" alt="Mobile"/>
                    </div>
                </span>
                <span>Mobile</span>
            </div>
            <input class="form-control" type="text">
        </div>
    </div>

    <div class="divider"></div>

    <div class="custom-form-group">
        <div class="input-group" role="group">
            <div class="input-group-text">
                <span class="icon">
                    <div class="image-icon menu-item-icon">
                        <img src="{{ asset('img/profile/name.png') }}" alt="Name">
                    </div>
                </span>
                 <span>Name</span>
            </div>
            <input class="form-control" type="text">
        </div>
    </div>

    <div class="divider"></div>

    <div class="custom-form-group">
        <div class="input-group" role="group">
            <div class="input-group-text">
                <span class="icon">
                    <div class="image-icon menu-item-icon">
                        <img src="{{ asset('img/profile/card.png') }}" alt="ID Card">
                    </div>
                </span>
                 <span>ID Card</span>
            </div>
            <input class="form-control" type="text">
        </div>
    </div>
    
    <div class="divider"></div>
    
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
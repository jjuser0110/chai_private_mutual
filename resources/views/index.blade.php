@extends('layouts.app')

@section('content')
<div id="header">
    <div class="logo"><img src="{{ asset('img/logo.png') }}" alt="Logo" height="20"></div>
    <a target="_blank" class="customer-service" href="#"><i class="ri-customer-service-2-line ri-xl"></i></a>
</div>
<div id="page-content">
    <!-- Slider -->
    <div class="swiper-container swiper hero-swiper" id="home-banner">
        <div class="swiper-wrapper">
            @foreach($slides as $slide)
            <div class="swiper-slide"><div class="image" style="background-image:url('{{ env('BACKEND_URL') }}/storage/{{ $slide->file_path }}')"></div></div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <!-- Notice -->
    <div id="notice-slider">
        <div class="notice-icon">
            <i class="ri-volume-down-line"></i>
        </div>

        <div class="swiper-container swiper" id="swiper-notice">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><span>Welcome to Hong Leong Mutual Asia</span></div>
                <div class="swiper-slide"><span>Welcome to Hong Leong Mutual Asia</span></div>
            </div>
        </div>
    </div>

    <!-- Menu -->
    <div id="content-menu">
        <a href="#" onclick="loadPage('news')" class="item"><div class="icon"><i class="ri-newspaper-line"></i></div><span>News</span></a>
        <a href="#" onclick="loadPage('join')" class="item"><div class="icon"><i class="ri-menu-line"></i></div><span>Join</span></a>
        <a href="#" onclick="loadPage('withdraw')" class="item"><div class="icon"><i class="ri-wallet-fill"></i></div><span>Withdraw</span></a>
        <a href="#" class="item"><div class="icon"><i class="ri-customer-service-line"></i></div><span>Customer Service</span></a>
    </div>

    <div class="divider"></div>

    @foreach($projects as $project)
    @if(count($project['items'])>0)
    <div class="project-wrapper">
        <div class="title">
            <h6>{{ $project['name'] }}</h6>
        </div>
        <div class="list">
            @foreach($project['items'] as $item)
            <div class="list-item" onclick="loadPage('{{ route('single_project',['project'=>$item->id]) }}')">
                <div class="card">
                    <div class="card-image-wrapper">
                        <div class="card-image" style="background-image:url(' {{ env('BACKEND_URL') }}/storage/{{ $item->thumbnail->file_path ?? '' }}')"></div>
                    </div>
                    <div class="card-bottom">
                        <div class="card-title">{{ $item->product_name }}</div>
                        <div class="card-content">Belong to: {{ $project['name'] }}</div>
                        <div class="card-content">User Level: {{ $item->user_level ?? '-'}}</div>
                        @if($item->product_type == 'normal')
                        <div class="card-content">Join Amount Start From:</div>
                        <div class="card-content" style="color:white; font-size:14px">MYR {{ number_format($item->investment_amount,2,'.',',') }}+</div>
                        @else
                        <div class="card-content">Booking Amount:</div>
                        <div class="card-content" style="color:white; font-size:14px">MYR {{ number_format($item->product_price,2,'.',',') }}</div>
                        @endif
                        <div class="progress">
                            <div class="progress-bar" style="width:{{ $item->product_percentage }}%;">
                                <div class="label">{{ $item->product_percentage }}%</div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
            @endforeach
        </div>
    </div>
    <div class="divider"></div>
    @endif
    @endforeach
</div>
@endsection
@section('custom')
<script>
    new Swiper('#home-banner', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        slidesPerView: 1,
        spaceBetween: 2,
    });

    new Swiper('#swiper-notice', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        slidesPerView: 1,
        spaceBetween: 2,
    });
    $('.menu-item').removeClass('active');
    $('#home-icon').addClass('active');
</script>
@endsection
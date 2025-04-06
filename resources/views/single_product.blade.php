@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('shop') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Product Details</div>
</div>

<div id="page-content">
    <div class="product-details">
        <div class="product-images">
            <div class="swiper-container swiper hero-swiper" id="single-product-swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><div class="image" style="background-image:url('{{ asset('img/product/02.jpg') }}')"></div></div>
                    <div class="swiper-slide"><div class="image" style="background-image:url('{{ asset('img/product/04.jpg') }}')"></div></div>
                    <div class="swiper-slide"><div class="image" style="background-image:url('{{ asset('img/product/05.jpg') }}')"></div></div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <div class="product-info">
            <div class="product-info-title">Gucci - Style 699757</div>
            <div class="product-info-item">
                <div class="product-info-item-title">Points</div>
                <div class="product-info-item-content">136,000.00</div>
            </div>
        </div>

        <div class="product-rules">
            <div class="product-rules-title">Details</div>
            <div class="product-rules-content">
                <span><p>The Gucci Bag - Style 699757 features elegant design, premium leather, and versatile straps for a stylish and practical accessory.</p></span>
            </div>
        </div>

        <div class="product-buy">
            <div class="image-icon product-buy-icon">
                <img src="{{ asset('img/exchange.png') }}" alt="Exchange"/>
            </div>
            <div>Exchange</div>
        </div>
    </div>
</div>
@endsection

@section('custom')
<script>
    new Swiper('#single-product-swiper', {
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

    $('.menu-item').removeClass('active');
</script>
@endsection
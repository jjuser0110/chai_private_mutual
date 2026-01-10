@extends('layouts.app')

@section('content')
<div id="header">
    <div class="title">Integral Shop</div>
</div>

<div id="page-content">
    <!-- Slider -->
    <div class="swiper-container swiper hero-swiper" id="shop-banner">
        <div class="swiper-wrapper">
            @foreach($slides as $slide)
            <div class="swiper-slide"><div class="image" style="background-image:url('{{ env('BACKEND_URL') }}/storage/{{ $slide->file_path }}')"></div></div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
    
    @if(Auth::check())
    <div id="shop-user-point"><span>My Points: </span><span>{{ number_format(Auth::user()->shop_point,2,'.',',') }}</span></div>
    @endif

    <div class="divider"></div>

    <div class="shop-menu">
        <div class="shop-menu-item" onclick="loadPage('order')">
            <div class="shop-menu-item-icon">
                <div class="image-icon shop-menu-item-icon">
                    <img src="data:image/png;base64,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" alt="Joined Record">
                </div>
            </div>
            <div class="shop-menu-item-title">Orders</div>
        </div>
    </div>
 
    <div class="divider"></div>
 
    <div class="product-grid-view">
        <div class="product-grid-container">
            @foreach($items as $item)
            <div class="product-item" onclick="loadPage('{{ route('single_product', ['id'=>$item->id]) }}')">
                <div class="product-card">
                    <div class="thumbnail-wrapper">
                        <div class="thumbnail" style="background-image:url('{{ env('BACKEND_URL') }}/storage/{{ $item->thumbnail->file_path }}')"></div>
                    </div>
                    <div class="product-info">
                        <div class="product-title">{{ $item->item_name }}</div>
                        <div class="product-desc">Points: {{ number_format($item->item_point,2,'.',',') }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


@endsection
@section('custom')
<script>
    initializeAllSwipers();
    $('.menu-item').removeClass('active');
    $('#shop-icon').addClass('active');
</script>
@endsection

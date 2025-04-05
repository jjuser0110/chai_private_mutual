@extends('layouts.app')

@section('content')
<div id="header">
    <div class="title">Integral Shop</div>
</div>

<div id="page-content">
    <!-- Slider -->
    <div class="swiper-container swiper hero-swiper" id="shop-banner">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="image" style="background-image:url('{{ asset('img/banner/shop/01.jpg') }}')"></div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <div class="project-category-tabs">
        <div class="list-group">
            <div class="list-group-item">
                <div class="icon">
                    <img src="{{ asset('img/icon-agriculture.png') }}" alt="Agriculture">
                </div>
                <div class="label">Agriculture</div>
            </div>
            <div class="list-group-item">
                <div class="icon"><img src="{{ asset('img/icon-architecture.png') }}" alt="Architecture"></div>
                <div class="label">Architecture</div>
            </div>
            <div class="list-group-item">
                <div class="icon">
                    <img src="{{ asset('img/icon-metaverse.png') }}" alt="Metaverse">
                </div>
                <div class="label">Metaverse</div>
            </div>
            <div class="list-group-item">
                <div class="icon">
                    <img src="{{ asset('img/icon-nft.png') }}" alt="NFT">
                </div>
                <div class="label">NFT</div>
            </div>
        </div>
    </div>

    <div class="project-list-view">
        <div class="list-group">
            <div class="list-group-item cursor-pointer">
                <div class="project-item d-flex align-items-center">
                    <div class="thumbnail-wrapper">
                        <div class="thumbnail" style="background-image: url(&quot;https://api.privatemutualhlg.com/storage/53/M10.jpg&quot;);"></div>
                    </div>
                    <div class="project-info">
                        <div class="project-name">River park</div>
                        <div class="project-details">
                            <div class="category">Belong to: Architecture</div>
                            <div class="user-level">User Level: Diamond</div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100.00" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                    <div class="label">100%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-min-invest">MYR 250,000.00</div>
                </div>
                <div class="divider"></div>
            </div>

            <div class="list-group-item cursor-pointer">
                <div class="project-item d-flex align-items-center">
                    <div class="thumbnail-wrapper">
                        <div class="thumbnail" style="background-image: url(&quot;https://api.privatemutualhlg.com/storage/47/M4.jpg&quot;);"></div>
                    </div>
                    <div class="project-info">
                        <div class="project-name">Oil palm farm</div>
                        <div class="project-details">
                            <div class="category">Belong to: Agriculture</div>
                            <div class="user-level">User Level: Gold</div>
                            <div class="progress animated-progress custom-progress progress-label bg-primary-subtle">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100.00" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                    <div class="label">100%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-min-invest">MYR 110,000.00</div>
                </div>
                <div class="divider"></div>
            </div>

            <div class="list-group-item cursor-pointer">
                <div class="project-item d-flex align-items-center">
                    <div class="thumbnail-wrapper">
                        <div class="thumbnail" style="background-image: url(&quot;https://api.privatemutualhlg.com/storage/46/M3.jpg&quot;);"></div>
                    </div>
                    <div class="project-info">
                        <div class="project-name">Durian farm</div>
                        <div class="project-details">
                            <div class="category">Belong to: Agriculture</div>
                            <div class="user-level">User Level: Silver</div>
                            <div class="progress animated-progress custom-progress progress-label bg-primary-subtle">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100.00" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                    <div class="label">100%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-min-invest">MYR 72,000.00</div>
                </div>
                <div class="divider"></div>
            </div>

            <div class="list-group-item cursor-pointer">
                <div class="project-item d-flex align-items-center">
                    <div class="thumbnail-wrapper">
                        <div class="thumbnail" style="background-image: url(&quot;https://api.privatemutualhlg.com/storage/41/M7.jpg&quot;);"></div>
                    </div>
                    <div class="project-info">
                        <div class="project-name">Pepe #2689</div>
                        <div class="project-details">
                            <div class="category">Belong to: Nft</div>
                            <div class="user-level">User Level: Gold</div>
                            <div class="progress animated-progress custom-progress progress-label bg-primary-subtle">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100.00" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                    <div class="label">100%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-min-invest">MYR 120,000.00</div>
                </div>
                <div class="divider"></div>
            </div>

            <div class="list-group-item cursor-pointer">
                <div class="project-item d-flex align-items-center">
                    <div class="thumbnail-wrapper">
                        <div class="thumbnail" style="background-image: url(&quot;https://api.privatemutualhlg.com/storage/40/M6.jpg&quot;);"></div>
                    </div>
                    <div class="project-info">
                        <div class="project-name">Kanpai panda</div>
                        <div class="project-details">
                            <div class="category">Belong to: Nft</div>
                            <div class="user-level">User Level: Silver</div>
                            <div class="progress animated-progress custom-progress progress-label bg-primary-subtle">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100.00" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                    <div class="label">100%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-min-invest">MYR 50,000.00</div>
                </div>
                <div class="divider"></div>
            </div>

            <div class="list-group-item cursor-pointer">
                <div class="project-item d-flex align-items-center">
                    <div class="thumbnail-wrapper">
                        <div class="thumbnail" style="background-image: url(&quot;https://api.privatemutualhlg.com/storage/30/M2.jpg&quot;);"></div>
                    </div>
                    <div class="project-info">
                        <div class="project-name">Pv 22 residences</div>
                        <div class="project-details">
                            <div class="category">Belong to: Architecture</div>
                            <div class="user-level">User Level: Diamond</div>
                            <div class="progress animated-progress custom-progress progress-label bg-primary-subtle">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100.00" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                    <div class="label">100%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-min-invest">MYR 300,000.00</div>
                </div>
                <div class="divider"></div>
            </div>

            <div class="list-group-item cursor-pointer">
                <div class="project-item d-flex align-items-center">
                    <div class="thumbnail-wrapper">
                        <div class="thumbnail" style="background-image: url(&quot;https://api.privatemutualhlg.com/storage/29/M1.jpg&quot;);"></div>
                    </div>
                    <div class="project-info">
                        <div class="project-name">The atas residence</div>
                        <div class="project-details">
                            <div class="category">Belong to: Architecture</div>
                            <div class="user-level">User Level: Diamond</div>
                            <div class="progress animated-progress custom-progress progress-label bg-primary-subtle">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100.00" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                    <div class="label">100%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-min-invest">MYR 400,000.00</div>
                </div>
                <div class="divider"></div>
            </div>
        </div>
    </div>
</div>

<div id="footer">
    @include('layouts.navimenu')
</div>
@endsection

@section('custom')
<script>
    var swiper = new Swiper('#shop-banner', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        }
    });

    $('.menu-item').removeClass('active');
    $('#shop-icon').addClass('active');
</script>
@endsection
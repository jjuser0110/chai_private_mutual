@extends('layouts.app')

@section('content')
<div id="header">
    <div class="title">Join</div>
</div>

<div id="page-content">
    <!-- Slider -->
    <div class="swiper-container swiper hero-swiper" id="join-banner">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><div class="image" style="background-image:url('{{ asset('img/banner/join/01.jpg') }}')"></div></div>
            <div class="swiper-slide"><div class="image" style="background-image:url('{{ asset('img/banner/join/02.jpg') }}')"></div></div>
            <div class="swiper-slide"><div class="image" style="background-image:url('{{ asset('img/banner/join/03.jpg') }}')"></div></div>
            <div class="swiper-slide"><div class="image" style="background-image:url('{{ asset('img/banner/join/04.jpg') }}')"></div></div>
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <!-- Projects Category -->
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

    <!-- Project list -->
    <div class="project-list-view">
        <div class="list-group">
            <div class="list-group-item cursor-pointer">
                <div class="project-item d-flex align-items-center">
                    <div class="thumbnail-wrapper">
                        <div class="thumbnail" style="background-image: url('{{ asset('img/project/01.jpg') }}');"></div>
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
                        <div class="thumbnail" style="background-image: url('{{ asset('img/project/02.jpg') }}');"></div>
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
                        <div class="thumbnail" style="background-image: url('{{ asset('img/project/03.jpg') }}');"></div>
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
                        <div class="thumbnail" style="background-image: url('{{ asset('img/project/04.jpg') }}');"></div>
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
                        <div class="thumbnail" style="background-image: url('{{ asset('img/project/05.jpg') }}');"></div>
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
                        <div class="thumbnail" style="background-image: url('{{ asset('img/project/06.jpg') }}');"></div>
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
                        <div class="thumbnail" style="background-image: url('{{ asset('img/project/07.jpg') }}');"></div>
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


@endsection

@section('custom')
<script>
    var swiper = new Swiper('#join-banner', {
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
    $('#join-icon').addClass('active');
</script>
@endsection
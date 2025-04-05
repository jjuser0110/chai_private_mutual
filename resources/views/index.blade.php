@extends('layouts.app')

@section('header_css')
@endsection

@section('content')
<div id="header">
    <div class="logo"><img src="{{ asset('img/logo.png') }}" alt="Logo" height="20"></div>

    <a target="_blank" class="customer-service" href="#"><i class="ri-customer-service-2-line ri-xl"></i></a>
</div>
<div id="page-content">
    <!-- SLIDERS -->
    <div class="swiper-container swiper hero-swiper" id="home-banner">
        <div class="swiper-wrapper">
            <!-- <div class="swiper-slide"><img src="{{ asset('img/sliders/slide8.webp') }}" alt="Jamesbond777"></div> -->
            <div class="swiper-slide"><div class="image" style="background-image:url('{{ asset('img/banner/home/01.jpg') }}')"></div></div>
            <div class="swiper-slide"><div class="image" style="background-image:url('{{ asset('img/banner/home/02.jpg') }}')"></div></div>
            <div class="swiper-slide"><div class="image" style="background-image:url('{{ asset('img/banner/home/03.jpg') }}')"></div></div>
            <div class="swiper-slide"><div class="image" style="background-image:url('{{ asset('img/banner/home/04.jpg') }}')"></div></div>
        
        </div>
        <div class="swiper-pagination"></div>
        <!--<div class="swiper-scrollbar"></div>-->
    </div>

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

    <div id="content-menu">
        <a href="#" class="item"><div class="icon"><i class="ri-newspaper-line"></i></div><span>News</span></a>
        <a href="#" class="item"><div class="icon"><i class="ri-menu-line"></i></div><span>Join</span></a>
        <a href="#" class="item"><div class="icon"><i class="ri-wallet-fill"></i></div><span>Withdraw</span></a>
        <a href="#" class="item"><div class="icon"><i class="ri-customer-service-line"></i></div><span>Customer Service</span></a>




    </div>

    <div class="divider"></div>

    <!-- Agriculture -->
    <div class="project-wrapper">
        <div class="title">
            <h6>Agriculture</h6>
        </div>
        <div class="list">
            <div class="list-item">
                <div class="card">
                    <div class="card-image-wrapper">
                        <div class="card-image" style="background-image:url('{{ asset('img/project/agriculture/01.jpg') }}')"></div>
                    </div>
                    <div class="card-bottom">
                        <div class="card-title">Oil Palm Farm</div>
                        <div class="card-content">Belong to: Agriculture</div>
                        <div class="card-content">User Level: Gold</div>
                        <div class="card-content">Booking Amount: MYR 110,000.00</div>
                        <div class="progress">
                            <div class="progress-bar" style="width: 100%;">
                                <div class="label">100%</div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>

            <div class="list-item">
                <div class="card">
                    <div class="card-image-wrapper">
                        <div class="card-image" style="background-image:url('{{ asset('img/project/agriculture/02.jpg') }}')"></div>
                    </div>
                    <div class="card-bottom">
                        <div class="card-title">Durian Farm</div>
                        <div class="card-content">Belong to: Agriculture</div>
                        <div class="card-content">User Level: Silver</div>
                        <div class="card-content">Booking Amount: MYR 72,000.00</div>
                        <div class="progress">
                            <div class="progress-bar" style="width: 100%;">
                                <div class="label">100%</div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>

    <div class="divider"></div>

    <!-- Architecture -->
    <div class="project-wrapper">
        <div class="title">
            <h6>Architecture</h6>
        </div>
        <div class="list">
            <div class="list-item">
                <div class="card">
                    <div class="card-image-wrapper">
                        <div class="card-image" style="background-image:url('{{ asset('img/project/architecture/01.jpg') }}')"></div>
                    </div>
                    <div class="card-bottom">
                        <div class="card-title">River Park</div>
                        <div class="card-content">Belong to: Architecture</div>
                        <div class="card-content">User Level: Diamond</div>
                        <div class="card-content">Min Invest Amount: MYR 250,000.00</div>
                        <div class="progress">
                            <div class="progress-bar" style="width: 100%;">
                                <div class="label">100%</div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>

            <div class="list-item">
                <div class="card">
                    <div class="card-image-wrapper">
                        <div class="card-image" style="background-image:url('{{ asset('img/project/architecture/02.jpg') }}')"></div>
                    </div>
                    <div class="card-bottom">
                        <div class="card-title">PV 22 Residences</div>
                        <div class="card-content">Belong to: Architecture</div>
                        <div class="card-content">User Level: Diamond</div>
                        <div class="card-content">Min Invest Amount: MYR 300,000.00</div>
                        <div class="progress">
                            <div class="progress-bar" style="width: 100%;">
                                <div class="label">100%</div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>

            <div class="list-item">
                <div class="card">
                    <div class="card-image-wrapper">
                        <div class="card-image" style="background-image:url('{{ asset('img/project/architecture/03.jpg') }}')"></div>
                    </div>
                    <div class="card-bottom">
                        <div class="card-title">The Atas Residence</div>
                        <div class="card-content">Belong to: Architecture</div>
                        <div class="card-content">User Level: Diamond</div>
                        <div class="card-content">Min Invest Amount: MYR 400,000.00</div>
                        <div class="progress">
                            <div class="progress-bar" style="width: 100%;">
                                <div class="label">100%</div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>

    <div class="divider"></div>

    <!-- Nft -->
    <div class="project-wrapper">
        <div class="title">
            <h6>NFT</h6>
        </div>
        <div class="list">
            <div class="list-item">
                <div class="card">
                    <div class="card-image-wrapper">
                        <div class="card-image" style="background-image:url('{{ asset('img/project/nft/01.jpg') }}')"></div>
                    </div>
                    <div class="card-bottom">
                        <div class="card-title">Pepe #2689</div>
                        <div class="card-content">Belong to: Nft</div>
                        <div class="card-content">User Level: Gold</div>
                        <div class="card-content">Booking Amount: MYR 120,000.00</div>
                        <div class="progress">
                            <div class="progress-bar" style="width: 100%;">
                                <div class="label">100%</div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>

            <div class="list-item">
                <div class="card">
                    <div class="card-image-wrapper">
                        <div class="card-image" style="background-image:url('{{ asset('img/project/nft/02.jpg') }}')"></div>
                    </div>
                    <div class="card-bottom">
                        <div class="card-title">Kanpai Panda</div>
                        <div class="card-content">Belong to: Nft</div>
                        <div class="card-content">User Level: Silver</div>
                        <div class="card-content">Booking Amount: MYR 50,000.00</div>
                        <div class="progress">
                            <div class="progress-bar" style="width: 100%;">
                                <div class="label">100%</div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>

    <div class="divider"></div>


</div>

<div id="footer">
    @include('layouts.navimenu')
</div>
@endsection
@section('extra')
<!--
<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="content">
            <div id="apk-game-info">
                <img id="game_info_image">
                <div class="account-info">
                    <div class="top">Game Account</div>
               
                    <div class="row copy-content">
                        <div class="col-left">
                            <label>Username</label>
                            <div class="value copy-value" id="game_info_username"></div>
                        </div>
                        <div class="btn-copy">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z"></path><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="row copy-content">
                        <div class="col-left">
                            <label>Password</label>
                            <div class="value copy-value" id="game_info_pass"></div>
                        </div>
                        <div class="btn-copy">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M8 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z"></path><path d="M16 8v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="action-wrapper">
                    <button class="btn btn-cancel" onclick="closeModal()">Cancel</button>
                    <button class="btn btn-primary" id="play_now">Play Now</button>
                </div>
            </div>
        </div>
    </div>
</div>
-->



@endsection
@section('custom')
<script>
var swiper = new Swiper('#home-banner', {
        loop: true,
        autoplay: {
            delay: 5000, // 5 seconds per slide
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        }
    });

    new Swiper('#swiper-notice', {
        loop: true,
        autoplay: {
            delay: 5000, // 5 seconds per slide
            disableOnInteraction: false,
        },
    });
    $('.menu-item').removeClass('active');
    $('#home-icon').addClass('active');
</script>
@endsection
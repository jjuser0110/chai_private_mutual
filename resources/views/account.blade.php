@extends('layouts.app')

@section('content')
<div id="page-content" style="padding-top:0">
    <div class="account-header">
        <div class="account-info">
            <div class="logo">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" height="20">
            </div>
            <div class="account-title">
                <div class="username">Hi, {{ Auth::user()->username ?? 'User' }}</div>
                <div class="user-level">
                    <div class="icon">
                        <img src="https://api.privatemutualhlg.com/storage/14/vip-ordinary.png" alt="ORDINARY">
                    </div>
                    <div class="label">Ordinary</div>
                </div>
                <div id="profile-verify-label" class="{{ Auth::user()->setup == 2 ? 'success' : 'warning' }}">
                    {{ Auth::user()->getVerificationAttribute() }}
                </div>
            </div>
        </div>
        <div class="account-funds">
            <div class="label">Available Funds</div>
            <div class="value">{{ number_format((Auth::user()->available_fund),2,'.',',') }}</div>
        </div>
        <div class="account-money-list">
            <div class="item">
                <div class="label">Total Money</div>
                <div class="value">{{ Auth::user()->total_money ?? 0 }}</div>
            </div>
            <div class="item">
                <div class="label">Unavailable Funds</div>
                <div class="value">{{ Auth::user()->unavailable_fund ?? 0 }}</div>
            </div>
            <div class="item">
                <div class="label">Income</div>
                <div class="value">{{ Auth::user()->income ?? 0 }}</div>
            </div>
        </div>
        @php
            if(Auth::user()->credit_score >= 80){
                $status = 'Good';;
                $color = 'success';
            }
            else if(Auth::user()->credit_score >= 60 && Auth::user()->credit_score < 80){
                $status = 'Fair';
                $color = 'warning';
            }
            else if(Auth::user()->credit_score >= 40 && Auth::user()->credit_score < 60){
                $status = 'Poor';
                $color = 'warning';
            }
            else if(Auth::user()->credit_score >= 20 && Auth::user()->credit_score < 40){
                $status = 'Very Poor';
                $color = 'danger';
            }
            else{
                $status = 'Extremely Poor';
                $color = 'danger';
            }

        @endphp
        <div class="account-score">
            <div class="score-info">
                <span>Credit Score:&nbsp;</span>
                <span class="score {{ $color }}">{{ Auth::user()->credit_score ?? 0 }}</span>
            </div>
            <div class="score-progress-bar">
                <div class="score-progress-inner {{ $color }}" style="width:{{ Auth::user()->credit_score ?? 0 }}%;"></div>
            </div>
            <div class="score-desc">
                <div class="label">Account Health</div>
                <div class="value {{ $color }}">{{ $status }}</div>
            </div>
        </div>
        <div class="account-buttons">
            <button class="btn btn-md btn-secondary btn-withdraw" type="button" onclick="loadPage('{{ route('withdraw') }}')">Withdraw</button>
            <button class="btn btn-md btn-secondary btn-recharge" type="button" onclick="openModal('modal-contact')">Recharge</button>
        </div>
    </div>
    <div class="list-group account-menu">
        <div class="list-group-item menu-item">
            <a class="menu-link" onclick="loadPage('{{ route('join_record') }}')">
                <div class="menu-item-icon">
                    <img src="{{ asset('img/profile/joined.png') }}">
                </div>
                <div class="menu-item-label"><span>Joined Record</span><i class="ri-arrow-right-s-line"></i></div>
            </a>
        </div>

        <div class="list-group-item menu-item">
            <a class="menu-link" onclick="loadPage('{{ route('booking_record') }}')">
                <div class="menu-item-icon">
                    <img src="{{ asset('img/profile/booking.png') }}">
                </div>
                <div class="menu-item-label"><span>Booking Record</span><i class="ri-arrow-right-s-line"></i></div>
            </a>
        </div>

        <div class="list-group-item menu-item">
            <a class="menu-link" onclick="loadPage('{{ route('withdraw_record') }}')">
                <div class="menu-item-icon">
                    <img src="{{ asset('img/profile/withdraw.png') }}">
                </div>
                <div class="menu-item-label"><span>Withdraw Record</span><i class="ri-arrow-right-s-line"></i></div>
            </a>
        </div>

        <div class="list-group-item menu-item">
            <a class="menu-link" onclick="loadPage('{{ route('money_record') }}')">
                <div class="menu-item-icon">
                    <img src="{{ asset('img/profile/money.png') }}">
                </div>
                <div class="menu-item-label"><span>Money Record</span><i class="ri-arrow-right-s-line"></i></div>
            </a>
        </div>

        <div class="divider"></div>

        <div class="list-group-item menu-item">
            <a class="menu-link" onclick="loadPage('{{ route('bank_account') }}')">
                <div class="menu-item-icon">
                    <img src="{{ asset('img/profile/bank.png') }}">
                </div>
                <div class="menu-item-label"><span>Bank Account</span><i class="ri-arrow-right-s-line"></i></div>
            </a>
        </div>

        <div class="divider"></div>

        <div class="list-group-item menu-item">
            <a class="menu-link" onclick="loadPage('{{ route('faq') }}')">
                <div class="menu-item-icon">
                    <img src="{{ asset('img/profile/faq.png') }}">
                </div>
                <div class="menu-item-label"><span>FAQ</span><i class="ri-arrow-right-s-line"></i></div>
            </a>
        </div>

        <div class="list-group-item menu-item">
            <a class="menu-link" onclick="loadPage('{{ route('update_account') }}')">
                <div class="menu-item-icon">
                    <img src="{{ asset('img/profile/update.png') }}">
                </div>
                <div class="menu-item-label"><span>Information Edit</span><i class="ri-arrow-right-s-line"></i></div>
            </a>
        </div>

        <div class="list-group-item menu-item">
            <a class="menu-link" onclick="loadPage('{{ route('about_us') }}')">
                <div class="menu-item-icon">
                    <img src="{{ asset('img/profile/about.png') }}">
                </div>
                <div class="menu-item-label"><span>About Us</span><i class="ri-arrow-right-s-line"></i></div>
            </a>
        </div>
    </div>

    <div class="divider"></div>
    <div class="logout-wrapper">
        <button class="btn btn-md btn-primary btn-logout" type="button" onclick="window.location.href='{{ route('logout') }}'">Logout</button>
    </div>
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
        },
        slidesPerView: 1,
        spaceBetween: 2,
    });

    $('.menu-item').removeClass('active');
    $('#account-icon').addClass('active');
</script>
@endsection

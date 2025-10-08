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
                        <img src="{{ asset('img/medal/' . (Auth::user()->medal ?? 'Ordinary') . '.png') }}">
                    </div>
                    <div class="label">{{Auth::user()->medal??"Ordinary"}}</div>
                </div>
                @if(Auth::user()->setup == 0 || Auth::user()->setup == 4)
                <div id="profile-verify-label" class="info" onclick="window.location.href='{{ route('setup') }}'">
                    Verify Profile 
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
                </div>
                @elseif(Auth::user()->setup == 1)
                <div id="profile-verify-label" class="warning">Pending Verification...</div>
                @elseif(Auth::user()->setup == 2)
                <div id="profile-verify-label" class="success"><svg width="18"  height="18" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-rosette-discount-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.01 2.011a3.2 3.2 0 0 1 2.113 .797l.154 .145l.698 .698a1.2 1.2 0 0 0 .71 .341l.135 .008h1a3.2 3.2 0 0 1 3.195 3.018l.005 .182v1c0 .27 .092 .533 .258 .743l.09 .1l.697 .698a3.2 3.2 0 0 1 .147 4.382l-.145 .154l-.698 .698a1.2 1.2 0 0 0 -.341 .71l-.008 .135v1a3.2 3.2 0 0 1 -3.018 3.195l-.182 .005h-1a1.2 1.2 0 0 0 -.743 .258l-.1 .09l-.698 .697a3.2 3.2 0 0 1 -4.382 .147l-.154 -.145l-.698 -.698a1.2 1.2 0 0 0 -.71 -.341l-.135 -.008h-1a3.2 3.2 0 0 1 -3.195 -3.018l-.005 -.182v-1a1.2 1.2 0 0 0 -.258 -.743l-.09 -.1l-.697 -.698a3.2 3.2 0 0 1 -.147 -4.382l.145 -.154l.698 -.698a1.2 1.2 0 0 0 .341 -.71l.008 -.135v-1l.005 -.182a3.2 3.2 0 0 1 3.013 -3.013l.182 -.005h1a1.2 1.2 0 0 0 .743 -.258l.1 -.09l.698 -.697a3.2 3.2 0 0 1 2.269 -.944zm3.697 7.282a1 1 0 0 0 -1.414 0l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.32 1.497l2 2l.094 .083a1 1 0 0 0 1.32 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z" /></svg> Verified</div>
                @endif
            </div>
        </div>
        <div class="account-funds">
            <div class="label">Available Funds</div>
            <div class="value">{{ number_format((Auth::user()->available_fund ?? 0),2,'.',',') }}</div>
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

         <div class="list-group-item menu-item">
            <a class="menu-link" onclick="loadPage('{{ route('reset_password') }}')">
                <div class="menu-item-icon">
                    <img src="{{ asset('img/profile/password.png') }}">
                </div>
                <div class="menu-item-label"><span>Reset Password</span><i class="ri-arrow-right-s-line"></i></div>
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
    initializeAllSwipers();
    $('.menu-item').removeClass('active');
    $('#account-icon').addClass('active');
</script>
@endsection

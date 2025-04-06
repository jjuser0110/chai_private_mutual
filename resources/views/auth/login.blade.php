@extends('layouts.app')

@section('content')
<div id="page-content" class="auth-page login-page">
	<div class="page-header">
		<a class="customer-service" target="_blank" href="#">
			<i class="ri-customer-service-line"></i>
		</a>
		<div class="close-wrapper cursor-pointer" onclick="loadPage('{{ route('index') }}')">
			<i class="ri-close-circle-line"></i>
		</div>
	</div>
	<div class="logo">
		<img src="{{ asset('img/logo.png') }}" alt="Hong Leong Bank Logo">
	</div>
	<div class="form-login">
		<div id="login-step-1">
			<div class="input-group">
				<span class="input-group-text"><i class="ri-mail-line"></i></span>
				<input type="text" id="username" class="form-control" placeholder="Please enter your Username">
			</div>
			<div class="btn-wrapper">
				<button class="btn btn-md btn-primary" id="btn-next" type="button">Next</button>
			</div>
		</div>
		<div id="login-step-2" style=";display:none">
			<div id="text-username">Username: null</div>
			<div class="input-group">
				<span class="input-group-text"><i class="ri-lock-line"></i></span>
				<input type="password" id="password" class="form-control" placeholder="Please enter your Password">
			</div>
			<div class="btn-wrapper">
				<button id="btn-previous" class="btn btn-md btn-primary" type="button">Previous</button>
			</div>
			<div class="btn-wrapper">
				<button class="btn btn-md btn-primary" type="button">Login</button>
			</div>
		</div>
		<div class="btn-wrapper">
			<a class="btn btn-secondary" onclick="loadPage('{{ route('register') }}')">Register</a>
		</div>
	</div>
</div>
@endsection

@section('custom')
<script>
    $('.menu-item').removeClass('active');
	$('#btn-next').off('click').on('click',function(){
		let username = $('#username').val();
		if(username){
			$('#text-username').html('Username: '+username);
			$('#login-step-1').css('display','none');
			$('#login-step-2').css('display','block');
		}
	});

	$('#btn-previous').off('click').on('click',function(){
		$('#login-step-2').css('display','none');
		$('#login-step-1').css('display','block');
	});
</script>
@endsection
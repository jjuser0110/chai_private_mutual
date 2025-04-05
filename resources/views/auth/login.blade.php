@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
<style>
	#forgotpassword{
		margin-top: -15px;
		font-size: 12px;
		display: flex;
		justify-content: flex-end;
		margin-bottom: 15px;
		color: white;
	}

	.text-danger{
		color:#fa6969;
		font-size:0.8em;
	}
</style>
@endsection

@section('content')
<div class="box">
	<div class="section bg-transparent ds">
		<div class="bg-dark ds section-header">
			<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-shield"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 21v-2a4 4 0 0 1 4 -4h2" /><path d="M22 16c0 4 -2.5 6 -3.5 6s-3.5 -2 -3.5 -6c1 0 2.5 -.5 3.5 -1.5c1 1 2.5 1.5 3.5 1.5z" /><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /></svg>
			<label>SIGN IN</label>
		</div>

		<form method="POST" action="{{ route('login') }}" onsubmit="showLoading()">
			@csrf
			<div class="input-field custom">
				<input type="text" name="username" placeholder="" class="inp-default inp-focus">
				<label>Username</label>
			</div>
			<div class="input-field custom">
				<input type="password" name="password" placeholder="" class="inp-default inp-focus">
				<label>Password</label>
			</div>
			@error('username')
				<span class="text-danger">{{ $message }}</span>
			@enderror
			@error('password')
				<span class="text-danger">{{ $message }}</span>
			@enderror
			<a id="forgotpassword" href="{{ route('forgotpassword') }}">Forgot password?</a>
			<button class="btn btn-submit" type="submit">Login</button>
			<a class="additional-link" href="{{ route('register') }}">Don't have an account yet? <span>SIGN UP NOW</span></a>
		</form>
	</div>
</div>
@endsection
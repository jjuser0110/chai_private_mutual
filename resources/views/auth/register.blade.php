@extends('layouts.app')

@section('content')
<div id="page-content" class="auth-page register-page">
	<div class="page-header">
		<div></div>
		<div class="close-wrapper cursor-pointer" onclick="loadPage('{{ route('index') }}')">
			<i class="ri-close-circle-line"></i>
		</div>
	</div>
	<div class="logo">
		<img src="{{ asset('img/logo.png') }}" alt="Hong Leong Bank Logo">
	</div>
	<div class="form-register">
		<div class="input-group">
			<span class="input-group-text"><i class="ri-mail-line"></i></span>
			<input type="text" id="username" class="form-control" placeholder="Username">
		</div>
		<div class="input-group">
			<span class="input-group-text"><i class="ri-lock-line"></i></span>
			<input type="password" id="password" class="form-control" placeholder="Password">
		</div>
		<div class="login-tips"><span>* Eight or more characters, including upper and lowercase letters and at least one number.</span></div>
		<div class="login-tips"><span>* Never share your account password, verification codes, or account security details with anyone.</span></div>
		<div class="input-group">
			<span class="input-group-text"><i class="ri-lock-line"></i></span>
			<input type="password" id="passwordConfirmation" class="form-control" placeholder="Confirm Password">
		</div>
		<div class="input-group">
			<span class="input-group-text"><i class="ri-barcode-box-line"></i></span>
			<input type="text" id="invitationCode" class="form-control" placeholder="Invitation Code">
		</div>
		<div class="btn-wrapper">
			<button class="btn btn-md btn-primary" type="button">Create Account</button>
		</div>
	</div>
</div>
@endsection

@section('custom')
<script>
    $('.menu-item').removeClass('active');
</script>
@endsection
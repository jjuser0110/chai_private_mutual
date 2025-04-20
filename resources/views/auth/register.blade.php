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
	<form class="form-register" id="form-register">
		<div class="input-group">
			<span class="input-group-text"><i class="ri-mail-line"></i></span>
			<input type="text" id="username" name="username" class="form-control" placeholder="Username">
		</div>
		<div class="input-group">
			<span class="input-group-text"><i class="ri-lock-line"></i></span>
			<input type="password" id="password" name="password" class="form-control" placeholder="Password">
		</div>
		<div class="login-tips"><span>* Eight or more characters, including upper and lowercase letters and at least one number.</span></div>
		<div class="login-tips"><span>* Never share your account password, verification codes, or account security details with anyone.</span></div>
		<div class="input-group">
			<span class="input-group-text"><i class="ri-lock-line"></i></span>
			<input type="password" id="passwordConfirmation" name="password_confirmation" class="form-control" placeholder="Confirm Password">
		</div>
		<div class="input-group">
			<span class="input-group-text"><i class="ri-barcode-box-line"></i></span>
			<input type="text" id="invitationCode" name="invitation_code" class="form-control" placeholder="Invitation Code">
		</div>
		<div class="btn-wrapper">
			<button class="btn btn-md btn-primary" type="submit">Create Account</button>
		</div>
	</from>
</div>
@endsection

@section('custom')
<script>
    $('.menu-item').removeClass('active');

	$('#form-register').off('submit').on('submit', function(e) {
		e.preventDefault();
		showLoading();
		var formData = new FormData(this);
		var btn = $(this).find('button[type="submit"]');
		$(btn).prop("disabled", true);
		$.ajax({
			url: "{{ route('submit_register') }}",
			method: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			success: function(response) {
				if(response.success == true){
					window.location.href = "{{ route('index') }}"
				}
				else{
					showToast('error','Failed',response.message)
				}
			},
			error: function() {
				showToast('error','Failed', 'There is something wrong, please try again.')
			},
			complete: function(){
				$(btn).prop("disabled", false);
				hideLoading();
			}
		});
	});
</script>
@endsection
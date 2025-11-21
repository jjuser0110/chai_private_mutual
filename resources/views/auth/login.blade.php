@extends('layouts.app')

@section('content')
<div id="page-content" class="auth-page login-page">
	<div class="page-header">
		<a class="customer-service" href="#" onclick="livechat();return false;" id="livechatID">
			<i class="ri-customer-service-line"></i>
		</a>
		<div class="close-wrapper cursor-pointer" onclick="loadPage('{{ route('index') }}')">
			<i class="ri-close-circle-line"></i>
		</div>
	</div>
	<div class="logo">
		<img src="{{ asset('img/logo.png') }}" alt="Hong Leong Bank Logo">
	</div>
	<form class="form-login"  id="form-login">
		<div id="login-step-1">
			<div class="input-group">
				<span class="input-group-text"><i class="ri-mail-line"></i></span>
				<input type="text" id="username" name="username" class="form-control" placeholder="Please enter your Username">
			</div>
			<div class="btn-wrapper">
				<button class="btn btn-md btn-primary" id="btn-next" type="button">Next</button>
			</div>
		</div>
		<div id="login-step-2" style=";display:none">
			<div id="text-username">Username: null</div>
			<div class="input-group">
				<span class="input-group-text"><i class="ri-lock-line"></i></span>
				 <img class="cus-toggle-password" src="{{ asset('img/grey-eyeoff.png') }}" alt="Toggle" />
				<input type="password" id="password" name="password" class="form-control" placeholder="Please enter your Password">
				  
			</div>
			<div class="btn-wrapper">
				<button id="btn-previous" class="btn btn-md btn-primary" type="button">Previous</button>
			</div>
			<div class="btn-wrapper">
				<button class="btn btn-md btn-primary" type="submit">Login</button>
			</div>
		</div>
		<div class="btn-wrapper">
			<a class="btn btn-secondary" onclick="loadPage('{{ route('register') }}')">Register</a>
		</div>
	</form>
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

	$('#form-login').off('submit').on('submit', function(e) {
		e.preventDefault();
		showLoading();
		var formData = new FormData(this);
		var btn = $(this).find('button[type="submit"]');
		$(btn).prop("disabled", true);
		$.ajax({
			url: "{{ route('submit_login') }}",
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
		})
	});

	 document.querySelectorAll('.cus-toggle-password').forEach(toggle => {
        toggle.addEventListener('click', () => {
            const input = toggle.nextElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
                toggle.src = "{{ asset('img/grey-eye.png') }}";
            } else {
                input.type = 'password';
                toggle.src = "{{ asset('img/grey-eyeoff.png') }}";
            }
        });
    });
</script>
@endsection
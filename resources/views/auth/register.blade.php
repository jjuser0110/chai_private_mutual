@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
<style>
.btn-submit:disabled {
	cursor: not-allowed;
	opacity: 0.5; 
}
</style>
@endsection

@section('content')
<div class="box">
	<div class="section bg-transparent ds">
		<div class="bg-dark ds section-header">
			<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M16 19h6" /><path d="M19 16v6" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /></svg>
			<label>Sign up</label>
		</div>

		<form method="POST" action="{{ route('user_register') }}" onsubmit="showLoading()">
			@csrf         
			<div class="input-field custom">
				<input type="text" name="username" id="username" placeholder="" class="inp-default inp-focus" autocomplete="username" value="{{ old('username') }}" required pattern="[A-Za-z0-9]{8,12}" title="8-12 characters long and only letters and numbers">
				<label>Username</label>
                <p class="input-note">*8-12 characters long and only letters and numbers</p>
			</div>

            <div class="input-field custom">
				<input type="password" name="password" id="password" autocomplete="new-password" pattern=".{8,12}" title="8-12 characters long" placeholder="" class="inp-default inp-focus" required>
				<label>Password</label>
                <p class="input-note">*8-12 characters long</p>
			</div>

            <div class="input-field custom">
				<input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" placeholder="" class="inp-default inp-focus  @error('password') is-invalid @enderror" pattern=".{8,12}" title="8-12 characters long" required>
				<label>Re-enter Password</label>
                <p class="input-note">*8-12 characters long</p>
			</div>

            <div class="input-field custom with-note">
				<input type="text" name="name" id="name" placeholder="" class="inp-default inp-focus" value="{{ old('name') }}" required pattern="[A-Za-z\s]+" title="Only Letters and Spaces">
				<label>Full Name</label>
                <p class="input-note">*Must be same name with your bank account & Only Letters and Spaces</p>
			</div>

            <div class="input-field custom">
				<input type="text" name="contact_no" id="contact_no" placeholder="" class="inp-default inp-focus" value="{{ old('contact_no') }}" required>
				<label>Contact No</label>
                <p class="input-note" style="color:gold;font-weight:700">*Example : 0434277975/434277975</p>
			</div>

			@if(request()->has('referral_code'))
				<div class="input-field custom">
					<input type="input" name="referral_code" id="referral_code" placeholder="" class="inp-default inp-focus" value="{{ request()->input('referral_code') }}" readonly>
					<label>Referral</label>
				</div>
			@else
				<div class="input-field custom">
					<input type="input" name="referral_code" id="referral_code" placeholder="" class="inp-default inp-focus" value="{{ old('referral_code') }}">
					<label>Referral</label>
				</div>
			@endif

            <div class="group-input">
				<div class="input-field custom with-note" style="width">
					<input type="text" name="otpnumber" placeholder="" class="inp-default inp-focus" required>
					<label>OTP Code</label>
                    <p class="input-note">*Please click Send to receive OTP via SMS</p>
				</div>
				<div class="extra-field">
					<a class="btn btn-otp" id="sendotp" onclick="startCountdown()">Send</a>
				</div>
			</div>
			
			<button class="btn btn-submit" type="submit" id="create_button" >Create Account</button>
			<a class="additional-link" href="{{ route('login') }}">Already have an account? <span>SIGN IN NOW</span></a>
		</form>
	</div>
</div>
<script>

	function startCountdown() {
        const btn = document.getElementById("sendotp");
        if (btn.disabled) {
            return; 
        }
        countdown = 120;

        var postData = {};
        postData.contact_no = document.getElementById("contact_no").value;
        postData.username = document.getElementById("username").value;
        postData.password = document.getElementById("password").value;
        postData.password_confirmation = document.getElementById("password_confirmation").value;
        postData.name = document.getElementById("name").value;
        postData.referral_code = document.getElementById("referral_code").value;
        postData._token = "{{ csrf_token() }}";

		console.log(postData);
        $.ajax({
            url: "<?php echo route("sendsms") ?>",
            method: "POST",
            data: postData,
            success: function(response){
				console.log(response);
                if(response.success){
                    btn.disabled = true;
                    updateCountdown();
                    countdownTimer = setInterval(updateCountdown, 1000);
					var button = document.getElementById("create_button");
					button.removeAttribute("disabled");
					document.getElementById('contact_no').setAttribute('readonly', true);
					document.getElementById('username').setAttribute('readonly', true);
					document.getElementById('password').setAttribute('readonly', true);
					document.getElementById('password_confirmation').setAttribute('readonly', true);
					document.getElementById('name').setAttribute('readonly', true);
					document.getElementById('referral_code').setAttribute('readonly', true);
                    setSwal(1, response.msg, 1500);
                }else{
                    setSwal(0, response.msg, 5000);
                }
            }
        });

		function updateCountdown() {
			const btn = document.getElementById("sendotp");
			countdown--;
			if (countdown <= 0) {
				// Countdown is done, enable the send button
				clearInterval(countdownTimer);
				btn.textContent = "Send";
				btn.disabled = false;
			} else {
				// Update the countdown text on the button
				btn.textContent = countdown.toString();
			}
		}

    }
</script>

@endsection

@extends('layouts.app')

@section('content')
<div id="page-content" class="auth-page register-page">
	<div class="page-header">
		<div></div>
		<div class="close-wrapper cursor-pointer" onclick="window.location.href='{{ route('logout') }}'">
			<i class="ri-close-circle-line"></i>
		</div>
	</div>
	<div class="logo">
		<img src="{{ asset('img/logo.png') }}" alt="Hong Leong Bank Logo">
	</div>
    <div style="display:flex;justify-content:center;margin-bottom: 20px;">Setup Your Profile</div>
    <form class="form-register" id="form-setup">

        <div class="input-group">
			<span class="input-group-text"><i class="ri-user-line"></i></span>
			<input type="text" id="name" name="name" class="form-control" placeholder="Full Name">
		</div>

        <div class="input-group">
			<span class="input-group-text"><i class="ri-profile-line"></i></span>
			<input type="number" id="nric-no" name="nric_no" class="form-control" placeholder="NRIC No">
		</div>

        <div class="input-group">
			<span class="input-group-text"><i class="ri-smartphone-line"></i></span>
			<input type="number" id="contact-no" name="contact_no" class="form-control" placeholder="Contact No">
		</div>

        <div class="input-group">
			<span class="input-group-text"><i class="ri-mail-line"></i></span>
			<input type="text" id="email" name="email" class="form-control" placeholder="Email">
		</div>

		<div class="input-group">
			<span class="input-group-text"><i class="ri-lock-line"></i></span>
			<input type="password" id="fund-password" name="fund_password" class="form-control" placeholder="Fund Password">
		</div>

        <div class="upload-wrapper">
            <div class="preview-wrapper" id="wrapper1">
                <span class="preview-text">Front Photo of your NRIC</span>
            </div>
            <input class="form-control" type="file" id="nric-front" name="nric_front" accept="image/*">
        </div>

        <div class="upload-wrapper">
            <div class="preview-wrapper" id="wrapper2">
                <span class="preview-text">Back Photo of your NRIC</span>
            </div>
            <input class="form-control" type="file" id="nric-back" name="nric_back" accept="image/*">

         </div>

		<div class="btn-wrapper">
			<button class="btn btn-md btn-primary" type="submit">Submit</button>
		</div>
	</from>
</div>
@endsection

@section('custom')
<script>
    function setupBackgroundPreview(inputId, wrapperId) {
        const input = document.getElementById(inputId);
        const wrapper = document.getElementById(wrapperId);
        const text = wrapper.querySelector('.preview-text');

        input.addEventListener('change', () => {
        const file = input.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = e => {
            wrapper.style.backgroundImage = `url(${e.target.result})`;
            wrapper.classList.add('filled');
            };
            reader.readAsDataURL(file);
        } else {
            wrapper.style.backgroundImage = '';
            wrapper.classList.remove('filled');
        }
        });
    }

    setupBackgroundPreview('nric-front', 'wrapper1');
    setupBackgroundPreview('nric-back', 'wrapper2');

    $('.menu-item').removeClass('active');

	$('#form-setup').off('submit').on('submit', function(e) {
		e.preventDefault();
		showLoading();
		var formData = new FormData(this);
		var btn = $(this).find('button[type="submit"]');
		$(btn).prop("disabled", true);
		$.ajax({
			url: "{{ route('submit_setup') }}",
			method: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			success: function(response) {
				if(response.success == true){
                    showToast('success','Success', response.message);
                    loadPage('{{ route('index') }}');
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
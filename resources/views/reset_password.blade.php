@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('account') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Reset Password</div>
</div>

<div id="page-content" class="history-page">
    <div class="join-record">
        <ul class="nav nav-tabs" id="join-record-options">
            <li class="nav-item">
                <button class="nav-link active" onclick="showForm(this)" data-value="form-reset-password">Password</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" onclick="showForm(this)" data-value="form-reset-fund-password">Fund Password</button>
            </li>
        </ul>
    </div>

    <form id="form-reset-password" class="multi-form-wrapper fade show">
        <div class="custom-form-group">
            <div class="input-group" role="group">
                <div class="input-group-text">
                    <span>Current Password</span>
                </div>
                <input class="form-control" type="password" name="old_password" style="padding-right:50px">
                <img class="cus-toggle-password" src="{{ asset('img/eyeoff.png') }}" alt="Toggle" />
            </div>
        </div>

        <div class="divider"></div>

        <div class="custom-form-group">
            <div class="input-group" role="group">
                <div class="input-group-text">
                    <span>New Password</span>
                </div>
                <input class="form-control" type="password" name="password" style="padding-right:50px">
                <img class="cus-toggle-password" src="{{ asset('img/eyeoff.png') }}" alt="Toggle" />
            </div>
        </div>

        <div class="divider"></div>

        <div class="custom-form-group">
            <div class="input-group" role="group">
                <div class="input-group-text">
                    <span>Confirm New Password</span>
                </div>
                <input class="form-control" type="password" name="password_confirmation" style="padding-right:50px">
                 <img class="cus-toggle-password" src="{{ asset('img/eyeoff.png') }}" alt="Toggle" />
            </div>
        </div>
        
        <div class="divider"></div>
        
        <div class="btn-wrapper" style="padding-left:0.5rem;padding-right:0.5rem">
            <button tyle="submit" class="btn btn-md btn-primary w-100 text-uppercase" style="margin-top:1rem">
                <span class="me-3">Reset</span>
            </button>
        </div>
    </form>

    <form id="form-reset-fund-password" class="multi-form-wrapper">
        @if(!Auth::user()->fund_password)
            <a class="btn btn-md btn-primary w-100 text-uppercase" href="{{ route('setup') }}" style="max-width:80%;margin:1rem 10% 0;">
                <span class="me-3">Setup Profile</span>
            </a>
        @else
        <div class="custom-form-group">
            <div class="input-group" role="group">
                <div class="input-group-text">
                    <span>Current Fund Password</span>
                </div>
                <input class="form-control" type="password" name="old_fund_password" style="padding-right:50px">
                <img class="cus-toggle-password" src="{{ asset('img/eyeoff.png') }}" alt="Toggle" />
            </div>
        </div>

        <div class="divider"></div>

        <div class="custom-form-group">
            <div class="input-group" role="group">
                <div class="input-group-text">
                    <span>New Fund Password</span>
                </div>
                <input class="form-control" type="password" name="fund_password" style="padding-right:50px">
                <img class="cus-toggle-password" src="{{ asset('img/eyeoff.png') }}" alt="Toggle" />
            </div>
        </div>

        <div class="divider"></div>

        <div class="custom-form-group">
            <div class="input-group" role="group">
                <div class="input-group-text">
                    <span>Confirm New Password</span>
                </div>
                <input class="form-control" type="password" name="fund_password_confirmation" style="padding-right:50px">
                <img class="cus-toggle-password" src="{{ asset('img/eyeoff.png') }}" alt="Toggle" />
            </div>
        </div>
        
        <div class="divider"></div>
        
        <div class="btn-wrapper" style="padding-left:0.5rem;padding-right:0.5rem">
            <button type="submit" class="btn btn-md btn-primary w-100 text-uppercase" style="margin-top:1rem">
                <span class="me-3">Reset</span>
            </button>
        </div>
        @endif
    </form>
</div>


@endsection
@section('custom')
<script>
    $('.menu-item').removeClass('active');

    function showForm(x){
        if(x){
            let target = $(x).data('value') ?? 'form-reset-password';
            $('.nav-link').removeClass('active');
            $('.multi-form-wrapper').removeClass('show fade');
            $(x).addClass('active');
            $(`#${target}`).addClass('show');
            setTimeout(() => {
                 $(`#${target}`).addClass('fade');
            }, 100);
        }
    }

    document.querySelectorAll('.cus-toggle-password').forEach(toggle => {
        toggle.addEventListener('click', () => {
            const input = toggle.previousElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
                toggle.src = "{{ asset('img/eye.png') }}";
            } else {
                input.type = 'password';
                toggle.src = "{{ asset('img/eyeoff.png') }}";
            }
        });
    });

    $('#form-reset-password').off('submit').on('submit', function(e) {
		e.preventDefault();
		showLoading();
		var formData = new FormData(this);
		var btn = $(this).find('button[type="submit"]');
		$(btn).prop("disabled", true);
		$.ajax({
			url: "{{ route('submit_reset_password') }}",
			method: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			success: function(response) {
				if(response.success == true){
					infoModal(response.message, "{{ route('account') }}")
				}
				else{
                    if(response.banned == 1){
                        infoModal(response.message, "{{ route('login') }}")
                    }
                    else{
                        showToast('error','Failed',response.message);
                    }
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

    $('#form-reset-fund-password').off('submit').on('submit', function(e) {
		e.preventDefault();
		showLoading();
		var formData = new FormData(this);
		var btn = $(this).find('button[type="submit"]');
		$(btn).prop("disabled", true);
		$.ajax({
			url: "{{ route('submit_reset_fund_password') }}",
			method: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			success: function(response) {
				if(response.success == true){
					infoModal(response.message, "{{ route('update_account') }}")
				}
				else{
                    if(response.banned == 1){
                        infoModal(response.message, "{{ route('login') }}")
                    }
                    else{
                        showToast('error','Failed',response.message);
                    }
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

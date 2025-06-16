@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('account') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Information Edit</div>
</div>

<div id="page-content">
    <form id="form-update-profile">
        <div class="custom-form-group">
            <div class="input-group" role="group">
                <div class="input-group-text">
                    <span class="icon">
                        <div class="image-icon menu-item-icon">
                            <img src="{{ asset('img/profile/mobile.png') }}" alt="Mobile" />
                        </div>
                    </span>
                    <span>Mobile</span>
                </div>
                <input class="form-control" type="number" name="contact_no" value="{{ Auth::user()->contact_no ?? ''}}" readonly>
            </div>
        </div>

        <div class="divider"></div>

        <div class="custom-form-group">
            <div class="input-group" role="group">
                <div class="input-group-text">
                    <span class="icon">
                        <div class="image-icon menu-item-icon">
                            <img src="{{ asset('img/profile/name.png') }}" alt="Name">
                        </div>
                    </span>
                    <span>Name</span>
                </div>
                <input class="form-control" type="text" name="name" value="{{ Auth::user()->name ?? ''}}" readonly>
            </div>
        </div>

        <div class="divider"></div>

        <div class="custom-form-group">
            <div class="input-group" role="group">
                <div class="input-group-text">
                    <span class="icon">
                        <div class="image-icon menu-item-icon">
                            <img src="{{ asset('img/profile/card.png') }}" alt="ID Card">
                        </div>
                    </span>
                    <span>ID Card</span>
                </div>
                <input class="form-control" type="text" name="nric_no" value="{{ Auth::user()->nric_no ?? ''}}" readonly>
            </div>
        </div>
        
        <div class="divider"></div>
        
        <div class="btn-wrapper" style="padding-left:0.5rem;padding-right:0.5rem">
            <!-- <button class="btn btn-md btn-primary w-100 text-uppercase" style="margin-top:1rem" type="submit">
                <span class="me-3">Submit</span>
            </button> -->
            <a class="btn btn-md btn-primary w-100 text-uppercase" style="margin-top:1rem" href="{{route('account')}}">
                <span class="me-3">Back</span>
            </a>
        </div>
    </div>
</div>
@endsection

@section('custom')
<script>
    $('.menu-item').removeClass('active');
    $('#form-update-profile').off('submit').on('submit', function(e) {
		e.preventDefault();
		showLoading();
		var formData = new FormData(this);
		var btn = $(this).find('button[type="submit"]');
		$(btn).prop("disabled", true);
		$.ajax({
			url: "{{ route('submit_update_account') }}",
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
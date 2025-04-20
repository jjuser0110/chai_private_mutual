@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('bank_account') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Add Bank Account</div>
</div>

<div id="page-content">
    <form id="form-add-bank">
    <div class="custom-form-group">
        <div class="input-group">
            <div class="input-group-text">Bank Name</div>
            <select class="form-select" name="bank_id">
                @foreach($banks as $bank)
                <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="divider"></div>

    <div class="custom-form-group">
        <div class="input-group">
            <div class="input-group-text">Bank Account Number</div>
            <input class="form-control" type="number" name="account_no">
        </div>
    </div>

    <div class="divider"></div>

    <div class="custom-form-group">
        <div class="input-group">
            <div class="input-group-text">Bank Holder Name</div>
            <input class="form-control" type="text" name="full_name">
        </div>
    </div>
    
    <div class="btn-wrapper" style="padding-left:0.5rem;padding-right:0.5rem">
        <button class="btn btn-md btn-primary w-100 text-uppercase" style="margin-top:1rem" type="submit">
            <span class="me-3">Submit</span>
        </button>
    </div>
</form>
</div>
@endsection

@section('custom')
<script>
    $('.menu-item').removeClass('active');

    $('#form-add-bank').off('submit').on('submit', function(e) {
		e.preventDefault();
		showLoading();
		var formData = new FormData(this);
		var btn = $(this).find('button[type="submit"]');
		$(btn).prop("disabled", true);
		$.ajax({
			url: "{{ route('submit_add_bank') }}",
			method: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			success: function(response) {
				if(response.success == true){
					infoModal(response.message, "{{ route('bank_account') }}")
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
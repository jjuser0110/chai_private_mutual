@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('account') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Withdraw</div>
</div>

<div id="page-content">
    <form id="form-withdraw">
        <div class="custom-form-group">
            <div class="input-group">
                <div class="input-group-text">Withdraw Amount</div>
                <input class="form-control" type="text" placeholder="Please enter the withdrawal" name="amount">
            </div>
        </div>

        <div class="help-text text-end small">
            Withdrawal Limit:<span class="text-primary">MYR 300.00 - MYR 10,000.00</span>
            <br>
            Maximum Daily Withdrawal Amount: <span class="text-primary">MYR 100,000.00</span>
        </div>

        <div class="custom-form-group">
            <div class="input-group">
                <div class="input-group-text">Fund Password</div>
                <input class="form-control" type="password" placeholder="Please enter Fund Password" name="fund_password">
            </div>
        </div>

        <div class="custom-form-group">
            <div class="input-group">
                <div class="input-group-text">Select a Bank Account</div>
                <select class="form-select" name="bank">
                    @foreach(Auth::user()->user_banks ?? [] as $bank)
                    <option value="{{ $bank->id }}">[{{ $bank->bank->bank_name }}] {{ $bank->full_name }} | {{ $bank->account_no }}</option>
                    @endforeach
                </select>
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
    $('#form-withdraw').off('submit').on('submit', function(e) {
		e.preventDefault();
		showLoading();
		var formData = new FormData(this);
		var btn = $(this).find('button[type="submit"]');
		$(btn).prop("disabled", true);
		$.ajax({
			url: "{{ route('submit_withdraw') }}",
			method: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			success: function(response) {
				if(response.success == true){
					infoModal(response.message, "{{ route('withdraw_record') }}")
				}
				else{
					showToast('error','Failed',response.message);
                    if (response.redirect) {
                        setTimeout(function () {
                            window.location.href = response.redirect;
                        }, 2000); // 2 seconds
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
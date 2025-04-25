@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('address') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title"></div>
</div>

<div id="page-content">
    <form id="form-add-address">
        <h4 class="title">Delivery Address</h4>
        <div class="desc mb-3">Add Address</div>
        <div class="card mb-3">
            <div class="card-body" style="padding-top:0">
                <div class="input-group">
                    <span class="input-group-text">
                        <span>Contact Name</span>
                    </span>
                    <input class="form-control" type="text" name="contact_name">
                </div>
        
                <div class="input-group">
                    <span class="input-group-text">
                        <span>Phone Number</span>
                    </span>
                    <input class="form-control" type="text" name="phone_no">
                </div>
               
                <div style="padding-top:1rem">
                    <label>Address</label>
                    <textarea class="form-control" rows="2" wrap="soft" style="resize: none;" name="address"></textarea>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="form-switch wrapper">
                    <div class="content">
                        <div class="title">Default Address</div>
                        <div class="desc" style="margin-bottom:0 !important">This Address Is Automatically Used By Default Each Time An Order Is Placed</div>
                    </div>
                    <div class="form-check form-switch">
                        <input id="qwe-check" class="form-check-input" type="checkbox" value="true" style="height:16px;width:32px">
                        <label for="qwe-check" class="form-check-label"></label>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-md btn-primary w-100" type="submit">Confirm</button></div>
    </form>
@endsection

@section('custom')
<script>
    $('.menu-item').removeClass('active');
    $('#form-add-address').off('submit').on('submit', function(e) {
		e.preventDefault();
		showLoading();
		var formData = new FormData(this);
		var btn = $(this).find('button[type="submit"]');
		$(btn).prop("disabled", true);
		$.ajax({
			url: "{{ route('submit_add_address') }}",
			method: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			success: function(response) {
				if(response.success == true){
					infoModal(response.message, "{{ route('address') }}")
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
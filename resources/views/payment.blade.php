@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('shop') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Product Details</div>
</div>

<div id="page-content">
    <form id="form-payment">
        <input type="hidden" name="address" value="{{ $address->id ?? ''}}">
        <input type="hidden" name="item" value="{{ $item->id ?? ''}}">
        <div class="card shipping-address-card" onclick="loadPage('{{ route('address') }}')">
            <div class="card-body">
                <div class="address-info">
                    <div class="label">{{ $address->address ?? 'Please Select A Shipping Address' }}</div>
                    <div class="icon">
                        <i class="ri-arrow-right-s-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="card product-card mb-3">
            <div class="card-body">
                <div class="product-wrapper">
                    <div class="product-thumbnail" style="background-image:url('{{ env('BACKEND_URL') }}/storage/{{ $item->thumbnail()->file_path }}')"></div>
                    <div class="product-info">
                        <div class="title">{{ $item->item_name }}</div>
                        <div class="desc">
                            <i class="ri-coins-line"></i>
                            <span class="price">{{ number_format($item->item_point,2,'.',',') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-md btn-primary w-100" type="submit"><span>Pay</span> </button>
    </form>
</div>
@endsection

@section('custom')
<script>
    localStorage.setItem('last_order', {{$item->id}});
    $('.menu-item').removeClass('active');
    $('#form-payment').off('submit').on('submit', function(e) {
		e.preventDefault();
        @if(Auth::user()->invalid_fund > 0)
			showToast('error','Failed',"You unable to perform this action. please contact customer services!")
		@else
		showLoading();
		var formData = new FormData(this);
		var btn = $(this).find('button[type="submit"]');
		$(btn).prop("disabled", true);
		$.ajax({
			url: "{{ route('submit_payment') }}",
			method: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			success: function(response) {
				if(response.success == true){
					infoModal(response.message, "{{ route('order') }}")
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
        @endif
	});
</script>
@endsection
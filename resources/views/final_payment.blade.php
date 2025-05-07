@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route( 'booking_record') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Final Payment</div>
</div>

<div id="page-content">
    @if(isset($booking))
    <form id="form-final-payment">
        <input type="hidden" value="{{ $booking->id }}" name="booking"/>
        <div class="card product-card mb-3" style="background:#24262b">
            <div class="card-body">
                <div class="product-wrapper">
                    <div class="product-thumbnail" style="background-image:url('{{ env('BACKEND_URL') }}/storage/{{ $booking->product->thumbnail->file_path }}')"></div>
                    <div class="product-info final-payment">
                        <div class="title">{{ $booking->product->product_name }}</div>
                        <div class="info">Paid Amount: <span class="success">{{ number_format($booking->booking_amount,2,'.',',') ?? '0.00' }}</span></div>
                        <div class="info">Final Payment: <span class="failed">{{ number_format($booking->final_payment,2,'.',',') ?? '0.00' }}</span></div>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-md btn-primary w-100" type="submit"><span>Pay {{ number_format($booking->final_payment,2,'.',',') ?? '0.00' }}</span></button>
    </form>
    @else
    <div class="no-data">
        <div class="icon">
            <img src="{{ asset('img/no-data.png') }}" alt="No Data">
        </div>
        <div class="label">Booking not found or expired.</div>
    </div>
    @endif
</div>
@endsection

@section('custom')
<script>
    $('.menu-item').removeClass('active');
  
    $('#form-final-payment').off('submit').on('submit', function(e) {
		e.preventDefault();
		showLoading();
		var formData = new FormData(this);
		var btn = $(this).find('button[type="submit"]');
		$(btn).prop("disabled", true);
		$.ajax({
			url: "{{ route('submit_final_payment') }}",
			method: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			success: function(response) {
				if(response.success == true){
					infoModal(response.message, "{{ route('booking_record') }}")
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
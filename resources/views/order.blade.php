@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('shop') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Orders</div>
</div>

<div id="page-content" class="history-page">
    <div class="order-status">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <button onclick="loadOrder(this)" data-value="all" class="nav-link active">All</button>
            </li>
            <li class="nav-item">
                <button onclick="loadOrder(this)" data-value="not shipped" class="nav-link">Not Shipped</button>
            </li>
            <li class="nav-item">
                <button onclick="loadOrder(this)" data-value="shipped" class="nav-link">Shipped</button>
            </li>
            <li class="nav-item">
                <button onclick="loadOrder(this)" data-value="completed" class="nav-link">Completed</button>
            </li>
        </ul>
    </div>

    <div id="orders-wrapper" class="fade"></div>
</div>
@endsection
@section('custom')
<script>
    $('.menu-item').removeClass('active');

    function loadOrder(x){
        let type = 'all';
        if(x){
            $('.order-status .nav-link').removeClass('active');
            $(x).addClass('active');
            type = $(x).data('value') ?? 'all';
            $('#orders-wrapper').removeClass('show');
        }
        $.ajax({
			url: "{{ route('load_order') }}",
			method: 'POST',
			data: {type:type},
			headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			success: function(response) {
				if(response.success == true){
                    document.getElementById('orders-wrapper').innerHTML = '';
                    
                    if(response.orders.length < 1){
                        document.getElementById('orders-wrapper').innerHTML = `<div class="no-data"><div class="icon"><img src="{{ asset('img/no-data.png') }}" alt="No Data"></div><div class="label">No Data</div></div>`;
                    }
                    else{
                        Object.values(response.orders).forEach((x)=>{
                            let order = document.createElement('div');
                            order.innerHTML = 
                                `<div class="card product-card mb-3">
                                    <div class="card-body">
                                        <div class="product-wrapper">
                                            <div class="product-thumbnail" style="background-image:url('{{ env('BACKEND_URL') }}/storage/${x.image}')"></div>
                                            <div class="product-info">
                                                <div class="title">${x.item_name}</div>
                                                <div class="desc"><span class="status">Status: ${x.status}</span></div>
                                                <div class="desc"><i class="ri-map-pin-line"></i><span class="address">${x.address}</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                            document.getElementById('orders-wrapper').append(order);
                        });
                    }
                    $('#orders-wrapper').addClass('show');
				}
				else{
					showToast('error','Failed',response.message)
				}
			},
			error: function() {
				showToast('error','Failed', 'There is something wrong, please try again.')
			},
			complete: function(){
				hideLoading();
			}
		});
    }

    loadOrder();
</script>
@endsection

@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="returnOrder()"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Address Selection</div>
</div>

<div id="page-content">
    <div style="padding: 0 1rem">
        @foreach(Auth::user()->user_addresses as $address)
        <div class="card shipping-address-card">
            <div class="card-body">
                <div class="address-info">
                    <button class="btn btn-md btn-secondary border-0" type="button" onclick="dropBank({{ $address->id }})"><i class="ri-close-line"></i></button>
                    <div class="info-wrapper" onclick="returnOrder({{ $address->id }})">
                        <div class="label">{{ $address->address }}</div>
                        <div class="icon">
                            <i class="ri-arrow-right-s-line"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <button class="btn btn-md btn-primary w-100" type="button" onclick="loadPage('{{ route('add_address') }}')"><span>Add Address</span></button>
    </div>
</div>
@endsection

@section('custom')
<script>
    $('.menu-item').removeClass('active');
    function dropBank(address){
        confirmationModal('Are you sure to delete the selected address?', function(){
            $.ajax({
                url: "{{ route('submit_delete_address') }}",
                method: 'POST',
                data: {target:address},
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
                    hideLoading();
                }
		    });
        })
    }

    function returnOrder(id){
        let item = localStorage.getItem('last_order');
        if(item){
            if(id){
                loadPage(`{{ route('payment',['id'=>'__ITEM__']) }}?address=${id}`.replace('__ITEM__',item));
            }
            else{
                loadPage(`{{ route('payment',['id'=>'__ITEM__']) }}`.replace('__ITEM__',item));
            }
         
        }
        else{
            loadPage("{{ route('shop') }}");
        }
    }
</script>
@endsection
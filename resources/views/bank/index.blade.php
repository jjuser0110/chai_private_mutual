@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('account') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Bank Account</div>
</div>

<div id="page-content">
    <div style="display:flex;flex-direction:column;height:100%;">
        @if(Auth::user()->user_banks->isEmpty())
        <div class="no-data">
            <div class="icon">
                <img src="{{ asset('img/no-data.png') }}" alt="No Data">
            </div>
            <div class="label">No Data</div>
        </div>
        @else
        <div id="user-banks">
            @foreach(Auth::user()->user_banks as $bank)
            <div class="card custom-card">
                <div class="card-body">
                    <div class="info">
                        <div class="name">{{ $bank->bank->bank_name }}</div>
                        <div class="card-content">
                            <div class="account-name">Account Name: {{ $bank->full_name }}</div>
                            <div class="account-number">Account Number: {{ $bank->account_no }}</div>
                        </div>
                    </div>
                    <div class="icon-wrapper">
                        <button class="btn btn-md btn-secondary" type="button" onclick="dropBank({{ $bank->id }})"><i class="ri-close-line"></i></button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
    <div class="btn-wrapper" style="padding-left:0.5rem;padding-right:0.5rem">
        <a class="btn btn-primary w-100" onclick="loadPage('{{ route('add_bank_account') }}')">Add Bank Account</a>
    </div>
</div>
@endsection

@section('custom')
<script>
    $('.menu-item').removeClass('active');
    
    function dropBank(bank){
        confirmationModal('Are you sure to delete the selected bank account?', function(){
            $.ajax({
                url: "{{ route('submit_delete_bank') }}",
                method: 'POST',
                data: {target:bank},
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
                    hideLoading();
                }
		    });
        })
    }
</script>
@endsection
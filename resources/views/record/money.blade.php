@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('account') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Money Records</div>
</div>

<div id="page-content" class="history-page">
    <div class="money-record">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <button onclick="loadBalance(this)" class="nav-link active">Balance</button>
            </li>
            <li class="nav-item">
                <button onclick="loadScore(this)" class="nav-link">Credit Score</button>
            </li>
        </ul>
    </div>

    <div id="table-balance-wrapper" class="table-wrapper fade">
        <div class="custom-datatable">
            <div class="flex-grow-1 mb-3">
                <div class="b-overlay-wrap position-relative">
                    <table class="table b-table table-dark mb-0" id="table-balance">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" width="30%">Record Type</th>
                                <th scope="col" class="text-center" width="20%">Amount</th>
                                <th scope="col" class="text-center" width="20%">Balance</th>
                                <th scope="col" class="text-end" width="auto">Time</th>
                            </tr>
                        </thead>
                        <tbody class="flex-grow-1">
                            <tr>
                                <td scope="colspan" class="nodata" colspan="5">
                                    <div class="no-data">
                                        <div class="icon">
                                            <img src="{{ asset('img/no-data.png') }}" alt="No Data">
                                        </div>
                                        <div class="label">No Data</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="custom-pagination"></div>
        </div>
    </div>

    <div id="table-score-wrapper" class="table-wrapper fade">
        <div class="custom-datatable">
            <div class="flex-grow-1 mb-3">
                <div class="b-overlay-wrap position-relative">
                    <table class="table b-table table-dark mb-0" id="table-score">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" width="30%">Score</th>
                                <th scope="col" class="text-center" width="30%">Value</th>
                                <th scope="col" class="text-end" width="auto">Time</th>
                            </tr>
                        </thead>
                        <tbody class="flex-grow-1">
                            <tr>
                                <td scope="colspan" class="nodata" colspan="3">
                                    <div class="no-data">
                                        <div class="icon">
                                            <img src="{{ asset('img/no-data.png') }}" alt="No Data">
                                        </div>
                                        <div class="label">No Data</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="custom-pagination"></div>
        </div>
    </div>
</div>
@endsection
@section('custom')
<script>
    $('.menu-item').removeClass('active');

    function loadScore(x){
        if(x){
            $('.nav-link').removeClass('active');
            $(x).addClass('active');
            $('.table-wrapper').removeClass('show');
        }

        $.ajax({
            url: "{{ route('load_score') }}",
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            success: function(response) {
                if(response.success == true){
                    let table = document.getElementById(`table-score`);
                    let tbody = table.querySelector('tbody');
                    tbody.innerHTML = '';
                    if(response.data.length < 1){
                        tbody.innerHTML = `<tr><td colspan="3" class="nodata"><div class="no-data"><div class="icon"><img src="{{ asset('img/no-data.png') }}" alt="No Data"></div><div class="label">No Data</div></div></td?</tr>`;
                    }
                    else{ 
                        response.data.forEach(item => {
                            let row = document.createElement('tr');
                            if(item.score >= 80){
                                $color = 'success';
                            }
                            else if(item.score >= 40 && item.score < 80){
                                $color = 'warning';
                            }
                            else{
                                $color = 'danger';
                            }
                            row.innerHTML = `<td class="${color}">${item.score ?? '-'}</td><td class="text-center ${color}">${item.value ?? '-'}</td> <td class="text-end">${formatDate(item.created_at)}</td>`;
                            tbody.appendChild(row);
                        });
                    }
                    $(`#table-score-wrapper`).addClass('show');
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

    function loadBalance(x){
        if(x){
            $('.nav-link').removeClass('active');
            $(x).addClass('active');
            $('.table-wrapper').removeClass('show');
        }

        $.ajax({
            url: "{{ route('load_balance') }}",
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            success: function(response) {
                if(response.success == true){
                    let table = document.getElementById(`table-balance`);
                    let tbody = table.querySelector('tbody');
                    tbody.innerHTML = '';
                    if(response.data.length < 1){
                        tbody.innerHTML = `<tr><td colspan="4" class="nodata"><div class="no-data"><div class="icon"><img src="{{ asset('img/no-data.png') }}" alt="No Data"></div><div class="label">No Data</div></div></td?</tr>`;
                    }
                    else{ 
                        response.data.forEach(item => {
                            let row = document.createElement('tr');
                            row.innerHTML = `<td style="text-transform:capitalize">${item.type ?? '-'}</td><td class="text-center">${formatNumber(item.amount ?? 0)}</td><td class="text-center">${formatNumber(item.final_amount ?? 0)}</td><td class="text-end">${formatDate(item.created_at)}</td>`;
                            tbody.appendChild(row);
                        });
                    }
                    $(`#table-balance-wrapper`).addClass('show');
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

    loadBalance();
</script>
@endsection

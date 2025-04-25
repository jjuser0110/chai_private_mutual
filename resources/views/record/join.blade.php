@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('account') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Join Record</div>
</div>

<div id="page-content" class="history-page">
    <div class="join-record">
        <ul class="nav nav-tabs" id="join-record-options">
            <li class="nav-item">
                <button class="nav-link active" onclick="loadData(this)" data-value="running">Running</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" onclick="loadData(this)" data-value="finished">Finished</button>
            </li>
        </ul>
    </div>

    <div id="table-running-wrapper" class="table-wrapper fade ">
        <div class="custom-datatable">
            <div class="flex-grow-1 mb-3">
                <div class="b-overlay-wrap position-relative">
                    <table class="table b-table table-dark mb-0" id="table-running">
                        <thead>
                            <tr>
                                <th scope="col" class="" width="30%">Project Name</th>
                                <th scope="col" class="text-center" width="15%">Investment Amount</th>
                                <th scope="col" class="text-center" width="auto">Dividend Amount</th>
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

    <div id="table-finished-wrapper" class="table-wrapper fade ">
        <div class="custom-datatable">
            <div class="flex-grow-1 mb-3">
                <div class="b-overlay-wrap position-relative">
                    <table class="table b-table table-dark mb-0" id="table-finished">
                        <thead>
                            <tr>
                                <th scope="col" class="" width="30%">Project Name</th>
                                <th scope="col" class="text-center" width="15%">Investment Amount</th>
                                <th scope="col" class="text-center" width="auto">Dividend Amount</th>
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
</div>


@endsection
@section('custom')
<script>
    $('.menu-item').removeClass('active');

    function loadData(x){
        let type = 'running';
        if(x){
            $('.nav-link').removeClass('active');
            $(x).addClass('active');
            type = $(x).data('value') ?? 'running';
            $('.table-wrapper').removeClass('show');
        }

        $.ajax({
			url: "{{ route('load_join') }}",
			method: 'POST',
			data: {type:type},
			headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			success: function(response) {
				if(response.success == true){
                    let table = document.getElementById(`table-${response.type}`);
                    let tbody = table.querySelector('tbody');
                    tbody.innerHTML = '';
                    if(response.data.length < 1){
                        tbody.innerHTML = `<tr><td colspan="4" class="nodata"><div class="no-data"><div class="icon"><img src="{{ asset('img/no-data.png') }}" alt="No Data"></div><div class="label">No Data</div></div></td?</tr>`;
                    }
                    else{ 
                        response.data.forEach(item => {
                            let row = document.createElement('tr');
                            if(response.type == 'finished'){
                                row.innerHTML = `
                                <td>${item.product.product_name || '-'}</td>
                                <td class="text-center">${formatNumber(item.investment_amount ?? 0)}</td>
                                <td class="text-center">${formatNumber(item.dividend_amount ?? 0)}</td>
                                <td class="text-end">${formatDate(item.created_at)}</td>
                            `;
                            
                            }
                            else{
                            
                                row.innerHTML = `
                                <td>${item.product.product_name || '-'}</td>
                                <td class="text-center">${formatNumber(item.investment_amount ?? 0)}</td>
                                <td class="text-center">${formatNumber(item.dividend_amount ?? 0)}</td>
                                <td class="text-end">${formatDate(item.created_at)}</td>
                            `;
                            }
                            tbody.appendChild(row);
                        });
                    }
                    $(`#table-${response.type}-wrapper`).addClass('show');
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
    loadData();
</script>
@endsection

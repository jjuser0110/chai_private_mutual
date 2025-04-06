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
                <button id="btn-balance" onclick="loadBalance()" class="nav-link">Balance</button>
            </li>
            <li class="nav-item">
                <button id="btn-credit"  onclick="loadCredit()" class="nav-link">Credit Score</button>
            </li>
        </ul>
    </div>

    <div id="table-balance-wrapper" class="table-wrapper">
        <div class="custom-datatable">
            <div class="flex-grow-1 mb-3">
                <div class="b-overlay-wrap position-relative">
                    <table class="table b-table table-dark mb-0">
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

    <div id="table-credit-wrapper" class="table-wrapper">
        <div class="custom-datatable">
            <div class="flex-grow-1 mb-3">
                <div class="b-overlay-wrap position-relative">
                    <table class="table b-table table-dark mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" width="30%">Score</th>
                                <th scope="col" class="text-center" width="30%">Value</th>
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
    function loadBalance(){
        $('.money-record .nav-link').removeClass('active');
        $('#btn-balance').addClass('active');
        $('.table-wrapper').removeClass('show fade');
        //ajax here
        $('#table-balance-wrapper').addClass('show');
        setTimeout(() => {
            $('#table-balance-wrapper').addClass('fade');
        }, 150);
    }
    
    function loadCredit(){
        $('.money-record .nav-link').removeClass('active');
        $('#btn-credit').addClass('active');
        $('.table-wrapper').removeClass('show fade');
        //ajax here
        $('#table-credit-wrapper').addClass('show');
        setTimeout(() => {
            $('#table-credit-wrapper').addClass('fade');
        }, 150);
    }
    loadBalance();
</script>
@endsection

@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('account') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Join Record</div>
</div>

<div id="page-content" class="history-page">
    <div class="join-record">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <button id="btn-join-running" onclick="loadRunningJoin()" class="nav-link">Running</button>
            </li>
            <li class="nav-item">
                <button id="btn-join-finished"  onclick="loadFinishedJoin()" class="nav-link">Finished</button>
            </li>
        </ul>
    </div>

    <div id="table-running-wrapper" class="table-wrapper">
        <div class="custom-datatable">
            <div class="flex-grow-1 mb-3">
                <div class="b-overlay-wrap position-relative">
                    <table class="table b-table table-dark mb-0">
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

    <div id="table-finished-wrapper" class="table-wrapper">
        <div class="custom-datatable">
            <div class="flex-grow-1 mb-3">
                <div class="b-overlay-wrap position-relative">
                    <table class="table b-table table-dark mb-0">
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

    function loadFinishedJoin(){
        $('.join-record .nav-link').removeClass('active');
        $('#btn-join-finished').addClass('active');
        $('.table-wrapper').removeClass('show fade');
        //ajax here
        $('#table-running-wrapper').addClass('show');
        setTimeout(() => {
            $('#table-running-wrapper').addClass('fade');
        }, 150);
    }
    
    function loadRunningJoin(){
        $('.join-record .nav-link').removeClass('active');
        $('#btn-join-running').addClass('active');
        $('.table-wrapper').removeClass('show fade');
        //ajax here
        $('#table-finished-wrapper').addClass('show');
        setTimeout(() => {
            $('#table-finished-wrapper').addClass('fade');
        }, 150);
    }
    loadRunningJoin();
</script>
@endsection

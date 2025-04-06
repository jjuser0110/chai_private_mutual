@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('account') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Withdraw Record</div>
</div>

<div id="page-content" class="history-page">
    <div id="table-withdraw-wrapper" class="table-wrapper">
        <div class="custom-datatable table-sm">
            <div class="flex-grow-1 mb-3">
                <div class="b-overlay-wrap position-relative">
                    <table class="table b-table table-dark mb-0">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" width="auto">Amount</th>
                                <th scope="col" class="text-center" width="auto">Status</th>
                                <th scope="col" class="text-center" width="auto">Bank Name</th>
                                <th scope="col" class="text-center" width="auto">Card No.</th>
                                <th scope="col" class="text-center" width="auto">Name</th>
                                <th scope="col" class="text-center" width="auto">Created Time</th>
                            </tr>
                        </thead>
                        <tbody class="flex-grow-1">
                            <tr>
                                <td scope="colspan" class="nodata" colspan="9">
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
    function loadWithdraw(){
        $('#table-withdraw-wrapper').removeClass('show fade');
        //ajax here
        $('#table-withdraw-wrapper').addClass('show');
        setTimeout(() => {
            $('#table-withdraw-wrapper').addClass('fade');
        }, 150);
    }
    loadWithdraw();
</script>
@endsection

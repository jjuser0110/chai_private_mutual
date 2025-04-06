@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="loadPage('{{ route('account') }}')"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Booking Record</div>
</div>

<div id="page-content" class="history-page">
    <div id="table-booking-wrapper" class="table-wrapper">
        <div class="custom-datatable table-xs">
            <div class="flex-grow-1 mb-3">
                <div class="b-overlay-wrap position-relative">
                    <table class="table b-table table-dark mb-0">
                        <thead>
                            <tr>
                                <th scope="col" width="auto">Project Name</th>
                                <th scope="col" width="auto">Status</th>
                                <th scope="col" class="text-center" width="auto">Booking Amount</th>
                                <th scope="col" class="text-center" width="auto">Number</th>
                                <th scope="col" class="text-center" width="auto">Final Payment</th>
                                <th scope="col" class="text-center" width="auto">Countdown</th>
                                <th scope="col" class="text-center" width="auto">Time</th>
                                <th scope="col" class="text-center" width="auto">Operation</th>
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
    function loadBooking(){
        $('#table-booking-wrapper').removeClass('show fade');
        //ajax here
        $('#table-booking-wrapper').addClass('show');
        setTimeout(() => {
            $('#table-booking-wrapper').addClass('fade');
        }, 150);
    }
    loadBooking();
</script>
@endsection

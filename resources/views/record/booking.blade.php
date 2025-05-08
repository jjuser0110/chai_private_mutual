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
                            @if(!isset($records))
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
                            @else
                            @foreach($records as $record)
                            <tr>
                                <td>{{ $record->product->product_name ?? '-' }} </td>
                                @if($record->created_at->lt(\Carbon\Carbon::now()->subHours(2)))
                                <td>{{ $record->status ?? '-' }}</td>
                                @else
                                <td>Running</td>
                                @endif
                                <td class="text-center">{{ number_format($record->booking_amount ?? 0,2,'.',',') }}</td>
                                <td class="text-center">{{ $record->number ?? '-' }}</td>
                                <td class="text-center">{{ isset($record->final_payment) ? number_format($record->final_payment,2,'.',',') : '-' }}</td>
                                @if(isset($record->countdown) && ($record->status == "Pending Final Payment" || $record->status == "Running"))
                                <td class="text-center countdown-timer" data-id="{{ $record->id }}" data-target="{{ $record->countdown }}"></td>
                                @else
                                <td class="text-center">-</td>
                                @endif
                                <td class="text-center">{{ $record->created_at->format('y/m/d H:i:s') }}</td>
                                @if($record->status == "Pending Final Payment" && $record->created_at->lt(\Carbon\Carbon::now()->subHours(2)))
                                <td class="text-center"><a href="{{ route('final_payment',['booking'=>$record->id]) }}" style="color:white;text-decoration:none;background:#0072ff;border-radius:50px;padding:3px 6px" >To Pay</a></td>
                                @else
                                <td class="text-center"></td>
                                @endif
                            </tr>
                            @endforeach
                            @endif
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

    document.querySelectorAll('.countdown-timer').forEach(function (el) {
        const targetTime = new Date(el.dataset.target).getTime();

        const timer = setInterval(function () {
            const now = new Date().getTime();
            const distance = targetTime - now;

            if (distance <= 0) {
                clearInterval(timer);
                el.innerText = "0s";
            } else {
                const hours = Math.floor(distance / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                let output = "";

                if (hours > 0) output += `${hours}h`;
                if (minutes > 0 || hours > 0) output += `${minutes}m`; // keep minutes if hours exist
                output += `${seconds}s`;

                el.innerText = output;
            }
        }, 1000);
    });
</script>
@endsection

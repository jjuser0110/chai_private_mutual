
@section('content')
<div id="project-details">
    <div class="product-images">
        <div class="swiper-container swiper hero-swiper" id="single-product-swiper">
            <div class="swiper-wrapper">
                @foreach($project->file_attachments as $image)
                <div class="swiper-slide"><div class="image" style="background-image:url('{{ env('BACKEND_URL') }}/storage/{{ $image->file_path }}')"></div></div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <div class="info">
        <div class="title">{{ $project->product_name ?? 'Name'}}</div>
        <div class="details-info-progress">
            <div class="progress animated-progress custom-progress progress-label bg-primary-subtle">
                <div class="progress-bar" role="progressbar" aria-valuenow="100.00" aria-valuemin="0" aria-valuemax="100" style="width: {{ $project->product_percentage ?? 0 }}%;">
                    <div class="label">{{ $project->product_percentage ?? 0 }}%</div>
                </div>
            </div>
        </div>
        <div class="data">
            <div class="data-item">
                <div class="data-item-title">Project Size</div>
                <div class="data-item-content">{{ $project->product_size ?? '-' }}</div>
            </div>
            <div class="data-item">
                <div class="data-item-title">Earning Yield</div>
                <div class="data-item-content">{{ number_format($project->earning_yield,2,'.',',') }}{{ $project->earning_yield_unit ?? '-' }}</div>
            </div>
            
            <div class="data-item">
                <div class="data-item-title">Project Deadline</div>
                <div class="data-item-content">{{ $project->project_deadline ?? '-' }} {{ $project->project_deadline_unit ?? '-' }}</div>
            </div>
            <!-- @if(strtolower($project->product_type) == 'normal')
            @else
            @php $countdown = $project->created_at->copy()->addHours(2); @endphp
            <div class="data-item">
                <div class="data-item-title">Project Deadline</div>
                <div class="data-item-content countdown-timer" data-id="{{ $project->id }}" data-target="{{ $countdown->format('Y-m-d H:i:s') }}"></div>
            </div>
            @endif -->
        </div>
        <div class="row">
            <div class="label-title">Description</div>
            <div class="label-content">{{ $project->description }} Member</div>
        </div>
        <div class="row">
            <div class="label-title">Investment Amount</div>
            @if($project->product_type == 'normal')
            <div class="label-content">MYR {{ number_format($project->investment_amount,2,'.',',') }}~MYR {{ number_format($project->investment_amount_to,2,'.',',') }}</div>
            @else
            <div class="label-content">MYR {{ number_format($project->investment_amount,2,'.',',') }}</div>
            @endif
        </div>
        <div class="row">
            <div class="label-title">User Level</div>
            <div class="label-content">{{ $project->user_level ?? '-' }}</div>
        </div>
        <div class="rules">
            <div class="rules-title">Project Rules</div>
            <div class="rules-content">
                <span>
                    <!-- <p>Settlement method: Once the project has reached 100% funding, the project will return the capital and credit the profit after end of the project term</p>
                    <p>Starting amount: MYR 250,000</p>
                    <p>Earning rate of return: 17%</p>
                    <p>Project period: 1 Month</p>
                    <p>User level: Diamond member</p>
                    <p>Can I reinvest: No</p> -->
                    {!! $project->project_rules ?? '' !!}
                </span>
            </div>
        </div>
    </div>

    <div class="divider"></div>

    @if($project->product_percentage < 100)
    <form id="form-investment">
        <div class="title">{{ $project->product_type == 'normal' ? 'Join Now' : 'Booking Now' }}</div>
        <div class="custom-form-group custom-form-group-sm">
            <input name="project" value="{{ $project->id }}" type="hidden"/>
            <div class="input-group" role="group">
                @if($project->product_type == 'normal')
                <span class="input-group-text">Investment Amount</span>
                <input class="form-control" type="number" name="amount" placeholder="Min: MYR {{ number_format($project->investment_amount,2,'.',',') }}" >
                @else
                <span class="input-group-text">Booking Amount</span>
                <input  class="form-control" type="text" name="amount" placeholder="MYR" value="MYR {{ number_format($project->investment_amount,2,'.',',') }}" disabled>
                @endif
            </div>
        </div>
        <div class="custom-form-group custom-form-group-sm mb-3">
            <div class="input-group" role="group">
                <span class="input-group-text">Login Password</span>
                <input name="password" class="form-control" type="password" placeholder="Enter Login Password">
            </div>
        </div>
        <button class="btn btn-md btn-primary" type="submit">{{ $project->product_type == 'normal' ? 'Join' : 'Booking Now' }}</button>
    </form>
    @endif
</div>

<script>
    $('#form-investment').off('submit').on('submit', function(e) {
		e.preventDefault();
		showLoading();
		var formData = new FormData(this);
		var btn = $(this).find('button[type="submit"]');
		$(btn).prop("disabled", true);
		$.ajax({
			url: "{{ route('submit_investment') }}",
			method: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			success: function(response) {
				if(response.success == true){
					// infoModal(response.message, "{{ route('join_record') }}")
                    showToast('success','Success', response.message);
                    loadPage(response.link);
				}
				else{
					showToast('error','Failed',response.message)
				}
			},
			error: function() {
				showToast('error','Failed', 'There is something wrong, please try again.')
			},
			complete: function(){
				$(btn).prop("disabled", false);
				hideLoading();
			}
		});
	});

    document.querySelectorAll('.countdown-timer').forEach(function (el) {
		const targetTime = new Date(el.dataset.target).getTime();

		const timer = setInterval(function () {
			const now = new Date().getTime();
			const distance = targetTime - now;

			if (distance <= 0) {
				clearInterval(timer);
				el.innerText = "Ended";
			} else {
				const hours = Math.floor(distance / (1000 * 60 * 60));
				const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
				const seconds = Math.floor((distance % (1000 * 60)) / 1000);

				let output = "";
				
				if (hours > 0) {
					output = `${hours} Hour${hours !== 1 ? 's' : ''}`;
				} else if (minutes > 0) {
					output = `${minutes} Minute${minutes !== 1 ? 's' : ''}`;
				} else {
					output = `${seconds} Second${seconds !== 1 ? 's' : ''}`;
				}

				el.innerText = output;
			}
		}, 1000);
	});
</script>
@endsection
@extends('layouts.app')

@section('content')
<div id="header">
    <div class="title">Join</div>
</div>

<div id="page-content">
    <!-- Slider -->
    <div class="swiper-container swiper hero-swiper" id="join-banner">
        <div class="swiper-wrapper">
            @foreach($slides as $slide)
            <div class="swiper-slide"><div class="image" style="background-image:url('{{ env('BACKEND_URL') }}/storage/{{ $slide->file_path }}')"></div></div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <!-- Projects Category -->
    <div class="project-category-tabs">
        <div class="list-group">
            @foreach($categories as $category)
            <div class="list-group-item" onclick="$('#input-project-category').val({{ $category->id }});$('#modal-project-category #password').val('');openModal('modal-project-category')">
                <div class="icon">
                    <img src="{{ env('BACKEND_URL') }}/storage/{{ $category->icon_path }}" alt="{{ $category->category_name }}">
                </div>
                <div class="label">{{ $category->category_name }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Project list -->
    <div class="project-list-view">
        <div class="list-group">
            @foreach($projects as $project)
            <div class="list-group-item cursor-pointer" onclick="loadPage('{{ route('single_project',['project'=>$project->id]) }}')">
                <div class="project-item d-flex align-items-center">
                    <div class="thumbnail-wrapper">
                        <div class="thumbnail" style="background-image: url('{{ env('BACKEND_URL') }}/storage/{{ $project->thumbnail->file_path ?? '' }}')"></div>
                    </div>
                    <div class="project-info">
                        <div class="project-name">{{ $project->product_name }}</div>
                        <div class="project-details">
                            <div class="category">Belong to: {{ $project->category->category_name }}</div>
                            <div class="user-level">User Level: {{ $project->user_level }}</div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100.00" aria-valuemin="0" aria-valuemax="100" style="width: {{ $project->product_percentage }}%;">
                                    <div class="label">{{ $project->product_percentage }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="project-min-invest">MYR {{ number_format($project->product_price,2,'.',',') }}</div>
                </div>
                <div class="divider"></div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('custom')
<script>
    initializeAllSwipers();
    $('.menu-item').removeClass('active');
    $('#join-icon').addClass('active');

    $('#form-project-category').off('submit').on('submit', function(e) {
		e.preventDefault();
		showLoading();
		var formData = new FormData(this);
		var btn = $(this).find('button[type="submit"]');
		$(btn).prop("disabled", true);
		$.ajax({
			url: "{{ route('submit_project_category') }}",
			method: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			success: function(response) {
				if(response.success == true){
					// $('#page-content').html(response.content);
					// closeAllModal();
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
</script>
@endsection
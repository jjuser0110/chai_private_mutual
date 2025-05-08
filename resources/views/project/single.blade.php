@extends('layouts.app')

@section('content')
<div id="header">
    <div class="btn-back" onclick="history.back()"><i class="ri-arrow-left-line cursor-pointer"></i></div>
    <div class="title">Join</div>
</div>

<div id="page-content">
</div>
@endsection

@section('custom')
<script>
    $('.menu-item').removeClass('active');
    $('#project-id').val({{ $project->id }});

	$('#modal-project-password').off('click').on('click', function (e) {
		if (!$(e.target).closest('.modal-content').length) {
			e.stopPropagation();
		}
	});
	$('#modal-project-password #password').val('');
    openModal('modal-project-password');
    $('#form-project').off('submit').on('submit', function(e) {
		e.preventDefault();
		showLoading();
		var formData = new FormData(this);
		var btn = $(this).find('button[type="submit"]');
		$(btn).prop("disabled", true);
		$.ajax({
			url: "{{ route('submit_project_password') }}",
			method: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			success: function(response) {
				if(response.success == true){
					$('#page-content').html(response.content);
					closeAllModal();
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
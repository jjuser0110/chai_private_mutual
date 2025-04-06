<script>
	function loadPage(path){
		//showLoading();
		closeAllModal();
		$.ajax({
			url: path,
			type: "GET",
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			},
			success: function (response) {
				if(response.success == true){
					if(response.hide_navi){
						$('#navi-menu').css('display','none');
					}
					else{
						$('#navi-menu').css('display','flex');
					}
					$('#content').fadeOut(150, function () {
						$(this).html(response.content).fadeIn(150);
						$('#custom-script').html(response.script ?? '');
					});
					window.history.pushState({}, '', path); 
				}
				else{
					if(response.message == 'login'){
						console.log('login first');
					}
					else{
						alert('response.message');
					}
				}
			},
			error: function () {
				alert("Failed to load "+path+".");
			},
			complete: function(){
				//   hideLoading();
			}
		});
	}

	function openModal(modalId) {
		$('#' + modalId).attr('style','display:block');
		setTimeout(() => { $('#' + modalId).addClass('show') }, 150);
		$('body').addClass('no-scroll');
	}

	function closeModal(modalId) {
		$('#' + modalId).removeClass('show');
		setTimeout(() => { $('#' + modalId).attr('style','display:none')}, 150);

		if ($('.modal:visible').length === 0) {
			$('body').removeClass('no-scroll');
		}
	}

	function closeAllModal() {
		$('.modal').removeClass('show');
		setTimeout(() => { $('.modal').attr('style','display:none') }, 150);

		if ($('.modal:visible').length === 0) {
			$('body').removeClass('no-scroll');
		}
	}

	$(document).on('click', '.modal', function(e) {
		if ($(e.target).is('.modal')) {
			closeModal($(this).attr('id'));
		}
	});

	$(document).on('click', function(e) {
		if (!$(e.target).is('#toast')) {
			hideToast($(this).attr('id'));
		}
	});

	function showToast(type,title,message){
		$('#toast-wrapper').removeClass('show');
		$('#toast-wrapper .toast').removeClass('success info error warning').addClass(type);
		$('#toast-title').html(title);
		$('#toast-message').html(message);
		$('#toast-wrapper').addClass('show');
		setTimeout(() => hideToast(),5000);
	}

	function hideToast(){
		$('#toast-wrapper').removeClass('show');
	}
</script>
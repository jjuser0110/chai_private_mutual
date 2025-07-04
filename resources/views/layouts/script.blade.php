<script>
	function loadPage(path){
		//showLoading();
		closeAllModalInstant();
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
					window.history.pushState({ path: path }, '', path);
				}
				else if(response.required_login == true){
					openModal('modal-login');
				}
				else{
					alert('response.message');
					showToast('error','Failed', response.message);
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

	window.addEventListener('popstate', function(event) {
		if (event.state && event.state.path) {
			loadPage(event.state.path); // Reload the page via AJAX when history changes
		}
	});

	function openModal(modalId) {
		$('#' + modalId).attr('style','display:block');
		setTimeout(() => { $('#' + modalId).addClass('show') }, 150);
		$('body').addClass('no-scroll');
	}

	function closeModal(modalId) {
		$('#' + modalId).removeClass('show');
		setTimeout(() => { $('#' + modalId).attr('style','display:none')}, 150);

		// if ($('.modal:visible').length === 0) {
		// 	$('body').removeClass('no-scroll');
		// }
		$('body').removeClass('no-scroll');
	}

	function infoModal(message, url) {
		$('#modal-info-content').text(message);
		openModal('modal-info');

		function handleClose() {
			closeModal('modal-info');
			if(url != false){
				window.location.href = url;
			}
			$('#btn-modal-info').off('click', handleClose);
			$('#modal-info').off('click', outsideClick);
		}

		function outsideClick(e) {
			if (e.target.id === 'modal-info') {
				handleClose();
			}
		}
		$('#btn-modal-info').on('click', handleClose);
		$('#modal-info').on('click', outsideClick);
	}

	function confirmationModal(message, onConfirm) {
		$('#modal-confirmation-content').text(message);
		openModal('modal-confirmation');

		function handleConfirm() {
			closeModal('modal-confirmation');

			if (typeof onConfirm === 'function') {
				onConfirm();
			}

			$('#btn-modal-confirmation').off('click', handleConfirm);
		}

		$('#btn-modal-confirmation').on('click', handleConfirm);
	}

	function closeAllModal() {
		$('.modal').removeClass('show');
		setTimeout(() => { $('.modal').attr('style','display:none') }, 150);

		// if ($('.modal:visible').length === 0) {
		// 	$('body').removeClass('no-scroll');
		// }
		$('body').removeClass('no-scroll');
	}

	function closeAllModalInstant() {
		$('.modal').removeClass('show');
		$('.modal').attr('style','display:none');
		// if ($('.modal:visible').length === 0) {
		// 	$('body').removeClass('no-scroll');
		// }
		$('body').removeClass('no-scroll');
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

	function showLoading(){
		//
	}

	function hideLoading(){
		//
	}

	function formatNumber(x) {
		return parseFloat(x).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
	}

	function formatDate(dateString){
        const date = new Date(dateString);
        // Get the date in 'YYYY-MM-DD HH:mm' format
        return date.getFullYear() + '-' +
           ('0' + (date.getMonth() + 1)).slice(-2) + '-' +
           ('0' + date.getDate()).slice(-2) + ' ' +
           ('0' + date.getHours()).slice(-2) + ':' +
           ('0' + date.getMinutes()).slice(-2);
    }
	
	function livechat(){
        LiveChatWidget.call('maximize');
        return false;
    }
</script>
<script>
    window.__lc = window.__lc || {};
    window.__lc.license = 19222995;
    window.__lc.integration_name = "manual_onboarding";
    window.__lc.product_name = "livechat";
    ;(function(n,t,c){function i(n){return e._h?e._h.apply(null,n):e._q.push(n)}var e={_q:[],_h:null,_v:"2.0",on:function(){i(["on",c.call(arguments)])},once:function(){i(["once",c.call(arguments)])},off:function(){i(["off",c.call(arguments)])},get:function(){if(!e._h)throw new Error("[LiveChatWidget] You can't use getters before load.");return i(["get",c.call(arguments)])},call:function(){i(["call",c.call(arguments)])},init:function(){var n=t.createElement("script");n.async=!0,n.type="text/javascript",n.src="https://cdn.livechatinc.com/tracking.js",t.head.appendChild(n)}};!n.__lc.asyncInit&&e.init(),n.LiveChatWidget=n.LiveChatWidget||e}(window,document,[].slice))
</script>

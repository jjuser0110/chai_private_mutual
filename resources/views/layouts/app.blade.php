<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		@if(!env('APP_LOCAL', false))
		<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" /> -->
		@endif
		@include('layouts.css')
		<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
		<link rel="stylesheet" href="{{ asset('css/swiper.css') }}"/>
		<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
		@yield('header_css')
		@yield('header_js')
		<title>Private Mutual HLG</title>
	</head>
	<body>
		<div id="toast-wrapper">
			<div class="toast">
				<i class="ri-error-warning-fill"></i>
				<div class="toast-body">
					<div class="toastification" toast-id="1">
						<h6 id="toast-title"></h6>
						<small id="toast-message"></small>
					</div>
				</div>
				<div class="Vue-Toastification__progress-bar" style="animation-duration: 3000ms; animation-play-state: paused; opacity: 0;"></div>
			</div>
		</div>
		@include('layouts.script')
		<div id="main-wrapper">
			<!-- CONTENT -->
			<div id="content">
				@yield('content')
			</div>
		</div>
		@yield('extra')
		<div id="modal-login" class="modal cus-modal fade">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Tip</h5>
					</div>
					<div class="modal-body">Please login first</div>
					<div class="modal-footer">
						<button class="btn btn-md btn-secondary" type="button" onclick="closeModal('modal-login')">Cancel</button>
						<button class="btn btn-md btn-primary" type="button" onclick="loadPage('{{ route('login') }}')">Go to Login</button>
					</div>
				</div>
			</div>
		</div>

		<div id="modal-contact" class="modal cus-modal fade">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Tip</h5>
					</div>
					<div class="modal-body">Please contact customer service</div>
					<div class="modal-footer">
						<button class="btn btn-md btn-primary w-100" type="button" onclick="closeModal('modal-contact')">Close</button>
					</div>
				</div>
			</div>
		</div>
	
		<div id="footer">
			@include('layouts.navimenu')
		</div>
		<div id="custom-script">
			@yield('custom')
		</div>
</html>

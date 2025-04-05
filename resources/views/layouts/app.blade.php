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
        @include('layouts.script')
		
		<div id="main-wrapper">
			<!-- CONTENT -->
			<div id="content">
				@yield('content')
			</div>
		</div>
		@yield('extra')

		<!-- FOOTER -->
	
    @yield('custom')
</html>

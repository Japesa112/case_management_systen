<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<!-- Chart.js -->
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
		<!-- Chart.js Zoom Plugin -->
		<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@2.0.1"></script>
		<!-- Moment.js -->
		<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

		<script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>

<!-- Include the customParseFormat plugin -->
		<script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/customParseFormat.js"></script>
		<!-- jQuery (for AJAX and DOM) -->

     <link href="../images/kufavicon.ico" rel=" icon">

	{{-- In the <head> section --}}
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
	<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery (Required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Tom Select CSS -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

<!-- Tom Select JS -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

		<style>
		    @media (max-width: 768px) {
		        .app-content {
		            padding: 10px;
		        }

		        .mobile-message {
		            font-size: 0.95rem;
		        }

		    }
		</style>

	@include('includes.head')
	@if (!empty($showVideo) && $showVideo)
		
		
	
	@else
		@stack('styles')
	@endif
</head>
@php
	$bodyClass = (!empty($appBoxedLayout)) ? 'boxed-layout ' : '';
	$bodyClass .= (!empty($paceTop)) ? 'pace-top ' : $bodyClass;
	$bodyClass .= (!empty($bodyClass)) ? $bodyClass . ' ' : $bodyClass;
	$appSidebarHide = (!empty($appSidebarHide)) ? $appSidebarHide : '';
	$appHeaderHide = (!empty($appHeaderHide)) ? $appHeaderHide : '';
	$appSidebarTwo = (!empty($appSidebarTwo)) ? $appSidebarTwo : '';
	$appSidebarSearch = (!empty($appSidebarSearch)) ? $appSidebarSearch : '';
	$appTopMenu = (!empty($appTopMenu)) ? $appTopMenu : '';
	
	$appClass = (!empty($appTopMenu)) ? 'app-with-top-menu ' : '';
	$appClass .= (!empty($appHeaderHide)) ? 'app-without-header ' : ' app-header-fixed ';
	$appClass .= (!empty($appSidebarEnd)) ? 'app-with-end-sidebar ' : '';
	$appClass .= (!empty($appSidebarWide)) ? 'app-with-wide-sidebar ' : '';
	$appClass .= (!empty($appSidebarHide)) ? 'app-without-sidebar ' : '';
	$appClass .= (!empty($appSidebarMinified)) ? 'app-sidebar-minified ' : '';
	$appClass .= (!empty($appSidebarTwo)) ? 'app-with-two-sidebar app-sidebar-end-toggled ' : '';
	$appClass .= (!empty($appSidebarHover)) ? 'app-with-hover-sidebar ' : '';
	$appClass .= (!empty($appContentFullHeight)) ? 'app-content-full-height ' : '';
	
	$appContentClass = (!empty($appContentClass)) ? $appContentClass : '';
	
	$isLawyer = Auth::user() && Auth::user()->role === 'Lawyer';  // Replace with your actual role check

@endphp



<body class="{{ $bodyClass }}">
	
		<!-- ✅ Show Background Video Only When Needed -->
	


	@include('includes.component.page-loader')
	
	<div id="app" class="app app-sidebar-fixed {{ $appClass }}">
		
		@includeWhen(!$appHeaderHide, 'includes.header')

		@includeWhen($appTopMenu, 'includes.top-menu')

		<!-- Check if the user is a lawyer, then show the lawyer sidebar -->
		@if($isLawyer)
			@include('includes.sidebar-lawyer') <!-- Include the lawyer sidebar -->
		@elseif(!$appSidebarHide)
			@include('includes.sidebar') <!-- Default sidebar for non-lawyers -->
		@endif
		
		@includeWhen($appSidebarTwo, 'includes.sidebar-right')
		
		<div id="content" class="app-content {{ $appContentClass }}">
			<div class="mobile-message d-md-none d-block alert alert-info text-center p-2">
		        Welcome to Kenyatta University Case System. Swipe right to open the menu.
		    </div>
			@yield('content')
		</div>
		
		@include('includes.component.scroll-top-btn')
		
		
		
	</div>
	
	@yield('outside-content')
	
	@include('includes.page-js')

	<!-- ✅ Ensure the video plays properly -->
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			const video = document.querySelector(".login-cover video");
			if (video) {
				video.play().catch(error => console.error("Video autoplay failed:", error));
			}
		});
	</script>





</body>
</html>

@extends('layouts.default', [
	'paceTop' => true,
	'videoBackground' => true,
	'appSidebarHide' => true,
	'appHeaderHide' => true,
	'appContentClass' => 'p-0',
	'showVideo' => true 
])

@section('title', 'Login Page')
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const video = document.querySelector(".video-container video");
        if (video) {
            video.play().catch(error => console.error("Video autoplay failed:", error));
        }
    });
</script>
@endpush
@push('styles')
<style>
    /* Ensure the body covers the entire screen */
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        width: 100%;
        overflow: hidden;
    }

    /* Background Video Container */
    .video-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        overflow: hidden;
        z-index: -1;
    }

    /* Ensure the video fully covers the background */
    .video-container video {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100vw;
        height: 100vh;
        object-fit: cover;
        transform: translate(-50%, -50%);
    }

    /* Dark Overlay Effect */
    .video-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(0, 0, 66, 0.5), #000042);
    }

    /* Ensure Login Form is Centered */
    .login-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 10;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        padding: 20px;
        border-radius: 10px;
    }
</style>
@endpush




@section('content')
	<!-- BEGIN login -->
	<div class="login login-v2 fw-bold">
		<!-- BEGIN login-cover -->
		<div class="login-cover">
			<div class="login-cover-img" style="background-image: url(/assets/img/login-bg/login-bg-17.jpg)" data-id="login-cover-image"></div>
			<div class="login-cover-bg"></div>
		</div>
		<!-- END login-cover -->
		
		<!-- BEGIN login-container -->
		<div class="login-container">
			<!-- BEGIN login-header -->
			<div class="login-header">
				<div class="brand">
					<div class="d-flex align-items-center">
						<span class="logo"></span> <b>Color</b> Admin
					</div>
					<small>Bootstrap 5 Responsive Admin Template</small>
				</div>
				<div class="icon">
					<i class="fa fa-lock"></i>
				</div>
			</div>
			<!-- END login-header -->
			
			<!-- BEGIN login-content -->
			<div class="login-content">
				@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<form action="{{ route('login.post') }}" method="post">
					@csrf
					@method('post')
					<div class="form-floating mb-20px">
						<input type="text" name="email" id="email" class="form-control fs-13px h-45px border-0" placeholder="Email Address" id="emailAddress" />
						<label for="emailAddress" class="d-flex align-items-center text-gray-600 fs-13px">Email Address</label>
					</div>
					<div class="form-floating mb-20px">
						<input type="password" name="password_hash" class="form-control fs-13px h-45px border-0" placeholder="Password" id="password" />
						<label for="emailAddress" class="d-flex align-items-center text-gray-600 fs-13px">Password</label>
					</div>
					<div class="form-check mb-20px">
						<input class="form-check-input border-0" type="checkbox" value="1" id="rememberMe" />
						<label class="form-check-label fs-13px text-gray-500" for="rememberMe">
							Remember Me. 
						</label>
					</div>
					<div class="mb-20px">
						<button type="submit" class="btn btn-theme d-block w-100 h-45px btn-lg"  id="signupButton" disabled>Sign me in</button>
					</div>
					<div class="text-gray-500">
						Not a member yet? Click <a href="{{ route('register-v3') }}" class="text-white">here</a> to register.
					</div>
				</form>
			</div>
			<!-- END login-content -->
		</div>
		<!-- END login-container -->
	</div>
	<!-- END login -->
	
	<!-- BEGIN login-bg -->
	<div class="login-bg-list clearfix">
		<div class="login-bg-list-item active"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg" data-img="/assets/img/login-bg/login-bg-17.jpg" style="background-image: url(/assets/img/login-bg/login-bg-17.jpg)"></a></div>
		<div class="login-bg-list-item"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg" data-img="/assets/img/login-bg/login-bg-16.jpg" style="background-image: url(/assets/img/login-bg/login-bg-16.jpg)"></a></div>
		<div class="login-bg-list-item"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg" data-img="/assets/img/login-bg/login-bg-15.jpg" style="background-image: url(/assets/img/login-bg/login-bg-15.jpg)"></a></div>
		<div class="login-bg-list-item"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg" data-img="/assets/img/login-bg/login-bg-14.jpg" style="background-image: url(/assets/img/login-bg/login-bg-14.jpg)"></a></div>
		<div class="login-bg-list-item"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg" data-img="/assets/img/login-bg/login-bg-13.jpg" style="background-image: url(/assets/img/login-bg/login-bg-13.jpg)"></a></div>
		<div class="login-bg-list-item"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg" data-img="/assets/img/login-bg/login-bg-12.jpg" style="background-image: url(/assets/img/login-bg/login-bg-12.jpg)"></a></div>
	</div>
	<!-- END login-bg -->
@endsection

@push('scripts')
	<script src="/assets/js/demo/login-v2.demo.js"></script>
	<script>
		document.addEventListener("DOMContentLoaded", function () {
			let email = document.getElementById("email");
			let password = document.getElementById("password");
			let signupButton = document.getElementById("signupButton");
	
			function toggleButton() {
				if (email.value.trim() !== "" && password.value.trim() !== "") {
					signupButton.removeAttribute("disabled");
				} else {
					signupButton.setAttribute("disabled", "true");
				}
			}
	
			email.addEventListener("input", toggleButton);
			password.addEventListener("input", toggleButton);
		});
	</script>
@endpush

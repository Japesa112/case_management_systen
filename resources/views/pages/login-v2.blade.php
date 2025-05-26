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
        background: linear-gradient(to bottom, rgba(66, 30, 0, 0.5), #000042);
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

    .or-divider {
    display: flex;
    align-items: center;
    text-align: center;
    margin: 20px 0;
}

.or-divider::before,
.or-divider::after {
    content: '';
    flex: 1;
    border-top: 1px solid #ccc;
}

.or-divider span {
    margin: 0 10px;
    color: #666;
    font-weight: 500;
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
						<span class="">
							<img src="https://rms.ku.ac.ke/RMS-old/IMS/assets/img/logo/Ku_Logo.png" class="img img-fluid w-100" alt="">
						</span> <b>Kenyatta </b>  &nbsp; <b> University </b> 
					</div>
					<h5>Case Management System - Login</h5>
				</div>
				<div class="icon">
					<i class="fa fa-lock"></i>
				</div>
			</div>
			<!-- END login-header -->
			
			<!-- BEGIN login-content -->
			<div class="login-content">
				@if ($errors->has('google'))
				<script>
				    document.addEventListener('DOMContentLoaded', function () {
				        Swal.fire({
				            icon: 'error',
				            title: 'Login Failed',
				            text: '{{ $errors->first('google') }}',
				            confirmButtonText: 'OK'
				        });
				    });
				</script>
				@endif

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
					<div class="mb-3">
					    <button type="submit" class="btn btn-theme w-100 btn-lg" id="signupButton" disabled>
					        Sign Me In
					    </button>
					</div>

										<div class="d-flex align-items-center my-4">
					    <hr class="flex-grow-1 border-top border-secondary-subtle">
					    <span class="mx-3 text-muted fw-bold">OR</span>
					    <hr class="flex-grow-1 border-top border-secondary-subtle">
					</div>

					<div class="mb-3">
					    <a href="{{ route('login.google') }}" class="btn btn-danger w-100 btn-lg d-flex align-items-center justify-content-center gap-2">
					        <i class="fab fa-google"></i> Continue with Google
					    </a>
					</div>

				</form>
			</div>
			<!-- END login-content -->
		</div>
		<!-- END login-container -->
	</div>
	<!-- END login -->
	<div class="login-bg">
		<video id="login-video-bg" autoplay muted loop playsinline style="display: none;">
		  <source src="http://127.0.0.1:8000/videos/cout_4.mp4" type="video/mp4">
		</video>
	  </div>
	<!-- BEGIN login-bg -->
	<div class="login-bg-list clearfix">
		<div class="login-bg-list-item active"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg" data-img="https://rms.ku.ac.ke/RMS-old/IMS/assets/img/login/GATE.JPG" style="background-image: url(https://rms.ku.ac.ke/RMS-old/IMS/assets/img/login/GATE.JPG)"></a></div>
		<div class="login-bg-list-item"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg" data-img="https://rms.ku.ac.ke/RMS-old/IMS/assets/img/login/Cac2.JPG" style="background-image: url(https://rms.ku.ac.ke/RMS-old/IMS/assets/img/login/Cac2.JPG)"></a></div>
		<div class="login-bg-list-item"><a href="javascript:;" class="login-bg-list-link" data-toggle="login-change-bg" data-img="https://rms.ku.ac.ke/RMS-old/IMS/assets/img/login/Library.JPG" style="background-image: url(https://rms.ku.ac.ke/RMS-old/IMS/assets/img/login/Library.JPG)"></a></div>
		
		
		<div class="login-bg-list-item">
			<a href="javascript:;" 
			   class="login-bg-list-link" 
			   data-toggle="login-change-bg" 
			 	style="background-image: url(../images/judiciary.png)"
			   data-type="video" 
			   data-video="http://127.0.0.1:8000/videos/first_court.mp4">
			  
			</a>
		</div>
		<div class="login-bg-list-item">
			<a href="javascript:;" 
			   class="login-bg-list-link" 
			   data-toggle="login-change-bg" 
			 	style="background-image: url(../images/court_first.jpg)"
			   data-type="video" 
			   data-video="http://127.0.0.1:8000/videos/54904-483011865_tiny.mp4">
			  
			</a>
		</div>
		<div class="login-bg-list-item">
			<a href="javascript:;" 
			   class="login-bg-list-link" 
			   data-toggle="login-change-bg" 
			  style="background-image: url(../images/second_court.jpg)"
			   data-type="video" 
			   data-video="http://127.0.0.1:8000/videos/cout_4.mp4">
			  
			</a>
		  </div>

		  
		
	
	</div>
	<!-- END login-bg -->
@endsection

@push('scripts')


<script>
	document.addEventListener('DOMContentLoaded', function() {
	  const links = document.querySelectorAll('[data-toggle="login-change-bg"]');
	
	  links.forEach(link => {
		link.addEventListener('click', function() {
		  const type = this.getAttribute('data-type');
		
		  if (type === 'video') {
			const videoUrl = this.getAttribute('data-video');

		
			
			// Show video background
			let video = document.getElementById('login-video-bg');
			console.log(video); 

			if (video) {
				
			  video = document.createElement('video');
			  video.id = 'login-video-bg';
			  video.autoplay = true;
			  video.muted = true;
			  video.loop = true;
			  video.playsInline = true;
			  video.style.position = 'fixed';
			  video.style.right = 0;
			  video.style.bottom = 0;
			  video.style.minWidth = '100%';
			  video.style.minHeight = '100%';
			  video.style.zIndex = '-1';
			  video.style.objectFit = 'cover';
			  document.body.appendChild(video);
			}

			
			video.src = videoUrl;
			video.style.display = 'block';
	
			// Hide image background if necessary
			document.body.style.backgroundImage = 'none';
		  } else {
			
			// Normal image background (system default)
			let video = document.getElementById('login-video-bg');
			if (video) {
			  video.style.display = 'none';
			  video.pause();
			}
		  }
		});
	  });
	});
	</script>
	
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

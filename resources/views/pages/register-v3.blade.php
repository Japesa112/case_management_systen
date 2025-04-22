@extends('layouts.default', [
	'paceTop' => true, 
	'appSidebarHide' => true, 
	'appHeaderHide' => true, 
	'appContentClass' => 'p-0'
])

@section('title', 'Register Page')

@section('content')
	<!-- BEGIN register -->
	<div class="register register-with-news-feed">
		<!-- BEGIN news-feed -->
		<div class="news-feed">
			<div class="news-image" style="background-image: url(/assets/img/login-bg/login-bg-15.jpg)"></div>
			<div class="news-caption">
				<h4 class="caption-title"><b>Color</b> Admin App</h4>
				<p>
					Manage your organization’s account easily.
				</p>
			</div>
		</div>
		<!-- END news-feed -->
		
		<!-- BEGIN register-container -->
		<div class="register-container">
			<div class="register-header mb-25px h1">
				<div class="mb-1">Sign Up</div>
				<small class="d-block fs-15px lh-16">Create your account.</small>
			</div>
			
			<!-- BEGIN register-content -->
			<div class="register-content">
				@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<form action="{{ route('register') }}" method="post" class="fs-13px">
					@csrf
					@method("post")

					<!-- First & Last Name -->
					<div class="mb-3">
						<label class="mb-2">Name <span class="text-danger">*</span></label>
						<div class="row gx-3">
							<div class="col-md-6 mb-2 mb-md-0">
								<input type="text" class="form-control fs-13px" name="first" placeholder="First name" required/>
							</div>
							<div class="col-md-6">
								<input type="text" class="form-control fs-13px" name="last" placeholder="Last name" required/>
							</div>
						</div>
					</div>

					<!-- Email & Confirmation -->
					<div class="mb-3">
						<label class="mb-2">Email <span class="text-danger">*</span></label>
						<input type="email" class="form-control fs-13px" name="email" placeholder="Email address" required/>
					</div>
					<div class="mb-3">
						<label class="mb-2">Re-enter Email <span class="text-danger">*</span></label>
						<input type="email" class="form-control fs-13px" name="email_confirmation" placeholder="Re-enter email address" required/>
					</div>

					<!-- Phone -->
					<div class="mb-3">
						<label class="mb-2">Phone Number</label>
						<input type="text" class="form-control fs-13px" name="phone" placeholder="Optional"/>
					</div>

					<!-- Role Selection -->
					<div class="mb-3">
						<label class="mb-2">Role <span class="text-danger">*</span></label>
						<select name="role" class="form-control fs-13px" required>
							<option value="">-- Select Role --</option>
							<option value="Lawyer">Lawyer</option>
							<option value="Admin">Admin</option>
							<option value="Case Manager">Case Manager</option>
							<option value="Evaluator">Evaluator</option>
							<option value="DVC">DVC</option>
							<option value="Other">Other</option>
						</select>
					</div>

					<!-- Password & Confirmation -->
					<div class="row gx-3">
						<div class="col-md-6 mb-2 mb-md-0">
							<label class="mb-2">Password <span class="text-danger">*</span></label>
							<input type="password" class="form-control fs-13px" name="password" placeholder="Password" required/>
						</div>
						<div class="col-md-6">
							<label class="mb-2">Confirm Password <span class="text-danger">*</span></label>
							<input type="password" name="password_confirmation" class="form-control fs-13px" placeholder="Confirm Password" required/>
						</div>
					</div>

					<!-- Terms Agreement -->
					<div class="form-check mb-4">
						<input class="form-check-input" type="checkbox" required/>
						<label class="form-check-label">
							By clicking Sign Up, you agree to our <a href="#">Terms</a> and <a href="#">Data Policy</a>.
						</label>
					</div>

					<!-- Submit Button -->
					<div class="mb-4">
						<button type="submit" class="btn btn-theme d-block w-100 btn-lg h-45px fs-13px">Sign Up</button>
					</div>

					<!-- Login Redirect -->
					<div class="mb-4 pb-5">
						Already a member? Click <a href="/login/v2">here</a> to login.
					</div>

					<hr class="bg-gray-600 opacity-2" />
				</form>
			</div>
		</div>
	</div>
@endsection

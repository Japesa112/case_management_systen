@extends('layouts.default', [])

@section('title', 'Settings Page')

@push('scripts')
	<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
	<script src="/assets/js/demo/sidebar-scrollspy.demo.js"></script>
@endpush

@section('content')
	<!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
		<li class="breadcrumb-item"><a href="javascript:;">Extra</a></li>
		<li class="breadcrumb-item active">Settings Page</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Settings Page <small>header small text goes here...</small></h1>
	<!-- END page-header -->
	<hr class="mb-4" />
	<!-- BEGIN row -->

	<div class="row">
		<!-- BEGIN col-3 -->
		<div style="width: 230px">
			<!-- BEGIN #sidebar-bootstrap -->
			<nav class="navbar navbar-sticky d-none d-xl-block my-n4 py-4 h-100 text-end">
				<nav class="nav" id="bsSpyTarget">
					<a class="nav-link active" href="#general" data-toggle="scroll-to">General</a>
					<a class="nav-link" href="#notifications" data-toggle="scroll-to">Notifications</a>
					<a class="nav-link" href="#privacyAndSecurity" data-toggle="scroll-to">Privacy and security</a>
					<a class="nav-link" href="#payment" data-toggle="scroll-to">Payment</a>
					<a class="nav-link" href="#shipping" data-toggle="scroll-to">Shipping</a>
					<a class="nav-link" href="#mediaAndFiles" data-toggle="scroll-to">Media and Files</a>
					<a class="nav-link" href="#languages" data-toggle="scroll-to">Languages</a>
					<a class="nav-link" href="#system" data-toggle="scroll-to">System</a>
					<a class="nav-link" href="#resetSettings" data-toggle="scroll-to">Reset settings</a>
				</nav>
			</nav>
			<!-- END #sidebar-bootstrap -->
		</div>
		<!-- END col-3 -->
		<!-- BEGIN col-9 -->
		<div class="col-xl-8" id="bsSpyContent">
			<!-- BEGIN #general -->
			<div id="general" class="mb-4 pb-3">
				<h4 class="d-flex align-items-center mb-2">
					<iconify-icon class="fs-24px me-2 text-body text-opacity-75 my-n1" icon="solar:user-bold-duotone"></iconify-icon> General
				</h4>
				<p>View and update your general account information and settings.</p>
				<div class="card">
					<div class="list-group list-group-flush fw-bold">
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Name</div>
								<div class="text-body text-opacity-60">Sean Ngu</div>
							</div>
							<div class="w-100px">
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Edit</a>
							</div>
						</div>
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Username</div>
								<div class="text-body text-opacity-60">@seantheme</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Edit</a>
							</div>
						</div>
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Phone</div>
								<div class="text-body text-opacity-60">+1-202-555-0183</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Edit</a>
							</div>
						</div>
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Email address</div>
								<div class="text-body text-opacity-60">support@seantheme.com</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary disabled w-100px">Edit</a>
							</div>
						</div>
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Password</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Edit</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END #general -->
	
			<!-- BEGIN #notifications -->
			<div id="notifications" class="mb-4 pb-3">
				<h4 class="d-flex align-items-center mb-2 mt-3">
					<iconify-icon class="fs-24px me-2 text-body text-opacity-75 my-n1" icon="solar:bell-bold-duotone"></iconify-icon> 
					Notifications
				</h4>
				<p>Enable or disable what notifications you want to receive.</p>
				<div class="card">
					<div class="list-group list-group-flush fw-bold">
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Comments</div>
								<div class="text-body text-opacity-60 d-flex align-items-center">
									<i class="fa fa-circle fs-6px mt-1px fa-fw text-success me-2"></i> Enabled (Push, SMS)
								</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Edit</a>
							</div>
						</div>
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Tags</div>
								<div class="text-body text-opacity-60 d-flex align-items-center">
									<i class="fa fa-circle fs-6px mt-1px fa-fw text-body text-opacity-25 me-2"></i> Disabled
								</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Edit</a>
							</div>
						</div>
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Reminders</div>
								<div class="text-body text-opacity-60 d-flex align-items-center">
									<i class="fa fa-circle fs-6px mt-1px fa-fw text-success me-2"></i> Enabled (Push, Email, SMS)
								</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Edit</a>
							</div>
						</div>
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>New orders</div>
								<div class="text-body text-opacity-60 d-flex align-items-center">
									<i class="fa fa-circle fs-6px mt-1px fa-fw text-success me-2"></i> Enabled (Push, Email, SMS)
								</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Edit</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END #notifications -->
	
			<!-- BEGIN #privacyAndSecurity -->
			<div id="privacyAndSecurity" class="mb-4 pb-3">
				<h4 class="d-flex align-items-center mb-2 mt-3">
					<iconify-icon class="fs-24px me-2 text-body text-opacity-75 my-n1" icon="solar:lock-password-bold-duotone"></iconify-icon> 
					Privacy and security
				</h4>
				<p>Limit the account visibility and the security settings for your website.</p>
				<div class="card">
					<div class="list-group list-group-flush fw-bold">
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Who can see your future posts?</div>
								<div class="text-body text-opacity-60 d-flex align-items-center">
									Friends only
								</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Edit</a>
							</div>
						</div>
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Photo tagging</div>
								<div class="text-body text-opacity-60 d-flex align-items-center">
									<i class="fa fa-circle fs-6px mt-1px fa-fw text-success me-2"></i> Enabled
								</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Edit</a>
							</div>
						</div>
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Location information</div>
								<div class="text-body text-opacity-60 d-flex align-items-center">
									<i class="fa fa-circle fs-6px mt-1px fa-fw text-body text-opacity-25 me-2"></i> Disabled
								</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Edit</a>
							</div>
						</div>
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Firewall</div>
								<div class="text-body text-opacity-60 d-block d-xl-flex align-items-center">
									<div class="d-flex align-items-center"><i class="fa fa-circle fs-6px mt-1px fa-fw text-body text-opacity-25 me-2"></i> Disabled</div>
									<span class="bg-warning bg-opacity-10 text-warning ms-xl-3 mt-1 d-inline-block mt-xl-0 px-1 rounded-sm">
										<i class="fa fa-exclamation-circle text-warning fs-12px me-1"></i> 
										<span class="text-warning">Please enable the firewall for your website</span>
									</span>
								</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Edit</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END #privacyAndSecurity -->
	
			<!-- BEGIN #payment -->
			<div id="payment" class="mb-4 pb-3">
				<h4 class="d-flex align-items-center mb-2 mt-3">
					<iconify-icon class="fs-24px me-2 text-body text-opacity-75 my-n1" icon="solar:bag-4-bold-duotone"></iconify-icon> 
					Payment
				</h4>
				<p>Manage your website payment provider</p>
				<div class="card">
					<div class="list-group list-group-flush fw-bold">
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Allowed payment method</div>
								<div class="text-body text-opacity-60">
									Paypal, Credit Card, Apple Pay, Amazon Pay, Google Wallet, Alipay, Wechatpay
								</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Edit</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END #payment -->
	
			<!-- BEGIN #shipping -->
			<div id="shipping" class="mb-4 pb-3">
				<h4 class="d-flex align-items-center mb-2 mt-3">
					<iconify-icon class="fs-24px me-2 text-body text-opacity-75 my-n1" icon="solar:box-bold-duotone"></iconify-icon> 
					Shipping
				</h4>
				<p>Allowed shipping area and zone setting</p>
				<div class="card">
					<div class="list-group list-group-flush fw-bold">
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Allowed shipping method</div>
								<div class="text-body text-opacity-60">
									Local, Domestic
								</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Edit</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END #shipping -->
	
			<!-- BEGIN #mediaAndFiles -->
			<div id="mediaAndFiles" class="mb-4 pb-3">
				<h4 class="d-flex align-items-center mb-2 mt-3">
					<iconify-icon class="fs-24px me-2 text-body text-opacity-75 my-n1" icon="solar:camera-bold-duotone"></iconify-icon> 
					Media and Files
				</h4>
				<p>Allowed files and media format upload setting</p>
				<div class="card">
					<div class="list-group list-group-flush fw-bold">
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Allowed files and media format</div>
								<div class="text-body text-opacity-60">
									.png, .jpg, .gif, .mp4
								</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Edit</a>
							</div>
						</div>
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Media and files cdn</div>
								<div class="text-body text-opacity-60 d-flex align-items-center">
									<i class="fa fa-circle fs-6px mt-1px fa-fw text-body text-opacity-25 me-2"></i> Disabled
								</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Edit</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END #mediaAndFiles -->
	
			<!-- BEGIN #languages -->
			<div id="languages" class="mb-4 pb-3">
				<h4 class="d-flex align-items-center mb-2 mt-3">
					<iconify-icon class="fs-24px me-2 text-body text-opacity-75 my-n1" icon="solar:globus-bold-duotone"></iconify-icon> 
					Languages
				</h4>
				<p>Language font support and auto translation enabled</p>
				<div class="card">
					<div class="list-group list-group-flush fw-bold">
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Language enabled</div>
								<div class="text-body text-opacity-60">
									English (default), Chinese, France, Portuguese, Japense
								</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Edit</a>
							</div>
						</div>
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Auto translation</div>
								<div class="text-body text-opacity-60 d-flex align-items-center">
									<i class="fa fa-circle fs-6px mt-1px fa-fw text-success me-2"></i> Enabled
								</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Edit</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END #languages -->
	
			<!-- BEGIN #system -->
			<div id="system" class="mb-4 pb-3">
				<h4 class="d-flex align-items-center mb-2 mt-3">
					<iconify-icon class="fs-24px me-2 text-body text-opacity-75 my-n1" icon="solar:ssd-round-bold-duotone"></iconify-icon> 
					System
				</h4>
				<p>System storage, bandwidth and database setting</p>
				<div class="card">
					<div class="list-group list-group-flush fw-bold">
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Web storage</div>
								<div class="text-body text-opacity-60">
									40.8gb / 100gb
								</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px">Manage</a>
							</div>
						</div>
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Monthly bandwidth</div>
								<div class="text-body text-opacity-60">
									Unlimited
								</div>
							</div>
						</div>
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Database</div>
								<div class="text-body text-opacity-60">
									MySQL version 8.0.19
								</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-secondary w-100px disabled">Update</a>
							</div>
						</div>
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Platform</div>
								<div class="text-body text-opacity-60">
									PHP 7.4.4, NGINX 1.17.0
								</div>
							</div>
							<div>
								<a href="#modalEdit" data-bs-toggle="modal" class="btn btn-success w-100px">Update</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END #system -->
	
			<!-- BEGIN #resetSettings -->
			<div id="resetSettings" class="mb-4 pb-3">
				<h4 class="d-flex align-items-center mb-2 mt-3">
					<iconify-icon class="fs-24px me-2 text-body text-opacity-75 my-n1" icon="solar:restart-bold-duotone"></iconify-icon> 
					Reset settings
				</h4>
				<p>Reset all website setting to factory default setting.</p>
				<div class="card">
					<div class="list-group list-group-flush fw-bold">
						<div class="list-group-item d-flex align-items-center">
							<div class="flex-fill">
								<div>Reset Settings</div>
								<div class="text-body text-opacity-60">
									This action will clear and reset all the current website setting.
								</div>
							</div>
							<div>
								<a href="#" class="btn btn-secondary w-100px">Reset</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END #resetSettings -->
		</div>
		<!-- END col-9-->
	</div>
	<!-- END row -->

	<div class="modal fade" id="modalEdit">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit name</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<div class="modal-body">
					<div class="mb-3">
						<label class="form-label">Name</label>
						<div class="row">
							<div class="col-4">
								<input class="form-control" placeholder="First" value="Sean">
							</div>
							<div class="col-4">
								<input class="form-control" placeholder="Middle" value="">
							</div>
							<div class="col-4">
								<input class="form-control" placeholder="Last" value="Ngu">
							</div>
						</div>
					</div>
					<div class="alert bg-body">
						<b>Please note:</b> If you change your name, you can't change it again for 60 days. Don't add any unusual capitalization, punctuation, characters or random words. <a href="#" class="alert-link">Learn more.</a>
					</div>
					<div class="mb-3">
						<label class="form-label">Other Names</label>
						<div>
							<a href="#" class="btn btn-secondary">
								<i class="fa fa-plus fa-fw"></i> Add other names </a>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-theme">Save changes</button>
				</div>
			</div>
		</div>
	</div>
@endsection
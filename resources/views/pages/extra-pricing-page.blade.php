@extends('layouts.default', [])

@section('title', 'Pricing Page')

@push('scripts')
	<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
@endpush

@section('content')
	<!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
		<li class="breadcrumb-item"><a href="javascript:;">Extra</a></li>
		<li class="breadcrumb-item active">Pricing Page</li>
	</ol>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Pricing Page <small>header small text goes here...</small></h1>
	<!-- END page-header -->

	<div class="card border-0 theme-gray-600 rounded-4 overflow-hidden" data-bs-theme="dark">
		<div class="row gx-0">
			<div class="col-xl-7 position-relative">
				<div class="p-5">
				<div class="display-5 fw-bold mb-3">Web Hosting Plan</div>
				<div class="fs-13px mb-4 font-monospace">
					Discover the <b class="text-theme d-inline-flex border-bottom border-1 border-gray-500">perfect plan</b> for your online presence. In a digital landscape where your website is the gateway to your brand, we offer an array of meticulously crafted hosting plans to suit every ambition and requirement.
				</div>
				<div class="row mb-n3">
					<div class="col-lg-6">
						<div class="d-flex align-items-center mb-3">
							<iconify-icon class="fs-30px text-theme" icon="solar:cup-star-bold-duotone"></iconify-icon>
							<div class="flex-1 ps-2 fs-13px fw-bold">
								Robust Performance
							</div>
						</div>
						<div class="d-flex align-items-center mb-3">
							<iconify-icon class="fs-30px text-theme" icon="solar:cpu-bolt-bold-duotone"></iconify-icon>
							<div class="flex-1 ps-2 fs-13px fw-bold">
								Scalability Options
							</div>
						</div>
						<div class="d-flex align-items-center mb-3">
							<iconify-icon class="fs-30px text-theme" icon="solar:shield-bold-duotone"></iconify-icon>
							<div class="flex-1 ps-2 fs-13px fw-bold">
								Security First
							</div>
						</div>
						<div class="d-flex align-items-center mb-3">
							<iconify-icon class="fs-30px text-theme" icon="solar:headphones-round-sound-bold-duotone"></iconify-icon>
							<div class="flex-1 ps-2 fs-13px fw-bold">
								24/7 Support
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="d-flex align-items-center mb-3">
							<iconify-icon class="fs-30px text-theme" icon="solar:monitor-smartphone-bold-duotone"></iconify-icon>
							<div class="flex-1 ps-2 fs-13px fw-bold">
								User-Friendly Control Panel
							</div>
						</div>
						<div class="d-flex align-items-center mb-3">
							<iconify-icon class="fs-30px text-theme" icon="solar:mouse-bold-duotone"></iconify-icon>
							<div class="flex-1 ps-2 fs-13px fw-bold">
								One-Click Installations
							</div>
						</div>
						<div class="d-flex align-items-center mb-3">
							<iconify-icon class="fs-30px text-theme" icon="solar:gift-bold-duotone"></iconify-icon>
							<div class="flex-1 ps-2 fs-13px fw-bold">
								Value-Added Features
							</div>
						</div>
						<div class="d-flex align-items-center mb-3">
							<iconify-icon class="fs-30px text-theme" icon="solar:dollar-bold-duotone"></iconify-icon>
							<div class="flex-1 ps-2 fs-13px fw-bold">
								Money-Back Guarantee
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
			<div class="col-xl-5 d-xl-block d-none">
				<div class="ms-n5 h-100 d-flex align-items-center justify-content-end">
					<img src="/assets/img/pricing/img-1.svg" style="height: 110%;" />
				</div>
			</div>
		</div>
	</div>

	<div class="row gx-4 py-5" data-bs-theme="dark">
		<div class="col-xl-3 col-md-6 py-3 py-xl-5">
			<div class="card border-0 rounded-4 h-100">
				<div class="card-body fs-14px p-30px d-flex flex-column">
					<div class="d-flex align-items-center">
						<div class="flex-1">
							<div class="h5 font-monospace">Starter Plan</div>
							<div class="display-6 fw-bold mb-0">$5 <small class="h5 text-body text-opacity-50">/month*</small></div>
						</div>
						<div>
							<iconify-icon class="display-4 text-theme rounded-3" icon="solar:usb-bold-duotone"></iconify-icon>
						</div>
					</div>
					<hr class="my-4" />
					<div class="mb-5 text-body text-opacity-75 flex-1">
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check fa-lg text-theme"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Storage:</span> <b class="text-body">10 GB</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check fa-lg text-theme"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Bandwidth:</span> <b class="text-body">100 GB</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check fa-lg text-theme"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Domain Names:</span> <b class="text-body">1</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check fa-lg text-theme"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">SSL Certificate:</span> <b class="text-body"> Shared</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check fa-lg text-theme"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Email Accounts:</span> <b class="text-body"> 5</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check fa-lg text-theme"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">24/7 Support:</span> <b class="text-body"> Yes</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-times fa-lg text-body text-opacity-25"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Backup:</span> <b class="text-body"> Daily</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-times fa-lg text-body text-opacity-25"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Uptime Guarantee:</span> <b class="text-body"> 99.9%</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-times fa-lg text-body text-opacity-25"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">FTP Access:</span> <b class="text-body"> Yes</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-times fa-lg text-body text-opacity-25"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Control Panel:</span> <b class="text-body"> cPanel</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-times fa-lg text-body text-opacity-25"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Free Domain:</span> <b class="text-body"> No</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-times fa-lg text-body text-opacity-25"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Firewall:</span> <b class="text-body"> No</b></div>
						</div>
					</div>
					<div class="mx-n2">
						<a href="#" class="btn btn-default btn-lg w-100 font-monospace">Get Started <i class="fa fa-arrow-right"></i></a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6 py-3 py-xl-5">
			<div class="card border-0 rounded-4 h-100">
				<div class="card-body fs-14px p-30px d-flex flex-column">
					<div class="d-flex align-items-center">
						<div class="flex-1">
							<div class="h5 font-monospace">Booster Plan</div>
							<div class="display-6 fw-bold mb-0">$10 <small class="h5 text-body text-opacity-50">/month*</small></div>
						</div>
						<div>
							<iconify-icon class="display-4 text-theme rounded-3" icon="solar:map-arrow-up-bold-duotone"></iconify-icon>
						</div>
					</div>
					<hr class="my-4" />
					<div class="mb-5 text-body text-opacity-75 flex-1">
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check fa-lg text-theme"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Storage:</span> <b class="text-body">20 GB</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check fa-lg text-theme"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Bandwidth:</span> <b class="text-body">200 GB</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check fa-lg text-theme"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Domain Names:</span> <b class="text-body">2</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check fa-lg text-theme"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">SSL Certificate:</span> <b class="text-body"> Free</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check fa-lg text-theme"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Email Accounts:</span> <b class="text-body"> 10</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check fa-lg text-theme"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">24/7 Support:</span> <b class="text-body"> Yes</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-times fa-lg text-body text-opacity-25"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Backup:</span> <b class="text-body"> Daily</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-times fa-lg text-body text-opacity-25"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Uptime Guarantee:</span> <b class="text-body"> 99.9%</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-times fa-lg text-body text-opacity-25"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">FTP Access:</span> <b class="text-body"> Yes</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-times fa-lg text-body text-opacity-25"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Control Panel:</span> <b class="text-body"> cPanel</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-times fa-lg text-body text-opacity-25"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Free Domain:</span> <b class="text-body"> No</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-times fa-lg text-body text-opacity-25"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Firewall:</span> <b class="text-body"> No</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-times fa-lg text-body text-opacity-25"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">45-Day Money-Back Guarantee</span></div>
						</div>
					</div>
					<div class="mx-n2">
						<a href="#" class="btn btn-default btn-lg w-100 font-monospace">Get Started <i class="fa fa-arrow-right"></i></a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6 py-3 py-xl-0">
			<div class="card border-0 rounded-4 shadow-lg bg-gradient-blue-indigo text-white h-100">
				<div class="card-body fs-15px p-30px h-100 d-flex flex-column">
					<div class="d-flex align-items-center">
						<div class="flex-1">
							<div class="h5 font-monospace">Premium Plan</div>
							<div class="display-6 fw-bold mb-0">$15 <small class="h5 text-body text-opacity-50">/month*</small></div>
						</div>
						<div>
							<iconify-icon class="display-3 text-black text-opacity-50 rounded-3" icon="solar:cup-first-bold-duotone"></iconify-icon>
						</div>
					</div>
					<hr class="my-4" />
					<div class="mb-5 text-body flex-1">
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-white text-opacity-50 fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Storage:</span> <b class="text-white">50 GB</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-white text-opacity-50 fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Bandwidth:</span> <b class="text-white">500 GB</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-white text-opacity-50 fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Domain Names:</span> <b class="text-white">Unlimited</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-white text-opacity-50 fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">SSL Certificate:</span> <b class="text-white">Free</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-white text-opacity-50 fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Email Accounts:</span> <b class="text-white">Unlimited</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-white text-opacity-50 fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">24/7 Support:</span> <b class="text-white">Yes</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-white text-opacity-50 fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Backup:</span> <b class="text-white">Daily</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-white text-opacity-50 fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Uptime Guarantee:</span> <b class="text-white">99.9%</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-white text-opacity-50 fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">FTP Access:</span> <b class="text-white">Yes</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-white text-opacity-50 fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Control Panel:</span> <b class="text-white">cPanel</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-white text-opacity-50 fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Free Domain:</span> <b class="text-white">No</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-white text-opacity-50 fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Firewall:</span> <b class="text-white">Yes</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-white text-opacity-50 fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">E-commerce Support</span></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-white text-opacity-50 fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">45-Day Money-Back Guarantee</span></div>
						</div>
					</div>
					<a href="#" class="btn btn-light btn-lg w-100 text-black font-monospace">Get Started <i class="fa fa-arrow-right"></i></a>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-md-6 py-3 py-xl-5">
			<div class="card border-0 rounded-4 h-100">
				<div class="card-body fs-14px p-30px d-flex flex-column">
					<div class="d-flex align-items-center">
						<div class="flex-1">
							<div class="h5 font-monospace">Business Plan</div>
							<div class="display-6 fw-bold mb-0">$99 <small class="h5 text-body text-opacity-50">/month*</small></div>
						</div>
						<div>
							<iconify-icon class="display-4 text-theme rounded-3" icon="solar:buildings-bold-duotone"></iconify-icon>
						</div>
					</div>
					<hr class="my-4" />
					<div class="mb-5 text-body text-opacity-75 flex-1">
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check fa-lg text-theme"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Storage:</span> <b class="text-body">1 TB</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check fa-lg text-theme"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Bandwidth:</span> <b class="text-body">20 TB</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check fa-lg text-theme"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Domain Names:</span> <b class="text-body">Unlimited</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check fa-lg text-theme"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">SSL Certificate:</span> <b class="text-body">Free</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check fa-lg text-theme"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Email Accounts:</span> <b class="text-body">Unlimited</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check fa-lg text-theme"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">24/7 Support:</span> <b class="text-body">Yes</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-theme fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Backup:</span> <b class="text-body"> Daily</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-theme fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Uptime Guarantee:</span> <b class="text-body">99.9%</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-theme fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">FTP Access:</span> <b class="text-body">Yes</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-theme fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Control Panel:</span> <b class="text-body">cPanel</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-theme fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Free Domain:</span> <b class="text-body">Yes</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-theme fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">Firewall:</span> <b class="text-body">Yes</b></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-theme fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">E-commerce Support</span></div>
						</div>
						<div class="d-flex align-items-center mb-1">
							<i class="fa fa-check text-theme fa-lg"></i> 
							<div class="flex-1 ps-3"><span class="font-monospace small">45-Day Money-Back Guarantee</span></div>
						</div>
					</div>
					<div class="mx-n2">
						<a href="#" class="btn btn-default btn-lg w-100 font-monospace">Get Started <i class="fa fa-arrow-right"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
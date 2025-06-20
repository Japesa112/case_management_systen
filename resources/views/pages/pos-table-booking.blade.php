@extends('layouts.default', [
	'paceTop' => true, 
	'appContentFullHeight' => true, 
	'appContentClass' => 'p-0',
	'appSidebarHide' => true,
	'appHeaderHide' => true
])

@section('title', 'POS - Table Booking System')

@push('scripts')
	<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
	<script src="/assets/js/demo/pos-header.demo.js"></script>
@endpush

@section('content')
	<!-- BEGIN pos -->
	<div class="pos pos-with-header" id="pos">
		<!-- BEGIN pos-header -->
		<div class="pos-header">
			<div class="logo">
				<a href="/">
					<div class="logo-img"><i class="fa fa-bowl-rice fs-2"></i></div>
					<div class="logo-text">Pine & Dine</div>
				</a>
			</div>
			<div class="time" id="time">00:00</div>
			<div class="nav">
				<div class="nav-item">
					<a href="/pos/counter-checkout" class="nav-link">
						<i class="far fa-credit-card nav-icon"></i>
					</a>
				</div>
				<div class="nav-item">
					<a href="/pos/kitchen-order" class="nav-link">
						<i class="far fa-clock nav-icon"></i>
					</a>
				</div>
				<div class="nav-item">
					<a href="/pos/table-booking" class="nav-link">
						<i class="far fa-calendar-check nav-icon"></i>
					</a>
				</div>
				<div class="nav-item">
					<a href="/pos/menu-stock" class="nav-link">
						<i class="fa fa-chart-pie nav-icon"></i>
					</a>
				</div>
			</div>
		</div>
		<!-- END pos-header -->
	
		<!-- BEGIN pos-content -->
		<div class="pos-content">
			<div class="pos-content-container p-4">
				<div class="d-md-flex align-items-center mb-4">
					<div class="pos-booking-title flex-1">
						<div class="fs-24px mb-1">Available Table (8/20)</div>
						<div class="mb-2 mb-md-0 d-flex">
							<div class="d-flex align-items-center me-3">
								<i class="fa fa-circle fa-fw text-gray-700 fs-9px me-1"></i> Completed
							</div>
							<div class="d-flex align-items-center me-3">
								<i class="fa fa-circle fa-fw text-warning fs-9px me-1"></i> Upcoming
							</div>
							<div class="d-flex align-items-center me-3">
								<i class="fa fa-circle fa-fw text-success fs-9px me-1"></i> In-progress
							</div>
						</div>
					</div>
					<div>
						<div class="w-200px">
							<input type="date" class="form-control form-control-lg fs-13px" placeholder="Today's" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">01</div>
											<div class="desc">max 4 pax</div>
										</div>
										<div class="text-theme display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">Reserved by Sean</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
										<div class="info">Reserved by Irene Wong (4pax)</div>
										<div class="status upcoming"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">Reserved by Irene Wong (4pax)</div>
										<div class="status upcoming"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">02</div>
											<div class="desc">max 8 pax</div>
										</div>
										<div class="text-gray-600 display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">Reserved by John (8pax)</div>
										<div class="status in-progress"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">Reserved by Terry (6pax)</div>
										<div class="status upcoming"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">03</div>
											<div class="desc">max 8 pax</div>
										</div>
										<div class="text-gray-600 display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">Walk in lunch</div>
										<div class="status in-progress"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">Reserved by Lisa (8pax)</div>
										<div class="status upcoming"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">Reserved by Lisa (8pax)</div>
										<div class="status upcoming"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">Reserved by Terry</div>
										<div class="status upcoming"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">04</div>
											<div class="desc">max 4 pax</div>
										</div>
										<div class="text-gray-600 display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">Walk in lunch</div>
										<div class="status in-progress"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">Reserved by Richard (4pax)</div>
										<div class="status upcoming"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">Reserved by Richard (4pax)</div>
										<div class="status upcoming"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">Reserved by Paul (3pax)</div>
										<div class="status upcoming"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">Reserved by Paul (3pax)</div>
										<div class="status upcoming"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">Reserved by Paul (3pax)</div>
										<div class="status upcoming"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">05</div>
											<div class="desc">max 4 pax</div>
										</div>
										<div class="text-gray-600 display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">Walk in lunch</div>
										<div class="status in-progress"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">06</div>
											<div class="desc">max 4 pax</div>
										</div>
										<div class="pe-1 text-theme display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">07</div>
											<div class="desc">max 6 pax</div>
										</div>
										<div class="text-gray-600 display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">Walk in lunch</div>
										<div class="status in-progress"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">08</div>
											<div class="desc">max 4 pax</div>
										</div>
										<div class="text-gray-600 display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">Walk in lunch</div>
										<div class="status in-progress"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">09</div>
											<div class="desc">max 4 pax</div>
										</div>
										<div class="pe-1 text-theme display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">10</div>
											<div class="desc">max 4 pax</div>
										</div>
										<div class="text-gray-600 display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">Walk in lunch</div>
										<div class="status in-progress"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">11</div>
											<div class="desc">max 4 pax</div>
										</div>
										<div class="pe-1 text-theme display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">12</div>
											<div class="desc">max 4 pax</div>
										</div>
										<div class="pe-1 text-theme display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">13</div>
											<div class="desc">max 4 pax</div>
										</div>
										<div class="pe-1 text-theme display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">14</div>
											<div class="desc">max 6 pax</div>
										</div>
										<div class="text-gray-600 display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">Walk in lunch</div>
										<div class="status in-progress"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">15</div>
											<div class="desc">max 6 pax</div>
										</div>
										<div class="text-gray-600 display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">Walk in lunch</div>
										<div class="status in-progress"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">16</div>
											<div class="desc">max 4 pax</div>
										</div>
										<div class="pe-1 text-theme display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">17</div>
											<div class="desc">max 4 pax</div>
										</div>
										<div class="pe-1 text-theme display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">18</div>
											<div class="desc">max 6 pax</div>
										</div>
										<div class="text-gray-600 display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">Walk in lunch</div>
										<div class="status in-progress"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">19</div>
											<div class="desc">max 6 pax</div>
										</div>
										<div class="text-gray-600 display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">Walk in lunch</div>
										<div class="status in-progress"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
						<a href="#" data-bs-toggle="modal" data-bs-target="#modalPosBooking" class="pos-table-booking">
							<div class="pos-table-booking-container">
								<div class="pos-table-booking-header">
									<div class="d-flex align-items-center">
										<div class="flex-1">
											<div class="title">TABLE</div>
											<div class="no">20</div>
											<div class="desc">max 6 pax</div>
										</div>
										<div class="text-gray-600 display-5">
											<iconify-icon icon="solar:check-circle-line-duotone"></iconify-icon>
										</div>
									</div>
								</div>
								<div class="pos-table-booking-body">
									<div class="booking">
										<div class="time">08:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">09:00am</div>
										<div class="info">Walk in breakfast</div>
										<div class="status completed"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">10:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">11:00am</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking highlight">
										<div class="time">12:00pm</div>
										<div class="info">Walk in lunch</div>
										<div class="status in-progress"><i class="fa fa-circle"></i></div>
									</div>
									<div class="booking">
										<div class="time">01:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">02:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">03:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">04:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">05:00pm</div>
											<div class="info-title">-</div>
											<div class="info-desc"></div>
									</div>
									<div class="booking">
										<div class="time">06:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">07:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">08:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">09:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
									<div class="booking">
										<div class="time">10:00pm</div>
										<div class="info">-</div>
										<div class="status"></div>
									</div>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
		<!-- END pos-content -->
	</div>
	<!-- END pos -->

	<!-- BEGIN #modalPosBooking -->
	<div class="modal modal-pos-booking fade" id="modalPosBooking">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-0">
				<div class="modal-body">
					<div class="d-flex align-items-center mb-3">
						<h4 class="modal-title d-flex align-items-center"><i class="fa fa-bowl-rice fs-2 me-2 my-n1"></i> Table 01 <small class="fs-13px fw-bold ms-2">max 4 pax</small></h4>
						<a href="#" data-bs-dismiss="modal" class="ms-auto btn-close"></a>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group mb-2">
								<div class="input-group">
									<div class="input-group-text fw-bold">08:00am</div>
									<input type="text" class="form-control" placeholder="" />
								</div>
							</div>
							<div class="form-group mb-2">
								<div class="input-group">
									<div class="input-group-text fw-bold">09:00am</div>
									<input type="text" class="form-control" placeholder="" value="Reserved by Sean" />
								</div>
							</div>
							<div class="form-group mb-2">
								<div class="input-group">
									<div class="input-group-text fw-bold">10:00am</div>
									<input type="text" class="form-control" placeholder="" />
								</div>
							</div>
							<div class="form-group mb-2">
								<div class="input-group">
									<div class="input-group-text fw-bold">11:00am</div>
									<input type="text" class="form-control" placeholder="" />
								</div>
							</div>
							<div class="form-group mb-2">
								<div class="input-group">
									<div class="input-group-text fw-bold">12:00pm</div>
									<input type="text" class="form-control" placeholder="" />
								</div>
							</div>
							<div class="form-group mb-2">
								<div class="input-group">
									<div class="input-group-text fw-bold">01:00pm</div>
									<input type="text" class="form-control" placeholder="" />
								</div>
							</div>
							<div class="form-group mb-2">
								<div class="input-group">
									<div class="input-group-text fw-bold">02:00pm</div>
									<input type="text" class="form-control" placeholder="" />
								</div>
							</div>
							<div class="form-group mb-2">
								<div class="input-group">
									<div class="input-group-text fw-bold">03:00pm</div>
									<input type="text" class="form-control" placeholder="" />
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group mb-2">
								<div class="input-group">
									<div class="input-group-text fw-bold">04:00pm</div>
									<input type="text" class="form-control" placeholder="" />
								</div>
							</div>
							<div class="form-group mb-2">
								<div class="input-group">
									<div class="input-group-text fw-bold">05:00pm</div>
									<input type="text" class="form-control" placeholder="" value="Reserved by Irene Wong (4pax)" />
								</div>
							</div>
							<div class="form-group mb-2">
								<div class="input-group">
									<div class="input-group-text fw-bold">06:00pm</div>
									<input type="text" class="form-control" placeholder="" value="Reserved by Irene Wong (4pax)" />
								</div>
							</div>
							<div class="form-group mb-2">
								<div class="input-group">
									<div class="input-group-text fw-bold">07:00pm</div>
									<input type="text" class="form-control" placeholder="" />
								</div>
							</div>
							<div class="form-group mb-2">
								<div class="input-group">
									<div class="input-group-text fw-bold">08:00pm</div>
									<input type="text" class="form-control" placeholder="" />
								</div>
							</div>
							<div class="form-group mb-2">
								<div class="input-group">
									<div class="input-group-text fw-bold">09:00pm</div>
									<input type="text" class="form-control" placeholder="" />
								</div>
							</div>
							<div class="form-group mb-2">
								<div class="input-group">
									<div class="input-group-text fw-bold">10:00pm</div>
									<input type="text" class="form-control" placeholder="" />
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-default w-100px" data-bs-dismiss="modal">Cancel</a>
					<button type="submit" class="btn btn-success w-100px">Book</button>
				</div>
			</div>
		</div>
	</div>
	<!-- END #modalPosBooking -->
@endsection

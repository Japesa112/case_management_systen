@extends('layouts.default', [
	'paceTop' => true, 
	'appContentFullHeight' => true, 
	'appContentClass' => 'p-0',
	'appSidebarHide' => true,
	'appHeaderHide' => true
])

@section('title', 'POS - Counter Checkout System')

@push('scripts')
	<script src="/assets/js/demo/pos-header.demo.js"></script>
	<script src="/assets/js/demo/pos-counter-checkout.demo.js"></script>
@endpush

@section('content')
	<!-- BEGIN pos -->
	<div class="pos pos-with-header pos-with-sidebar" id="pos">
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
			<div class="pos-content-container">
				<div class="d-md-flex align-items-center mb-4">
					<div class="pos-booking-title flex-1">
						<div class="fs-24px mb-1">Available Table (13/20)</div>
						<div class="mb-2 mb-md-0 d-flex">
							<div class="d-flex align-items-center me-3">
								<i class="fa fa-circle fa-fw text-gray-500 fs-9px me-1"></i> Reserved
							</div>
							<div class="d-flex align-items-center me-3">
								<i class="fa fa-circle fa-fw text-warning fs-9px me-1"></i> Table In-use
							</div>
							<div class="d-flex align-items-center me-3">
								<i class="fa fa-circle fa-fw text-theme fs-9px me-1"></i> Table Available
							</div>
						</div>
					</div>
				</div>
				<div class="pos-table-row">
					<div class="pos-table in-use selected">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">1</div>
								<div class="order"><span>9 orders</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">4 / 4</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">35:20</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">$318.20</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-dollar-sign"></i></span>
										<span class="text">Unpaid</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table in-use">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">2</div>
								<div class="order"><span>12 orders</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">6 / 8</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">12:69</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">$682.20</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-dollar-sign"></i></span>
										<span class="text">Unpaid</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table available">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">3</div>
								<div class="order"><span>max 6 pax</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">0 / 6</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">-</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-dollar-sign"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table available">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">4</div>
								<div class="order"><span>max 4 pax</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">0 / 4</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">-</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-dollar-sign"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table available">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">5</div>
								<div class="order"><span>max 4 pax</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">0 / 4</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">-</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-dollar-sign"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table in-use">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">6</div>
								<div class="order"><span>3 orders</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">3 / 6</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">20:52</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">$56.49</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-dollar-sign"></i></span>
										<span class="text">unpaid</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table in-use">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">7</div>
								<div class="order"><span>6 order</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">3 / 4</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">58:40</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">$329.02</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-check-circle"></i></span>
										<span class="text">Paid</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table in-use">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">8</div>
								<div class="order"><span>0 order</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">2 / 4</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">05:12</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">$0.00</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-dollar-sign"></i></span>
										<span class="text">unpaid</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table in-use">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">9</div>
								<div class="order"><span>4 order</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">2 / 4</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">52:58</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">$49.50</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-dollar-sign"></i></span>
										<span class="text">Unpaid</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table in-use">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">10</div>
								<div class="order"><span>12 order</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">9 / 12</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">66:69</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">$768.24</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-check-circle"></i></span>
										<span class="text">Paid</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table disabled">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">11</div>
								<div class="order"><span>Reserved for Sean</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">0 / 4</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">-</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-dollar-sign"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table available">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">12</div>
								<div class="order"><span>max 6 pax</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">0 / 6</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">-</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-dollar-sign"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table available">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">13</div>
								<div class="order"><span>max 6 pax</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">0 / 6</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">-</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-dollar-sign"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table available">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">14</div>
								<div class="order"><span>max 6 pax</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">0 / 6</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">-</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-dollar-sign"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table available">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">15</div>
								<div class="order"><span>max 6 pax</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">0 / 6</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">-</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-dollar-sign"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table available">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">16</div>
								<div class="order"><span>max 6 pax</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">0 / 6</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">-</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-dollar-sign"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table available">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">17</div>
								<div class="order"><span>max 6 pax</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">0 / 6</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">-</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-dollar-sign"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table available">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">18</div>
								<div class="order"><span>max 6 pax</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">0 / 6</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">-</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-dollar-sign"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table available">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">19</div>
								<div class="order"><span>max 6 pax</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">0 / 6</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">-</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-dollar-sign"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="pos-table available">
						<a href="#" class="pos-table-container" data-toggle="select-table">
							<div class="pos-table-status"></div>
							<div class="pos-table-name">
								<div class="name">Table</div>
								<div class="no">20</div>
								<div class="order"><span>max 6 pax</span></div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-user"></i></span>
										<span class="text">0 / 6</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-clock"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
							<div class="pos-table-info-row">
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="fa fa-receipt"></i></span>
										<span class="text">-</span>
									</div>
								</div>
								<div class="pos-table-info-col">
									<div class="pos-table-info-container">
										<span class="icon opacity-50"><i class="far fa-dollar-sign"></i></span>
										<span class="text">-</span>
									</div>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
		<!-- END pos-content -->
	
		<!-- BEGIN pos-sidebar -->
		<div class="pos-sidebar">
			<div class="pos-sidebar-header">
				<div class="back-btn">
					<button type="button" data-dismiss-class="pos-sidebar-mobile-toggled" data-target="#pos" class="btn">
						<i class="fa fa-chevron-left"></i>
					</button>
				</div>
				<div class="icon"><i class="fa fa-plate-wheat"></i></div>
				<div class="title">Table 01</div>
				<div class="order">Order: <b>#0001</b></div>
			</div>
			<div class="pos-sidebar-body">
				<div class="pos-table" data-id="pos-table-info">
					<div class="row pos-table-row">
						<div class="col-8">
							<div class="pos-product-thumb">
								<div class="img" style="background-image: url(/assets/img/pos/product-2.jpg)"></div>
								<div class="info">
									<div class="title">Grill Pork Chop</div>
									<div class="desc">- size: large</div>
								</div>
							</div>
						</div>
						<div class="col-1 total-qty">x1</div>
						<div class="col-3 total-price">$12.99</div>
					</div>
					<div class="row pos-table-row">
						<div class="col-8">
							<div class="pos-product-thumb">
								<div class="img" style="background-image: url(/assets/img/pos/product-8.jpg)"></div>
								<div class="info">
									<div class="title">Orange Juice</div>
									<div class="desc">
										- size: large<br />
										- less ice
									</div>
								</div>
							</div>
						</div>
						<div class="col-1 total-qty">x2</div>
						<div class="col-3 total-price">$10.00</div>
					</div>
					<div class="row pos-table-row">
						<div class="col-8">
							<div class="pos-product-thumb">
								<div class="img" style="background-image: url(/assets/img/pos/product-13.jpg)"></div>
								<div class="info">
									<div class="title">Vanilla Ice-cream</div>
									<div class="desc">
										- scoop: 1 <br />
										- flavour: vanilla
									</div>
								</div>
							</div>
						</div>
						<div class="col-1 total-qty">x1</div>
						<div class="col-3 total-price">$3.99</div>
					</div>
					<div class="row pos-table-row">
						<div class="col-8">
							<div class="pos-product-thumb">
								<div class="img" style="background-image: url(/assets/img/pos/product-1.jpg)"></div>
								<div class="info">
									<div class="title">Grill chicken chop</div>
									<div class="desc">
										- size: large<br />
										- spicy: medium
									</div>
								</div>
							</div>
						</div>
						<div class="col-1 total-qty">x1</div>
						<div class="col-3 total-price">$10.99</div>
					</div>
					<div class="row pos-table-row">
						<div class="col-8">
							<div class="pos-product-thumb">
								<div class="img" style="background-image: url(/assets/img/pos/product-10.jpg)"></div>
								<div class="info">
									<div class="title">Mushroom Soup</div>
									<div class="desc">
										- size: large<br />
										- more cheese
									</div>
								</div>
							</div>
						</div>
						<div class="col-1 total-qty">x1</div>
						<div class="col-3 total-price">$3.99</div>
					</div>
					<div class="row pos-table-row">
						<div class="col-8">
							<div class="pos-product-thumb">
								<div class="img" style="background-image: url(/assets/img/pos/product-5.jpg)"></div>
								<div class="info">
									<div class="title">Hawaiian Pizza</div>
									<div class="desc">
										- size: large<br />
										- more onion
									</div>
								</div>
							</div>
						</div>
						<div class="col-1 total-qty">x1</div>
						<div class="col-3 total-price">$15.00</div>
					</div>
					<div class="row pos-table-row">
						<div class="col-8">
							<div class="pos-product-thumb">
								<div class="img" style="background-image: url(/assets/img/pos/product-15.jpg)"></div>
								<div class="info">
									<div class="title">Perfect Yeast Doughnuts</div>
									<div class="desc">
										- size: 1 set<br />
										- flavour: random
									</div>
								</div>
							</div>
						</div>
						<div class="col-1 total-qty">x1</div>
						<div class="col-3 total-price">$2.99</div>
					</div>
					<div class="row pos-table-row">
						<div class="col-8">
							<div class="pos-product-thumb">
								<div class="img" style="background-image: url(/assets/img/pos/product-14.jpg)"></div>
								<div class="info">
									<div class="title">Macarons</div>
									<div class="desc">
										- size: 1 set<br />
										- flavour: random
									</div>
								</div>
							</div>
						</div>
						<div class="col-1 total-qty">x1</div>
						<div class="col-3 total-price">$4.99</div>
					</div>
				</div>
				<div class="h-100 d-none align-items-center justify-content-center text-center p-20" data-id="pos-table-empty">
					<div>
						<div class="mb-3">
							<svg width="6em" height="6em" viewBox="0 0 16 16" class="text-gray-300" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" d="M14 5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V5zM1 4v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4H1z"/>
								<path d="M8 1.5A2.5 2.5 0 0 0 5.5 4h-1a3.5 3.5 0 1 1 7 0h-1A2.5 2.5 0 0 0 8 1.5z"/>
							</svg>
						</div>
						<h4>No table selected</h4>
					</div>
				</div>
			</div>
			<div class="pos-sidebar-footer">
				<div class="d-flex align-items-center mb-2">
					<div>Subtotal</div>
					<div class="flex-1 text-end h6 mb-0">$64.94</div>
				</div>
				<div class="d-flex align-items-center">
					<div>Taxes (6%)</div>
					<div class="flex-1 text-end h6 mb-0">$3.90</div>
				</div>
				<hr class="opacity-1 my-10px">
				<div class="d-flex align-items-center mb-2">
					<div>Total</div>
					<div class="flex-1 text-end h4 mb-0">$68.84</div>
				</div>
				<div class="d-flex align-items-center mt-3">
					<a href="#" class="btn btn-default w-80px rounded-3 text-center me-10px">
						<i class="fab fa-paypal d-block fs-18px my-1"></i>
						E-Wallet
					</a>
					<a href="#" class="btn btn-default w-80px rounded-3 text-center me-10px">
						<i class="fab fa-cc-visa d-block fs-18px my-1"></i>
						CC
					</a>
					<a href="#" class="btn btn-theme rounded-3 text-center flex-1">
						<i class="fa fa-wallet d-block fs-18px my-1"></i>
						Pay by Cash
					</a>
				</div>
			</div>
		</div>
		<!-- END pos-sidebar -->
	</div>
	<!-- END pos -->
@endsection

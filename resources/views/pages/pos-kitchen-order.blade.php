@extends('layouts.default', [
	'paceTop' => true, 
	'appContentFullHeight' => true, 
	'appContentClass' => 'p-0',
	'appSidebarHide' => true,
	'appHeaderHide' => true
])

@section('title', 'POS - Kitchen Order System')

@push('scripts')
	<script src="/assets/js/demo/posheader.demo.js"></script>
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
			<div class="pos-task-row">
				<div class="pos-task">
					<div class="pos-task-info">
						<div class="table-no">
							Table <b>05</b>
						</div>
						<div class="order-no">
							Order No: #9049
						</div>
						<div class="order-type">
							<span class="badge bg-success">Dine-in</span>
						</div>
						<div class="time-pass" data-start-time="3">
							07:13 time
						</div>
					</div>
					<div class="pos-task-body">
						<div class="pos-task-completed">
							Completed: <b>(1/3)</b>
						</div>
						<div class="pos-task-product-row">
							<div class="pos-task-product">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-2.jpg);"></div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Pork Burger</div>
										<div class="desc">
											- large size<br />
											- extra cheese<br />
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success">Complete</a>
									<a href="#" class="btn btn-outline-inverse">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-14.jpg);"></div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Macarons</div>
										<div class="desc">
											- serve after dishes
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success">Complete</a>
									<a href="#" class="btn btn-outline-inverse">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-8.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Vita C Detox Juice</div>
										<div class="desc">
											- large size<br />
											- less ice<br />
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="pos-task">
					<div class="pos-task-info">
						<div class="table-no">
							Table <b>14</b>
						</div>
						<div class="order-no">
							Order No: #9047
						</div>
						<div class="order-type">
							<span class="badge bg-success">Dine-in</span>
						</div>
						<div class="time-pass" data-start-time="3">
							<span class="text-danger">12:13</span> time
						</div>
					</div>
					<div class="pos-task-body">
						<div class="pos-task-completed">
							Completed: <b>(3/4)</b>
						</div>
						<div class="pos-task-product-row">
							<div class="pos-task-product">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-11.jpg);"></div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Baked chicken wing</div>
										<div class="desc">
											- 6 pieces<br />
											- honey source<br />
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success">Complete</a>
									<a href="#" class="btn btn-outline-inverse">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-12.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Veggie Spaghetti</div>
										<div class="desc">
											- size: large <br />
											- spicy level: light
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-7.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Coffee Latte</div>
										<div class="desc">
											- no sugar<br />
											- more cream<br />
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-1.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Grill Chicken Chop</div>
										<div class="desc">
											- ala carte
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="pos-task">
					<div class="pos-task-info">
						<div class="table-no">
							Table <b>17</b>
						</div>
						<div class="order-no">
							Order No: #9046
						</div>
						<div class="order-type">
							<span class="badge bg-gray-500">Dine-in</span>
						</div>
						<div class="time-pass" data-start-time="3">
							All dish served<br />12:30 total time
						</div>
					</div>
					<div class="pos-task-body">
						<div class="pos-task-completed">
							Completed: <b>(3/3)</b>
						</div>
						<div class="pos-task-product-row">
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-2.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Pork Burger</div>
										<div class="desc">
											- large size<br />
											- extra cheese<br />
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-10.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Mushroom soup</div>
										<div class="desc">
											- ala carte<br />
											- more cheese<br />
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-8.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Vita C Detox Juice</div>
										<div class="desc">
											- large size<br />
											- less ice<br />
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="pos-task">
					<div class="pos-task-info">
						<div class="table-no">
							Table <b>18</b>
						</div>
						<div class="order-no">
							Order No: #9045
						</div>
						<div class="order-type">
							<span class="badge bg-gray-500">Dine-in</span>
						</div>
						<div class="time-pass" data-start-time="3">
							All dish served<br />12:30 total time
						</div>
					</div>
					<div class="pos-task-body">
						<div class="pos-task-completed">
							Completed: <b>(2/2)</b>
						</div>
						<div class="pos-task-product-row">
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-13.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Vanilla Ice Cream</div>
										<div class="desc">
											- ala carte
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-9.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Pancake</div>
										<div class="desc">
											- ala carte
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="pos-task">
					<div class="pos-task-info">
						<div class="table-no">
							Table <b>02</b>
						</div>
						<div class="order-no">
							Order No: #9045
						</div>
						<div class="order-type">
							<span class="badge bg-gray-500">Take Away</span>
						</div>
						<div class="time-pass" data-start-time="3">
							All dish served<br />22:28 total time
						</div>
					</div>
					<div class="pos-task-body">
						<div class="pos-task-completed">
							Completed: <b>(3/3)</b>
						</div>
						<div class="pos-task-product-row">
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-4.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Vegan Salad Bowl&reg;</div>
										<div class="desc">
											- ala carte
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-6.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Avocado Shake</div>
										<div class="desc">
											- ala carte
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
							<div class="pos-task-product completed">
								<div class="pos-task-product-img">
									<div class="cover" style="background-image: url(/assets/img/pos/product-5.jpg);"></div>
									<div class="caption">
										<div>Completed</div>
									</div>
								</div>
								<div class="pos-task-product-info">
									<div class="info">
										<div class="title">Hawaiian Pizza&reg;</div>
										<div class="desc">
											- ala carte
										</div>
									</div>
									<div class="qty">
										x1
									</div>
								</div>
								<div class="pos-task-product-action">
									<a href="#" class="btn btn-success disabled">Complete</a>
									<a href="#" class="btn btn-outline-inverse disabled">Cancel</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END pos-content -->
	</div>
	<!-- END pos -->
@endsection

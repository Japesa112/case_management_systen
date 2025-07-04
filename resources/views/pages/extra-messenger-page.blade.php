@extends('layouts.default', ['appContentFullHeight' => true, 'appHeaderInverse' => true, 'appSidebarMinified' => true, 'appContentClass' => 'p-0'])

@section('title', 'Messenger Page')

@push('scripts')
	<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
@endpush

@section('content')
	<div class="messenger" id="messenger">
		<div class="messenger-menu">
			<div class="messenger-menu-item my-2">
				<a href="#" class="messenger-menu-link">
					<div class="m-n1">
						<img src="/assets/img/user/user-13.jpg" class="w-100 d-block rounded-circle" />
					</div>
				</a>
			</div>
			<div class="messenger-menu-item active">
				<a href="#" class="messenger-menu-link">
					<iconify-icon class="fs-30px" icon="solar:dialog-2-bold-duotone"></iconify-icon>
				</a>
			</div>
			<div class="messenger-menu-item">
				<a href="#" class="messenger-menu-link">
					<iconify-icon class="fs-30px" icon="solar:notebook-bold-duotone"></iconify-icon>
				</a>
			</div>
			<div class="messenger-menu-item">
				<a href="#" class="messenger-menu-link">
					<iconify-icon class="fs-30px" icon="solar:box-minimalistic-bold-duotone"></iconify-icon>
				</a>
			</div>
			<div class="messenger-menu-item">
				<a href="#" class="messenger-menu-link">
					<iconify-icon class="fs-30px" icon="solar:folder-with-files-bold-duotone"></iconify-icon>
				</a>
			</div>
			<div class="messenger-menu-item">
				<a href="#" class="messenger-menu-link">
					<iconify-icon class="fs-30px" icon="solar:clapperboard-play-bold-duotone"></iconify-icon>
				</a>
			</div>
			<div class="messenger-menu-item">
				<a href="#" class="messenger-menu-link">
					<iconify-icon class="fs-30px" icon="solar:settings-bold-duotone"></iconify-icon>
				</a>
			</div>
		</div>
		<div class="messenger-chat">
			<div class="messenger-chat-header d-flex">
				<div class="flex-1 position-relative">
					<input type="text" class="form-control border-0 bg-light ps-30px" placeholder="Search" />
					<i class="fa fa-search position-absolute start-0 top-0 h-100 ps-2 ms-3px d-flex align-items-center justify-content-center"></i>
				</div>
				<div class="ps-2">
					<a href="#" class="btn border-0 bg-light shadow-none">
						<i class="fa fa-plus"></i>
					</a>
				</div>
			</div>
			<div class="messenger-chat-body">
				<div data-scrollbar="true" data-height="100%">
					<div class="messenger-chat-list">
						<div class="messenger-chat-item">
							<a href="javascript:;" class="messenger-chat-link" data-toggle-class="messenger-chat-content-mobile-toggled" data-target="#messenger">
								<div class="messenger-chat-media">
									<img alt="" src="/assets/img/user/user-1.jpg" />
								</div>
								<div class="messenger-chat-content">
									<div class="messenger-chat-title">
										<div>Daniel</div>
										<div class="messenger-chat-time">09:15 AM</div>
									</div>
									<div class="messenger-chat-desc"> Hey, how was your weekend?</div>
								</div>
							</a>
						</div>
						<div class="messenger-chat-item active">
							<a href="javascript:;" class="messenger-chat-link" data-toggle-class="messenger-chat-content-mobile-toggled" data-target="#messenger">
								<div class="messenger-chat-media flex-wrap overflow-hidden">
									<img alt="" src="/assets/img/user/user-1.jpg" width="14" class="rounded-0 me-1px mb-1px" />
									<img alt="" src="/assets/img/user/user-2.jpg" width="14" class="rounded-0 me-1px mb-1px" />
									<img alt="" src="/assets/img/user/user-3.jpg" width="14" class="rounded-0 me-0px mb-1px" />
									<img alt="" src="/assets/img/user/user-4.jpg" width="14" class="rounded-0 me-1px mb-1px" />
									<img alt="" src="/assets/img/user/user-5.jpg" width="14" class="rounded-0 me-1px mb-1px" />
									<img alt="" src="/assets/img/user/user-6.jpg" width="14" class="rounded-0 me-0px mb-1px" />
									<img alt="" src="/assets/img/user/user-7.jpg" width="14" class="rounded-0 me-1px mb-1px" />
									<img alt="" src="/assets/img/user/user-8.jpg" width="14" class="rounded-0 me-1px mb-1px" />
									<img alt="" src="/assets/img/user/user-9.jpg" width="14" class="rounded-0 me-0px mb-1px" />
								</div>
								<div class="messenger-chat-content">
									<div class="messenger-chat-title">
										<div>Company Discussion Group (9)</div>
										<div class="messenger-chat-time">10:30 AM</div>
									</div>
									<div class="messenger-chat-desc">Me: We need to prepare the project report by Friday. </div>
								</div>
							</a>
						</div>
						<div class="messenger-chat-item">
							<a href="javascript:;" class="messenger-chat-link" data-toggle-class="messenger-chat-content-mobile-toggled" data-target="#messenger">
								<div class="messenger-chat-media bg-lime-900 text-lime">
									<iconify-icon icon="solar:book-bold-duotone"></iconify-icon>
								</div>
								<div class="messenger-chat-content">
									<div class="messenger-chat-title">
										<div>Online Course (12)</div>
										<div class="messenger-chat-time">11:45 AM</div>
									</div>
									<div class="messenger-chat-desc">Emily: Let's meet at the library at 1 PM to study. </div>
								</div>
							</a>
						</div>
						<div class="messenger-chat-item">
							<a href="javascript:;" class="messenger-chat-link" data-toggle-class="messenger-chat-content-mobile-toggled" data-target="#messenger">
								<div class="messenger-chat-media bg-orange text-orange-900">
									<iconify-icon icon="solar:oven-mitts-bold-duotone"></iconify-icon>
								</div>
								<div class="messenger-chat-content">
									<div class="messenger-chat-title">
										<div>Pizza Lovers</div>
										<div class="messenger-chat-time">12:20 PM</div>
									</div>
									<div class="messenger-chat-desc"> I found a new pizzeria for our next meetup! </div>
								</div>
							</a>
						</div>
						<div class="messenger-chat-item">
							<a href="javascript:;" class="messenger-chat-link" data-toggle-class="messenger-chat-content-mobile-toggled" data-target="#messenger">
								<div class="messenger-chat-media bg-blue-900 text-blue">
									<iconify-icon icon="solar:gamepad-charge-bold-duotone"></iconify-icon>
								</div>
								<div class="messenger-chat-content">
									<div class="messenger-chat-title">
										<div>Gaming Crew</div>
										<div class="messenger-chat-time">01:05 PM</div>
									</div>
									<div class="messenger-chat-desc"> Anyone up for a game of Among Us tonight? </div>
								</div>
							</a>
						</div>
						<div class="messenger-chat-item">
							<a href="javascript:;" class="messenger-chat-link" data-toggle-class="messenger-chat-content-mobile-toggled" data-target="#messenger">
								<div class="messenger-chat-media row gx-0 overflow-hidden">
									<div class="col-6 d-flex flex-column">
										<img alt="" src="/assets/img/user/user-10.jpg" class="w-100 rounded-0" />
										<img alt="" src="/assets/img/user/user-11.jpg" class="w-100 rounded-0" />
									</div>
									<div class="col-6 d-flex flex-column">
										<img alt="" src="/assets/img/user/user-12.jpg" class="w-100 rounded-0" />
										<img alt="" src="/assets/img/user/user-13.jpg" class="w-100 rounded-0" />
									</div>
								</div>
								<div class="messenger-chat-content">
									<div class="messenger-chat-title">
										<div>Weekend Plans</div>
										<div class="messenger-chat-time">02:15 PM</div>
									</div>
									<div class="messenger-chat-desc"> How about a hike this Saturday morning? </div>
								</div>
							</a>
						</div>
						<div class="messenger-chat-item">
							<a href="javascript:;" class="messenger-chat-link" data-toggle-class="messenger-chat-content-mobile-toggled" data-target="#messenger">
								<div class="messenger-chat-media">
									<iconify-icon class="text-red-600" icon="solar:calendar-bold-duotone"></iconify-icon>
								</div>
								<div class="messenger-chat-content">
									<div class="messenger-chat-title">
										<div>Event Reminders</div>
										<div class="messenger-chat-time">03:00 PM</div>
									</div>
									<div class="messenger-chat-desc"> Don't forget Grandma's birthday tomorrow! </div>
								</div>
							</a>
						</div>
						<div class="messenger-chat-item">
							<a href="javascript:;" class="messenger-chat-link" data-toggle-class="messenger-chat-content-mobile-toggled" data-target="#messenger">
								<div class="messenger-chat-media">
									<iconify-icon icon="solar:clipboard-list-bold-duotone"></iconify-icon>
								</div>
								<div class="messenger-chat-content">
									<div class="messenger-chat-title">
										<div>Party Planning</div>
										<div class="messenger-chat-time">03:45 PM</div>
									</div>
									<div class="messenger-chat-desc"> We need to finalize the decorations for the party. </div>
								</div>
							</a>
						</div>
						<div class="messenger-chat-item">
							<a href="javascript:;" class="messenger-chat-link" data-toggle-class="messenger-chat-content-mobile-toggled" data-target="#messenger">
								<div class="messenger-chat-media">
									<iconify-icon icon="solar:book-bold-duotone"></iconify-icon>
								</div>
								<div class="messenger-chat-content">
									<div class="messenger-chat-title">
										<div>Book Club Discussions</div>
										<div class="messenger-chat-time">04:30 PM</div>
									</div>
									<div class="messenger-chat-desc"> What did you think of the last book's ending? </div>
								</div>
							</a>
						</div>
						<div class="messenger-chat-item">
							<a href="javascript:;" class="messenger-chat-link" data-toggle-class="messenger-chat-content-mobile-toggled" data-target="#messenger">
								<div class="messenger-chat-media">
									<iconify-icon icon="solar:bicycling-bold-duotone"></iconify-icon>
								</div>
								<div class="messenger-chat-content">
									<div class="messenger-chat-title">
										<div>Road Trip Ideas</div>
										<div class="messenger-chat-time">05:15 PM</div>
									</div>
									<div class="messenger-chat-desc"> Let's plan our road trip route and stops! </div>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="messenger-content">
			<div class="widget-chat">
				<!-- BEGIN widget-chat-header -->
				<div class="widget-chat-header">
					<div class="d-block d-lg-none">
						<button type="button" class="btn border-0 shadow-none" data-toggle-class="messenger-chat-content-mobile-toggled" data-target="#messenger">
							<i class="fa fa-chevron-left fa-lg"></i>
						</button>
					</div>
					<div class="widget-chat-header-content">
						<div class="fs-5 fw-bold">Company Discussion Group (9)</div>
					</div>
					<div class="">
						<button type="button" class="btn border-0 shadow-none" data-bs-toggle="dropdown">
							<i class="fa fa-ellipsis fa-lg"></i>
						</button>
						<ul class="dropdown-menu">
							<li>
								<a class="dropdown-item" href="#">Action</a>
							</li>
							<li>
								<a class="dropdown-item" href="#">Another action</a>
							</li>
							<li>
								<a class="dropdown-item" href="#">Something else here</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- END widget-chat-header -->
				<!-- BEGIN widget-chat-body -->
				<div class="widget-chat-body" data-scrollbar="true" data-height="100%">
					<div class="widget-chat-item with-media end">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-13.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-message"> Good morning, team! Just a reminder, we need to prepare the project report by Friday. Let's stay on track and meet our deadlines. </div>
								<div class="widget-chat-time">08:45AM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-1.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-blue">Daniel</div>
								<div class="widget-chat-message"> Morning! I'm on it and will start compiling the data today. </div>
								<div class="widget-chat-time">09:02AM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-2.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-indigo">Mark</div>
								<div class="widget-chat-message"> Thanks for the heads up! I'll make sure the design elements are ready for the report. </div>
								<div class="widget-chat-time">09:20AM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-3.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-red">Alexander</div>
								<div class="widget-chat-message"> Got it. I'll review the financial data and ensure all the numbers are accurate. </div>
								<div class="widget-chat-time">09:35AM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media end">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-13.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-message"> Great! Let's have a progress check-in at 2 PM today to see how things are going. Keep up the good work, team! </div>
								<div class="widget-chat-time">10:10AM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-1.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-blue">Daniel</div>
								<div class="widget-chat-message"> Sounds good! See you at the meeting. </div>
								<div class="widget-chat-time">10:30AM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-2.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-indigo">Mark</div>
								<div class="widget-chat-message"> Looking forward to it. We'll have everything ready. </div>
								<div class="widget-chat-time">10:50AM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-3.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-red">Alexander</div>
								<div class="widget-chat-message"> Count me in. I'll be prepared with the financial figures. </div>
								<div class="widget-chat-time">11:15AM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media end">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-13.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-orange"></div>
								<div class="widget-chat-message"> Excellent teamwork, everyone! We're making great progress. </div>
								<div class="widget-chat-time">11:45AM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-1.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-blue">Daniel</div>
								<div class="widget-chat-message"> Thank you! It's a team effort. </div>
								<div class="widget-chat-time">12:20PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-2.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-indigo">Mark</div>
								<div class="widget-chat-message"> Absolutely, we've got a strong team. </div>
								<div class="widget-chat-time">01:05PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-3.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-red">Alexander</div>
								<div class="widget-chat-message"> Agreed, we're all working towards the same goal. </div>
								<div class="widget-chat-time">02:00PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media end">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-13.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-message"> That's the spirit! Let's keep the communication flowing. If you have any questions or face any challenges, don't hesitate to reach out. </div>
								<div class="widget-chat-time">02:45PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-1.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-blue">Daniel</div>
								<div class="widget-chat-message"> Will do, Manager. </div>
								<div class="widget-chat-time">03:10PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-2.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-indigo">Mark</div>
								<div class="widget-chat-message"> Understood, we'll collaborate closely. </div>
								<div class="widget-chat-time">03:35PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-3.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-red">Alexander</div>
								<div class="widget-chat-message"> Thanks for the support, Manager. </div>
								<div class="widget-chat-time">04:00PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media end">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-13.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-message"> Alexander, can you also provide an update on the budget allocation? </div>
								<div class="widget-chat-time">04:25PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-3.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-red">Alexander</div>
								<div class="widget-chat-message"> Sure, I'll get that information for you by the end of the day. </div>
								<div class="widget-chat-time">04:50PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media end">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-13.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-message"> Perfect. And Mark, how's the visual design coming along? </div>
								<div class="widget-chat-time">05:15PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-2.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-indigo">Mark</div>
								<div class="widget-chat-message"> It's going smoothly. I'll share the mockups with you later today. </div>
								<div class="widget-chat-time">05:40PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media end">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-13.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-message"> Sounds great, Mark. Looking forward to it. </div>
								<div class="widget-chat-time">06:05PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-1.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-blue">Daniel</div>
								<div class="widget-chat-message"> Should we discuss the presentation format for the report? </div>
								<div class="widget-chat-time">06:30AM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media end">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-13.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-message"> Good point, Daniel. Let's have a quick discussion on that during the meeting today. </div>
								<div class="widget-chat-time">07:00PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-3.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-red">Alexander</div>
								<div class="widget-chat-message"> I'll make sure the financial data is presented in a clear and concise manner. </div>
								<div class="widget-chat-time">07:25PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media end">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-13.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-message"> Thank you, Alexander. That will be essential for our stakeholders. </div>
								<div class="widget-chat-time">07:50PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-2.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-indigo">Mark</div>
								<div class="widget-chat-message"> Do we have all the necessary data and information for the report? </div>
								<div class="widget-chat-time">08:15PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-4.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-blue">Daniel</div>
								<div class="widget-chat-message"> I've collected most of it, but I'm waiting on a few figures from the sales team. </div>
								<div class="widget-chat-time">08:40PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-3.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-red">Alexander</div>
								<div class="widget-chat-message"> I'll follow up with them to expedite the process. </div>
								<div class="widget-chat-time">09:05PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media end">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-13.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-message"> Great teamwork, everyone. Keep up the good work. Our client will be impressed! </div>
								<div class="widget-chat-time">09:30PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-4.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-blue">Daniel</div>
								<div class="widget-chat-message"> We won't disappoint! </div>
								<div class="widget-chat-time">09:55PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-2.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-indigo">Mark</div>
								<div class="widget-chat-message"> Let's make it a stellar report! </div>
								<div class="widget-chat-time">10:20PM</div>
							</div>
						</div>
					</div>
					<div class="widget-chat-item with-media start">
						<div class="widget-chat-media">
							<img alt="" src="/assets/img/user/user-3.jpg">
						</div>
						<div class="widget-chat-info">
							<div class="widget-chat-info-container">
								<div class="widget-chat-name text-red">Alexander</div>
								<div class="widget-chat-message"> Agreed, let's do our best! </div>
								<div class="widget-chat-time">10:45PM</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END widget-chat-body -->
				<!-- BEGIN widget-input -->
				<div class="widget-chat-input">
					<div class="widget-chat-toolbar">
						<a href="#" class="widget-chat-toolbar-link">
							<iconify-icon class="fs-26px" icon="solar:smile-circle-outline"></iconify-icon>
						</a>
						<a href="#" class="widget-chat-toolbar-link">
							<iconify-icon class="fs-26px" icon="solar:folder-with-files-outline"></iconify-icon>
						</a>
						<a href="#" class="widget-chat-toolbar-link">
							<iconify-icon class="fs-26px" icon="solar:scissors-square-outline"></iconify-icon>
						</a>
						<a href="#" class="widget-chat-toolbar-link">
							<iconify-icon class="fs-26px" icon="solar:chat-round-dots-outline"></iconify-icon>
						</a>
						<a href="#" class="widget-chat-toolbar-link ms-auto">
							<iconify-icon class="fs-26px" icon="solar:phone-calling-outline"></iconify-icon>
						</a>
						<a href="#" class="widget-chat-toolbar-link">
							<iconify-icon class="fs-26px" icon="solar:videocamera-record-outline"></iconify-icon>
						</a>
					</div>
					<textarea class="form-control"></textarea>
				</div>
				<!-- END widget-input -->
			</div>
		</div>
	</div>
@endsection
@extends('layouts.default')

@section('title', 'Calendar')

@push('scripts')
	<script src="/assets/plugins/moment/moment.js"></script>
	<script src="/assets/plugins/@fullcalendar/core/index.global.js"></script>
	<script src="/assets/plugins/@fullcalendar/daygrid/index.global.js"></script>
	<script src="/assets/plugins/@fullcalendar/timegrid/index.global.js"></script>
	<script src="/assets/plugins/@fullcalendar/interaction/index.global.js"></script>
	<script src="/assets/plugins/@fullcalendar/list/index.global.js"></script>
	<script src="/assets/plugins/@fullcalendar/bootstrap/index.global.js"></script>
	<script src="/assets/js/demo/calendar.demo.js"></script>
@endpush

@section('content')
	<!-- BEGIN breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
		<li class="breadcrumb-item active">Calendar</li>
	</ol>
	
	<hr />
	<!-- BEGIN row -->
	<div class="row mb-2">
		
		<!-- BEGIN event-list -->
		<div class="d-none d-lg-block" style="width: 100px">
			<div id="external-events" class="fc-event-list">
				<!--
				<h5 class="mb-3">Draggable Events</h5>
				<div class="fc-event" data-color="#00acac">
					<div class="fc-event-text">Meeting with Client</div>
					<div class="fc-event-icon"><i class="fas fa-circle fa-fw fs-9px text-success"></i></div>
				</div>
				<div class="fc-event" data-color="#348fe2">
					<div class="fc-event-text">IOS App Development</div>
					<div class="fc-event-icon"><i class="fas fa-circle fa-fw fs-9px text-blue"></i></div>
				</div>
				<div class="fc-event" data-color="#f59c1a">
					<div class="fc-event-text">Group Discussion</div>
					<div class="fc-event-icon"><i class="fas fa-circle fa-fw fs-9px text-warning"></i></div>
				</div>
				<div class="fc-event" data-color="#ff5b57">
					<div class="fc-event-text">New System Briefing: hi</div>
					<div class="fc-event-icon"><i class="fas fa-circle fa-fw fs-9px text-danger"></i></div>
				</div>
				<div class="fc-event">
					<div class="fc-event-text">Brainstorming</div>
					<div class="fc-event-icon"><i class="fas fa-circle fa-fw fs-9px text-dark"></i></div>
				</div>
				-->
				<!---
				<hr class="bg-grey-lighter my-3" />
				<h5 class="mb-3">Other Events</h5>
				<div class="fc-event" data-color="#b6c2c9">
					<div class="fc-event-text">Other Event 1</div>
					<div class="fc-event-icon"><i class="fas fa-circle fa-fw fs-9px text-gray-500"></i></div>
				</div>
				<div class="fc-event" data-color="#b6c2c9">
					<div class="fc-event-text">Other Event 2</div>
					<div class="fc-event-icon"><i class="fas fa-circle fa-fw fs-9px text-gray-500"></i></div>
				</div>
				<div class="fc-event" data-color="#b6c2c9">
					<div class="fc-event-text">Other Event 3</div>
					<div class="fc-event-icon"><i class="fas fa-circle fa-fw fs-9px text-gray-500"></i></div>
				</div>
				<div class="fc-event" data-color="#b6c2c9">
					<div class="fc-event-text">Other Event 4</div>
					<div class="fc-event-icon"><i class="fas fa-circle fa-fw fs-9px text-gray-500"></i></div>
				</div>
				<div class="fc-event" data-color="#b6c2c9">
					<div class="fc-event-text">Other Event 5</div>
					<div class="fc-event-icon"><i class="fas fa-circle fa-fw fs-9px text-gray-500"></i></div>
				</div>
				-->
			</div>
		</div>
		<!-- END event-list -->
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-12">

					<div id="calendar"></div>
				</div>
			</div>
		</div>
		
	</div>
	<!-- END row -->


	<!-- View Activity Modal -->
<div class="modal fade" id="viewActivityModal" tabindex="-1" aria-labelledby="viewActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewActivityModalLabel">Activity Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="activity-content">
                    <div class="text-center p-4">
                        <i class="fa fa-spinner fa-spin fa-2x"></i> Loading details...
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
           </div>
        </div>
    </div>
</div>
@endsection

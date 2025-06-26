@extends('layouts.default')

@section('title', 'Calendar')

@push('scripts')
<script src="{{ asset('assets/plugins/moment/moment.js') }}"></script>
<script src="{{ asset('assets/plugins/@fullcalendar/core/index.global.js') }}"></script>
<script src="{{ asset('assets/plugins/@fullcalendar/daygrid/index.global.js') }}"></script>
<script src="{{ asset('assets/plugins/@fullcalendar/timegrid/index.global.js') }}"></script>
<script src="{{ asset('assets/plugins/@fullcalendar/interaction/index.global.js') }}"></script>
<script src="{{ asset('assets/plugins/@fullcalendar/list/index.global.js') }}"></script>
<script src="{{ asset('assets/plugins/@fullcalendar/bootstrap/index.global.js') }}"></script>
<script src="{{ asset('assets/js/demo/calendar.demo.js') }}"></script>
<script>
    window.AppData = {
        baseUrl: "{{ url('/') }}", // e.g., http://127.0.0.1:8000 or https://yourdomain.com
    };
</script>
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



<!-- View Appeal Modal -->
<div class="modal fade" id="viewAppealModal" tabindex="-1" aria-labelledby="viewAppealModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewAppealModalLabel">Appeal Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="appeal-content">
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
<!-- View Adjourn Modal -->
<div class="modal fade" id="viewAdjournModal" tabindex="-1" aria-labelledby="viewAdjournModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewAdjournModalLabel">Adjourn Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="adjourn-content">
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
<!-- View preparation Modal -->
<div class="modal fade" id="viewPreparationModal" tabindex="-1" aria-labelledby="viewPreparationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewPreparationModalLabel">Preparation Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="preparation-content">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Case ID:</strong> <span id="preparation-case-id"></span></p>
                            <p><strong>Preparation Name:</strong> <span id="preparation-name"></span></p>
                            <p><strong>Phone:</strong> <span id="preparation-phone"></span></p>
                            <p><strong>Email:</strong> <span id="preparation-email"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Availability:</strong> <span id="preparation-availability"></span></p>
                            <p><strong>Preparation Statement:</strong></p>
                            <p id="preparation-statement" class="border p-2 bg-light"></p>
                            <p><strong>Created At:</strong> <span id="preparation-created-at"></span></p>
                            <p><strong>Updated At:</strong> <span id="preparation-updated-at"></span></p>
                        </div>
                    </div>

                    <!-- Attachments Section -->
                    <div class="mt-3">
                        <h5>Attachments</h5>
                        <ul id="preparation-attachments" class="list-group"></ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- View trial Modal -->
<div class="modal fade" id="viewTrialModal" tabindex="-1" aria-labelledby="viewTrialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewTrialModalLabel">Trial Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="trial-content">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Case ID:</strong> <span id="trial-case-id"></span></p>
                            <p><strong>Trial Name:</strong> <span id="trial-name"></span></p>
                            <p><strong>Phone:</strong> <span id="trial-phone"></span></p>
                            <p><strong>Email:</strong> <span id="trial-email"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Availability:</strong> <span id="trial-availability"></span></p>
                            <p><strong>Trial Statement:</strong></p>
                            <p id="trial-statement" class="border p-2 bg-light"></p>
                            <p><strong>Created At:</strong> <span id="trial-created-at"></span></p>
                            <p><strong>Updated At:</strong> <span id="trial_updated-at"></span></p>
                        </div>
                    </div>

                    <!-- Attachments Section -->
                    <div class="mt-3">
                        <h5>Attachments</h5>
                        <ul id="trial-attachments" class="list-group"></ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- View   appointmentce Modal -->
<div class="modal fade" id="viewAppointmentModal" tabindex="-1" aria-labelledby="viewaAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewAppointmentModalLabel">Briefing Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="appointment-content">
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

<!-- View   Advice Modal -->
<div class="modal fade" id="viewAdviceModal" tabindex="-1" aria-labelledby="viewAdviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewAdviceModalLabel">Advice Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="advice-content">
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

<!-- View Payment Modal -->
<div class="modal fade" id="viewPaymentModal" tabindex="-1" aria-labelledby="viewPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewPaymentModalLabel">Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="payment-content">
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


<!-- View Payment Modal -->
<div class="modal fade" id="viewPaymentModal" tabindex="-1" aria-labelledby="viewPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewPaymentModalLabel">Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="payment-content">
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


<!-- View PreTrial Modal -->
<div class="modal fade" id="viewPreTrialModal" tabindex="-1" aria-labelledby="viewPreTrialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewPreTrialModalLabel">Pre-Trial Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="pretrial-content">
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

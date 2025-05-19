@extends('layouts.default')

@section('title', 'Negotiations List')


@push('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endpush
@push('styles')
<style>
    .panel-title {
        font-size: 18px;
        font-weight: bold;
    }
    .table thead th {
        background-color: #3c3440;
        color: white;
        text-align: center;
    }
    .table tbody td {
        vertical-align: middle;
    }
    .action-buttons a, .action-buttons form {
        display: inline-block;
        margin-right: 5px;
    }
 .dataTables_filter input {
        border-radius: 20px;
        padding: 8px 16px;
        border: 5px solid #d109d8;
        box-shadow: none;
        outline: none;
        transition: border-color 0.3s ease-in-out;
        width: 250px; /* 👈 You can increase this */
        max-width: 100%; /* Make sure it doesn’t overflow on smaller screens */
    }

    /* Optional: Highlight on focus */
    .dataTables_filter input:focus {
        border-color: #0db1fd;
    }


</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

@endpush


@section('content')
<div class="container-fluid">
    @php
    use Illuminate\Support\Str;
    @endphp
    
    <div class="mt-4">
    <h1 class="page-header">Negotiations</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading d-flex justify-content-between align-items-center">
            <!-- Back to Cases Button (Left) -->
            <a href="{{ url('/cases') }}" class="btn btn-dark btn-sm d-flex align-items-center gap-2">
                <i class="fa fa-arrow-left text-white fw-bold"></i> <span class="text-white">Back to Cases</span>
            </a>

            <!-- Add New Negotiation Button (Right) -->
            <div class="panel-heading-btn">
                <button class="btn btn-success btn-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addNegotiationModal">
                    <i class="fa fa-plus text-white"></i> <span class="text-white">Add New Negotiation</span>
                </button>
            </div>
        </div>


       

        <div class="panel-body">
            @if(request()->has('message'))
            <div id="success-alert" class="alert alert-success flex-grow-1 mx-3 text-center">
                    {{ request()->get('message') }}
            </div>
            <script>
                setTimeout(function () {
                    document.getElementById('success-alert').style.display = 'none';
                }, 5000); // 5000ms = 5 seconds
            </script>
            @endif

            @if(session('success'))
                    <div id="success-alert" class="alert alert-success flex-grow-1 mx-3 text-center">
                                {{ session('success') }}
                    </div>
                
                    <script>
                        setTimeout(function () {
                            document.getElementById('success-alert').style.display = 'none';
                        }, 5000); // 5000ms = 5 seconds
                    </script>
            @endif
            @if(session('error'))
                    <div id="error-alert" class="alert alert-danger flex-grow-1 mx-3 text-center">
                                {{ session('error') }}
                    </div>
                
                    <script>
                        setTimeout(function () {
                            document.getElementById('error-alert').style.display = 'none';
                        }, 5000); // 5000ms = 5 seconds
                    </script>
            @endif
            <div class="table-responsive">
                <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <tr>
                                <th>Number</th>
                                <th>Case Name</th>
                                <th>Method</th>
                                <th>Subject</th>
                                <th>Outcome</th>
                                <th>Initiation Date</th>
                                <th>Panel Evaluation</th>
                                <th>Action</th>
                            </tr>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($negotiations as $negotiation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($negotiation->caseRecord)
                                    <a href="{{ route('cases.show', $negotiation->caseRecord->case_id) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center" title="View Case">
                                        <i class="fa fa-eye me-1"></i> {{ $negotiation->caseRecord->case_name }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>

                            <td>{{ $negotiation->negotiation_method }}</td>
                            <td>{{ $negotiation->subject }}</td>
                            <td>{{ $negotiation->outcome }}</td>
                            <td>{{ $negotiation->initiation_datetime }}</td>
                            <td>
                                @if($negotiation->caseRecord)
                                    <div class="d-flex flex-wrap gap-2">
                                        <!-- Panel Evaluation Button -->
                                        <a href="{{ route('cases.panelEvaluation', $negotiation->caseRecord->case_id) }}" 
                                           class="btn btn-sm btn-outline-success d-inline-flex align-items-center" 
                                           title="Submit for Panel Evaluation">
                                            <i class="fa fa-gavel me-1"></i> Panel Evaluation
                                        </a>

                                        <!-- Close Case Button -->
                                        <a href="{{ route('closed_cases.create', $negotiation->caseRecord->case_id) }}" 
                                           class="btn btn-sm btn-outline-danger d-inline-flex align-items-center" 
                                           title="Close Case">
                                            <i class="fa fa-lock me-1"></i> Close Case
                                        </a>
                                    </div>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>


                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    <!-- View Button -->
                                    <a href="{{ route('negotiations.show', $negotiation) }}" 
                                       class="btn btn-info btn-sm d-inline-flex align-items-center gap-1" 
                                       title="View Details">
                                        <i class="fa fa-eye"></i> <span>View</span>
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('negotiations.edit', $negotiation) }}" 
                                       class="btn btn-warning btn-sm d-inline-flex align-items-center gap-1" 
                                       title="Edit Negotiation">
                                        <i class="fa fa-edit"></i> <span>Edit</span>
                                    </a>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
             
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="addNegotiationModal" tabindex="-1" aria-labelledby="addNegotiationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color: rgb(1, 9, 12)" id="addNegotiationModalLabel">Create New Negotiation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!--action="// //route('negotiations.checkCase') }}"-->
                            <form id="checkCaseForm">
                                @csrf
                                <div class="form-group">
                                    <label for="evaluation_case_id" style="color: rgb(1, 9, 12)">Select Case <span class="text-danger">*</span></label>
                                    <select name="case_id" id="evaluation_case_id" class="form-control" required>
                                       
                                        <!-- Options will be populated via AJAX -->
                                    </select>
                                 </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Create Negotiation</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>




@endsection

@prepend('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
    
@endprepend

@push('scripts')
<script>
     $(document).ready(function () {
    let tomSelectInstance;

    $('#addNegotiationModal').on('shown.bs.modal', function () {
        let caseSelect = $('#evaluation_case_id');

        // If already initialized, destroy previous Tom Select instance
        if (tomSelectInstance) {
            tomSelectInstance.destroy();
            tomSelectInstance = null;
        }

        caseSelect.empty().append('<option value="">Loading cases...</option>');

        $.ajax({
            url: "{{ route('cases.available-evaluation-cases') }}",
            type: "GET",
            success: function (response) {
                caseSelect.empty();
               caseSelect.append('<option value="">Select Case</option>');

                $.each(response, function (index, caseItem) {
                    caseSelect.append(
                        `<option value="${caseItem.case_number}">${caseItem.display_name}</option>`
                    );
                });

                // Reinitialize Tom Select *after* options are loaded
                tomSelectInstance = new TomSelect('#evaluation_case_id', {
                    placeholder: "Select Case",
                    allowEmptyOption: true,
                    maxOptions: 500
                });
            },
            error: function () {
                caseSelect.empty().append('<option value="">Failed to load cases</option>');
                alert("Failed to fetch cases. Please try again.");
            }
        });
    });
});

    $(document).ready(function () {
        $(document).on('submit', '#checkCaseForm', function (e) {
            e.preventDefault(); // Prevent default form submission
    
            let caseNumber = $('#evaluation_case_id').val(); 
    
            $.ajax({
                url: "{{ route('negotiations.checkCase') }}", 
                type: "GET", 
                data: { case_number: caseNumber }, 
                success: function (response) {
                    if (response.exists) {
                        if (response.negotiation) {
                            // Redirect to negotiations.edit if negotiation exists
                            window.location.href = response.negotiation.edit_url;
                        } else {
                            // Redirect to negotiations.create if no negotiation exists
                            window.location.href = "{{ route('negotiations.create', ':case_id') }}"
                                .replace(':case_id', response.case_id) + 
                                "?case_name=" + encodeURIComponent(response.case_name);
                        }
                    } else {
                        // Show error message inside modal
                        $('.modal-body').html('<p class="text-danger text-center">Case number does not exist.</p>');
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: xhr.responseJSON ? xhr.responseJSON.message : "Something went wrong!"
                    });
                }
            });
        });
    });
    </script>
    
     
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#data-table').DataTable(
            {
            pageLength: 5,
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            
        }
        );
    });
</script> 
    
    
@endpush
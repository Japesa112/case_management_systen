@extends('layouts.default')

@section('title', 'Offers List')

@push('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush

@push('styles')
<style>
.dataTables_filter {
        margin-bottom: 20px; /* Adjust this value as needed */
        margin-right: 20px;
       
    }
     /* Make the search input rounded */
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
    use Illuminate\Support\Facades\Auth;
    use App\Models\Forwarding;
    $isLawyer = Auth::user() && Auth::user()->role === 'Lawyer'; 
    @endphp
    
    <div class="mt-4">
        <h1 class="page-header">Lawyers' Offers</h1>
        <div class="panel panel-inverse">
            <div class="panel-heading d-flex justify-content-between align-items-center">
                @if ($isLawyer)
                <a href="{{ url('/cases') }}" class="btn btn-dark btn-sm d-flex align-items-center gap-2">
                <i class="fa fa-arrow-left text-white fw-bold"></i> <span class="text-white">Back to Cases</span>
            </a>
               
                @else

                <a href="{{ url('/cases') }}" class="btn btn-dark btn-sm d-flex align-items-center gap-2">
                <i class="fa fa-arrow-left text-white fw-bold"></i> <span class="text-white">Back to Cases</span>
                </a>
              <div class="panel-heading-btn d-flex gap-2 flex-wrap">
                <!-- Add New Evaluation Button -->
                <button class="btn btn-success btn-sm d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#addEvaluationModal">
                    <i class="fa fa-plus"></i> <span>Add New Offer</span>
                </button>

               <!-- Seek AG Advice Button -->
            <button class="btn btn-secondary btn-sm d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#agAdviceModal">
                <i class="fa fa-envelope-open-text"></i> <span>Seek AG Advice</span>
            </button>

            </div>

                
                @endif

            </div>
            
            <!-- Panel Body -->
            <div class="panel-body">
                @if(session('success'))
                    <div id="success-alert" class="alert alert-success flex-grow-1 mx-3 text-center">
                        {{ session('success') }}
                    </div>
                    <script>
                        setTimeout(function () {
                            document.getElementById('success-alert').style.display = 'none';
                        }, 5000);
                    </script>
                @endif

                @if(session('error'))
                    <div id="error-alert" class="alert alert-danger flex-grow-1 mx-3 text-center">
                        {{ session('error') }}
                    </div>
                    <script>
                        setTimeout(function () {
                            document.getElementById('error-alert').style.display = 'none';
                        }, 5000);
                    </script>
                @endif
                

                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Case Name</th>
                                <th>Lawyer</th>
                                <th>Evaluation Date</th>
                                <th>Comments</th>
                                <th>Outcome</th>
                                <th>Forward</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($evaluations as $evaluation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                               

                                <td>
                                @if($evaluation->case)
                                    <a href="{{ route('cases.show', $evaluation->case->case_id) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center" title="View Case">
                                        <i class="fa fa-eye me-1"></i> {{ $evaluation->case->case_name }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                                 </td>

                                <td>{{ $evaluation->user->full_name ?? 'N/A' }}
                                </td>
                                <td>{{ $evaluation->evaluation_date }}</td>
                                <td>{{ Str::limit($evaluation->comments, 20) }}</td>
                                
                                <td>{{ $evaluation->outcome }}</td>

                               <td>
                                    @php
                                        

                                        $isForwarded = Forwarding::where('evaluation_id', $evaluation->evaluation_id)->exists();
                                        $isLawyer = Auth::check() && Auth::user()->role === 'Lawyer';
                                    @endphp

                                    @if ($isLawyer)
                                        @if ($isForwarded)
                                            <span class="text-muted">Already Forwarded</span>
                                        @else
                                            <span class="text-muted">Not Forwarded</span>
                                        @endif
                                    @else
                                        @if (strtolower($evaluation->outcome) === 'no')
                                            <span class="text-muted">Cannot be forwarded to DVC</span>
                                        @elseif ($isForwarded)
                                            <span class="text-muted">Already Forwarded</span>
                                        @else
                                            <a href="{{ route('dvc_appointments.create', [$evaluation->case->case_id, $evaluation->evaluation_id]) }}"
                                               title="Forward to DVC"
                                               class="text-decoration-none text-purple">
                                                <i class="fa fa-edit me-1"></i> Forward to DVC
                                            </a>
                                        @endif
                                    @endif
                                </td>


                                
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        <!-- View Button (Modal trigger) -->
                                        <button 
                                            class="btn btn-info btn-sm d-inline-flex align-items-center gap-1 view-evaluation" 
                                            data-bs-target="#viewEvaluationModal" 
                                            data-id="{{ $evaluation->evaluation_id }}" 
                                            title="View Details">
                                            <i class="fa fa-eye"></i> <span>View</span>
                                        </button>

                                        <!-- Edit Button -->
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


                <!-- Modal -->
 <div class="modal fade" id="addEvaluationModal" tabindex="-1" aria-labelledby="addEvaluationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="addEvaluationModalLabel">Create New Evaluation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
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
            <button type="submit" class="btn btn-primary">Create Evaluation</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- View Evaluation Modal -->
<div class="modal fade" id="viewEvaluationModal" tabindex="-1" aria-labelledby="viewEvaluationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Large modal for better view -->
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewEvaluationModalLabel">Evaluation Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="evaluation-content">
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

<div class="modal fade" id="agAdviceModal" tabindex="-1" aria-labelledby="agAdviceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title" id="agAdviceModalLabel">Seek AG Advice</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <form id="agAdviceForm">
          @csrf
          <div class="form-group">
            <label for="ag_case_id" class="form-label">Select Case <span class="text-danger">*</span></label>
            <select name="case_number" id="ag_case_id" class="form-control" required>
              <option value="">Loading cases...</option>
            </select>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Continue</button>
          </div>
        </form>
      </div>
      
    </div>
  </div>
</div>

@endsection

@push('scripts')

<script>
    $(document).ready(function () {
        $(document).on('click', '.view-evaluation', function () {
            let evaluationId = $(this).data('id');
    
            // Show the modal
            $('#viewEvaluationModal').modal('show');
    
            // Display a loading indicator
            $('#evaluation-content').html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading details...</div>');
    
            // Fetch evaluation details
            $.ajax({
                url: "{{ route('evaluations.show', ':id') }}".replace(':id', evaluationId),
                type: "GET",
                success: function (response) {
                    let evaluation = response.evaluation;
    
                    let content = `
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Case Name:</strong> ${evaluation.case_name ?? 'N/A'}<br>
                                <strong>Lawyer:</strong> ${evaluation.lawyer_name ?? 'N/A'}<br>
                                <strong>Evaluation Date:</strong> ${evaluation.evaluation_date ?? 'N/A'}<br>
                                <strong>Evaluation Time:</strong> ${evaluation.evaluation_time ?? 'N/A'}<br>

                                <strong>Quote:</strong> ${evaluation.quote ?? 'N/A'}<br>
                            </div>
                            <div class="col-md-6">
                                <strong>Outcome:</strong> ${evaluation.outcome ?? 'N/A'}<br>

                                <strong>Worked Before:</strong> ${evaluation.worked_before ?? 'N/A'}<br>
                                <strong>Pager:</strong> ${evaluation.pager ? evaluation.pager.substring(0, 50) : 'N/A'}<br>
                                <strong>Comments:</strong> <p>${evaluation.comments ?? 'N/A'}</p>
                            </div>
                        </div>
                    `;
    
                    $('#evaluation-content').html(content);
                },
                error: function () {
                    $('#evaluation-content').html('<div class="text-danger text-center">Error loading evaluation details.</div>');
                }
            });
        });
    });
    </script>



<script>
    $(document).ready(function () {
        $(document).on('submit', '#checkCaseForm', function (e) {
            e.preventDefault(); // Prevent default form submission
    
          let caseNumber = $('#evaluation_case_id').val(); 
          // This will give you the selected case_number

    
            $.ajax({
                url: "{{ route('evaluations.checkCase') }}", 
                type: "GET", 
                data: { case_number: caseNumber }, 
                success: function (response) {
                    if (response.exists) {
                        if (response.evaluation) {
                            // Redirect to evaluations.edit if evaluation exists
                            window.location.href = response.evaluation.edit_url;
                        } else {
                            // Redirect to evaluations.create if no evaluation exists
                            window.location.href = "{{ route('evaluations.create', ':case_id') }}"
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

<script>
$(document).ready(function () {
    let tomSelectInstance;

    $('#addEvaluationModal').on('shown.bs.modal', function () {
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

let agCaseSelect;

$(document).ready(function () {
    $('#agAdviceModal').on('shown.bs.modal', function () {
        const caseSelect = $('#ag_case_id');

        // Destroy if already initialized
        if (agCaseSelect) {
            agCaseSelect.destroy();
        }

        caseSelect.empty().append('<option value="">Loading cases...</option>');

        $.ajax({
            url: "{{ route('cases.available-evaluation-cases') }}",
            type: "GET",
            success: function (response) {
                caseSelect.empty().append('<option value="">Select Case</option>');

                $.each(response, function (index, caseItem) {
                    caseSelect.append(
                        `<option value="${caseItem.case_id}">${caseItem.display_name}</option>`
                    );
                });

                // Initialize Tom Select after populating options
                agCaseSelect = new TomSelect("#ag_case_id", {
                    placeholder: "Select Case",
                    maxOptions: 500,
                    allowEmptyOption: true,
                });
            },
            error: function () {
                caseSelect.empty().append('<option value="">Failed to load cases</option>');
                alert("Failed to fetch cases. Please try again.");
            }
        });
    });

    $('#agAdviceForm').on('submit', function (e) {
        e.preventDefault();
        const caseNumber = $('#ag_case_id').val();

        if (!caseNumber) {
            alert("Please select a case.");
            return;
        }

        window.location.href = `/ag_advice/create/{case_id}${caseNumber}`;


    });
});

</script>

@endpush

@extends('layouts.default')

@section('title', 'Evaluations List')

@push('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush

@section('content')
<div class="container-fluid">
    @php
    use Illuminate\Support\Str;
    $isLawyer = Auth::user() && Auth::user()->role === 'Lawyer'; 
    @endphp
    
    <div class="mt-4">
        <h1 class="page-header">Evaluations</h1>
        <div class="panel panel-inverse">
            <div class="panel-heading">
                @if ($isLawyer)
                <h4 class="panel-title">My Evaluation List</h4>
               
                @else

                <h4 class="panel-title">Evaluation List</h4>
                <div class="panel-heading-btn">
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addEvaluationModal">
                        <i class="fa fa-plus"></i> Add New Evaluation
                    </button>
                </div>
                
                @endif

                <!-- Modal -->
                <div class="modal fade" id="addEvaluationModal" tabindex="-1" aria-labelledby="addEvaluationModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" style="color: rgb(1, 9, 12)" id="addEvaluationModalLabel">Create New Evaluation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="checkCaseForm">
                                    @csrf
                                    <div class="form-group">
                                        <label for="case_number" style="color: rgb(1, 9, 12)">Case Number <span class="text-danger">*</span></label>
                                        <input type="text" name="case_number" id="case_number" class="form-control" required>
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
                    <table class="table table-bordered table-striped">
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
                                <td>{{ $evaluation->case->case_name ?? 'N/A' }}</td>
                                <td>{{ $evaluation->user->full_name ?? 'N/A' }}
                                </td>
                                <td>{{ $evaluation->evaluation_date }}</td>
                                <td>{{ Str::limit($evaluation->comments, 30) }}</td>
                                
                                <td>{{ $evaluation->outcome }}</td>

                                <td>
                                    @if(strtolower($evaluation->outcome) === 'no')
                                        <span class="text-muted">Cannot be forwarded to DVC</span>
                                    @else
                                        <a href="{{ route('dvc_appointments.create',  [$evaluation->case->case_id, $evaluation->evaluation_id]) }}" title="Forward to DVC" class="text-decoration-none text-purple">
                                            <i class="fa fa-edit me-1"></i> Forward to DVC
                                        </a>
                                    @endif
                                </td>
                                
                                
                                <td>
                                    <button class="btn btn-info btn-sm view-evaluation" data-bs-target="#viewEvaluationModal" data-id="{{ $evaluation->evaluation_id }}" title="View Details">
                                        <i class="fa fa-eye"></i> View
                                    </button>
                                    <a href="{{ route('evaluations.edit', $evaluation) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            {{ $evaluations->links('vendor.pagination.bootstrap-4') }}
                        </ul>
                    </nav>
                </div>
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
    
            let caseNumber = $('#case_number').val();
    
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
@endpush

@extends('layouts.default')
@section('title', 'Case Details')

@section('content')
@push('styles')
/* CSS for Text Truncation */
.btn.text-truncate {
    white-space: nowrap; 
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Show full text on hover */
.btn:hover {
    white-space: normal; /* Allow wrapping on hover */
    overflow: visible;   /* Make sure text can be shown */
    text-overflow: unset; /* Remove ellipsis */
}

@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
@endpush
<div class="container mt-3"> <!-- Added space at the top -->
    @php
    
    $isLawyer = Auth::user() && Auth::user()->role === 'Lawyer'; 
  
    
@endphp
    
@if ($isLawyer)

@else

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif

<!-- Action Buttons Card (Spans Full Width) -->

<div class="card shadow-lg mb-3"> 
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-2 mb-2">
                <button class="btn btn-info btn-sm w-100 text-start text-truncate assign-case" title="Assign Case"
                 data-bs-toggle="modal" 
                    data-bs-target="#assignCaseModal"
                    data-case-id="{{ $case->case_id }}"
                    data-case-number="{{ $case->case_number }}"
                    data-case-name="{{ $case->case_name }}"
                    data-case-category="{{ $case->case_category }}"
                    data-case-status="{{ $case->case_status }}"
                    data-initial-status="{{ $case->initial_status }}"
                    data-first-hearing-date="{{ $case->first_hearing_date }}"
                    data-date-received="{{ $case->date_received }}"
                    data-case-description="{{ $case->case_description }}"
                
                >Assign Case</button>
            </div>
            @if ($case->case_status != "Closed")
            <div class="col-md-2 mb-2">
                <a href="{{ route("closed_cases.create", $case->case_id) }}" class="btn btn-danger btn-sm w-100 text-start text-truncate" title="Close Case">Close Case</a>
            </div>
            @else
            
            <div class="col-md-2 mb-2">
                <a href="{{ route("closed_cases.create", $case->case_id) }}" class="btn btn-info btn-sm w-100 text-start text-truncate" title="Close Case"  style="pointer-events: none; color: gray;">Cased Closed</a>
            </div>
            @endif
            

            @if ( $case->case_status == "Panel Evaluation")
            <div class="col-md-2 mb-2">
                <button id="submitEvaluationBtn"
                        data-case-id="{{ $case->case_id }}"
                        data-case-flag="{{ true }}"
                        class="btn btn-secondary btn-sm w-100 text-start text-truncate"
                        title="Submitted to Panel Evaluation"
                        data-bs-toggle="modal"
                        data-bs-target="#panelEvaluationModal">
                        Message Lawyers
                </button>

            </div>
            @else

            <div class="col-md-2 mb-2">
                <button id="submitEvaluationBtn"
                        data-case-id="{{ $case->case_id }}"
                        class="btn btn-primary btn-sm w-100 text-start text-truncate"
                        title="Submit for Panel Evaluation"
                        data-bs-toggle="modal"
                        data-bs-target="#panelEvaluationModal">
                    Submit for Panel Evaluation
                </button>

            </div>
            
            @endif
            
            
            <div class="col-md-2 mb-2">
                
                 <a href="{{ route('negotiations.create', $case->case_id) }}" class="btn btn-warning btn-sm w-100 text-start text-truncate" title="Send to Negotiation">Send to Negotiation</a>
            </div>
            <div class="col-md-2 mb-2">
                <a href="{{ route('dvc_appointments.create', $case->case_id) }}" class="btn btn-secondary btn-sm w-100 text-start text-truncate" title="Forward to DVC/VC">Forward to DVC/VC</a>
            </div>
            <div class="col-md-2 mb-2">
                <button class="btn btn-dark btn-sm w-100 text-start text-truncate" title="More Actions" data-bs-toggle="modal"
                id="actionCaseModal"
                data-bs-target="#actionModal"   
                data-case-id="{{ $case->case_id }}" data-case-name="{{ $case->case_name }}" data-case-number="{{ $case->case_number }}"  
                >
                    More Actions
                </button>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Modal Dialog: Manage Activities -->
<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actionModalLabel">Manage Case Activities</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Add Actions Column -->
                    <div class="col-4">
                        <h6>Add Actions</h6>

                        

                        <div class="d-grid gap-2">
                            <!-- Add Hearing Button -->
                        <button class="btn btn-primary" id="addHearingBtn" data-case-id="" data-case-name=""  data-bs-toggle="modal" data-bs-target="#addHearingModal">
                            Add Hearing
                        </button>
                        
                        <button class="btn btn-primary" id="addMentionBtn" data-case-id="" data-case-name=""  data-bs-toggle="modal" data-bs-target="#addMentionModal">Add Mention</button>
                        
                        <button class="btn btn-primary" id="addApplicationBtn" data-case-id="" data-case-name=""  data-bs-toggle="modal" data-bs-target="#addApplicationModal">Add Application</button>
                        </div>
                    </div>

                    <!-- Update Actions Column -->
                    <div class="col-4">
                        <h6>Update Actions</h6>
                        <div class="d-grid gap-2">
                            <button class="btn btn-warning" id="updateHearingBtn" data-case-id="" data-case-name="">Update Hearing</button>
                            <button class="btn btn-warning" id="updateMentionBtn" data-case-id="" data-case-name="" >Update Mention</button>
                            <button class="btn btn-warning" id="updateApplicationBtn" data-case-id="" data-case-name="">Update Application</button>
                        </div>
                    </div>

                    <!-- Delete Actions Column -->
                    <div class="col-4">
                        <h6>Delete Actions</h6>
                        <div class="d-grid gap-2">
                            <button class="btn btn-danger" id="deleteHearingBtn" data-case-id="" data-case-name="">Delete Hearing</button>
                            <button class="btn btn-danger" id="deleteMentionBtn" data-case-id="" data-case-name="">Delete Mention</button>
                            <button class="btn btn-danger" id="deleteApplicationBtn" data-case-id="" data-case-name="">Delete Application</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>








    <div class="row justify-content-center pt-3">
        <!-- Left Side: Case Details (Bigger Column) -->
        <div class="col-lg-7 col-md-6 col-12 mb-4">
<div class="card shadow-lg">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Case Details</h4>
        @php
            switch ($case->case_status) {
                case 'open': $bgColor = 'background-color: green; color: white;'; break;
                case 'closed': $bgColor = 'background-color: #dc3545; color: white;'; break;
                case 'pending': $bgColor = 'background-color: #ffc107; color: black;'; break;
                default: $bgColor = 'background-color: #6c757d; color: white;';
            }
        @endphp
        <span style="{{ $bgColor }} padding: 5px 10px; border-radius: 5px;">
            @if (!empty($case->seq_num) && !empty($case->seq_suffix))
            {{ $case->seq_num }}<sup>{{ $case->seq_suffix }}</sup> {{ ucfirst($case->type)." ".$case->matter }} 
        @else
            {{ ucfirst($case->case_status) }}
        @endif
        </span>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Left Column: Case Details -->
            <div class="col-md-7">
                <h5><strong>Case Number:</strong> <span id="case_number_display">{{ $case->case_number }}</span></h5>
                <h5><strong>Title:</strong> <span id="case_name_display">{{ $case->case_name }}</span></h5>
                <p><strong>Description:</strong></p>
                <p id="case_description_display">{{ $case->case_description }}</p>
                <p><strong>Received Date:</strong> <span id="date_received_display">{{ $case->date_received }}</span></p>
                <p><strong>Category:</strong> <span id="case_category_display">{{ ucfirst($case->case_category) }}</span></p>
                <p><strong>Initial Status:</strong> <span id="initial_status_display">{{ ucfirst($case->initial_status) }}</span></p>
                <p class="text-muted">
                    Created at: {{ $case->created_at->format('F d, Y h:i A') }} <br>
                    Last updated: <span id="updated_at_display">{{ $case->updated_at->diffForHumans() }}</span>
                </p>
            </div>

            <!-- Right Column: Action Buttons with Vertical Line -->
            
            @if ($isLawyer)
            @php
              $lawyer_id = Auth::user()->lawyer->lawyer_id;
              $lawyer_name =  Auth::user()->full_name;
             
            @endphp
            <div class="col-md-5 border-start">
                <div class="text-center align-center items-center mt-5">
                    <div class="mt-5">
                       
                    <button 
                    id="evaluateCaseBtn"                     
                    class="btn btn-success btn-sm w-75 mx-auto mt-4 evaluate-case" 
                        data-case-id="{{ $case->case_id }}" 
                        data-case-name="{{ $case->case_name }}"
                        data-lawyer-id="{{ $lawyer_id }}" 
                        data-lawyer-name="{{ $lawyer_name }}">
                        Evaluate this Case
                    </button>

                    
                    
                    
                    </div>
                    
                   
                  
                </div>
            </div>
            @else
                
            @endif

             
            
        </div>
    </div>

    <div class="card-footer d-flex justify-content-between">
        @if ($isLawyer)
            
        
        <a href="{{ route('cases.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        @else
        <a href="{{ route('cases.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>

        <a href="#" 
            class="btn btn-warning edit-case" 
            data-bs-toggle="modal" 
            data-bs-target="#editCaseModal"
            data-case-id="{{ $case->case_id }}"
            data-case-number="{{ $case->case_number }}"
            data-case-name="{{ $case->case_name }}"
            data-case-category="{{ $case->case_category }}"
            data-case-status="{{ $case->case_status }}"
            data-initial-status="{{ $case->initial_status }}"
            data-first-hearing-date="{{ $case->first_hearing_date }}"
            data-date-received="{{ $case->date_received }}"
            data-case-description="{{ $case->case_description }}">
            <i class="fas fa-edit"></i> Update
        </a>
        @endif
    </div>
</div>



        </div>

        <!-- Case Update Modal -->
        <!-- Edit Case Modal -->
        <!-- Edit Case Modal -->
            <div class="modal fade" id="editCaseModal" tabindex="-1" aria-labelledby="editCaseModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCaseModalLabel">Edit Case Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="updateCaseForm">
                                <input type="hidden" id="modal_case_id" name="case_id">

                                <!-- Form Section -->
                                <div class="form-section current">
                                    
                                    <!-- Case Number & Case Name -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mt-3 mb-2">
                                                <label for="modal_case_number" class="control-label">Case Number</label>
                                                <input type="text" id="modal_case_number" name="case_number" class="form-control" placeholder="Enter case number" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mt-3 mb-2">
                                                <label for="modal_case_name" class="control-label">Case Name</label>
                                                <input type="text" id="modal_case_name" name="case_name" class="form-control" placeholder="Enter case name" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Case Category & Case Status -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mt-3 mb-2">
                                                <label for="modal_case_category" class="control-label">Case Category</label>
                                                <select id="modal_case_category" name="case_category" class="form-control">
                                                    <option value="Academic">Academic</option>
                                                    <option value="Disciplinary">Disciplinary</option>
                                                    <option value="Administrative">Administrative</option>
                                                    <option value="student">Student</option>
                                                    <option value="staff">Staff</option>
                                                    <option value="supplier">Supplier</option>
                                                    <option value="staff union">Staff Union</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mt-3 mb-2">
                                                <label for="modal_case_status" class="control-label">Case Status</label>
                                                <select id="modal_case_status" name="case_status" class="form-control">
                                                    <option value="Waiting for First Hearing">Waiting for First Hearing</option>
                                                    <option value="Under Review">Under Review</option>
                                                    <option value="Waiting for Panel Evaluation">Waiting for Panel Evaluation</option>
                                                    <option value="Waiting for AG Advice">Waiting for AG Advice</option>
                                                    <option value="Forwarded to DVC">Forwarded to DVC</option>
                                                    <option value="Under Trial">Under Trial</option>
                                                    <option value="Judgement Rendered">Judgement Rendered</option>
                                                    <option value="Closed">Closed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Initial Status, First Hearing Date & Date Received -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mt-3 mb-2">
                                                <label for="modal_initial_status" class="control-label">Initial Status</label>
                                                <select id="modal_initial_status" name="initial_status" class="form-control">
                                                    <option value="Under Review">Under Review</option>
                                                    <option value="Approved">Approved</option>
                                                    <option value="Rejected">Rejected</option>
                                                    <option value="Needs Negotiation">Needs Negotiation</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mt-3 mb-2">
                                                <label for="modal_first_hearing_date" class="control-label">First Hearing Date</label>
                                                <input type="date" id="modal_first_hearing_date" name="first_hearing_date" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mt-3 mb-2">
                                                <label for="modal_date_received" class="control-label">Date Received</label>
                                                <input type="date" id="modal_date_received" name="date_received" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-group mt-3 mb-2">
                                        <label for="modal_case_description">Description</label>
                                        <textarea id="modal_case_description" name="case_description" class="form-control"></textarea>
                                    </div>

                                </div>
                                <!-- End Form Section -->

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Case</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--Assign Modal-->
             <div class="modal fade" id="assignCaseModal" tabindex="-1" aria-labelledby="editCaseModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCaseModalLabel">Assign Case</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="assignCaseForm">
                                <input type="hidden" id="modal_assign_case_id" name="case_id">

                                <!-- Form Section -->
                                <div class="form-section current">
                                    
                                    <!-- Case Number & Case Name -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mt-3 mb-2">
                                                <label for="modal_case_number" class="control-label">Case Number</label>
                                                <input type="text" id="modal_assign_case_number" name="case_number" class="form-control" placeholder="Enter case number" readonly disabled>
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                            <div class="form-group mt-3 mb-2">
                                                <label for="modal_case_name" class="control-label">Case Name</label>
                                                <input type="text" id="modal_assign_case_name" name="case_name" class="form-control" placeholder="Enter case name" readonly disabled>
                                            </div>
                                        </div>
                                     <div class="form-group mt-2">
                                    <label for="payment_lawyer">Select Lawyer <span class="text-danger">*</span></label>
                                    <select name="lawyer_id" id="edit_payment_lawyer" class="form-control" required>
                                        <option value="">Select Lawyer</option>
                                        <!-- Lawyers will be dynamically added here -->
                                    </select>
                                </div>
                                       
                                    </div>

                                   

                                </div>
                                <!-- End Form Section -->

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Assign Case</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


           
                        
            <!-- View Assigned Lawyers Modal -->
            <div class="modal fade" id="assignedLawyersModal" tabindex="-1" aria-labelledby="assignCaseModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="assignCaseModalLabel">Assigned Lawyers</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <!-- Assigned Lawyers List -->
                        <div class="mt-4">
                                <h6>Assigned Lawyers</h6>
                                <ul id="assignedLawyersList" class="list-group">
                                    <!-- Assigned lawyers will be dynamically loaded here -->
                                </ul>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="assignAnotherLawyerBtn">Assign Another Lawyer</button>
                        </div>
                    </div>
                </div>
            </div>









        <!-- Right Side: Complainant & Documents (Smaller Column) -->
        <div class="col-lg-5 col-md-6 col-12">
            <!-- Complainant Details (Smaller on top) -->
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Complainant Details</h4>
                     
                                        @if ($isLawyer)
                                            
                                        @else
                                        <!-- Ensure `data-bs-toggle="modal"` and `data-bs-target="#editComplainantModal"` are correctly set -->
                                        <button type="button" class="btn btn-warning btn-sm edit-complainant-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editComplainantModal"
                                        data-id="{{ $complainant->Complainant_id }}"
                                        data-case="{{ $case->case_id }}"
                                        data-name="{{ $complainant->complainant_name }}"
                                        data-phone="{{ $complainant->phone }}"
                                        data-email="{{ $complainant->email }}"
                                        data-address="{{ $complainant->address }}">
                                         <i class="fas fa-edit"></i> Edit Complainant
                                         </button>
                                         @endif
                                
                                

                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $complainant->complainant_name }}</p>
                    <p><strong>Phone:</strong> {{ $complainant->phone ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $complainant->email ?? 'N/A' }}</p>
                    <p><strong>Address:</strong> {{ $complainant->address ?? 'N/A' }}</p>
                </div>
            </div>
            
            <!-- Edit Complainant Modal -->
            <!-- Edit Complainant Modal -->
                <div class="modal fade" id="editComplainantModal" tabindex="-1" aria-labelledby="editComplainantModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editComplainantModalLabel">Edit Complainant</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="updateComplainantForm">
                                    @csrf
                                    @method('PUT')

                                    <!-- Name -->
                                    <div class="mb-3">
                                        <label for="modal_complainant_name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="modal_complainant_name" name="complainant_name" required>
                                    </div>

                                    <!-- Phone -->
                                    <div class="mb-3">
                                        <label for="modal_phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="modal_phone" name="phone">
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label for="modal_email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="modal_email" name="email">
                                    </div>

                                    <!-- Address -->
                                    <div class="mb-3">
                                        <label for="modal_address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="modal_address" name="address">
                                    </div>

                                    <!-- Hidden field for complainant ID -->
                                    <input type="hidden" id="modal_complainant_id" name="complainant_id">
                                    <!-- Hidden field for complainant ID -->
                                    <input type="hidden" id="modal_case_id" name="case_id">
                                    <!-- Buttons -->
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



            <!-- Case Documents (Bigger than complainant) -->
           
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Case Documents</h4>
                    <!-- Add Document Button (Triggers Modal) -->
                    @if ($isLawyer)

                    @else
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                        <i class="fas fa-plus"></i> Add Document
                    </button>  
                    @endif
                    
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                swal("Success!", "{{ session('success') }}", "success");
                            });
                        </script>
                    @endif

                    @if (session('error'))
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                swal("Error!", "{{ session('error') }}", "error");
                            });
                        </script>
                    @endif

                    @if ($caseDocuments->isEmpty())
                        <p class="text-muted">No documents uploaded.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($caseDocuments as $document)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ asset('storage/documents/' . $document->document_name) }}" target="_blank">
                                        {{ $document->document_name }}
                                    </a>
                                    <!-- Delete Button -->
                                    @if ($isLawyer)
                                    
                                    @else
                                    <button type="button" class="btn btn-danger btn-sm delete-document-btn"
                                    data-id="{{ $document->document_id }}"
                                    data-case-id="{{ $case->case_id }}"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                    
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <!-- Add Document Modal -->
            <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addDocumentModalLabel">Add Case Document</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Upload Document Form -->
                            <form id="documentUploadForm" action="{{ route('documents.store', $case) }}" method="POST" enctype="multipart/form-data">
                                @method('POST')
                                @csrf
                                <div class="mb-3">
                                    <label for="document" class="form-label">Select Document</label>
                                    <input type="file" name="document" id="document" class="form-control" required accept=".pdf,.doc,.docx,.jpg,.png">
                                </div>
                                <input type="hidden" name="case_id" value="{{ $case->case_id }}">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal Dialog for Add Hearing -->
<div class="modal fade" id="addHearingModal" tabindex="-1" aria-labelledby="addHearingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addHearingModalLabel">Add Hearing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Hearing Form -->
                <form id="addHearingForm">
                    @csrf
                    <input type="hidden" name="case_id" id="modal_case_add_hearing_id">
                    <input type="hidden" name="sequence_number" id="modal_sequence_number">
                    
                    <div class="row mb-2">
                        <!-- Court Room Number and Court Name in One Row -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="case_name">Case Name</label>
                                <input type="text" class="form-control" name="case_name" id="modal_add_hearing_name"  readonly disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="court_room_number">Case Number</label>
                                <input type="text" class="form-control" name="case_number" readonly disabled  id="modal_add_hearing_number">
                            </div>
                        </div>
                    </div>


                    <div class="row mb-2">
                        <!-- Court Room Number and Court Name in One Row -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="court_name">Court Name</label>
                                <input type="text" class="form-control" name="court_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="court_room_number">Court Room Number</label>
                                <input type="text" class="form-control" name="court_room_number" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <!-- Date and Time in One Row -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" name="date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="time">Time</label>
                                <input type="time" class="form-control" name="time" required>
                            </div>
                        </div>
                    </div>

                    <!-- Sequence Number as Text Field -->
                    <div class="form-group mb-2">
                        <label for="sequence_number">Hearing Sequence</label>
                        <input type="text" name="sequence_number_1" id="sequence_number" class="form-control" readonly>
                    </div>

                    <div class="row mb-2">
                        <!-- Hearing Type and Virtual Link (optional) in One Row -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hearing_type">Hearing Type</label>
                                <select name="hearing_type" class="form-control" required>
                                    <option value="virtual">Virtual</option>
                                    <option value="physical">Physical</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="virtual_link">Virtual Link (if virtual hearing)</label>
                                <input type="text" class="form-control" name="virtual_link">
                            </div>
                        </div>
                    </div>

                    <!-- Court Contacts -->
                    <div class="form-group mb-2">
                        <label for="court_contacts">Court Contacts</label>
                        <textarea class="form-control" name="court_contacts"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100 mt-2">Add Hearing</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Dialog for Add Mention -->
<div class="modal fade" id="addMentionModal" tabindex="-1" aria-labelledby="addHearingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addHearingModalLabel">Add Mention</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Hearing Form -->
                <form id="addMentionForm">
                    @csrf
                    <input type="hidden" name="case_id" id="modal_case_add_mention_id">
                    <input type="hidden" name="sequence_number" id="modal_mention_sequence_number">
                    
                    <div class="row mb-2">
                        <!-- Court Room Number and Court Name in One Row -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="case_name">Case Name</label>
                                <input type="text" class="form-control" name="case_name" id="modal_add_mention_name"  readonly disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="court_room_number">Case Number</label>
                                <input type="text" class="form-control" name="case_number" readonly disabled  id="modal_add_mention_number">
                            </div>
                        </div>
                    </div>


                    <div class="row mb-2">
                        <!-- Court Room Number and Court Name in One Row -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="court_name">Court Name</label>
                                <input type="text" class="form-control" name="court_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="court_room_number">Court Room Number</label>
                                <input type="text" class="form-control" name="court_room_number" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <!-- Date and Time in One Row -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" name="date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="time">Time</label>
                                <input type="time" class="form-control" name="time" required>
                            </div>
                        </div>
                    </div>

                    <!-- Sequence Number as Text Field -->
                    <div class="form-group mb-2">
                        <label for="sequence_number">Hearing Sequence</label>
                        <input type="text" name="sequence_number_1" id="mention_sequence_number" class="form-control" readonly>
                    </div>

                    <div class="row mb-2">
                        <!-- Hearing Type and Virtual Link (optional) in One Row -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hearing_type">Hearing Type</label>
                                <select name="hearing_type" class="form-control" required>
                                    <option value="virtual">Virtual</option>
                                    <option value="physical">Physical</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="virtual_link">Virtual Link (if virtual hearing)</label>
                                <input type="text" class="form-control" name="virtual_link">
                            </div>
                        </div>
                    </div>

                    <!-- Court Contacts -->
                    <div class="form-group mb-2">
                        <label for="court_contacts">Court Contacts</label>
                        <textarea class="form-control" name="court_contacts"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100 mt-2">Add a Mention</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Dialog for Add Application -->
<div class="modal fade" id="addApplicationModal" tabindex="-1" aria-labelledby="addHearingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addHearingModalLabel">Add an Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Hearing Form -->
                <form id="addApplicationForm">
                    @csrf
                    <input type="hidden" name="case_id" id="modal_case_add_application_id">
                    <input type="hidden" name="sequence_number" id="modal_application_sequence_number">
                    
                    <div class="row mb-2">
                        <!-- Court Room Number and Court Name in One Row -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="case_name">Case Name</label>
                                <input type="text" class="form-control" name="case_name" id="modal_add_application_name"  readonly disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="court_room_number">Case Number</label>
                                <input type="text" class="form-control" name="case_number" readonly disabled  id="modal_add_application_number">
                            </div>
                        </div>
                    </div>


                    <div class="row mb-2">
                        <!-- Court Room Number and Court Name in One Row -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="court_name">Court Name</label>
                                <input type="text" class="form-control" name="court_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="court_room_number">Court Room Number</label>
                                <input type="text" class="form-control" name="court_room_number" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <!-- Date and Time in One Row -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" name="date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="time">Time</label>
                                <input type="time" class="form-control" name="time" required>
                            </div>
                        </div>
                    </div>

                    <!-- Sequence Number as Text Field -->
                    <div class="form-group mb-2">
                        <label for="sequence_number">Hearing Sequence</label>
                        <input type="text" name="sequence_number_1" id="application_sequence_number" class="form-control" readonly>
                    </div>

                    <div class="row mb-2">
                        <!-- Hearing Type and Virtual Link (optional) in One Row -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hearing_type">Hearing Type</label>
                                <select name="hearing_type" class="form-control" required>
                                    <option value="virtual">Virtual</option>
                                    <option value="physical">Physical</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="virtual_link">Virtual Link (if virtual hearing)</label>
                                <input type="text" class="form-control" name="virtual_link">
                            </div>
                        </div>
                    </div>

                    <!-- Court Contacts -->
                    <div class="form-group mb-2">
                        <label for="court_contacts">Court Contacts</label>
                        <textarea class="form-control" name="court_contacts"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100 mt-2">Add an Application</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="panelEvaluationModal" tabindex="-1" aria-labelledby="panelEvaluationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="panelEvaluationForm">
          <div class="modal-header">
            <h5 class="modal-title" id="panelEvaluationModalLabel">Submit Case for Panel Evaluation</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="modalCaseId">
            <div class="mb-3">
              <label for="panelMessage" class="form-label">Message to Lawyers</label>
              <textarea class="form-control" id="panelMessage" rows="4" placeholder="Enter message..."></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="sendPanelEvaluationBtn" class="btn btn-primary">Send</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  

@endsection



@push('scripts')
<!-- Case Update Section -->
<script>

    $(document).ready(function () {
        $(".assign-case").each(function () {
            let button = $(this);
            let caseId = button.data("case-id");
            
            $.ajax({
                url: "/cases/" + caseId + "/check-assignment",
                type: "GET",
                success: function (response) {
                    if (response.assigned) {
                        button.text("Assigned Lawyers");
                        button.removeClass("btn-info").addClass("btn-secondary");
                        button.attr("disabled", false); // Optionally disable the button
                        button.attr("data-bs-target", "#assignedLawyersModal")
                    }
                },
                error: function () {
                    console.error("Error checking case assignment.");
                }
            });
        });
    });


$(document).ready(function () {
    $(".evaluate-case").each(function () {
        let button = $(this);
        let caseId = button.data("case-id");
        let lawyerId = button.data("lawyer-id");
        let lawyerName = button.data("lawyer-name");
        
        if (caseId) {
            $.ajax({
                url: "/cases/" + caseId + "/check-evaluation",
                type: "GET",
                data: { lawyer_id: lawyerId },
                success: function (response) {
                    console.log("Evaluation exists:", response.exists);

                    if (response.exists) {
                        button.text("Re-evaluate this Case");
                        button.removeClass("btn-success").addClass("btn-warning"); // Change to warning color
                        button.attr("data-evaluation-exists", "true"); // Store evaluation status
                    } else {
                        button.text("Evaluate this Case");
                        button.removeClass("btn-warning").addClass("btn-success"); // Keep success color
                        button.attr("data-evaluation-exists", "false");
                    }
                },
                error: function () {
                    console.error("Error checking evaluation status.");
                    button.text("Evaluate this Case");
                    button.removeClass("btn-warning").addClass("btn-success"); // Default to success color
                }
            });
        } else {
            console.error("Case ID is missing for evaluation button.");
        }
    });
});


$(document).on("click", ".evaluate-case", function () { 
    let button = $(this);
    let caseId = button.data("case-id");
    let caseName = button.data("case-name");
    let lawyerId = button.data("lawyer-id");
    let lawyerName = button.data("lawyer-name");

    if (!caseId || !lawyerId) {
        Swal.fire("Error", "Missing case or lawyer details!", "error");
        return;
    }

    // Check if an evaluation already exists
    $.ajax({
        url: "/cases/" + caseId + "/check-evaluation",
        type: "GET",
        data: { lawyer_id: lawyerId }, // Pass the lawyer ID to check specifically for this lawyer
        success: function (response) {
            alert( response.evaluation.evaluation_id);
            let url;
            if (response.exists) {
                // Redirect to the edit page if evaluation exists
                url = "{{ route('evaluations.edit', ':evaluation_id') }}".replace(':evaluation_id', response.evaluation.evaluation_id);
            } else {
                // Redirect to create page if no evaluation exists
                url = "{{ route('evaluations.create', ':case_id') }}"
                    .replace(':case_id', caseId) + 
                    "?case_name=" + encodeURIComponent(caseName) + 
                    "&lawyer_id=" + encodeURIComponent(lawyerId) + 
                    "&lawyer_name=" + encodeURIComponent(lawyerName);
            }

            window.location.href = url; // Perform the redirection
        },
        error: function () {
            Swal.fire("Error", "Could not check evaluation status!", "error");
        }
    });
});


$(document).ready(function () {
    $(document).on('click', '.assign-case', function () {

        let case_id = $(this).data('case-id');
        let case_number = $(this).data("case-number");
        let case_name = $(this).data("case-name");
         // Set the case ID in the hidden input
        $("#modal_assign_case_id").val($(this).data("case-id"));
        $("#modal_assign_case_number").val($(this).data("case-number"));
        $("#modal_assign_case_name").val($(this).data("case-name"));
        
        //alert("The case : "+case_id+" Name: "+case_name+"Number:  "+case_number);
        console.log("The case id is: "+case_id);
        $.ajax({
            url: "/cases/" + case_id + "/available-lawyers",
            type: "GET",
            data: { case_id: case_id },
            success: function(response) {
                let paymentMethodSelect = $("#edit_payment_lawyer");
                
                paymentMethodSelect.empty();
                paymentMethodSelect.append('<option value="">Select Lawyer</option>');

                $.each(response, function (index, lawyer) {
                    console.log("The lawyer is: "+lawyer.lawyer_id);
                    paymentMethodSelect.append(`<option value="${lawyer.lawyer_id}">${lawyer.display_name}</option>`);
                });
    
    

        
    },
            error: function () {
                alert("Failed to fetch lawyers. Please try again.");
            }
        });
    });


});

$("#assignCaseForm").on("submit", function (e) {
    e.preventDefault(); // Prevent form from reloading the page
    
    let caseId = $("#modal_assign_case_id").val();
    let lawyerId = $("#edit_payment_lawyer").val(); // Ensure this field exists in the form
    alert(lawyerId)
    if (!caseId || !lawyerId) {
        Swal.fire("Error", "Case ID or Lawyer ID is missing!", "error");
        return;
    }

    let formData = $(this).serialize(); // Serialize form data

    $.ajax({
        url: "/cases/assign",  // ✅ Send request to correct route (NO ID in URL)
        type: "POST",
        data: formData,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") // CSRF token for Laravel security
        },
        success: function (response) {
            if (response.success) {
                Swal.fire("Success", "Case assigned successfully!", "success");
                  $(".assign-case[data-case-id='" + caseId + "']")
                    .text("Assigned Lawyers")
                    .removeClass("btn-info")
                    .attr("data-bs-target", "#assignedLawyersModal")
                    .attr("disabled", false)
                    .addClass("btn-secondary"); // Optionally change color


                // Close the modal
                $("#assignCaseModal").modal("hide");
            }
        },
        error: function (xhr) {
            let errorMessage = "Failed to assign case.";
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage += " " + xhr.responseJSON.message;
            }
            Swal.fire("Error", errorMessage, "error");
        }
    });
});




    $(document).ready(function () {
    $(".edit-case").on("click", function () {
        let caseId = $(this).data("case-id");  
        
        
       
        // Ensure data-case-id exists in the button
        $("#modal_case_id").val(caseId);  // Set the case ID in the hidden input
        $("#modal_case_id").val($(this).data("case-id"));
        $("#modal_case_number").val($(this).data("case-number"));
        $("#modal_case_name").val($(this).data("case-name"));
        $("#modal_case_category").val($(this).data("case-category"));
        $("#modal_case_status").val($(this).data("case-status"));
        $("#modal_initial_status").val($(this).data("initial-status"));
        $("#modal_first_hearing_date").val($(this).data("first-hearing-date"));
        $("#modal_date_received").val($(this).data("date-received"));
        $("#modal_case_description").val($(this).data("case-description"));
    });
});

$("#updateCaseForm").on("submit", function (e) {
    e.preventDefault();
    
    let caseId = $("#modal_case_id").val();

    if (!caseId) {
        Swal.fire("Error", "Case ID is missing!", "error");
        return;
    }

    let formData = $(this).serialize(); // Serialize form data

    $.ajax({
        url: "/cases/update/" + caseId,  // Matches route: /cases/update/{case}
        type: "PUT",
        data: formData,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") // Pass CSRF token
        },
        success: function (response) {
            if (response.success) {
                Swal.fire("Success", "Case updated successfully!", "success");

                // 🟢 Update Case Details on UI
                $("#case_number_display").text(response.case.case_number);
                $("#case_name_display").text(response.case.case_name);
                $("#case_description_display").text(response.case.case_description);
                $("#date_received_display").text(response.case.date_received);
                $("#case_category_display").text(response.case.case_category);
                $("#initial_status_display").text(response.case.initial_status);
                $("#updated_at_display").text("Just now");

                // Close the modal
                $("#editCaseModal").modal("hide");
            }
        },
        error: function (xhr) {
            Swal.fire("Error", "Failed to update case: " + xhr.responseJSON.error, "error");
        }
    });
});


</script>

<!-- Complainant Update Section -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    // When clicking the edit button, populate the modal fields
    document.querySelectorAll(".edit-complainant-btn").forEach(button => {
        button.addEventListener("click", function () {
            // Get data from button attributes
            let complainantId = this.getAttribute("data-id");
            let caseId = this.getAttribute("data-case");
            console.log(complainantId);
            let complainantName = this.getAttribute("data-name");
            let phone = this.getAttribute("data-phone");
            let email = this.getAttribute("data-email");
            let address = this.getAttribute("data-address");

            // Populate modal fields
            document.getElementById("modal_complainant_id").value = complainantId;
            document.getElementById("modal_case_id").value = caseId;
            document.getElementById("modal_complainant_name").value = complainantName;
            document.getElementById("modal_phone").value = phone;
            document.getElementById("modal_email").value = email;
            document.getElementById("modal_address").value = address;
        });
    });
});


$(document).ready(function () {
    $("#updateComplainantForm").submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        let complainantId = $("#modal_complainant_id").val();
        let caseId = $("#modal_case_id").val();
        

        if (!complainantId) {
            alert("Complainant ID is missing!");
            return;
        }

       

        let formData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            _method: "PUT", // Laravel uses PUT for updates
            complainant_name: $("#modal_complainant_name").val(),
            case_id: $("#modal_case_id").val(),
            phone: $("#modal_phone").val(),
            email: $("#modal_email").val(),
            address: $("#modal_address").val()
        };

        $.ajax({
            url: "/complainants/" + complainantId,
            type: "PUT",
            data: formData,
            success: function (response) {
                if (response.success) {
                    Swal.fire("Updated!", response.success, "success");

                    // Update UI dynamically
                    let complainantCard = $("button[data-id='" + complainantId + "']").closest(".card");
                    
                    complainantCard.find(".card-body").html(`
                        <p><strong>Name:</strong> ${response.complainant.complainant_name}</p>
                        <p><strong>Phone:</strong> ${response.complainant.phone || 'N/A'}</p>
                        <p><strong>Email:</strong> ${response.complainant.email || 'N/A'}</p>
                        <p><strong>Address:</strong> ${response.complainant.address || 'N/A'}</p>
                    `);

                    // Update data attributes for future edits
                    let editButton = $("button[data-id='" + complainantId + "']");
                    editButton.attr("data-name", response.complainant.complainant_name);
                    editButton.attr("data-phone", response.complainant.phone);
                    editButton.attr("data-email", response.complainant.email);
                    editButton.attr("data-address", response.complainant.address);

                    // Close modal
                    $("#editComplainantModal").modal("hide");
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                Swal.fire("Error!", "Failed to update complainant. Check console for details.", "error");
            }
        });

    });
});

</script>
<script>
   document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-document-btn").forEach(button => {
        button.addEventListener("click", function () {
            let documentId = this.getAttribute("data-id");
            let caseId = this.getAttribute("data-case-id");


            Swal.fire({
                title: "Are you sure?",
                text: "Do you really want to delete this document?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Delete",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/cases/${caseId}/documents/${documentId}`, {
                        method: "POST", // Use POST instead of DELETE
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                            "Accept": "application/json",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ _method: "DELETE" }) // Laravel recognizes this as DELETE
                    })
                    .then(response => {
                        if (response.ok) {
                            button.closest("li").remove();
                            Swal.fire("Deleted!", "The document has been deleted.", "success");
                        } else {
                            Swal.fire("Error!", "Something went wrong.", "error");
                        }
                    }).catch(error => {
                        console.error("Error deleting document:", error);
                        Swal.fire("Error!", "Something went wrong.", "error");
                    });
                }
            });
        });
    });
});




$(document).ready(function () {
    $("#assignedLawyersModal").on("show.bs.modal", function (event) {
        let button = $(event.relatedTarget);
        let caseId = button.data("case-id");
       
        /*
        $("#modal_assign_case_id").val(caseId);
        $("#modal_assign_case_number").val(button.data("case-number"));
        $("#modal_assign_case_name").val(button.data("case-name"));
        */
        loadAssignedLawyers(caseId);
    });

    function loadAssignedLawyers(caseId) {
        $("#assignedLawyersList").html("<li class='list-group-item'>Loading...</li>");

        $.ajax({
            url: "/cases/" + caseId + "/assigned-lawyers",
            type: "GET",
            success: function (response) {
                let listHtml = "";
                if (response.length === 0) {
                    listHtml = "<li class='list-group-item text-muted'>No lawyers assigned yet.</li>";
                } else {
                    response.forEach(lawyer => {
                                            listHtml += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            ${lawyer.full_name} - ${lawyer.license_number} 
                            <button class="btn btn-danger btn-sm remove-lawyer" 
                                data-lawyer-id="${lawyer.lawyer_id}" 
                                data-case-id="${caseId}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </li>`;

                    });
                }
                $("#assignedLawyersList").html(listHtml);
            },
            error: function () {
                $("#assignedLawyersList").html("<li class='list-group-item text-danger'>Error loading lawyers.</li>");
            }
        });
    }

    // Handle lawyer removal
    $(document).on("click", ".remove-lawyer", function () {
        let lawyerId = $(this).data("lawyer-id");
        let caseId = $(this).data("case-id");
        let listItem = $(this).closest("li");

        $.ajax({
            url: "/cases/" + caseId + "/remove-lawyer/" + lawyerId,
            type: "DELETE",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function () {
                Swal.fire("Success", "Lawyer Removed Successfully!", "success"); 
                listItem.remove();
            },
            error: function () {
                alert("Error removing lawyer.");
            }
        });
    });

    // Handle "Add Another Lawyer" button click
    $("#addLawyerBtn").click(function () {
        let newSelect = $("#edit_payment_lawyer").clone();
        newSelect.val(""); // Clear previous selection
        $("#assignCaseForm").append(newSelect);
    });
});



$(document).ready(function () {
    $("#assignAnotherLawyerBtn").on("click", function () {
        $("#assignedLawyersModal").modal("hide"); // Close current modal
        setTimeout(function () {
            $("#assignCaseModal").modal("show"); // Open assign case modal
        }, 500); // Delay to ensure smooth transition
    });
});




$('#actionCaseModal').on('click', function () {
        var caseId = $(this).data('case-id');  // Get case_id from button
        var caseName = $(this).data('case-name');  // Get case_name from button

        var caseNumber = $(this).data('case-number');
        
        
        // Set the case_id and case_name in the modal form
        $('#modal_case_id').val(caseId);
        $('#modal_case_name').val(caseName);
        $('#addHearingBtn').data('case-id', caseId);
        $('#addHearingBtn').data('case-name', caseName);
        $('#addHearingBtn').data('case-number', caseNumber);

        $('#updateHearingBtn').data('case-id', caseId);
        $('#updateHearingBtn').data('case-name', caseName);
        $('#updateHearingBtn').data('case-number', caseNumber);

        $('#deleteHearingBtn').data('case-id', caseId);
        $('#deleteHearingBtn').data('case-name', caseName);
        $('#deleteHearingBtn').data('case-number', caseNumber);




        $('#addMentionBtn').data('case-id', caseId);
        $('#addMentionBtn').data('case-name', caseName);
        $('#addMentionBtn').data('case-number', caseNumber);

        $('#updateMentionBtn').data('case-id', caseId);
        $('#updateMentionBtn').data('case-name', caseName);
        $('#updateMentionBtn').data('case-number', caseNumber);

        $('#deleteMentionBtn').data('case-id', caseId);
        $('#deleteMentionBtn').data('case-name', caseName);
        $('#deleteMentionBtn').data('case-number', caseNumber);


        $('#addApplicationBtn').data('case-id', caseId);
        $('#addApplicationBtn').data('case-name', caseName);
        $('#addApplicationBtn').data('case-number', caseNumber);

        $('#updateApplicationBtn').data('case-id', caseId);
        $('#updateApplicationBtn').data('case-name', caseName);
        $('#updateApplicationBtn').data('case-number', caseNumber);

        $('#deleteApplicationBtn').data('case-id', caseId);
        $('#deleteApplicationBtn').data('case-name', caseName);
        $('#deleteApplicationBtn').data('case-number', caseNumber);




        
        

       
    $('#case-id-display').text("Case ID: " + caseId);
    });


    $('#addHearingBtn').on('click', function() {
    var caseId = $(this).data('case-id'); // Get the case_id from button's data attribute
    var caseName = $(this).data('case-name'); // Get the case_name from button's data attribute
    var caseNumber = $(this).data('case-number');
    // Set the case_id and case_name in the modal form
    $('#modal_case_add_hearing_id').val(caseId);
    $('#modal_add_hearing_name').val(caseName);
    $('#modal_add_hearing_number').val(caseNumber);

    // Send AJAX request to get the last sequence number for the given case_id
    $.ajax({
        url: '/cases/get-last-sequence/' + caseId, // Adjust the route as needed
        method: 'GET',
        success: function(response) {
            var nextSequence = response.nextSequence;
            var nextSequenceText = response.nextSequenceText;
            $('#modal_sequence_number').val(nextSequence);

            // Set the sequence number text field with the generated text
            $('#sequence_number').val(nextSequenceText); // Display the ordinal value in the text field
        },
        error: function() {
                    Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Error fetching last sequence number.',
        });

        }
    });
});


$('#addMentionBtn').on('click', function() {
    var caseId = $(this).data('case-id'); // Get the case_id from button's data attribute
    var caseName = $(this).data('case-name'); // Get the case_name from button's data attribute
    var caseNumber = $(this).data('case-number');
    // Set the case_id and case_name in the modal form
    $('#modal_case_add_mention_id').val(caseId);
    $('#modal_add_mention_name').val(caseName);
    $('#modal_add_mention_number').val(caseNumber);

    // Send AJAX request to get the last sequence number for the given case_id
    $.ajax({
        url: '/cases/get-last-sequence-mention/' + caseId, // Adjust the route as needed
        method: 'GET',
        success: function(response) {
            var nextSequence = response.nextSequence;
            var nextSequenceText = response.nextSequenceText;
            $('#modal_mention_sequence_number').val(nextSequence);

            // Set the sequence number text field with the generated text
            $('#mention_sequence_number').val(nextSequenceText); // Display the ordinal value in the text field
        },
        error: function() {
                    Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Error fetching last sequence number.',
        });

        }
    });
});




$('#addApplicationBtn').on('click', function() {
    var caseId = $(this).data('case-id'); // Get the case_id from button's data attribute
    var caseName = $(this).data('case-name'); // Get the case_name from button's data attribute
    var caseNumber = $(this).data('case-number');
    // Set the case_id and case_name in the modal form
    $('#modal_case_add_application_id').val(caseId);
    $('#modal_add_application_name').val(caseName);
    $('#modal_add_application_number').val(caseNumber);

    // Send AJAX request to get the last sequence number for the given case_id
    $.ajax({
        url: '/cases/get-last-sequence-application/' + caseId, // Adjust the route as needed
        method: 'GET',
        success: function(response) {
            var nextSequence = response.nextSequence;
            var nextSequenceText = response.nextSequenceText;
            $('#modal_application_sequence_number').val(nextSequence);

            // Set the sequence number text field with the generated text
            $('#application_sequence_number').val(nextSequenceText); // Display the ordinal value in the text field
        },
        error: function() {
                    Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Error fetching last sequence number.',
        });

        }
    });
});


$(document).ready(function() {
    $('#addHearingForm').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: "{{ route('cases.addHearing') }}", // Laravel route
            method: "POST",
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Hearing added successfully!',
                    timer: 2000,
                    showConfirmButton: false
                });

                $('#addHearingForm')[0].reset(); // Clear the form
                $('#addHearingModal').modal('hide'); // Optional: close modal
            },
            error: function(xhr) {
                let msg = 'Something went wrong.';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: msg
                });
            }
        });
    });
});



$(document).ready(function() {
    $('#addMentionForm').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: "{{ route('cases.addMention') }}", // Laravel route
            method: "POST",
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Mention added successfully!',
                    timer: 2000,
                    showConfirmButton: false
                });

                $('#addMentionForm')[0].reset(); // Clear the form
                $('#addMentionModal').modal('hide'); // Optional: close modal
            },
            error: function(xhr) {
                let msg = 'Something went wrong.';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: msg
                });
            }
        });
    });
});

$(document).ready(function() {
    $('#addApplicationForm').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: "{{ route('cases.addApplication') }}", // Laravel route
            method: "POST",
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Application added successfully!',
                    timer: 2000,
                    showConfirmButton: false
                });

                $('#addApplicationForm')[0].reset(); // Clear the form
                $('#addApplicationModal').modal('hide'); // Optional: close modal
            },
            error: function(xhr) {
                let msg = 'Something went wrong.';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: msg
                });
            }
        });
    });
});

$('#updateHearingBtn').on('click', function (e) {
    e.preventDefault();  // Prevent the default action (navigation)

    var caseId = $(this).data('case-id');
    var caseName = $(this).data('case-name');
    var type = 'hearing';

    $.ajax({
        url: '/cases/update-form',
        method: 'GET',
        data: {
            case_id: caseId,
            case_name: caseName,
            type: type
        },
        success: function (response) {
           
            if (response.redirect_url) {
                // Redirect the browser to the URL provided in the response
                window.location.href = response.redirect_url;
            }
        },
        error: function (xhr) {
            console.error('Error loading update form:', xhr);
        }
    });
});


$('#updateMentionBtn').on('click', function (e) {
    e.preventDefault();  // Prevent the default action (navigation)

    var caseId = $(this).data('case-id');
    var caseName = $(this).data('case-name');
    var type = 'mention';

    $.ajax({
        url: '/cases/update-form',
        method: 'GET',
        data: {
            case_id: caseId,
            case_name: caseName,
            type: type
        },
        success: function (response) {
           
            if (response.redirect_url) {
                // Redirect the browser to the URL provided in the response
                window.location.href = response.redirect_url;
            }
        },
        error: function (xhr) {
            console.error('Error loading update form:', xhr);
        }
    });
});

$('#updateApplicationBtn').on('click', function (e) {
    e.preventDefault();  // Prevent the default action (navigation)

    var caseId = $(this).data('case-id');
    var caseName = $(this).data('case-name');
    var type = 'application';

    $.ajax({
        url: '/cases/update-form',
        method: 'GET',
        data: {
            case_id: caseId,
            case_name: caseName,
            type: type
        },
        success: function (response) {
           
            if (response.redirect_url) {
                // Redirect the browser to the URL provided in the response
                window.location.href = response.redirect_url;
            }
        },
        error: function (xhr) {
            console.error('Error loading update form:', xhr);
        }
    });
});

$('#deleteHearingBtn').on('click', function (e) {
    e.preventDefault();  // Prevent the default action (navigation)

    var caseId = $(this).data('case-id');
    var caseName = $(this).data('case-name');
    var type = 'hearing';

    $.ajax({
        url: '/cases/update-form',
        method: 'GET',
        data: {
            case_id: caseId,
            case_name: caseName,
            type: type
        },
        success: function (response) {
           
            if (response.redirect_url) {
                // Redirect the browser to the URL provided in the response
                window.location.href = response.redirect_url;
            }
        },
        error: function (xhr) {
            console.error('Error loading update form:', xhr);
        }
    });
});

$('#deleteMentionBtn').on('click', function (e) {
    e.preventDefault();  // Prevent the default action (navigation)

    var caseId = $(this).data('case-id');
    var caseName = $(this).data('case-name');
    var type = 'mention';

    $.ajax({
        url: '/cases/update-form',
        method: 'GET',
        data: {
            case_id: caseId,
            case_name: caseName,
            type: type
        },
        success: function (response) {
           
            if (response.redirect_url) {
                // Redirect the browser to the URL provided in the response
                window.location.href = response.redirect_url;
            }
        },
        error: function (xhr) {
            console.error('Error loading update form:', xhr);
        }
    });
});


$('#deleteApplicationBtn').on('click', function (e) {
    e.preventDefault();  // Prevent the default action (navigation)

    var caseId = $(this).data('case-id');
    var caseName = $(this).data('case-name');
    var type = 'application';

    $.ajax({
        url: '/cases/update-form',
        method: 'GET',
        data: {
            case_id: caseId,
            case_name: caseName,
            type: type
        },
        success: function (response) {
           
            if (response.redirect_url) {
                // Redirect the browser to the URL provided in the response
                window.location.href = response.redirect_url;
            }
        },
        error: function (xhr) {
            console.error('Error loading update form:', xhr);
        }
    });
});




</script>

<script>
    $(document).ready(function () {
        // Store case_id in modal hidden field
        $('#submitEvaluationBtn').on('click', function () {
            const caseId = $(this).data('case-id');
            const caseFlag = $(this).data('case-flag');
            let message = "Send Message to Lawyers";
            
            if (caseFlag) {
              
                $('#panelEvaluationModalLabel').text(message);
            }
            $('#modalCaseId').text(caseId);
            
        });
    
        $('#sendPanelEvaluationBtn').on('click', function () {
            const caseId = $('#modalCaseId').val();
            const message = $('#panelMessage').val().trim();
    
            if (message === '') {
                Swal.fire('Error', 'Please enter a message to send.', 'warning');
                return;
            }
    
            $.ajax({
                url: `/cases/${caseId}/submit-panel-evaluation`,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { message: message },
                success: function (response) {
                    Swal.fire('Success', response.message, 'success');
                    $('#panelEvaluationModal').modal('hide');
                      // Update modal title
                $('#panelEvaluationModalLabel').text('Message Sent to Lawyers');

                    // Optionally clear the message textarea
                    $('#panelMessage').val('');
    
                    $('#submitEvaluationBtn')
                        .text('Submitted to Panel Evaluation')
                        .removeClass('btn-primary')
                        .addClass('btn-secondary')
                        .prop('disabled', true);
                },
                error: function (xhr) {
                    let message = 'Something went wrong.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    Swal.fire('Error', message, 'error');
                }
            });
        });
    });
    </script>
    

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".card").forEach(function(card) {
                const assignButton = card.querySelector(".assign-case");
                if (assignButton) {
                    const status = assignButton.getAttribute("data-case-status");
                    if (status && status.toLowerCase() === "closed") {
                        card.style.display = "none";
                    }
                }
            });
        });
        </script>
        

@endpush
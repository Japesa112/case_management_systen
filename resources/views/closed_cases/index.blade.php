@extends('layouts.default')

@section('title', 'Manage Closed Cases')

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
<div class="container-fluid mt-4">
    @php
    use Illuminate\Support\Str;
    @endphp
    
    <div class="panel panel-inverse">
        <div class="panel-heading d-flex justify-content-between align-items-center">
            <a href="{{ url('/cases') }}" class="btn btn-dark btn-sm d-flex align-items-center gap-2">
                <i class="fa fa-arrow-left text-white fw-bold"></i> <span class="text-white">Back to Cases</span>
            </a>
            <div class="panel-heading-btn">
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addEvaluationModal">
                    <i class="fa fa-plus"></i> Close a Case
                </button>
            </div>
        </div>
        <div class="panel-body">
            
             <!-- Modal -->
             <div class="modal fade" id="addEvaluationModal" tabindex="-1" aria-labelledby="addEvaluationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color: rgb(1, 9, 12)" id="addEvaluationModalLabel">Close a Case</h5>
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
                                    <button type="submit" class="btn btn-primary">Close Case</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


                @if(session('success'))
                <div class="alert alert-success" id="success-message">
                    {{ session('success') }}
                </div>
            
                <script>
                    setTimeout(function() {
                        document.getElementById('success-message').style.display = 'none';
                    }, 5000); // Hides the message after 5 seconds (5000ms)
                </script>
            @endif
            
            
            <div class="table-responsive">
                <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Case Name</th>
                            <th>Closure Date</th>                           
                            <th>Final Outcome</th>                           
                            <th>Actions</th>
                        </tr>
                    </thead>
            
                    <tbody>
                        @foreach($closedCases as $closure)
                            <tr>
                                <td class="text-center">{{ $closure->closure_id }}</td>
                                
                                <td class="text-center">
                                 @if($closure->case)
                                    <a href="{{ route('cases.show', $closure->case->case_id) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center" title="View Case">
                                        <i class="fa fa-eye me-1"></i> {{ $closure->case->case_name }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                                 </td>
                                <td class="text-center">{{ $closure->closure_date }}</td>
                             
                                <td class="text-center">{{ $closure->final_outcome }}</td>
                               
                                <td class="text-center action-buttons">
                                    <button class="btn btn-warning btn-sm edit-closure" data-id="{{ $closure->closure_id }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
            
                                    <button class="btn btn-info btn-sm view-closure" data-id="{{ $closure->closure_id }}">
                                        <i class="fa fa-eye"></i> View
                                    </button>
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

<!-- View Case Closure Modal -->
<div class="modal fade" id="viewClosureModal" tabindex="-1" aria-labelledby="viewClosureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewClosureModalLabel">Case Closure Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="closure-content">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Case ID:</strong> <span id="closure-case-id"></span></p>
                            <p><strong>Case Name:</strong> <span id="closure-case-name"></span></p>
                            <p><strong>Closure Date:</strong> <span id="closure-date"></span></p>
                            <p><strong>Final Outcome:</strong> <span id="closure-final-outcome"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Closure Reason:</strong> <span id="closure-reason"></span></p>
                            <p><strong>Additional Notes:</strong></p>
                            <p id="closure-notes" class="border p-2 bg-light"></p>
                            <p><strong>Created At:</strong> <span id="closure-created-at"></span></p>
                            <p><strong>Updated At:</strong> <span id="closure-updated-at"></span></p>
                        </div>
                    </div>

                    <!-- Attachments Section -->
                    <div class="mt-3">
                        <h5>Attachments</h5>
                        <ul id="closure-attachments" class="list-group"></ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

</div>
<!-- Edit Case Closure Modal -->
<div class="modal fade" id="editClosureModal" tabindex="-1" aria-labelledby="editClosureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editClosureModalLabel">Edit Case Closure</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Left Section: Document List -->
                    <div class="col-md-5 border-end">
                        <h5>Existing Attachments</h5>
                        <ul id="documentList" class="list-group mb-3">
                            <!-- Documents will be loaded here dynamically -->
                        </ul>
                        <button type="button" class="btn btn-success btn-sm" id="openUploadModalBtn">
                            <i class="fa fa-plus"></i> Add Attachment
                        </button>
                    </div>

                    <!-- Right Section: Edit Case Closure Form -->
                    <div class="col-md-7">
                        <form id="editClosureForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" id="edit_closure_id" name="closure_id">
                            <input type="hidden" class="form-control" id="edit_case_id" name="case_id" readonly>

                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit_case_name" class="form-label">Case Name</label>
                                        <input type="text" class="form-control" id="edit_case_name" name="case_name" readonly disabled>
                                    </div>


                                    <div class="mb-3">
                                        <label for="edit_closure_date" class="form-label">Closure Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="edit_closure_date" name="closure_date" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="edit_final_outcome" class="form-label">Final Outcome <span class="text-danger">*</span></label>
                                        <select class="form-control" id="edit_final_outcome" name="final_outcome" required>
                                            <option value="">Select Outcome</option>
                                            <option value="Win">Win</option>
                                            <option value="Loss">Loss</option>
                                            <option value="Other">Other</option>
                                          
                                        </select>
                                    </div>
                                    <div class="mb-3 d-none" id="edit_final_outcome_other_group">
                                        <label for="edit_final_outcome_other" class="form-label">Specify Other Outcome</label>
                                        <input type="text" class="form-control" id="edit_final_outcome_other" name="final_outcome_other" placeholder="Enter final outcome">
                                    </div>



                                    <div class="mb-3">
                                        <label for="edit_lawyer_payment_confirmed" class="form-label">Lawyer Payment Confirmed   <span class="text-danger">*</span></label>
                                        <select class="form-control" id="edit_lawyer_payment_confirmed" name="lawyer_payment_confirmed" required>
                                            <option value="">Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                   

                                    <div class="mb-3">
                                        <label for="edit_follow_up_actions" class="form-label">Follow-Up Actions</label>
                                        <textarea class="form-control" id="edit_follow_up_actions" name="follow_up_actions" rows="3"></textarea>
                                    </div>

                                    
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="updateClosureBtn">
                                    Update Case Closure
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Upload Case Closure Attachment Modal -->
<div class="modal fade" id="uploadAttachmentModal" tabindex="-1" aria-labelledby="uploadClosureAttachmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="uploadClosureAttachmentModalLabel">Upload Closure Attachment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modal_closure_id">
                <div class="mb-3">
                    <label for="modal_attachmentFile" class="form-label">Choose File</label>
                    <input type="file" class="form-control" id="modal_attachmentFile">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="modal_uploadAttachmentBtn">
                    <i class="fa fa-upload"></i> Upload
                </button>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
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
   $(document).ready(function () {
    // View Case Closure
    $(document).on('click', '.view-closure', function () {
        let closureId = $(this).data('id');

        // Show the modal
        $('#viewClosureModal').modal('show');

        // Display a loading indicator
        $('#closure-content').html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading details...</div>');

        // Fetch case closure details
        $.ajax({
            url: "{{ route('closed_cases.show', ':id') }}".replace(':id', closureId),
            type: "GET",
            success: function (response) {
                let closure = response.closure;
                let attachments = response.attachments;
                let case_name = response.case_name;
                let content = `
                        <div class="row">
                        <div class="col-md-6">
                            <strong>Case Name:</strong> ${case_name ?? 'N/A'}<br>
                            <strong>Closure Date:</strong> ${closure.closure_date ?? 'N/A'}<br>
                            <strong>Final Outcome:</strong> <p>${closure.final_outcome ?? 'N/A'}</p>
                            <strong>Follow-up Actions:</strong> <p>${closure.follow_up_actions ?? 'N/A'}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Lawyer Payment Confirmed:</strong> ${closure.lawyer_payment_confirmed ?? 'N/A'}<br>
                            <strong>Created At:</strong> ${closure.created_at ?? 'N/A'}<br>
                            <strong>Updated At:</strong> ${closure.updated_at ?? 'N/A'}<br>
                        </div>
                    </div>

                    <hr>
                    <h5>Attachments</h5>
                    <ul class="list-group">
                    `;


                if (attachments.length > 0) {
                    attachments.forEach(file => {
                        content += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="${file.file_path}" target="_blank">${file.file_name}</a>
                                <span class="badge bg-primary">${file.file_type ?? 'Unknown'}</span>
                            </li>
                        `;
                    });
                } else {
                    content += `<li class="list-group-item text-muted">No attachments found.</li>`;
                }

                content += `</ul>`;

                $('#closure-content').html(content);
            },
            error: function () {
                $('#closure-content').html('<div class="text-danger text-center">Error loading case closure details.</div>');
            }
        });
    });

    // Edit Case Closure
    $(document).on('click', '.edit-closure', function () {
        let closureId = $(this).data('id');

        // Fetch closure details using AJAX
        $.ajax({
            url: `closed_cases/show/${closureId}`,
            type: "GET",
            success: function (response) {
                let closure = response.closure;
                let attachments = response.attachments;

                
               
                let case_name = response.case_name;

                // Populate form fields with fetched data
                $('#edit_closure_id').val(closure.closure_id);
                $('#edit_case_id').val(closure.case_id);
                $('#edit_case_name').val(case_name);
                $('#edit_closure_date').val(closure.closure_date);
                $('#edit_lawyer_payment_confirmed').val(closure.lawyer_payment_confirmed);
                $('#edit_follow_up_actions').val(closure.follow_up_actions);
                $('#edit_final_outcome').val(closure.final_outcome);

                // Clear and populate document list
                $('#documentList').empty();
                if (attachments.length > 0) {
                    attachments.forEach(doc => {
                        console.log( "File path is: " +doc.file_path );
                        $('#documentList').append(`
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                
                                <a href="${doc.file_path}" target="_blank">${doc.file_name}</a>
                                <button class="btn btn-danger btn-sm delete-document" data-id="${doc.attachment_id}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </li>
                        `);
                    });
                } else {
                    $('#documentList').append('<li class="list-group-item no-documents">No documents uploaded.</li>');
                }

                // Show the modal
                $('#editClosureModal').modal('show');
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Update Failed",
                    text: "Error fetching case closure details.",
                });
            }
        });
    });
});


    $(document).on("click", ".delete-document", function () {
    let button = $(this);
    let documentId = button.data("id");

    Swal.fire({
        title: "Are you sure?",
        text: "Do you really want to delete this document?"+ documentId,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Delete",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/closed_cases/deleteDocuments/${documentId}`,
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Accept": "application/json"
                },
                success: function () {
                    button.closest("li").remove();
                    Swal.fire("Deleted!", "The document has been deleted.", "success");
                },
                error: function () {
                    Swal.fire("Error!", "Something went wrong.", "error");
                }
            });
        }
    });
});
$(document).ready(function () {
    // Open modal and set case closure ID
    $("#openUploadModalBtn").click(function () {
        let caseClosureId = $("#edit_closure_id").val(); // Ensure the closure ID is available
        $("#modal_closure_id").val(caseClosureId);
        $("#uploadAttachmentModal").modal("show");
    });

    // Upload file when clicking "Upload" in the modal
    $("#modal_uploadAttachmentBtn").click(function () {
        let caseClosureId = $("#modal_closure_id").val();
       

        let fileInput = $("#modal_attachmentFile")[0].files[0];

        if (!fileInput) {
            Swal.fire({
                icon: "warning",
                title: "No File Selected",
                text: "Please select a file to upload.",
                confirmButtonColor: "#d33",
            });

            return;
        }
        
        let formData = new FormData();
        formData.append("case_closure_id", caseClosureId); // Updated field name
        formData.append("attachment", fileInput);
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

        $.ajax({
            url: "/closed_cases/uploadAttachment", // Ensure correct route for closed cases
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                Swal.fire("Success!", response.message, "success");

                // Close the modal
                $("#uploadAttachmentModal").modal("hide");

                // Clear file input
                $("#modal_attachmentFile").val("");
                $('#documentList').find('.no-documents').remove();

                // Append new document to the list
                $("#documentList").append(`
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="/storage/${response.document.file_path}" target="_blank">${response.document.file_name}</a>
                        <button class="btn btn-danger btn-sm delete-document" data-id="${response.document.attachment_id}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </li>
                `);
            },
            error: function (xhr) {
                let errorMessage = xhr.responseJSON?.error || "Upload failed. Please try again.";

                Swal.fire({
                    icon: "error",
                    title: "Upload Failed",
                    text: errorMessage,
                });
            }
        });
    });
});

$(document).ready(function () {
    $("#editClosureForm").on("submit", function (e) {
        e.preventDefault(); // Prevent default form submission

        let formData = new FormData(this);
        let closureId = $("#edit_closure_id").val(); // Get closure ID
        let url = `/closed_cases/update/${closureId}`; // Construct the update route URL
        
        console.log("Closure ID:", closureId);
        console.log("Form Data:", Object.fromEntries(new FormData($("#editClosureForm")[0])));

        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Updated Successfully",
                    text: "Case closure has been updated successfully!",
                }).then(() => {
                    window.location.href = "/closed_cases"; // Redirect after success
                });
            },
            error: function (xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = "Something went wrong.";

                if (errors) {
                    errorMessage = Object.values(errors).join("\n");
                }

                Swal.fire({
                    icon: "error",
                    title: "Update Failed",
                    text: errorMessage,
                });
            },
        });
    });
});



</script>


<script>
   $(document).ready(function () {
    $(document).on('submit', '#checkCaseForm', function (e) {
        e.preventDefault(); // Prevent default form submission

        let caseNumber = $('#evaluation_case_id').val(); 

        $.ajax({
            url: "{{ route('closed_cases.checkCase') }}",  // Updated route for closed cases
            type: "GET",
            data: { case_number: caseNumber },
            success: function (response) {
                if (response.exists) {
                    if (response.evaluation) {
                        // Redirect to evaluations.edit if evaluation exists
                        window.location.href = response.evaluation.edit_url;
                    } else {
                        console.log(response);
                        // Redirect to evaluations.create if no evaluation exists
                        window.location.href = "{{ route('closed_cases.create', ':case_id') }}"
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
document.addEventListener("DOMContentLoaded", function () {
    // Load final outcomes from DB and populate the edit dropdown
    fetch('{{ route('case_closures.final_outcomes') }}')
        .then(response => response.json())
        .then(outcomes => {
            const select = document.getElementById('edit_final_outcome');
            const defaultOptions = ['Win', 'Loss', 'Dismissed', 'Settled']; // Always show these

            const seen = new Set();
            // Add DB outcomes if not in default
            outcomes.forEach(outcome => {
                const cleaned = outcome.trim();
                if (!defaultOptions.includes(cleaned) && !seen.has(cleaned)) {
                    const opt = document.createElement('option');
                    opt.value = cleaned;
                    opt.textContent = cleaned;
                    select.insertBefore(opt, select.querySelector('option[value="Other"]'));
                    seen.add(cleaned);
                }
            });
        });

    // Toggle "Other" input field visibility
    const outcomeSelect = document.getElementById('edit_final_outcome');
    const otherGroup = document.getElementById('edit_final_outcome_other_group');

    outcomeSelect.addEventListener('change', function () {
        if (this.value === 'Other') {
            otherGroup.classList.remove('d-none');
            document.getElementById('edit_final_outcome_other').required = true;
        } else {
            otherGroup.classList.add('d-none');
            document.getElementById('edit_final_outcome_other').required = false;
        }
    });
});
</script>

@endpush
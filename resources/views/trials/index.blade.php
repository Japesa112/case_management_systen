@extends('layouts.default')

@section('title', 'Manage Trials')

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
<div class="container-fluid mt-4">
    @php
    use Illuminate\Support\Str;
    @endphp
    
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">List of Trials</h4>
            <div class="panel-heading-btn">
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addEvaluationModal">
                    <i class="fa fa-plus"></i> Add New Trial
                </button>
            </div>
        </div>
        <div class="panel-body">
            
             <!-- Modal -->
             <div class="modal fade" id="addEvaluationModal" tabindex="-1" aria-labelledby="addEvaluationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color: rgb(1, 9, 12)" id="addEvaluationModalLabel">Create New Trial</h5>
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
                                    <button type="submit" class="btn btn-primary">Create Trial</button>
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
                            <th>Trial Date</th>
                            
                            <th>Judgement Date</th>
                            <th>Outcome</th>
                            <th>Judgement Details</th>
                            <th>Next Step</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

            
                    <tbody>
                        @foreach($trials as $trial)
                            <tr>
                                <td class="text-center">{{ $trial->trial_id }}</td>
                                
                                 <td class="text-center">
                                 @if($trial->case)
                                    <a href="{{ route('cases.show', $trial->case->case_id) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center" title="View Case">
                                        <i class="fa fa-eye me-1"></i> {{ $trial->case->case_name }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                                 </td>

                                <td class="text-center">{{ $trial->trial_date}}</td>
                                <td class="text-center">{{ $trial->judgement_date}}</td>
                                <td class="text-center">{{ $trial->outcome}}</td>
                                <td> {{ Str::limit($trial->judgement_details ?? 'No comments', 30) }}  </td>
                                <td>
                                @if($trial->case)
                                 <a href="{{ route('lawyer_payments.create', $trial->case->case_id) }}" 
                                       class="btn btn-sm btn-outline-success d-inline-flex align-items-center" 
                                       title="Lawyer Payment">
                                        <i class="fa fa-gavel me-1"></i> Lawyer Payment
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>

                                <td class="text-center action-buttons">
                                    <button class="btn btn-warning btn-sm edit-trial" data-id="{{ $trial->trial_id }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>

                                    <button class="btn btn-info btn-sm view-trial" data-id="{{ $trial->trial_id }}">
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



<!-- Edit trial Modal -->
<div class="modal fade" id="editTrialModal" tabindex="-1" aria-labelledby="editTrialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editTrialModalLabel">Edit Trial</h5>
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
                        <button type="button" class="btn btn-success btn-sm"  id="openUploadModalBtn">
                            <i class="fa fa-plus"></i> Add Attachment
                        </button>
                    </div>

                    <!-- Right Section: Edit trial Form -->
                    <div class="col-md-7">
                        <form id="editTrialForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                        
                            <input type="hidden" id="edit_trial_id" name="trial_id">
                            <input type="hidden" class="form-control" id="edit_case_id" name="case_id" readonly>
                        
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit_case_name" class="form-label">Case Name</label>
                                        <input type="text" class="form-control" id="edit_case_name" name="case_name" readonly disabled>
                                    </div>
                        
                                    <div class="mb-3">
                                        <label for="edit_trial_date" class="form-label">Trial Date <span class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control" id="edit_trial_date" name="trial_date" required>
                                    </div>
                        
                                    <div class="mb-3">
                                        <label for="edit_judgement_date" class="form-label">Judgement Date</label>
                                        <input type="datetime-local" class="form-control" id="edit_judgement_date" name="judgement_date">
                                    </div>
                                </div>
                        
                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit_outcome" class="form-label">Outcome <span class="text-danger">*</span></label>
                                        <select class="form-control" id="edit_outcome" name="outcome" required>
                                            <option value="">Select Outcome</option>
                                            <option value="Win">Win</option>
                                            <option value="Loss">Loss</option>
                                            <option value="Adjourned">Adjourned</option>
                                        </select>
                                    </div>
                        
                                    <div class="mb-3">
                                        <label for="edit_judgement_details" class="form-label">Judgement Details</label>
                                        <textarea class="form-control" id="edit_judgement_details" name="judgement_details" rows="3"></textarea>
                                    </div>
                        
                                    
                                </div>
                            </div>
                        
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="updateTrialBtn">
                                    Update Trial
                                </button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Upload Attachment Modal -->
<div class="modal fade" id="uploadAttachmentModal" tabindex="-1" aria-labelledby="uploadAttachmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="uploadAttachmentModalLabel">Upload Attachment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modal_trial_id">
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
        $(document).on('click', '.view-trial', function () {
            let trialId = $(this).data('id');

            // Show the modal
            $('#viewTrialModal').modal('show');

            // Display a loading indicator
            $('#trial-content').html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading details...</div>');

            // Fetch trial details
            $.ajax({
                url: "{{ route('trials.show', ':id') }}".replace(':id', trialId),
                type: "GET",
                success: function (response) {
                    let trial = response.trial;
                    let attachments = response.attachments;
                    let case_name = response.case_name;

                    let content = `
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Case Name:</strong> ${case_name ?? 'N/A'}<br>
                            <strong>Trial Date:</strong> ${trial.trial_date ?? 'N/A'}<br>
                             <strong>Trial Time:</strong> ${trial.trial_time ?? 'N/A'}<br>
                            <strong>Judgement Details:</strong> <p>${trial.judgement_details ?? 'N/A'}</p>
                            <strong>Judgement Date:</strong> ${trial.judgement_date ?? 'N/A'}<br>
                             <strong>Judgement Time:</strong> ${trial.judgement_time ?? 'N/A'}<br>
                        </div>
                        <div class="col-md-6">
                            <strong>Outcome:</strong> ${trial.outcome ?? 'N/A'}<br>
                            <strong>Created At:</strong> ${trial.created_at ?? 'N/A'}<br>
                            <strong>Updated At:</strong> ${trial.updated_at ?? 'N/A'}<br>
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

                    $('#trial-content').html(content);
                },
                error: function () {
                    $('#trial-content').html('<div class="text-danger text-center">Error loading trial details.</div>');
                }
            });
        });

        $(document).ready(function () {
    $(document).on('click', '.edit-trial', function () {
        let trialId = $(this).data('id');
    
        // Fetch trial details using AJAX
        $.ajax({
            url: `trials/show/${trialId}`, // Make sure this route exists in your Laravel routes
            type: "GET",
            success: function (response) {
                let trial = response.trial;
                let attachments = response.attachments; // Get attachments correctly
                let case_name = response.case_name;
                let formattedJudgementDateTime = response.formattedJudgementDateTime;
                let formattedTrialDateTime = response.formattedTrialDateTime;

                // Populate form fields with fetched data
              // Populate form fields with fetched data
                    $('#edit_trial_id').val(trial.trial_id);
                    $('#edit_case_id').val(trial.case_id);
                    $('#edit_case_name').val(case_name);
                    $('#edit_trial_date').val(formattedTrialDateTime);
                    $('#edit_judgement_date').val(formattedJudgementDateTime);
                    $('#edit_judgement_details').val(trial.judgement_details);
                    $('#edit_outcome').val(trial.outcome);





                 // Clear and populate document list
                 $('#documentList').empty();
                if (attachments.length > 0) {
                    attachments.forEach(doc => {
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
                $('#editTrialModal').modal('show');
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Update Failed",
                    text: errorMessage,
                });
            }
        });
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
                url: `/trials/deleteDocuments/${documentId}`,
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
    // Open modal and set trial ID
    $("#openUploadModalBtn").click(function () {
        let trialId = $("#edit_trial_id").val(); // Ensure the trial ID is available
        $("#modal_trial_id").val(trialId);
        $("#uploadAttachmentModal").modal("show");
    });

    // Upload file when clicking "Upload" in the modal
    $("#modal_uploadAttachmentBtn").click(function () {
        let trialId = $("#modal_trial_id").val();
       
        let fileInput = $("#modal_attachmentFile")[0].files[0];

        if (!fileInput) {
            Swal.fire({
                icon: "warning", // Use "warning" icon
                title: "No File Selected",
                text: "Please select a file to upload.",
                confirmButtonColor: "#d33", // Optional: Customize button color
            });

            return;
        }

        let formData = new FormData();
        formData.append("trial_id", trialId);
        formData.append("attachment", fileInput);
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

        $.ajax({
            url: "/trials/uploadAttachment",
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
                Swal.fire({
                    icon: "error",
                    title: "Upload Failed",
                    text: "Upload failed. " + xhr.responseJSON.error,
                });

            }
        });
    });
});

//Updating the trial
$(document).ready(function () {
    $("#editTrialForm").on("submit", function (e) {
        e.preventDefault(); // Prevent default form submission

        let formData = new FormData(this);
        let trialId = $("#edit_trial_id").val(); // Get trial ID
        let url = `/trials/update/${trialId}`; // Construct the update route URL
        console.log("trial ID:", $("#edit_trial_id").val());
        console.log("Form Data:", Object.fromEntries(new FormData($("#editTrialForm")[0])));
        
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
                    text: "Trial has been updated successfully!",
                }).then(() => {
                    window.location.href = "/trials"; // Redirect after success
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
    
            let caseNumber = $('#case_number').val();
    
            $.ajax({
                url: "{{ route('trials.checkCase') }}", 
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
                            window.location.href = "{{ route('trials.create', ':case_id') }}"
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
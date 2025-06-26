@extends('layouts.default')

@section('title', 'Manage Preparations')

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
    <h4>List of Trial Preparations</h4>
    <div class="panel panel-inverse">
        <div class="panel-heading d-flex justify-content-between align-items-center">
            <a href="{{ route('cases.index') }}" class="btn btn-dark btn-sm d-flex align-items-center gap-2">
                <i class="fa fa-arrow-left text-white fw-bold"></i> <span class="text-white">Back to Cases</span>
            </a>
            <div class="panel-heading-btn">
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addEvaluationModal">
                    <i class="fa fa-plus"></i> Add New Preparation
                </button>
            </div>
        </div>
        <div class="panel-body">
            
             <!-- Modal -->
             <div class="modal fade" id="addEvaluationModal" tabindex="-1" aria-labelledby="addEvaluationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color: rgb(1, 9, 12)" id="addEvaluationModalLabel">Create New Preparation</h5>
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
                                    <button type="submit" class="btn btn-primary">Create Preparation</button>
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
                            <th>Preparation Date</th>
                            <th>Preparation Status	</th>
                            <th>Briefing Notes</th>
                            <th>Next Step</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trialPreparations as $preparation)
                            <tr>
                                <td class="text-center">{{ $preparation->preparation_id }}</td>
                                
                                <td class="text-center">
                                 @if($preparation->case)
                                    <a href="{{ route('cases.show', $preparation->case->case_id) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center" title="View Case">
                                        <i class="fa fa-eye me-1"></i> {{ $preparation->case->case_name }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                                 </td>

                                <td class="text-center">{{ $preparation->preparation_date}}</td>
                                <td class="text-center">{{ $preparation->preparation_status}}</td>
                                <td> {{ Str::limit($preparation->briefing_notes ?? 'No comments', 30) }}  </td>
                                <td>
                                    @if($preparation->case)
                                        <a href="{{ route('trials.create', $preparation->case->case_id) }}" 
                                           class="btn btn-sm btn-outline-success d-inline-flex align-items-center mb-1" 
                                           title="Trial">
                                            <i class="fa fa-gavel me-1"></i> Trial
                                        </a>
                                        <a href="{{ route('witnesses.create', $preparation->case->case_id) }}" 
                                           class="btn btn-sm btn-outline-primary d-inline-flex align-items-center" 
                                           title="Add Witness">
                                            <i class="fa fa-user-plus me-1"></i> Witness
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>

                              <td class="text-center action-buttons">
                                  <div class="d-flex justify-content-center gap-2">
                                    <!-- Edit Button -->
                                    <button class="btn btn-warning btn-sm edit-preparation" data-id="{{ $preparation->preparation_id }}" title="Edit Preparation">
                                      <i class="fa fa-edit me-1"></i> Edit
                                    </button>

                                    <!-- View Button -->
                                    <button class="btn btn-info btn-sm view-preparation" data-id="{{ $preparation->preparation_id }}" title="View Preparation">
                                      <i class="fa fa-eye me-1"></i> View
                                    </button>

                                    <!-- Delete Button -->
                                    <form id="delete-preparation-form-{{ $preparation->preparation_id }}"
                                          action="{{ route('trial_preparations.destroy', $preparation->preparation_id) }}"
                                          method="POST" class="d-inline">
                                      @csrf
                                      @method('DELETE')
                                      <button type="button"
                                              class="btn btn-danger btn-sm swal-delete-preparation-btn"
                                              data-id="{{ $preparation->preparation_id }}"
                                              title="Delete Preparation">
                                        <i class="fa fa-trash me-1"></i> Delete
                                      </button>
                                    </form>
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



<!-- Edit Preparation Modal -->
<div class="modal fade" id="editPreparationModal" tabindex="-1" aria-labelledby="editPreparationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editPreparationModalLabel">Edit Preparation</h5>
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

                    <!-- Right Section: Edit Preparation Form -->
                    <div class="col-md-7">
                        <form id="editPreparationForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                        
                            <input type="hidden" id="edit_preparation_id" name="preparation_id">
                            <input type="hidden" id="edit_case_id" name="case_id">
                        
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit_case_name" class="form-label">Case Name</label>
                                        <input type="text" class="form-control" id="edit_case_name" name="case_name" readonly disabled>
                                    </div>
                        
                                    <div class="mb-3">
                                        <label for="edit_preparation_date" class="form-label">Preparation Date <span class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control" id="edit_preparation_date" name="preparation_date" required>
                                    </div>
                        
                                    
                                </div>
                        
                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="edit_preparation_status" class="form-label">Preparation Status <span class="text-danger">*</span></label>
                                        <select class="form-control" id="edit_preparation_status" name="preparation_status" required>
                                            <option value="Pending">Pending</option>
                                            <option value="Ongoing">Ongoing</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_briefing_notes" class="form-label">Briefing Notes</label>
                                        <textarea class="form-control" id="edit_briefing_notes" name="briefing_notes" rows="3"></textarea>
                                    </div>
                        
                                    
                        
                                   
                                </div>
                            </div>
                        
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="updatePreparationBtn">
                                    Update Preparation
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
                <input type="hidden" id="modal_preparation_id">
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
        $(document).on('click', '.view-preparation', function () {
            let preparationId = $(this).data('id');

            // Show the modal
            $('#viewPreparationModal').modal('show');

            // Display a loading indicator
            $('#preparation-content').html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading details...</div>');

            // Fetch preparation details
            $.ajax({
                url: "{{ route('preparations.show', ':id') }}".replace(':id', preparationId),
                type: "GET",
                success: function (response) {
                    let preparation = response.preparation;
                    let attachments = response.attachments;
                    let case_name = response.case_name;

                    let content = `
                    <div class="row">
                        <div class="col-md-6">
                            
                            <strong>Case Name:</strong> ${case_name ?? 'N/A'}<br>
                            <strong>Preparation Date:</strong> ${preparation.preparation_date ?? 'N/A'}<br>
                            <strong>Preparation Time:</strong> ${preparation.preparation_time ?? 'N/A'}<br>
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong> ${preparation.preparation_status ?? 'N/A'}<br>
                            <strong>Briefing Notes:</strong> <p>${preparation.briefing_notes ?? 'N/A'}</p>
                            <strong>Created At:</strong> ${preparation.created_at ?? 'N/A'}<br>
                            <strong>Updated At:</strong> ${preparation.updated_at ?? 'N/A'}<br>
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

                    $('#preparation-content').html(content);
                },
                error: function () {
                    $('#preparation-content').html('<div class="text-danger text-center">Error loading preparation details.</div>');
                }
            });
        });

        $(document).ready(function () {
    $(document).on('click', '.edit-preparation', function () {
        let preparationId = $(this).data('id');
    
        // Fetch preparation details using AJAX
        $.ajax({
            url: "{{ route('preparations.show', ':id') }}".replace(':id', preparationId), // Make sure this route exists in your Laravel routes
            type: "GET",
            success: function (response) {
                let preparation = response.preparation;
                let attachments = response.attachments; // Get attachments correctly
                let case_name = response.case_name;
                let formattedDateTime = response.formattedDateTime
              // Populate form fields with fetched data
                $('#edit_preparation_id').val(preparation.preparation_id);
                $('#edit_case_id').val(preparation.case_id);
                $('#edit_case_name').val(case_name);
                $('#edit_preparation_date').val(formattedDateTime);
                $('#edit_preparation_status').val(preparation.preparation_status);
                $('#edit_briefing_notes').val(preparation.briefing_notes);





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
                $('#editPreparationModal').modal('show');
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error fetching preparation details.',
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
                url: "{{ route('preparations.deleteDocument', ':id') }}".replace(':id', documentId),
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
    // Open modal and set preparation ID
    $("#openUploadModalBtn").click(function () {
        let preparationId = $("#edit_preparation_id").val(); // Ensure the preparation ID is available
        $("#modal_preparation_id").val(preparationId);
        $("#uploadAttachmentModal").modal("show");
    });

    // Upload file when clicking "Upload" in the modal
    $("#modal_uploadAttachmentBtn").click(function () {
        let preparationId = $("#modal_preparation_id").val();
       
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
        formData.append("preparation_id", preparationId);
        formData.append("attachment", fileInput);
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

        $.ajax({
            url: "{{ route('preparations.uploadAttachment') }}",
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

//Updating the preparation
$(document).ready(function () {
    $("#editPreparationForm").on("submit", function (e) {
        e.preventDefault(); // Prevent default form submission

        let formData = new FormData(this);
        let preparationId = $("#edit_preparation_id").val(); // Get preparation ID
        let url = "{{ route('preparations.update', ':id') }}".replace(':id', preparationId); // Construct the update route URL
        console.log("Preparation ID:", $("#edit_preparation_id").val());
        console.log("Form Data:", Object.fromEntries(new FormData($("#editPreparationForm")[0])));
        
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
                    text: "Preparation has been updated successfully!",
                }).then(() => {
                    window.location.href = "{{ route('preparations.index') }}";
 // Redirect after success
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
                url: "{{ route('preparations.checkCase') }}", 
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
                            window.location.href = "{{ route('preparations.create', ':case_id') }}"
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
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.swal-delete-preparation-btn').forEach(button => {
      button.addEventListener('click', function () {
        const id = this.dataset.id;

        Swal.fire({
          title: 'Are you sure?',
          text: "This trial preparation will be permanently deleted.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'Cancel'
        }).then((result) => {
          if (result.isConfirmed) {
            document.getElementById('delete-preparation-form-' + id).submit();
          }
        });
      });
    });
  });
</script>
     
@endpush
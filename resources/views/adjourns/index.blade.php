@extends('layouts.default')

@section('title', 'Manage Adjourn')

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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

</style>
@endpush

@section('content')
<div class="container-fluid mt-4">
    <h4>List of Adjourned Cases</h4>
    <div class="panel panel-inverse">
        <div class="panel-heading d-flex justify-content-between align-items-center">
            <a href="{{ url('/cases') }}" class="btn btn-dark btn-sm d-flex align-items-center gap-2">
                <i class="fa fa-arrow-left text-white fw-bold"></i> <span class="text-white">Back to Cases</span>
            </a>
            <div class="panel-heading-btn">
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addEvaluationModal">
                    <i class="fa fa-plus"></i> Add New Case Adjourn
                </button>
            </div>
        </div>
        <div class="panel-body">
            
             <!-- Modal -->
             <div class="modal fade" id="addEvaluationModal" tabindex="-1" aria-labelledby="addEvaluationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color: rgb(1, 9, 12)" id="addEvaluationModalLabel">Create New Adjourn</h5>
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
                                    <button type="submit" class="btn btn-primary">Create Adjourn</button>
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
                <table id="data-adjourn" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Case Name</th>
                            <th>Next Hearing Date</th>
                            <th>Comments</th>
                            <th>Next Step</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($adjourns as $adjourn)
                            <tr>
                                <td class="text-center">{{ $adjourn->adjourns_id }}</td>
                                
                                <td class="text-center">
                                 @if($adjourn->case)
                                    <a href="{{ route('cases.show', $adjourn->case->case_id) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center" title="View Case">
                                        <i class="fa fa-eye me-1"></i> {{ $adjourn->case->case_name }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                                 </td>

                                <td class="text-center">{{ $adjourn->next_hearing_date ?? 'N/A' }}</td>
                                <td>{{ $adjourn->adjourn_comments ?? 'No comments' }}</td>
                                <td>
                                @if($adjourn->case)
                                 <a href="{{ route('preparations.create', $adjourn->case->case_id) }}" 
                                       class="btn btn-sm btn-outline-success d-inline-flex align-items-center" 
                                       title="Trial Preparation">
                                        <i class="fa fa-gavel me-1"></i> Trial Preparation
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                               <td class="text-center action-buttons">

                                    <!-- Edit Button -->
                                    <button class="btn btn-warning btn-sm edit-adjourn" data-id="{{ $adjourn->adjourns_id }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>

                                    <!-- View Button -->
                                    <button class="btn btn-info btn-sm view-adjourn" data-id="{{ $adjourn->adjourns_id }}">
                                        <i class="fa fa-eye"></i> View
                                    </button>

                                    <!-- Delete Button -->
                                    <form id="delete-adjourn-form-{{ $adjourn->adjourns_id }}"
                                          action="{{ route('adjourns.destroy', $adjourn->adjourns_id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-danger btn-sm swal-delete-adjourn-btn"
                                                data-id="{{ $adjourn->adjourns_id }}"
                                                title="Delete Adjournment">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>

                                
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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


<!-- Edit Adjourn Modal -->
<div class="modal fade" id="editAdjournModal" tabindex="-1" aria-labelledby="editAdjournModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editAdjournModalLabel">Edit Adjourn</h5>
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

                    <!-- Right Section: Edit Adjourn Form -->
                    <div class="col-md-7">
                        <form id="editAdjournForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" id="edit_adjourn_id" name="adjourn_id">
                            <input type="hidden" class="form-control" id="edit_case_id" name="case_id" readonly>
                           
                            <div class="mb-3">
                                <label for="edit_case_id" class="form-label">Case Name</label>
                                <input type="text" class="form-control" id="edit_case_name" name="case_name" readonly disabled>
                            </div>

                            <div class="mb-3">
                                <label for="edit_next_hearing_date" class="form-label">Next Hearing Date</label>
                                <input type="datetime-local" class="form-control" id="edit_next_hearing_date" name="next_hearing_date">
                            </div>

                            <div class="mb-3">
                                <label for="edit_adjourn_comments" class="form-label">Adjourn Comments</label>
                                <textarea class="form-control" id="edit_adjourn_comments" name="adjourn_comments" rows="3"></textarea>
                            </div>
                            <!--
                            <div class="mb-3">
                                <label for="editAttachments" class="form-label">Upload New Attachments</label>
                                <input type="file" class="form-control" id="editAttachments" name="attachments[]" multiple>
                            </div>
                        -->

                            <button type="submit" class="btn btn-primary" id="updateAdjournBtn">
                                Update Adjourn
                            </button>
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
                <input type="hidden" id="modal_adjourn_id">
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
        $(document).on('click', '.view-adjourn', function () {
            let adjournId = $(this).data('id');

            // Show the modal
            $('#viewAdjournModal').modal('show');

            // Display a loading indicator
            $('#adjourn-content').html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading details...</div>');

            // Fetch adjourn details
            $.ajax({
                url: "{{ route('adjourns.show', ':id') }}".replace(':id', adjournId),
                type: "GET",
                success: function (response) {
                    let adjourn = response.adjourn;
                    let attachments = response.attachments;
                    let case_name = response.case_name;

                    let content = `
                        <div class="row">
                            <div class="col-md-6">
                              <strong>Case Name:</strong> ${case_name ?? 'N/A'}<br>
                                <strong>Next Hearing Date:</strong> ${adjourn.next_hearing_date ?? 'N/A'}<br>
                                 <strong>Next Hearing Time:</strong> ${adjourn.next_hearing_time ?? 'N/A'}<br>
                                <strong>Adjourn Comments:</strong> <p>${adjourn.adjourn_comments ?? 'N/A'}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Created At:</strong> ${adjourn.created_at ?? 'N/A'}<br>
                                <strong>Updated At:</strong> ${adjourn.updated_at ?? 'N/A'}<br>
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

                    $('#adjourn-content').html(content);
                },
                error: function () {
                    $('#adjourn-content').html('<div class="text-danger text-center">Error loading adjourn details.</div>');
                }
            });
        });

        $(document).ready(function () {
    $(document).on('click', '.edit-adjourn', function () {
        let adjournId = $(this).data('id');
    
        // Fetch adjourn details using AJAX
        $.ajax({
            url: `adjourns/show/${adjournId}`, // Make sure this route exists in your Laravel routes
            type: "GET",
            success: function (response) {
                let adjourn = response.adjourn;
                let attachments = response.attachments; // Get attachments correctly
                let case_name = response.case_name;
                let formattedDateTime = response.formattedDateTime;
                // Populate form fields with fetched data
                $('#edit_adjourn_id').val(adjourn.adjourns_id);
                $('#edit_case_id').val(adjourn.case_id);
                $('#edit_case_name').val(case_name);
                $('#edit_next_hearing_date').val(formattedDateTime);
                $('#edit_adjourn_comments').val(adjourn.adjourn_comments);




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
                $('#editAdjournModal').modal('show');
            },
            error: function () {
                alert("Error fetching adjourn details.");
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
                url: `/adjourns/deleteDocuments/${documentId}`,
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
    // Open modal and set adjourn ID
    $("#openUploadModalBtn").click(function () {
        let adjournId = $("#edit_adjourn_id").val(); // Ensure the adjourn ID is available
        console.log("Adjourn ID: "+adjournId);
        $("#modal_adjourn_id").val(adjournId);
        $("#uploadAttachmentModal").modal("show");
    });

    // Upload file when clicking "Upload" in the modal
    $("#modal_uploadAttachmentBtn").click(function () {
        let adjournId = $("#modal_adjourn_id").val();
        console.log("Adjourn ID: "+adjournId);

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
        formData.append("adjourns_id", adjournId);
        formData.append("attachment", fileInput);
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

        $.ajax({
            url: "/adjourns/uploadAttachment",
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

//Updating the Adjourn
$(document).ready(function () {
    $("#editAdjournForm").on("submit", function (e) {
        e.preventDefault(); // Prevent default form submission

        let formData = new FormData(this);
        let adjournId = $("#edit_adjourn_id").val(); // Get adjourn ID
        let url = `/adjourns/update/${adjournId}`; // Construct the update route URL
        console.log("Adjourn ID:", $("#edit_adjourn_id").val());
        console.log("Form Data:", Object.fromEntries(new FormData($("#editAdjournForm")[0])));
        
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
                    text: "Adjournhas been updated successfully!",
                }).then(() => {
                    window.location.href = "/adjourns"; // Redirect after success
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
                url: "{{ route('adjourns.checkCase') }}", 
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
                            window.location.href = "{{ route('adjourns.create', ':case_id') }}"
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
        $('#data-adjourn').DataTable(
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
        document.querySelectorAll('.swal-delete-adjourn-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This adjournment will be permanently deleted.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-adjourn-form-' + id).submit();
                    }
                });
            });
        });
    });
</script>

@endpush
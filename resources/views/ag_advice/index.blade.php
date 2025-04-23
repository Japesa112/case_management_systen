@extends('layouts.default')

@section('title', 'Manage AG Advice')

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
</style>
@endpush

@section('content')
<div class="container-fluid mt-4">
    @php
    use Illuminate\Support\Str;
    @endphp

    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">List of Advice</h4>
            <div class="panel-heading-btn">
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addEvaluationModal">
                    <i class="fa fa-plus"></i> Add New AG Advice
                </button>
            </div>
        </div>
        <div class="panel-body">
            
             <!-- Modal -->
             <div class="modal fade" id="addEvaluationModal" tabindex="-1" aria-labelledby="addEvaluationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color: rgb(1, 9, 12)" id="addEvaluationModalLabel">Create New AG Advice</h5>
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
                                    <button type="submit" class="btn btn-primary">Create Advice</button>
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
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Case Name</th>
                            <th>Advice Date</th>
                            <th>Advice Details</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($advices as $advice)
                            <tr>
                                <td class="text-center">{{ $advice->ag_advice_id}}</td>
                                <td class="text-center">{{ $advice->case->case_name }}</td>
                                <td class="text-center">{{ $advice->advice_date ?? 'N/A' }}</td>
                                <td>{{ Str::limit($advice->ag_advice, 50) }}  </td>
                                <td class="text-center action-buttons">
                                    <button class="btn btn-warning btn-sm edit-advice" data-id="{{ $advice->ag_advice_id }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>

                                    <button class="btn btn-info btn-sm view-advice" data-id="{{ $advice->ag_advice_id }}">
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


<!-- Edit Advice Modal -->
<div class="modal fade" id="editAdviceModal" tabindex="-1" aria-labelledby="editAdviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editAdviceModalLabel">Edit Advice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                  
                    
                        <form id="editAdviceForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" id="edit_advice_id" name="ag_advice_id">
                            <input type="hidden" class="form-control" id="edit_case_id" name="case_id" readonly>
                           
                            <div class="mb-3">
                                <label for="edit_case_id" class="form-label">Case Name</label>
                                <input type="text" class="form-control" id="edit_case_name" name="case_name" readonly disabled>
                            </div>

                            <div class="mb-3">
                                <label for="edit_advice_date" class="form-label">Advice Date</label>
                                <input type="datetime-local" class="form-control" id="edit_advice_date" name="advice_date">
                            </div>
                           
                            <div class="mb-3">
                                <label for="edit_ag_advice" class="form-label">Advice Details</label>
                                <textarea class="form-control" id="edit_ag_advice" name="ag_advice" rows="3" required></textarea>
                            </div>
                            <!--
                            <div class="mb-3">
                                <label for="editAttachments" class="form-label">Upload New Attachments</label>
                                <input type="file" class="form-control" id="editAttachments" name="attachments[]" multiple>
                            </div>
                        -->

                            <button type="submit" class="btn btn-primary" id="updateAdviceBtn">
                                Update Advice
                            </button>
                        </form>
                
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
                <input type="hidden" id="modal_advice_id">
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
        $(document).on('click', '.view-advice', function () {
            let ag_advice_id = $(this).data('id');

            console.log("The AG Advice: "+ag_advice_id);

            // Show the modal
            $('#viewAdviceModal').modal('show');

            // Display a loading indicator
            $('#advice-content').html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading details...</div>');

            // Fetch advice details
            $.ajax({
                url: "{{ route('ag_advice.show', ':id') }}".replace(':id', ag_advice_id),
                type: "GET",
                success: function (response) {
                    let advice = response.advice;
                    let case_name = response.case_name;

                    let content = `
                        <div class="row">
                            <div class="col-md-6">
                              <strong>Case Name:</strong> ${case_name ?? 'N/A'}<br>
                                <strong>Advice Date:</strong> ${advice.advice_date ?? 'N/A'}<br>
                                <strong>Advice Time:</strong> ${advice.advice_time ?? 'N/A'}<br>
                                <strong>Advice Comments:</strong> <p>${advice.ag_advice ?? 'N/A'}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Created At:</strong> ${advice.created_at ?? 'N/A'}<br>
                                <strong>Updated At:</strong> ${advice.updated_at ?? 'N/A'}<br>
                            </div>
                        </div>
                        <hr>
                      
                    `;

                    

                    content += `</ul>`;

                    $('#advice-content').html(content);
                },
                error: function () {
                    $('#advice-content').html('<div class="text-danger text-center">Error loading advice details.</div>');
                }
            });
        });

        $(document).ready(function () {
    $(document).on('click', '.edit-advice', function () {
        let ag_advice_id = $(this).data('id');
    
        // Fetch advice details using AJAX
        $.ajax({
            url: `ag_advice/show/${ag_advice_id}`, // Make sure this route exists in your Laravel routes
            type: "GET",
            success: function (response) {
                let advice = response.advice;
                let case_name = response.case_name;
                let formattedDateTime  = response.formattedDateTime;

                // Populate form fields with fetched data
                $('#edit_advice_id').val(advice.ag_advice_id);
                $('#edit_case_id').val(advice.case_id);
                $('#edit_case_name').val(case_name);
                $('#edit_advice_date').val(formattedDateTime);
                $('#edit_ag_advice').val(advice.ag_advice);




               

                // Show the modal
                $('#editAdviceModal').modal('show');
            },
            error: function () {
                alert("Error fetching advice details.");
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
                url: `/ag_advice/deleteDocuments/${documentId}`,
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
    // Open modal and set advice ID
    $("#openUploadModalBtn").click(function () {
        let ag_advice_id = $("#edit_advice_id").val(); // Ensure the advice ID is available
        console.log("Advice ID: "+ag_advice_id);
        $("#modal_advice_id").val(ag_advice_id);
        $("#uploadAttachmentModal").modal("show");
    });

    // Upload file when clicking "Upload" in the modal
    $("#modal_uploadAttachmentBtn").click(function () {
        let ag_advice_id = $("#modal_advice_id").val();
        console.log("Advice ID: "+ag_advice_id);

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
        formData.append("ag_advice_id", ag_advice_id);
        formData.append("attachment", fileInput);
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

        $.ajax({
            url: "/ag_advice/uploadAttachment",
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

//Updating the advice
$(document).ready(function () {
    $("#editAdviceForm").on("submit", function (e) {
        e.preventDefault(); // Prevent default form submission

        let formData = new FormData(this);
        let ag_advice_id = $("#edit_advice_id").val(); // Get advice ID
        let url = `/ag_advice/update/${ag_advice_id}`; // Construct the update route URL
        console.log("Advice ID:", $("#edit_advice_id").val());
        console.log("Form Data:", Object.fromEntries(new FormData($("#editAdviceForm")[0])));
        
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
                    text: "Advice has been updated successfully!",
                }).then(() => {
                    window.location.href = "/ag_advice"; // Redirect after success
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
                url: "{{ route('ag_advice.checkCase') }}", 
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
                            window.location.href = "{{ route('ag_advice.create', ':case_id') }}"
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
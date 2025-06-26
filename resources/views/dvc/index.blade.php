@extends('layouts.default')

@section('title', 'Manage Appointment')

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
    <div class="panel panel-inverse">
        <div class="panel-heading d-flex justify-content-between align-items-center">
            <a href="{{ route('cases.index') }}" class="btn btn-dark btn-sm d-flex align-items-center gap-2">
                <i class="fa fa-arrow-left text-white fw-bold"></i> <span class="text-white">Back to Cases</span>
            </a>
            <div class="panel-heading-btn">
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addEvaluationModal">
                    <i class="fa fa-plus"></i> Add New Appointment
                </button>
            </div>
        </div>
        <div class="panel-body">
            
             <!-- Modal -->
            <div class="modal fade" id="addEvaluationModal" tabindex="-1" aria-labelledby="addEvaluationModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title text-dark" id="addEvaluationModalLabel">Create New Appointment</h5>
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
                            <button type="submit" class="btn btn-primary">Create Appointment</button>
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
                @endif

                @if(session('error'))
                    <div class="alert alert-danger" id="error-message">
                        {{ session('error') }}
                    </div>
                @endif

                <script>
                    setTimeout(function () {
                        var successMsg = document.getElementById('success-message');
                        if (successMsg) successMsg.style.display = 'none';

                        var errorMsg = document.getElementById('error-message');
                        if (errorMsg) errorMsg.style.display = 'none';
                    }, 5000); // Hide messages after 5 seconds
                </script>

            
            
            <div class="table-responsive">
                <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Case Name</th>
                            <th>Appointment Date & Time</th>
                            <th>Comments</th>
                            <th>Next Step</th>
                            <th>Actions</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td class="text-center">{{ $appointment->appointment_id }}</td>
                                

                                <td class="text-center">
                                 @if($appointment->evaluation->case)
                                    <a href="{{ route('cases.show', $appointment->evaluation->case->case_id) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center" title="View Case">
                                        <i class="fa fa-eye me-1"></i> {{ $appointment->evaluation->case->case_name }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                                 </td>

                                <td class="text-center">{{ $appointment->appointment_date ?? 'N/A' }} {{ $appointment->appointment_time ?? 'N/A' }}</td>
                                <td>{{ $appointment->comments ?? 'No comments' }}</td>

                                <td>
                                @if($appointment->evaluation->case)
                                 <a href="{{ route('preparations.create', $appointment->evaluation->case->case_id) }}" 
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
                                <button class="btn btn-warning btn-sm edit-appointment" data-id="{{ $appointment->appointment_id }}">
                                    <i class="fa fa-edit"></i> Edit
                                </button>

                                <!-- View Button -->
                                <button class="btn btn-info btn-sm view-appointment" data-id="{{ $appointment->appointment_id }}">
                                    <i class="fa fa-eye"></i> View
                                </button>

                                <!-- Delete Button -->
                                <form id="delete-appointment-form-{{ $appointment->appointment_id }}" 
                                      action="{{ route('appointments.destroy', $appointment->appointment_id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn btn-danger btn-sm swal-delete-appointment-btn" 
                                            data-id="{{ $appointment->appointment_id }}">
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



<!-- View Appointment Modal -->
<div class="modal fade" id="viewAppointmentModal" tabindex="-1" aria-labelledby="viewAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewAppointmentModalLabel">Appointment Details</h5>
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


<!-- Edit Appointment Modal -->
<div class="modal fade" id="editAppointmentModal" tabindex="-1" aria-labelledby="editAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editAppointmentModalLabel">Edit Appointment</h5>
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

                    <!-- Right Section: Edit Appointment Form -->
                    <div class="col-md-7">
                        <form id="editAppointmentForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" id="edit_appointment_id" name="appointment_id">
                            <input type="hidden" class="form-control" id="edit_case_id" name="case_id" readonly>
                            <input type="hidden" name="forwarding_id" id="edit_forwarding_id">
                            <input type="hidden" name="evaluation_id" id="edit_evaluation_id">
                               
                           
                            <div class="mb-3">
                                <label for="edit_case_id" class="form-label">Case Name</label>
                                <input type="text" class="form-control" id="edit_case_name" name="case_name" readonly disabled>
                            </div>

                            <div class="mb-3">
                                <label for="edit_next_hearing_date" class="form-label">Next Hearing Date</label>
                                <input type="datetime-local" class="form-control" id="edit_next_hearing_date" name="next_hearing_date">
                            </div>

                            <div class="mb-3">
                                <label for="edit_appointment_comments" class="form-label">Appointment Comments</label>
                                <textarea class="form-control" id="edit_appointment_comments" name="comments" rows="3"></textarea>
                            </div>
                            <!--
                            <div class="mb-3">
                                <label for="editAttachments" class="form-label">Upload New Attachments</label>
                                <input type="file" class="form-control" id="editAttachments" name="attachments[]" multiple>
                            </div>
                        -->

                            <button type="submit" class="btn btn-primary" id="updateAppointmentBtn">
                                Update Appointment
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
                <input type="hidden" id="modal_appointment_id">
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
        $(document).on('click', '.view-appointment', function () {
            let appointmentId = $(this).data('id');

            // Show the modal
            $('#viewAppointmentModal').modal('show');

            // Display a loading indicator
            $('#appointment-content').html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading details...</div>');

            // Fetch appointment details
            $.ajax({
                url: "{{ route('dvc.show', ':id') }}".replace(':id', appointmentId),
                type: "GET",
                success: function (response) {
                    let appointment = response.appointment;
                    let attachments = response.attachments;
                    let case_name = response.case_name;

                    let content = `
                        <div class="row">
                            <div class="col-md-6">
                              <strong>Case Name:</strong> ${case_name ?? 'N/A'}<br>
                                <strong>Next Hearing Date:</strong> ${appointment.appointment_date ?? 'N/A'}<br>
                                 <strong>Next Hearing Time:</strong> ${appointment.appointment_time ?? 'N/A'}<br>
                                <strong>Appointment Comments:</strong> <p>${appointment.comments ?? 'N/A'}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Created At:</strong> ${appointment.created_at ?? 'N/A'}<br>
                                <strong>Updated At:</strong> ${appointment.updated_at ?? 'N/A'}<br>
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

                    $('#appointment-content').html(content);
                },
                error: function () {
                    $('#appointment-content').html('<div class="text-danger text-center">Error loading appointment details.</div>');
                }
            });
        });

        $(document).ready(function () {
    $(document).on('click', '.edit-appointment', function () {
        let appointmentId = $(this).data('id');
        let url = "{{ route('dvc.show', ['appointment_id' => ':appointmentId']) }}"
        .replace(':appointmentId', appointmentId);
        // Fetch appointment details using AJAX
        $.ajax({
            url: url, // Make sure this route exists in your Laravel routes
            type: "GET",
            success: function (response) {
                let appointment = response.appointment;
                let attachments = response.attachments; // Get attachments correctly
                let case_name = response.case_name;
                let formattedDateTime = response.formattedDateTime
                // Populate form fields with fetched data
                $('#edit_appointment_id').val(appointment.appointment_id);
                $('#edit_case_id').val(response.case_id);
                $('#edit_forwarding_id').val(appointment.forwarding_id);
                $('#edit_evaluation_id').val(appointment.evaluation_id);
                $('#edit_case_name').val(case_name);
                $('#edit_next_hearing_date').val(formattedDateTime);
                $('#edit_appointment_comments').val(appointment.comments);




                 // Clear and populate document list
                 $('#documentList').empty();
                if (attachments.length > 0) {
                    attachments.forEach(doc => {
                        $('#documentList').append(`
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                               <a href="${doc.file_url}" target="_blank">${doc.file_name}</a>
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
                $('#editAppointmentModal').modal('show');
            },
            error: function () {
                alert("Error fetching appointment details.");
            }
        });
    });
});

       


    });


    $(document).on("click", ".delete-document", function () {
    let button = $(this);
    let documentId = button.data("id");
        let url = "{{ route('dvc.deleteDocument', ['documentId' => ':documentId']) }}"
        .replace(':documentId', documentId);

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
                url: url,
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
    // Open modal and set appointment ID
    $("#openUploadModalBtn").click(function () {
        let appointmentId = $("#edit_appointment_id").val(); // Ensure the appointment ID is available
        $("#modal_appointment_id").val(appointmentId);
        $("#uploadAttachmentModal").modal("show");
    });

    // Upload file when clicking "Upload" in the modal
    $("#modal_uploadAttachmentBtn").click(function () {
        let appointmentId = $("#modal_appointment_id").val();
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
        formData.append("appointment_id", appointmentId);
        formData.append("attachment", fileInput);
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
            let url = "{{ route('dvc.uploadAttachment') }}";

        $.ajax({
            url: url,
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

//Updating the Appointment
$(document).ready(function () {
    $("#editAppointmentForm").on("submit", function (e) {
        e.preventDefault(); // Prevent default form submission

        let formData = new FormData(this);
        let appointmentId = $("#edit_appointment_id").val(); // Get appointment ID
        let url = "{{ route('dvc.update', ['appointment' => ':id']) }}"
        .replace(':id', appointmentId);
        console.log("Appointment ID:", $("#edit_appointment_id").val());
        console.log("Form Data:", Object.fromEntries(new FormData($("#editAppointmentForm")[0])));
        
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
                    text: "Appointment has been updated successfully!",
                }).then(() => {
                        window.location.href = "{{ route('dvc.index') }}";
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

    
             
        if (!caseNumber) {
            alert("Please select a case.");
            return;
        }
       
            window.location.href = "{{ route('dvc_appointments.index') }}";

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
        document.querySelectorAll('.swal-delete-appointment-btn').forEach(button => {
            button.addEventListener('click', function () {
                const appointmentId = this.dataset.id;

             let url = "{{ route('appointments.destroy', ':id') }}".replace(':id', appointmentId);


                Swal.fire({
                    title: 'Are you sure?',
                    text: "This appointment will be permanently deleted.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.fire('Deleted!', data.message, 'success').then(() => {
                                location.reload();
                            });
                        })
                        .catch(error => {
                            Swal.fire('Error!', 'Failed to delete appointment.', 'error');
                        });
                    }
                });
            });
        });
    });
</script>
@endpush
@extends('layouts.default')

@section('title', 'Manage Forwardings')

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
            <a href="{{ route('cases.index') }}" class="btn btn-dark btn-sm d-flex align-items-center gap-2">
                <i class="fa fa-arrow-left text-white fw-bold"></i> <span class="text-white">Back to Cases</span>
            </a>
            <div class="panel-heading-btn">
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addEvaluationModal">
                    <i class="fa fa-plus"></i> Add New Forwarding
                </button>
            </div>
        </div>
        <div class="panel-body">
            
             <!-- Modal -->
             <div class="modal fade" id="addEvaluationModal" tabindex="-1" aria-labelledby="addEvaluationModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title text-dark" id="addEvaluationModalLabel">Create New Forwarding</h5>
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
                            <button type="submit" class="btn btn-primary">Create Forwarding</button>
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
                            <th>Forwarding Date</th>
                            <th>Briefing Notes</th>
                            <th>Assign</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($forwardings as $appointment)
                            <tr>
                                <td class="text-center">{{ $appointment->forwarding_id}}</td>
                                <td class="text-center">
                                 @if($appointment->case)
                                    <a href="{{ route('cases.show', $appointment->case->case_id) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center" title="View Case">
                                        <i class="fa fa-eye me-1"></i> {{ $appointment->case->case_name }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                                 </td>

                                <td class="text-center">{{ $appointment->dvc_appointment_date ?? 'N/A' }}</td>
                                
                                <td>{{ Str::limit($appointment->briefing_notes, 50) }}  </td>
                               <td class="text-center">
                                @php
                                    // Check if a DVC appointment already exists for this forwarding_id
                                    $hasDvc = \App\Models\DvcAppointment::where('forwarding_id', $appointment->forwarding_id)->exists();
                                @endphp

                                @if ($hasDvc)
                                    <span class="text-muted">Already Assigned</span>
                                @else
                                    <a href="{{ route('dvc.create', [
                                        'case_id' => $appointment->case_id,
                                        'forwarding_id' => $appointment->forwarding_id,
                                        'evaluation_id' => $appointment->evaluation_id
                                    ]) }}?case_name={{ urlencode($appointment->case_name) }}"
                                    class="btn btn-sm btn-outline-primary">
                                        Assign
                                    </a>
                                @endif
                            </td>

                               <td class="text-center action-buttons">
                                <!-- Edit Button -->
                                <button class="btn btn-warning btn-sm edit-appointment" data-id="{{ $appointment->forwarding_id }}">
                                    <i class="fa fa-edit"></i> Edit
                                </button>

                                <!-- View Button -->
                                <button class="btn btn-info btn-sm view-appointment" data-id="{{ $appointment->forwarding_id }}">
                                    <i class="fa fa-eye"></i> View
                                </button>

                                <!-- Delete Button -->
                                <form id="delete-forwarding-form-{{ $appointment->forwarding_id }}" 
                                      action="{{ route('forwardings.destroy', $appointment->forwarding_id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn btn-danger btn-sm swal-delete-forwarding-btn" 
                                            data-id="{{ $appointment->forwarding_id }}">
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



<!-- View   appointmentce Modal -->
<div class="modal fade" id="viewAppointmentModal" tabindex="-1" aria-labelledby="viewaAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewAppointmentModalLabel">Briefing Notes</h5>
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


<!-- Edit AppointmentModal -->
<div class="modal fade" id="editAppointmentModal" tabindex="-1" aria-labelledby="editAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editAppointmentModalLabel">Edit Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                  
                    <form id="editAppointmentForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    
                        <input type="hidden" id="edit_appointment_id" name="ag_appointment_id">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Case Number -->
                                <div class="form-group mt-2">
                                    <label for="edit_case_id">Case Number <span class="text-danger">*</span></label>
                                    <input type="hidden" name="case_id" id="edit_case_id" class="form-control">
                                    <input type="text" id="edit_case_number" class="form-control" disabled>
                                </div>
                    
                                <!-- Case Name -->
                                <div class="form-group mt-2">
                                    <label for="edit_case_name">Case Name <span class="text-danger">*</span></label>
                                    <input type="text" id="edit_case_name" class="form-control" disabled>
                                    <input type="hidden" name="case_name" id="hidden_case_name">
                                </div>
                            </div>
                    
                            <div class="col-md-6">
                                <!-- Appointment Date & Time -->
                                <div class="form-group mt-2">
                                    <label for="edit_appointment_date">Appointment Date & Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="dvc_appointment_date" id="edit_appointment_date" class="form-control" required>
                                </div>
                    
                                <!-- Briefing Notes -->
                                <div class="form-group mt-2">
                                    <label for="edit_briefing_notes">Briefing Notes <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="edit_briefing_notes" name="briefing_notes" rows="2" placeholder="Enter briefing notes" required></textarea>
                                </div>
                            </div>
                        </div>
                    
                        <div class="form-group text-center mt-2">
                            <button type="submit" class="btn btn-primary" id="updateAppointmentBtn">
                                <i class="fa fa-save"></i> Update Appointment
                            </button>
                        </div>
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
            let forwarding_id = $(this).data('id');

            console.log("The AG Appointment: "+forwarding_id);

            // Show the modal
            $('#viewAppointmentModal').modal('show');

            // Display a loading indicator
            $('#appointment-content').html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading details...</div>');

            // Fetch appointment details
            $.ajax({
                url: "{{ route('dvc_appointments.show', ':id') }}".replace(':id', forwarding_id),
                type: "GET",
                success: function (response) {
                    let appointment = response.forwarding;
                    let case_name = response.case_name;

                    let content = `
                        <div class="row">
                            <div class="col-md-6">
                              <strong>Case Name:</strong> ${case_name ?? 'N/A'}<br>
                                <strong>Appointment Date:</strong> ${appointment.dvc_appointment_date ?? 'N/A'}<br>
                                 <strong>Appointment Date:</strong> ${appointment.dvc_appointment_time ?? 'N/A'}<br>
                                <strong>Appointment Comments:</strong> <p>${appointment.briefing_notes ?? 'N/A'}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Created At:</strong> ${appointment.created_at ?? 'N/A'}<br>
                                <strong>Updated At:</strong> ${appointment.updated_at ?? 'N/A'}<br>
                            </div>
                        </div>
                        <hr>
                      
                    `;

                    

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
        let forwarding_id = $(this).data('id');
    let url = "{{ route('dvc_appointments.show', ':id') }}".replace(':id', forwarding_id);

        // Fetch appointment details using AJAX
        $.ajax({
            url: url, // Make sure this route exists in your Laravel routes
            type: "GET",
            success: function (response) {
                let appointment = response.forwarding;
                let case_name = response.case_name;
                let case_number = response.case_number;

                // Populate form fields with fetched data
                $('#edit_appointment_id').val(appointment.forwarding_id);
                $('#edit_case_id').val(appointment.case_id);
                $('#edit_case_number').val(case_number); // or appointment.case_number if available
                $('#edit_case_name').val(case_name);
                $('#hidden_case_name').val(case_name);
                $('#edit_appointment_date').val(appointment.dvc_appointment_date + 'T' + appointment.dvc_appointment_time); // make sure time is included
                $('#edit_briefing_notes').val(appointment.briefing_notes);


               

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
    let url = "{{ route('dvc_appointments.deleteDocument', ':id') }}".replace(':id', documentId);


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
    // Open modal and set briefing_notes ID
    $("#openUploadModalBtn").click(function () {
        let forwarding_id = $("#edit_appointment_id").val(); // Ensure the appointment ID is available
        console.log("Appointment ID: "+forwarding_id);
        $("#modal_appointment_id").val(forwarding_id);
        $("#uploadAttachmentModal").modal("show");
    });

    // Upload file when clicking "Upload" in the modal
    $("#modal_uploadAttachmentBtn").click(function () {
        let forwarding_id = $("#modal_appointment_id").val();
        console.log("Appointment ID: "+forwarding_id);

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
        formData.append("forwarding_id", forwarding_id);
        formData.append("attachment", fileInput);
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
        const uploadUrl = "{{ route('dvc_appointments.uploadAttachment') }}";

        $.ajax({
            url: uploadUrl,
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

//Updating the appointment
$(document).ready(function () {
    $("#editAppointmentForm").on("submit", function (e) {
        e.preventDefault(); // Prevent default form submission

        let formData = new FormData(this);
        let forwarding_id = $("#edit_appointment_id").val(); // Get appointment ID
        let url = "{{ route('dvc_appointments.update', ':id') }}".replace(':id', forwarding_id);
 // Construct the update route URL
        console.log("AppointmentID:", $("#edit_appointment_id").val());
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
                    window.location.href = "/dvc_appointments"; // Redirect after success
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
       
            window.location.href = "{{ route('evaluations.index') }}";

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
        document.querySelectorAll('.swal-delete-forwarding-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                let url = "{{ route('forwardings.destroy', ':id') }}".replace(':id', id);


                Swal.fire({
                    title: 'Are you sure?',
                    text: "This forwarding record will be deleted permanently.",
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
                                location.reload(); // Or remove the row dynamically
                            });
                        })
                        .catch(() => {
                            Swal.fire('Error!', 'Failed to delete forwarding.', 'error');
                        });
                    }
                });
            });
        });
    });
</script>

@endpush
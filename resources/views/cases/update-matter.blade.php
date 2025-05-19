@extends('layouts.default')

@section('title', 'Manage Matters')

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
    <h5>Cases Hearings/Mentions/Applications</h5>
    <div class="panel panel-inverse">
         <div class="panel-heading d-flex justify-content-between align-items-center">
            <a href="{{ url('/cases') }}" class="btn btn-dark btn-sm d-flex align-items-center gap-2">
                <i class="fa fa-arrow-left text-white fw-bold"></i> <span class="text-white">Back to Cases</span>
            </a>
            <div class="panel-heading-btn">
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addEvaluationModal">
                    <i class="fa fa-plus"></i> Add New Activity
                </button>
            </div>
        </div>
        <div class="panel-body">
            
             <!-- Modal -->
             <div class="modal fade" id="addEvaluationModal" tabindex="-1" aria-labelledby="addEvaluationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color: rgb(1, 9, 12)" id="addEvaluationModalLabel">Create New Activity</h5>
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
                                    <button type="submit" class="btn btn-primary">Create Activity</button>
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
                <table  id="data-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Case Number</th>
                            <th>Case Name</th>
                            <th>Time</th>
                            <th>Number</th>
                            <th>Next Action</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $activity)
                            <tr>
                                <td class="text-center">{{ $activity->id }}</td>
                                <td class="text-center">{{ $case_name ?? $activity->case->case_number }}</td>
                                
                                  <td>
                                @if($activity->case)
                                    <a href="{{ route('cases.show', $activity->case->case_id) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center" title="View Case">
                                        <i class="fa fa-eye me-1"></i> {{ $activity->case->case_name }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                                 </td>

                                <td class="text-center">{{ $activity->formatted_date }} at {{ $activity->formatted_time }}</td>
                                <td>{{ $activity->seq_num }}<sup>{{ $activity->seq_suffix }}</sup>
                                    {{ ucfirst($activity->type )  }}</td>


                                <td>
                                @if($activity->case)
                                 <a href="{{ route('preparations.create', $activity->case->case_id) }}" 
                                       class="btn btn-sm btn-outline-success d-inline-flex align-items-center" 
                                       title="Trial Preparation">
                                        <i class="fa fa-gavel me-1"></i> Trial Preparation
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>

                                <td class="text-center action-buttons">
                                    <button class="btn btn-warning btn-sm edit-activity" data-id="{{ $activity->id }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>

                                    <button class="btn btn-info btn-sm view-activity" data-id="{{ $activity->id }}">
                                        <i class="fa fa-eye"></i> View
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-activity-btn" data-id="{{ $activity->id }}">
                                        <i class="fa fa-trash"></i> Delete
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



<!-- View Activity Modal -->
<div class="modal fade" id="viewActivityModal" tabindex="-1" aria-labelledby="viewActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewActivityModalLabel">Activity Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="activity-content">
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


<!-- Edit Activity Modal -->
<div class="modal fade" id="editActivityModal" tabindex="-1" aria-labelledby="editActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editActivityModalLabel">Edit Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Hearing Form -->
                <form id="editForm">
                    @csrf
                    <input type="hidden" name="case_id" id="modal_case_add_hearing_id">
                    <input type="hidden" name="sequence_number" id="modal_sequence_number">
                    <input type="hidden" name="id" id="modal_id">
                    <input type="hidden" name="type" id="modal_type">
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
                                <input type="text" class="form-control" name="court_name" id="modal_court_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="court_room_number">Court Room Number</label>
                                <input type="text" class="form-control" name="court_room_number" id="modal_court_room_number" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <!-- Date and Time in One Row -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" name="date" id="modal_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="time">Time</label>
                                <input type="time" class="form-control" name="time" id="modal_time" required>
                            </div>
                        </div>
                    </div>

                    <!-- Sequence Number as Text Field
                    <div class="form-group mb-2">
                        <label for="sequence_number">Hearing Sequence</label>
                        <input type="text" name="sequence_number_1" id="sequence_number" class="form-control" readonly>
                    </div>
                     -->

                    <div class="row mb-2">
                        <!-- Hearing Type and Virtual Link (optional) in One Row -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hearing_type">Hearing Type</label>
                                <select name="hearing_type" class="form-control" required id="modal_hearing_type">
                                    <option value="virtual">Virtual</option>
                                    <option value="physical">Physical</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="virtual_link">Virtual Link (if virtual hearing)</label>
                                <input type="text" class="form-control" name="virtual_link" id="modal_virtual_link">
                            </div>
                        </div>
                    </div>

                    <!-- Court Contacts -->
                    <div class="form-group mb-2">
                        <label for="court_contacts">Court Contacts</label>
                        <textarea class="form-control" name="court_contacts" id="modal_court_contacts"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="modalSubmitBtn" class="btn btn-primary w-100 mt-2">
                        Add
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
                <input type="hidden" id="modal_activity_id">
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


<!-- Modal Dialog for Add Matter -->
<div class="modal fade" id="addMatterModal" tabindex="-1" aria-labelledby="addMatterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMatterModalLabel">Add Hearing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Add Hearing Form -->
                <form id="addMatterForm">
                    @csrf
                    <input type="hidden" name="case_id" id="modal_case_add_matter_id">
                    <input type="hidden" name="sequence_number" id="modal_matter_sequence_number">
                    <input type="hidden" name="type" id="modal_matter_type">
                    
                    <div class="row mb-2">
                        <!-- Court Room Number and Court Name in One Row -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="case_name">Case Name</label>
                                <input type="text" class="form-control" name="case_name" id="modal_add_matter_name"  readonly disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="court_room_number">Case Number</label>
                                <input type="text" class="form-control" name="case_number" readonly disabled  id="modal_add_matter_number">
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
                        <input type="text" name="sequence_number_1" id="matter_sequence_number" class="form-control" readonly>
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
                    <button type="submit" class="btn btn-primary w-100 mt-2" id="modalMatterSubmitBtn">Add Hearing</button>
                </form>
            </div>
        </div>
    </div>
</div>


  
  <!-- Modal -->
  <div class="modal fade" id="activityModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="activityModalLabel">Add Case Activity</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="activityForm">
          <div class="modal-body">
            <div class="mb-3">
              <label for="activityType" class="form-label">Which activity do you want to add to the case?</label>
              <select class="form-select" id="activityType" name="activity_type" required>
                <option value="" selected disabled>Select activity</option>
                <option value="hearing">Hearing</option>
                <option value="mention">Mention</option>
                <option value="application">Application</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="continueBtn"  data-case-id="" data-case-name="">Continue</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  


@endsection

@push('scripts')
<script>




    $(document).ready(function () {
        $(document).on('click', '.view-activity', function () {
            let activityId = $(this).data('id');
            

            // Show the modal
            $('#viewActivityModal').modal('show');

            // Display a loading indicator
            $('#activity-content').html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading details...</div>');

            // Fetch activity details
            $.ajax({
                url: `/cases/case-activity/${activityId}`, 
                type: "GET",
                success: function (response) {
                    let activity = response.data;
                   
                    let case_name = response.case_name;
                    let case_number = response.case_number;
                    
                    const capType = activity.type.charAt(0).toUpperCase() + activity.type.slice(1);

                    let content = `
                    <div class="row">
                        <div class="col-md-6">
                        <p><strong>Case Number:</strong> ${case_number}</p>
                        <p><strong>Case Name:</strong> ${case_name}</p>
                       
                        <p><strong>Type & Sequence:</strong>
                        ${activity.seq_num}<sup>${activity.seq_suffix}</sup>
                        ${capType}
                        </p>
                        <p><strong>Court Room #:</strong> ${activity.court_room_number}</p>
                        <p><strong>Court Name:</strong> ${activity.court_name}</p>
                        <p><strong>Date:</strong> ${activity.formatted_date}</p>
                        <p><strong>Time:</strong> ${activity.formatted_time}</p>
                        </div>
                        <div class="col-md-6">
                        <p><strong>Mode:</strong> ${activity.hearing_type}</p>
                        <p><strong>Virtual Link:</strong> ${activity.virtual_link ? `<a href="${activity.virtual_link}" target="_blank">Join</a>` : 'N/A'}</p>
                        <p><strong>Court Contacts:</strong> ${activity.court_contacts || 'N/A'}</p>
                        <p><strong>Full Texts:</strong> ${activity.full_texts || 'N/A'}</p>
                        <p><strong>Created At:</strong> ${activity.created_at}</p>
                        <p><strong>Updated At:</strong> ${activity.updated_at}</p>
                        </div>
                    </div>
                    `;
                    var type = activity.type; 

                    var capitalized = type.charAt(0).toUpperCase() + type.slice(1);

                    $('#viewActivityModalLabel').text( capitalized +" Details");

                    

                    $('#activity-content').html(content);
                },
                error: function () {
                    $('#activity-content').html('<div class="text-danger text-center">Error loading appeal details.</div>');
                }
            });
        });

$(document).ready(function () {
    $(document).on('click', '.edit-activity', function () {
        let activityId = $(this).data('id');
       
        // Fetch activity details using AJAX
        $.ajax({
            url: `/cases/case-activity/${activityId}`, // Make sure this route exists in your Laravel routes
            type: "GET",
            success: function (response) {


                if(response.data){
                    
                let activity = response.data;
                let case_name  = response.case_name;
                let case_number = response.case_number

                $('#modal_add_hearing_name').val(case_name);                
                $('#modal_add_hearing_number').val(case_number);
                $('#modal_case_add_hearing_id').val(activity.case_id);
                $('#modal_id').val(activity.id);
                $('#modal_court_name').val(activity.court_name);
                $('#modal_court_room_number').val(activity.court_room_number)
                //$('#sequence_number').val(activity.activity_comments);
                $('#modal_hearing_type').val(activity.hearing_type);
                $('#modal_sequence_number').val(activity.sequence_number);
                $('#modal_court_contacts').val(activity.court_contacts);
                var raw = activity.date.substring(0, 10); // "2025-04-08"
                $('#modal_date').val(raw);
                $('#modal_time').val(activity.time);
                $('#modal_virtual_link').val(activity.virtual_link);
                var type = activity.type;          // e.g. "hearing", "mention", "application"
                $('#modal_type').val(type);
                
                var capitalized = type.charAt(0).toUpperCase() + type.slice(1);

                $('#modalSubmitBtn').text('Update ' + capitalized);
                $('#editActivityModalLabel').text('Edit ' + capitalized);


                $('#editActivityModal').modal('show');

                }
                

                // Populate form fields with fetched data
               
               


                // Show the modal
                
            },
            error: function () {
                alert("Error fetching activity details.");
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
                url: `/appeals/deleteDocuments/${documentId}`,
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
    // Open modal and set activity ID
    $("#openUploadModalBtn").click(function () {
        let activityId = $("#edit_activity_id").val(); // Ensure the activity ID is available
        $("#modal_activity_id").val(activityId);
        $("#uploadAttachmentModal").modal("show");
    });

    // Upload file when clicking "Upload" in the modal
    $("#modal_uploadAttachmentBtn").click(function () {
        let activityId = $("#modal_activity_id").val();
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
        formData.append("activity_id", activityId);
        formData.append("attachment", fileInput);
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

        $.ajax({
            url: "/appeals/uploadAttachment",
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

//Updating the Activity
$(document).ready(function () {
    $("#editActivityForm").on("submit", function (e) {
        e.preventDefault(); // Prevent default form submission

        let formData = new FormData(this);
        let activityId = $("#edit_activity_id").val(); // Get activity ID
        let url = `/appeals/update/${activityId}`; // Construct the update route URL
        console.log("Activity ID:", $("#edit_activity_id").val());
        console.log("Form Data:", Object.fromEntries(new FormData($("#editActivityForm")[0])));
        
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
                    text: "Activity has been updated successfully!",
                }).then(() => {
                    window.location.href = "/appeals"; // Redirect after success
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
                url: "{{ route('cases.checkCase') }}", 
                type: "GET", 
                data: { case_number: caseNumber }, 
                success: function (response) {
                    if (response.exists) {
                        if (response.evaluation) {
                            // Redirect to evaluations.edit if evaluation exists
                            window.location.href = response.evaluation.edit_url;
                        } else {
                            /*
                            console.log(response);
                            // Redirect to evaluations.create if no evaluation exists
                            window.location.href = "{{ route('appeals.create', ':case_id') }}"
                                .replace(':case_id', response.case_id) + 
                                "?case_name=" + encodeURIComponent(response.case_name);
                                */
                               
                               var caseId = response.case_id;  // Get case_id from button
                               var caseName = response.case_name;  // Get case_name from button

                                var caseNumber = response.case_number;
        

                               $('#continueBtn').data('case-id', caseId);
                                $('#continueBtn').data('case-name', caseName);
                                $('#continueBtn').data('case-number', caseNumber);
                               $('#activityModal').modal('show');
                               $('#addEvaluationModal').modal('hide');


                      


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


    $('#continueBtn').on('click', function () {
    var caseId = $(this).data('case-id'); // Get the case_id from button's data attribute
    var caseName = $(this).data('case-name'); // Get the case_name from button's data attribute
    var caseNumber = $(this).data('case-number'); // Get this from a hidden field or JS variable

    let selectedType = $('#activityType').val();
    $('#modal_case_add_matter_id').val(caseId);
    $('#modal_add_matter_name').val(caseName);
    $('#modal_add_matter_number').val(caseNumber);

    if (!selectedType) {
        Swal.fire({
            icon: 'warning',
            title: 'Select an activity',
            text: 'Please choose an activity type before continuing.'
        });
        return;
    }

    $.ajax({
        url: '/cases/get-last-sequence-all/' + caseId + '?type=' + selectedType, // Append type as query param
        method: 'GET',
        success: function (response) {
            var nextSequence = response.nextSequence;
            var nextSequenceText = response.nextSequenceText;
            
            var capitalized = selectedType.charAt(0).toUpperCase() + selectedType.slice(1);
            $('#modal_matter_sequence_number').val(nextSequence);
            $('#matter_sequence_number').val(nextSequenceText);
            $('#modal_matter_type').val(selectedType);
            $('#modalMatterSubmitBtn').text('Add ' + capitalized);
            $('#addMatterModalLabel').text('Add ' + capitalized);
            $('#activityModal').modal('hide');
            $('#addMatterModal').modal('show');



            // You can also trigger display of the next step/form here if needed
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Error fetching last sequence number.'
            });
        }
    });
});



    
$(document).ready(function() {
    $('#editForm').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: "{{ route('cases.updateMatter') }}", // Laravel route
            method: "POST",
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Updated successfully!',
                    timer: 2000,
                    showConfirmButton: false
                });

                $('#editForm')[0].reset(); // Clear the form
                $('#editActivityModal').modal('hide'); // Optional: close modal
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

$(document).on('click', '.delete-activity-btn', function () {
    const activityId = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Make AJAX request to delete
            $.ajax({
                url: `/cases/activities/${activityId}`, // Update this with your actual route
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    Swal.fire(
                        'Deleted!',
                        'Activity has been deleted.',
                        'success'
                    );
                    // Optionally remove the row or reload
                    // Example: $(`#activity-row-${activityId}`).remove();
                    location.reload();
                },
                error: function (xhr) {
                    Swal.fire(
                        'Error!',
                        'Could not delete activity.',
                        'error'
                    );
                }
            });
        }
    });
});


$(document).ready(function() {
    $('#addMatterForm').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: "{{ route('cases.addActivity') }}", // Laravel route
            method: "POST",
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Activity added successfully!',
                    timer: 2000,
                    showConfirmButton: false
                });

                $('#addMatterForm')[0].reset(); // Clear the form
                $('#addMatterModal').modal('hide'); // Optional: close modal
                location.reload();
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
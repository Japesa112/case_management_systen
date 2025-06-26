@extends('layouts.default')

@push('styles')
<style>
    .custom-file-input ~ .custom-file-label::after {
        content: "Browse";
    }
    .uploaded-files-list .list-group-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
@endpush



@section('title', 'Edit Negotiation')

@section('content')
<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-md-12">
            <!-- Page Header -->
            <h1 class="page-header">Update Negotiation</h1>
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Update Form</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand">
                            <i class="fa fa-expand"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse">
                            <i class="fa fa-minus"></i>
                        </a>
                    </div>
                </div>
               

                <div class="panel-body">
                    <div class="row d-flex justify-content-between align-items-start">
                        <!-- Left and Middle Column (Inside Form) -->
                        <div class="col-md-8">
                            <form id="negotiationForm" action="{{ route('negotiations.update', ['negotiation' => $negotiation->negotiation_id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT') 
                
                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">
                                        <div class="form-group mt-2">
                                            <label for="case_id">Case ID <span class="text-danger">*</span></label>
                                            <input type="text" name="case_id" id="case_id" class="form-control" value="{{ $negotiation->case_id }}" disabled>
                                        </div>
                
                                        <input type="hidden" name="negotiator_id" value="{{ Auth::id() }}">
                
                                        <div class="form-group mt-2">
                                            <label for="negotiation_method">Method <span class="text-danger">*</span></label>
                                            <select name="negotiation_method" id="negotiation_method" class="form-control" required>
                                                <option value="">Select Method</option>
                                                <option value="Email" {{ $negotiation->negotiation_method == 'Email' ? 'selected' : '' }}>Email</option>
                                                <option value="Phone" {{ $negotiation->negotiation_method == 'Phone' ? 'selected' : '' }}>Phone</option>
                                                <option value="In-Person" {{ $negotiation->negotiation_method == 'In-Person' ? 'selected' : '' }}>In-Person</option>
                                            </select>
                                        </div>
                
                                        <div class="form-group mt-2">
                                            <label for="subject">Subject</label>
                                            <input type="text" name="subject" id="subject" class="form-control" value="{{ $negotiation->subject }}">
                                        </div>

                                        <div class="form-group mt-2">
                                            <label for="initiation_datetime">Initiation Date &amp; Time <span class="text-danger">*</span></label>
                                            <input type="datetime-local" name="initiation_datetime" id="initiation_datetime" class="form-control" value="{{ $negotiation->initiation_datetime }}">
                                        </div>
                            
                                        <div class="form-group mt-2">
                                            <label for="follow_up_date">Follow Up Date</label>
                                            <input type="date" name="follow_up_date" id="follow_up_date" class="form-control" value="{{ $negotiation->follow_up_date }}">
                                        </div>

                                        <div class="form-group mt-2">
                                            <label for="final_resolution_date">Final Resolution Date</label>
                                            <input type="date" name="final_resolution_date" id="final_resolution_date" class="form-control" 
       value="{{ $negotiation->final_resolution_date ? \Carbon\Carbon::parse($negotiation->final_resolution_date)->format('Y-m-d') : '' }}">

                                        </div>

                                    </div>

                                    
                
                                    <!-- Middle Column -->
                                    <div class="col-md-6">
                                        <div class="form-group mt-2">
                                            <label for="follow_up_actions">Follow Up Actions</label>
                                            <textarea name="follow_up_actions" id="follow_up_actions" class="form-control" rows="2">{{ $negotiation->follow_up_actions }}</textarea>
                                        </div>
                
                                        <div class="form-group mt-2">
                                            <label for="complainant_response">Complainant Response</label>
                                            <textarea name="complainant_response" id="complainant_response" class="form-control" rows="2">{{ $negotiation->complainant_response }}</textarea>
                                        </div>
                
                                        <div class="form-group mt-2">
                                            <label for="notes">Notes</label>
                                            <textarea name="notes" id="notes" class="form-control" rows="2">{{ $negotiation->notes }}</textarea>
                                        </div>

                                        <div class="form-group mt-2">
                                            <label for="additional_comments">Additional Comments</label>
                                            <textarea name="additional_comments" id="additional_comments" class="form-control" rows="2">{{ $negotiation->additional_comments }}</textarea>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="outcome">Outcome</label>
                                            <select name="outcome" id="outcome" class="form-control">
                                               
                                                <option value="Resolved" {{ $negotiation->outcome == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                                <option value="Pending" {{ $negotiation->outcome == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Requires Further Action" {{ $negotiation->outcome == 'Requires Further Action' ? 'selected' : '' }}>Requires Further Action</option>
                                            </select>
                                        </div>
                                        
                                    </div>


           
                                </div>
                


                                                                     <!-- Button container -->
                        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                            <!-- Back Button (Left) -->
                            <a href="javascript:history.back()" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                                <i class="fa fa-arrow-left"></i> <span>Back</span>
                            </a>

                            <!-- Go to Negotiations (Center) -->
                            <a href="{{ route('negotiations.index') }}" class="btn btn-outline-info d-flex align-items-center gap-2">
                                <i class="fa fa-list-alt"></i> <span>All Negotiations</span>
                            </a>

                            <!-- Update Button (Right) -->
                            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                                <i class="fa fa-paper-plane"></i> <span>Update Negotiation</span>
                            </button>
                        </div>

                                
                            </form>
                        </div>
                
                        <!-- Right Column (Upload Documents) - Outside the Form -->
                        <div class="col-md-4">
                            <label>Upload Documents</label>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                                <i class="fas fa-upload"></i> Upload Documents
                            </button>
                            <br/>
                            <h6 class="mt-2">Uploaded Documents</h6>
                            <div id="uploadedFilesList" class="mt-2">
                                @foreach ($attachments as $attachment)
                                <div id="attachment-{{ $attachment->attachment_id }}" class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">
                                        <i class="fa fa-file"></i> {{ $attachment->file_name }}
                                    </a>
                                    <button type="button" class="btn btn-xs btn-danger delete-attachment"
                                        data-attachment-id="{{ $attachment->attachment_id }}">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            @endforeach
                            
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

   
</div>

<!-- Modal Dialog for File Upload -->
<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDocumentModalLabel">Add Negotiation Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Upload Document Form -->
                <form id="documentUploadForm" action="{{ route('negotiations.attachments.store_edit', ['negotiation' => $negotiation]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="modalAttachments">Select Files</label>
                        <input type="file" name="modalAttachments[]" id="modalAttachments" class="form-control" multiple>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#documentUploadForm').submit(function (e) {
            e.preventDefault(); // Prevent default form submission
           
            let formData = new FormData(this);
    
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Uploaded!",
                            text: response.message,
                        });
    
                        // Append new files to the list dynamically
                        response.attachments.forEach(function (attachment) {
                            $('#uploadedFilesList').append(`
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="${attachment.file_path}" target="_blank">
                                        <i class="fa fa-file"></i> ${attachment.file_name}
                                    </a>
                                    <button type="button" class="btn btn-xs btn-danger" onclick="deleteAttachment(${attachment.id})">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            `);
                        });
    
                        // Reset the file input field
                        $('#modalAttachments').val('');
                        // **Hide the modal dialog**
                    $('#addDocumentModal').modal('hide');
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Upload Failed",
                            text: response.message,
                        });
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: xhr.responseJSON ? xhr.responseJSON.message : "Something went wrong!",
                    });
                }
            });
        });
    });
    </script>  
    
    

    <script>
       $(document).ready(function () {
    // Handle delete button click event
    $(document).on("click", ".delete-attachment", function () {
        let attachmentId = $(this).data("attachment-id"); // Get attachment_id from button attribute
        
        if (!attachmentId) {
            console.error("Attachment ID is undefined");
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Invalid attachment ID!"
            });
            return;
        }

        deleteAttachment(attachmentId);
    });
});

function deleteAttachment(attachmentId) {
    Swal.fire({
        title: "Are you sure?",
        text: "This file will be permanently deleted!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('negotiations.attachments.delete', ':attachment_id') }}".replace(':attachment_id', attachmentId),
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Deleted!",
                            text: response.message,
                        });

                        // Remove the deleted attachment from the UI
                        $("#attachment-" + attachmentId).remove();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Deletion Failed",
                            text: response.message,
                        });
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: xhr.responseJSON ? xhr.responseJSON.message : "Something went wrong!",
                    });
                }
            });
        }
    });
}

        </script>
<script>
    $(document).ready(function () {
        $("#negotiationForm").on("submit", function (e) {
            e.preventDefault(); // Prevent default form submission

            let formData = new FormData(this);
            let actionUrl = $(this).attr("action");

            $.ajax({
                url: actionUrl,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.negotiation) {
                        Swal.fire({
                            icon: "success",
                            title: "Updated!",
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Update form fields dynamically
                        $("#negotiation_method").val(response.negotiation.negotiation_method);
                        $("#subject").val(response.negotiation.subject);
                        $("#initiation_datetime").val(response.negotiation.initiation_datetime);
                        $("#follow_up_date").val(response.negotiation.follow_up_date);
                        $("#final_resolution_date").val(response.negotiation.final_resolution_date);
                        $("#follow_up_actions").val(response.negotiation.follow_up_actions);
                        $("#complainant_response").val(response.negotiation.complainant_response);
                        $("#notes").val(response.negotiation.notes);
                        $("#additional_comments").val(response.negotiation.additional_comments);
                        $("#outcome").val(response.negotiation.outcome);
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Update Failed",
                        text: xhr.responseJSON ? xhr.responseJSON.message : "Something went wrong!",
                    });
                }
            });
        });
    });
</script>
   
@endpush

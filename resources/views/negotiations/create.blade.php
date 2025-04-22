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
@section('title', 'Create Negotiation')

@section('content')
<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-md-12">
            <!-- Page Header -->
            <h1 class="page-header">Create Negotiation</h1>
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Negotiation Form</h4>
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

                    

                    @if (session('error'))
                    <div class="alert alert-danger">
                    {{ session('error') }}

                    </div>
                    @endif
                
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                   
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('existingNegotiation'))
                    
                        <a href="{{ route('negotiations.edit', session('existingNegotiation')) }}" class="btn btn-warning btn-sm mt-2">
                            <i class="fa fa-edit"></i> Update Negotiation
                        </a>
                   
                    
                    @endif


                    <form action="{{ route('negotiations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="case_id">Case ID <span class="text-danger">*</span></label>
                                    <input type="hidden" name="case_id" value="{{ $case_id }}">

                                    <input type="text" name="case_id" id="case_id" class="form-control" value="{{ $case_id }}" disabled>
                                </div>

                                <!-- Hidden negotiator_id -->
                                <input type="hidden" name="negotiator_id" value="{{ Auth::id() }}">

                                <div class="form-group mt-2">
                                    <label for="negotiation_method">Method <span class="text-danger">*</span></label>
                                    <select name="negotiation_method" id="negotiation_method" class="form-control" required>
                                        <option value="">Select Method</option>
                                        <option value="Email">Email</option>
                                        <option value="Phone">Phone</option>
                                        <option value="In-Person">In-Person</option>
                                    </select>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="subject">Subject</label>
                                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter Subject">
                                </div>

                                <div class="form-group mt-2">
                                    <label for="initiation_datetime">Initiation Date &amp; Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="initiation_datetime" id="initiation_datetime" class="form-control" required>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="follow_up_date">Follow Up Date</label>
                                    <input type="date" name="follow_up_date" id="follow_up_date" class="form-control">
                                </div>

                                <div class="form-group mt-2">
                                    <label for="final_resolution_date">Final Resolution Date</label>
                                    <input type="date" name="final_resolution_date" id="final_resolution_date" class="form-control">
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="follow_up_actions">Follow Up Actions</label>
                                    <textarea name="follow_up_actions" id="follow_up_actions" class="form-control" rows="2" placeholder="Enter follow-up actions"></textarea>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="complainant_response">Complainant Response</label>
                                    <textarea name="complainant_response" id="complainant_response" class="form-control" rows="2" placeholder="Enter complainant response"></textarea>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="2" placeholder="Enter notes"></textarea>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="additional_comments">Additional Comments</label>
                                    <textarea name="additional_comments" id="additional_comments" class="form-control" rows="2" placeholder="Enter additional comments"></textarea>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="outcome">Outcome</label>
                                    <select name="outcome" id="outcome" class="form-control">
                                        <option value="">Select Outcome</option>
                                        <option value="Resolved">Resolved</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Requires Further Action">Requires Further Action</option>
                                    </select>
                                </div>
                                
                                
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center mt-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-paper-plane"></i> Submit Negotiation
                            </button>
                        </div>
                    </form>
                </div> <!-- end panel-body -->
            </div> <!-- end panel -->
        </div>
    </div>
</div>

<!-- Modal Dialog for File Upload -->
@if(session('negotiation_success'))
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        swal({
            title: "Negotiation submitted!",
            text: "Do you have negotiation files to upload?",
            icon: "info",
            buttons: ["No", "Yes"]
        }).then((willUpload) => {
            if(willUpload) {
                // Trigger the modal dialog for file upload
                $('#addDocumentModal').modal('show');
            }
            else {
            // Redirect to index with a query parameter for success message
            window.location.href = "{{ route('negotiations.index') }}?message=Negotiation+added+successfully";
        }
        
        });
    </script>
@endif

<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDocumentModalLabel">Add Negotiation Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Upload Document Form -->
                @if ($negotiation)
                    
                
                <form id="documentUploadForm" action="{{ route('negotiations.attachments.store', ['negotiation' => $negotiation]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label for="modalAttachments">Select Files</label>
                        <input type="file" name="modalAttachments[]" id="modalAttachments" class="form-control" multiple>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection


@push('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>  

<script>
    // JavaScript to display file names on file selection
    document.getElementById('attachments').addEventListener('change', function(e) {
        const fileList = e.target.files;
        const listContainer = document.getElementById('uploadedFiles');
        listContainer.innerHTML = ''; // Clear any existing items
        for(let i = 0; i < fileList.length; i++) {
            const li = document.createElement('li');
            li.classList.add('list-group-item');
            li.textContent = fileList[i].name;
            listContainer.appendChild(li);
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // File upload display handler
        document.getElementById('documents').addEventListener('change', function(e) {
            const fileList = document.querySelector('.uploaded-files-list');
            fileList.innerHTML = '';
            
            Array.from(e.target.files).forEach((file, index) => {
                const listItem = document.createElement('div');
                listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                listItem.innerHTML = `
                    ${file.name}
                    <button type="button" class="btn btn-xs btn-danger" onclick="removeFile(${index})">
                        <i class="fa fa-times"></i>
                    </button>
                `;
                fileList.appendChild(listItem);
            });
        });
    });
    
    function removeFile(index) {
        const input = document.getElementById('documents');
        const files = Array.from(input.files);
        files.splice(index, 1);
        
        // Create new DataTransfer to update files
        const dataTransfer = new DataTransfer();
        files.forEach(file => dataTransfer.items.add(file));
        input.files = dataTransfer.files;
    
        // Trigger change event to update display
        input.dispatchEvent(new Event('change'));
    }
    </script>
@endpush
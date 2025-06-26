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

@section('title', 'Create Preparation')

@section('content')
<div class="container-fluid">
    <div class="row mt-1" style="margin-left: 15%; margin-right: 10%;">
        <div class="col-md-12 mt-2">
            <h1 class="page-header mt-2">Create Preparation</h1>
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Preparation Form</h4>
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
                        <div class="alert alert-danger">{{ session('error') }}</div>
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

                    <form action="{{ route('preparations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <input type="hidden" name="case_id" value="{{ $case_id }}">
                    
                                <div class="form-group mt-2">
                                    <label for="case_name">Case Name <span class="text-danger">*</span></label>
                                    <input type="text" id="case_name" class="form-control" value="{{ $case_name }}" disabled>
                                    <input type="hidden" name="case_name" value="{{ $case_name }}">
                                </div>
                    
                                <div class="form-group mt-2">
                                    <label for="preparation_date">Preparation Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="preparation_date" id="preparation_date" class="form-control" required>
                                </div>
                    
                                <div class="form-group mt-2">
                                    <label for="preparation_status">Preparation Status <span class="text-danger">*</span></label>
                                    <select name="preparation_status" id="preparation_status" class="form-control" required>
                                        <option value="">Select Status</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Ongoing">Ongoing</option>
                                        <option value="Completed">Completed</option>
                                    </select>
                                </div>
                            </div>
                    
                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="briefing_notes">Briefing Notes</label>
                                    <textarea name="briefing_notes" id="briefing_notes" class="form-control" rows="3" placeholder="Enter briefing notes"></textarea>
                                </div>
                    
                                <div class="form-group mt-2">
                                    <label for="modalAttachments">Attach Documents</label>
                                    <input type="file" name="modalAttachments[]" id="modalAttachments" class="form-control" multiple>
                                </div>
                    
                                <ul id="fileList" class="list-group mt-2"></ul>
                            </div>
                        </div>
                    
                        <div class="form-group d-flex justify-content-center align-items-center gap-3 mt-3">

                              <!-- Back Button (Left) -->
                              <button type="button" onclick="window.history.back();" class="btn btn-secondary d-inline-flex align-items-center gap-2">
                                <i class="fa fa-arrow-left"></i> Back
                              </button>

                              <!-- Go to Preparations Button (Middle) -->
                              <a href="{{ route('preparations.index') }}" class="btn btn-info d-inline-flex align-items-center gap-2">
                                <i class="fa fa-list"></i> Preparations
                              </a>

                              <!-- Submit Preparation Button (Right) -->
                              <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2">
                                <i class="fa fa-paper-plane"></i> Submit Preparation
                              </button>

                            </div>

                    </form>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('preparation_success'))
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        swal({
            title: "Preparation submitted!",
            text: "Do you have Preparation documents to upload?",
            icon: "info",
            buttons: ["No", "Yes"]
        }).then((willUpload) => {
            if (willUpload) {
                $('#addDocumentModal').modal('show');
                
            } else {
                window.location.href = "{{ route('preparations.index') }}?message=Preparation+added+successfully";
            }
        });
    </script>
@endif

<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDocumentModalLabel">Add Preparation Document  </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              
                
                <form id="documentUploadForm" action="" method="POST" enctype="multipart/form-data">
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
    document.addEventListener("DOMContentLoaded", function() {
        const fileInput = document.getElementById("modalAttachments");
        const fileListContainer = document.getElementById("fileList");
        const form = document.getElementById("documentUploadForm");
    
        fileInput.addEventListener("change", function() {
            fileListContainer.innerHTML = ""; // Clear previous list
            Array.from(fileInput.files).forEach((file, index) => {
                const listItem = document.createElement("li");
                listItem.classList.add("list-group-item");
                listItem.innerHTML = `
                    ${file.name} 
                    <button type="button" class="btn btn-sm btn-danger remove-file" data-index="${index}">Remove</button>
                `;
                fileListContainer.appendChild(listItem);
            });
        });
    
        fileListContainer.addEventListener("click", function(event) {
            if (event.target.classList.contains("remove-file")) {
                const index = event.target.getAttribute("data-index");
                let filesArray = Array.from(fileInput.files);
                filesArray.splice(index, 1);
    
                // Create a new DataTransfer object to reset file input
                let dataTransfer = new DataTransfer();
                filesArray.forEach(file => dataTransfer.items.add(file));
                fileInput.files = dataTransfer.files;
    
                // Refresh the file list display
                fileListContainer.innerHTML = "";
                filesArray.forEach((file, index) => {
                    const listItem = document.createElement("li");
                    listItem.classList.add("list-group-item");
                    listItem.innerHTML = `
                        ${file.name} 
                        <button type="button" class="btn btn-sm btn-danger remove-file" data-index="${index}">Remove</button>
                    `;
                    fileListContainer.appendChild(listItem);
                });
            }
        });
    });
    </script>
    
    
@endpush
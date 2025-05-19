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

@section('title', 'Create Appeal')

@section('content')
<div class="container-fluid">
    <div class="row mt-4" style="margin-left: 20%; margin-right: 10%;">
        <div class="col-md-12 mt-4">
            <h1 class="page-header mt-4">Create Appeal</h1>
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Appeal Form</h4>
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

                    <form action="{{ route('appeals.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="case_id">Case ID <span class="text-danger">*</span></label>
                                    <input type="text" name="case_id" id="case_id" class="form-control" value="{{ $case_id }}" disabled>
                                    <input type="hidden" name="case_id" value="{{ $case_id }}">
                                </div>

                                <div class="form-group mt-2">
                                    <label for="case_id">Case Name <span class="text-danger">*</span></label>
                                    <input type="text" name="case_name" id="case_name" class="form-control" value="{{ $case_name }}" disabled>
                                    <input type="hidden" name="case_name" value="{{ $case_name }}">
                                </div>


                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="next_hearing_date">Next Hearing Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="next_hearing_date" id="next_hearing_date" class="form-control" required>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="appeal_comments">Appeal Comments</label>
                                    <textarea name="appeal_comments" id="appeal_comments" class="form-control" rows="2" placeholder="Enter appeal comments"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="modalAttachments">Select Files</label>
                                    <input type="file" name="modalAttachments[]" id="modalAttachments" class="form-control" multiple>
                                </div>
                                <ul id="fileList" class="list-group mt-2"></ul>
                                
                              
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-between align-items-center mt-3 px-3">

                            <!-- Back Button -->
                            <button type="button" onclick="window.history.back();" class="btn btn-secondary d-flex align-items-center">
                                <i class="fa fa-arrow-left me-1"></i> Back
                            </button>

                            <!-- Go to Appeals Button -->
                            <a href="/appeals" class="btn btn-info d-flex align-items-center">
                                <i class="fa fa-list me-1"></i> Go to Appeals
                            </a>

                            <!-- Submit Appeal Button -->
                            <button type="submit" class="btn btn-primary d-flex align-items-center">
                                <i class="fa fa-paper-plane me-1"></i> Submit Appeal
                            </button>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('appeal_success'))
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        swal({
            title: "Appeal submitted!",
            text: "Do you have appeal documents to upload?",
            icon: "info",
            buttons: ["No", "Yes"]
        }).then((willUpload) => {
            if (willUpload) {
                $('#addDocumentModal').modal('show');
                
            } else {
                window.location.href = "{{ route('appeals.index') }}?message=Appeal+added+successfully";
            }
        });
    </script>
@endif

<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDocumentModalLabel">Add Appeal Document  </h5>
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
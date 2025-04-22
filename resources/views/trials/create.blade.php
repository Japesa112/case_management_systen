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

@section('title', 'Create Trial')

@section('content')
<div class="container-fluid">
    <div class="row mt-1" style="margin-left: 15%; margin-right: 10%;">
        <div class="col-md-12 mt-2">
            <h1 class="page-header mt-2">Create Trial</h1>
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Trial Form</h4>
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

                    <form action="{{ route('trials.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <input type="hidden" name="case_id" value="{{ $case_id }}">
                    

                                <div class="form-group mt-2">
                                    <label for="case_name">Case Name <span class="text-danger">*</span></label>
                                    <input type="text" name="case_name" id="case_name" class="form-control" value="{{ $case_name }}" disabled>

                                </div>
                                <div class="form-group mt-2">
                                    <label for="trial_date">Trial Date <span class="text-danger">*</span></label>
                                    <input type="date" name="trial_date" id="trial_date" class="form-control" required>
                                </div>
                    
                                <div class="form-group mt-2">
                                    <label for="judgement_date">Judgement Date</label>
                                    <input type="date" name="judgement_date" id="judgement_date" class="form-control">
                                </div>
                            </div>
                    
                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="outcome">Outcome <span class="text-danger">*</span></label>
                                    <select name="outcome" id="outcome" class="form-control" required>
                                        <option value="">Select Outcome</option>
                                        <option value="Win">Win</option>
                                        <option value="Loss">Lost</option>
                                        <option value="Dismissed">Dismissed</option>
                                        <option value="Adjourned">Adjourned</option>
                                    </select>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="judgement_details">Judgement Details</label>
                                    <textarea name="judgement_details" id="judgement_details" class="form-control" rows="3" placeholder="Enter judgement details"></textarea>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="trialAttachments">Select Files</label>
                                    <input type="file" name="trialAttachments[]" id="trialAttachments" class="form-control" multiple>
                                </div>
                                
                    
                                
                            </div>
                        </div>
                    
                        <div class="form-group text-center mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-paper-plane"></i> Submit Trial
                            </button>
                        </div>
                    </form>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('trial_success'))
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        swal({
            title: "Trial submitted!",
            text: "Do you have trial documents to upload?",
            icon: "info",
            buttons: ["No", "Yes"]
        }).then((willUpload) => {
            if (willUpload) {
                $('#addDocumentModal').modal('show');
                
            } else {
                window.location.href = "{{ route('trials.index') }}?message=Trial+added+successfully";
            }
        });
    </script>
@endif

<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDocumentModalLabel">Add Trial Document  </h5>
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
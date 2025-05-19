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

<style>
  .btn-custom {
    border-radius: 6px;
    font-weight: 600;
    padding: 0.5rem 1.25rem;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
  }
  .btn-custom i {
    font-size: 1.1rem;
  }
  .btn-secondary:hover {
    background-color: #5a6268;
    color: #fff;
  }
  .btn-primary:hover {
    background-color: #004085;
    color: #fff;
  }
  @media (max-width: 575.98px) {
    .form-group.d-flex {
      flex-direction: column;
      gap: 0.75rem;
      align-items: stretch;
    }
  }
</style>
@endpush

@section('title', 'Forwarding')

@section('content')
<div class="container-fluid">
    <div class="row mt-4" style="margin-left: 20%; margin-right: 10%;">
        <div class="col-md-12 mt-4">
            <h1 class="page-header mt-4">Forwarding </h1>
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Forward Form</h4>
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

                    <form action="{{ route('dvc_appointments.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="case_id">Case Number <span class="text-danger">*</span></label>
                                    <input type="hidden" name="case_id" id="case_id" class="form-control" value="{{ $case_id }}" disabled>
                                    <input type="hidden" name="case_id" value="{{ $case_id }}">
                                    <input type="text" name="case_id" id="case_id" class="form-control" value="{{ $case_number }}" disabled>
                                    <input type="hidden" name="evaluation_id" value="{{ $evaluation_id }}">
                                </div>

                               

                                <div class="form-group mt-2">
                                    <label for="case_id">Case Name <span class="text-danger">*</span></label>
                                    <input type="text" name="case_name" id="case_name" class="form-control" value="{{ $case_name }}" disabled>
                                    <input type="hidden" name="case_name" value="{{ $case_name }}">
                                </div>


                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-2">


                                    <label for="next_hearing_date">Forward Date & Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="dvc_appointment_date" id="dvc_appointment_date" class="form-control" required>

                                  <!---  <input type="date" name="dvc_appointment_date" id="dvc_appointment_date" class="form-control" required> --->
                                </div>
                                <div class="form-group mt-2">
                                    <label for="adjourn_comments">Briefing Notes <span class="text-danger">*</span></label>
                                    <textarea name="briefing_notes" id="briefing_notes" class="form-control" rows="2" placeholder="Enter briefing notes" required></textarea>
                                </div>
                                
                              
                            </div>
                        </div>
                       <div class="form-group mt-3 d-flex justify-content-between px-3">

                      <a href="{{ url()->previous() }}" class="btn btn-secondary btn-custom d-inline-flex align-items-center gap-2" title="Go Back">
                        <i class="fa fa-arrow-left"></i> <span>Back</span>
                      </a>

                      <a href="{{ url('/dvc_appointments') }}" class="btn btn-info btn-custom d-inline-flex align-items-center gap-2" title="Go to Evaluations">
                        <i class="fa fa-list"></i> <span>Forwardings </span>
                      </a>

                      <button type="submit" class="btn btn-primary btn-custom d-inline-flex align-items-center gap-2" title="Forward">
                        <i class="fa fa-share"></i> <span>Forward</span>
                      </button>

                    </div>


                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('adjourn_success'))
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        swal({
            title: "Adjourn submitted!",
            text: "Do you have adjourn documents to upload?",
            icon: "info",
            buttons: ["No", "Yes"]
        }).then((willUpload) => {
            if (willUpload) {
                $('#addDocumentModal').modal('show');
                
            } else {
                window.location.href = "{{ route('dvc_appointments.index') }}?message=Adjourn+added+successfully";
            }
        });
    </script>
@endif

<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDocumentModalLabel">Add Appointment Document  </h5>
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
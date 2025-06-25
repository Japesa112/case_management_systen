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

@section('title', 'Closed Case')

@section('content')
<div class="container-fluid">
    <div class="row mt-1" style="margin-left: 5%; margin-right: 5%;">
        <div class="col-md-12 mt-2">
            <h1 class="page-header mt-2">Closed Case</h1>
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Case Closure Form</h4>
                    

                    <div class="panel-heading-btn">
                        <a href="{{ route('cases.index') }}"  class="btn btn-dark btn-sm d-flex align-items-center gap-2">
                        <i class="fa fa-arrow-left text-white fw-bold"></i> <span class="text-white">Back to Cases</span>
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

                    <form action="{{ route('closed_cases.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <input type="hidden" name="case_id" value="{{ $case_id }}">
                    
                                <div class="form-group mt-2">
                                    <label for="case_name">Case Name <span class="text-danger">*</span></label>
                                    <input type="text" id="case_name" class="form-control" value="{{ $case_name }}" disabled>
                                </div>
                    
                                <div class="form-group mt-2">
                                    <label for="closure_date">Closure Date <span class="text-danger">*</span></label>
                                    <input type="date" name="closure_date" id="closure_date" class="form-control" required>
                                </div>
                    
                              <div class="form-group mt-2">
                                <label for="final_outcome">Final Outcome <span class="text-danger">*</span></label>
                                <select name="final_outcome" id="final_outcome" class="form-control" required>
                                    <option value="">Select Outcome</option>
                                    <option value="Win">Win</option>
                                    <option value="Loss">Loss</option>
                                    <option value="Dismissed">Dismissed</option>
                                    <option value="Settled">Settled</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <!-- Hidden input that appears if "Other" is selected -->
                            <div class="form-group mt-2 d-none" id="final_outcome_other_wrapper">
                                <label for="final_outcome_other">Specify Other Outcome</label>
                                <input type="text" name="final_outcome_other" id="final_outcome_other" class="form-control">
                            </div>

                               
                            </div>
                    
                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="lawyer_payment_confirmed">Payment Confirmed <span class="text-danger">*</span></label>
                                    <select name="lawyer_payment_confirmed" id="lawyer_payment_confirmed" class="form-control" required>
                                        <option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                
                                <div class="form-group mt-2">
                                    <label for="follow_up_actions">Follow-up Actions</label>
                                    <textarea name="follow_up_actions" id="follow_up_actions" class="form-control" rows="3" placeholder="Enter follow-up actions (if any)"></textarea>
                                </div>
                    
                               
                    
                              
                    
                                <div class="form-group mt-2">
                                    <label for="closureAttachments">Attach Supporting Documents</label>
                                    <input type="file" name="closureAttachments[]" id="closureAttachments" class="form-control" multiple>
                                </div>
                            </div>
                        </div>
                    
                      <div class="form-group d-flex justify-content-between align-items-center mt-3">

                            <!-- Back Button (Left) -->
                            <button type="button" onclick="window.history.back();" class="btn btn-secondary d-inline-flex align-items-center gap-2">
                                <i class="fa fa-arrow-left"></i> <span>Back</span>
                            </button>

                            <!-- Middle Button (Center) -->
                            <a href="/closed_cases" class="btn btn-info d-inline-flex align-items-center gap-2">
                                <i class="fa fa-archive"></i> <span>Closed Cases</span>
                            </a>

                            <!-- Submit Button (Right) -->
                            <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2">
                                <i class="fa fa-folder-check"></i> <span>Close Case</span>
                            </button>

                        </div>


                    </form>
                           
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('close_success'))

    <script>
        swal({
            title: "Case Closure submitted!",
            text: "Do you have closing documents to upload?",
            icon: "info",
            buttons: ["No", "Yes"]
        }).then((willUpload) => {
            if (willUpload) {
                $('#addDocumentModal').modal('show');
                
            } else {
                window.location.href = "{{ route('closed_case.index') }}?message=Case+closed+successfully";
            }
        });
    </script>
@endif

<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDocumentModalLabel">Add Document closure Document  </h5>
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
    <script>
    document.getElementById('final_outcome').addEventListener('change', function () {
        const selected = this.value;
        const otherWrapper = document.getElementById('final_outcome_other_wrapper');
        const otherInput = document.getElementById('final_outcome_other');

        if (selected === 'Other') {
            otherWrapper.classList.remove('d-none');
            otherInput.required = true;
        } else {
            otherWrapper.classList.add('d-none');
            otherInput.required = false;
            otherInput.value = '';
        }
    });
</script>

    
@endpush
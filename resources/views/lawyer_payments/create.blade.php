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

@section('title', 'Create Payment')

@section('content')
<div class="container-fluid">

    @php
    
    $isLawyer = Auth::user() && Auth::user()->role === 'Lawyer';

    @endphp
    <div class="row mt-4" style="margin-left: 10%; margin-right: 10%;">
        <div class="col-md-12 mt-3">
            @if ($isLawyer)
            <h1 class="page-header mt-3">Request Payout</h1>
            @else
            <h1 class="page-header mt-3">Record Lawyer Payment</h1>
            @endif
            
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Lawyer Payment Form</h4>
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

                    <form action="{{ route('lawyer_payments.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="case_id">Case ID <span class="text-danger">*</span></label>
                                    <input type="text" name="case_id" id="case_id" class="form-control" value="{{ $case_id }}" disabled>
                                    <input type="hidden" name="case_id" value="{{ $case_id }}">
                                </div>
                    
                                <div class="form-group mt-2">
                                    <label for="case_name">Case Name <span class="text-danger">*</span></label>
                                    <input type="text" name="case_name" id="case_name" class="form-control" value="{{ $case_name }}" disabled>
                                    <input type="hidden" name="case_name" value="{{ $case_name }}">
                                </div>
                    
                                <div class="form-group mt-2">
                                    <label for="amount_paid">Amount Paid <span class="text-danger">*</span></label>
                                    <input type="number" name="amount_paid" id="amount_paid" class="form-control" required>
                                </div>
                    
                                <div class="form-group mt-2">
                                    <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                                    <select name="payment_method" id="payment_method" class="form-control" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Mpesa">Mpesa</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    
                                </div>
                               
                                
                            </div>
                    
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="payment_lawyer">Select Lawyer <span class="text-danger">*</span></label>
                                    <select name="payment_lawyer" id="payment_lawyer" class="form-control" required>
                                        <option value="">Select Lawyer</option>
                                        <!-- Lawyers will be dynamically added here -->
                                    </select>
                                </div>
                                
                                
                                <div class="form-group mt-2">
                                    <label for="payment_date">Payment Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="payment_date" id="payment_date" class="form-control" required>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="appeal_details">Transaction  Details</label>
                                    <textarea name="transaction" id="transaction" class="form-control" rows="2"></textarea>
                                </div>
                    
                                <div class="form-group mt-2">
                                    <label for="lawyer_payment_status">Payment Status<span class="text-danger">*</span></label>
                                    <select name="lawyer_payment_status" id="lawyer_payment_status" class="form-control" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Completed">Completed</option>
                                        
                                    </select>
                                    
                                </div>
                    
                               
                                <div class="form-group mt-2">
                                    <label for="paymentAttachments">Select Files</label>
                                    <input type="file" name="lawyerPaymentAttachments[]" id="lawyerPaymentAttachments" class="form-control" multiple accept=".pdf,.doc,.docx,.jpg,.png">
                                </div>
                                <ul id="fileList" class="list-group mt-2"></ul>
                            </div>
                        </div>
                    
                        <div class="form-group d-flex justify-content-between align-items-center mt-2">

                              <!-- Back Button -->
                              <button type="button" onclick="window.history.back();" class="btn btn-secondary d-inline-flex align-items-center gap-2">
                                <i class="fa fa-arrow-left"></i> Back
                              </button>

                              <!-- Lawyer Payments Button -->
                              <a href="{{ url('/lawyer_payments') }}" class="btn btn-info d-inline-flex align-items-center gap-2">
                                <i class="fa fa-money-bill-wave"></i> Lawyer Payments
                              </a>

                              <!-- Submit Payment Button -->
                              <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2">
                                <i class="fa fa-paper-plane"></i> Submit Payment
                              </button>

                            </div>

                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('payment_success'))
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        swal({
            title: "Payment submitted!",
            text: "Do you have payment documents to upload?",
            icon: "info",
            buttons: ["No", "Yes"]
        }).then((willUpload) => {
            if (willUpload) {
                $('#addDocumentModal').modal('show');
                
            } else {
                window.location.href = "{{ route('all_payments.index') }}?message=Payment+added+successfully";
            }
        });
    </script>
@endif

<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDocumentModalLabel">Add Payment Document  </h5>
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
        const fileInput = document.getElementById("lawyerPaymentAttachments");
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
    $(document).ready(function () {
        $.ajax({
            url: "/lawyer_payments/get-lawyers",
            type: "GET",
            dataType: "json",
            success: function (response) {
                let paymentMethodSelect = $("#payment_lawyer");
                
                paymentMethodSelect.empty();
                paymentMethodSelect.append('<option value="">Select Lawyer</option>');

                $.each(response, function (index, lawyer) {
                    console.log("The lawyer is: "+lawyer.lawyer_id);
                    paymentMethodSelect.append(`<option value="${lawyer.lawyer_id}">${lawyer.display_name}</option>`);
                });
            },
            error: function () {
                alert("Failed to fetch lawyers. Please try again.");
            }
        });
    });
</script>
    
    
@endpush
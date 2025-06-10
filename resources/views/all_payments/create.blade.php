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

@section('title', 'Payment Evidence')

@section('content')
<div class="container-fluid">
    <div class="row mt-4" style="margin-left: 10%; margin-right: 10%;">
        <div class="col-md-12 mt-4">
            <h1 class="page-header mt-4">Payment Evidence</h1>
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Payment Evidence Form</h4>
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

                    <form action="{{ route('all_payments.store') }}" method="POST" enctype="multipart/form-data">
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

                                <div class="form-group mt-2">
                                    <label for="payment_status">Payment Status <span class="text-danger">*</span></label>
                                    <select name="payment_status" id="payment_status" class="form-control" required>
                                        <option value="">Select Payment Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                    
                                </div>
                               <!-- Payer Type -->
                                <div class="form-group mt-2">
                                    <label for="payer_type">Payee (Payment Recipient) <span class="text-danger">*</span></label>
                                    <select name="payee" id="payee" class="form-control" required>
                                        <option value="">Select Payment From</option>
                                        <option value="kenyatta_university">Kenyatta University</option>
                                        <option value="complainant">Claimant</option>
                                        <option value="lawyer">Lawyer</option>
                                        <option value="other">Other Payment</option>
                                    </select>
                                </div>
                                
                            </div>
                    
                            <div class="col-md-6">

                                

                                <!-- Complainant Select (Initially Hidden) -->
                                <div class="form-group mt-2 d-none" id="complainant_select_group">
                                    <label for="complainant_id">Select Complainant</label>
                                    <select name="payee_id" id="complainant_id" class="form-control">
                                        <option value="">Select Claimant</option>
                                        @foreach ($complainants as $complainant)
                                            <option value="{{ $complainant->Complainant_id }}">{{ $complainant->complainant_name."-:".$complainant->phone}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Lawyer Select (Initially Hidden) -->
                                <div class="form-group mt-2 d-none" id="lawyer_select_group">
                                    <label for="lawyer_id">Select Lawyer</label>
                                    <select name="payee_id" id="lawyer_id" class="form-control">
                                        <option value="">Select Lawyer</option>
                                        @foreach ($lawyers as $lawyer)
                                            <option value="{{ $lawyer->lawyer_id }}">{{ $lawyer->user->full_name."-".$lawyer->license_number }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Payment Type Select (Only for Lawyer) -->
                                <div class="form-group mt-2 d-none" id="payment_type_group">
                                    <label for="payment_type">Payment Type <span class="text-danger">*</span></label>
                                    <select id="payment_type" name="payment_type" class="form-control">
                                        <option value="">Select Payment Type</option>
                                        <option value="deposit">Deposit</option>
                                        <option value="final">Final Payment</option>
                                    </select>
                                </div>





                                 <div class="form-group mt-2">
                                    <label for="payment_date">Expected Payment Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="due_date" id="due_date" class="form-control" required>
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
                                    <label for="auctioneer_involvement">Auctioneer Involvement</label>
                                    <textarea name="auctioneer_involvement" id="auctioneer_involvement" class="form-control" rows="2"></textarea>
                                </div>
                    
                               
                                <div class="form-group mt-2">
                                    <label for="paymentAttachments">Select Files</label>
                                    <input type="file" name="paymentAttachments[]" id="paymentAttachments" class="form-control" multiple accept=".pdf,.doc,.docx,.jpg,.png">
                                </div>
                                <ul id="fileList" class="list-group mt-2"></ul>
                            </div>
                        </div>
                    
                        <div class="form-group d-flex justify-content-between align-items-center mt-3 px-3">

                            <!-- Back Button -->
                            <button type="button" onclick="window.history.back();" class="btn btn-secondary d-flex align-items-center">
                                <i class="fa fa-arrow-left me-1"></i> Back
                            </button>

                            <!-- Go to Payments Button -->
                            <a href="/all_payments" class="btn btn-info d-flex align-items-center">
                                <i class="fa fa-credit-card me-1"></i> Go to Payments
                            </a>

                            <!-- Submit Payment Button -->
                            <button type="submit" class="btn btn-primary d-flex align-items-center">
                                <i class="fa fa-paper-plane me-1"></i> Submit Payment
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
        const fileInput = document.getElementById("paymentAttachments");
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
    $('#payee').on('change', function () {
        let selected = $(this).val();

        // Hide and reset all conditionally displayed fields
        $('#complainant_select_group').addClass('d-none');
        $('#lawyer_select_group').addClass('d-none');
        $('#payment_type_group').addClass('d-none');

        $('#complainant_id').removeAttr('name').prop('required', false);
        $('#lawyer_id').removeAttr('name').prop('required', false);
        $('#payment_type').removeAttr('name').prop('required', false);

        // Show based on selection
        if (selected === 'complainant') {
            $('#complainant_select_group').removeClass('d-none');
            $('#complainant_id').attr('name', 'payee_id').prop('required', true);
        } else if (selected === 'lawyer') {
            $('#lawyer_select_group').removeClass('d-none');
            $('#lawyer_id').attr('name', 'payee_id').prop('required', true);

            // Show payment type for lawyer
            $('#payment_type_group').removeClass('d-none');
            $('#payment_type').attr('name', 'payment_type').prop('required', true);
        }
    });
});
</script>



<script>
$(document).ready(function () {
    let complainantSelectInstance = null;
    let lawyerSelectInstance = null;

    $('#payee').on('change', function () {
        let selected = $(this).val();

        // Hide both groups and clean up
        $('#complainant_select_group').addClass('d-none');
        $('#lawyer_select_group').addClass('d-none');

        $('#complainant_id').removeAttr('name').prop('required', false);
        $('#lawyer_id').removeAttr('name').prop('required', false);

        // Destroy existing TomSelect instances if they exist
        if (complainantSelectInstance) {
            complainantSelectInstance.destroy();
            complainantSelectInstance = null;
        }
        if (lawyerSelectInstance) {
            lawyerSelectInstance.destroy();
            lawyerSelectInstance = null;
        }

        // Show and initialize TomSelect on the selected group
        if (selected === 'complainant') {
            $('#complainant_select_group').removeClass('d-none');
            $('#complainant_id').attr('name', 'payee_id').prop('required', true);

            complainantSelectInstance = new TomSelect('#complainant_id', {
                placeholder: "Search Claimant...",
                allowEmptyOption: true
            });

        } else if (selected === 'lawyer') {
            $('#lawyer_select_group').removeClass('d-none');
            $('#lawyer_id').attr('name', 'payee_id').prop('required', true);

            lawyerSelectInstance = new TomSelect('#lawyer_id', {
                placeholder: "Search Lawyer...",
                allowEmptyOption: true
            });
        }
    });
});
</script>


@endpush


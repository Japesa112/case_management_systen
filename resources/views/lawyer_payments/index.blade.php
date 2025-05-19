@extends('layouts.default')

@section('title', 'Lawyer Payments')

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
    }.dataTables_filter {
        margin-bottom: 20px; /* Adjust this value as needed */
        margin-right: 20px;
       
    }
     /* Make the search input rounded */
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

    @php
    $isLawyer = Auth::user() && Auth::user()->role === 'Lawyer'; 
    @endphp
    
    @if ($isLawyer)
    <h4>My Payments</h4>
        
    @else
        <h4>Payments</h4>
    @endif

    
    <div class="panel panel-inverse">

         <div class="panel-heading d-flex justify-content-between align-items-center">
            
            @if ($isLawyer)
            <a href="{{ url('/cases') }}" class="btn btn-dark btn-sm d-flex align-items-center gap-2">
                <i class="fa fa-arrow-left text-white fw-bold"></i> <span class="text-white">Back to Cases</span>
            </a>
            <div class="panel-heading-btn">
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addEvaluationModal">
                    <i class="fa fa-plus"></i> Request Case Payment
                </button>
            </div>
            @else
           <a href="{{ url('/cases') }}" class="btn btn-dark btn-sm d-flex align-items-center gap-2">
                <i class="fa fa-arrow-left text-white fw-bold"></i> <span class="text-white">Back to Cases</span>
            </a>
            <div class="panel-heading-btn">
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addEvaluationModal">
                    <i class="fa fa-plus"></i> Add New Case Payment
                </button>
            </div>
            @endif

            



        </div>
        <div class="panel-body">
            
             <!-- Modal -->
             <div class="modal fade" id="addEvaluationModal" tabindex="-1" aria-labelledby="addEvaluationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            

                            @if ($isLawyer)
                            <h5 class="modal-title" style="color: rgb(1, 9, 12)" id="addEvaluationModalLabel">Request Payment</h5>
                            @else
                            <h5 class="modal-title" style="color: rgb(1, 9, 12)" id="addEvaluationModalLabel">Pay Lawyer</h5>
                            @endif
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="checkCaseForm">
                                @csrf
                               <div class="form-group">
                                    <label for="evaluation_case_id" style="color: rgb(1, 9, 12)">Select Case <span class="text-danger">*</span></label>
                                    <select name="case_id" id="evaluation_case_id" class="form-control" required>
                                       
                                        <!-- Options will be populated via AJAX -->
                                    </select>
                                 </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    
                                    @if ($isLawyer)
                                    <button type="submit" class="btn btn-primary">Request Payment</button>
                                    @else
                                    <button type="submit" class="btn btn-primary">Pay a Lawyer</button>
                                    @endif
                                    
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
                <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Case Name</th>
                            <th>Lawyer</th>
                            <th>Amount Paid</th>                            
                            <th>Payment Method</th>
                            <th>Payment Date</th>
                             <th>Next Step</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td class="text-center">{{ $payment->payment_id }}</td>
                                
                                <td class="text-center">
                                 @if($payment->case)
                                    <a href="{{ route('cases.show', $payment->case->case_id) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center" title="View Case">
                                        <i class="fa fa-eye me-1"></i> {{ $payment->case->case_name }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                                 </td>
                                <td class="text-center">{{ $payment->lawyer->license_number.'-'. $payment->lawyer->user->full_name }}</td>
                                <td class="text-center">{{ $payment->amount_paid }}</td>
                                <td class="text-center">{{ $payment->payment_method }}</td>
                                <td class="text-center">{{ $payment->payment_date ?? 'N/A' }}</td>
                                <td>
                                @if($payment->case)
                                 <a href="{{ route('closed_cases.create', $payment->case->case_id) }}" 
                                       class="btn btn-sm btn-outline-success d-inline-flex align-items-center" 
                                       title="Close this case">
                                        <i class="fa fa-gavel me-1"></i> Close Case
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                                <td class="text-center action-buttons">
                                    <button class="btn btn-warning btn-sm edit-payment" data-id="{{ $payment->payment_id }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>

                                    <button class="btn btn-info btn-sm view-payment" data-id="{{ $payment->payment_id }}">
                                        <i class="fa fa-eye"></i> View
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



<!-- View Payment Modal -->
<div class="modal fade" id="viewPaymentModal" tabindex="-1" aria-labelledby="viewPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewPaymentModalLabel">Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="payment-content">
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


<!-- Edit Payment Modal -->
<div class="modal fade" id="editPaymentModal" tabindex="-1" aria-labelledby="editPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editPaymentModalLabel">Edit Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Left Section: Document List -->
                    <div class="col-md-5 border-end">
                        <h5>Existing Attachments</h5>
                        <ul id="documentList" class="list-group mb-3">
                            <!-- Documents will be loaded here dynamically -->
                        </ul>
                        <button type="button" class="btn btn-success btn-sm"  id="openUploadModalBtn">
                            <i class="fa fa-plus"></i> Add Attachment
                        </button>
                    </div>

                    <!-- Right Section: Edit Payment Form -->
                    <div class="col-md-7">
                        <form id="editPaymentForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" id="edit_payment_id" name="payment_id">
                            <input type="hidden" class="form-control" id="edit_case_id" name="case_id" readonly>
                            <div class="row">
                            <div class="col-md-6">

                            <div class="mb-3">
                                <label for="edit_case_id" class="form-label">Case Name</label>
                                <input type="text" class="form-control" id="edit_case_name" name="case_name" readonly disabled>
                            </div>


                            

                            <div class="form-group mt-2">
                                <label for="amount_paid">Amount Paid <span class="text-danger">*</span></label>
                                <input type="number" name="amount_paid" id="edit_amount_paid" class="form-control" required>
                            </div>
                
                            <div class="form-group mt-2">
                                <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                                <select name="payment_method" id="edit_payment_method" class="form-control" required>
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
                                    <select name="payment_lawyer" id="edit_payment_lawyer" class="form-control" required>
                                        <option value="">Select Lawyer</option>
                                        <!-- Lawyers will be dynamically added here -->
                                    </select>
                                </div>
                                
                                
                                <div class="form-group mt-2">
                                    <label for="payment_date">Payment Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="payment_date" id="edit_payment_date" class="form-control" required>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="appeal_details">Transaction  Details</label>
                                    <textarea name="transaction" id="edit_transaction" class="form-control" rows="2"></textarea>
                                </div>
                    
                                <div class="form-group mt-2">
                                    <label for="lawyer_payment_status">Payment Status<span class="text-danger">*</span></label>
                                    <select name="lawyer_payment_status" id="edit_lawyer_payment_status" class="form-control" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Completed">Completed</option>
                                        
                                    </select>
                                    
                                </div>
                    
                            </div>

                            </div>
                            <!--
                            <div class="mb-3">
                                <label for="editAttachments" class="form-label">Upload New Attachments</label>
                                <input type="file" class="form-control" id="editAttachments" name="attachments[]" multiple>
                            </div>
                        -->

                            <button type="submit" class="btn btn-primary" id="updatePaymentBtn">
                                Update Payment
                            </button>
                        </form>
                    </div>
                </div>
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
                <input type="hidden" id="modal_payment_id">
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

@endsection

@push('scripts')
<script>

     $(document).ready(function () {
    let tomSelectInstance;

    $('#addEvaluationModal').on('shown.bs.modal', function () {
        let caseSelect = $('#evaluation_case_id');

        // If already initialized, destroy previous Tom Select instance
        if (tomSelectInstance) {
            tomSelectInstance.destroy();
            tomSelectInstance = null;
        }

        caseSelect.empty().append('<option value="">Loading cases...</option>');

        $.ajax({
            url: "{{ route('cases.available-evaluation-cases') }}",
            type: "GET",
            success: function (response) {
                caseSelect.empty();
               caseSelect.append('<option value="">Select Case</option>');

                $.each(response, function (index, caseItem) {
                    caseSelect.append(
                        `<option value="${caseItem.case_number}">${caseItem.display_name}</option>`
                    );
                });

                // Reinitialize Tom Select *after* options are loaded
                tomSelectInstance = new TomSelect('#evaluation_case_id', {
                    placeholder: "Select Case",
                    allowEmptyOption: true,
                    maxOptions: 500
                });
            },
            error: function () {
                caseSelect.empty().append('<option value="">Failed to load cases</option>');
                alert("Failed to fetch cases. Please try again.");
            }
        });
    });
});
     
    $(document).ready(function () {
        $(document).on('click', '.view-payment', function () {
            let paymentId = $(this).data('id');

            // Show the modal
            $('#viewPaymentModal').modal('show');

            // Display a loading indicator
            $('#payment-content').html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading details...</div>');

            // Fetch payment details
            $.ajax({
                url: "{{ route('lawyer_payments.show', ':id') }}".replace(':id', paymentId),
                type: "GET",
                success: function (response) {
                    let payment = response.payment;
                    let attachments = response.attachments;
                    let case_name = response.case_name;
                    let lawyer = response.lawyer;
  
                            
                                        let content = `
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Case Name:</strong> ${case_name ?? 'N/A'}<br>
                                <strong>Lawyer: </strong> ${lawyer ?? 'N/A'}<br>
                                <strong>Payment Date:</strong> ${payment.payment_date ?? 'N/A'}<br>
                                <strong>Payment Time:</strong> ${payment.payment_time ?? 'N/A'}<br>
                                <strong>Amount Paid:</strong> ${payment.amount_paid ?? 'N/A'}<br>
                                <strong>Payment Method:</strong> ${payment.payment_method ?? 'N/A'}<br>
                                
                                <strong>Payment :</strong> ${payment.lawyer_payment_status ?? 'N/A'}<br>
                            </div>
                            <div class="col-md-6">
                                <strong>Created At:</strong> ${payment.created_at ?? 'N/A'}<br>
                                <strong>Updated At:</strong> ${payment.updated_at ?? 'N/A'}<br>
                                <strong>Transaction Details:</strong> <p>${payment.transaction ?? 'N/A'}</p>
                            </div>
                        </div>
                        <hr>
                        <h5>Attachments</h5>
                        <ul class="list-group">
                    `;


                    if (attachments.length > 0) {
                        attachments.forEach(file => {
                            content += `
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="${file.file_path}" target="_blank">${file.file_name}</a>
                                    <span class="badge bg-primary">${file.file_type ?? 'Unknown'}</span>
                                </li>
                            `;
                        });
                    } else {
                        content += `<li class="list-group-item text-muted">No attachments found.</li>`;
                    }

                    content += `</ul>`;

                    $('#payment-content').html(content);
                },
                error: function () {
                    $('#payment-content').html('<div class="text-danger text-center">Error loading payment details.</div>');
                }
            });
        });

$(document).ready(function () {
    $(document).on('click', '.edit-payment', function () {

        let paymentId = $(this).data('id');
        console.log("The payment id is: "+paymentId);
        $.ajax({
            url: "/lawyer_payments/get-lawyers",
            type: "GET",
            dataType: "json",
            success: function (response) {
                let paymentMethodSelect = $("#edit_payment_lawyer");
                
                paymentMethodSelect.empty();
                paymentMethodSelect.append('<option value="">Select Lawyer</option>');

                $.each(response, function (index, lawyer) {
                    console.log("The lawyer is: "+lawyer.lawyer_id);
                    paymentMethodSelect.append(`<option value="${lawyer.lawyer_id}">${lawyer.display_name}</option>`);
                });

    
        // Fetch payment details using AJAX
        $.ajax({
            url: `lawyer_payments/show/${paymentId}`, // Make sure this route exists in your Laravel routes
            type: "GET",
            success: function (response) {
                let payment= response.payment;
                let formattedDateTime = response.formattedDateTime;
                let attachments = response.attachments; // Get attachments correctly
                let case_name = response.case_name;
                console.log("The lawyer is: "+response.lawyer);
                // Populate form fields with fetched data
                $('#edit_payment_id').val(payment.payment_id);
                $('#edit_case_id').val(payment.case_id);
                $('#edit_case_name').val(case_name);
                $('#edit_transaction').val(payment.transaction);
                // Create a mapping of database values to select option values
                  

                    // Set the select value
                    $('#edit_payment_method').val(payment.payment_method);
                    $('#edit_lawyer_payment_status').val(payment.lawyer_payment_status);
                    $('#edit_payment_lawyer').val(response.lawyer_id);
                    
                $('#edit_auctioneer_involvement').val(payment.auctioneer_involvement);
                $('#edit_payment_date').val(formattedDateTime);
                $('#edit_amount_paid').val(payment.amount_paid);




                 // Clear and populate document list
                 $('#documentList').empty();
                if (attachments.length > 0) {
                    attachments.forEach(doc => {
                        $('#documentList').append(`
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                               <a href="${doc.file_path}" target="_blank">${doc.file_name}</a>
                                <button class="btn btn-danger btn-sm delete-document" data-id="${doc.attachment_id}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </li>
                        `);
                    });
                } else {
                    $('#documentList').append('<li class="list-group-item no-documents">No documents uploaded.</li>');
                }


                // Show the modal
                $('#editPaymentModal').modal('show');
            },
            error: function () {
                alert("Error fetching payment details.");
            }
        });
    
    
    

        
    },
            error: function () {
                alert("Failed to fetch lawyers. Please try again.");
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
                url: `/lawyer_payments/deleteDocuments/${documentId}`,
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
    // Open modal and set payment ID
    $("#openUploadModalBtn").click(function () {
        let paymentId = $("#edit_payment_id").val(); // Ensure the payment ID is available
        console.log("Payment ID: "+paymentId);
        $("#modal_payment_id").val(paymentId);
        $("#uploadAttachmentModal").modal("show");
    });

    // Upload file when clicking "Upload" in the modal
    $("#modal_uploadAttachmentBtn").click(function () {
        let paymentId = $("#modal_payment_id").val();
        console.log("Payment ID: "+paymentId);

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
        formData.append("payment_id", paymentId);
        formData.append("attachment", fileInput);
        formData.append("_token", $('meta[name="csrf-token"]').attr("content"));

        $.ajax({
            url: "/lawyer_payments/uploadAttachment",
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

//Updating the payment
$(document).ready(function () {
    $("#editPaymentForm").on("submit", function (e) {
        e.preventDefault(); // Prevent default form submission

        let formData = new FormData(this);
        let paymentId = $("#edit_payment_id").val(); // Get payment ID
        let url = `/lawyer_payments/update/${paymentId}`; // Construct the update route URL
        console.log("Payment ID:", $("#edit_payment_id").val());
        console.log("Form Data:", Object.fromEntries(new FormData($("#editPaymentForm")[0])));
        
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
                    text: "Payment has been updated successfully!",
                }).then(() => {
                    window.location.href = "/lawyer_payments"; // Redirect after success
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
    
           let caseNumber = $('#evaluation_case_id').val();     
            $.ajax({
                url: "{{ route('lawyer_payments.checkCase') }}", 
                type: "GET", 
                data: { case_number: caseNumber }, 
                success: function (response) {
                    if (response.exists) {
                        if (response.evaluation) {
                            // Redirect to evaluations.edit if evaluation exists
                            window.location.href = response.evaluation.edit_url;
                        } else {
                            console.log(response);
                            // Redirect to evaluations.create if no evaluation exists
                            window.location.href = "{{ route('lawyer_payments.create', ':case_id') }}"
                                .replace(':case_id', response.case_id) + 
                                "?case_name=" + encodeURIComponent(response.case_name);
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
@extends('layouts.default')
@section('title', 'Submit Case for Panel Evaluation')

@section('content')
<!-- BEGIN panel -->
<div class="panel panel-inverse mt-5">
  <div class="panel-heading">
    <h4 class="panel-title">Message Lawyers about this Case</h4>
  </div>
  <div class="panel-body">
    <form id="panelEvaluationForm">
      @csrf
      <input type="hidden" name="case_id" id="caseId" value="{{ $caseId ?? '' }}">

     <div class="mb-3">
        <label for="payment_lawyer" class="form-label">Select Lawyer(s) <span class="text-danger">*</span></label>
        <select id="payment_lawyer" name="lawyer_id[]" class="form-control" multiple required>
          <option value="">Loading lawyers...</option>
        </select>
      </div>



      <div class="mb-3">
        <label for="panelMessage" class="form-label">Message to Lawyers</label>
        <textarea class="form-control" id="panelMessage" name="message" rows="5" placeholder="Enter your message to the panel..."></textarea>
      </div>
      

      <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
          <!-- Back Button (Left) -->
          <button type="button" onclick="window.history.back();" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2">
              <i class="fa fa-arrow-left"></i> <span>Back</span>
          </button>

          <!-- Go to Panel Evaluation (Center) -->
          <a href="{{ url('/evaluations') }}" class="btn btn-outline-info d-inline-flex align-items-center gap-2">
              <i class="fa fa-gavel"></i> <span>See Offers for this Case</span>
          </a>

          <!-- Send Evaluation Request (Right) -->
          <button type="submit" id="sendPanelEvaluationBtn" class="btn btn-primary d-inline-flex align-items-center gap-2">
              <i class="fa fa-paper-plane"></i> <span>Send Message</span>
          </button>
      </div>

    </form>
  </div>
</div>
<!-- END panel -->
@endsection


@push("scripts")
<script>
  $(document).ready(function () {
    $('#panelEvaluationForm').on('submit', function (e) {
      e.preventDefault();

      const caseId = $('#caseId').val();
      const message = $('#panelMessage').val().trim();
      const selectedLawyers = $('#payment_lawyer').val(); // Get selected lawyers

      if (!selectedLawyers || selectedLawyers.length === 0) {
        Swal.fire('Warning', 'Please select at least one lawyer.', 'warning');
        return;
      }

      if (message === '') {
        Swal.fire('Warning', 'Please enter a message to send.', 'warning');
        return;
      }

      $.ajax({
        url: `/cases/${caseId}/submit-panel-evaluation`,
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          message: message,
          lawyer_ids: selectedLawyers // Send the array of lawyer IDs
        },
        success: function (response) {
          Swal.fire({
            title: 'Success',
            text: response.message || 'Message sent successfully.',
            icon: 'success',
            confirmButtonText: 'Go to Evaluations'
          }).then(() => {
            window.location.href = '/evaluations';
          });
        },
        error: function (xhr) {
          let errorMsg = 'Something went wrong.';
          if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMsg = xhr.responseJSON.message;
          }
          Swal.fire('Error', errorMsg, 'error');
        }
      });
    });
  });
</script>



<script>
$(document).ready(function () {
    let lawyerSelect = $('#payment_lawyer');
    let lawyerTomSelect;

    // Destroy existing Tom Select if re-initializing
    if (lawyerTomSelect) {
        lawyerTomSelect.destroy();
        lawyerTomSelect = null;
    }

    // Fetch lawyers
    $.ajax({
        url: "/lawyer_payments/get-lawyers",
        type: "GET",
        dataType: "json",
        success: function (response) {
            lawyerSelect.empty().append('<option value="">Select Lawyer</option>');

            $.each(response, function (index, lawyer) {
                lawyerSelect.append(
                    `<option value="${lawyer.lawyer_id}">${lawyer.display_name}</option>`
                );
            });

            // Initialize Tom Select
            lawyerTomSelect = new TomSelect('#payment_lawyer', {
                placeholder: "Select Lawyer",
                allowEmptyOption: true,
                maxOptions: 500
            });
        },
        error: function () {
            lawyerSelect.empty().append('<option value="">Failed to load lawyers</option>');
            alert("Failed to fetch lawyers. Please try again.");
        }
    });
});
</script>


@endpush
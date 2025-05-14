@extends('layouts.default')
@section('title', 'Submit Case for Panel Evaluation')

@section('content')
<!-- BEGIN panel -->
<div class="panel panel-inverse">
  <div class="panel-heading">
    <h4 class="panel-title">Submit Case for Panel Evaluation</h4>
  </div>
  <div class="panel-body">
    <form id="panelEvaluationForm">
      @csrf
      <input type="hidden" name="case_id" id="caseId" value="{{ $caseId ?? '' }}">

      <div class="mb-3">
        <label for="panelMessage" class="form-label">Message to Lawyers</label>
        <textarea class="form-control" id="panelMessage" name="message" rows="5" placeholder="Enter your message to the panel..."></textarea>
      </div>

      <div class="text-end">
        <button type="submit" id="sendPanelEvaluationBtn" class="btn btn-primary">
          <i class="fa fa-paper-plane me-1"></i> Send Evaluation Request
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
        data: { message: message },
        success: function (response) {
          Swal.fire({
            title: 'Success',
            text: response.message || 'Message sent successfully.',
            icon: 'success',
            confirmButtonText: 'Go to Evaluations'
          }).then(() => {
            // Redirect to the evaluations list
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

@endpush
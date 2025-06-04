@extends('layouts.default')
@section('title', 'PreTrials')

@push('styles')
<style>
    .pretrial-item.active {
        background-color: #e0f0ff;
        font-weight: bold;
        border-left: 4px solid #007bff;
    }

    .pretrial-item.active {
  cursor: pointer;
}

</style>
@endpush


@section('content')
<div class="container-fluid">
    <div class="row mt-2" style="margin-left: 2%; margin-right: 2%;">
        <div class="col-md-12 mt-2">

            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title d-flex align-items-center">
                    PreTrials for 
                    
                    <a href="{{ route('cases.show', $case) }}" class="btn btn-primary btn-sm ms-2" title="View Case" style="padding: 2px 8px;">
                        <i> {{ $case->case_name ?? 'N/A' }}</i>
                    </a>
                </h4>

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
                    <div class="row">
                        <!-- Left: 30% -->
                        <div class="col-md-4">
                            <div class="card card-body bg-light">
                                <h5>Pre-Trial Dates</h5>
                                @if($preTrials->isEmpty())
                                    <p>No pre-trials available.</p>
                                @else
                                    <ul class="list-group" id="pretrial-list">
                                       @foreach($preTrials as $index => $preTrial)
                                            <li class="list-group-item pretrial-item {{ $index === 0 ? 'active' : '' }}"
                                                data-id="{{ $preTrial->pretrial_id }}"
                                                data-date="{{ $preTrial->pretrial_date }}"
                                                data-time="{{ $preTrial->pretrial_time }}"
                                                data-location="{{ $preTrial->location }}"
                                                data-comments="{{ $preTrial->comments }}">
                                                {{ $preTrial->pretrial_date }} @ {{ $preTrial->pretrial_time }}
                                            </li>
                                        @endforeach

                                    </ul>
                                @endif

                                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addPreTrialModal">
                                    Add Pre-Trial
                                </button>
                            </div>
                        </div>

                        <!-- Right: 70% -->
                        <div class="col-md-8">
                            <div class="card card-body">
                               

                                @if($preTrials->isEmpty())
                                    <p>No pre-trials found.</p>
                                @else
                                <div id="pretrial-details" style="display: none;">
                                    <!-- Update Button -->
                                    <div class="d-flex justify-content-end mb-2">

                                        <div class="mb-2 text-end">
                                        <button class="btn btn-warning btn-sm" id="editPreTrialBtn" style="display: none;">
                                        ✏️ Update Pre-Trial
                                      </button>
                                    </div>


                                        
                                    </div>

                                    
                                    <div class="row">
                                        <!-- Left: Pre-Trial Info -->
                                        <div class="col-md-6 border-end mb-3 mb-md-0">
                                            <h6>Selected Pre-Trial Info</h6>
                                            <p><strong>Date:</strong> <span id="pt-date"></span></p>
                                            <p><strong>Time:</strong> <span id="pt-time"></span></p>
                                            <p><strong>Location:</strong> <span id="pt-location"></span></p>
                                            <p><strong>Comments:</strong> <span id="pt-comments"></span></p>
                                        </div>

                                        <!-- Right: Pre-Trial Members -->
                                        <div class="col-md-6">
                                            <h6 style="font-weight: ;"> Pre-Trial Members</h6>
                                            <div style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 0.5rem; border-radius: 4px;">
                                                <ul class="list-group" id="pt-members-list">
                                                    <!-- Members will be injected here -->
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                                    <hr>

                                    <!-- Documents Section -->
                                    <div id="pretrial-documents" style="display: none;">
                                        <h6>Documents</h6>
                                        <ul class="list-group" id="documents-list">
                                            <!-- Documents will be injected here -->
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

</div>


            </div>

        </div>
    </div>
</div>

<!-- Add Pre-Trial Modal -->
<div class="modal fade" id="addPreTrialModal" tabindex="-1" aria-labelledby="addPreTrialModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <form id="addPreTrialForm" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Add Pre-Trial</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <!-- Tabs -->
          <ul class="nav nav-tabs" id="pretrialTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab">Details</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="members-tab" data-bs-toggle="tab" data-bs-target="#members" type="button" role="tab">Members</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="attachments-tab" data-bs-toggle="tab" data-bs-target="#attachments" type="button" role="tab">Attachments</button>
            </li>
          </ul>

          <!-- Tab Content -->
          <div class="tab-content pt-3" id="pretrialTabContent">
            <!-- Details Tab -->
            <div class="tab-pane fade show active" id="details" role="tabpanel">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Pre-Trial Date</label>
                  <input type="date" name="pretrial_date" class="form-control required" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Pre-Trial Time</label>
                  <input type="time" name="pretrial_time" class="form-control required" required>
                </div>
                <div class="col-md-12">
                  <label class="form-label">Location</label>
                  <input type="text" name="location" class="form-control required" required>
                </div>
                <div class="col-md-12">
                  <label class="form-label">Comments</label>
                  <textarea name="comments" class="form-control" rows="3"></textarea>
                </div>
                <input type="hidden" name="case_id" value="{{ $case->case_id }}">
              </div>
              <div class="mt-4 d-flex justify-content-end">
                <button type="button" class="btn btn-primary" onclick="goToTab('members')">Next</button>
              </div>
            </div>

            <!-- Members Tab -->
            <div class="tab-pane fade" id="members" role="tabpanel">
              <div id="member-container">
                <div class="member-row row g-2 mb-2">
                  <div class="col-md-4">
                    <select name="members[0][member_type]" class="form-control required" required>
                      <option value="">Select Type</option>
                      <option value="lawyer">Lawyer</option>
                      <option value="witness">Witness</option>
                      <option value="dvc">DVC</option>
                      <option value="other">Other</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <input type="text" name="members[0][name]" class="form-control required" placeholder="Name" required>
                  </div>
                  <div class="col-md-3">
                    <input type="text" name="members[0][role_or_position]" class="form-control" placeholder="Role/Position">
                  </div>
                  <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">✕</button>
                  </div>
                </div>
              </div>
              <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addMemberRow()">+ Add Member</button>

              <div class="d-flex justify-content-between mt-3">
                <button type="button" class="btn btn-secondary" onclick="goToTab('details')">Previous</button>
                <button type="button" class="btn btn-primary" onclick="goToTab('attachments')">Next</button>
              </div>
            </div>

            <!-- Attachments Tab -->
            <div class="tab-pane fade" id="attachments" role="tabpanel">
              <div class="mb-3">
                <label class="form-label">Upload Files</label>
                <input type="file" name="attachments[]" class="form-control" multiple>
                <small class="text-muted">You can select multiple files.</small>
              </div>

              <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" onclick="goToTab('members')">Previous</button>
               <button type="submit" form="addPreTrialForm" class="btn btn-success">Save PreTrial</button>

              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer d-none"></div>
      </form>
    </div>
  </div>
</div>






@endsection

@push('scripts')
<script>
    window.pretrialDocuments = @json($documentsByPretrial);
    window.pretrialMembers = @json($membersByPretrial);
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const pretrialItems = document.querySelectorAll('.pretrial-item');
    const detailsSection = document.getElementById('pretrial-details');
    const documentsSection = document.getElementById('pretrial-documents');
    const documentsList = document.getElementById('documents-list');
    const membersList = document.getElementById('pt-members-list');

    pretrialItems.forEach(item => {
        item.addEventListener('click', function () {
            // Remove highlight from others
            pretrialItems.forEach(i => i.classList.remove('active', 'bg-info', 'text-white'));

            // Highlight selected item
            this.classList.add('active', 'bg-info', 'text-white');

            // Show details section
            detailsSection.style.display = 'block';

            // Fill details
            document.getElementById('pt-date').textContent = this.dataset.date;
            document.getElementById('pt-time').textContent = this.dataset.time;
            document.getElementById('pt-location').textContent = this.dataset.location;
            document.getElementById('pt-comments').textContent = this.dataset.comments;

            selectedPretrial = this;
            document.getElementById('editPreTrialBtn').style.display = 'inline-block';


            // Load documents and members
            loadDocuments(this.dataset.id);
            loadMembers(this.dataset.id);
        });
    });

    function loadDocuments(pretrialId) {
    documentsList.innerHTML = '';
    documentsSection.style.display = 'none';

    if (window.pretrialDocuments && window.pretrialDocuments[pretrialId]) {
        const docs = window.pretrialDocuments[pretrialId];
        if (docs.length > 0) {
            docs.forEach(doc => {
                const li = document.createElement('li');
                li.className = 'list-group-item';
                li.innerHTML = `<a href="${doc.url}" target="_blank">${doc.name}</a>`;
                documentsList.appendChild(li);
            });
            documentsSection.style.display = 'block';
        }
    }
}

function loadMembers(pretrialId) {
    const membersList = document.getElementById('pt-members-list');
    membersList.innerHTML = '';

    if (window.pretrialMembers && window.pretrialMembers[pretrialId]) {
        const members = window.pretrialMembers[pretrialId];
        if (members.length > 0) {
            members.forEach(member => {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.innerHTML = `<span>${member.name}</span><small class="text-muted">${member.role_or_position}</small>`;
                membersList.appendChild(li);
            });
        } else {
            membersList.innerHTML = '<li class="list-group-item text-muted">No members found.</li>';
        }
    }
}


    // 👇 Auto-select first item on page load
    const firstItem = document.querySelector('.pretrial-item');
    if (firstItem) {
        firstItem.click();
    }
});
</script>


<script>
let memberIndex = 1;

function addMemberRow() {
  const container = document.getElementById('member-container');
  const row = document.createElement('div');
  row.className = 'row g-2 mb-2 member-row';
  row.innerHTML = `
    <div class="col-md-4">
      <select name="members[${memberIndex}][member_type]" class="form-control required" required>
        <option value="">Select Type</option>
        <option value="lawyer">Lawyer</option>
        <option value="witness">Witness</option>
        <option value="dvc">DVC</option>
        <option value="other">Other</option>
      </select>
    </div>
    <div class="col-md-4">
      <input type="text" name="members[${memberIndex}][name]" class="form-control required" placeholder="Name" required>
    </div>
    <div class="col-md-3">
      <input type="text" name="members[${memberIndex}][role_or_position]" class="form-control" placeholder="Role/Position">
    </div>
    <div class="col-md-1">
      <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">✕</button>
    </div>
  `;
  container.appendChild(row);
  memberIndex++;
}

function removeRow(button) {
  button.closest('.member-row').remove();
}

function goToTab(tabId) {
  const currentTab = document.querySelector('.tab-pane.active');
  const requiredFields = currentTab.querySelectorAll('.required');
  let valid = true;

  requiredFields.forEach(field => {
    if (!field.value.trim()) {
      field.classList.add('is-invalid');
      valid = false;
    } else {
      field.classList.remove('is-invalid');
    }
  });

  if (!valid){

    

    return;

  } 

  const targetTab = new bootstrap.Tab(document.querySelector(`[data-bs-target="#${tabId}"]`));
  targetTab.show();
}


$(document).ready(function() {
  // Highlight first pretrial date on page load
 const pretrialList = document.getElementById('pretrial-list');
  const items = pretrialList.querySelectorAll('.pretrial-item');

  function highlightAndShowInfo(item) {
    // Remove highlight from all
    items.forEach(i => i.classList.remove('active', 'bg-primary', 'text-white'));

    // Highlight selected
    item.classList.add('active', 'bg-primary', 'text-white');

    // Show info
    document.getElementById('pretrial-details').style.display = 'block';
    document.getElementById('pt-date').textContent = item.dataset.date;
    document.getElementById('pt-time').textContent = item.dataset.time;
    document.getElementById('pt-location').textContent = item.dataset.location;
    document.getElementById('pt-comments').textContent = item.dataset.comments;


    
  }

  // Highlight first on load
  if(items.length > 0) {
    highlightAndShowInfo(items[0]);
  }

  // On click highlight selected
  items.forEach(item => {
    item.addEventListener('click', () => {
      highlightAndShowInfo(item);
    });
  });

  // Custom form validation with Swal error messages
  function validateForm() {
    const form = document.getElementById('addPreTrialForm');
    const requiredFields = form.querySelectorAll('.required');
    let valid = true;

    requiredFields.forEach(field => {
      if (!field.value.trim()) {
        field.classList.add('is-invalid');
        valid = false;
      } else {
        field.classList.remove('is-invalid');
      }
    });



    if (!valid) {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Please fill all the required fields!',
      });
    }

    return valid;
  }

  // Ajax form submission with validation and Swal messages
  $('#addPreTrialForm').submit(function(e) {
    e.preventDefault();

    if (!validateForm()) {
      return; // stop if validation fails
    }

    let formData = new FormData(this);

    $.ajax({
      url: "{{ route('pretrials.store') }}", // Adjust to your route
      method: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        Swal.fire({
          icon: 'success',
          title: 'Saved!',
          text: response.message,
          timer: 2000,
          showConfirmButton: false,
        });

        // Close modal
        $('#addPreTrialModal').modal('hide');

        // Clear form
        $('#addPreTrialForm')[0].reset();

        // Add new pretrial item to the list
        let newPretrial = response.pretrial;
        let listItem = $('<li>')
          .addClass('list-group-item pretrial-item active bg-info text-white')
          .attr('data-date', newPretrial.pretrial_date)
          .attr('data-time', newPretrial.pretrial_time)
          .attr('data-location', newPretrial.location)
          .attr('data-comments', newPretrial.comments)
          .text(newPretrial.pretrial_date + ' at ' + newPretrial.pretrial_time);

        // Remove highlight from others and add to new one
        $('#pretrial-list li').removeClass('active bg-info text-white');
        $('#pretrial-list').prepend(listItem);

        // Show details of new pretrial
        highlightPretrial(listItem);

      },
      error: function(xhr) {
        let errMsg = 'Something went wrong';
        if (xhr.responseJSON && xhr.responseJSON.message) {
          errMsg = xhr.responseJSON.message;
        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
          // Laravel validation errors array
          errMsg = Object.values(xhr.responseJSON.errors).flat().join('\n');
        }

        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: errMsg,
        });
      }
    });
  });
});

</script>


<script>
    const preTrialMembers = @json($preTrials->pluck('members', 'pretrial_id'));

    document.querySelectorAll('.pretrial-item').forEach(item => {
    item.addEventListener('click', function () {
        const pretrialId = this.getAttribute('data-id'); // make sure you add data-id="{{ $preTrial->pretrial_id }}" in each list item

        // Update members list
        const members = preTrialMembers[pretrialId] || [];
        const membersList = document.getElementById('pt-members-list');
        membersList.innerHTML = '';

        if (members.length > 0) {
            members.forEach(member => {
                
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                li.innerHTML = `<span>${member.name}</span><small class="text-muted">${member.role_or_position}</small>`;
                membersList.appendChild(li);
            });
        } else {
            membersList.innerHTML = '<li class="list-group-item text-muted">No members added.</li>';
        }

        // Other logic for highlighting, updating date/time/comments/docs remains as-is
    });
});

</script>


@endpush

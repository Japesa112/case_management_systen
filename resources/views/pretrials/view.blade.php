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

              <div class="panel-heading d-flex justify-content-between align-items-center">

                <h4 class="panel-title d-flex align-items-center">
                    PreTrials for 
                    
                    <a href="{{ route('cases.show', $case) }}" class="btn btn-primary btn-sm ms-2" title="View Case" style="padding: 2px 8px;">
                        <i> {{ $case->case_name ?? 'N/A' }}</i>
                    </a>
                </h4>
            

            <div class="panel-heading-btn">
                <a href="{{ url('/pretrials') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                <span class="text-white">All Pretrials</span>
            </a>
            </div>
           </div>

                
                 <div class="panel-body">
                    <div class="row">
                        <!-- Left: 30% -->
                        <div class="col-md-4">
                            <div class="card card-body bg-light">
                                <h5>Pre-Trial</h5>
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
                                    <!-- Action Buttons -->
                                  <div class="d-flex justify-content-end gap-2 mb-3">
                                      <!-- Update Details Button -->
                                      <button class="btn btn-warning btn-sm" id="editPreTrialBtn" onclick="openUpdatePreTrialModal(this)">
                                        ✏️ Update Pre-Trial
                                      </button>

                                      <!-- Add Member Button -->
                                      <button class="btn btn-info btn-sm" onclick="openAddMemberModal(this)">
                                        ➕ Add Member
                                      </button>

                                     <button class="btn btn-secondary btn-sm"
                                            onclick="openAddDocumentModal(this)"
                                            >
                                      📎 Add Document
                                       </button>
                                 </div>


                                    <!-- Pre-Trial Details -->
                                    <div id="pretrial-details" style="display: none;">
                                        <div class="row">
                                            <!-- Left: Pre-Trial Info -->
                                            <div class="col-md-6 border-end mb-3 mb-md-0">
                                                <h6>Selected Pre-Trial Info</h6>
                                                <span id="pt-id" style="display: none;"></span>
                                                <p><strong>Date:</strong> <span id="pt-date"></span></p>
                                                <p><strong>Time:</strong> <span id="pt-time"></span></p>
                                                <p><strong>Location:</strong> <span id="pt-location"></span></p>
                                                <p><strong>Comments:</strong> <span id="pt-comments"></span></p>
                                            </div>

                                            <!-- Right: Pre-Trial Members -->
                                            <div class="col-md-6">
                                                <h6>Pre-Trial Members</h6>
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
                   <select name="members[0][member_type]" class="form-control required member-type-select" data-index="0" required>
                      <option value="">Select Type</option>
                      <option value="lawyer">Lawyer</option>
                      <option value="witness">Witness</option>
                      <option value="dvc">DVC</option>
                      <option value="other">Other</option>
                    </select>
                  </div>
                   <div class="col-md-4 name-container" data-index="0">
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



<div class="modal fade" id="updatePreTrialModal" tabindex="-1" aria-labelledby="updatePreTrialModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="updatePreTrialForm">
        <div class="modal-header">
          <h5 class="modal-title" id="updatePreTrialModalLabel">Update Pre-Trial Info</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label class="form-label">Pre-Trial Date</label>
            <input type="date" name="pretrial_date" class="form-control" id="modal_pretrial_date" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Pre-Trial Time</label>
            <input type="time" name="pretrial_time" class="form-control" id="modal_pretrial_time" required>
          </div>
          <div class="col-md-12">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" id="modal_pretrial_location" required>
          </div>
          <div class="col-md-12">
            <label class="form-label">Comments</label>
            <textarea name="comments" class="form-control" rows="3" id="modal_pretrial_comments"></textarea>
          </div>
          <input type="hidden" name="pretrial_id" id="updatePretrialId">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update Pre-Trial</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="addMemberForm">
        <div class="modal-header">
          <h5 class="modal-title" id="addMemberModalLabel">Add Pre-Trial Member</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="member-container-modal">
            <div class="member-row row g-2 mb-2">
              <div class="col-md-4">
                <select name="members[0][member_type]" class="form-control member-type-select-1" data-index="0" required>
                  <option value="">Select Type</option>
                  <option value="lawyer">Lawyer</option>
                  <option value="witness">Witness</option>
                  <option value="dvc">DVC</option>
                  <option value="other">Other</option>
                </select>
              </div>
              <div class="col-md-4 name-container" data-index="0">
                <input type="text" name="members[0][name]" class="form-control" placeholder="Name" required>
              </div>
              <div class="col-md-3">
                <input type="text" name="members[0][role_or_position]" class="form-control" placeholder="Role/Position">
              </div>
             
            </div>
          </div>
          
          <input type="hidden" name="pretrial_id" id="memberPretrialId">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Member</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="addDocumentForm" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="addDocumentModalLabel">Add Document</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <label class="form-label">Upload Files</label>
          <input type="file" name="attachments" class="form-control"  required>
          <small class="text-muted">You can only select one file.</small>
          <input type="hidden" name="pretrial_id" id="documentPretrialId">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>




@endsection




@push('scripts')
<script>
    window.pretrialDocuments = @json($documentsByPretrial ?? []);
    window.pretrialMembers = @json($membersByPretrial ?? []);
</script>


<script>

    function loadDocuments(pretrialId) {
    documentsList.innerHTML = '';
    documentsSection.style.display = 'none';

    if (window.pretrialDocuments && window.pretrialDocuments[pretrialId]) {
        const docs = window.pretrialDocuments[pretrialId];
        if (docs.length > 0) {
            docs.forEach(doc => {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';

                li.innerHTML = `
                    <a href="${doc.url}" target="_blank">${doc.name}</a>
                    <button class="btn btn-sm btn-outline-danger" onclick="confirmDeleteAttachmentById(${doc.attachment_id}, ${pretrialId})" title="Delete Document">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                `;
                documentsList.appendChild(li);
            });
            documentsSection.style.display = 'block';
        }
    }
}





document.addEventListener('DOMContentLoaded', function () {
    const pretrialItems = document.querySelectorAll('.pretrial-item') || [];;
  
    const detailsSection = document.getElementById('pretrial-details');
    const documentsSection = document.getElementById('pretrial-documents');
    const documentsList = document.getElementById('documents-list');
    const membersList = document.getElementById('pt-members-list');
     if (!membersList) return; // another safeguard

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
            document.getElementById('pt-id').textContent = this.dataset.id;
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
                li.className = 'list-group-item d-flex justify-content-between align-items-center';

                li.innerHTML = `
                    <a href="${doc.url}" target="_blank">${doc.name}</a>
                    <button class="btn btn-sm btn-outline-danger" onclick="confirmDeleteAttachmentById(${doc.attachment_id}, ${pretrialId})" title="Delete Document">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                `;
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

                li.innerHTML = `
                    <span>
                        ${member.name}
                        <small class="text-muted d-block">${member.role_or_position}</small>
                    </span>
                    <button class="btn btn-sm btn-danger" onclick="confirmDeleteMemberByName('${member.name}', ${pretrialId})">✕</button>
                `;
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

function loadMembers(pretrialId) {
    const membersList = document.getElementById('pt-members-list');
    membersList.innerHTML = '';

    if (window.pretrialMembers && window.pretrialMembers[pretrialId]) {
        const members = window.pretrialMembers[pretrialId];
        if (members.length > 0) {
            members.forEach(member => {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';

                li.innerHTML = `
                    <span>
                        ${member.name}
                        <small class="text-muted d-block">${member.role_or_position}</small>
                    </span>
                    <button class="btn btn-sm btn-danger" onclick="confirmDeleteMemberByName('${member.name}', ${pretrialId})">✕</button>
                `;
                membersList.appendChild(li);
            });
        } else {
            membersList.innerHTML = '<li class="list-group-item text-muted">No members found.</li>';
        }
    }
}

function confirmDeleteMemberByName(name, pretrialId) {
    Swal.fire({
        title: 'Are you sure?',
        text: `Delete member "${name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/pretrials/members/delete-by-name`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ name: name, pretrial_id: pretrialId })
            })
            .then(async res => {
                const contentType = res.headers.get("content-type");
                if (!res.ok) {
                    const text = await res.text();
                    throw new Error(`Server error (${res.status}): ${text}`);
                }

                if (contentType && contentType.includes("application/json")) {
                    return res.json();
                } else {
                    const text = await res.text();
                    throw new Error(`Expected JSON, got: ${text}`);
                }
            })
            .then(response => {
                if (response.success) {
                    Swal.fire('Deleted!', response.message, 'success');
                    // Update local list and reload members
                    window.pretrialMembers[pretrialId] = window.pretrialMembers[pretrialId].filter(m => m.name !== name);
                    loadMembers(pretrialId);
                } else {
                    Swal.fire('Error', response.message || 'Failed to delete member.', 'error');
                }
            })
            .catch((err) => {
                console.error('Delete Error:', err);
                Swal.fire('Error', err.message || 'Something went wrong.', 'error');
            });
        }
    });
}

function confirmDeleteAttachmentById(attachmentId, pretrialId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'This document will be deleted permanently.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel'
    }).then(result => {
        if (result.isConfirmed) {
            fetch(`/pretrials/attachments/delete/${attachmentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error(`Failed with status ${res.status}`);
                return res.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                      title: 'Deleted!',
                      text: data.message,
                      icon: 'success',
                      timer: 2000, // time in milliseconds (e.g., 2000ms = 2 seconds)
                      showConfirmButton: false
                    });

                    // Remove from local array
                    window.pretrialDocuments[pretrialId] = window.pretrialDocuments[pretrialId].filter(doc => doc.attachment_id !== attachmentId);
                    location.reload();
                } else {
                    Swal.fire('Error', data.message || 'Deletion failed.', 'error');
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Error', 'Something went wrong.', 'error');
            });
        }
    });
}






</script>


<script>
let memberIndex = 1;

function addMemberRow() {
  const container = document.getElementById('member-container');
  const row = document.createElement('div');
  row.className = 'row g-2 mb-2 member-row';
  row.innerHTML = `
    <div class="col-md-4">
      <select name="members[${memberIndex}][member_type]" 
              class="form-control required member-type-select" 
              data-index="${memberIndex}" required>
        <option value="">Select Type</option>
        <option value="lawyer">Lawyer</option>
        <option value="witness">Witness</option>
        <option value="dvc">DVC</option>
        <option value="other">Other</option>
      </select>
    </div>
    <div class="col-md-4 name-container" data-index="${memberIndex}">
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

 if(!pretrialList) return;

  const items = pretrialList.querySelectorAll('.pretrial-item') || [];

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

 
});

</script>


<script>
    
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
            timerProgressBar: true,
            willClose: () => {
              location.reload();
            }
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
</script>




<script>
document.addEventListener('DOMContentLoaded', function () {
  // Attach change listener to all current and future selects
  document.getElementById('member-container').addEventListener('change', function (e) {
    if (e.target.classList.contains('member-type-select')) {
      const type = e.target.value;
      const index = e.target.getAttribute('data-index');
      const nameContainer = document.querySelector(`.name-container[data-index="${index}"]`);
      const roleField = nameContainer.nextElementSibling.querySelector('input');

      if (type === 'lawyer') {
        // Make role field readonly and preset
        roleField.value = 'Lawyer';
        roleField.readOnly = true;

        // Replace name input with select
        fetch(`/lawyer_payments/get-lawyers`)
          .then(res => res.json())
          .then(data => {
            const select = document.createElement('select');
            select.name = `members[${index}][name]`;
            select.className = 'form-control required';
            select.required = true;

            select.innerHTML = `<option value="">Select Lawyer</option>`;
            data.forEach(lawyer => {
              const id = lawyer.lawyer_id;
              const label = lawyer.display_name || lawyer.user?.full_name;
              select.innerHTML += `<option value="${label}">${label}</option>`;
            });

            nameContainer.innerHTML = '';
            nameContainer.appendChild(select);
          });
      } 

      else if (type === 'witness') {
          // Make role field readonly and preset
          roleField.value = 'Witness';
          roleField.readOnly = true;

          // Replace name input with select for witnesses
          fetch(`/witnesses/all-available-witnesses`)
            .then(res => res.json())
            .then(data => {
              const select = document.createElement('select');
              select.name = `members[${index}][name]`;
              select.className = 'form-control required';
              select.required = true;

              select.innerHTML = `<option value="">Select Witness</option>`;
              data.forEach(witness => {
                select.innerHTML += `<option value="${witness.display_name}">${witness.display_name}</option>`;
              });

              nameContainer.innerHTML = '';
              nameContainer.appendChild(select);
            });
        }

      else {
        // Reset to editable input and clear role
        nameContainer.innerHTML = `
          <input type="text" name="members[${index}][name]" class="form-control required" placeholder="Name" required>
        `;

        roleField.value = type.charAt(0).toUpperCase() + type.slice(1);
        roleField.readOnly = (type !== 'other');
      }
    }
  });
});



function openUpdatePreTrialModal(button) {

     let date = document.getElementById('pt-date').textContent;
     let time = document.getElementById('pt-time').textContent;
     let location = document.getElementById('pt-location').textContent;
     let comments = document.getElementById('pt-comments').textContent;
     let id = document.getElementById('pt-id').textContent;
     document.getElementById('modal_pretrial_date').value = date;
     document.getElementById('modal_pretrial_time').value = time;
     document.getElementById('modal_pretrial_location').value = location;
     document.getElementById('modal_pretrial_comments').value = comments;
     document.getElementById('updatePretrialId').value = id;


     
    new bootstrap.Modal(document.getElementById('updatePreTrialModal')).show();
}

function openAddMemberModal(button) {
    let id = document.getElementById('pt-id').textContent;

    
    document.getElementById('memberPretrialId').value = id;
    new bootstrap.Modal(document.getElementById('addMemberModal')).show();
}

function openAddDocumentModal(button) {
    let id = document.getElementById('pt-id').textContent;
    
    document.getElementById('documentPretrialId').value = id;

    document.getElementById('documentPretrialId').value = id;
    new bootstrap.Modal(document.getElementById('addDocumentModal')).show();
}

</script>





<script>
document.addEventListener('DOMContentLoaded', function () {
  const memberContainer = document.getElementById('member-container-modal');

  memberContainer.addEventListener('change', function (e) {
    if (e.target.classList.contains('member-type-select-1')) {
      const type = e.target.value;
      const index = e.target.dataset.index;
      const nameContainer = memberContainer.querySelector(`.name-container[data-index="${index}"]`);
      const roleField = memberContainer.querySelector(`[name="members[${index}][role_or_position]"]`);

      if (type === 'lawyer') {
        roleField.value = 'Lawyer';
        roleField.readOnly = true;

        fetch('/lawyer_payments/get-lawyers')
          .then(res => res.json())
          .then(data => {
            const select = document.createElement('select');
            select.name = `members[${index}][name]`;
            select.className = 'form-control required';
            select.required = true;

            select.innerHTML = `<option value="">Select Lawyer</option>`;
            data.forEach(lawyer => {
              const label = lawyer.display_name || (lawyer.user?.full_name ?? 'Unnamed Lawyer');
              select.innerHTML += `<option value="${label}">${label}</option>`;
            });

            nameContainer.innerHTML = '';
            nameContainer.appendChild(select);
          });

      } else if (type === 'witness') {
        roleField.value = 'Witness';
        roleField.readOnly = true;

        fetch('/witnesses/all-available-witnesses')
          .then(res => res.json())
          .then(data => {
            const select = document.createElement('select');
            select.name = `members[${index}][name]`;
            select.className = 'form-control required';
            select.required = true;

            select.innerHTML = `<option value="">Select Witness</option>`;
            data.forEach(witness => {
              select.innerHTML += `<option value="${witness.display_name}">${witness.display_name}</option>`;
            });

            nameContainer.innerHTML = '';
            nameContainer.appendChild(select);
          });

      }   else {
        // Reset to editable input and clear role
        nameContainer.innerHTML = `
          <input type="text" name="members[${index}][name]" class="form-control required" placeholder="Name" required>
        `;

        roleField.value = type.charAt(0).toUpperCase() + type.slice(1);
        roleField.readOnly = (type !== 'other');
      }
    }
  });
});
</script>


<script>
document.getElementById('addDocumentForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const form = e.target;
  const files = form.querySelector('input[type="file"]').files;
  const pretrialId = form.querySelector('#documentPretrialId').value;

  if (!files.length) {
    alert('Please select at least one file.');
    return;
  }

  // Upload each file individually
  Array.from(files).forEach(file => {
    const formData = new FormData();
    formData.append('attachments', file);
    formData.append('pretrial_id', pretrialId);

    fetch(`/pretrials/${pretrialId}/attachments`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {

       Swal.fire({
          icon: 'success',
          timer: 2000,
          title: 'Success!',
          text: data.message || 'File uploaded successfully.'
        });
       location.reload();

      } else {
       Swal.fire({
          icon: 'error',
          title: 'Upload Failed',
          text: data.message || 'Something went wrong.'
        });
      }
    })
    .catch(error => {
      Swal.fire({
        icon: 'error',
        title: 'Network Error',
        text: 'Could not upload file. Please try again later.'
      });
    });
  });

  // Optionally hide the modal and reset
  form.reset();
  const modal = bootstrap.Modal.getInstance(document.getElementById('addDocumentModal'));
  modal.hide();
});
</script>



<script>
document.getElementById('addMemberForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);
  const pretrialId = formData.get('pretrial_id');

  fetch('/pretrials/' + pretrialId + '/members', {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      Swal.fire({
        title: 'Success!',
        text: data.message || 'Member(s) added successfully.',
        icon: 'success',
        timer: 2000,
        showConfirmButton: false
      });

      // Close modal
      const modal = bootstrap.Modal.getInstance(document.getElementById('addMemberModal'));
      modal.hide();

      location.reload();

      // Reset form
      form.reset();

      // Optional: reload members list in UI
      if (typeof loadMembers === 'function') {
        loadMembers(pretrialId);
      }

    } else {
      Swal.fire({
        title: 'Error',
        text: data.message || 'Something went wrong.',
        icon: 'error'
      });
    }
  })
  .catch(error => {
    console.error(error);
    Swal.fire({
      title: 'Error',
      text: 'Failed to add member(s).',
      icon: 'error'
    });
  });
});
</script>


<script>
document.getElementById('updatePreTrialForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);
  for (const [key, value] of formData.entries()) {
  console.log(`${key}:`, value);
}
  const pretrialId = formData.get('pretrial_id');


  fetch(`/pretrials/${pretrialId}`, {
    method: 'POST', // HTML forms can't use PUT directly
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Accept': 'application/json',
      'X-HTTP-Method-Override': 'PUT' // Trick Laravel into accepting it as PUT
    },
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      Swal.fire({
        title: 'Success',
        text: data.message || 'Pre-Trial updated successfully!',
        icon: 'success',
        timer: 2000,
        showConfirmButton: false
      });

      const modal = bootstrap.Modal.getInstance(document.getElementById('updatePreTrialModal'));
      modal.hide();
      form.reset();

      location.reload();
      
    } else {
      Swal.fire('Error', data.message || 'Failed to update.', 'error');
    }
  })
  .catch(error => {
    console.error(error);
    Swal.fire('Error', 'Something went wrong.', 'error');
  });
});
</script>


@endpush

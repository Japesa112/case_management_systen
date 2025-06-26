@php

$isLawyer = Auth::user() && Auth::user()->role === 'Lawyer'; 

@endphp


@if ($isLawyer)

@php
    $lawyer = Auth::user()->lawyer;
@endphp

<div class="dropdown-menu dropdown-menu-end me-1">
    <a href="{{ route("lawyers.edit", $lawyer->lawyer_id) }}" class="dropdown-item">Edit Profile</a>
    
    <div class="dropdown-divider"></div>
<!-- 🔔 Notification Preferences Trigger -->
    <a href="javascript:void(0);" class="dropdown-item" onclick="openNotificationPreferenceModal()">
        <i class="fa fa-bell"></i> Notification Preferences
    </a>

    <div class="dropdown-divider"></div>

    <!-- Logout Form (Styled Correctly) -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="dropdown-item">Log Out</button>
    </form>
</div>

@else
<div class="dropdown-menu dropdown-menu-end me-1"> 
    <a href="/users/change-password" class="dropdown-item">
        <i class="fa fa-pencil-alt"></i>
        Change Password
    </a>

    <a href="/users/help" class="dropdown-item" id="help-trigger">
        <i class="fa fa-question-circle"></i>
        Helps
    </a>

    <!-- 🔔 Notification Preferences Trigger -->
    <a href="javascript:void(0);" class="dropdown-item" onclick="openNotificationPreferenceModal()">
        <i class="fa fa-bell"></i> Notification Preferences
    </a>

    <div class="dropdown-divider"></div>

    <!-- Logout Form -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="dropdown-item">Log Out</button>
    </form>
</div>



@endif



   
 <!-- Help Modal -->
 <div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="helpModalLabel"><i class="fa fa-info-circle me-2 text-primary"></i>Using the System</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Welcome to the Case Management System!</p>
          <ul>
              <li>🔒 <strong>Security Reminder:</strong> If you haven’t changed your password in the last 3 months, we recommend doing so to keep your account secure.</li>
              <li>🙅 <strong>Never share your password</strong> with anyone, including colleagues. Your login is personal and confidential.</li>
              <li>🚀 <strong>Good news!</strong> Our system is built to be user-friendly, intuitive, and efficient — helping you manage your work with ease.</li>
          </ul>
          <p>If you need further assistance, don’t hesitate to reach out to support.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Got it</button>
        </div>
      </div>
    </div>
  </div>
  

  
@push('scripts')


<script>
function openNotificationPreferenceModal(currentData = {}) {
    Swal.fire({
        title: '<i class="far fa-bell" style="margin-right: 10px;"></i> Notification Preferences',
        html: `
            <style>
                .notification-form-container {
                    text-align: left;
                    padding: 10px 15px;
                }
                .form-group {
                    margin-bottom: 20px;
                }
                .form-group:last-child {
                    margin-bottom: 5px;
                }
                .form-group label {
                    display: block;
                    font-weight: 600;
                    color: #333;
                    margin-bottom: 8px;
                    font-size: 15px;
                }
                .form-control {
                    width: 100%;
                    padding: 12px 15px;
                    font-size: 16px;
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    background-color: #f9f9f9;
                    box-sizing: border-box; /* Important for padding */
                    transition: border-color 0.2s ease, box-shadow 0.2s ease;
                }
                .form-control:focus {
                    outline: none;
                    border-color: #007bff;
                    background-color: #fff;
                    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
                }
                .form-description {
                    font-size: 14px;
                    color: #666;
                    margin-bottom: 25px;
                    margin-top: -5px;
                    text-align: center;
                }
                .swal2-popup {
                    border-radius: 12px !important;
                }
                .form-group.hidden {
                    display: none;
                }
            </style>

            <div class="notification-form-container">
                <p class="form-description">Choose when you'd like to receive your upcoming events.</p>

                <div class="form-group">
                    <label for="swal-frequency">Frequency</label>
                    <select id="swal-frequency" class="form-control">
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                    </select>
                </div>

                <div id="day-of-week-group" class="form-group hidden">
                    <label for="swal-dayOfWeek">Day of the Week</label>
                    <select id="swal-dayOfWeek" class="form-control">
                        <option value="" disabled selected>Select a day...</option>
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>
                        <option value="7">Sunday</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="swal-time">Time</label>
                    <input type="time" id="swal-time" class="form-control">
                </div>
            </div>
        `,
        confirmButtonText: 'Save Preferences',
        confirmButtonColor: '#007bff',
        showCancelButton: true,
        cancelButtonText: 'Cancel',
        cancelButtonColor: '#6c757d',
        focusConfirm: false,
        customClass: {
            popup: 'professional-swal-popup',
            actions: 'professional-swal-actions'
        },
        preConfirm: () => {
            const frequency = document.getElementById('swal-frequency').value;
            const day = document.getElementById('swal-dayOfWeek').value;
            const time = document.getElementById('swal-time').value;

            if (!time) {
                Swal.showValidationMessage('Please select a time for the notification.');
                return false;
            }
            if (frequency === 'weekly' && !day) {
                Swal.showValidationMessage('Please select a day for the weekly notification.');
                return false;
            }

           return {
              frequency,
              day: frequency === 'weekly' ? parseInt(day) : null, // make sure it's an integer
              time
            };
        },
        didOpen: () => {
            // Get elements
            const frequencySelect = document.getElementById('swal-frequency');
            const dayOfWeekGroup = document.getElementById('day-of-week-group');

            // Function to toggle day of week visibility
            const toggleDayOfWeek = () => {
                const isWeekly = frequencySelect.value === 'weekly';
                dayOfWeekGroup.classList.toggle('hidden', !isWeekly);
            };

            // Set initial values from currentData
            document.getElementById('swal-frequency').value = currentData.frequency || 'daily';
            document.getElementById('swal-dayOfWeek').value = currentData.day || '';
            document.getElementById('swal-time').value = currentData.time || '09:00';
            
            // Add event listener and trigger it once to set the initial state
            frequencySelect.addEventListener('change', toggleDayOfWeek);
            toggleDayOfWeek(); // Set the correct initial state
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // This part remains the same as your original logic
            console.log('Saving data:', result.value); // For demonstration
            
            // Example of a fetch call
            let url = "{{ route('users.notificationPreference.save') }}";
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(result.value),
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: 'Saved!',
                    text: 'Your preferences have been updated.',
                    icon: 'success',
                    confirmButtonColor: '#007bff'
                });
            })
            .catch(err => {
                Swal.fire('Error', 'Something went wrong while saving.', 'error');
            });
            

           // For demonstration purposes, we'll just show a success message
            Swal.fire({
                title: 'Saved!',
                text: 'Your preferences have been updated.',
                icon: 'success',
                confirmButtonColor: '#007bff'
            });
        }
    });
}
</script>

<script>
    $('#change-password-trigger').on('click', function () {
        $('#changePasswordModal').modal('show');
    });




    $('#change-password-form').on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        let data = form.serialize();

        $.ajax({
            url: "{{ route('lawyer.changePassword') }}",
            method: 'POST',
            data: data,
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message
                    }).then(() => {
                        $('#changePasswordModal').modal('hide');
                        form[0].reset(); // clear the form
                    });
                }
            },
            error: function(xhr) {
                let res = xhr.responseJSON;
                let msg = res.message || 'Something went wrong';

                if (res.errors) {
                    // Show first validation error
                    msg = Object.values(res.errors)[0][0];
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msg
                });
            }
        });
    });

    
    $('#help-trigger').on('click', function () {
        $('#helpModal').modal('show');
    });


</script>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		// Get all collapsible elements
		document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(link => {
			const targetSelector = link.getAttribute('data-bs-target');
			const target = document.querySelector(targetSelector);
			const icon = link.querySelector('.collapse-chevron');

			if (!target || !icon) return;

			target.addEventListener('shown.bs.collapse', () => {
				icon.classList.remove('fa-chevron-right');
				icon.classList.add('fa-chevron-down');
			});

			target.addEventListener('hidden.bs.collapse', () => {
				icon.classList.remove('fa-chevron-down');
				icon.classList.add('fa-chevron-right');
			});
		});
	});
</script>


@endpush

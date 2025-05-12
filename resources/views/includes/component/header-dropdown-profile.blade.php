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
    
   <br />
    <a href="/users/help" class="dropdown-item" id="help-trigger">
       <i class="fa fa-question-circle"></i>
        Helps
    </a>

    <div class="dropdown-divider"></div>

    <!-- Logout Form (Styled Correctly) -->
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

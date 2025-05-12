@extends('layouts.default') {{-- Adjust based on your layout structure --}}


@section('title', 'Change Password')
@section('content')
<!-- BEGIN panel -->
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Change Password</h4>
    </div>

    <div class="panel-body">
        <form id="change-password-form_">
            @csrf

            <div class="mb-3">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" class="form-control" id="current_password_" name="current_password" required>
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="new_password_" name="new_password" required>
            </div>

            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="new_password_confirmation_" name="new_password_confirmation" required>
            </div>

            <div class="text-end">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Change Password</button>
            </div>
        </form>
    </div>
</div>
<!-- END panel -->
@endsection


  
@push('scripts')

<script>

    $('#change-password-form_').on('submit', function(e) {
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
                        
                        form[0].reset(); // clear the form
                        window.location.href = "/users";
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

    


</script>


@endpush

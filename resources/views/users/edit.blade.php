@extends('layouts.default')
@section('title', 'Edit User')

@section('content')
<div class="container">
    @php
    $isLawyer = Auth::user() && Auth::user()->role === 'Lawyer'; 
    @endphp
    <div class="panel panel-inverse mt-4">
        <div class="panel-heading">
            <h4 class="panel-title">Edit User Details</h4>
        </div>
        <div class="panel-body">
            <form id="edit-user-form" action="{{ route('users.update', $user->user_id) }}" method="POST">
                @csrf
                @method('PUT')
            
                <div class="row">
                    <!-- First row of fields -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $user->full_name }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <!-- Second row of fields -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" required>
                        </div>
                    </div>
                </div>
            
                <div class="row mt-4">
                    <!-- Back and Save buttons -->
                    <div class="col-md-6 text-start">
                        <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
    
</div>
@endsection

@push('scripts')
<script>
    $('#edit-user-form').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const actionUrl = form.attr('action');
        const formData = form.serialize();

        $.ajax({
            url: actionUrl,
            method: 'POST',
            data: formData,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = response.redirect;
                });
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors;
                let errorMsg = 'Something went wrong!';
                
                if (errors) {
                    errorMsg = Object.values(errors).flat().join('\n');
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMsg
                });
            }
        });
    });
</script>
@endpush

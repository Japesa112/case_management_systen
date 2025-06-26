@extends('layouts.default')
@section('title', 'Edit Lawyer')

@section('content')
<div class="container">
    @php
    $isLawyer = Auth::user() && Auth::user()->role === 'Lawyer'; 
    @endphp
    <div class="panel panel-inverse mt-4">
        <div class="panel-heading">
            <h4 class="panel-title">Edit Lawyer Details</h4>
        </div>
        <div class="panel-body">
            <form id="edit-lawyer-form" action="{{ route('lawyers.update', $lawyer->lawyer_id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $lawyer->user->full_name }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ $lawyer->user->username }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $lawyer->user->email }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $lawyer->user->phone }}" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="license_number">License Number</label>
                            <input type="text" class="form-control" id="license_number" name="license_number" value="{{ $lawyer->license_number }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="area_of_expertise">Area of Expertise</label>
                            <input type="text" class="form-control" id="area_of_expertise" name="area_of_expertise" value="{{ $lawyer->area_of_expertise }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="firm_name">Firm Name</label>
                            <input type="text" class="form-control" id="firm_name" name="firm_name" value="{{ $lawyer->firm_name }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="years_experience">Years of Experience</label>
                            <input type="number" class="form-control" id="years_experience" name="years_experience" value="{{ $lawyer->years_experience }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="working_hours">Working Hours</label>
                            <input type="text" class="form-control" id="working_hours" name="working_hours" value="{{ $lawyer->working_hours }}" required>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success">Save Changes</button>

                    @if ($isLawyer)
                    <a href="/dashboard/lawyer" class="btn btn-danger">Cancel</a>

                    @else
                        <a href="{{ route('dashboard-v2-lawyer') }}" class="btn btn-danger">Cancel</a>


                    @endif
                </div>
            </form>
        </div>
    </div>
    
</div>
@endsection

@push('scripts')
<script>
    $('#edit-lawyer-form').on('submit', function(e) {
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

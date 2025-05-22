@extends('layouts.default')

@section('title', 'Add User')

@push('styles')

<style>
   .form-section{
    display: none;
}

.form-section.current{
    display: inline;
}
.parsley-errors-list{
    color:rgb(0, 255, 85);
}

</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-md-12">
            <h1 class="page-header">Add User</h1>
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title"> User Registration Form</h4>
                </div>
                <div class="panel-body">
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.store') }}" method="POST"  class="user-form">
                        @csrf
                    <div class="form-section current">
                        <h4 class="mt-4">User Information</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-2">
                                    <label for="full_name">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="full_name" id="full_name" class="form-control" required>
                                </div>
                                <!--
                                <div class="form-group mt-2">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" id="username" class="form-control" required>
                                </div>
                            -->
                                <div class="form-group mt-2">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>

                                
                            </div>
                            <div class="col-md-6">

                                <!--
                                <div class="form-group mt-2">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                            -->
                                <!-- Step 1: Select Role -->
                
                                <div class="form-group mt-2">
                                    <label for="role">Select Role</label>
                                    <select id="role" name="role" class="form-control" required>
                                        <option value="lawyer">Choose...</option>
                                        <option value="Admin">Admin</option>
                                        <option value="DVC">DVC</option>
                                       
                                    </select>
                                </div>

                                <div class="form-group mt-2">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control">
                                </div>
                
                            </div>
                        </div>
                    </div>

                  

                          <!-- Navigation Buttons -->
                <div class="form-navigation d-flex justify-content-between mt-3">
                    
                    <button type="button" class="btn btn-secondary" onclick="history.back()">Back</button>
                    <button type="submit" class="btn btn-success submit">Submit</button>
                </div>
                

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@prepend('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js" integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
@endprepend
@push('scripts')


<script>

   

</script>
    
@endpush
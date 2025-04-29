@extends('layouts.default')
@section('title', 'Users List')

@section('content')

<div class="panel panel-inverse">

  
   
    <div class="panel-heading mt-4">
        <h4 class="panel-title">Users List</h4>
        <div class="panel-heading-btn">
            <a href="{{ route('users.create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus"></i> Add new User
              </a>
        </div>

    </div>
    
    
    <div class="panel-body">
        <!-- Success Message Alerts -->
        @foreach (['createdUser' => 'success', 'updatedUser' => 'info', 'deletedUser' => 'danger'] as $key => $type)
            @if (session($key))
                <div class="alert alert-{{ $type }} fade show">
                    <strong>{{ ucfirst(str_replace('User', '', $key)) }} Successful!</strong>User  has been processed.
                </div>
            @endif
        @endforeach
        
        

        <!-- Users Table -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->user_id }}</td>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                <button class="btn btn-info btn-sm view-user" data-bs-target="#viewUserModal" data-bs-toggle="modal"  data-id="{{ $user->user_id }}" title="View Details">
                                    <i class="fa fa-eye"></i> View
                                </button>

                                <a href="{{ route('users.edit', $user->user_id) }}" class="btn btn-warning btn-sm">Edit</a>
                               
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- View User Modal -->
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewUserModalLabel">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="user-content">
                    <div class="text-center p-4">
                        <i class="fa fa-spinner fa-spin fa-2x"></i> Loading details...
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- SweetAlert Delete Confirmation -->
<script src="../assets/plugins/sweetalert/dist/sweetalert.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-button").forEach(button => {
            button.addEventListener("click", function () {
                var userId = this.getAttribute("data-id");
                var userName = this.getAttribute("data-name");

                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover " + userName + "'s record!",
                    icon: "warning",
                    buttons: ["Cancel", "Delete"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        document.getElementById('delete-form-' + userId).submit();
                    }
                });
            });
        });
    });
</script>
@endsection


@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("DOM fully loaded!"); // Debugging

        // Attach event listener to the document, targeting future elements
        document.body.addEventListener("click", function (event) {
            if (event.target.classList.contains("view-user")) {
                let userId = event.target.getAttribute("data-id");
                

                // Show loading state
                document.getElementById("user-content").innerHTML = `
                    <div class="text-center p-4">
                        <i class="fa fa-spinner fa-spin fa-2x"></i> Loading details...
                    </div>`;

                // Fetch user details via AJAX
                fetch(`/users/show/${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("user-content").innerHTML = `
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Full Name:</strong> ${data.full_name}</p>
                                    <p><strong>Username:</strong> ${data.username}</p>
                                    <p><strong>Email:</strong> ${data.email}</p>
                                    <p><strong>Phone:</strong> ${data.phone}</p>
                                </div>
                               
                            </div>`;
                    })
                    .catch(error => {
                        document.getElementById("user-content").innerHTML = `<p class="text-danger">Failed to load details.</p>`;
                        console.error("Error fetching user details:", error);
                    });
            }
        });
    });
</script>


    
@endpush
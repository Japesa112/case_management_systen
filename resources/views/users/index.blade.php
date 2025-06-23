@extends('layouts.default')
@section('title', 'Users List')

@push('styles')
<style>
    .panel-title {
        font-size: 18px;
        font-weight: bold;
    }
    .table thead th {
        background-color: #3c3440;
        color: white;
        text-align: center;
    }
    .table tbody td {
        vertical-align: middle;
    }
    .action-buttons a, .action-buttons form {
        display: inline-block;
        margin-right: 5px;
    }
   .dataTables_filter input {
        border-radius: 20px;
        padding: 8px 16px;
        border: 5px solid #d109d8;
        box-shadow: none;
        outline: none;
        transition: border-color 0.3s ease-in-out;
        width: 250px; /* 👈 You can increase this */
        max-width: 100%; /* Make sure it doesn’t overflow on smaller screens */
    }

    /* Optional: Highlight on focus */
    .dataTables_filter input:focus {
        border-color: #0db1fd;
    }


</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

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
        
        @if(session('success'))
            <div class="alert alert-success fade-out-alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger fade-out-alert">
                {{ session('error') }}
            </div>
        @endif
        

        <!-- Users Table -->
        <div class="table-responsive">
            <table id="data-table" class="table table-striped table-bordered">
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
                                <!-- View Button -->
                                <button class="btn btn-info btn-sm view-user" data-bs-target="#viewUserModal" data-bs-toggle="modal" data-id="{{ $user->user_id }}" title="View Details">
                                    <i class="fa fa-eye"></i> View
                                </button>

                                <!-- Edit Button -->
                                <a href="{{ route('users.edit', $user->user_id) }}" class="btn btn-warning btn-sm">Edit</a>

                               <!-- Delete Button with Swal -->
                                <form id="delete-form-{{ $user->user_id }}" action="{{ route('users.destroy', $user->user_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm swal-delete-btn" data-user-id="{{ $user->user_id }}" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

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



   <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#data-table').DataTable(
            {
            pageLength: 5,
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            
        }
        );
    });
</script> 


<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.swal-delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const userId = this.getAttribute('data-user-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + userId).submit();
                    }
                });
            });
        });
    });
</script>

<script>
    setTimeout(function () {
        document.querySelectorAll('.fade-out-alert').forEach(el => {
            el.style.transition = 'opacity 1s ease';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 1000); // Remove from DOM after fade-out
        });
    }, 3600); // 60,000ms = 1 minute
</script>

@endpush
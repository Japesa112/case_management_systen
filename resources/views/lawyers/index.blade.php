@extends('layouts.default')
@section('title', 'Lawyers List')

@push('styles')
<style>
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

@endpush
@section('content')

<div class="panel panel-inverse">

  
   
    <div class="panel-heading mt-4">
        <h4 class="panel-title">Lawyer List</h4>
        <div class="panel-heading-btn">
            <a href="{{ route('lawyers.create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus"></i> Add new Lawyer
              </a>
        </div>

    </div>
    
    
    <div class="panel-body">
        <!-- Success Message Alerts -->
        @foreach (['createdLawyer' => 'success', 'updatedLawyer' => 'info', 'deletedLawyer' => 'danger'] as $key => $type)
            @if (session($key))
                <div class="alert alert-{{ $type }} fade show">
                    <strong>{{ ucfirst(str_replace('Lawyer', '', $key)) }} Successful!</strong> Lawyer has been processed.
                </div>
            @endif
        @endforeach
        
        

        <!-- Lawyers Table -->
        <div class="table-responsive">
            <table id="data-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>License ID</th>
                        <th>Full Name</th>
                        <th>Firm Name</th>
                        <th>Years of Experience</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lawyers as $lawyer)
                        <tr>
                            <td>{{ $lawyer->license_number }}</td>
                            <td>{{ $lawyer->user->full_name }}</td>
                            <td>{{ $lawyer->firm_name }}</td>
                            <td>{{ $lawyer->years_experience }}</td>
                            <td>
                                <!-- View Button -->
                                <button class="btn btn-info btn-sm view-lawyer" data-bs-target="#viewLawyerModal" data-bs-toggle="modal" data-id="{{ $lawyer->lawyer_id }}" title="View Details">
                                    <i class="fa fa-eye"></i> View
                                </button>

                                <!-- Edit Button -->
                                <a href="{{ route('lawyers.edit', $lawyer->lawyer_id) }}" class="btn btn-warning btn-sm">Edit</a>

                                <!-- Delete Button -->
                                <form id="delete-lawyer-form-{{ $lawyer->lawyer_id }}" action="{{ route('lawyers.destroy', $lawyer->lawyer_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm swal-lawyer-delete-btn" data-lawyer-id="{{ $lawyer->lawyer_id }}" title="Delete">
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
            {{ $lawyers->links() }}
        </div>
    </div>
</div>

<!-- View Lawyer Modal -->
<div class="modal fade" id="viewLawyerModal" tabindex="-1" aria-labelledby="viewLawyerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewLawyerModalLabel">Lawyer Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="lawyer-content">
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
                var lawyerId = this.getAttribute("data-id");
                var lawyerName = this.getAttribute("data-name");

                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover " + lawyerName + "'s record!",
                    icon: "warning",
                    buttons: ["Cancel", "Delete"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        document.getElementById('delete-form-' + lawyerId).submit();
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
            if (event.target.classList.contains("view-lawyer")) {
                let lawyerId = event.target.getAttribute("data-id");
                

                // Show loading state
                document.getElementById("lawyer-content").innerHTML = `
                    <div class="text-center p-4">
                        <i class="fa fa-spinner fa-spin fa-2x"></i> Loading details...
                    </div>`;

                // Fetch lawyer details via AJAX
                fetch(`/lawyers/show/${lawyerId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("lawyer-content").innerHTML = `
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Full Name:</strong> ${data.full_name}</p>
                                    <p><strong>Username:</strong> ${data.username}</p>
                                    <p><strong>Email:</strong> ${data.email}</p>
                                    <p><strong>Phone:</strong> ${data.phone}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>License Number:</strong> ${data.license_number}</p>
                                    <p><strong>Area of Expertise:</strong> ${data.area_of_expertise}</p>
                                    <p><strong>Firm Name:</strong> ${data.firm_name}</p>
                                    <p><strong>Years of Experience:</strong> ${data.years_experience}</p>
                                    <p><strong>Working Hours:</strong> ${data.working_hours}</p>
                                </div>
                            </div>`;
                    })
                    .catch(error => {
                        document.getElementById("lawyer-content").innerHTML = `<p class="text-danger">Failed to load details.</p>`;
                        console.error("Error fetching lawyer details:", error);
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
        document.querySelectorAll('.swal-lawyer-delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const lawyerId = this.getAttribute('data-lawyer-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This lawyer will be deleted permanently.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-lawyer-form-' + lawyerId).submit();
                    }
                });
            });
        });
    });
</script>

    
@endpush
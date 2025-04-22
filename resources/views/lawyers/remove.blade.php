@extends('layouts.default')
@section('title', 'delete')



@section('content')
<div class="container">
     <!---Viewing a lawyer-->
     @if (session('viewLawyer'))
     @php
         $lawyer = session('viewLawyer');
     @endphp
     <script>
         document.addEventListener("DOMContentLoaded", function() {
             var myModal = new bootstrap.Modal(document.getElementById('modal-dialog3'));
             myModal.show();
         });
     </script>
     
     
 <!-- #modal-dialog -->
 <div class="modal fade" id="modal-dialog3">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title">Viewer</h4>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
             </div>
             <div class="modal-body">
                 <p><strong>Name:</strong> {{ session('viewLawyer')->name }}</p>
                 <p><strong>Email:</strong> {{ session('viewLawyer')->email }}</p>
                 <p><strong>Phone:</strong> {{ session('viewLawyer')->phone }}</p>
             </div>
             <div class="modal-footer">
                 <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
             </div>
         </div>
     </div>
 </div>
 
 
 
 
 
         
     @endif
 




    <!---checking if a lawyer has been created-->
    @if (session('createdLawyer'))
    @php
        $lawyer = session('createdLawyer');
    @endphp
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var myModal = new bootstrap.Modal(document.getElementById('modal-dialog2'));
            myModal.show();
        });
    </script>
    
    
<!-- #modal-dialog -->
<div class="modal fade" id="modal-dialog2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Lawyer Added Successfully</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> {{ session('createdLawyer')->name }}</p>
                <p><strong>Email:</strong> {{ session('createdLawyer')->email }}</p>
                <p><strong>Phone:</strong> {{ session('createdLawyer')->phone }}</p>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>





        
    @endif


    <!--Checking if lawyer has been Updated-->
    @if(session('updatedLawyer'))
    @php
        $lawyer = session('updatedLawyer');
    @endphp

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var myModal = new bootstrap.Modal(document.getElementById('modal-dialog1'));
            myModal.show();
        });
    </script>

    
    
<!-- #modal-dialog -->
<div class="modal fade" id="modal-dialog1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Lawyer Updated Successfully</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> {{ session('updatedLawyer')->name }}</p>
                <p><strong>Email:</strong> {{ session('updatedLawyer')->email }}</p>
                <p><strong>Phone:</strong> {{ session('updatedLawyer')->phone }}</p>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>



@endif

    <!-- Container for Heading, Success Message, and Button -->
<div class="d-flex justify-content-between align-items-center mt-5 mb-2">
    <!-- Heading (Centered) -->
    <h2 class="mb-0 mx-auto">Lawyers List</h2>

    <!-- Success Message (Optional, Only Shows If Session Has Success) 
    @if(session('success'))
        <div class="alert alert-success flex-grow-1 mx-3 text-center">
            {{ session('success') }}
        </div>
    @endif
-->
    <!-- Add Lawyer Button (Right) -->
    <a href="{{ route('lawyers.create') }}" class="btn btn-primary">Add New Lawyer</a>
</div>


    <!-- Table to Display Lawyers -->
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Specialization</th>
                <th>Experience (Years)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lawyers as $lawyer)
                <tr>
                    <td>{{ $lawyer->id }}</td>
                    <td>{{ $lawyer->name }}</td>
                    <td>{{ $lawyer->email }}</td>
                    <td>{{ $lawyer->specialization }}</td>
                    <td>{{ $lawyer->experience_years }}</td>
                    <td>
                      <form id="delete-form-{{ $lawyer->id }}" action="{{ route('lawyers.destroy', $lawyer->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm delete-button" 
                                        data-id="{{ $lawyer->id }}" 
                                        data-name="{{ $lawyer->name }}">Delete</button>
                            </form>
                            
                            <!-- SweetAlert Script -->
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
                                                buttons: {
                                                    cancel: {
                                                        text: "Cancel",
                                                        visible: true,
                                                        className: "btn btn-default",
                                                        closeModal: true,
                                                    },
                                                    confirm: {
                                                        text: "Delete",
                                                        value: true,
                                                        visible: true,
                                                        className: "btn btn-danger",
                                                        closeModal: false
                                                    }
                                                }
                                            }).then((willDelete) => {
                                                if (willDelete) {
                                                    document.getElementById('delete-form-' + lawyerId).submit();
                                                }
                                            });
                                        });
                                    });
                                });
                            </script>
                            
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    


    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $lawyers->links() }}
    </div>
</div>
@endsection

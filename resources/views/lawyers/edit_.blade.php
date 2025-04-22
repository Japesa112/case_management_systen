@extends('layouts.default')
@section('title', 'edit')



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
                                               
                            <a href="{{ route('lawyers.edit', ['lawyer' => $lawyer->id]) }}" class="btn btn-warning btn-sm">Edit</a>

                            
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

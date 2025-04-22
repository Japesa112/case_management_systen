@extends('layouts.default')

@section('title', 'Negotiations List')


@push('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endpush
@section('content')
<div class="container-fluid">
    @php
    use Illuminate\Support\Str;
    @endphp
    
    <div class="mt-4">
    <h1 class="page-header">Negotiations</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">Negotiation List</h4>
           
            <div class="panel-heading-btn">
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addNegotiationModal">
                    <i class="fa fa-plus"></i> Add New Negotiation
                </button>
                
            </div>
            <div class="modal fade" id="addNegotiationModal" tabindex="-1" aria-labelledby="addNegotiationModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color: rgb(1, 9, 12)" id="addNegotiationModalLabel">Create New Negotiation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!--action="// //route('negotiations.checkCase') }}"-->
                            <form id="checkCaseForm">
                                @csrf
                                <div class="form-group">
                                    <label for="case_number" style="color: rgb(1, 9, 12)">Case Number <span class="text-danger">*</span></label>
                                    <input type="text" name="case_number" id="case_number" class="form-control" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Create Negotiation</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

       

        <div class="panel-body">
            @if(request()->has('message'))
            <div id="success-alert" class="alert alert-success flex-grow-1 mx-3 text-center">
                    {{ request()->get('message') }}
            </div>
            <script>
                setTimeout(function () {
                    document.getElementById('success-alert').style.display = 'none';
                }, 5000); // 5000ms = 5 seconds
            </script>
            @endif

            @if(session('success'))
                    <div id="success-alert" class="alert alert-success flex-grow-1 mx-3 text-center">
                                {{ session('success') }}
                    </div>
                
                    <script>
                        setTimeout(function () {
                            document.getElementById('success-alert').style.display = 'none';
                        }, 5000); // 5000ms = 5 seconds
                    </script>
            @endif
            @if(session('error'))
                    <div id="error-alert" class="alert alert-danger flex-grow-1 mx-3 text-center">
                                {{ session('error') }}
                    </div>
                
                    <script>
                        setTimeout(function () {
                            document.getElementById('error-alert').style.display = 'none';
                        }, 5000); // 5000ms = 5 seconds
                    </script>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <tr>
                                <th>Number</th>
                                <th>Case Name</th>
                                <th>Method</th>
                                <th>Subject</th>
                                <th>Outcome</th>
                                <th>Initiation Date &amp; Time</th>
                                <th>Action</th>
                            </tr>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($negotiations as $negotiation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $negotiation->caseRecord->case_name ?? 'N/A' }}</td>
                            <td>{{ $negotiation->negotiation_method }}</td>
                            <td>{{ $negotiation->subject }}</td>
                            <td>{{ $negotiation->outcome }}</td>
                            <td>{{ $negotiation->initiation_datetime }}</td>
                            <td>
                                <a href="{{ route('negotiations.show', $negotiation) }}" class="btn btn-info btn-sm" title="View Details">
                                    <i class="fa fa-eye"></i> View
                                </a>

                                <a href="{{ route('negotiations.edit', $negotiation) }}" class="btn btn-warning btn-sm" title="View Details">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                

                                
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
             <!-- Pagination -->
             <div class="d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {{ $negotiations->links('vendor.pagination.bootstrap-4') }}
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
</div>





@endsection

@prepend('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
    
@endprepend

@push('scripts')
<script>
    $(document).ready(function () {
        $(document).on('submit', '#checkCaseForm', function (e) {
            e.preventDefault(); // Prevent default form submission
    
            let caseNumber = $('#case_number').val();
    
            $.ajax({
                url: "{{ route('negotiations.checkCase') }}", 
                type: "GET", 
                data: { case_number: caseNumber }, 
                success: function (response) {
                    if (response.exists) {
                        if (response.negotiation) {
                            // Redirect to negotiations.edit if negotiation exists
                            window.location.href = response.negotiation.edit_url;
                        } else {
                            // Redirect to negotiations.create if no negotiation exists
                            window.location.href = "{{ route('negotiations.create', ':case_id') }}"
                                .replace(':case_id', response.case_id) + 
                                "?case_name=" + encodeURIComponent(response.case_name);
                        }
                    } else {
                        // Show error message inside modal
                        $('.modal-body').html('<p class="text-danger text-center">Case number does not exist.</p>');
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: xhr.responseJSON ? xhr.responseJSON.message : "Something went wrong!"
                    });
                }
            });
        });
    });
    </script>
    
  
    
@endpush
@extends('layouts.default')
@section('title', 'Case')


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

@endpush

@section('content')
<div class="container">
    @php
    use Illuminate\Support\Str;
    $isLawyer = Auth::user() && Auth::user()->role === 'Lawyer'; 
    
    @endphp
    

    <div class="panel panel-inverse mt-5">
        <div class="panel-heading">
            <h4 class="panel-title">My Cases</h4>
           
            
            @if ($isLawyer)
             
            @else
                <div class="panel-heading-btn">
                <a href="{{ route('cases.create') }}" class="btn btn-success btn-sm">
                    <i class="fa fa-plus"></i> Add New Case
                </a>
            </div>
            @endif
        </div>

        <div class="panel-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
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
        

            <div class="table-responsive">
                <table id="data-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Number</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            
                            <th>View</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cases as $key => $case)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $case->case_number}}</td>
                            <td>{{ $case->case_name }}</td>
                            <td>{{ Str::limit($case->case_description, 50) }}</td>
                            <td>
                                

                                @php
                                switch ($case->status) {
                                    case 'open':
                                        $bgColor = 'background-color: #007bff; color: white;'; // Blue (Bootstrap primary)
                                        break;
                                    case 'closed':
                                        $bgColor = 'background-color: #dc3545; color: white;'; // Red (Bootstrap danger)
                                        break;
                                    case 'pending':
                                        $bgColor = 'background-color: #ffc107; color: black;'; // Yellow (Bootstrap warning)
                                        break;
                                    default:
                                        $bgColor = 'background-color: #6c757d; color: white;'; // Grey (Bootstrap secondary)
                                    }
                                @endphp
                            
                            <span style="{{ $bgColor }} padding: 5px 10px; border-radius: 5px;">
                                {{ ucfirst($case->case_status) }}
                            </span>
                            
                            </td>
                           
                            <td>
                                <a href="{{ route('cases.show', $case) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                           
                             </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Pagination --}}
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {{ $cases->links('vendor.pagination.bootstrap-4') }}
                    </ul>
                </nav>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#data-table').DataTable(
            {
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        }
        );
         // Custom search box
        $('#customSearchBox').on('keyup', function () {
            table.search(this.value).draw();
        });
    });
</script>

@endpush




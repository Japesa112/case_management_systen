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
        width: 250px; 
        max-width: 100%;
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
    use Illuminate\Support\Facades\Auth;
    use App\Models\PanelEvaluation;
    @endphp

    @php
    use Illuminate\Support\Str;
    $isLawyer = Auth::user() && Auth::user()->role === 'Lawyer'; 
    
    @endphp
    

    <div class="panel panel-inverse mt-5">
         <div class="panel-heading d-flex justify-content-between align-items-center">
            <a href="{{ route('cases.index') }}" class="btn btn-dark btn-sm d-flex align-items-center gap-2">
                <i class="fa fa-arrow-left text-white fw-bold"></i> <span class="text-white">Back to Cases</span>
            </a>
            
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
                           
                            <th>Case Name</th>
                            <th>Comments</th>
                            <th>Registered At</th>
                            <th>Date</th>
                            
                            <th>View</th>
                            <th>Next Step</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($preTrials as $key => $preTrial)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            
                            

                             <td class="text-center">
                                 @if($preTrial->case)
                                    <a href="{{ route('cases.show', $preTrial->case->case_id) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center" title="View Case">
                                        <i class="fa fa-eye me-1"></i> {{  $preTrial->case->case_name  }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                                 </td>

                            <td>{{ Str::limit($preTrial->comments, 50) }}</td>
                            <td>{{ $preTrial->pretrial_date}} at {{ $preTrial->pretrial_time}}</td>
                            <td>{{ $preTrial->created_at }}</td>
                           
                           
                            <td>
                                <a href="{{ route('pretrials.index', $preTrial->case->case_id) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        <td>
                                @if($preTrial->case)
                                 <a href="{{ route('preparations.create', $preTrial->case->case_id) }}" 
                                       class="btn btn-sm btn-outline-success d-inline-flex align-items-center" 
                                       title="Trial Preparation">
                                        <i class="fa fa-gavel me-1"></i> Trial Preparation
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                                

                             </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
           

        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Add margin to DataTables search bar */
    .dataTables_filter {
        margin-bottom: 20px; /* Adjust this value as needed */
    }
</style>
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
@section('scripts')
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
@endsection

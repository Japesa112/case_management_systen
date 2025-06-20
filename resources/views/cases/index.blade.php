@extends('layouts.default')
@section('title', 'Case List')


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
    use Illuminate\Support\Facades\Auth;
    use App\Models\PanelEvaluation;
    @endphp

    @php
    use Illuminate\Support\Str;
    $isLawyer = Auth::user() && Auth::user()->role === 'Lawyer'; 
    
    @endphp
    

    <div class="panel panel-inverse mt-5">
        <div class="panel-heading">
            <h4 class="panel-title">Case List</h4>
            
           
            
            @if ($isLawyer)
                <div class="panel-heading-btn">
                <a href="{{ route('lawyers.my_index') }}" class="btn btn-success btn-sm">
                    <i class="fa fa-all"></i> My Assigned Cases
                </a>
            </div>
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
        

               <div class="row mb-3">
                <!-- Left: Case Status Filter -->
                <div class="col-md-6">
                    <label for="statusFilter" class="form-label fw-bold">Filter by Case Status:</label>
                    <select id="statusFilter" class="form-control" data-current="{{ request('status_filter') }}">
                        <option value="">All Cases</option>
                        <!-- Options will be populated via JS -->
                    </select>
                </div>

                <!-- Right: Final Outcome Filter -->
                <div class="col-md-6">
                    <label for="outcomeFilter" class="form-label fw-bold">Filter by Final Outcome:</label>
                    <select id="outcomeFilter" class="form-control" data-current="{{ request('outcome_filter') }}">
                        <option value="">All Outcomes</option>
                        <!-- Options will be populated via JS -->
                    </select>
                </div>
            </div>



   
         
           <div class="table-responsive">
    @if ($cases->isNotEmpty())
        <table id="data-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Number</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Registered At</th>
                    <th>Status</th>
                    <th>View</th>
                    <th>Handled By</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cases as $key => $case)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $case->case_number}}</td>
                        <td>{{ $case->case_name }}</td>
                        <td>{{ Str::limit($case->case_description, 50) }}</td>
                        <td>{{ $case->created_at }}</td>
                        <td>
                            {{ $case->case_status }}
                        </td>
                        <td>
                            <a href="{{ route('cases.show', $case) }}" class="btn btn-info btn-sm">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                        <td class="text-nowrap">
                            <span class="text-muted">
                                @if(count($case->caseLawyers) == 0)
                                    Not Assigned
                                @elseif(count($case->caseLawyers)==1)
                                    {{ $case->caseLawyers->first()->lawyer->user->full_name . ":-" . $case->caseLawyers->first()->lawyer->license_number }}
                                @else
                                    More than 1 Lawyer Assigned
                                @endif
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-warning text-center">
            No cases found for the selected filters.
        </div>
    @endif
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

@push("scripts")
<script>
$(document).ready(function () {
    
    $('.handled-by').each(function () {
        let $cell = $(this);
        let caseId = $cell.data('case-id');
        console.log(caseId);

        $.ajax({
            url: `/cases/${caseId}/lawyers`,
            method: 'GET',
            success: function (data) {
                if (data.length > 0) {
                    let badges = data.map(name => `<span class="badge bg-secondary d-block mb-1">${name}</span>`);
                    $cell.html(badges.join(''));
                } else {
                    $cell.html('<span class="text-muted">Not assigned</span>');
                }
            },
            error: function () {
                $cell.html('<span class="text-danger">Error loading</span>');
            }
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('/cases/case-statuses/db')
        .then(response => response.json())
        .then(statuses => {
            const select = document.getElementById('statusFilter');
            const current = select.dataset.current;

            statuses.forEach(status => {
                const option = document.createElement('option');
                option.value = status.toLowerCase();
                option.textContent = status;
                if (status.toLowerCase() === current) {
                    option.selected = true;
                }
                select.appendChild(option);
            });

            const tomSelect = new TomSelect('#statusFilter', {
                placeholder: 'Select case status...',
                allowEmptyOption: true,
                plugins: ['dropdown_input'],
            });

            // Handle selection change
            select.addEventListener('change', function () {
                const url = new URL(window.location.href);
                if (this.value) {
                    url.searchParams.set('status_filter', this.value);
                } else {
                    url.searchParams.delete('status_filter');
                }
                window.location.href = url.toString();
            });
        });


        fetch('{{ route("case_closures.final_outcomes") }}')
        .then(res => res.json())
        .then(outcomes => {
            const outcomeFilter = document.getElementById('outcomeFilter');
            const currentOutcome = outcomeFilter.dataset.current;

            outcomes.forEach(outcome => {
                const option = document.createElement('option');
                option.value = outcome;
                option.textContent = outcome;
                if (outcome === currentOutcome) option.selected = true;
                outcomeFilter.appendChild(option);
            });
        });

        document.getElementById('outcomeFilter').addEventListener('change', applyFilters);
        function applyFilters() {
       
        const outcome = document.getElementById('outcomeFilter').value;

        let url = new URL(window.location.href);
       
        url.searchParams.set('outcome_filter', outcome);

        window.location.href = url.toString();
    }
});
</script>


@endpush

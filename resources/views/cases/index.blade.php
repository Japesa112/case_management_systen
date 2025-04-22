@extends('layouts.default')
@section('title', 'Case')

@section('content')
<div class="container">
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
        

            <div class="table-responsive">

                <!--
              
                <form method="POST" action="{{ route('cases.sendEmail', $cases[0]->case_id) }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Send Email</button>
                </form>

            -->
                
                
                <table id="data-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Number</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Hearing Date</th>
                            <th>View</th>
                            <th>Next Step</th>
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
                            <td>{{ $case->first_hearing_date}}</td>
                            <td>
                                <a href="{{ route('cases.show', $case) }}" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('negotiations.create', $case->case_id) }}" class="btn btn-primary btn-sm" title="Negotiation">
                                    <i class="fa fa-handshake"></i>
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

@section('scripts')
<script>
    $(document).ready(function() {
        $('#data-table').DataTable();
    });
</script>
@endsection

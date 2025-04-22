@extends('layouts.default')

@section('title', 'Create Evaluation')

@section('content')
<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-md-12">
            <h1 class="page-header">Create Evaluation</h1>
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Evaluation Form</h4>
                </div>
                <div class="panel-body">
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('evaluations.store') }}" method="POST">
                        @csrf
                        
                        <!-- Hidden Fields -->
                        <input type="hidden" name="case_id" value="{{ $case_id }}">
                        <input type="hidden" name="lawyer_id" value="{{ Auth::id() }}"> <!-- Lawyer ID -->
                        
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Case Name (Not Editable) -->
                                <div class="form-group mt-2">
                                    <label for="case_name">Case Name</label>
                                    <input type="text" id="case_name" class="form-control" value="{{ $case_name }}" disabled>
                                </div>

                                <!-- Reviewer's Full Name (Displayed Only) -->
                                <div class="form-group mt-2">
                                    <label for="reviewer">Lawyer</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->full_name }}" disabled>
                                </div>

                                <!-- Evaluation Date -->
                                <div class="form-group mt-2">
                                    <label for="evaluation_date">Evaluation Date <span class="text-danger">*</span></label>
                                    <input type="date" name="evaluation_date" id="evaluation_date" class="form-control" required>
                                </div>

                                <div class="form-group mt-2">
                                    <label>Have you worked on this case before? <span class="text-danger">*</span></label>
                                    <div>
                                        <label class="me-3">
                                            <input type="radio" name="worked_before" value="Yes" required> Yes
                                        </label>
                                        <label>
                                            <input type="radio" name="worked_before" value="No" required> No
                                        </label>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="col-md-6">

                                <!-- Outcome -->
                                <div class="form-group mt-2">
                                    <label>Do you want to take the case? <span class="text-danger">*</span></label>
                                    <select name="outcome" id="outcome" class="form-control" required>
                                        <option value="">Select</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                                <!-- Comments -->

                                <!-- Quote -->
                                <div class="form-group mt-2">
                                    <label for="quote">Quote</label>
                                    <input type="text" name="quote" id="quote" class="form-control">
                                </div>

                                <!-- Pager -->
                                <div class="form-group mt-2">
                                    <label for="pager">Pager</label>
                                    <input type="text" name="pager" id="pager" class="form-control">
                                </div>


                                <div class="form-group mt-2">
                                    <label for="comments">Comments</label>
                                    <textarea name="comments" id="comments" class="form-control" rows="3"></textarea>
                                </div>

                                

                                
                                </div>
                            </div>
                        </div>
                                    <!-- Submit and Back Buttons -->
                <!-- Submit and Back Buttons -->
                    <div class="form-group d-flex justify-content-between mt-4 ml-5">
                        <div class="ml-4" style="margin-left: 5%; margin-bottom: 5%;">
                            <a href="{{ route("cases.index") }}" class="btn btn-secondary">Back to Cases</a> <!-- Back Button (Left) -->
                        </div>
                        <div style="margin-right: 5%; margin-bottom: 5%;">
                            <button type="submit" class="btn btn-primary">Submit Evaluation</button> <!-- Submit Button (Right) -->
                        </div>
                        
            </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

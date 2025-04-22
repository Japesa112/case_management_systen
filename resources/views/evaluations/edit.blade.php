@extends('layouts.default')

@section('title', 'Edit Evaluation')

@section('content')
<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-md-12">
            <h1 class="page-header">Edit Evaluation</h1>
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

                    <form action="{{ route('evaluations.update', $evaluation->evaluation_id) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Laravel requires this for updates -->

                        <!-- Hidden Fields -->
                        <input type="hidden" name="case_id" value="{{ $evaluation->case_id }}">
                        <input type="hidden" name="lawyer_id" value="{{ $evaluation->lawyer_id }}">

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Case Name (Not Editable) -->
                                <div class="form-group mt-2">
                                    <label for="case_name">Case Name</label>
                                    <input type="text" id="case_name" class="form-control" value="{{ $evaluation->case->case_name ?? 'N/A' }}" disabled>
                                </div>

                                <!-- Lawyer Name (Not Editable) -->
                                <div class="form-group mt-2">
                                    <label for="reviewer">Lawyer</label>
                                    <input type="text" class="form-control" value="{{ $evaluation->lawyer->user->full_name ?? 'N/A' }}" disabled>
                                </div>

                                <!-- Evaluation Date -->
                                <div class="form-group mt-2">
                                    <label for="evaluation_date">Evaluation Date <span class="text-danger">*</span></label>
                                    <input type="date" name="evaluation_date" id="evaluation_date" class="form-control" value="{{ $evaluation->evaluation_date }}" required>
                                </div>

                                <!-- Worked Before -->
                                <div class="form-group mt-2">
                                    <label>Have you worked on this case before? <span class="text-danger">*</span></label>
                                    <div>
                                        <label class="me-3">
                                            <input type="radio" name="worked_before" value="Yes" {{ $evaluation->worked_before == 'Yes' ? 'checked' : '' }} required> Yes
                                        </label>
                                        <label>
                                            <input type="radio" name="worked_before" value="No" {{ $evaluation->worked_before == 'No' ? 'checked' : '' }} required> No
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
                                        <option value="Yes" {{ $evaluation->outcome == 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ $evaluation->outcome == 'No' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>

                                <!-- Quote -->
                                <div class="form-group mt-2">
                                    <label for="quote">Quote</label>
                                    <input type="text" name="quote" id="quote" class="form-control" value="{{ $evaluation->quote }}">
                                </div>

                                <!-- Pager -->
                                <div class="form-group mt-2">
                                    <label for="pager">Pager</label>
                                    <input type="text" name="pager" id="pager" class="form-control" value="{{ $evaluation->pager }}">
                                </div>

                                <!-- Comments -->
                                <div class="form-group mt-2">
                                    <label for="comments">Comments</label>
                                    <textarea name="comments" id="comments" class="form-control" rows="3">{{ $evaluation->comments }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center mt-4">
                            <a href="{{ route('evaluations.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
                     
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update Evaluation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.default')

@push('styles')
<style>
    .info-label {
        font-weight: bold;
        color: #333;
    }
    .info-value {
        padding: 10px;
        background: #f8f9fa;
        border-radius: 5px;
    }
    .info-container {
        margin-bottom: 15px;
    }
    .uploaded-files-list .list-group-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
@endpush

@section('title', 'View Negotiation')

@section('content')
<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-md-12">
            <h1 class="page-header">Negotiation Details</h1>
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Details</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-container">
                                <label class="info-label">Case ID</label>
                                <div class="info-value">{{ $negotiation->case_id }}</div>
                            </div>
                            <div class="info-container">
                                <label class="info-label">Method</label>
                                <div class="info-value">{{ $negotiation->negotiation_method }}</div>
                            </div>
                            <div class="info-container">
                                <label class="info-label">Subject</label>
                                <div class="info-value">{{ $negotiation->subject }}</div>
                            </div>
                            <div class="info-container">
                                <label class="info-label">Initiation Date & Time</label>
                                <div class="info-value">{{ $negotiation->initiation_datetime }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-container">
                                <label class="info-label">Follow Up Actions</label>
                                <div class="info-value">{{ $negotiation->follow_up_actions }}</div>
                            </div>
                            <div class="info-container">
                                <label class="info-label">Complainant Response</label>
                                <div class="info-value">{{ $negotiation->complainant_response }}</div>
                            </div>
                            <div class="info-container">
                                <label class="info-label">Notes</label>
                                <div class="info-value">{{ $negotiation->notes }}</div>
                            </div>
                            <div class="info-container">
                                <label class="info-label">Outcome</label>
                                <div class="info-value">{{ $negotiation->outcome }}</div>
                            </div>
                            
                        </div>
                    </div>
                    <h5>Uploaded Documents</h5>
                    <div id="uploadedFilesList" class="mt-2">
                        @if(count($attachments) > 0)
                            @foreach ($attachments as $attachment)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank">
                                        <i class="fa fa-file"></i> {{ $attachment->file_name }}
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No document uploaded.</p>
                        @endif
                    </div>


                     <!-- Button container -->
                    <div class="d-flex justify-content-between mt-4">
                        <!-- Back Button (Left) -->
                        <button onclick="window.history.back();" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back
                        </button>

                        <!-- Update Button (Right) -->
                        <a href="{{ route('negotiations.edit', $negotiation) }}" class="btn btn-warning">
                            <i class="fa fa-edit"></i> Update Negotiation
                        </a>
                    </div>
                </div>

                
                
            </div>
        </div>
        
    </div>

    
    
</div>
@endsection

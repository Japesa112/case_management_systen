@extends('layouts.default')

@section('title', 'Help Page')

@section('content')
<div class="panel panel-inverse">
    <div class="panel-heading">
        <h4 class="panel-title">Help Page</h4>
    </div>

    <div class="panel-body">
        <div class="mb-4">
            <h5><i class="fa fa-info-circle me-2 text-primary"></i>Using the System</h5>
            <p>Welcome to the Case Management System!</p>
            <ul>
                <li>🔒 <strong>Security Reminder:</strong> If you haven’t changed your password in the last 3 months, we recommend doing so to keep your account secure.</li>
                <li>🙅 <strong>Never share your password</strong> with anyone, including colleagues. Your login is personal and confidential.</li>
                <li>🚀 <strong>Good news!</strong> Our system is built to be user-friendly, intuitive, and efficient — helping you manage your work with ease.</li>
            </ul>
            <p>If you need further assistance, don’t hesitate to reach out to support.</p>
        </div>

        <div class="mt-4">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                ← Back
            </a>
        </div>
        

        {{-- You can include the form here as well if needed --}}
        {{-- @include('partials.change-password-form') --}}
    </div>
</div>
@endsection

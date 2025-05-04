@extends('layouts.app') {{-- Or your specific layout like staff.layout --}}

@section('title', 'Lab Request Details')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Lab Request Details</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Patient: {{ $labRequest->patient->name ?? 'N/A' }}</h5>
            <p class="card-text"><strong>Requested By:</strong> {{ $labRequest->requestedBy->name ?? 'N/A' }}</p>
            <p class="card-text"><strong>Test Type:</strong> {{ $labRequest->test_type }}</p>
            <p class="card-text"><strong>Description:</strong> {{ $labRequest->description }}</p>
            <p class="card-text"><strong>Status:</strong> 
                @if($labRequest->status === 'pending')
                    <span class="badge bg-warning text-dark">Pending</span>
                @elseif($labRequest->status === 'accepted')
                    <span class="badge bg-success">Accepted</span>
                @else
                    <span class="badge bg-secondary">Unknown</span>
                @endif
            </p>
            <p class="card-text"><strong>Requested At:</strong> {{ $labRequest->created_at->format('M d, Y h:i A') }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('staff.lab-requests.index') }}" class="btn btn-secondary">Back to All Requests</a>
    </div>
</div>
@endsection

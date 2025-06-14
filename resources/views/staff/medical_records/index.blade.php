@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Medical History</h1>

    {{-- Show error messages --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Search Form --}}
    <!-- <form action="{{ route('staff.medical-history.search') }}" method="GET">
        <div class="input-group mb-4">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" name="patient_id" class="form-control" placeholder="Enter Student ID" required>
            <button class="btn btn-success" type="submit">Search</button>
        </div>
    </form> -->

    {{-- Show patient history if available --}}
    @isset($patient)
        <div class="card mb-4">
            <div class="card-header">
                Patient Info - {{ $patient->name }} (ID: {{ $patient->id }})
            </div>
            <div class="card-body">
                <h5>Medical Records</h5>
                @forelse ($patient->medicalRecords as $record)
                    <div class="border p-3 mb-3">
                        <strong>Diagnosis:</strong> {{ $record->diagnosis }} <br>
                        <strong>Treatment:</strong> {{ $record->treatment }} <br>
                        <strong>Prescription:</strong> {{ $record->prescription ?? 'N/A' }} <br>
                        <strong>Visit Date:</strong> {{ \Carbon\Carbon::parse($record->visit_date)->format('Y-m-d') }} <br>
                        <strong>Follow-Up Date:</strong> {{ $record->follow_up_date ? \Carbon\Carbon::parse($record->follow_up_date)->format('Y-m-d') : 'N/A' }} <br>
                        <strong>Created By:</strong> {{ $record->creator->name ?? 'N/A' }} <br>
                        @if($record->results_id && $record->Result)
                            <strong>Lab Results:</strong>
                            <a href="{{ route('staff.lab-results.show', $record->results_id) }}" class="btn btn-outline-info btn-sm">
                                View Lab Result
                            </a><br>
                        @endif
                        <strong>Date Recorded:</strong> {{ $record->created_at->format('Y-m-d') }}
                    </div>
                @empty
                    <p>No medical records found.</p>
                @endforelse

                <h5 class="mt-4">Medical Documents</h5>
                @forelse ($patient->medicalDocuments as $doc)
                    <div class="border p-3 mb-3">
                        <strong>{{ $doc->title }}</strong><br>
                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm mt-2">
                            View Document
                        </a>
                    </div>
                @empty
                    <p>No documents uploaded.</p>
                @endforelse
            </div>
        </div>
    @endisset
</div>
@endsection

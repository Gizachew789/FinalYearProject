{{-- resources/views/medical_records/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Medical Record Details</h2>

    <div class="card mb-4">
        <div class="card-header">Patient Information</div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $medicalRecord->patient->user->name ?? 'N/A' }}</p>
            <p><strong>Patient ID:</strong> {{ $medicalRecord->patient->id }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Medical Details</div>
        <div class="card-body">
            <p><strong>Diagnosis:</strong> {{ $medicalRecord->diagnosis ?? 'N/A' }}</p>
            <p><strong>Symptoms:</strong> {{ $medicalRecord->symptoms ?? 'N/A' }}</p>
            <p><strong>Treatment:</strong> {{ $medicalRecord->treatment ?? 'N/A' }}</p>
            <p><strong>Notes:</strong> {{ $medicalRecord->notes ?? 'N/A' }}</p>
            <p><strong>Follow-Up Date:</strong> {{ $medicalRecord->follow_up_date ? $medicalRecord->follow_up_date->format('Y-m-d') : 'N/A' }}</p>
            <p><strong>Created At:</strong> {{ $medicalRecord->created_at->format('Y-m-d H:i') }}</p>
        </div>
    </div>

    @if($medicalRecord->appointment)
    <div class="card mb-4">
        <div class="card-header">Appointment Information</div>
        <div class="card-body">
            <p><strong>Appointment ID:</strong> {{ $medicalRecord->appointment->id }}</p>
            <p><strong>Status:</strong> {{ ucfirst($medicalRecord->appointment->status) }}</p>
            <p><strong>Date:</strong> {{ $medicalRecord->appointment->date ?? 'N/A' }}</p>
        </div>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">Attached Documents</div>
        <div class="card-body">
            @if($medicalRecord->documents->isEmpty())
                <p>No documents uploaded.</p>
            @else
                <ul>
                    @foreach($medicalRecord->documents as $document)
                        <li>
                            <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank">
                                {{ $document->original_name ?? 'View Document' }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection

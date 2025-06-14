@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Appointments Accepted</h1>

    @foreach ($appointments as $appointment)
        <div class="card mb-3">
            <div class="card-header">
                Appointment ID: {{ $appointment->id }}
            </div>
            <div class="card-body">
                <p><strong>Patient Name:</strong> {{ $appointment->patient->name ?? 'N/A' }}</p>
                <p><strong>Appointment Date:</strong> {{ $appointment->appointment_date }}</p>
                <p><strong>Appointment Time:</strong> {{ $appointment->appointment_time }}</p>
                <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
            </div>
        </div>
    @endforeach

    <a href="{{ route('staff.dashboard') }}" class="btn btn-primary">Go Back to Dashboard</a>
</div>
@endsection

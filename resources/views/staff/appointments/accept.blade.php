@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Appointment Accepted</h1>

    <div class="card">
        <div class="card-header">
            Appointment Information
        </div>
        <div class="card-body">
            <p><strong>Patient Name:</strong> {{ $appointment->patient->name }}</p>
            <p><strong>Appointment Date:</strong> {{ $appointment->appointment_date }}</p>
            <p><strong>Appointment Time:</strong> {{ $appointment->appointment_time }}</p>
            <p><strong>Status:</strong> Accepted</p>

            <a href="{{ route('staff.dashboard') }}" class="btn btn-primary">Go Back to Dashboard</a>
        </div>
    </div>
</div>
@endsection

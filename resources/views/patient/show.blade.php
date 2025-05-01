@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Patient Details</h2>

    <div class="card mb-3 p-3">
        <p><strong>Name:</strong> {{ $patient->name }}</p>
        <p><strong>Gender:</strong> {{ ucfirst($patient->gender) }}</p>
        <p><strong>Age:</strong> {{ $patient->age }}</p>
        <p><strong>Email:</strong> {{ $patient->email }}</p>
        @if($patient->phone_number)
            <p><strong>Phone:</strong> {{ $patient->phone_number }}</p>
        @endif
        @if($patient->department)
            <p><strong>Department:</strong> {{ $patient->department }}</p>
        @endif
        @if($patient->year_of_study)
            <p><strong>Year of Study:</strong> {{ $patient->year_of_study }}</p>
        @endif
        @if($patient->blood_group)
            <p><strong>Blood Group:</strong> {{ $patient->blood_group }}</p>
        @endif
    </div>

    <h3 class="mb-3">Appointments</h3>
    @forelse($patient->appointments as $appointment)
        <div class="card mb-2 p-3">
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d') }}</p>
            <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
        </div>
    @empty
        <p>No appointments found.</p>
    @endforelse
</div>
@endsection

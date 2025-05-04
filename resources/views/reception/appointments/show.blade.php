@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-semibold mb-4">Appointment Details</h2>

    <p><strong>Patient:</strong> {{ $appointment->patient->name ?? 'Unknown' }}</p>
    <p><strong>Date:</strong> {{ $appointment->appointment_date }}</p>
    <p><strong>Time:</strong> {{ $appointment->appointment_time }}</p>
    <p><strong>Reason:</strong> {{ $appointment->reason ?? 'Not specified' }}</p>
    <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>

    <a href="{{ route('reception.appointments.index') }}" class="text-blue-500 mt-4 inline-block">Back to Appointments</a>
</div>
@endsection

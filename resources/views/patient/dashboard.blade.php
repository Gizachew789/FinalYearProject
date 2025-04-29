@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Welcome to Your Dashboard</h2>

    {{-- Book Appointment Section --}}
    <div class="card mb-4">
        <div class="card-header">
            <strong>Book an Appointment</strong>
        </div>
        <div class="card-body">
            <p>Book your next appointment here.</p>
            <a href="{{ route('patient.appointments.create') }}" class="btn btn-primary">Book Appointment</a>

        </div>
    </div>

    {{-- Appointment Status Section --}}
    <div class="card mb-4">
        <div class="card-header">
            <strong>Your Appointments</strong>
        </div>
        <div class="card-body">
            <h5>Upcoming Appointments</h5>
            @if($upcomingAppointments->isEmpty())
                <p class="text-muted">No upcoming appointments.</p>
            @else
                <ul class="list-group mb-3">
                    @foreach($upcomingAppointments as $appointment)
                        <li class="list-group-item">
                            {{ $appointment->date }} at {{ $appointment->time }}
                        </li>
                    @endforeach
                </ul>
            @endif

            <h5>Pending Appointments</h5>
            @if($pendingAppointments->isEmpty())
                <p class="text-muted">No pending appointments.</p>
            @else
                <ul class="list-group mb-3">
                    @foreach($pendingAppointments as $appointment)
                        <li class="list-group-item">
                            {{ $appointment->date }} - Awaiting confirmation
                        </li>
                    @endforeach
                </ul>
            @endif

            <h5>Completed Appointments</h5>
            @if($completedAppointments->isEmpty())
                <p class="text-muted">No completed appointments yet.</p>
            @else
                <ul class="list-group">
                    @foreach($completedAppointments as $appointment)
                        <li class="list-group-item">
                            {{ $appointment->date }} with Dr. {{ $appointment->doctor->name }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{-- Medical History Section --}}
    <div class="card">
        <div class="card-header">
            <strong>Your Medical History</strong>
        </div>
        <div class="card-body">
            @if($medicalRecords->isEmpty())
                <p class="text-muted">No medical records found.</p>
            @else
                <ul class="list-group">
                    @foreach($medicalRecords as $record)
                        <li class="list-group-item">
                            <strong>Date:</strong> {{ $record->created_at->format('Y-m-d') }} <br>
                            <strong>Details:</strong> {{ $record->notes }}
                        </li>
                    @endforeach
                </ul>
            @endif
            <p class="mt-3 text-muted">
                Note: You can view your medical history, but only authorized staff can update or modify these records.
            </p>
        </div>
    </div>
</div>
@endsection

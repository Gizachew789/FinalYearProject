@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>All Appointments</h2>

    <a href="{{ route('reception.appointments.create') }}" class="btn btn-primary mb-3">Book New Appointment</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Date</th>
                <th>Time</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->name ?? 'Unknown' }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>{{ $appointment->appointment_time }}</td>
                    <td>{{ $appointment->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

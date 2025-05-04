@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-semibold mb-4">Edit Appointment</h2>

    <form method="POST" action="{{ route('reception.appointments.update', $appointment->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label>Patient</label>
            <select name="patient_id" class="w-full border p-2 rounded" required>
                @foreach ($patients as $patient)
                    <option value="{{ $patient->id }}" {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>
                        {{ $patient->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label>Date</label>
            <input type="date" name="appointment_date" class="w-full border p-2 rounded" value="{{ $appointment->appointment_date }}" required>
        </div>

        <div class="mb-4">
            <label>Time</label>
            <input type="time" name="appointment_time" class="w-full border p-2 rounded" value="{{ $appointment->appointment_time }}" required>
        </div>

        <div class="mb-4">
            <label>Reason</label>
            <textarea name="reason" class="w-full border p-2 rounded">{{ $appointment->reason }}</textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Appointment</button>
    </form>
</div>
@endsection

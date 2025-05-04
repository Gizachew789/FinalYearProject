@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Delete Appointment</h2>

    <p>Are you sure you want to delete the appointment for <strong>{{ $appointment->patient->name ?? 'Unknown' }}</strong> on <strong>{{ $appointment->appointment_date }}</strong> at <strong>{{ $appointment->appointment_time }}</strong>?</p>

    <form method="POST" action="{{ route('reception.appointments.destroy', $appointment->id) }}">
        @csrf
        @method('DELETE')

        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Yes, Delete</button>
        <a href="{{ route('reception.appointments.index') }}" class="ml-4 text-gray-600">Cancel</a>
    </form>
</div>
@endsection

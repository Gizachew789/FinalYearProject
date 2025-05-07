{{-- resources/views/reception/appointments/create.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Book Appointment</h2>

    <form method="POST" action="{{ route('reception.appointments.store') }}">
        @csrf

        {{-- Select Patient --}}
        <div class="mb-4">
            <label for="patient_id" class="block text-sm font-medium text-gray-700">Patient</label>
            <select name="patient_id" id="patient_id" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Patient</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->email }})</option>
                @endforeach
            </select>
        </div>

        {{-- Appointment Date --}}
        <div class="mb-4">
            <label for="appointment_date" class="block text-sm font-medium text-gray-700">Appointment Date</label>
            <input type="date" name="appointment_date" id="appointment_date" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        {{-- Appointment Time --}}
        <div class="mb-4">
            <label for="appointment_time" class="block text-sm font-medium text-gray-700">Appointment Time</label>
            <input type="time" name="appointment_time" id="appointment_time" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        {{-- Reason --}}
        <div class="mb-4">
            <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
            <textarea name="reason" id="reason" rows="3"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
        </div>

        {{-- Reception ID --}}
        <div class="mb-4">
            <label for="reception_id" class="block text-sm font-medium text-gray-700">Reception</label>
            <select name="reception_id" id="reception_id" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Receptionist </option>
                @foreach($receptions as $reception)
                    <option value="{{ $reception->id }}">{{ $reception->name }} ({{ $reception->email }})</option>
                @endforeach
            </select>
        </div>

        {{-- Created By --}}
        <div class="mb-4">
            <label for="created_by" class="block text-sm font-medium text-gray-700">Created By</label>
            <input type="text" name="created_by" id="created_by" value="{{ auth()->user()->name }}" readonly
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        {{-- Submit Button --}}
        <div class="text-center">
            <button type="submit"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                Book Appointment
            </button>
        </div>
    </form>
</div>
@endsection

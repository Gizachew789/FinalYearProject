@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">All Appointments</h1>

    <table class="table-auto w-full border">
        <thead>
            <tr>
                <th class="border px-4 py-2">Patient Name</th>
                <th class="border px-4 py-2">Date</th>
                <th class="border px-4 py-2">Time</th>
                <th class="border px-4 py-2">Reason</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
            <tr>
                <td class="border px-4 py-2">{{ $appointment->patient->name ?? 'Unknown' }}</td>
                <td class="border px-4 py-2">{{ $appointment->appointment_date }}</td>
                <td class="border px-4 py-2">{{ $appointment->appointment_time }}</td>
                <td class="border px-4 py-2">{{ $appointment->reason ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

{{-- resources/views/staff/medical_records/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Medical Records</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($medicalRecords->isEmpty())
        <div class="alert alert-info">No medical records found.</div>
    @else
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Patient Name</th>
                    <th>Diagnosis</th>
                    <th>Appointment</th>
                    <th>Follow-Up Date</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicalRecords as $index => $record)
                    <tr>
                        <td>{{ $medicalRecords->firstItem() + $index }}</td>
                        <td>{{ $record->patient->user->name ?? 'N/A' }}</td>
                        <td>{{ $record->diagnosis ?? 'N/A' }}</td>
                        <td>
                            @if($record->appointment)
                                {{ $record->appointment->appointment_date }} {{ $record->appointment->appointment_time }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $record->follow_up_date ? $record->follow_up_date->format('Y-m-d') : 'N/A' }}</td>
                        <td>{{ $record->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('medical_records.show', $record->id) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $medicalRecords->links() }}
        </div>
    @endif
</div>
@endsection

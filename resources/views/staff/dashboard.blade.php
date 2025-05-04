@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome, {{ $user->name }}</h1>
    <p class="mb-4">This is your shared staff dashboard.</p>

    {{-- Appointments Section --}}
    <div class="card mb-4">
        <div class="card-header">Booked Appointments</div>
        <div class="card-body">
            @if($appointments->isEmpty())
                <p>No appointments available.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                            <td>{{ $patient->name }}</td>
                                <td>{{ $appointment->appointment_date }}</td>
                                <td>{{ $appointment->appointment_time }}</td>
                                <td>{{ ucfirst($appointment->status) }}</td>
                                <td>
                                    @if($appointment->status == 'pending')
                                        <form method="POST" action="{{ route('staff.appointments.accept', $appointment->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Accept</button>
                                        </form>
                                    @else
                                        <a href="{{ route('staff.patients.show', $appointment->patient_id) }}" class="btn btn-sm btn-primary">View Details</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Medical History Section --}}
    @if(isset($patient))
    <div class="card mb-4">
        <div class="card-header">Medical History - {{ $patient->name }}</div>
        <div class="card-body">
            @if($patient->medicalRecords->isEmpty())
                <p>No medical records found.</p>
            @else
                <ul>
                    @foreach($patient->medicalRecords as $record)
                        <li>{{ $record->created_at->format('Y-m-d') }}: {{ $record->summary }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{-- Upload New Medical Record --}}
    <div class="card mb-4">
        <div class="card-header">Upload New Medical Document</div>
        <div class="card-body">
            <form action="{{ route('staff.medical_records.store', $patient->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="document">Medical Document (PDF or Image)</label>
                    <input type="file" name="document" class="form-control" required>
                </div>
                <div class="form-group mt-2">
                    <label for="notes">Notes</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Enter summary or notes..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Upload</button>
            </form>
        </div>
    </div>
    @endif

    {{-- Lab Test & Prescription Section --}}
    @if(isset($patient))
    <div class="card mb-4">
        <div class="card-header">Actions</div>
        <div class="card-body">
            <a href="{{ route('staff.lab-requests.create', $patient->id) }}" class="btn btn-outline-secondary me-2">Request Lab Test</a>
            <a href="{{ route('staff.prescriptions.create', $patient->id) }}" class="btn btn-outline-secondary">Write Prescription</a>
        </div>
    </div>

    {{-- Lab Test Results --}}
   <div class="card mb-4">
    <div class="card-header">Lab Test Results</div>
    <div class="card-body">
        @if($patient->results->isEmpty())
            <p>No lab test results found.</p>
        @else
            <ul>
                @foreach($patient->results as $result)
                    <li>
                        {{ $result->test_name }} - {{ $result->result }} 
                        ({{ $result->created_at->format('Y-m-d') }})
                        @if($result->technician)
                            - Added by: {{ $result->technician->name }}
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
   </div>


    @endif
</div>
@endsection

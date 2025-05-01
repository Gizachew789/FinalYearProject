{{-- resources/views/staff/medical_records/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Create New Medical Record</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('staff.medical_records.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="patient_id">Patient</label>
            <select name="patient_id" class="form-control" required>
                <option value="">-- Select Patient --</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                        {{ $patient->name }} (ID: {{ $patient->id }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="appointment_id">Appointment (optional)</label>
            <select name="appointment_id" class="form-control">
                <option value="">-- None --</option>
                @foreach($appointments as $appointment)
                    <option value="{{ $appointment->id }}" {{ old('appointment_id') == $appointment->id ? 'selected' : '' }}>
                        {{ $appointment->date }} - {{ $appointment->patient->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="diagnosis">Diagnosis</label>
            <input type="text" name="diagnosis" class="form-control" value="{{ old('diagnosis') }}">
        </div>

        <div class="form-group mb-3">
            <label for="symptoms">Symptoms</label>
            <textarea name="symptoms" class="form-control" rows="2">{{ old('symptoms') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="treatment">Treatment</label>
            <textarea name="treatment" class="form-control" rows="2">{{ old('treatment') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="notes">Additional Notes</label>
            <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="follow_up_date">Follow-up Date</label>
            <input type="date" name="follow_up_date" class="form-control" value="{{ old('follow_up_date') }}">
        </div>

        <button type="submit" class="btn btn-primary">Create Medical Record</button>
    </form>
</div>
@endsection

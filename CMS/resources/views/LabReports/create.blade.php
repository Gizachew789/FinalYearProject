@extends('layouts.app')

@section('content')
    <h1>Create Lab Report</h1>

    <form action="{{ route('lab_reports.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="patient_id">Patient</label>
            <select name="patient_id" id="patient_id" class="form-control" required>
                <option value="">Select a patient</option>
                @foreach ($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="report_date">Report Date</label>
            <input type="date" name="report_date" id="report_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="result">Result</label>
            <select name="result" id="result" class="form-control" required>
                <option value="Positive">Positive</option>
                <option value="Negative">Negative</option>
            </select>
        </div>

        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Save Report</button>
    </form>
@endsection

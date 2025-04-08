@extends('layouts.app')

@section('content')
    <h1>Edit Lab Report</h1>

    <form action="{{ route('lab_reports.update', $labReport) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="patient_id">Patient</label>
            <select name="patient_id" id="patient_id" class="form-control" required>
                @foreach ($patients as $patient)
                    <option value="{{ $patient->id }}" {{ $patient->id == $labReport->patient_id ? 'selected' : '' }}>
                        {{ $patient->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="report_date">Report Date</label>
            <input type="date" name="report_date" id="report_date" class="form-control" value="{{ $labReport->report_date->format('Y-m-d') }}" required>
        </div>

        <div class="form-group">
            <label for="result">Result</label>
            <select name="result" id="result" class="form-control" required>
                <option value="Positive" {{ $labReport->result == 'Positive' ? 'selected' : '' }}>Positive</option>
                <option value="Negative" {{ $labReport->result == 'Negative' ? 'selected' : '' }}>Negative</option>
            </select>
        </div>

        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" class="form-control">{{ $labReport->notes }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Report</button>
    </form>

    <a href="{{ route('lab_reports.index') }}" class="btn btn-secondary mt-3">Back to Lab Reports</a>
@endsection

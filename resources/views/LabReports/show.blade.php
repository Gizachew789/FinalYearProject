@extends('layouts.app')

@section('content')
    <h1>Lab Report Details</h1>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Patient: {{ $labReport->patient->name }}</h5>
            <p><strong>Report Date:</strong> {{ $labReport->report_date->format('Y-m-d') }}</p>
            <p><strong>Result:</strong> {{ $labReport->result }}</p>
            <p><strong>Notes:</strong> {{ $labReport->notes ?? 'N/A' }}</p>
        </div>
    </div>

    <a href="{{ route('lab_reports.index') }}" class="btn btn-secondary mt-3">Back to Lab Reports</a>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Result Details</h1>

        <div class="card">
            <div class="card-header">
                Result #{{ $result->patient_id }}
            </div>
            <div class="card-body">
                <p><strong>Patient Name:</strong> {{ $result->patient ? $result->patient->name : 'No patient assigned' }}</p>
                <p><strong>Tested By:</strong> {{ $result->tested_by_user ? $result->tested_by_user->name : 'No user assigned' }}</p>
                <p><strong>Disease Type:</strong> {{ $result->disease_type }}</p>
                <p><strong>Sample Type:</strong> {{ $result->sample_type }}</p>
                <p><strong>Result:</strong> {{ $result->result }}</p>
                <p><strong>Recommendation:</strong> {{ $result->recommendation ?? 'N/A' }}</p>
                <p><strong>Result Date:</strong> {{ $result->result_date }}</p>
            </div>
        </div>

        <a href="{{ route('lab.results.index') }}" class="btn btn-primary mt-3">Back to Results</a>
    </div>
@endsection

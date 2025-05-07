@extends('layouts.app')

@section('title', 'Medical History')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">My Medical History</h2>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if($medicalHistory->isEmpty())
        <div class="alert alert-info">No medical history records found.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Diagnosis</th>
                        <th>Prescription</th>
                        <th>Doctor</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medicalHistory as $record)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($record->created_at)->format('Y-m-d') }}</td>
                            <td>{{ $record->diagnosis }}</td>
                            <td>{{ $record->prescription }}</td>
                            <td>{{ $record->doctor->name ?? 'N/A' }}</td>
                            <td>{{ $record->notes }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

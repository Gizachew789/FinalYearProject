@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Patient Details - {{ $patient->user->name ?? 'Patient' }}</h2>

    <div class="card mb-4">
        <div class="card-header">Basic Information</div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $patient->id }}</p>
            <p><strong>Name:</strong> {{ $patient->user->name }}</p>
            <p><strong>Gender:</strong> {{ $patient->gender }}</p>
            <p><strong>Birth Date:</strong> {{ $patient->birth_date }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Lab Requests</div>
        <div class="card-body">
            @if($patient->labRequests->isEmpty())
                <p>No lab requests found.</p>
            @else
                <ul>
                    @foreach($patient->labRequests as $request)
                        <li>{{ $request->test_name }} - {{ ucfirst($request->status) }} ({{ $request->created_at->format('Y-m-d') }})</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection

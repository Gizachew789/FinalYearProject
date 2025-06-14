@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Request Lab Test for {{ $patient->user->name ?? 'Patient' }}</h2>

    <form action="{{ route('staff.lab-requests.store', ['patient_id' => $patient->patient_id]) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="test_name" class="form-label">Test Name</label>
            <input type="text" class="form-control" id="test_name" name="test_name" required>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Lab Request</button>
    </form>
</div>
@endsection

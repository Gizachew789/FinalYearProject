@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Book an Appointment</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('patient.appointments.store') }}">
        @csrf

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="time" class="form-label">Time</label>
            <input type="time" name="time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="reason" class="form-label">Reason</label>
            <textarea name="reason" class="form-control" rows="3" required></textarea>
        </div>

        <input type="hidden" name="status" value="pending">

        <button type="submit" class="btn btn-primary">Book Appointment</button>
    </form>
</div>
@endsection

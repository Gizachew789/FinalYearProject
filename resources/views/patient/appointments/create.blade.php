@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Book an Appointment</h2>

    <form method="POST" action="{{ route('patient.appointments.store') }}">
    @csrf
    
    <label for="date">Date</label>
    <input type="date" name="date" required>

    <label for="time">Time</label>
    <input type="time" name="time" required>

    <label for="reason">Reason</label>
    <textarea name="reason" required></textarea>

    <button type="submit">Book Appointment</button>
</form>

</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Appointment Reports</h1>
    <p>Generate and view reports for appointments.</p>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.reports.appointments') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-4">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="">All</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.reports.appointments') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

<!-- Appointment Report Table -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Patient Name</th>
            <th>Receptionist</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Reason</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($appointments as $appointment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $appointment->patient->user->name }}</td>
                <td>{{ $appointment->reception->user->name }}</td>
                <td>{{ $appointment->appointment_date }}</td>
                <td>{{ $appointment->appointment_time }}</td>
                <td>{{ ucfirst($appointment->status) }}</td>
                <td>{{ $appointment->reason }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No appointments found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Pagination -->
<div class="d-flex justify-content-center">
    {{ $appointments->links() }}
</div>

</div>
@endsection
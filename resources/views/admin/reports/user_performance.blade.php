@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Performance Reports</h1>
    <p>Generate and view reports for user performance.</p>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.reports.userPerformance') }}" class="mb-4">
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
                <label for="user" class="form-label">User</label>
                <select id="user" name="user" class="form-select">
                    <option value="">All Users</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.reports.userPerformance') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <!-- User Performance Report Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>Total Appointments</th>
                <th>Completed Appointments</th>
                <th>Cancelled Appointments</th>
                <th>Medical Records Created</th>
                <th>Prescriptions Issued</th>
            </tr>
        </thead>   
        <tbody>
            @foreach ($users as $user)
                @php
                    // Filter data for the current user
                    $appointmentsForUser = $appointments->firstWhere('reception_id', $user->id);
                    $medicalRecordsForUser = $medical_records->firstWhere('created_by', $user->id);
                    $prescriptionsForUser = $prescriptions->firstWhere('prescriber_id', $user->id);
                @endphp

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $appointmentsForUser ? $appointmentsForUser->total_appointments : 0 }}</td>
                    <td>{{ $appointmentsForUser ? $appointmentsForUser->completed_appointments : 0 }}</td>
                    <td>{{ $appointmentsForUser ? $appointmentsForUser->cancelled_appointments : 0 }}</td>
                    <td>{{ $medicalRecordsForUser ? $medicalRecordsForUser->count : 0 }}</td>
                    <td>{{ $prescriptionsForUser ? $prescriptionsForUser->count : 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->

</div>
@endsection

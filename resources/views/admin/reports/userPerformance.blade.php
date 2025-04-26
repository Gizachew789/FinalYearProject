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
            @forelse ($performanceData as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data['user_name'] }}</td>
                    <td>{{ $data['total_appointments'] }}</td>
                    <td>{{ $data['completed_appointments'] }}</td>
                    <td>{{ $data['cancelled_appointments'] }}</td>
                    <td>{{ $data['medical_records_created'] }}</td>
                    <td>{{ $data['prescriptions_issued'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No performance data found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $performanceData->links() }}
    </div>
</div>
@endsection
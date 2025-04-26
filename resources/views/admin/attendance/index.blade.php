<!-- resources/views/admin/attendance/index.blade.php -->

@extends('layouts.app') <!-- Extend the base layout -->

@section('content')
    <!-- Page-specific content for Attendance Management -->
    <div class="container">
        <h1>Attendance Management</h1>

        <table>
            <thead>
                <tr>
                    <th>Staff Name</th>
                    <th>Date</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Status</th> 
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance) <!-- Changed back to $attendances -->
                    <tr>
                        <td>{{ $attendance->user->name }}</td> <!-- Assuming 'user' relationship -->
                        <td>{{ $attendance->date }}</td>
                        <td>{{ $attendance->check_in }}</td>
                        <td>{{ $attendance->check_out }}</td>
                        <td>{{ $attendance->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination links -->
        <div>
        <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary">Add Attendance</a>
        <a href="{{ route('admin.attendance.confirm', $attendance->user->id) }}" class="btn btn-success">Confirm Attendance</a>
            {{ $attendances->links() }}
        </div>
    </div>
@endsection

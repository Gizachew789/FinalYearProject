{{-- resources/views/admin/attendance/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Attendance Detail for {{ $attendance->user->name }}</h2>

    <div class="card mt-3">
        <div class="card-body">
            <p><strong>Date:</strong> {{ $attendance->date }}</p>
            <p><strong>Check In:</strong> {{ $attendance->check_in }}</p>
            <p><strong>Check Out:</strong> {{ $attendance->check_out ?? 'N/A' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($attendance->status) }}</p>
        </div>
    </div>

    <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary mt-3">Back to Attendance List</a>
</div>
@endsection
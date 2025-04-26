{{-- resources/views/admin/attendance/store.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Add Attendance Record</h2>

    <form action="{{ route('admin.attendance.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select name="user_id" id="user_id" class="form-select" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="check_in" class="form-label">Check In</label>
            <input type="datetime-local" name="check_in" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="check_out" class="form-label">Check Out</label>
            <input type="datetime-local" name="check_out" class="form-control">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="present">Present</option>
                <option value="absent">Absent</option>
                <option value="late">Late</option>
                <option value="half_day">Half Day</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection

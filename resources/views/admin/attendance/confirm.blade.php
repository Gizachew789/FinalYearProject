{{-- resources/views/admin/attendance/confirm.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Confirm Attendance for {{ $attendance->user->name }}</h2>

    <form action="{{ route('admin.attendance.confirm', $attendance->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" class="form-control" value="{{ old('date', $attendance->date ?? date('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="present" {{ old('status', $attendance->status) == 'present' ? 'selected' : '' }}>Present</option>
                <option value="absent" {{ old('status', $attendance->status) == 'absent' ? 'selected' : '' }}>Absent</option>
                <option value="late" {{ old('status', $attendance->status) == 'late' ? 'selected' : '' }}>Late</option>
                <option value="half_day" {{ old('status', $attendance->status) == 'half_day' ? 'selected' : '' }}>Half Day</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Confirm</button>
        <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

@extends('layouts.app') {{-- Or use layouts.admin if you have it --}}

@section('content')
<div class="container">
    <h2>Edit Patient</h2>

    <form action="{{ route('admin.patients.update',$patient-> patient_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="student_id" class="form-label">Student ID</label>
            <input type="text" name="patient_id" id="patient_id" class="form-control" value="{{ old('patient_id', $patient->patient_id) }}" required>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $patient->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select name="gender" id="gender" class="form-select" required>
                <option value="male" {{ $patient->gender === 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ $patient->gender === 'female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="number" name="age" id="age" class="form-control" value="{{ old('age', $patient->age) }}" required>
        </div>

        <div class="mb-3">
            <label for="department" class="form-label">Department</label>
            <input type="text" name="department" id="department" class="form-control" value="{{ old('department', $patient->department) }}" required>
        </div>

        <div class="mb-3">
            <label for="year_of_study" class="form-label">Year of Study</label>
            <input type="text" name="year_of_study" id="year_of_study" class="form-control" value="{{ old('year_of_study', $patient->year_of_study) }}" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $patient->phone) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $patient->email) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Patient</button>
    </form>
</div>
@endsection

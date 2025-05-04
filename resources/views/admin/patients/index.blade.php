@extends('layouts.app')

@section('title', 'Patient List')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Patients</h2>
        <a href="{{ route('reception.register.patient') }}" class="btn btn-primary">Register New Patient</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    //@if ($patients->isEmpty())
        <p>No patients registered yet.</p>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Department</th>
                    <th>Year</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $patient)
                    <tr>
                        <td>{{ $patient->id }}</td>
                        <td>{{ $patient->name }}</td>
                        <td>{{ ucfirst($patient->gender) }}</td>
                        <td>{{ $patient->age }}</td>
                        <td>{{ $patient->department }}</td>
                        <td>{{ $patient->year_of_study }}</td>
                        <td>{{ $patient->email }}</td>
                        <td>{{ $patient->phone }}</td>
                        <td>
                            <a href="{{ route('admin.patients.show', $patient->id) }}" class="btn btn-sm btn-info mb-1">View</a>
                            <a href="{{ route('admin.patients.edit', $patient->id) }}" class="btn btn-sm btn-warning mb-1">Edit</a>
                            <form action="{{ route('admin.patients.destroy', $patient->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this patient?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger mb-1">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection

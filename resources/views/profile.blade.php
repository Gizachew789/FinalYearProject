@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Profile</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>ID:</strong> {{ $user->id }}</p>

            @if ($type === 'user')
                <p><strong>Role:</strong> {{ $user->role }}</p>
            @elseif ($type === 'patient')
                <p><strong>Student ID:</strong> {{ $user->student_id ?? 'N/A' }}</p>
                <p><strong>Name:</strong> {{ $patient->name }}</p>
            <p><strong>Email:</strong> {{ $patient->email }}</p>
            @endif
        </div>
    </div>
</div>
@endsection

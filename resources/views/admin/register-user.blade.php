@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Register New User</h2>

    @if (session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.register.user.store') }}">

        @csrf

        <div class="mb-4">
            <label>Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label>Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label>Password</label>
            <input type="password" name="password" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label>Role</label>
            <select name="role" class="w-full border p-2 rounded" required>
                <option value="receptionist">Receptionist</option>
                <option value="pharmacist">Pharmacist</option>
                <option value="lab_technician">Lab Technician</option>
                <option value="nurse">Nurse</option>
                <option value="health_officer">Health Officer</option>
            </select>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Register</button>
    </form>
</div>
@endsection

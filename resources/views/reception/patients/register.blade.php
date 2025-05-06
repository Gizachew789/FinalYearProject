@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Register New Patient</h2>

    @if (session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('reception.register.patient.store') }}">
        @csrf
                <div class="mb-4">
        <label for="id">Patient ID</label>
        <input type="text" name="id" required class="w-full border p-2 rounded">
             </div>
        <div class="mb-4">
            <label>Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label>Gender</label>
            <select name="gender" class="w-full border p-2 rounded" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>

        <div class="mb-4">
            <label>Age</label>
            <input type="number" name="age" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label>Phone</label>
            <input type="text" name="phone" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label>Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label>Department</label>
            <input type="text" name="department" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label>year of study</label>
            <input type="text" name="year_of_study" class="w-full border p-2 rounded">
        </div>

        <button type="submit" class="bg-green-600 text-black px-4 py-2 rounded">Register Patient</button>
    </form>
</div>
@endsection

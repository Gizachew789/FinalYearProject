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
            <label>Age</label>
            <input type="number" name="age" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
             <label>Gender</label>
              <select name="gender" class="w-full border p-2 rounded" required>
               <option value="male">Male</option>
               <option value="female">Female</option>
              </select>
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
            <label>Role</label>
            <select name="role" class="w-full border p-2 rounded" required>
                <option value="Reception">Receptionist</option>
                <option value="Pharmacist">Pharmacist</option>
                <option value="Lab_Technician">Lab Technician</option>
                <option value="Nurse">Nurse</option>
                <option value="Health_Officer">Health Officer</option>
            </select>
        </div>

        <button type="submit" class="bg-green-600 text-green px-4 py-2 rounded">Register</button>
    </form>
</div>
@endsection


@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Edit User</h1>

    <form  method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Reception" {{ $user->role == 'Reception' ? 'selected' : '' }}>Reception</option>
                <option value="Pharmacist" {{ $user->role == 'Pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                <option value="Lab_Technician" {{ $user->role == 'Lab_Technician' ? 'selected' : '' }}>Lab Technician</option>
                <option value="Health_Officer" {{ $user->role == 'Health_Officer' ? 'selected' : '' }}>Health Officer</option>           
                <option value="Nurse" {{ $user->role == 'Nurse' ? 'selected' : '' }}>Nurse</option>    
            </select>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update User</button>
    </form>

    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Back to Users</a>
</div>
@endsection
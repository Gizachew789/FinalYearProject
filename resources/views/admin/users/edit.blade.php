<?php

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Edit User</h1>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
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
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="healthOfficer" {{ $user->role == 'healthOfficer' ? 'selected' : '' }}>Health Officer</option>
                <option value="reception" {{ $user->role == 'reception' ? 'selected' : '' }}>Reception</option>
                <option value="lab_technician" {{ $user->role == 'lab_technician' ? 'selected' : '' }}>Lab Technician</option>
                <option value="pharmacist" {{ $user->role == 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
            </select>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}">
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update User</button>
    </form>

    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Back to Users</a>
</div>
@endsection
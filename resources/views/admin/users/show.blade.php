<?php
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>User Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Name: {{ $user->name }}</h5>
            <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="card-text"><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
            <p class="card-text"><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
            <p class="card-text"><strong>Status:</strong> {{ ucfirst($user->status) }}</p>
            <p class="card-text"><strong>Created At:</strong> {{ $user->created_at->format('d M Y, h:i A') }}</p>
        </div>
    </div>

    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mt-3">Back to Users</a>
    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary mt-3">Edit User</a>
</div>
@endsection
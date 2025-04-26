@extends('layouts.app')

@section('content')
<h2>Edit Medication</h2>

<form method="POST" action="{{ route('admin.inventory.update', $medication->id) }}">
    @csrf
    @method('PUT')
    <input type="text" name="name" value="{{ $medication->name }}" required>
    <input type="text" name="category" value="{{ $medication->category }}" required>
    <input type="text" name="unit" value="{{ $medication->unit }}" required>
    <input type="number" name="reorder_level" value="{{ $medication->reorder_level }}" required>
    <input type="number" name="price" value="{{ $medication->price }}" step="0.01" required>
    <input type="date" name="expiry_date" value="{{ $medication->expiry_date ? date('Y-m-d', strtotime($medication->expiry_date)) : '' }}">
    <input type="text" name="manufacturer" value="{{ $medication->manufacturer }}">
    <button type="submit">Update</button>
</form>
@endsection

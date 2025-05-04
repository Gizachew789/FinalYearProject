
@extends('layouts.app')

@section('content')
<h2>Add New Medication</h2>

<form method="POST" action="{{ route('admin.inventory.store') }}">
    @csrf
    <input type="text" name="name" placeholder="Name" required>
    <input type="text" name="category" placeholder="Category" required>
    <input type="text" name="unit" placeholder="Unit" required>
    <input type="number" name="current_stock" placeholder="Current Stock" required>
    <input type="number" name="reorder_level" placeholder="Reorder Level" required>
    <input type="date" name="expiry_date">
    <input type="text" name="manufacturer" placeholder="Manufacturer">
    <button type="submit">Save</button>
</form>
@endsection

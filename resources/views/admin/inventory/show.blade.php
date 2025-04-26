@extends('layouts.app')

@section('content')
<h2>Medication Details</h2>

<ul>
    <li><strong>Name:</strong> {{ $medication->name }}</li>
    <li><strong>Category:</strong> {{ $medication->category }}</li>
    <li><strong>Unit:</strong> {{ $medication->unit }}</li>
    <li><strong>Current Stock:</strong> {{ $medication->current_stock }}</li>
    <li><strong>Reorder Level:</strong> {{ $medication->reorder_level }}</li>
    <li><strong>Price:</strong> {{ $medication->price }}</li>
    <li><strong>Expiry Date:</strong> {{ $medication->expiry_date }}</li>
    <li><strong>Manufacturer:</strong> {{ $medication->manufacturer }}</li>
</ul>

<a href="{{ route('admin.inventory.edit', $medication->id) }}">Edit</a>
<a href="{{ route('admin.inventory.index') }}">Back to List</a>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Update Inventory Item</h1>
    <p>Modify the details of the inventory item below.</p>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Inventory Item Update Form -->
    <form method="POST" action="{{ route('admin.inventory.update', $item->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Item Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control">{{ old('description', $item->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" id="category" name="category" class="form-control" value="{{ old('category', $item->category) }}" required>
        </div>

        <div class="mb-3">
            <label for="unit" class="form-label">Unit</label>
            <input type="text" id="unit" name="unit" class="form-control" value="{{ old('unit', $item->unit) }}" required>
        </div>

        <div class="mb-3">
            <label for="current_stock" class="form-label">Current Stock</label>
            <input type="number" id="current_stock" name="current_stock" class="form-control" value="{{ old('current_stock', $item->current_stock) }}" required>
        </div>

        <div class="mb-3">
            <label for="reorder_level" class="form-label">Reorder Level</label>
            <input type="number" id="reorder_level" name="reorder_level" class="form-control" value="{{ old('reorder_level', $item->reorder_level) }}" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" id="price" name="price" class="form-control" value="{{ old('price', $item->price) }}" required>
        </div>

        <div class="mb-3">
            <label for="expiry_date" class="form-label">Expiry Date</label>
            <input type="date" id="expiry_date" name="expiry_date" class="form-control" value="{{ old('expiry_date', $item->expiry_date) }}">
        </div>

        <div class="mb-3">
            <label for="manufacturer" class="form-label">Manufacturer</label>
            <input type="text" id="manufacturer" name="manufacturer" class="form-control" value="{{ old('manufacturer', $item->manufacturer) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Item</button>
        <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
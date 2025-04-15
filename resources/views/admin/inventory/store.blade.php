@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Inventory Item</h1>
    <p>Fill out the form below to add a new inventory item.</p>

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

    <!-- Inventory Item Creation Form -->
    <form method="POST" action="{{ route('admin.inventory.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Item Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" id="category" name="category" class="form-control" value="{{ old('category') }}" required>
        </div>

        <div class="mb-3">
            <label for="unit" class="form-label">Unit</label>
            <input type="text" id="unit" name="unit" class="form-control" value="{{ old('unit') }}" required>
        </div>

        <div class="mb-3">
            <label for="current_stock" class="form-label">Current Stock</label>
            <input type="number" id="current_stock" name="current_stock" class="form-control" value="{{ old('current_stock') }}" required>
        </div>

        <div class="mb-3">
            <label for="reorder_level" class="form-label">Reorder Level</label>
            <input type="number" id="reorder_level" name="reorder_level" class="form-control" value="{{ old('reorder_level') }}" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" id="price" name="price" class="form-control" value="{{ old('price') }}" required>
        </div>

        <div class="mb-3">
            <label for="expiry_date" class="form-label">Expiry Date</label>
            <input type="date" id="expiry_date" name="expiry_date" class="form-control" value="{{ old('expiry_date') }}">
        </div>

        <div class="mb-3">
            <label for="manufacturer" class="form-label">Manufacturer</label>
            <input type="text" id="manufacturer" name="manufacturer" class="form-control" value="{{ old('manufacturer') }}">
        </div>

        <button type="submit" class="btn btn-primary">Create Item</button>
        <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
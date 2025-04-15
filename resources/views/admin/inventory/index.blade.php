@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Inventory Management</h1>
    <p>View and manage all inventory items.</p>

    <!-- Add Inventory Management Options -->
    <div class="mb-3">
        <a href="{{ route('admin.inventory.create') }}" class="btn btn-primary">Add New Item</a>
        <a href="{{ route('admin.inventory.lowStock') }}" class="btn btn-warning">View Low Stock Items</a>
    </div>

    <!-- Inventory Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Category</th>
                <th>Current Stock</th>
                <th>Reorder Level</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($medications as $medication)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $medication->name }}</td>
                    <td>{{ $medication->category }}</td>
                    <td>{{ $medication->current_stock }}</td>
                    <td>{{ $medication->reorder_level }}</td>
                    <td>${{ number_format($medication->price, 2) }}</td>
                    <td>
                        <a href="{{ route('admin.inventory.show', $medication->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('admin.inventory.edit', $medication->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.inventory.destroy', $medication->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No inventory items found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $medications->links() }}
    </div>
</div>
@endsection
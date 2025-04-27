@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Inventory Reports</h1>
    <p>Generate and view reports for inventory.</p>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.reports.inventory') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="category" class="form-label">Category</label>
                <select id="category" name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ ucfirst($category) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="low_stock" class="form-label">Low Stock</label>
                <select id="low_stock" name="low_stock" class="form-select">
                    <option value="">All</option>
                    <option value="true" {{ request('low_stock') == 'true' ? 'selected' : '' }}>Low Stock</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="search" class="form-label">Search</label>
                <input type="text" id="search" name="search" class="form-control" placeholder="Search by name" value="{{ request('search') }}">
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.reports.inventory') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <!-- Inventory Report Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Category</th>
                <th>Current Stock</th>
                <th>Reorder Level</th>
                <th>Unit</th>
                <th>Manufacturer</th>
                <th>Expiry Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($low_stock as $medication)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $medication->name }}</td>
                    <td>{{ $medication->category }}</td>
                    <td>{{ $medication->current_stock }}</td>
                    <td>{{ $medication->reorder_level }}</td>
                    <td>{{ $medication->unit }}</td>
                    <td>{{ $medication->manufacturer }}</td>
                    <td>{{ $medication->expiry_date ? $medication->expiry_date->format('Y-m-d') : 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No low stock items found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Most Used Medications Report -->
    <h3>Most Used Medications (from {{ \Carbon\Carbon::parse($date_range['start_date'])->format('Y-m-d') }} to {{ \Carbon\Carbon::parse($date_range['end_date'])->format('Y-m-d') }})</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Total Used</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($most_used as $used)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $used->medication->name ?? 'Unknown Medication' }}</td>
                    <td>{{ $used->total_used }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->

</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Delete Inventory Item</h1>
    <p>Are you sure you want to delete the inventory item: <strong>{{ $item->name }}</strong>?</p>

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

    <!-- Delete Confirmation Form -->
    <form method="POST" action="{{ route('admin.inventory.destroy', $item->id) }}">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger">Delete</button>
        <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
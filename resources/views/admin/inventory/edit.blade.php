<?php
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Inventory Item</h1>
    <form method="POST" action="{{ route('admin.inventory.update', $item->id) }}">
        @csrf
        @method('PUT')
        <!-- Add form fields for inventory editing -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $item->name) }}" required>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $item->quantity) }}" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" class="form-control" id="price" name="price" value="{{ old('price', $item->price) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
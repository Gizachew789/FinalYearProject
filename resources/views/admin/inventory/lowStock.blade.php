<?php
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Low Stock Items</h1>
    <p>View all inventory items with low stock.</p>
    <!-- Add table or list for low stock items -->
    <table class="table">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Current Stock</th>
                <th>Reorder Level</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lowStockItems as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->current_stock }}</td>
                <td>{{ $item->reorder_level }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
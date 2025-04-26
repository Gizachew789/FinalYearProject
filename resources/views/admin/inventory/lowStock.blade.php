@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Low Stock Medications</h2>

        <!-- Display a message if there are no low stock medications -->
        @if($medications->isEmpty())
            <p>No low stock medications found.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Current Stock</th>
                        <th>Reorder Level</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medications as $med)
                        <tr>
                            <td>{{ $med->name }}</td>
                            <td>{{ $med->current_stock }}</td>
                            <td>{{ $med->reorder_level }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Test Results</h1>
        <a href="{{ route('results.create') }}" class="btn btn-primary mb-3">Create New Result</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient Name</th>
                    <th>Tested By</th>
                    <th>Disease Type</th>
                    <th>Result</th>
                    <th>Sample Type</th>
                    <th>Recommendation</th>
                    <th>Result Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $result)
                    <tr>
                        <td>{{ $result->id }}</td>
                        <td>{{ $result->patient->name }}</td>
                        <td>{{ $result->tested_by_user?->name ?? 'N/A' }}</td>
                        <td>{{ $result->disease_type }}</td>
                        <td>{{ $result->result }}</td>
                        <td>{{ $result->sample_type }}</td>
                        <td>{{ $result->recommendation }}</td>
                        <td>{{ $result->result_date }}</td>
                        <td>
                            <a href="{{ route('results.show', $result->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('results.edit', $result->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('results.destroy', $result->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

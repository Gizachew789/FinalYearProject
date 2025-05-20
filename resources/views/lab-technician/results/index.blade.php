@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Test Results</h1>
        <a href="{{ route('lab.results.create') }}" class="btn btn-primary mb-3">Create New Result</a>

        <table class="table table-striped">
            <thead>
                <tr>
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
                        <td>{{ $result->patient_id }}</td>
                        <td>{{ $result->patient->name }}</td>
                        <td>{{ $result->tested_by_user?->name }}</td>
                        <td>{{ $result->disease_type }}</td>
                        <td>{{ $result->result }}</td>
                        <td>{{ $result->sample_type }}</td>
                        <td>{{ $result->recommendation }}</td>
                        <td>{{ $result->result_date }}</td>
                        <td>
                            <a href="{{ route('lab.results.show', $result->patient_id) }}" class="btn btn-info btn-sm">View</a>
                            <!-- <form action="{{ route('lab.results.destroy', $result->patient_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form> -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection


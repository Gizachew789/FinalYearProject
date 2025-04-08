@extends('layouts.app')

@section('content')
    <h1>Lab Reports</h1>

    <a href="{{ route('lab_reports.create') }}" class="btn btn-primary">Create Lab Report</a>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Report Date</th>
                <th>Result</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($labReports as $labReport)
                <tr>
                    <td>{{ $labReport->patient->name }}</td>
                    <td>{{ $labReport->report_date->format('Y-m-d') }}</td>
                    <td>{{ $labReport->result }}</td>
                    <td>
                        <a href="{{ route('lab_reports.show', $labReport) }}" class="btn btn-info">View</a>
                        <a href="{{ route('lab_reports.edit', $labReport) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('lab_reports.destroy', $labReport) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

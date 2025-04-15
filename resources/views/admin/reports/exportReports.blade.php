@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Export Reports</h1>
    <p>Select the type of report you want to export and the format.</p>

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

    <!-- Export Reports Form -->
    <form method="GET" action="{{ route('admin.reports.export', ['type' => '']) }}">
        <div class="form-group mb-3">
            <label for="report_type">Report Type</label>
            <select id="report_type" name="report_type" class="form-control" required>
                <option value="appointments">Appointments</option>
                <option value="inventory">Inventory</option>
                <option value="user-performance">User Performance</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="format">Export Format</label>
            <select id="format" name="format" class="form-control" required>
                <option value="csv">CSV</option>
                <option value="pdf">PDF</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Export</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Lab Test Result</h1>

    <form action="{{ route('results.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="patient_id">Patient</label>
            <select name="patient_id" id="patient_id" class="form-control">
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="tested_by">Tested By</label>
            <select name="tested_by" id="tested_by" class="form-control">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="disease_type">Disease Type</label>
            <input type="text" name="disease_type" id="disease_type" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="sample_type">Sample Type</label>
            <select name="sample_type" id="sample_type" class="form-control" required>
                <option value="Blood">Blood</option>
                <option value="Saliva">Saliva</option>
                <option value="Tissue">Tissue</option>
                <option value="Waste">Waste</option>
            </select>
        </div>

        <div class="form-group">
            <label for="result">Result</label>
            <select name="result" id="result" class="form-control" required>
                <option value="Positive">Positive</option>
                <option value="Negative">Negative</option>
            </select>
        </div>

        <div class="form-group">
            <label for="recommendation">Recommendation</label>
            <input type="text" name="recommendation" id="recommendation" class="form-control">
        </div>

        <div class="form-group">
            <label for="result_date">Result Date</label>
            <input type="date" name="result_date" id="result_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection

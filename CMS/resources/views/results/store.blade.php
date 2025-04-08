@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Result</h1>
        
        <form action="{{ route('results.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="patient_id">Patient</label>
                <select name="patient_id" id="patient_id" class="form-control">
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tested_by">Tested By</label>
                <select name="tested_by" id="tested_by" class="form-control">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="disease_type">Disease Type</label>
                <input type="text" name="disease_type" class="form-control" value="{{ old('disease_type') }}" required>
            </div>

            <div class="form-group">
                <label for="sample_type">Sample Type</label>
                <select name="sample_type" class="form-control" required>
                    <option value="Blood" {{ old('sample_type') == 'Blood' ? 'selected' : '' }}>Blood</option>
                    <option value="Saliva" {{ old('sample_type') == 'Saliva' ? 'selected' : '' }}>Saliva</option>
                    <option value="Tissue" {{ old('sample_type') == 'Tissue' ? 'selected' : '' }}>Tissue</option>
                    <option value="Waste" {{ old('sample_type') == 'Waste' ? 'selected' : '' }}>Waste</option>
                </select>
            </div>

            <div class="form-group">
                <label for="result">Result</label>
                <select name="result" class="form-control" required>
                    <option value="Positive" {{ old('result') == 'Positive' ? 'selected' : '' }}>Positive</option>
                    <option value="Negative" {{ old('result') == 'Negative' ? 'selected' : '' }}>Negative</option>
                </select>
            </div>

            <div class="form-group">
                <label for="recommendation">Recommendation</label>
                <textarea name="recommendation" class="form-control">{{ old('recommendation') }}</textarea>
            </div>

            <div class="form-group">
                <label for="result_date">Result Date</label>
                <input type="date" name="result_date" class="form-control" value="{{ old('result_date') }}" required>
            </div>

            <button type="submit" class="btn btn-success">Create Result</button>
            <a href="{{ route('results.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection

{{-- resources/views/staff/medical_records/store.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Upload Medical Document for {{ $patient->user->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">Upload New Medical Document</div>
        <div class="card-body">
            <form action="{{ route('staff.medical_records.store', $patient->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                <div class="form-group">
                    <label for="document">Medical Document (PDF or Image)</label>
                    <input type="file" name="document" class="form-control" required>
                </div>

                <div class="form-group mt-2">
                    <label for="notes">Notes</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Enter summary or notes..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Upload</button>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
   

    <div class="card mb-4">
        <div class="card-header">Basic Information</div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $patients->patient_id ?? 'N/A' }}</p>
            <p><strong>Name:</strong> {{ $patients->name ? $patients->name : 'N/A'}}</p>
            <p><strong>Gender:</strong> {{ $patients->gender ?? 'N/A' }}</p>

        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Medical Records and Documents</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- Form to Record New Medical History -->
            <h5 class="mt-4">Record New Medical History</h5>
            <form action="{{ route('staff.medical_records.store', $patients->patient_id) }}" method="POST" class="mb-4">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="diagnosis" class="form-label">Diagnosis</label>
                        <input type="text" name="diagnosis" id="diagnosis" class="form-control" value="{{ old('diagnosis') }}" required>
                        @error('diagnosis')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="visit_date" class="form-label">Visit Date</label>
                        <input type="date" name="visit_date" id="visit_date" class="form-control" value="{{ old('visit_date') }}" required>
                        @error('visit_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="treatment" class="form-label">Treatment</label>
                        <textarea name="treatment" id="treatment" class="form-control">{{ old('treatment') }}</textarea>
                        @error('treatment')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prescription" class="form-label">Prescription</label>
                        <textarea name="prescription" id="prescription" class="form-control">{{ old('prescription') }}</textarea>
                        @error('prescription')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="follow_up_date" class="form-label">Follow-Up Date</label>
                        <input type="date" name="follow_up_date" id="follow_up_date" class="form-control" value="{{ old('follow_up_date') }}">
                        @error('follow_up_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lab_results_id" class="form-label">Lab Result ID (Optional)</label>
                        <input type="number" name="lab_results_id" id="lab_results_id" class="form-control" value="{{ old('lab_results_id') }}">
                        @error('lab_results_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save Medical Record</button>
            </form>

            <!-- Form to Upload Medical Document -->
            <h5 class="mt-4">Upload Medical Document</h5>
            <form action="{{ route('staff.medical_documents.upload', $patients->patient_id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label for="document" class="form-label">Document (PDF, JPG, PNG, max 5MB)</label>
                    <input type="file" name="document" id="document" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                    @error('document')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Upload Document</button>
            </form>

            <!-- Medical Records Table -->
            <h5 class="mt-4">Medical Records</h5>
            @if($patients->medicalHistory->isEmpty())
                <p>No medical records found.</p>
            @else
                <table class="table table-bordered mb-4">
                    <thead>
                        <tr>
                            <th>Visit Date</th>
                            <th>Diagnosis</th>
                            <th>Treatment</th>
                            <th>Prescription</th>
                            <th>Follow-Up Date</th>
                            <th>Created By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients->medicalHistory as $record)
                            <tr>
                                <td>{{ $record->visit_date ? $record->visit_date->format('Y-m-d') : 'N/A' }}</td>
                                <td>{{ $record->diagnosis ?? 'N/A' }}</td>
                                <td>{{ $record->treatment ?? 'N/A' }}</td>
                                <td>{{ $record->prescription ?? 'N/A' }}</td>
                                <td>{{ $record->follow_up_date ? $record->follow_up_date->format('Y-m-d') : 'N/A' }}</td>
                                <td>{{ $record->createdBy ? $record->createdBy->name : 'Unknown' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <!-- Medical Documents Table -->
            <h5 class="mt-4">Medical Documents</h5>
            @if($patients->medicalDocuments->isEmpty())
                <p>No medical documents found.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>File Type</th>
                            <th>Uploaded At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients->medicalDocuments as $document)
                            <tr>
                                <td>{{ ucfirst($document->file_type) }}</td>
                                <td>{{ $document->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ Storage::url($document->file_path) }}" class="btn btn-sm btn-info" target="_blank">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
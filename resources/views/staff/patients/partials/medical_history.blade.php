<div class="mb-3">
    <h5>Student Information</h5>
    <ul class="list-group">
        <li class="list-group-item"><strong>Name:</strong> {{ $patient->name }}</li>
        <li class="list-group-item"><strong>ID:</strong> {{ $patient->id ?? $patient->patient_id }}</li>
        <li class="list-group-item"><strong>Gender:</strong> {{ $patient->gender }}</li>
        <li class="list-group-item"><strong>Department:</strong> {{ $patient->department ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Year of Study:</strong> {{ $patient->year_of_study ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Phone:</strong> {{ $patient->phone ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $patient->email ?? 'N/A' }}</li>
    </ul>
</div>
@if($medicalRecords->isEmpty())
    <div class="alert alert-info mt-3">No medical history found for this patient.</div>
@else
    <h5 class="mt-4">Medical History</h5>
    <ul class="list-group mb-3">
        @foreach($medicalRecords as $record)
            <li class="list-group-item">
                <strong>Date:</strong> {{ $record->visit_date ?? $record->created_at->format('Y-m-d') }}<br>
                <strong>Diagnosis:</strong> {{ $record->diagnosis ?? 'N/A' }}<br>
                <strong>Treatment:</strong> {{ $record->treatment ?? 'N/A' }}<br>
                <strong>Prescription:</strong> {{ $record->prescription ?? 'N/A' }}
            </li>
        @endforeach
    </ul>
@endif

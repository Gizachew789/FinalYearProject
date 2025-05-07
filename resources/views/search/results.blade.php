<h2>Search results for "{{ $query }}"</h2>

@if($patients->isEmpty() && $users->isEmpty())
    <p>No results found.</p>
@endif

@if(!$patients->isEmpty())
    <h3>Patients</h3>
    @foreach($patients as $patient)
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
            <p><strong>Patient ID:</strong> {{ $patient->patient_id ?? 'N/A' }}</p>
            <p><strong>Full Name:</strong> {{ $patient->name ?? 'N/A' }}</p>
            <p><strong>Gender:</strong> {{ $patient->gender ?? 'N/A' }}</p>
            <p><strong>Age:</strong> {{ $patient->age ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $patient->email ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $patient->phone ?? 'N/A' }}</p>
            <p><strong>Department:</strong> {{ $patient->department ?? 'N/A' }}</p>
            <p><strong>Created At:</strong> {{ $patient->created_at }}</p>
        </div>
    @endforeach
@endif

@if(!$users->isEmpty())
    <h3>Users</h3>
    <ul>
        @foreach($users as $user)
            <li>{{ $user->name ?? $user->id }}</li>
        @endforeach
    </ul>
@endif

@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Create Prescription for {{ $patient->name }}</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('staff.prescriptions.store', ['patient_id' => $patient->patient_id]) }}" method="POST">
        @csrf

        <select name="medication_id" id="medication_id" class="form-control" required>
              <option value="">Select Medication</option>
              @foreach($medications as $medication)
              <option value="{{ $medication->id }}">{{ $medication->name }}</option>
              @endforeach
        </select>


        <div class="mb-3">
            <label for="dosage" class="form-label">Dosage</label>
            <input type="text" name="dosage" id="dosage" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="instructions" class="form-label">Instructions</label>
            <textarea name="instructions" id="instructions" class="form-control" rows="3"></textarea>
        </div>

         <div class="mb-3">
          <label for="frequency" class="form-label">Frequency</label>
          <select class="form-control" id="frequency" name="frequency" required>
             <option value="Once a day">Once a day</option>
             <option value="Twice a day">Twice a day</option>
             <option value="Three times a day">Three times a day</option>
             <option value="Every 8 hours">Every 8 hours</option>
             <option value="Every 12 hours">Every 12 hours</option>
             <option value="Before bedtime">Before bedtime</option>
             <option value="Weekly">Weekly</option>
             <option value="As needed">As needed</option>
          </select>
        </div>

        <div class="mb-3">
            <label for="duration" class="form-label">Duration</label>
            <input type="text" name="duration" id="duration" class="form-control" required>
        </div>




        <button type="submit" class="btn btn-primary">Submit Prescription</button>
    </form>
</div>
@endsection

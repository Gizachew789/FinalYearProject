@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Pharmacist Dashboard</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Prescription List --}}
    <div class="card mb-4">
        <div class="card-header">Pending Prescriptions</div>
        <div class="card-body">
            @forelse($prescriptions as $prescription)
                <div class="border p-3 mb-3">
                    <p><strong>Patient:</strong> {{ $prescription->patient->user->name }}</p>
                    <p><strong>Date:</strong> {{ $prescription->created_at->format('Y-m-d') }}</p>
                    <form method="POST" action="{{ route('pharmacist.prescriptions.dispense', $prescription->id) }}">
                        @csrf
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Medicine</th>
                                    <th>Quantity Prescribed</th>
                                    <th>Quantity to Dispense</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prescription->medications as $medication)
                                    <tr>
                                        <td>{{ $medication->name }}</td>
                                        <td>{{ $medication->pivot->quantity }}</td>
                                        <td>
                                            <input type="hidden" name="medication_ids[]" value="{{ $medication->id }}">
                                            <input type="number" name="quantities[]" class="form-control" min="1" max="{{ $medication->pivot->quantity }}" required>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-success">Confirm & Dispense</button>
                    </form>
                </div>
            @empty
                <p>No pending prescriptions.</p>
            @endforelse
        </div>
    </div>

    {{-- Inventory Section --}}
    <div class="card">
        <div class="card-header">Inventory Status</div>
          <div class="card-body">
             <table class="table table-bordered">
               <thead>
                   <tr>
                    <th>Medicine</th>
                    <th>Quantity Available</th>
                   </tr>
                </thead>
             <tbody>
                 @foreach($inventory as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->current_quantity }}</td>
                    </tr>
                 @endforeach
             </tbody>
         </table>
     </div>
   </div>

</div>
@endsection

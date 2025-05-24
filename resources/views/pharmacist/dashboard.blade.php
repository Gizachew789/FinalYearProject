@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-5 fw-bold text-primary">Pharmacist Dashboard</h1>
        <div class="badge bg-primary rounded-pill px-3 py-2 fs-6">Today: {{ now()->format('F j, Y') }}</div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Prescription List --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="bi bi-prescription2 me-2 text-primary"></i>
                        Pending Prescriptions
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($prescriptions as $prescription)
                        <div class="border rounded-3 p-4 mb-4 bg-light">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="badge bg-info text-dark fs-6 mb-2">Prescription #{{ $prescription->id }}</span>
                                    <h6 class="mb-1"><i class="bi bi-person me-2"></i>Patient: {{ $prescription->patient->user->name }}</h6>
                                    <small class="text-muted"><i class="bi bi-calendar me-1"></i>{{ $prescription->created_at->format('M d, Y - h:i A') }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="d-block fw-bold">Status:</span>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('pharmacist.prescriptions.dispense', $prescription->id) }}">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-4">Medicine</th>
                                                <th>Prescribed</th>
                                                <th>Dispense</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($prescription->medications as $medication)
                                                <tr>
                                                    <td class="ps-4 fw-semibold">{{ $medication->name }}</td>
                                                    <td>{{ $medication->pivot->quantity }}</td>
                                                    <td>
                                                        <input type="hidden" name="medication_ids[]" value="{{ $medication->id }}">
                                                        <input type="number" name="quantities[]" 
                                                               class="form-control form-control-sm w-75" 
                                                               min="1" max="{{ $medication->pivot->quantity }}" 
                                                               required>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary px-4 py-2">
                                        <i class="bi bi-check-circle me-2"></i>
                                        Confirm Dispensing
                                    </button>
                                </div>
                            </form>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-check-circle-fill text-success fs-1"></i>
                            <h5 class="mt-3 text-muted">No pending prescriptions</h5>
                            <p class="text-muted">All prescriptions have been processed</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Inventory Section --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="bi bi-clipboard2-pulse me-2 text-primary"></i>
                        Inventory Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr class="border-bottom">
                                    <th class="ps-3">Medicine</th>
                                    <th class="text-end pe-3">Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inventory as $item)
                                    <tr class="{{ $item->current_quantity < 20 ? 'table-warning' : '' }}">
                                        <td class="ps-3">{{ $item->name }}</td>
                                        <td class="text-end pe-3 fw-semibold">
                                            {{ $item->current_quantity }}
                                            @if($item->current_quantity < 20)
                                                <i class="bi bi-exclamation-triangle-fill ms-2 text-danger" data-bs-toggle="tooltip" title="Low stock"></i>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Medicines:</span>
                            <span class="fw-bold">{{ count($inventory) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Low Stock Items:</span>
                            <span class="fw-bold text-danger">{{ $inventory->where('current_quantity', '<', 20)->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Enable Bootstrap tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>
@endpush
@endsection
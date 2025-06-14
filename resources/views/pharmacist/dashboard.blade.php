@extends('layouts.app')

@section('content')
<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container-fluid">
        <div class="ms-auto d-flex align-items-center">
            @auth
                <span class="me-3 text-muted">Welcome, {{ Auth::user()->name ?? 'Guest' }}</span>
            @else
                <span class="me-3 text-muted">Welcome, Guest</span>
            @endauth
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle me-1"></i> Account
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    @auth
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                    </li>
                    @else
                    <li><a class="dropdown-item" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-2"></i>Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <!-- <h2 class="display-3 text-primary">Pharmacist Dashboard</h2> -->
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
<div class="container">
    <h2 class="mb-4"> Prescriptions</h2>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Prescribed By</th>
                <th>Medication</th>
                <th>Dosage</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($prescriptions as $prescription)
                <tr>
                    <td>{{ $prescription->patient->patient_id ?? 'Unknown' }}</td>
                    <td>{{ $prescription->prescriber->name ?? 'N/A' }}</td>
                    <td>{{ $prescription->medication->name }}</td>
                    <td>{{ $prescription->dosage }}</td>
                    <td>
                        <span class="badge 
                            @if($prescription->status == 'confirmed') bg-success 
                            @elseif($prescription->status == 'rejected') bg-danger 
                            @else bg-secondary @endif">
                            {{ ucfirst($prescription->status) }}
                        </span>
                    </td>
                    <td>
                        @if($prescription->status === 'waiting')
                            <form action="{{ route('pharmacist.prescriptions.confirm', $prescription->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button class="btn btn-sm btn-success" type="submit">Confirm</button>
                            </form>

                            <form action="{{ route('pharmacist.prescriptions.reject', $prescription->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-danger" type="submit">Reject</button>
                            </form>
                        @else
                            <em>No actions</em>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No prescriptions available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</div>

<!-- <div class="col-lg-4">
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
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medication ?? [] as $item)
                            <tr class="{{ $item->current_stock < $item->reorder_level ? 'table-warning' : '' }}">
                                <td class="ps-3">{{ $item->name }}</td>
                                <td class="text-end pe-3 fw-semibold">
                                    {{ $item->current_stock }}
                                    @if($item->current_stock < $item->reorder_level)
                                        <i class="bi bi-exclamation-triangle-fill ms-2 text-danger" data-bs-toggle="tooltip" title="Low stock"></i>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#updateStockModal"
                                        data-id="{{ $item->id }}"
                                        data-name="{{ $item->name }}">
                                        Update
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Total Medicines:</span>
                    <span class="fw-bold">{{ count($inventory ?? []) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Low Stock Items:</span>
                    <span class="fw-bold text-danger">
                       
                    </span>
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- Update Stock Modal -->
<!-- <div class="modal fade" id="updateStockModal" tabindex="-1" aria-labelledby="updateStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="updateStockForm" method="POST" action="{{ route('inventory.editStock') }}">
            @csrf
            <input type="hidden" name="medication_id" id="medicationId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reduce Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Enter the number to reduce from <strong id="medicationName"></strong>'s stock:</p>
                    <input type="number" name="reduce_amount" class="form-control" min="1" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
            </div>
        </form>
    </div>
</div> -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    var updateModal = document.getElementById('updateStockModal');
    updateModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var medicationId = button.getAttribute('data-id');
        var medicationName = button.getAttribute('data-name');
        updateModal.querySelector('#medicationId').value = medicationId;
        updateModal.querySelector('#medicationName').textContent = medicationName;
    });
});
</script>

    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white mt-5">
    <div class="container py-4">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <h3>BiT Students Clinic</h3>
                <p>Providing quality healthcare for students</p>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <h4>Quick Links</h4>
                        <ul class="list-unstyled">
                            <li><a href="{{ url('/') }}" class="text-white">Home</a></li>
                            <li><a href="{{ route('patient.dashboard') }}" class="text-white">Dashboard</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4>Contact</h4>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-envelope me-2"></i> support@bitstudentsclinic.com</li>
                            <li><i class="fas fa-phone me-2"></i> +251 911 123 456</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center py-3" style="background-color: rgba(0, 0, 0, 0.2);">
        <p class="mb-0">&copy; {{ date('Y') }} BiT Students Clinic. All rights reserved.</p>
    </div>
</footer>

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
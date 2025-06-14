@extends('layouts.app')

@section('content')
<!-- Patient Dashboard Wrapper -->
<div id="patient-dashboard-wrapper" class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar-wrapper" class="bg-dark text-white" style="width: 250px; min-height: 100vh;">
        <div class="sidebar-heading p-3">
            <h4 class="text-center">Patient Panel</h4>
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ route('patient.dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white active">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </a>
            <a href="{{ url('/') }}" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-home mr-2"></i> Home
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white" data-toggle="modal" data-target="#settingsModal">
                <i class="fas fa-cog mr-2"></i> Settings
            </a>
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper" class="w-100">
        <!-- Navbar at the top -->
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
        <div class="container-fluid p-4">
            <div class="row">
                <!-- Dashboard Cards -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0"><i class="fas fa-calendar-plus mr-2"></i>Book an Appointment</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Schedule your next appointment with our healthcare professionals.</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('patient.appointments.create') }}" class="btn btn-primary btn-block" data-toggle="modal" data-target="#bookAppointmentModal">
                                Book Appointment
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0"><i class="fas fa-clock mr-2"></i>Booked Appointments</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">View pending appointments.</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <!-- FIXED BUTTON (remove href and point to the correct modal ID) -->
                               <button type="button" class="btn btn-info btn-block text-white" data-bs-toggle="modal" data-bs-target="#viewAppointmentsModal">
                                     View Booked Appointments
                                </button>

                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0"><i class="fas fa-file-medical mr-2"></i>Medical History</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Access your complete medical history and records.</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('patient.medical_history.index') }}" class="btn btn-success btn-block" data-toggle="modal" data-target="#medicalHistoryModal">
                                View Medical History
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Book Appointment Modal -->
<div class="modal fade" id="bookAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="bookAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="bookAppointmentModalLabel">Book New Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('patient.appointments.store') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="appointment_date">Appointment Date</label>
                            <input type="date" class="form-control" name="appointment_date" id="appointment_date" required>
                            @error('appointment_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="appointment_time">Appointment Time</label>
                            <input type="time" class="form-control" name="appointment_time" id="appointment_time" required>
                            @error('appointment_time')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="reason">Reason for Appointment</label>
                        <textarea class="form-control" name="reason" id="reason" rows="3" required></textarea>
                        @error('reason')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Book Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Pending Appointments Modal -->
<div class="modal fade" id="viewAppointmentsModal" tabindex="-1" aria-labelledby="viewAppointmentsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title fw-bold" id="viewAppointmentsModalLabel">
                    <i class="fas fa-calendar-alt me-2"></i>View Appointments
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                 <div class="modal-body">
                <div class="mb-4">
                    <form method="GET" action="{{ route('patient.appointments.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <select name="appointment_status" class="form-select">
                                     <option value="">All Statuses</option>
                                    <option value="pending" {{ request('appointment_status') == 'pending' ? 'selected' : '' }}>pending</option>
                                    <option value="upcoming" {{ request('appointment_status') == 'upcoming' ? 'selected' : '' }}>upcoming</option>
                                    <option value="Completed" {{ request('appointment_status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                            <div class="col-md-2 text-end">
                                <button class="btn btn-success" type="submit">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Patient Name</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Reason</th>
                                <th>Status</th>
                               <!--  <th class="text-end">Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($appointments) && $appointments->count() > 0)
                                @foreach($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->id ?? 'N/A' }}</td>
                                        <td>{{ $appointment->patient->name ?? 'N/A' }}</td>
                                        <td>{{ $appointment->appointment_date?->format('Y-m-d') ?? 'N/A' }}</td>
                                        <td>{{ $appointment->appointment_time ?? 'N/A' }}</td>
                                        <td>{{ $appointment->reason ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $appointment->status === 'Scheduled' ? 'primary' : ($appointment->status === 'Confirmed' ? 'success' : ($appointment->status === 'Completed' ? 'info' : ($appointment->status === 'Cancelled' ? 'danger' : 'warning'))) }}">
                                                {{ $appointment->status ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                               
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="8" class="text-center">No appointments found</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Medical History Modal -->
<div class="modal fade" id="medicalHistoryModal" tabindex="-1" role="dialog" aria-labelledby="medicalHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="medicalHistoryModalLabel">Medical History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
           <div class="modal-body">
    @if(isset($medicalRecords))
        @if($medicalRecords->isEmpty())
            <div class="alert alert-info">No medical records found.</div>
        @else
            <div class="accordion" id="medicalRecordsAccordion">
                @foreach($medicalRecords as $index => $record)
                    <div class="card mb-2">
                        <div class="card-header" id="heading{{ $index }}">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                    <i class="fas fa-file-medical mr-2"></i>
                                    <strong>{{ $record->created_at->format('Y-m-d') }}</strong> - Medical Record
                                </button>
                            </h2>
                        </div>

                        <div id="collapse{{ $index }}" class="collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-parent="#medicalRecordsAccordion">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Date:</strong> {{ $record->created_at->format('Y-m-d') }}</p>
                                        {{-- <p><strong>Doctor:</strong> {{ $record->doctor->name ?? 'Not Available' }}</p> --}}
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Diagnosis:</strong> {{ $record->diagnosis ?? 'Not Available' }}</p>
                                        <p><strong>Treatment:</strong> {{ $record->treatment ?? 'Not Available' }}</p>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <p><strong>Notes:</strong></p>
                                    <p class="text-muted">{{ $record->notes }}</p>
                                </div>
                                @if($record->prescriptions && count($record->prescriptions) > 0)
                                    <div class="mt-3">
                                        <p><strong>Prescriptions:</strong></p>
                                        <ul class="list-group">
                                            @foreach($record->prescriptions as $prescription)
                                                <li class="list-group-item">
                                                    <strong>{{ $prescription->medication }}</strong> - {{ $prescription->dosage }} - {{ $prescription->instructions }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @else
        <div class="alert alert-warning">Medical records are not available at the moment.</div>
    @endif

    <p class="text-muted mt-3">
        Note: You can view your medical history, but only authorized staff can update or modify these records.
    </p>
</div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
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
                            <li><i class="fas fa-envelope mr-2"></i> support@bitstudentsclinic.com</li>
                            <li><i class="fas fa-phone mr-2"></i> +251 911 123 456</li>
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

@push('styles')
<style>
    #patient-dashboard-wrapper {
        overflow-x: hidden;
    }
    
    #sidebar-wrapper {
        min-height: 100vh;
        transition: margin 0.25s ease-out;
    }
    
    #page-content-wrapper {
        min-width: 0;
        width: 100%;
    }
    
    #menu-toggle {
        cursor: pointer;
    }
    
    .list-group-item.active {
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .card {
        transition: transform 0.2s;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .accordion .card-header {
        background-color: #f8f9fa;
    }
    
    @media (max-width: 768px) {
        #sidebar-wrapper {
            margin-left: -250px;
        }
        
        #patient-dashboard-wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Toggle sidebar
    document.getElementById("menu-toggle").addEventListener("click", function(e) {
        e.preventDefault();
        document.getElementById("patient-dashboard-wrapper").classList.toggle("toggled");
    });
    
    // Initialize tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@endpush

@endsection
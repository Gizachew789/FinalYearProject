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
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <button class="btn btn-primary" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle mr-1"></i> Welcome, {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Profile</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Settings</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                               <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    </li>
                </ul>
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
                            <h5 class="card-title mb-0"><i class="fas fa-clock mr-2"></i>Pending Appointments</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">View and manage your pending appointment requests.</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('patient.appointments.index') }}" class="btn btn-info btn-block text-white" data-toggle="modal" data-target="#pendingAppointmentsModal">
                                View Pending Appointments
                            </a>
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
<div class="modal fade" id="pendingAppointmentsModal" tabindex="-1" role="dialog" aria-labelledby="pendingAppointmentsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="pendingAppointmentsModalLabel">Pending Appointments</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($pendingAppointments->isEmpty())
                    <div class="alert alert-info">You have no pending appointments.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingAppointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->appointment_date }}</td>
                                        <td>{{ $appointment->appointment_time }}</td>
                                        <td>{{ $appointment->reason }}</td>
                                        <td><span class="badge badge-warning">Pending</span></td>
                                        <td>
                                            <form method="POST" action="{{ route('patient.appointments.cancel', $appointment->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                                    Cancel
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                @if($medicalRecords->isEmpty())
                    <div class="alert alert-info">No medical records found.</div>
                @else
                    <div class="accordion" id="medicalRecordsAccordion">
                        @foreach($medicalRecords as $index => $record)
                            <div class="card mb-2">
                                <div class="card-header" id="heading{{ $index }}">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                            <i class="fas fa-file-medical mr-2"></i><strong>{{ $record->created_at->format('Y-m-d') }}</strong> - Medical Record
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapse{{ $index }}" class="collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-parent="#medicalRecordsAccordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Date:</strong> {{ $record->created_at->format('Y-m-d') }}</p>
                                                <p><strong>Doctor:</strong> {{ $record->doctor->name ?? 'Not Available' }}</p>
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
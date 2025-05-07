@extends('layouts.app')

@section('content')
<!-- Patient Dashboard Wrapper -->
<div class="d-flex" id="patient-dashboard-wrapper">
    <!-- Sidebar -->
    <div class="bg-dark text-white" id="sidebar-wrapper" style="min-width: 250px; min-height: calc(100vh - 72px);">
        <div class="sidebar-heading p-3 border-bottom">
            <h5 class="m-0">Patient Panel</h5>
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ route('patient.dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white border-light active">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a href="{{ url('/') }}" class="list-group-item list-group-item-action bg-dark text-white border-light">
                <i class="fas fa-home me-2"></i> Home
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white border-light" data-bs-toggle="modal" data-bs-target="#settingsModal">
                <i class="fas fa-cog me-2"></i> Settings
            </a>
            <a href="{{ route('logout') }}" class="list-group-item list-group-item-action bg-dark text-white border-light" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper" class="w-100" style="margin-left: 250px;">
        <!-- Patient Header -->
        <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom mb-4 fixed-top" style="width: calc(100% - 250px); margin-left: 250px; z-index: 900;">
            <div class="container-fluid">
                <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-bell me-1"></i>
                                <span class="badge bg-danger rounded-pill">1</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Upcoming appointment reminder</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">View all notifications</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav> -->

        <!-- Original Dashboard Content with padding for fixed header -->
        <div class="container mx-auto p-4" style="margin-top: 70px;">
            <h1 class="text-3xl mb-6 text-center text-gray-10">Patient Dashboard</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Book Appointment --}}
                <div class="bg-blue-100 rounded-lg shadow-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-3">Book an Appointment</h3>
                    <p class="text-gray-700 mb-4">Schedule your next appointment with our healthcare professionals.</p>
                    <a href="{{ route('patient.appointments.create') }}" data-bs-toggle="modal" data-bs-target="#bookAppointmentModal" 
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-3 rounded transition">
                        Book Appointment
                    </a>
                </div>
                
                {{-- Pending Appointments --}}
                <div class="bg-yellow-100 rounded-lg shadow-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-3">Pending Appointments</h3>
                    <p class="text-gray-700 mb-4">View and manage your pending appointment requests.</p>
                    <a href="{{ route('patient.appointments.index') }}" data-bs-toggle="modal" data-bs-target="#pendingAppointmentsModal" 
                        class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-semibold px-6 py-3 rounded transition">
                        View Pending Appointments
                    </a>
                </div>
                
                {{-- Medical History --}}
                <div class="bg-green-100 rounded-lg shadow-lg p-6 text-center">
                    <h3 class="text-xl font-semibold mb-3">Medical History</h3>
                    <p class="text-gray-700 mb-4">Access your complete medical history and records.</p>
                    <a href="{{ route('patient.medical_history.index') }}" data-bs-toggle="modal" data-bs-target="#medicalHistoryModal" 
                        class="inline-block bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-6 py-3 rounded transition">
                        View Medical History
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Book Appointment Modal -->
<div class="modal fade" id="bookAppointmentModal" tabindex="-1" aria-labelledby="bookAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue-600 text-white">
                <h5 class="modal-title" id="bookAppointmentModalLabel">Book New Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('patient.appointments.store') }}">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="appointment_date" class="form-label">Appointment Date</label>
                            <input type="date" name="appointment_date" id="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror" required>
                            @error('appointment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="appointment_time" class="form-label">Appointment Time</label>
                            <input type="time" name="appointment_time" id="appointment_time" class="form-control @error('appointment_time') is-invalid @enderror" required>
                            @error('appointment_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason for Appointment</label>
                        <textarea name="reason" id="reason" rows="3" class="form-control @error('reason') is-invalid @enderror" required></textarea>
                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Book Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Pending Appointments Modal -->
<div class="modal fade" id="pendingAppointmentsModal" tabindex="-1" aria-labelledby="pendingAppointmentsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-yellow-600 text-white">
                <h5 class="modal-title" id="pendingAppointmentsModalLabel">Pending Appointments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($pendingAppointments->isEmpty())
                    <div class="alert alert-info">You have no pending appointments.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingAppointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->appointment_date }}</td>
                                        <td>{{ $appointment->appointment_time }}</td>
                                        <td>{{ $appointment->reason }}</td>
                                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                                        <td>
                                            <form method="POST" action="{{ route('patient.appointments.cancel', $appointment->id) }}" class="d-inline">
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Medical History Modal -->
<div class="modal fade" id="medicalHistoryModal" tabindex="-1" aria-labelledby="medicalHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-green-600 text-white">
                <h5 class="modal-title" id="medicalHistoryModalLabel">Medical History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($medicalRecords->isEmpty())
                    <div class="alert alert-info">No medical records found.</div>
                @else
                    <div class="accordion" id="medicalRecordsAccordion">
                        @foreach($medicalRecords as $index => $record)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                        <strong>{{ $record->created_at->format('Y-m-d') }}</strong> - Medical Record
                                    </button>
                                </h2>
                                <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#medicalRecordsAccordion">
                                    <div class="accordion-body">
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
                                            <p>{{ $record->notes }}</p>
                                        </div>
                                        @if($record->prescriptions && count($record->prescriptions) > 0)
                                            <div class="mt-3">
                                                <p><strong>Prescriptions:</strong></p>
                                                <ul class="list-group">
                                                    @foreach($record->prescriptions as $prescription)
                                                        <li class="list-group-item">
                                                            {{ $prescription->medication }} - {{ $prescription->dosage }} - {{ $prescription->instructions }}
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
                <p class="mt-3 text-muted">
                    Note: You can view your medical history, but only authorized staff can update or modify these records.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-black text-white p-6 mt-5">
    <div class="container mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <h3 class="text-lg font-bold mb-2">BiT Students Clinic</h3>
                <p class="text-gray-400">Providing quality healthcare for students</p>
            </div>
            <div class="flex space-x-6">
                <div>
                    <h4 class="font-semibold mb-2">Quick Links</h4>
                    <ul class="space-y-1">
                        <li><a href="{{ url('/') }}" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('patient.dashboard') }}" class="text-gray-400 hover:text-white transition">Dashboard</a></li>
                        <li>
                            <a href="{{ route('logout') }}" class="text-gray-400 hover:text-white transition" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-2">Contact</h4>
                    <ul class="space-y-1">
                        <li class="text-gray-400">support@bitstudentsclinic.com</li>
                        <li class="text-gray-400">+251 911 123 456</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-6 pt-6 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} BiT Students Clinic. All rights reserved.</p>
        </div>
    </div>
</footer>

@push('scripts')
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    // Toggle sidebar
    document.getElementById("menu-toggle").addEventListener("click", function(e) {
        e.preventDefault();
        var wrapper = document.getElementById("patient-dashboard-wrapper");
        wrapper.classList.toggle("toggled");
        
        if (wrapper.classList.contains("toggled")) {
            document.getElementById("sidebar-wrapper").style.left = "-250px";
            document.getElementById("page-content-wrapper").style.marginLeft = "0";
        } else {
            document.getElementById("sidebar-wrapper").style.left = "0";
            document.getElementById("page-content-wrapper").style.marginLeft = "250px";
        }
    });
</script>
@endpush
@endsection

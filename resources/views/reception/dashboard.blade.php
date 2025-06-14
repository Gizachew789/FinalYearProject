{{-- resources/views/reception/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<!-- Reception Dashboard Wrapper -->
<div id="reception-dashboard-wrapper" class="d-flex">
    <!-- Sidebar -->
   <div id="sidebar-wrapper" class="bg-dark text-white" style="width: 100px; min-height: 0; transition: all 0.3s;">
    <div class="sidebar-heading p-3">
        <h5 class="fw-bold text-center m-0">Reception Panel</h5>
    </div>
    <div class="list-group list-group-flush">
        <a href="{{ route('reception.dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white py-2 border-bottom">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white py-2 border-bottom" data-bs-toggle="modal" data-bs-target="#registerPatientModal">
            <i class="fas fa-user-plus me-2"></i> Register Patient
        </a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white py-2 border-bottom" data-bs-toggle="modal" data-bs-target="#bookAppointmentModal">
            <i class="fas fa-calendar-plus me-2"></i> Book Appointment
        </a>
        <a href="#" class="list-group-item list-group-item-action bg-dark text-white py-2 border-bottom" data-bs-toggle="modal" data-bs-target="#viewAppointmentsModal">
            <i class="fas fa-calendar-alt me-2"></i> View Appointments
        </a>
        <a href="{{ route('admin.patients.index') }}" class="list-group-item list-group-item-action bg-dark text-white py-2">
            <i class="fas fa-users-cog me-2"></i> Patient Management
        </a>
    </div>
</div>

    <!-- Page Content -->
    <div id="page-content-wrapper" style="width: calc(100% - 250px);">
        <!-- reception Header -->
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

        <!-- Original Dashboard Content -->
        <div class="container-fluid p-4">
            <h1 class="mb-4 fw-bold text-primary">Reception Dashboard</h1>

            <div class="row g-4">
                {{-- Register New Patient --}}
                <div class="col-md-4">
                    <div class="card h-100 border-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title fw-bold text-primary mb-0">
                                    <i class="fas fa-user-plus me-2"></i>Patient Registration
                                </h5>
                                <div class="bg-primary bg-opacity-10 p-2 rounded">
                                    <i class="fas fa-user-plus text-primary fs-4"></i>
                                </div>
                            </div>
                            <p class="card-text text-muted">
                                Register new patients and manage their information easily.
                            </p>
                            <a href="#" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#registerPatientModal">
                                <i class="fas fa-plus me-2"></i>Register Patient
                            </a>
                        </div>
                    </div>
                </div>
                
                {{-- Book Appointment --}}
                <div class="col-md-4">
                    <div class="card h-100 border-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title fw-bold text-success mb-0">
                                    <i class="fas fa-calendar-plus me-2"></i>Book Appointment
                                </h5>
                                <div class="bg-success bg-opacity-10 p-2 rounded">
                                    <i class="fas fa-calendar-plus text-success fs-4"></i>
                                </div>
                            </div>
                            <p class="card-text text-muted">Find registered patients and schedule their appointments easily.</p>
                            <a href="#" class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#bookAppointmentModal">
                                <i class="fas fa-calendar-plus me-2"></i>Book Appointment
                            </a>
                        </div>
                    </div>
                </div>
                
                {{-- See Appointment --}}
                <div class="col-md-4">
                    <div class="card h-100 border-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title fw-bold text-info mb-0">
                                    <i class="fas fa-calendar-alt me-2"></i>View Appointments
                                </h5>
                                <div class="bg-info bg-opacity-10 p-2 rounded">
                                    <i class="fas fa-calendar-alt text-info fs-4"></i>
                                </div>
                            </div>
                            <p class="card-text text-muted">Show and manage upcoming appointments easily.</p>
                            <a href="#" class="btn btn-info text-white mt-3" data-bs-toggle="modal" data-bs-target="#viewAppointmentsModal">
                                <i class="fas fa-eye me-2"></i>View Appointments
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats Section -->
           <!--  <div class="row mt-4 g-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Today's Appointments</h6>
                                    <h3 class="card-title fw-bold">24</h3>
                                </div>
                                <i class="fas fa-calendar-day fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Registered Patients</h6>
                                    <h3 class="card-title fw-bold">1,245</h3>
                                </div>
                                <i class="fas fa-users fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Pending Appointments</h6>
                                    <h3 class="card-title fw-bold">8</h3>
                                </div>
                                <i class="fas fa-clock fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Cancelled Today</h6>
                                    <h3 class="card-title fw-bold">2</h3>
                                </div>
                                <i class="fas fa-times-circle fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            Recent Activity Section
            <div class="card mt-4">
                <div class="card-header bg-white">
                    <h5 class="fw-bold mb-0"><i class="fas fa-history me-2"></i>Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Time</th>
                                    <th>Activity</th>
                                    <th>Patient</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>10:30 AM</td>
                                    <td>New Registration</td>
                                    <td>John Smith (BDU1234567)</td>
                                    <td>Department: Software Engineering</td>
                                </tr>
                                <tr>
                                    <td>09:15 AM</td>
                                    <td>Appointment Booked</td>
                                    <td>Jane Doe (BDU7654321)</td>
                                    <td>With Dr. Smith on 2023-06-16</td>
                                </tr>
                                <tr>
                                    <td>Yesterday</td>
                                    <td>Appointment Completed</td>
                                    <td>Michael Johnson (BDU11223344)</td>
                                    <td>Diagnosis: Common Cold</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 -->
<!-- Patient Registration Modal -->
<div class="modal fade" id="registerPatientModal" tabindex="-1" aria-labelledby="registerPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="registerPatientModalLabel">
                    <i class="fas fa-user-plus me-2"></i>Register New Patient
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
                <form id="patientRegistrationForm" method="POST" action="{{ route('reception.register.patient.store') }}">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="id" class="form-label fw-bold">Patient ID</label>
                            <input type="text" class="form-control" name="id" id="id" placeholder="BDU1234567" required>
                            <small class="text-muted">Format: BDU followed by 7 digits</small>
                            @error('id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label fw-bold">Full Name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label fw-bold">Gender</label>
                            <select class="form-select" name="gender" id="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="age" class="form-label fw-bold">Age</label>
                            <input type="number" class="form-control" name="age" id="age">
                            @error('age')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label fw-bold">Phone Number</label>
                            <input type="text" class="form-control" name="phone" id="phone" required>
                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-bold">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="department" class="form-label fw-bold">Department</label>
                            <input type="text" class="form-control" name="department" id="department">
                            @error('department')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="year_of_study" class="form-label fw-bold">Year of Study</label>
                            <input type="text" class="form-control" name="year_of_study" id="year_of_study">
                            @error('year_of_study')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Register Patient
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Book Appointment Modal -->
<div class="modal fade" id="bookAppointmentModal" tabindex="-1" aria-labelledby="bookAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="bookAppointmentModalLabel">
                    <i class="fas fa-calendar-plus me-2"></i>Book New Appointment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (session('appointment_success'))
                    <div class="alert alert-success">{{ session('appointment_success') }}</div>
                @endif
                
                <form id="appointmentBookingForm" method="POST" action="{{ route('reception.appointments.store') }}">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="patient_id" class="form-label fw-bold">Patient ID</label>
                            <input type="text" class="form-control" name="patient_id" id="patient_id" placeholder="BDU1234567" required>
                            <small class="text-muted">Enter registered patient ID</small>
                            @error('patient_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="appointment_date" class="form-label fw-bold">Appointment Date</label>
                            <input type="date" class="form-control" name="appointment_date" id="appointment_date" required>
                            @error('appointment_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="appointment_time" class="form-label fw-bold">Appointment Time</label>
                            <input type="time" class="form-control" name="appointment_time" id="appointment_time" required>
                            @error('appointment_time')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                    </div>
                    
                    <div class="mb-3">
                        <label for="reason" class="form-label fw-bold">Reason for Appointment</label>
                        <textarea class="form-control" name="reason" id="reason" rows="3" required></textarea>
                        @error('reason')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
            
                    
                    <div class="mb-3">
                        <label for="created_by" class="form-label fw-bold">Created By</label>
                        <input type="text" class="form-control bg-light" name="created_by" id="created_by" value="{{ Auth::user()->name }}" readonly>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Close
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-calendar-check me-2"></i>Book Appointment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Appointments Modal -->
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
                    <form method="GET" action="{{ route('reception.appointments.fetch') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <select name="appointment_status" class="form-select">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ request('appointment_status') == 'pending' ? 'selected' : '' }}>pending</option>
                                    <option value="upcoming" {{ request('appointment_status') == 'upcoming' ? 'selected' : '' }}>upcoming</option>
                                    <option value="Completed" {{ request('appointment_status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <!-- <option value="Cancelled" {{ request('appointment_status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="No Show" {{ request('appointment_status') == 'No Show' ? 'selected' : '' }}>No Show</option> -->
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
                                <th>Created By</th>
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
                                        <td>{{ $appointment->creator->name ?? 'N/A' }}</td>
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

<!-- Reception Footer -->
<!-- Footer -->
<footer class="bg-black text-white p-2 mt-5">
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
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition">Login</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-2">Contact</h4>
                    <ul class="space-y-1">
                        <li class="text-gray-400">info@bitstudentsclinic.com</li>
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
@endsection



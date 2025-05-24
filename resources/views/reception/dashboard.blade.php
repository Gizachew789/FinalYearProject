{{-- resources/views/reception/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<!-- Reception Dashboard Wrapper -->
<div id="reception-dashboard-wrapper" class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar-wrapper" class="bg-dark text-white" style="width: 250px; min-height: 100vh; transition: all 0.3s;">
        <div class="sidebar-heading p-4">
            <h5 class="fw-bold text-center">Reception Panel</h5>
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ route('reception.dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white py-3 border-bottom">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white py-3 border-bottom" data-bs-toggle="modal" data-bs-target="#registerPatientModal">
                <i class="fas fa-user-plus me-2"></i> Register Patient
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white py-3 border-bottom" data-bs-toggle="modal" data-bs-target="#bookAppointmentModal">
                <i class="fas fa-calendar-plus me-2"></i> Book Appointment
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white py-3 border-bottom" data-bs-toggle="modal" data-bs-target="#viewAppointmentsModal">
                <i class="fas fa-calendar-alt me-2"></i> View Appointments
            </a>
            <a href="{{ route('admin.patients.index') }}" class="list-group-item list-group-item-action bg-dark text-white py-3">
                <i class="fas fa-users-cog me-2"></i> Patient Management
            </a>
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper" style="width: calc(100% - 250px);">
        <!-- reception Header -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <button class="btn btn-dark d-lg-none" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="ms-auto d-flex align-items-center">
                    <span class="me-3 fw-bold">Welcome, {{ Auth::user()->name }}</span>
                    <div class="dropdown">
                        <button type="button" class="btn btn-light rounded-circle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle fs-4"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </li>
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
            <div class="row mt-4 g-4">
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
            
            <!-- Recent Activity Section -->
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
                        
                       <!--  <div class="col-md-6 mb-3">
                            <label for="doctor_id" class="form-label fw-bold">Doctor</label>
                            <select class="form-select" name="doctor_id" id="doctor_id" required>
                                <option value="">Select Doctor</option>
                                <option value="1">Dr. John Doe (General Physician)</option>
                                <option value="2">Dr. Jane Smith (Dermatologist)</option>
                                <option value="3">Dr. Michael Johnson (Pediatrician)</option>
                            </select>
                            @error('doctor_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div> -->
                    </div>
                    
                    <div class="mb-3">
                        <label for="reason" class="form-label fw-bold">Reason for Appointment</label>
                        <textarea class="form-control" name="reason" id="reason" rows="3" required></textarea>
                        @error('reason')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                   <!--  <div class="mb-3">
                        <label for="notes" class="form-label fw-bold">Additional Notes</label>
                        <textarea class="form-control" name="notes" id="notes" rows="2"></textarea>
                        @error('notes')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div> -->
                    
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
                    <div class="row g-3">
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" class="form-control" id="appointmentSearch" placeholder="Search appointments...">
                                <button type="button" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="appointmentDateFilter" placeholder="Filter by date">
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="appointmentStatusFilter">
                                <option value="">All Statuses</option>
                                <option value="scheduled">Scheduled</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold">APT001</td>
                                <td>John Smith <span class="text-muted">(BDU1234567)</span></td>
                                <td>Dr. Jane Doe</td>
                                <td>2023-06-15</td>
                                <td>10:30 AM</td>
                                <td><span class="badge bg-primary">Scheduled</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success me-1">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">APT002</td>
                                <td>Jane Doe <span class="text-muted">(BDU7654321)</span></td>
                                <td>Dr. John Smith</td>
                                <td>2023-06-16</td>
                                <td>02:00 PM</td>
                                <td><span class="badge bg-primary">Scheduled</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success me-1">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">APT003</td>
                                <td>Michael Johnson <span class="text-muted">(BDU11223344)</span></td>
                                <td>Dr. Michael Johnson</td>
                                <td>2023-06-17</td>
                                <td>03:30 PM</td>
                                <td><span class="badge bg-primary">Scheduled</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success me-1">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">APT004</td>
                                <td>Sarah Williams <span class="text-muted">(BDU55667788)</span></td>
                                <td>Dr. Jane Smith</td>
                                <td>2023-06-14</td>
                                <td>09:00 AM</td>
                                <td><span class="badge bg-success">Completed</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">APT005</td>
                                <td>David Brown <span class="text-muted">(BDU33445566)</span></td>
                                <td>Dr. John Doe</td>
                                <td>2023-06-13</td>
                                <td>11:45 AM</td>
                                <td><span class="badge bg-danger">Cancelled</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <nav aria-label="Appointments pagination">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Reception Footer -->
<footer class="bg-dark text-white py-4 mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <h3 class="fw-bold text-primary">BiT Students Clinic</h3>
                <p class="text-muted">Providing quality healthcare for students</p>
                <div class="social-icons mt-3">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <h4 class="fw-bold">Quick Links</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ url('/') }}" class="text-white text-decoration-none"><i class="fas fa-home me-2"></i>Home</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none"><i class="fas fa-info-circle me-2"></i>About Us</a></li>
                    <li class="mb-2"><a href="#" class="text-white text-decoration-none"><i class="fas fa-envelope me-2"></i>Contact</a></li>
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <h4 class="fw-bold">Contact</h4>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Bahir Dar University, Bahir Dar, Ethiopia</li>
                    <li class="mb-2"><i class="fas fa-envelope me-2"></i> support@bitstudentsclinic.com</li>
                    <li class="mb-2"><i class="fas fa-phone me-2"></i> +251 911 123 456</li>
                    <li><i class="fas fa-clock me-2"></i> Mon-Fri: 8:00 AM - 5:00 PM</li>
                </ul>
            </div>
        </div>
        <hr class="my-4 bg-secondary">
        <div class="text-center">
            <p class="mb-0">&copy; {{ date('Y') }} BiT Students Clinic. All rights reserved.</p>
        </div>
    </div>
</footer>

@push('styles')
<style>
    #reception-dashboard-wrapper {
        overflow-x: hidden;
    }
    
    #sidebar-wrapper {
        min-height: 100vh;
        margin-left: 0;
        transition: margin 0.25s ease-out;
    }
    
    #page-content-wrapper {
        min-width: 0;
        width: 100%;
    }
    
    .list-group-item-action:hover {
        background-color: #343a40;
        color: #fff;
    }
    
    .card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
        border-bottom: none;
        background-color: #f8f9fa;
    }
    
    .table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }
    
    .btn {
        border-radius: 5px;
        font-weight: 500;
    }
    
    .form-control, .form-select {
        border-radius: 5px;
        padding: 0.5rem 0.75rem;
    }
    
    .modal-header {
        border-radius: 0;
    }
    
    @media (max-width: 768px) {
        #sidebar-wrapper {
            margin-left: -250px;
        }
        
        #reception-dashboard-wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }
        
        #page-content-wrapper {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    // Toggle sidebar
    document.getElementById("menu-toggle").addEventListener("click", function(e) {
        e.preventDefault();
        var wrapper = document.getElementById("reception-dashboard-wrapper");
        wrapper.classList.toggle("toggled");
        
        if (wrapper.classList.contains("toggled")) {
            document.getElementById("sidebar-wrapper").style.left = "-250px";
            document.getElementById("page-content-wrapper").style.marginLeft = "0";
            document.querySelector("nav.navbar").style.width = "100%";
            document.querySelector("nav.navbar").style.marginLeft = "0";
            document.querySelector("footer").style.marginLeft = "0";
        } else {
            document.getElementById("sidebar-wrapper").style.left = "0";
            document.getElementById("page-content-wrapper").style.marginLeft = "250px";
            document.querySelector("nav.navbar").style.width = "calc(100% - 250px)";
            document.querySelector("nav.navbar").style.marginLeft = "250px";
            document.querySelector("footer").style.marginLeft = "250px";
        }
    });   
    
    // Handle form submission with AJAX
    document.getElementById('patientRegistrationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                const successAlert = document.createElement('div');
                successAlert.className = 'alert alert-success';
                successAlert.innerHTML = `<i class="fas fa-check-circle me-2"></i> ${data.success}`;
                
                const modalBody = document.querySelector('.modal-body');
                modalBody.insertBefore(successAlert, modalBody.firstChild);
                
                // Reset form
                form.reset();
                
                // Close modal after 2 seconds
                setTimeout(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('registerPatientModal'));
                    modal.hide();
                    
                    // Remove success message after modal closes
                    successAlert.remove();
                }, 2000);
            } else if (data.errors) {
                // Display validation errors
                Object.keys(data.errors).forEach(field => {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('is-invalid');
                        
                        const feedback = document.createElement('div');
                        feedback.className = 'invalid-feedback';
                        feedback.textContent = data.errors[field][0];
                        
                        const parent = input.parentElement;
                        const existingFeedback = parent.querySelector('.invalid-feedback');
                        if (existingFeedback) {
                            existingFeedback.remove();
                        }
                        
                        parent.appendChild(feedback);
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
    
    // Clear validation errors when input changes
    document.querySelectorAll('#patientRegistrationForm input, #patientRegistrationForm select').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const feedback = this.parentElement.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.remove();
            }
        });
    });
    
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
@endsection



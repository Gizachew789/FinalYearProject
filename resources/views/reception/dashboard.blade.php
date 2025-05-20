{{-- resources/views/reception/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<!-- Reception Dashboard Wrapper -->
<div class="d-flex" id="reception-dashboard-wrapper">
    <!-- Sidebar -->
    <div class="bg-dark text-white" id="sidebar-wrapper" style="min-width: 250px; min-height: calc(100vh - 72px);">
        <div class="sidebar-heading p-3 border-bottom">
            <h5 class="m-0">Reception Panel</h5>
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ route('reception.dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white border-light active">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white border-light" data-bs-toggle="modal" data-bs-target="#registerPatientModal">
                <i class="fas fa-user-plus me-2"></i> Register Patient
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white border-light" data-bs-toggle="modal" data-bs-target="#bookAppointmentModal">
                <i class="fas fa-calendar-plus me-2"></i> Book Appointment
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white border-light" data-bs-toggle="modal" data-bs-target="#viewAppointmentsModal">
                <i class="fas fa-calendar-check me-2"></i> View Appointments
            </a>
            <a href="{{ route('admin.patients.index') }}" class="list-group-item list-group-item-action bg-dark text-white border-light">
                <i class="fas fa-users me-2"></i> Patient Management
            </a>
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper" class="w-100" style="margin-left: 250px;">
        <!-- reception Header -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom mb-4">
            <div class="container-fluid">
                <!-- <button class="btn btn-primary" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button> -->
                <div class="ms-auto d-flex align-items-center">
                    <span class="me-3">Welcome, {{ Auth::user()->name }}</span>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Original Dashboard Content with padding for fixed header -->
        <div class="container mx-auto p-4" style="margin-top: 70px;">
            <h1 class="text-3xl mb-6 text-center text-gray-10">Reception Dashboard</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Register New Patient --}}
                <div class="bg-brown rounded-lg shadow-lg p-6 text-center">
                    <p>
                        <span class="text-gray-200 mb-4">Register new patients and manage their information easily.</span>
                    </p>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#registerPatientModal" 
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-black text-sm font-semibold px-6 py-3 rounded transition">
                        Register Patient
                    </a>
                </div>
                {{-- Book Appointment --}}
                <div class="bg-gray rounded-lg shadow-lg p-3 text-center">
                    <p class="text-gray-200 mb-4">Find registered patients and schedule their appointments easily.</p>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#bookAppointmentModal" 
                        class="inline-block bg-green-600 hover:bg-green-100 text-black text-sm font-semibold px-6 py-3 rounded transition">
                        Book Appointment
                    </a>
                </div>
                {{-- See Appointment --}}
                <div class="bg-purple rounded-lg shadow-lg p-3 text-center">
                    <p class="text-gray-200 mb-4">Show and manage upcoming appointments easily.</p>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#viewAppointmentsModal" 
                        class="inline-block bg-green-600 hover:bg-green-100 text-black text-sm font-semibold px-6 py-3 rounded transition">
                        See Appointment
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Patient Registration Modal -->
<div class="modal fade" id="registerPatientModal" tabindex="-1" aria-labelledby="registerPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue-600 text-white">
                <h5 class="modal-title" id="registerPatientModalLabel">Register New Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
                <form id="patientRegistrationForm" method="POST" action="{{ route('reception.register.patient.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="id" class="form-label">Patient ID</label>
                            <input type="text" name="id" id="id" class="form-control @error('id') is-invalid @enderror" 
                                   placeholder="BDU1234567" required>
                            <small class="text-muted">Format: BDU followed by 7 digits</small>
                            @error('id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" name="age" id="age" class="form-control @error('age') is-invalid @enderror">
                            @error('age')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" name="department" id="department" class="form-control @error('department') is-invalid @enderror">
                            @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="year_of_study" class="form-label">Year of Study</label>
                            <input type="text" name="year_of_study" id="year_of_study" class="form-control @error('year_of_study') is-invalid @enderror">
                            @error('year_of_study')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Register Patient</button>
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
            <div class="modal-header bg-green-600 text-white">
                <h5 class="modal-title" id="bookAppointmentModalLabel">Book New Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if (session('appointment_success'))
                    <div class="alert alert-success">{{ session('appointment_success') }}</div>
                @endif
                
                <form id="appointmentBookingForm" method="POST" action="{{ route('reception.appointments.store') }}">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="patient_id" class="form-label">Patient ID</label>
                            <input type="text" name="patient_id" id="patient_id" class="form-control @error('patient_id') is-invalid @enderror" 
                                   placeholder="BDU1234567" required>
                            <small class="text-muted">Enter registered patient ID</small>
                            @error('patient_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="appointment_date" class="form-label">Appointment Date</label>
                            <input type="date" name="appointment_date" id="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror" required>
                            @error('appointment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="appointment_time" class="form-label">Appointment Time</label>
                            <input type="time" name="appointment_time" id="appointment_time" class="form-control @error('appointment_time') is-invalid @enderror" required>
                            @error('appointment_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="doctor_id" class="form-label">Doctor</label>
                            <select name="doctor_id" id="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                                <option value="">Select Doctor</option>
                                <option value="1">Dr. John Doe</option>
                                <option value="2">Dr. Jane Smith</option>
                                <option value="3">Dr. Michael Johnson</option>
                            </select>
                            @error('doctor_id')
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
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Additional Notes</label>
                        <textarea name="notes" id="notes" rows="2" class="form-control @error('notes') is-invalid @enderror"></textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="created_by" class="form-label">Created By</label>
                        <input type="text" name="created_by" id="created_by" value="{{ Auth::user()->name }}" class="form-control" readonly>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Book Appointment</button>
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
            <div class="modal-header bg-purple text-white">
                <h5 class="modal-title" id="viewAppointmentsModalLabel">View Appointments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" id="appointmentSearch" class="form-control" placeholder="Search appointments...">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <input type="date" id="appointmentDateFilter" class="form-control" placeholder="Filter by date">
                        </div>
                        <div class="col-md-4">
                            <select id="appointmentStatusFilter" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="scheduled">Scheduled</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
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
                                <td>APT001</td>
                                <td>John Smith (BDU1234567)</td>
                                <td>Dr. Jane Doe</td>
                                <td>2023-06-15</td>
                                <td>10:30 AM</td>
                                <td><span class="badge bg-success">Scheduled</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary me-2">View</a>
                                    <a href="#" class="btn btn-sm btn-success me-2">Complete</a>
                                    <a href="#" class="btn btn-sm btn-danger">Cancel</a>
                                </td>
                            </tr>
                            <tr>
                                <td>APT002</td>
                                <td>Jane Doe (BDU7654321)</td>
                                <td>Dr. John Smith</td>
                                <td>2023-06-16</td>
                                <td>02:00 PM</td>
                                <td><span class="badge bg-success">Scheduled</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary me-2">View</a>
                                    <a href="#" class="btn btn-sm btn-success me-2">Complete</a>
                                    <a href="#" class="btn btn-sm btn-danger">Cancel</a>
                                </td>
                            </tr>
                            <tr>
                                <td>APT003</td>
                                <td>Michael Johnson (BDU11223344)</td>
                                <td>Dr. Michael Johnson</td>
                                <td>2023-06-17</td>
                                <td>03:30 PM</td>
                                <td><span class="badge bg-success">Scheduled</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary me-2">View</a>
                                    <a href="#" class="btn btn-sm btn-success me-2">Complete</a>
                                    <a href="#" class="btn btn-sm btn-danger">Cancel</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reception Footer -->
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
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                         @csrf
                       </form>
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
                successAlert.textContent = data.success;
                
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
</script>
@endpush
@endsection



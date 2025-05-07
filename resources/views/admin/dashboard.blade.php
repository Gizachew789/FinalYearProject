
@extends('layouts.app')

@section('content')
<!-- Admin Dashboard Wrapper -->
<div class="d-flex" id="admin-dashboard-wrapper">
    <!-- Sidebar -->
    <div class="bg-dark text-white" id="sidebar-wrapper" style="min-width: 250px; min-height: calc(100vh - 72px);">
        <div class="sidebar-heading p-3 border-bottom">
            <h5 class="m-0">Admin Panel</h5>
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white border-light active">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white border-light" data-bs-toggle="modal" data-bs-target="#userManagementModal">
                <i class="fas fa-users me-2"></i> User Management
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white border-light" data-bs-toggle="modal" data-bs-target="#patientManagementModal">
                <i class="fas fa-user-injured me-2"></i> Patient Management
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white border-light" data-bs-toggle="modal" data-bs-target="#inventoryModal">
                <i class="fas fa-boxes me-2"></i> Inventory
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white border-light" data-bs-toggle="modal" data-bs-target="#appointmentsModal">
                <i class="fas fa-calendar-check me-2"></i> Appointments
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white border-light" data-bs-toggle="modal" data-bs-target="#attendanceModal">
                <i class="fas fa-clipboard-list me-2"></i> Attendance
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white border-light" data-bs-toggle="modal" data-bs-target="#reportsModal">
                <i class="fas fa-chart-line me-2"></i> Reports
            </a>
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper" class="w-100">
        <!-- Admin Header -->
     <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
        <!-- Notifications Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-bell me-1 text-dark"></i>
                <span class="badge bg-danger rounded-pill">3</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item text-dark" href="#">New patient registration</a></li>
                <li><a class="dropdown-item text-dark" href="#">Low inventory alert</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-dark" href="#">View all notifications</a></li>
            </ul>
        </li>

        <!-- User Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-dark" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-circle me-1 text-dark"></i> {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item text-dark" href="#">Profile</a></li>
                <li><a class="dropdown-item text-dark" href="#">Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-dark" href="{{ route('logout') }}"
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

        <!-- Original Dashboard Content -->
        <div class="container" role="main">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">{{ __('Admin Dashboard') }}</div>

                         <div class="card-body">
                            <!-- This component displays alert messages, such as success or error notifications -->
                            <!-- For customization or further details, refer to the documentation: https://laravel.com/docs/8.x/blade#components -->
                          

                            <div class="row">
                                @php
                                    $cards = [
                                        [
                                            'title' => 'Staff Management',
                                            'text' => 'Manage staff members including physicians, reception, lab technicians, and pharmacists.',
                                            'modal' => '#userManagementModal',
                                            'button' => 'Manage Staff',
                                            'class' => 'btn-primary'
                                        ],
                                        [
                                            'title' => 'Register New User',
                                            'text' => 'Add a new staff member to the system.',
                                            'modal' => '#registerUserModal',
                                            'button' => 'Register New User',
                                            'class' => 'btn-success'
                                        ],
                                        [
                                            'title' => 'Appointment Reports',
                                            'text' => 'View and generate reports related to appointments.',
                                            'modal' => '#appointmentReportsModal',
                                            'button' => 'Generate Appointment Reports',
                                            'class' => 'btn-info'
                                        ],
                                        [
                                            'title' => 'Inventory Reports',
                                            'text' => 'View and generate reports related to inventory.',
                                            'modal' => '#inventoryReportsModal',
                                            'button' => 'Generate Inventory Reports',
                                            'class' => 'btn-info'
                                        ],
                                        [
                                            'title' => 'Staff Performance Reports',
                                            'text' => 'View and generate reports related to staff performance.',
                                            'modal' => '#staffPerformanceModal',
                                            'button' => 'Generate Staff Performance Reports',
                                            'class' => 'btn-info'
                                        ],
                                        [
                                            'title' => 'Inventory Management',
                                            'text' => 'Manage and monitor inventory items.',
                                            'modal' => '#inventoryModal',
                                            'button' => 'Manage Inventory',
                                            'class' => 'btn-warning'
                                        ],
                                        [
                                            'title' => 'Attendance Management',
                                            'text' => 'Manage reception-related tasks and patient registrations.',
                                            'modal' => '#attendanceModal',
                                            'button' => 'Attendance Management',
                                            'class' => 'btn-secondary'
                                        ],
                                        [
                                            'title' => 'Patient Management',
                                            'text' => 'Manage patient-related tasks.',
                                            'modal' => '#patientManagementModal',
                                            'button' => 'Patient Management',
                                            'class' => 'btn-secondary'
                                        ],
                                    ];
                                @endphp
                            
                                @foreach ($cards as $card)
                                    <div class="col-md-4 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ __($card['title']) }}</h5>
                                                <p class="card-text">{{ __($card['text']) }}</p>
                                                <a href="#" data-bs-toggle="modal" data-bs-target="{{ $card['modal'] }}" class="btn {{ $card['class'] }}">{{ __($card['button']) }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                             @if(session('success'))
                              <div class="alert alert-success">
                                 {{ session('success') }}
                              </div>
                             @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- User Management Modal -->
<div class="modal fade" id="userManagementModal" tabindex="-1" aria-labelledby="userManagementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="userManagementModalLabel">User Management</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" id="userSearch" class="form-control" placeholder="Search users...">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select id="userRoleFilter" class="form-select">
                                <option value="">All Roles</option>
                                <option value="admin">Admin</option>
                                <option value="doctor">Doctor</option>
                                <option value="nurse">Nurse</option>
                                <option value="receptionist">Receptionist</option>
                                <option value="lab_technician">Lab Technician</option>
                                <option value="pharmacist">Pharmacist</option>
                            </select>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registerUserModal">
                                <i class="fas fa-user-plus me-1"></i> Add New User
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>john.doe@example.com</td>
                                <td>Admin</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>2023-01-15</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary me-1"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger me-1"><i class="fas fa-trash"></i></a>
                                    <a href="#" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jane Smith</td>
                                <td>jane.smith@example.com</td>
                                <td>Doctor</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>2023-02-20</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary me-1"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger me-1"><i class="fas fa-trash"></i></a>
                                    <a href="#" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Michael Johnson</td>
                                <td>michael.johnson@example.com</td>
                                <td>Receptionist</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>2023-03-10</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary me-1"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger me-1"><i class="fas fa-trash"></i></a>
                                    <a href="#" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <nav aria-label="User pagination">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Register User Modal -->
<div class="modal fade" id="registerUserModal" tabindex="-1" aria-labelledby="registerUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="registerUserModalLabel">Register New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userRegistrationForm" method="POST" action="{{ route('admin.register.user') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
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
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="doctor">Doctor</option>
                                <option value="nurse">Nurse</option>
                                <option value="receptionist">Receptionist</option>
                                <option value="lab_technician">Lab Technician</option>
                                <option value="pharmacist">Pharmacist</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea name="address" id="address" rows="2" class="form-control @error('address') is-invalid @enderror"></textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Register User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Patient Management Modal -->
<div class="modal fade" id="patientManagementModal" tabindex="-1" aria-labelledby="patientManagementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="patientManagementModalLabel">Patient Management</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" id="patientSearch" class="form-control" placeholder="Search patients...">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select id="patientStatusFilter" class="form-select">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registerPatientModal">
                                <i class="fas fa-user-plus me-1"></i> Add New Patient
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Registered</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>john.doe@example.com</td>
                                <td>123-456-7890</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>2023-01-15</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary me-1"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger me-1"><i class="fas fa-trash"></i></a>
                                    <a href="#" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jane Smith</td>
                                <td>jane.smith@example.com</td>
                                <td>987-654-3210</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>2023-02-20</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary me-1"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger me-1"><i class="fas fa-trash"></i></a>
                                    <a href="#" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Michael Johnson</td>
                                <td>michael.johnson@example.com</td>
                                <td>555-123-4567</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>2023-03-10</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary me-1"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger me-1"><i class="fas fa-trash"></i></a>
                                    <a href="#" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <nav aria-label="Patient pagination">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Register Patient Modal -->
<div class="modal fade" id="registerPatientModal" tabindex="-1" aria-labelledby="registerPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="registerPatientModalLabel">Register New Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="patientRegistrationForm" method="POST" action="{{ route('reception.register.patient') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="patient_name" class="form-label">Full Name</label>
                            <input type="text" name="patient_name" id="patient_name" class="form-control @error('patient_name') is-invalid @enderror" required>
                            @error('patient_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="patient_email" class="form-label">Email Address</label>
                            <input type="email" name="patient_email" id="patient_email" class="form-control @error('patient_email') is-invalid @enderror">
                            @error('patient_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="patient_phone" class="form-label">Phone Number</label>
                            <input type="text" name="patient_phone" id="patient_phone" class="form-control @error('patient_phone') is-invalid @enderror" required>
                            @error('patient_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="patient_address" class="form-label">Address</label>
                            <textarea name="patient_address" id="patient_address" rows="2" class="form-control @error('patient_address') is-invalid @enderror" required></textarea>
                            @error('patient_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="patient_status" class="form-label">Status</label>
                        <select name="patient_status" id="patient_status" class="form-select @error('patient_status') is-invalid @enderror" required>
                            <option value="">Select Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        @error('patient_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Register Patient</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Admin Footer -->
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
                        <li><a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white transition">Dashboard</a></li>
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
        document.getElementById("admin-dashboard-wrapper").classList.toggle("toggled");
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@endpush
@endsection


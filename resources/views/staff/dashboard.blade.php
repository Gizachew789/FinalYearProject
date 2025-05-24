@extends('layouts.app')

@section('content')
<div class="d-flex" id="staff-dashboard-wrapper">
    <!-- Modern Sidebar -->
    <div class="sidebar bg-dark text-white" id="sidebar-wrapper">
        <div class="sidebar-header p-4 bg-primary">
            <h4 class="mb-0 fw-bold">Staff Panel</h4>
        </div>
        <nav class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('staff.dashboard') }}" class="nav-link active">
                        <i class="bi bi-speedometer2 me-3"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('staff.appointments.show') }}" class="nav-link">
                        <i class="bi bi-calendar-check me-3"></i>
                        <span>Booked Appointments</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#medicalHistoryModal">
                        <i class="bi bi-file-medical me-3"></i>
                        <span>Medical History</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#uploadMedicalDocModal">
                        <i class="bi bi-cloud-arrow-up me-3"></i>
                        <span>Upload Documents</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#labResultsModal">
                        <i class="bi bi-droplet me-3"></i>
                        <span>Lab Results</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content Area -->
    <div class="main-content bg-light" id="page-content-wrapper">
        <!-- Top Navigation -->
        <nav class="navbar navbar-expand navbar-light bg-white shadow-sm">
            <div class="container-fluid px-4">
                <div class="ms-auto d-flex align-items-center">
                    <div class="me-3">
                        <span class="text-muted">Welcome back,</span>
                        <span class="fw-bold text-primary">{{ Auth::user()->name }}</span>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-light rounded-circle p-2 dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-4"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="bi bi-gear me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Dashboard Content -->
        <div class="container-fluid px-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-dark mb-0">Staff Dashboard</h2>
                <div class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                    <i class="bi bi-calendar3 me-2"></i>
                    {{ now()->format('F j, Y') }}
                </div>
            </div>

            <p class="text-muted mb-5">Manage patient care and clinic operations efficiently</p>

            <!-- Dashboard Cards -->
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                    <i class="bi bi-calendar-check fs-3 text-primary"></i>
                                </div>
                                <h5 class="mb-0">Appointments</h5>
                            </div>
                            <p class="text-muted mb-4">View and manage all patient appointments scheduled for today and upcoming dates.</p>
                            <a href="{{ route('staff.appointments.show') }}" class="btn btn-primary px-4">
                                View Appointments
                                <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                                    <i class="bi bi-file-medical fs-3 text-success"></i>
                                </div>
                                <h5 class="mb-0">Medical Records</h5>
                            </div>
                            <p class="text-muted mb-4">Access comprehensive patient medical histories and treatment records.</p>
                            <button class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#medicalHistoryModal">
                                View Records
                                <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                                    <i class="bi bi-droplet fs-3 text-warning"></i>
                                </div>
                                <h5 class="mb-0">Lab Results</h5>
                            </div>
                            <p class="text-muted mb-4">Review and analyze patient laboratory test results and diagnostics.</p>
                            <button class="btn btn-warning text-dark px-4" data-bs-toggle="modal" data-bs-target="#labResultsModal">
                                View Results
                                <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer mt-auto py-3 bg-dark text-white">
            <div class="container-fluid px-4">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h5 class="mb-2">BiT Students Clinic</h5>
                        <p class="small text-muted mb-0">Providing quality healthcare since {{ date('Y') - 5 }}</p>
                    </div>
                    <div class="col-md-3">
                        <h6 class="fs-sm mb-2">Quick Links</h6>
                        <ul class="list-unstyled small">
                            <li class="mb-1"><a href="{{ url('/') }}" class="text-muted hover-white">Home</a></li>
                            <li class="mb-1"><a href="{{ route('staff.dashboard') }}" class="text-muted hover-white">Dashboard</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h6 class="fs-sm mb-2">Contact</h6>
                        <ul class="list-unstyled small text-muted">
                            <li class="mb-1"><i class="bi bi-envelope me-2"></i>support@bitclinic.edu</li>
                            <li class="mb-1"><i class="bi bi-telephone me-2"></i>+251 911 123 456</li>
                        </ul>
                    </div>
                </div>
                <hr class="my-3 border-secondary">
                <div class="text-center small text-muted">
                    &copy; {{ date('Y') }} BiT Students Clinic. All rights reserved.
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- Modals -->
<!-- Lab Test Results Modal -->
<!-- Lab Test Results Modal -->
<div class="modal fade" id="labResultsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow">
            <!-- Modal Header -->
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title"><i class="bi bi-droplet me-2"></i>Lab Test Results</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body bg-light">

                <!-- Search Form -->
                <form action="{{ route('lab-results.search') }}" method="GET" class="w-100 mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="query" class="form-control" placeholder="Search by patient ID, name, or test..." required>
                        <button type="submit" class="btn btn-warning">
                            Search
                        </button>
                    </div>
                </form>

                <!-- Results Area -->
                <div id="patientLabResults" class="bg-white p-4 rounded shadow-sm">
                    <div class="text-center py-5">
                        <i class="bi bi-search fs-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">Search for a patient</h5>
                        <p class="text-muted">Enter patient details to view lab results</p>
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="medicalHistoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-file-medical me-2"></i>Medical History</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light">
                <div class="search-box mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" id="patientSearch" class="form-control" placeholder="Search by patient ID or name...">
                        <button class="btn btn-success" type="button" id="searchPatientBtn">
                            Search
                        </button>
                    </div>
                </div>
                
                <div id="patientMedicalHistory" class="bg-white p-4 rounded shadow-sm">
                    <div class="text-center py-5">
                        <i class="bi bi-search fs-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">Search for a patient</h5>
                        <p class="text-muted">Enter patient details to view medical history</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadMedicalDocModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-cloud-arrow-up me-2"></i>Upload Medical Document</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light">
                <div class="search-box mb-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" id="patientSearchUpload" class="form-control" placeholder="Search by patient ID or name...">
                        <button class="btn btn-primary" type="button" id="searchPatientUploadBtn">
                            Search
                        </button>
                    </div>
                </div>
                
                <div id="uploadMedicalDocForm" class="bg-white p-4 rounded shadow-sm">
                    <div class="text-center py-5">
                        <i class="bi bi-search fs-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">Search for a patient</h5>
                        <p class="text-muted">Enter patient details to upload documents</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    #staff-dashboard-wrapper {
        min-height: 100vh;
    }
    
    .sidebar {
        width: 250px;
        min-height: 100vh;
        transition: all 0.3s;
    }
    
    .sidebar-nav .nav-link {
        color: rgba(255, 255, 255, 0.8);
        padding: 12px 20px;
        border-left: 3px solid transparent;
        transition: all 0.2s;
    }
    
    .sidebar-nav .nav-link:hover {
        color: white;
        background: rgba(255, 255, 255, 0.1);
        border-left-color: var(--bs-primary);
    }
    
    .sidebar-nav .nav-link.active {
        color: white;
        background: rgba(255, 255, 255, 0.1);
        border-left-color: var(--bs-primary);
    }
    
    .sidebar-nav .nav-link i {
        width: 20px;
        text-align: center;
    }
    
    .main-content {
        width: calc(100% - 250px);
    }
    
    .hover-white:hover {
        color: white !important;
    }
    
    @media (max-width: 768px) {
        .sidebar {
            width: 80px;
        }
        
        .sidebar-header h4, 
        .sidebar-nav .nav-link span {
            display: none;
        }
        
        .sidebar-nav .nav-link {
            text-align: center;
            padding: 12px 5px;
        }
        
        .sidebar-nav .nav-link i {
            margin-right: 0;
            font-size: 1.2rem;
        }
        
        .main-content {
            width: calc(100% - 80px);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Toggle sidebar
    document.getElementById("menu-toggle")?.addEventListener("click", function(e) {
        e.preventDefault();
        document.getElementById("staff-dashboard-wrapper").classList.toggle("toggled");
    });
    
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush
@endsection
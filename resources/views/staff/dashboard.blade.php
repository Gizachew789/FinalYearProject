@extends('layouts.app')

@section('content')
<!-- Staff Dashboard Wrapper -->
<div class="d-flex" id="staff-dashboard-wrapper" style="background-color: #F4F6F9;">
    <!-- Sidebar -->
    <div class="text-white" id="sidebar-wrapper" style="min-width: 62.5px; min-height: 100vh; transition: all 0.3s ease; background-color: #333333;">
        <div class="sidebar-heading p-3 border-bottom" style="background-color: #4A90E2;">
            <h5 class="m-0">Staff Panel</h5>
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ route('staff.dashboard') }}" class="list-group-item list-group-item-action border-light active" style="background-color: #4A90E2; color: white;">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a href="{{ route('staff.appointments.show') }}" class="list-group-item list-group-item-action border-light" style="background-color: #333333; color: white; border-color: #7F8C8D;">
                <i class="fas fa-calendar-check me-2"></i> Booked Appointments
            </a>
            <a href="#" class="list-group-item list-group-item-action border-light" style="background-color: #333333; color: white; border-color: #7F8C8D;" data-bs-toggle="modal" data-bs-target="#medicalHistoryModal">
                <i class="fas fa-notes-medical me-2"></i> Medical History
            </a>
            <a href="#" class="list-group-item list-group-item-action border-light" style="background-color: #333333; color: white; border-color: #7F8C8D;" data-bs-toggle="modal" data-bs-target="#uploadMedicalDocModal">
                <i class="fas fa-file-medical me-2"></i> Upload Medical Document
            </a>
            <a href="#" class="list-group-item list-group-item-action border-light" style="background-color: #333333; color: white; border-color: #7F8C8D;" data-bs-toggle="modal" data-bs-target="#labResultsModal">
                <i class="fas fa-flask me-2"></i> Lab Test Results
            </a>
            <!-- <a href="{{ route('logout') }}" class="list-group-item list-group-item-action border-light" style="background-color: #333333; color: white; border-color: #7F8C8D;"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form> -->
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper" class="flex-grow-1" style="min-height: 100vh; display: flex; flex-direction: column; transition: all 0.3s ease; background-color: #F4F6F9;">
        <!-- Staff Header -->
        <nav class="navbar navbar-expand-lg navbar-light border-bottom mb-4" style="background-color: white;">
            <div class="container-fluid">
                <!-- <button class="btn" id="menu-toggle" style="background-color: #4A90E2; color: white;">
                    <i class="fas fa-bars"></i>
                </button> -->
                <div class="ms-auto d-flex align-items-center">
                    <span class="me-3" style="color: #333333;">Welcome, {{ Auth::user()->name }}</span>
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #F4F6F9; color: #333333; border: 1px solid #7F8C8D;">
                            <i class="fas fa-user-circle"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile') }}" style="color: #333333;">Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('settings') }}" style="color: #333333;">Settings</a></li>
                                 <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" style="color: ##333333;"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Original Dashboard Content -->
        <div class="container mx-auto p-4 flex-grow-1">
            <h1 class="text-3xl mb-6 text-center" style="color: #333333;">Staff Dashboard</h1>
            <p class="mb-4 text-center" style="color: #7F8C8D;">This is your shared staff dashboard for managing patient care.</p>

            <div class="row mt-5">
                <div class="col-md-4 mb-4">
                    <div class="card h-100" style="border: none; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <div class="card-body text-center">
                            <i class="fas fa-calendar-check fa-3x mb-3" style="color: #4A90E2;"></i>
                            <h5 class="card-title" style="color: #333333;">Booked Appointments</h5>
                            <p class="card-text" style="color: #7F8C8D;">View and manage all patient appointments</p>
                            <a href="{{ route('staff.appointments.show') }}" class="btn mt-3" style="background-color: #4A90E2; color: white;">
                                View Appointments
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100" style="border: none; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <div class="card-body text-center">
                            <i class="fas fa-notes-medical fa-3x mb-3" style="color: #50E3C2;"></i>
                            <h5 class="card-title" style="color: #333333;">Medical History</h5>
                            <p class="card-text" style="color: #7F8C8D;">Access patient medical records and history</p>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#medicalHistoryModal" class="btn mt-3" style="background-color: #4A90E2; color: white;">
                                View Medical History
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100" style="border: none; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <div class="card-body text-center">
                            <i class="fas fa-flask fa-3x mb-3" style="color: #F5A623;"></i>
                            <h5 class="card-title" style="color: #333333;">Lab Test Results</h5>
                            <p class="card-text" style="color: #7F8C8D;">View patient lab test results</p>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#labResultsModal" class="btn mt-3" style="background-color: #4A90E2; color: white;">
                                View Lab Results
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <footer class="p-1 mt-auto" style="background-color: #333333; color: white;">
            <div class="container mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-1 md:mb-0">
                        <h3 class="text-sm font-bold mb-0">BiT Students Clinic</h3>
                        <p style="color: #7F8C8D; font-size: 0.75rem;">Providing quality healthcare</p>
                    </div>
                    <div class="flex space-x-3">
                        <div>
                            <h4 class="font-semibold mb-0 text-sm">Quick Links</h4>
                            <ul class="space-y-0">
                                <li><a href="{{ url('/') }}" style="color: #7F8C8D; text-decoration: none; font-size: 0.75rem;" onmouseover="this.style.color='#4A90E2'" onmouseout="this.style.color='#7F8C8D'">Home</a></li>
                                <li><a href="{{ route('staff.dashboard') }}" style="color: #7F8C8D; text-decoration: none; font-size: 0.75rem;" onmouseover="this.style.color='#4A90E2'" onmouseout="this.style.color='#7F8C8D'">Dashboard</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-0 text-sm">Contact</h4>
                            <ul class="space-y-0">
                                <li style="color: #7F8C8D; font-size: 0.75rem;">support@bitstudentsclinic.com</li>
                                <li style="color: #7F8C8D; font-size: 0.75rem;">+251 911 123 456</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="border-t mt-1 pt-1 text-center" style="border-color: #7F8C8D; color: #7F8C8D;">
                    <p style="font-size: 0.75rem;">&copy; {{ date('Y') }} BiT Students Clinic. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</div>

@push('scripts')
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    // Toggle sidebar
    document.getElementById("menu-toggle").addEventListener("click", function(e) {
        e.preventDefault();
        var wrapper = document.getElementById("staff-dashboard-wrapper");
        wrapper.classList.toggle("toggled");
        
        if (wrapper.classList.contains("toggled")) {
            document.getElementById("sidebar-wrapper").style.marginLeft = "-62.5px";
            document.getElementById("page-content-wrapper").style.marginLeft = "0";
        } else {
            document.getElementById("sidebar-wrapper").style.marginLeft = "0";
            document.getElementById("page-content-wrapper").style.marginLeft = "62.5px";
        }
    });
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>
@endpush

<!-- Lab Results Modal -->
<div class="modal fade" id="labResultsModal" tabindex="-1" aria-labelledby="labResultsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #F5A623; color: white;">
                <h5 class="modal-title" id="labResultsModalLabel">Lab Test Results</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #F4F6F9;">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" id="patientSearchLab" class="form-control" placeholder="Search patient by ID or name...">
                                <button class="btn" type="button" id="searchPatientLabBtn" style="background-color: #4A90E2; color: white;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="patientLabResults">
                    <div class="alert" style="background-color: #F4F6F9; color: #7F8C8D; border: 1px solid #4A90E2;">
                        Please search for a patient to view their lab results.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #7F8C8D; color: white;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Medical History Modal -->
<div class="modal fade" id="medicalHistoryModal" tabindex="-1" aria-labelledby="medicalHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #50E3C2; color: white;">
                <h5 class="modal-title" id="medicalHistoryModalLabel">Patient Medical History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #F4F6F9;">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" id="patientSearch" class="form-control" placeholder="Search patient by ID or name...">
                                <button class="btn" type="button" id="searchPatientBtn" style="background-color: #4A90E2; color: white;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="patientMedicalHistory">
                    <div class="alert" style="background-color: #F4F6F9; color: #7F8C8D; border: 1px solid #4A90E2;">
                        Please search for a patient to view their medical history.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #7F8C8D; color: white;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Upload Medical Document Modal -->
<div class="modal fade" id="uploadMedicalDocModal" tabindex="-1" aria-labelledby="uploadMedicalDocModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #4A90E2; color: white;">
                <h5 class="modal-title" id="uploadMedicalDocModalLabel">Upload Medical Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #F4F6F9;">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" id="patientSearchUpload" class="form-control" placeholder="Search patient by ID or name...">
                                <button class="btn" type="button" id="searchPatientUploadBtn" style="background-color: #4A90E2; color: white;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="uploadMedicalDocForm">
                    <div class="alert" style="background-color: #F4F6F9; color: #7F8C8D; border: 1px solid #4A90E2;">
                        Please search for a patient to upload medical documents.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal" style="background-color: #7F8C8D; color: white;">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

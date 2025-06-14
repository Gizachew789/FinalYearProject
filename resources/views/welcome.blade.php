@extends('layouts.app')

@section('title', 'Student Clinic Management')

@section('content')
<div class="d-flex" id="dashboard-wrapper">
    <!-- Sidebar -->
    <!-- <div id="sidebar-wrapper" class="bg-dark text-white" style="width: 250px; min-height: 100vh;">
        <div class="sidebar-heading p-3">
            <h4 class="text-center text-white">BiT Students Clinic</h4>
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ url('/') }}" class="list-group-item list-group-item-action bg-dark text-white active">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </a>
  
            <a href="{{ route('reception.register.patient') }}" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-user-plus mr-2"></i> Patient Registration
            </a>
          
            <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-users-cog mr-2"></i> User Management
            </a>
          
            <a href="{{ route('reception.appointments.store') }}" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-calendar-check mr-2"></i> Appointments
            </a>
         
            <a href="{{ route('admin.reports.inventory') }}" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-pills mr-2"></i> Inventory
            </a>
            
            <a href="{{ route('admin.reports.inventory') }}" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-chart-bar mr-2"></i> Reports
            </a>
            @if(Auth::check() && Auth::user()->isAdmin())
            <a href="{{ route('admin.patients.index') }}" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-procedures mr-2"></i> Patient Management
            </a>
            @endif
        </div>
        <div class="px-3 my-3">
            <button class="btn btn-primary btn-block">
                <i class="fas fa-bolt mr-2"></i> Quick Actions
            </button>
        </div>
    </div> -->

    <!-- Page Content -->
    <div id="page-content-wrapper" class="w-100">
        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <!-- <button class="btn btn-light mr-2" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </button> -->
            
            <<!-- div class="d-flex flex-grow-1">
                <form action="{{ route('search') }}" method="GET" class="form-inline my-2 my-lg-0 w-100">
                    <div class="input-group w-100">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" name="query" class="form-control" placeholder="Search for patients, appointments..." aria-label="Search">
                    </div>
                </form>
            </div> -->
        </nav>

        <!-- Main Content -->
        <div class="container-fluid p-4">
            <h2 class="mb-4">Welcome to BiT Students Clinic Management System</h2>
            
            <!-- Welcome Banner -->
            <div class="card bg-light mb-4 border-primary">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <!-- <h3 class="card-title text-primary">Student Healthcare Management</h3> -->
                            <p class="card-text">
                                A comprehensive solution for managing student healthcare services, appointments, and medical records.
                            </p>
                            @guest
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                If You Are Authorized Personnel,
                               Please Login to Access System
                            </a>
                            @else
                            <span class="text-primary font-weight-bold">Welcome back, {{ Auth::user()->name }}!</span>
                            @endguest
                        </div>
                        <!-- <div class="col-md-4 text-center">
                            <img src="{{ asset('images/new-logo.jpg') }}" alt="Clinic Logo" class="rounded-circle" style="width: 100px; height: 100px;">
                        </div> -->
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <!-- <div class="row mb-4">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0"><i class="fas fa-user-plus mr-2"></i>Patient Registration</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Register new patients easily and manage their information</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('reception.register.patient') }}" class="btn btn-primary btn-block">
                                Register Patient
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0"><i class="fas fa-users-cog mr-2"></i>User Management</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Manage clinic staff and their permissions</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('admin.register.user') }}" class="btn btn-success btn-block text-white">
                                Manage Users
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0"><i class="fas fa-pills mr-2"></i>Inventory</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Track and manage medications and supplies</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('admin.reports.inventory') }}" class="btn btn-info btn-block text-white">
                                Manage Inventory
                            </a>
                        </div>
                    </div>
                </div>
            </div> -->
            
            <!-- Statistics Section -->
          
        </div>
        
        <!-- Footer -->
        <footer class="bg-dark text-white p-4 mt-auto">
            <div class="container">
                <div class="row">
                    <!-- <div class="col-md-4 mb-4 mb-md-0">
                        <h5>BiT Students Clinic</h5>
                        <p>Providing quality healthcare for students</p>
                    </div> -->
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="{{ url('/') }}" class="text-white">Home</a></li>
                            <li><a href="{{ route('login') }}" class="text-white">Login</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5>Contact</h5>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-envelope mr-2"></i> info@bitstudentsclinic.com</li>
                            <li><i class="fas fa-phone mr-2"></i> +123-456-7890</li>
                        </ul>
                    </div>
                </div>
                <hr class="bg-light">
                <div class="text-center">
                    <p class="mb-0">&copy; {{ date('Y') }} BiT Students Clinic. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</div>

@push('styles')
<style>
    #dashboard-wrapper {
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
    
    @media (max-width: 768px) {
        #sidebar-wrapper {
            margin-left: -250px;
        }
        
        #dashboard-wrapper.toggled #sidebar-wrapper {
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
        document.getElementById("dashboard-wrapper").classList.toggle("toggled");
    });
</script>
@endpush

@endsection
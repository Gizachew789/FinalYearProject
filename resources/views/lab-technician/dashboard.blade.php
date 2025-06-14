{{-- resources/views/lab_technician/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')

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


<div class="container mt-5">
    <h2 class="text-center mb-5">Lab Technician Dashboard</h2>

    <div class="row">
        {{-- View Lab Test Requests --}}
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-flask fa-3x text-primary"></i>
                    </div>
                    <h4 class="card-title text-primary mb-3">View Lab Test Requests</h4>
                    <p class="card-text text-muted mb-4">
                        Review and accept pending lab test requests submitted by Nurses and Health Officers.
                    </p>
                    <a href="{{ route('lab.requests.index') }}" 
                       class="btn btn-primary btn-lg px-4">
                        <i class="fas fa-list mr-2"></i> See Test Requests
                    </a>
                </div>
            </div>
        </div>

        {{-- Upload Lab Test Results --}}
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-upload fa-3x text-success"></i>
                    </div>
                    <h4 class="card-title text-success mb-3">Upload Lab Test Results</h4>
                    <p class="card-text text-muted mb-4">
                        Upload results for confirmed lab test requests to make them visible to Nurses and Health Officers.
                    </p>
                    <a href="{{ route('lab.results.create') }}" 
                       class="btn btn-success btn-lg px-4">
                        <i class="fas fa-cloud-upload-alt mr-2"></i> Upload Results
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(isset($patient) && count($patient->results) > 0)
    <div class="row mt-4">
        @foreach($patient->results as $result)
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-file-alt fa-3x text-info"></i>
                    </div>
                    <h4 class="card-title text-info mb-3">View Results: {{ $result->test_name }}</h4>
                    <p class="card-text text-muted mb-4">
                        Access and review the results of lab tests that have been uploaded.
                    </p>
                    <a href="{{ route('lab.results.index', ['patient_id'=> $patient->patient_id]) }}" 
                       class="btn btn-info btn-lg px-4">
                        <i class="fas fa-eye mr-2"></i> View Results
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
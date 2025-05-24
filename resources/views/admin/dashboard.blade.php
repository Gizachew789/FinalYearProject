@extends('layouts.app')

@section('content')
<!-- Admin Dashboard Wrapper -->
<div class="d-flex" id="admin-dashboard-wrapper">
    <!-- Sidebar -->
    <div class="bg-dark text-white border-end" id="sidebar-wrapper" style="min-width: 250px;">
        <div class="sidebar-heading p-3 border-bottom">
            <h5 class="m-0">Admin Panel</h5>
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action bg-primary text-white">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white" data-bs-toggle="modal" data-bs-target="#userManagementModal">
                <i class="fas fa-users me-2"></i> User Management
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white" data-bs-toggle="modal" data-bs-target="#patientManagementModal">
                <i class="fas fa-user-injured me-2"></i> Patient Management
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white" data-bs-toggle="modal" data-bs-target="#inventoryModal">
                <i class="fas fa-boxes me-2"></i> Inventory
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white" data-bs-toggle="modal" data-bs-target="#appointmentsModal">
                <i class="fas fa-calendar-check me-2"></i> Appointments
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white" data-bs-toggle="modal" data-bs-target="#attendanceModal">
                <i class="fas fa-clipboard-list me-2"></i> Attendance
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white" data-bs-toggle="modal" data-bs-target="#reportsModal">
                <i class="fas fa-chart-line me-2"></i> Reports
            </a>
        </div>
    </div>

    <!-- Page Content -->
    <div id="page-content-wrapper" class="w-100 bg-light">
        <!-- Admin Header -->
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

        <!-- Dashboard Content -->
        <div class="container-fluid py-4">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0">{{ __('Admin Dashboard') }}</h5>
                        </div>

                        <div class="card-body">
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <div class="row g-4">
                                @php
                                    $cards = [
                                        [
                                            'title' => 'Staff Management',
                                            'text' => 'Manage staff members including physicians, reception, lab technicians, and pharmacists.',
                                            'modal' => '#userManagementModal',
                                            'button' => 'Manage Staff',
                                            'class' => 'btn-primary',
                                            'icon' => 'users',
                                            ],
                                        [
                                            'title' => 'Register New User',
                                            'text' => 'Add a new staff member to the system.',
                                            'modal' => '#registerUserModal',
                                            'button' => 'Register New User',
                                            'class' => 'btn-success',
                                            'icon' => 'user-plus'
                                        ],
                                        [
                                            'title' => 'Appointment Reports',
                                            'text' => 'View and generate reports related to appointments.',
                                            'modal' => '#appointmentReportsModal',
                                            'button' => 'Generate Reports',
                                            'class' => 'btn-info',
                                            'icon' => 'chart-bar'
                                        ],
                                        [
                                            'title' => 'Inventory Reports',
                                            'text' => 'View and generate reports related to inventory.',
                                            'modal' => '#inventoryReportsModal',
                                            'button' => 'Generate Reports',
                                            'class' => 'btn-info',
                                            'icon' => 'chart-pie'
                                        ],
                                        [
                                            'title' => 'Staff Performance',
                                            'text' => 'View and generate reports related to staff performance.',
                                            'modal' => '#staffPerformanceModal',
                                            'button' => 'View Reports',
                                            'class' => 'btn-info',
                                            'icon' => 'chart-line'
                                        ],
                                        [
                                            'title' => 'Inventory Management',
                                            'text' => 'Manage and monitor inventory items.',
                                            'modal' => '#inventoryModal',
                                            'button' => 'Manage Inventory',
                                            'class' => 'btn-warning',
                                            'icon' => 'boxes'
                                        ],
                                        [
                                            'title' => 'Attendance Management',
                                            'text' => 'Manage And Control Staff Attendance.',
                                            'modal' => '#attendanceModal',
                                            'button' => 'Attendance',
                                            'class' => 'btn-secondary',
                                            'icon' => 'clipboard-list'
                                        ],
                                        [
                                            'title' => 'Patient Management',
                                            'text' => 'Manage patient-related tasks.',
                                            'modal' => '#patientManagementModal',
                                            'button' => 'Patients',
                                            'class' => 'btn-secondary',
                                            'icon' => 'user-injured'
                                        ],
                                    ];
                                @endphp

                                @foreach ($cards as $card)
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="card h-100 border-0 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="bg-{{ explode('-', $card['class'])[1] }} bg-opacity-10 p-3 rounded me-3">
                                                        <i class="fas fa-{{ $card['icon'] }} text-{{ explode('-', $card['class'])[1] }} fs-4"></i>
                                                    </div>
                                                    <h5 class="card-title mb-0">{{ __($card['title']) }}</h5>
                                                </div>
                                                <p class="card-text text-muted">{{ __($card['text']) }}</p>
                                                @if(isset($card['action']))
                                                    <form action="{{ $card['action'] }}" method="GET">
                                                        <button type="submit" class="btn btn-sm {{ $card['class'] }}">
                                                            {{ __($card['button']) }}
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="{{ $card['modal'] }}" class="btn btn-sm {{ $card['class'] }}">
                                                        {{ __($card['button']) }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- User Management Modal -->
<div class="modal fade" id="userManagementModal" tabindex="-1" aria-labelledby="userManagementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="userManagementModalLabel"><i class="fas fa-users me-2"></i>Staff Management</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <form method="GET" action="{{ route('admin.staff.fetch') }}">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" name="user_search" class="form-control" placeholder="Search users..." value="{{ request('user_search') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select name="user_role" class="form-select">
                                    <option value="">All Roles</option>
                                    <option value="Admin" {{ request('user_role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="Nurse" {{ request('user_role') == 'Nurse' ? 'selected' : '' }}>Nurse</option>
                                    <option value="Reception" {{ request('user_role') == 'Reception' ? 'selected' : '' }}>Receptionist</option>
                                    <option value="Lab_Technician" {{ request('user_role') == 'Lab_Technician' ? 'selected' : '' }}>Lab Technician</option>
                                    <option value="Pharmacist" {{ request('user_role') == 'Pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                                    <option value="Health_Officer" {{ request('user_role') == 'Health_Officer' ? 'selected' : '' }}>Health Officer</option>
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Registered</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($users) && $users->count() > 0)
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id ?? 'N/A' }}</td>
                                        <td>{{ $user->name ?? 'N/A' }}</td>
                                        <td>{{ $user->email ?? 'N/A' }}</td>
                                        <td>
                                           @if($user->roles->isNotEmpty())
                                             <span class="badge bg-primary">
                                                 {{ $user->roles->first()->name }}
                                                        </span>
                                                   @else
                                                 <span class="badge bg-secondary">No Role</span>
                                                  @endif
                                               </td>
                                        <td><span class="badge bg-{{ ($user->status ?? '') === 'Active' ? 'success' : 'danger' }}">{{ $user->status ?? 'N/A' }}</span></td>
                                        <td>{{ $user->created_at?->format('Y-m-d') ?? 'N/A' }}</td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-primary"><i class="fas fa-edit"></i> Edit</a>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash"></i> Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="7" class="text-center">No users found</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
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
                <h5 class="modal-title" id="registerUserModalLabel"><i class="fas fa-user-plus me-2"></i>Register New User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userRegistrationForm" method="POST" action="{{ route('admin.register.user') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" name="age" id="age" min="0" class="form-control @error('age') is-invalid @enderror" required>
                            @error('age')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">Select Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">Select Role</option>
                                <option value="Admin">Admin</option>
                                <option value="Nurse">Nurse</option>
                                <option value="Reception">Receptionist</option>
                                <option value="Lab_Technician">Lab Technician</option>
                                <option value="Pharmacist">Pharmacist</option>
                                <option value="Health_Officer">Health Officer</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Register User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Patient Management Modal -->
<div class="modal fade" id="patientManagementModal" tabindex="-1" aria-labelledby="patientManagementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="patientManagementModalLabel"><i class="fas fa-user-injured me-2"></i>Patient Management</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                  <form method="GET" action="{{ route('admin.patients.index') }}">
                     <div class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                               <span class="input-group-text"><i class="fas fa-search"></i></span>
                             <input type="text" name="patient_search" class="form-control" placeholder="Search by Patient ID..." value="{{ request('patient_search') }}">
                            </div>
                         </div>
                     </div>
                 </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Registered</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if( isset($patients) && $patients->count() > 0)
                                @foreach($patients as $patient)
                                    <tr>
                                        <td>{{ $patient->patient_id ?? 'N/A' }}</td>
                                        <td>{{ $patient->name ?? 'N/A' }}</td>
                                        <td>{{ $patient->email ?? 'N/A' }}</td>
                                        <td>{{ $patient->phone ?? 'N/A' }}</td>
                                        <td>{{ $patient->created_at?->format('Y-m-d') ?? 'N/A' }}</td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.patients.edit', $patient->patient_id) }}" class="btn btn-outline-primary"> edit<i class="fas fa-edit"></i></a>
                                                <form action="{{ route('admin.patients.destroy', $patient->patient_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this patient?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger"> delete<i class="fas fa-trash"></i></button>
                                                </form>
                                                <a href="{{ route('admin.patients.show', $patient->patient_id) }}" class="btn btn-outline-info"> show<i class="fas fa-eye"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="7" class="text-center">No patients found</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Inventory Report Modal -->
<div class="modal fade" id="inventoryReportsModal" tabindex="-1" aria-labelledby="inventoryReportsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="inventoryReportsModalLabel"><i class="fas fa-chart-pie me-2"></i>Inventory Reports</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="GET" action="{{ route('admin.reports.inventory') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date', \Carbon\Carbon::now()->subMonth()->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-3">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" id="category" class="form-select">
                                <option value="">All</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                       <!--  <div class="col-md-3">
                            <label for="search" class="form-label">Search Medication</label>
                            <input type="text" id="search" name="search" class="form-control" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3 form-check mt-4">
                            <input type="checkbox" class="form-check-input" name="low_stock" value="true" id="low_stock" {{ request('low_stock') === 'true' ? 'checked' : '' }}>
                            <label class="form-check-label" for="low_stock">Low Stock Only</label>
                        </div> -->
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-info w-100"><i class="fas fa-filter me-2"></i>Apply Filters</button>
                        </div>
                    </div>
                </form>

                <hr>

                <h5 class="mt-4"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Low Stock Medications</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle">
                        <thead class="table-warning">
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Current Stock</th>
                                <th>Reorder Level</th>
                            </tr>
                        </thead>
                        @if(isset($low_stock))
    <tbody>
        @forelse($low_stock as $med)
            <tr>
                <td>{{ $med->name }}</td>
                <td>{{ $med->category }}</td>
                <td>{{ $med->current_stock }}</td>
                <td>{{ $med->reorder_level }}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center">No low stock medications found.</td></tr>
        @endforelse
    </tbody>
    @endif

                    </table>
                </div>

                @php
                $date_range = $date_range ?? ['start_date' => now()->subDays(30), 'end_date' => now()];
            @endphp

                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle">
                        <thead class="table-success">
                            <tr>
                                <th>Name</th>
                                <th>Total Used</th>
                                <th>Current Stock</th>
                            </tr>
                        </thead>
                        @if(isset($most_used))
                        <tbody>
                            @forelse($most_used as $used)
                                <tr>
                                    <td>{{ $used->medication->name ?? 'N/A' }}</td>
                                    <td>{{ $used->total_used }}</td>
                                    <td>{{ $used->medication->current_stock ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center">No usage data found.</td></tr>
                            @endforelse
                        </tbody>
                         @endif
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<!-- Inventory Management Modal -->
<div class="modal fade" id="inventoryModal" tabindex="-1" aria-labelledby="inventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="inventoryModalLabel"><i class="fas fa-boxes me-2"></i>Inventory Management</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                {{-- Filter Form --}}
               <form method="GET" action="{{ route('admin.inventory.index') }}">
          <div class="row g-3">
           <div class="col-md-6">
             <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" name="inventory_search" class="form-control" placeholder="Search medications..." value="{{ request('inventory_search') }}">
            </div>
           </div>
           <div class="col-md-4">
              <select name="inventory_category" class="form-select">
                <option value="">All Categories</option>
                <option value="Medicatiions" {{ request('inventory_category') == 'Medicatiions' ? 'selected' : '' }}>Medicatiions</option>
                <option value="Clinical_Supplies" {{ request('inventory_category') == 'Clinical_Supplies' ? 'selected' : '' }}>Clinical Supplies</option>
                <option value="Lab_Supplies" {{ request('inventory_category') == 'Lab_Supplies' ? 'selected' : '' }}>Lab_Supplies</option>
                <option value="Diagnostic_Supplies" {{ request('inventory_category') == 'Diagnostic_Supplies' ? 'selected' : '' }}>Diagnostic_Supplies</option>
                <option value="Steralization_Supplies" {{ request('inventory_category') == 'Steralization_Supplies' ? 'selected' : '' }}>Steralization_Supplies</option>
            </select>
           </div>
          <div class="col-md-2 text-end">
            <button class="btn btn-success" type="submit">Filter</button>
            <button class="btn btn-success ms-2" type="button" data-bs-toggle="modal" data-bs-target="#addInventoryModal">
                <i class="fas fa-plus me-1"></i> Add
            </button>
        </div>
    </div>
</form>


                {{-- Inventory Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Reorder Level</th>
                                <th>Expiry</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                           @if(isset($medications) && $medications->count() > 0)
    @foreach($medications as $med)
        <tr class="{{ (isset($med->current_stock, $med->reorder_level) && $med->current_stock < $med->reorder_level) ? 'table-danger' : '' }}">
            <td>{{ $med->id }}</td>
            <td>{{ $med->name }}</td>
            <td>{{ isset($med->description) ? \Illuminate\Support\Str::limit($med->description, 50) : '' }}</td>
            <td><span class="badge bg-info">{{ $med->category ?? '' }}</span></td>
            <td>
                <span class="{{ (isset($med->current_stock, $med->reorder_level) && $med->current_stock < $med->reorder_level) ? 'text-danger fw-bold' : '' }}">
                    {{ $med->current_stock ?? '' }} {{ $med->unit ?? '' }}
                </span>
            </td>
            <td>{{ $med->reorder_level ?? '' }} {{ $med->unit ?? '' }}</td>
            <!-- <td>{{ isset($med->price) ? number_format($med->price, 2) : '' }}</td> -->
            <td @if(isset($med->expiry_date) && $med->expiry_date < now()->addDays(30)) class="text-danger" @endif>
                {{ isset($med->expiry_date) ? $med->expiry_date->format('Y-m-d') : '' }}
            </td>
            <td class="text-end">
                <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.inventory.edit', $med->id) }}" class="btn btn-outline-primary">Edit<i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.inventory.destroy', $med->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">Delete<i class="fas fa-trash"></i></button>
                    </form>
                    <a href="{{ route('admin.inventory.show', $med->id) }}" class="btn btn-outline-primary">View<i class="fas fa-edit"></i></a>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr><td colspan="9" class="text-center">No inventory items found</td></tr>
@endif

                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-3 d-flex justify-content-center">
                  @if(isset($medications)) {{ $medications->appends(request()->query())->links() }} @endif
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Add Inventory Modal -->
<div class="modal fade" id="addInventoryModal" tabindex="-1" aria-labelledby="addInventoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addInventoryModalLabel"><i class="fas fa-plus me-2"></i>Add New Medication</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.inventory.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="category" class="form-label">Category</label>
                            <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                <option value="Medicatiions">Medicatiions</option>
                                <option value="Clinical_Supplies">Clinical Supplies</option>
                                <option value="Lab_Supplies">Lab Supplies</option>
                                <option value="Steralization_Supplies">Steralization Supplies</option>
                                <option value="Diagnostic_Supplies">Diagnostic Supplies</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="unit" class="form-label">Unit</label>
                            <input type="text" class="form-control" id="unit" name="unit" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="current_stock" class="form-label">Current Stock</label>
                            <input type="number" class="form-control" id="current_stock" name="current_stock" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="reorder_level" class="form-label">Reorder Level</label>
                            <input type="number" class="form-control" id="reorder_level" name="reorder_level" required>
                        </div>
                    </div>
                    
                        <div class="col-md-6 mb-3">
                            <label for="expiry_date" class="form-label">Expiry Date</label>
                            <input type="date" class="form-control" id="expiry_date" name="expiry_date">
                        </div>
                    
                    <div class="mb-3">
                        <label for="manufacturer" class="form-label">Manufacturer</label>
                        <input type="text" class="form-control" id="manufacturer" name="manufacturer">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Medication</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Attendance Modal -->
<div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="attendanceModalLabel">Attendance Management</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="attendanceTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Role(s)</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
                                    @if ($user->getRoleNames()->isNotEmpty())
                                        {{ $user->getRoleNames()->implode(', ') }}
                                    @else
                                        {{ $user->role }}
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <!-- Present Form -->
                                    <form method="POST" action="{{ route('admin.attendance.store') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <input type="hidden" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                        <input type="hidden" name="present" value="{{ \Carbon\Carbon::now()->format('H:i') }}">
                                        <input type="hidden" name="status" value="present">
                                        <button type="submit" class="btn btn-success btn-sm">Present</button>
                                    </form>

                                    <!-- Abscent Form -->
                                    <form method="POST" action="{{ route('admin.attendance.store') }}" class="d-inline ms-2">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <input type="hidden" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                        <input type="hidden" name="abscent" value="{{ \Carbon\Carbon::now()->format('H:i') }}">
                                        <input type="hidden" name="status" value="abscent">
                                        <button type="submit" class="btn btn-primary btn-sm">Abscent</button>
                                    </form>

                                    <!-- Late Form -->
                                    <form method="POST" action="{{ route('admin.attendance.store') }}" class="d-inline ms-2">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <input type="hidden" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                        <input type="hidden" name="late" value="{{ \Carbon\Carbon::now()->format('H:i') }}">
                                        <input type="hidden" name="status" value="late">
                                        <button type="submit" class="btn btn-primary btn-sm">Late</button>
                                    </form>

                                    <!-- Half Day Form -->
                                    <form method="POST" action="{{ route('admin.attendance.store') }}" class="d-inline ms-2">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <input type="hidden" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                        <input type="hidden" name="half_day" value="{{ \Carbon\Carbon::now()->format('H:i') }}">
                                        <input type="hidden" name="status" value="half_day">
                                        <button type="submit" class="btn btn-primary btn-sm">Half Day</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>





<!-- Footer -->
<footer class="bg-dark text-white py-4 mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="mb-3">BiT Students Clinic</h5>
                <p class="text-muted">Providing quality healthcare for students</p>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ url('/') }}" class="text-muted text-decoration-none">Home</a></li>
                    <li><a href="{{ route('admin.dashboard') }}" class="text-muted text-decoration-none">Dashboard</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="mb-3">Contact</h5>
                <ul class="list-unstyled text-muted">
                    <li class="mb-2">support@bitstudentsclinic.com</li>
                    <li>+251 911 123 456</li>
                </ul>
            </div>
        </div>
        <hr class="my-4 bg-secondary">
        <div class="text-center text-muted">
            <p class="mb-0">© {{ date('Y') }} BiT Students Clinic. All rights reserved.</p>
        </div>
    </div>
</footer>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" integrity="sha512-uKQ39gEGiyU55B4BB6DnxewT2rK9D8JBGZCxLI7J0MxfpJUg3uS7lTLeFXW0pe0jrwBu4R9K5QVRMSHgiP2rvg==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min, like, an admin dashboard and should be able to search for staff like you can search for patients. So, essentially, an admin dashboard that can search for patients and staff. But the staff search should be in that staff management modal.
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Debug form submissions
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', () => {
            console.log('Form submitted to:', form.action);
        });
    });

    // Check if modal should be opened
    var openUserModal = {{ isset($openUserModal) && $openUserModal ? 'true' : 'false' }};
    console.log('openUserModal:', openUserModal);
    if (openUserModal && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        document.addEventListener('DOMContentLoaded', function() {
            var userModalElement = document.getElementById('userManagementModal');
            if (userModalElement) {
                var userModal = new bootstrap.Modal(userModalElement);
                userModal.show();
            } else {
                console.error('User Management Modal element not found');
            }
        });
    }
</script>
@endpush
@endsection
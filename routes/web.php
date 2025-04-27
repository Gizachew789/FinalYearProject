<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\Admin\UserRegistrationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LabReportController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\Auth\PatientRegistrationController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
});


// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Admin routes

  

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Admin dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Staff registration
     Route::get('/register-user', [UserRegistrationController::class, 'create'])->name('register.user');
    Route::post('/register-user', [UserRegistrationController::class, 'store'])->name('register.user.store'); 

    // User management
    Route::get('/users/create', [UserRegistrationController::class, 'create'])->name('users.create');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Reports management
    
       // Appointment Reports
       Route::get('/reports/appointments', [ReportController::class, 'appointmentReports'])
       ->name('reports.appointments'); // Generate appointment reports (by status, reception, day)

   // Inventory Reports
   Route::get('/reports/inventory', [ReportController::class, 'inventoryReports'])
       ->name('reports.inventory'); // Generate inventory reports (low stock, most used medications)

   // User Performance Reports
   Route::get('/reports/user-performance', [ReportController::class, 'userPerformanceReports'])
       ->name('reports.userPerformance'); // Generate user performance reports (appointments, medical records, prescriptions)

   // Export Reports
   Route::get('/reports/export/{type}', [ReportController::class, 'exportReport'])
       ->name('reports.export'); // Export reports as CSV or PDF (appointments, inventory, user performance)
    
    // Attendance management
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index'); // View all attendance records
    Route::get('/attendance/{user}', [AttendanceController::class, 'show'])->name('attendance.show'); // View a specific user's attendance
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/{user}/confirm', [AttendanceController::class, 'confirmForm'])->name('attendance.confirm'); // Confirm a user's attendance
    Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance/{user}/confirm', [AttendanceController::class, 'confirm'])->name('attendance.confirm.submit'); // Confirm a user's attendance

    // Inventory management
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index'); // View all inventory items
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create'); // Create a new inventory item
    Route::get('/inventory/{id}', [InventoryController::class, 'show'])->name('inventory.show');  
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store'); // Store a new inventory item
    Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit'); // Edit an inventory item
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update'); // Update an inventory item
    Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy'); // Delete an inventory item
    Route::get('/inventory/low-stock', [InventoryController::class, 'lowStock'])->name('inventory.lowStock'); // view low stock item


});




// @if (Route::has('register'))
//     <p>Register route exists!</p>
//     <a href="{{ route('register') }}">Register</a>
// @endif

// Reception routes
Route::prefix('reception')->name('reception.')->middleware(['auth', 'reception'])->group(function () {
    Route::get('/dashboard', function () {
        return view('reception.dashboard');
    })->name('dashboard');

    // Patient registration
    Route::get('/register-patient', [PatientRegistrationController::class, 'showRegistrationForm'])->name('register.patient');
    Route::post('/register-patient', [PatientRegistrationController::class, 'register'])->name('register.patient.store');
    
    // Patient management
    Route::get('/patients', function () {
        return view('reception.patients.dashboard');
    })->name('patients.dashboard');
});

// Bsc_Nurse routes
Route::prefix('Bsc_Nurse')->middleware(['auth'])->name('Bsc_Nurse.')->group(function () {
    Route::get('/dashboard', function () {
        return view('Bsc_Nurse.dashboard');
    })->name('dashboard');
});

// Result routes
Route::resource('results', ResultController::class);

// LabReport routes
Route::resource('lab_reports', LabReportController::class);

// Lab technician routes
Route::prefix('lab_technician')->middleware(['auth'])->name('lab_technician.')->group(function () {
    Route::get('/dashboard', function () {
        return view('lab.dashboard');
    })->name('dashboard');
});

// Pharmacist routes
Route::prefix('pharmacist')->middleware(['auth'])->name('pharmacist.')->group(function () {
    Route::get('/dashboard', function () {
        return view('pharmacist.dashboard');
    })->name('dashboard');
});

// Patient routes
Route::prefix('patient')->middleware(['auth'])->name('patient.')->group(function () {
    Route::get('/dashboard', function () {
        return view('patient.dashboard');
    })->name('dashboard');
});


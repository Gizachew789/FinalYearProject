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
use App\Http\Controllers\Reception\AppointmentController;
use App\Http\Controllers\Patient\PatientAppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PharmacistDashboardController;
use App\Http\Controllers\PatientController;
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
Route::post('/login', [LoginController::class, 'login'])->name('login');
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
Route::prefix('reception')->name('reception.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('reception.dashboard');
    })->name('dashboard');

    // Patient registration
    Route::get('/register-patient', [PatientRegistrationController::class, 'showRegistrationForm'])->name('register.patient');
    Route::post('/register/patient', [PatientRegistrationController::class, 'register'])->name('register.patient.store');

    // Appointment booking (Controller you should create)
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
     Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

});


// Bsc_Nurse, Nurse and HealthOfficer routes
Route::prefix('staff')->middleware(['auth'])->name('staff.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'staffDashboard'])->name('dashboard.index');


    // Appointments
    Route::post('/appointments/{id}/accept', [AppointmentController::class, 'accept'])->name('appointments.accept');

    // Patients
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');

    // Medical Records
    Route::post('/patients/{id}/medical-records', [MedicalRecordController::class, 'store'])->name('medical-records.store');

    // Lab Requests 
    Route::get('/patients/{id}/lab-requests/create', [LabRequestController::class, 'create'])->name('lab-requests.create');
    Route::post('/patients/{id}/lab-requests', [LabRequestController::class, 'store'])->name('lab-requests.store');

    // Prescriptions
    Route::get('/patients/{id}/prescriptions/create', [PrescriptionController::class, 'create'])->name('prescriptions.create');
    Route::post('/patients/{id}/prescriptions', [PrescriptionController::class, 'store'])->name('prescriptions.store');

    // Lab Results
    Route::get('/patients/{id}/lab-results', [ResultController::class, 'index'])->name('patients.lab-results.index');
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
Route::middleware(['auth'])->prefix('pharmacist')->name('pharmacist.')->group(function () {
    Route::get('/dashboard', [PharmacistDashboardController::class, 'index'])->name('dashboard');
    Route::post('/prescriptions/{id}/dispense', [PharmacistDashboardController::class, 'dispense'])->name('prescriptions.dispense');
});


// Patient routes
Route::prefix('patient')->middleware(['auth'])->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientAppointmentController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/appointments/create', [PatientAppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [PatientAppointmentController::class, 'store'])->name('appointments.store');
});


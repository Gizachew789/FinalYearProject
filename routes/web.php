<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Patient\PatientMedicalHistoryController;
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
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\LabRequestController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::resource('roles', RoleController::class);

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Profile page
 Route::get('/profile', function () {
    if (Auth::check()) {
        $user = Auth::user(); // From users table
        return view('profile', ['user' => $user, 'type' => 'user']);
    } elseif (Auth::guard('patient')->check()) {
        $patient = Auth::guard('patient')->user(); // From patients table
        return view('profile', ['user' => $patient, 'type' => 'patient']);
    } else {
        abort(403, 'Unauthorized');
    }
})->name('profile');


  // Settings page
  Route::get('/settings', function () {
    return view('settings');
  })->name('settings');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'role:Admin'])->group(function () {
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
    Route::get('/reports/appointments', [ReportController::class, 'appointmentReports'])->name('reports.appointments');
    Route::get('/reports/inventory', [ReportController::class, 'inventoryReports'])->name('reports.inventory');
    Route::get('/reports/user-performance', [ReportController::class, 'userPerformanceReports'])->name('reports.userPerformance');
    Route::get('/reports/export/{type}', [ReportController::class, 'exportReport'])->name('reports.export');

    // Attendance management
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/{user}', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/{user}/confirm', [AttendanceController::class, 'confirmForm'])->name('attendance.confirm');
    Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance/{user}/confirm', [AttendanceController::class, 'confirm'])->name('attendance.confirm');

    // Inventory management
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::get('/inventory/{id}', [InventoryController::class, 'show'])->name('inventory.show');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::get('/inventory/low-stock', [InventoryController::class, 'lowStock'])->name('inventory.lowStock');

    // Patient management
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::get('/patients/{patient_id}', [PatientController::class, 'show'])->name('patients.show');
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/{patient_id}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('/patients/{patient_id}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{patient_id}', [PatientController::class, 'destroy'])->name('patients.destroy');
});

// Reception routes
Route::prefix('reception')->name('reception.')->middleware(['auth:reception', 'role:Reception'])->group(function () {
    Route::get('/dashboard', function () {
        return view('reception.dashboard');
    })->name('dashboard');

    // Patient registration
    Route::get('/register-patient', [PatientRegistrationController::class, 'showRegistrationForm'])->name('register.patient');
    Route::post('/register/patient', [PatientRegistrationController::class, 'register'])->name('register.patient.store');

    // Appointment booking
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->name('appointments.show');
});

// Nurse and Health Officer routes
Route::prefix('staff')->middleware(['auth:nurse,health_officer', 'role:Nurse|Health_Officer'])->name('staff.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'staffDashboard'])->name('dashboard');

    // Appointments
    Route::post('/appointments/{patient}/accept', [AppointmentController::class, 'accept'])->name('appointments.accept');
    Route::get('/appointments/search', [AppointmentController::class, 'search'])->name('appointments.search');

    // Patients
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/{patient_id}', [PatientController::class, 'showPatient'])->name('patients.show');

    // Medical Records
    Route::post('/medical-records/{patient_id}', [PatientController::class, 'storeMedicalRecord'])->name('medical_records.store');
    Route::post('/medical-documents/{patient_id}', [PatientController::class, 'uploadMedicalDocument'])->name('medical_documents.upload');

    // Lab Requests
    Route::get('/lab-requests/create/{patient_id}', [LabRequestController::class, 'create'])->name('lab-requests.create');
    Route::get('/lab-requests/{patient_id}', [LabRequestController::class, 'show'])->name('lab-requests.show');
    Route::get('/lab-requests', [LabRequestController::class, 'index'])->name('lab-requests.index');
    Route::post('/lab-requests/{patient_id}', [LabRequestController::class, 'store'])->name('lab-requests.store');

    // Prescriptions
    Route::get('/prescriptions/create/{patient_id}', [PrescriptionController::class, 'create'])->name('prescriptions.create');
    Route::post('/prescriptions/{patient_id}', [PrescriptionController::class, 'store'])->name('prescriptions.store');

    // Lab Results
    Route::get('/lab-results/{patient_id}', [ResultController::class, 'index'])->name('lab-results.index');
    Route::post('/lab-results', [ResultController::class, 'store'])->name('lab-results.store');

    Route::get('/medical_records', [PatientMedicalHistoryController::class, 'index'])->name('medical_history.index');
    Route::get('/medical_records/{patient_id}', [PatientMedicalHistoryController::class, 'show'])->name('medical_history.show');
    Route::get('/medical_records/{patient_id}/edit', [PatientMedicalHistoryController::class, 'edit'])->name('medical_history.edit');
    Route::post('/medical_records/{patient_id}', [PatientMedicalHistoryController::class, 'store'])->name('medical_history.store');
    Route::get('/medical_records/{patient_id}/create', [PatientMedicalHistoryController::class, 'create'])->name('medical_history.create');
});

Route::get('/appointments', [AppointmentController::class, 'index'])->name('staff.appointments.index');
Route::get('/appointments', [AppointmentController::class, 'showappointment'])->name('staff.appointments.show');
Route::get('/appointments/search', [AppointmentController::class, 'search'])->name('staff.appointments.search');
Route::get('/patients/search', [PatientController::class, 'search'])->name('staff.patients.search');
Route::get('/patients/{patient_id}', [PatientController::class, 'showPatient'])->name('staff.patients.show');
Route::get('/lab_results/search', [ResultController::class, 'search'])->name('lab-results.search');

// Result routes
Route::resource('results', ResultController::class);

// LabReport routes
Route::resource('lab_reports', LabReportController::class);

// Lab Technician routes
Route::prefix('lab-technician')->name('lab.')->middleware(['auth:lab_technician', 'role:Lab_Technician'])->group(function () {
    Route::get('/dashboard', function () {
        return view('lab-technician.dashboard');
    })->name('dashboard');

    Route::get('/requests', [LabRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/{patient_id}', [LabRequestController::class, 'show'])->name('requests.show');
    Route::get('/requests/{patient_id}/accept', [LabRequestController::class, 'accept'])->name('requests.accept');

    Route::get('/results/create', [ResultController::class, 'create'])->name('results.create');
    Route::post('/results/store', [ResultController::class, 'store'])->name('results.store');
    Route::get('/results/{result_id}', [ResultController::class, 'show'])->name('results.show');
    Route::delete('/results/{result_id}', [ResultController::class, 'destroy'])->name('results.destroy');
    Route::get('/results/{patient_id}', [ResultController::class, 'index'])->name('results.index');
});

// Pharmacist routes
Route::middleware(['auth:pharmacist', 'role:Pharmacist'])->prefix('pharmacist')->name('pharmacist.')->group(function () {
    Route::get('/dashboard', [PharmacistDashboardController::class, 'index'])->name('dashboard');
    Route::post('/prescriptions/{id}/dispense', [PharmacistDashboardController::class, 'dispense'])->name('prescriptions.dispense');
    Route::get('/prescriptions/{id}', [PharmacistDashboardController::class, 'show'])->name('prescriptions.show');
    Route::get('/prescriptions', [PharmacistDashboardController::class, 'index'])->name('prescriptions.index');
});

// Patient routes
Route::prefix('patient')->middleware(['auth:patient'])->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientAppointmentController::class, 'dashboard'])->name('dashboard');

    Route::get('/appointments/create', [PatientAppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [PatientAppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments', [PatientAppointmentController::class, 'index'])->name('appointments.index');
    Route::delete('/appointments/cancel', [PatientAppointmentController::class, 'cancel'])->name('appointments.cancel');

    Route::get('/medical-history', [PatientMedicalHistoryController::class, 'index'])->name('medical_history.index');
});

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
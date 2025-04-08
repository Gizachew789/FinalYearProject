<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResultController;
use App\Http\Controller\Auth\LabReportController;
use App\Http\Controllers\Auth\PatientRegistrationController;
use App\Http\Controllers\Auth\UserRegistrationController;
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
Route::prefix('admin')->middleware(['auth'])->name('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Staff registration
    Route::get('/register-user', [App\Http\Controllers\Auth\UserRegistrationController::class, 'showRegistrationForm'])->name('register.user');
    Route::post('/register-user', [App\Http\Controllers\Auth\UserRegistrationController::class, 'register']);
    
    // Staff management
    Route::get('/user', function () {
        return view('admin.user.dashboard');
    })->name('user.dashboard');
});

// @if (Route::has('register'))
//     <p>Register route exists!</p>
//     <a href="{{ route('register') }}">Register</a>
// @endif


// Reception routes
Route::prefix('reception')->middleware(['auth', 'reception'])->name('reception.')->group(function () {
    Route::get('/dashboard', function () {
        return view('reception.dashboard');
    })->name('dashboard');
    
    // Patient registration
    Route::get('/register-patient', [App\Http\Controllers\Auth\PatientRegistrationController::class, 'showRegistrationForm'])->name('register.patient');
    Route::post('/register-patient', [App\Http\Controllers\Auth\PatientRegistrationController::class, 'register']);
    
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


Route::get("User/index", function(){
    return "hhelooooooo";

})->name('admin.User.index');


Route::get("User/register", function(){
    return "bye";

})->name('admin.register.User');


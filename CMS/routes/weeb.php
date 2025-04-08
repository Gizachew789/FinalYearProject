<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PatientRegistrationController;
use App\Http\Controllers\Auth\UserRegistrationController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
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
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // User registration
    Route::get('/register-user', [UserRegistrationController::class, 'showRegistrationForm'])->name('register.user');
    Route::post('/register-user', [UserRegistrationController::class, 'register']);
    
    // User management
    Route::get('/users', function () {
        return view('admin.users.dashboard');
    })->name('users.dashboard');
});

// Reception routes
Route::prefix('reception')->middleware(['auth', 'reception'])->name('reception.')->group(function () {
    Route::get('/dashboard', function () {
        return view('reception.dashboard');
    })->name('dashboard');
    
    // Patient registration
    Route::get('/register-patient', [PatientRegistrationController::class, 'showRegistrationForm'])->name('register.patient');
    Route::post('/register-patient', [PatientRegistrationController::class, 'register']);
    
    // Patient management
    Route::get('/patients', function () {
        return view('reception.patients.dashboard');
    })->name('patients.dashboard');
});

// healthOfficer routes
Route::prefix('healthOfficer')->middleware(['auth'])->name('healthOfficer.')->group(function () {
    Route::get('/dashboard', function () {
        return view('healthOfficer.dashboard');
    })->name('dashboard');
});

// Lab technician routes
Route::prefix('lab')->middleware(['auth'])->name('lab.')->group(function () {
    Route::get('/dashboard', function () {
        return view('lab.dashboard');
    })->name('dashboard');
});

// Pharmacist routes
Route::prefix('pharmacy')->middleware(['auth'])->name('pharmacy.')->group(function () {
    Route::get('/dashboard', function () {
        return view('pharmacy.dashboard');
    })->name('dashboard');
});

// Patient routes
Route::prefix('patient')->middleware(['auth'])->name('patient.')->group(function () {
    Route::get('/dashboard', function () {
        return view('patient.dashboard');
    })->name('dashboard');
});

// Inventory routes (accessible by all authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::resource('inventory', InventoryController::class);
    Route::get('/inventory/{inventory}/update-stock', [InventoryController::class, 'showUpdateStock'])->name('inventory.show-update-stock');
    Route::post('/inventory/{inventory}/update-stock', [InventoryController::class, 'updateStock'])->name('inventory.update-stock');
    Route::get('/low-stock', [InventoryController::class, 'lowStock'])->name('inventory.low-stock');
});

// Reports routes (accessible by admin and reception)
Route::middleware(['auth'])->group(function () {
    Route::resource('reports', ReportController::class);
});

Route::get("user/index", function(){
    return "hhelooooooo";

})->name('admin.user.index');


Route::get("user/register", function(){
    return "bye";

})->name('admin.register.user');


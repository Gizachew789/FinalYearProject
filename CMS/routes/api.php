<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);


// Route::post('/login/user', function(){
//     return "logged ion success";

// })->name('login');

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard']);
    Route::put('/dashboard/settings', [DashboardController::class, 'updateSettings'])
    Route::get('/dashboard/appointment-stats', [DashboardController::class, 'appointmentStats']);

    // Appointments
    Route::get('/appointments', [AppointmentController::class, 'dashboard']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
    Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);
    Route::get('/available-physicians', [AppointmentController::class, 'availablePhysicians']);

    // Medical Records
    //Route::apiResource('medical-records', MedicalRecordController::class);
   // Route::post('/medical-records/{id}/documents', [MedicalRecordController::class, 'uploadDocument']);
    //Route::get('/documents/{id}/download', [MedicalRecordController::class, 'downloadDocument']);

        // Medical Records
        Route::get('/medical-records', [MedicalRecordController::class, 'dashboard']);
        Route::post('/medical-records', [MedicalRecordController::class, 'store']);
        Route::get('/medical-records/{id}', [MedicalRecordController::class, 'show']);
        Route::put('/medical-records/{id}', [MedicalRecordController::class, 'update']);
        Route::post('/medical-records/{id}/documents', [MedicalRecordController::class, 'uploadDocument']);
        Route::get('/documents/{id}/download', [MedicalRecordController::class, 'downloadDocument']);

    // Prescriptions
    //Route::apiResource('prescriptions', PrescriptionController::class);
    //Route::put('/prescriptions/{id}/items/{itemId}', [PrescriptionController::class, 'updateItemStatus']);

        // Prescriptions
        Route::get('/prescriptions', [PrescriptionController::class, 'dashboard']);
        Route::post('/prescriptions', [PrescriptionController::class, 'store']);
        Route::get('/prescriptions/{id}', [PrescriptionController::class, 'show']);
        Route::put('/prescriptions/{id}/items/{itemId}', [PrescriptionController::class, 'updateItemStatus']);

    // Inventory
    Route::get('/inventory', [InventoryController::class, 'dashboard']);
    Route::post('/inventory', [InventoryController::class, 'store']);
    Route::get('/inventory/{id}', [InventoryController::class, 'show']);
    Route::put('/inventory/{id}', [InventoryController::class, 'update']);
    Route::delete('/inventory/{id}', [InventoryController::class, 'destroy']);
    Route::post('/inventory/{id}/stock', [InventoryController::class, 'updateStock']);
    Route::get('/inventory/low-stock', [InventoryController::class, 'lowStock']);

    // Medications
    //Route::apiResource('medications', MedicationController::class);
    //Route::post('/medications/{id}/stock', [MedicationController::class, 'updateStock']);
    //Route::get('/medication-categories', [MedicationController::class, 'categories']);

//         // Medications
//         Route::get('/medications', [MedicationController::class, 'dashboard']);
//         Route::post('/medications', [MedicationController::class, 'store']);
//         Route::get('/medications/{id}', [MedicationController::class, 'show']);
//         Route::put('/medications/{id}', [MedicationController::class, 'update']);
//         Route::post('/medications/{id}/stock', [MedicationController::class, 'updateStock']);
//         Route::get('/medication-categories', [MedicationController::class, 'categories']);

//     // Medicines
//     Route::apiResource('medicines', MedicineController::class);

//     // Physician Schedules
//     //Route::apiResource('physician-schedules', PhysiciansScheduleController::class);
//    //Route::get('/week-schedule', [PhysiciansScheduleController::class, 'weekSchedule']);

//         // Physician Schedules
//         Route::get('/physician-schedules', [PhysicianScheduleController::class, 'dashboard']);
//         Route::post('/physician-schedules', [PhysicianScheduleController::class, 'store']);
//         Route::get('/physician-schedules/{id}', [PhysicianScheduleController::class, 'show']);
//         Route::put('/physician-schedules/{id}', [PhysicianScheduleController::class, 'update']);
//         Route::delete('/physician-schedules/{id}', [PhysicianScheduleController::class, 'destroy']);
//         Route::get('/week-schedule', [PhysicianScheduleController::class, 'weekSchedule']);

//     // Notifications
//     Route::apiResource('notifications', NotificationController::class)->only(['dashboard', 'update']);
//     Route::put('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
//     Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);

    // Reports
    Route::get('/reports/appointments', [ReportController::class, 'appointmentReports']);
    Route::get('/reports/inventory', [ReportController::class, 'inventoryReports']);
    Route::get('/reports/Pharmacist', [ReportController::class, 'PharmacistPerformanceReports']);
    Route::get('/reports/export/{type}', [ReportController::class, 'exportReport']);

    // Reception
    Route::apiResource('receptions', ReceptionController::class);

    // Lab Technician
    Route::apiResource('lab-technicians', LabTechnicianController::class);

    // Patient
    Route::apiResource('patients', PatientController::class);

    // Pharmacist
    Route::apiResource('pharmacists', PharmacistController::class);

    // Admin
    Route::apiResource('admin', AdminController::class);

    // Laboratory Reports
    Route::apiResource('laboratory-reports', LaboratoryReportController::class);

    // Staff
    Route::apiResource('staff', StaffController::class);

    // Attendance
    Route::apiResource('attendances', AttendanceController::class);

    // Admin Reports
    //Route::get('/admin-reports', [AdminReportController::class, 'dashboard']);
    //Route::post('/admin-reports/generate', [AdminReportController::class, 'generate']);
   // Route::get('/admin-reports/{id}', [AdminReportController::class, 'show']);
   // Route::delete('/admin-reports/{id}', [AdminReportController::class, 'destroy']);
});

Route::get('/', function(){
    return  view('welcome');
});



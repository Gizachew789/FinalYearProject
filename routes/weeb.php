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

    // Route::get('/admin/users', [UserController::class, 'index'])->name('admin.user.index');
    // Route::prefix('admin')->name('admin.')->middleware(['auth', 'isAdmin'])->group(function () {
    //     Route::get('/users', [UserController::class, 'index'])->name('user.index');
    // });
    // Route::get('/users', [UserController::class, 'index'])->name('user.index');
    //     Route::get('/users', [UserController::class, 'index'])->name('user.index');
    
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






    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="{{ mix('js/app.js') }}" defer></script>
    @endif
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex flex-col min-h-screen font-sans">

    <!-- Header -->
    <header class="bg-white dark:bg-[#121212] shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-[#1b1b18] dark:text-white">Student Clinic Management System</h1>

            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="text-sm px-4 py-2 rounded border border-gray-300 dark:border-gray-600 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-sm px-4 py-2 rounded text-[#1b1b18] dark:text-white hover:underline">
                            Log in
                        </a>
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col items-center justify-center px-6 py-12">
        <div class="space-y-6 text-center">
            <a href="{{ route('reception.register.patient') }}"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-6 py-3 rounded shadow transition">
                Register Patient
            </a>

            <div class="">
                <h2 class="text-2xl font-semibold text-[#1b1b18] dark:text-white"></h2>
                <p class="text-gray-600 dark:text-gray-400"></p>
            </div>

            <a href="{{ route('admin.register.user') }}"
               class="inline-block bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-6 py-3 rounded shadow transition">
                Register User
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-[#121212] border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-6 py-4 text-center text-sm text-gray-600 dark:text-gray-400">
            &copy; {{ date('Y') }} Student Clinic Management System. All rights reserved.
        </div>
    </footer>

</body>
</html>


// <?php

// namespace App\Http\Controllers;

// use App\Models\Appointment;
// use App\Models\Dashboard;
// use App\Models\Medication;
// use App\Models\Patient;
// use App\Models\Physician;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

// class DashboardController extends Controller
// {
//     /**
//      * Get dashboard statistics and user-specific dashboard settings.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function index(Request $request)
//     {
//         $user = $request->user();
//         $stats = [];

//         // Get or create user's dashboard
//         $dashboard = Dashboard::firstOrCreate(['user_id' => $user->id]);

//         // Admin and reception can see all stats
//         if ($user->isAdmin() || $user->isReception()) {
//             // Total patients
//             $stats['total_patients'] = Patient::count();

//             // Total physicians
//             $stats['total_physicians'] = Physician::count();

//             // Total appointments today
//             $stats['appointments_today'] = Appointment::whereDate('appointment_date', today())->count();

//             // Appointments by status
//             $stats['appointments_by_status'] = Appointment::select('status', DB::raw('count(*) as count'))
//                 ->groupBy('status')
//                 ->get()
//                 ->pluck('count', 'status')
//                 ->toArray();

//             // Low stock medications
//             $stats['low_stock_medications'] = Medication::whereRaw('current_stock <= reorder_level')->count();

//             // Recent appointments
//             $stats['recent_appointments'] = Appointment::with(['patient.user', 'physician.user'])
//                 ->orderBy('created_at', 'desc')
//                 ->limit(5)
//                 ->get();
//         }

//         // Physician-specific stats
//         if ($user->isPhysician()) {
//             // Physician's appointments today
//             $stats['appointments_today'] = Appointment::where('physician_id', $user->physician->id)
//                 ->whereDate('appointment_date', today())
//                 ->count();

//             // Physician's upcoming appointments
//             $stats['upcoming_appointments'] = Appointment::with(['patient.user'])
//                 ->where('physician_id', $user->physician->id)
//                 ->where('appointment_date', '>=', today())
//                 ->where('status', '!=', 'cancelled')
//                 ->orderBy('appointment_date')
//                 ->orderBy('appointment_time')
//                 ->limit(5)
//                 ->get();

//             // Physician's appointment stats
//             $stats['appointments_by_status'] = Appointment::where('physician_id', $user->physician->id)
//                 ->select('status', DB::raw('count(*) as count'))
//                 ->groupBy('status')
//                 ->get()
//                 ->pluck('count', 'status')
//                 ->toArray();
//         }

//         // Patient-specific stats
//         if ($user->isPatient()) {
//             // Patient's upcoming appointments
//             $stats['upcoming_appointments'] = Appointment::with(['physician.user'])
//                 ->where('patient_id', $user->patient->id)
//                 ->where('appointment_date', '>=', today())
//                 ->where('status', '!=', 'cancelled')
//                 ->orderBy('appointment_date')
//                 ->orderBy('appointment_time')
//                 ->limit(5)
//                 ->get();

//             // Patient's recent prescriptions
//             $stats['recent_prescriptions'] = $user->patient->prescriptions()
//                 ->with(['physician.user', 'items.medication'])
//                 ->orderBy('created_at', 'desc')
//                 ->limit(5)
//                 ->get();
//         }

//         return response()->json([
//             'stats' => $stats,
//             'dashboard' => $dashboard,
//         ]);
//     }

//     /**
//      * Update user's dashboard settings.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function updateSettings(Request $request)
//     {
//         $user = $request->user();
//         $dashboard = Dashboard::firstOrCreate(['user_id' => $user->id]);

//         $validatedData = $request->validate([
//             'layout' => 'nullable|json',
//             'preferences' => 'nullable|json',
//         ]);

//         $dashboard->update($validatedData);

//         return response()->json([
//             'message' => 'Dashboard settings updated successfully',
//             'dashboard' => $dashboard,
//         ]);
//     }

//     /**
//      * Get appointment statistics.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function appointmentStats(Request $request)
//     {
//         $user = $request->user();
        
//         // Only admin and reception can access this
//         if (!$user->isAdmin() && !$user->isReception()) {
//             return response()->json([
//                 'message' => 'Unauthorized',
//             ], 404);
//         }

//         // Appointments by day of week
//         $appointmentsByDay = Appointment::select(
//                 DB::raw('DAYNAME(appointment_date) as day'),
//                 DB::raw('count(*) as count')
//             )
//             ->groupBy('day')
//             ->orderByRaw('FIELD(day, "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday")')
//             ->get()
//             ->pluck('count', 'day')
//             ->toArray();

//         // Appointments by month
//         $appointmentsByMonth = Appointment::select(
//                 DB::raw('MONTHNAME(appointment_date) as month'),
//                 DB::raw('count(*) as count')
//             )
//             ->groupBy('month')
//             ->orderByRaw('MONTH(appointment_date)')
//             ->get()
//             ->pluck('count', 'month')
//             ->toArray();

//         return response()->json([
//             'by_day' => $appointmentsByDay,
//             'by_month' => $appointmentsByMonth,
//         ]);
//     }
// }



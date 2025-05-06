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





// <?php

// namespace App\Http\Controllers;

// use App\Models\Appointment;
// use App\Models\Document;
// use App\Models\MedicalRecord;
// use App\Models\Notification;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Validator;

// class MedicalRecordController extends Controller
// {
//     /**
//      * Display a listing of the medical records.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function index(Request $request)
//     {
//         $user = $request->user();
//         $query = MedicalRecord::with(['patient.user', 'physician.user', 'appointment']);

//         if ($user->isPatient()) {
//             $query->where('patient_id', $user->patient->id);
//         } elseif ($user->isPhysician()) {
//             $query->where('created_by', $user->physician->id);
//         }

//         // Filter by patient
//         if ($request->has('patient_id') && ($user->isAdmin() || $user->isPhysician() || $user->isReception())) {
//             $query->where('patient_id', $request->patient_id);
//         }

//         $medicalRecords = $query->orderBy('created_at', 'desc')
//             ->paginate(10);

//         return response()->json([
//             'medical_records' => $medicalRecords,
//         ]);
//     }

//     /**
//      * Store a newly created medical record in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function store(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'patient_id' => 'required|exists:patients,id',
//             'appointment_id' => 'nullable|exists:appointments,id',
//             'diagnosis' => 'nullable|string',
//             'symptoms' => 'nullable|string',
//             'treatment' => 'nullable|string',
//             'notes' => 'nullable|string',
//             'follow_up_date' => 'nullable|date',
//             'vital_signs' => 'nullable|json',
//             'lab_results' => 'nullable|json',
//         ]);

//         if ($validator->fails()) {
//             return response()->json(['errors' => $validator->errors()], 422);
//         }

//         $user = $request->user();
        
//         // Check if the user is a physician
//         if (!$user->isPhysician()) {
//             return response()->json([
//                 'message' => 'Only physicians can create medical records',
//             ], 403);
//         }

//         // Create the medical record
//         $medicalRecord = MedicalRecord::create([
//             'patient_id' => $request->patient_id,
//             'appointment_id' => $request->appointment_id,
//             'created_by' => $user->physician->id,
//             'diagnosis' => $request->diagnosis,
//             'symptoms' => $request->symptoms,
//             'treatment' => $request->treatment,
//             'notes' => $request->notes,
//             'follow_up_date' => $request->follow_up_date,
//             'vital_signs' => $request->vital_signs,
//             'lab_results' => $request->lab_results,
//         ]);

//         // Update appointment status if provided
//         if ($request->appointment_id) {
//             $appointment = Appointment::find($request->appointment_id);
//             if ($appointment) {
//                 $appointment->status = 'completed';
//                 $appointment->save();
//             }
//         }

//         // Create notification for the patient
//         Notification::create([
//             'user_id' => $medicalRecord->patient->user_id,
//             'title' => 'New Medical Record',
//             'message' => 'A new medical record has been created for you',
//             'type' => 'system',
//             'related_id' => $medicalRecord->id,
//             'related_type' => MedicalRecord::class,
//         ]);

//         return response()->json([
//             'message' => 'Medical record created successfully',
//             'medical_record' => $medicalRecord->load(['patient.user', 'physician.user', 'appointment']),
//         ], 201);
//     }

//     /**
//      * Display the specified medical record.
//      *
//      * @param  int  $id
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function show($id, Request $request)
//     {
//         $user = $request->user();
//         $medicalRecord = MedicalRecord::with(['patient.user', 'physician.user', 'appointment', 'documents', 'prescriptions.items.medication'])
//             ->findOrFail($id);

//         // Check if the user has permission to view this medical record
//         if ($user->isPatient() && $medicalRecord->patient_id !== $user->patient->id) {
//             return response()->json([
//                 'message' => 'You do not have permission to view this medical record',
//             ], 403);
//         }

//         return response()->json([
//             'medical_record' => $medicalRecord,
//         ]);
//     }

//     /**
//      * Update the specified medical record in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function update(Request $request, $id)
//     {
//         $validator = Validator::make($request->all(), [
//             'diagnosis' => 'nullable|string',
//             'symptoms' => 'nullable|string',
//             'treatment' => 'nullable|string',
//             'notes' => 'nullable|string',
//             'follow_up_date' => 'nullable|date',
//             'vital_signs' => 'nullable|json',
//             'lab_results' => 'nullable|json',
//         ]);

//         if ($validator->fails()) {
//             return response()->json(['errors' => $validator->errors()], 422);
//         }

//         $user = $request->user();
//         $medicalRecord = MedicalRecord::findOrFail($id);

//         // Check if the user has permission to update this medical record
//         if (!$user->isAdmin() && !$user->isPhysician()) {
//             return response()->json([
//                 'message' => 'Only physicians and admins can update medical records',
//             ], 403);
//         }

//         // Physicians can only update their own records unless they're admins
//         if ($user->isPhysician() && !$user->isAdmin() && $medicalRecord->created_by !== $user->physician->id) {
//             return response()->json([
//                 'message' => 'You can only update medical records that you created',
//             ], 403);
//         }

//         // Update the medical record
//         $medicalRecord->diagnosis = $request->diagnosis ?? $medicalRecord->diagnosis;
//         $medicalRecord->symptoms = $request->symptoms ?? $medicalRecord->symptoms;
//         $medicalRecord->treatment = $request->treatment ?? $medicalRecord->treatment;
//         $medicalRecord->notes = $request->notes ?? $medicalRecord->notes;
//         $medicalRecord->follow_up_date = $request->follow_up_date ?? $medicalRecord->follow_up_date;
//         $medicalRecord->vital_signs = $request->vital_signs ?? $medicalRecord->vital_signs;
//         $medicalRecord->lab_results = $request->lab_results ?? $medicalRecord->lab_results;
//         $medicalRecord->save();

//         return response()->json([
//             'message' => 'Medical record updated successfully',
//             'medical_record' => $medicalRecord->load(['patient.user', 'physician.user', 'appointment']),
//         ]);
//     }

//     /**
//      * Upload a document to a medical record.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  int  $id
//      * @return \Illuminate\Http\Response
//      */
//     public function uploadDocument(Request $request, $id)
//     {
//         $validator = Validator::make($request->all(), [
//             'title' => 'required|string|max:255',
//             'description' => 'nullable|string',
//             'file' => 'required|file|max:10240', // 10MB max
//             'document_date' => 'nullable|date',
//         ]);

//         if ($validator->fails()) {
//             return response()->json(['errors' => $validator->errors()], 422);
//         }

//         $user = $request->user();
//         $medicalRecord = MedicalRecord::findOrFail($id);

//         // Check if the user has permission to upload documents
//         if (!$user->isAdmin() && !$user->isPhysician()) {
//             return response()->json([
//                 'message' => 'Only physicians and admins can upload documents',
//             ], 403);
//         }

//         // Store the file
//         $file = $request->file('file');
//         $path = $file->store('documents');
        
//         // Create the document record
//         $document = Document::create([
//             'medical_record_id' => $medicalRecord->id,
//             'uploaded_by' => $user->id,
//             'title' => $request->title,
//             'file_path' => $path,
//             'file_type' => $file->getClientMimeType(),
//             'description' => $request->description,
//             'document_date' => $request->document_date ?? now(),
//         ]);

//         // Create notification for the patient
//         Notification::create([
//             'user_id' => $medicalRecord->patient->user_id,
//             'title' => 'New Document Uploaded',
//             'message' => 'A new document has been uploaded to your medical record',
//             'type' => 'system',
//             'related_id' => $document->id,
//             'related_type' => Document::class,
//         ]);

//         return response()->json([
//             'message' => 'Document uploaded successfully',
//             'document' => $document,
//         ], 201);
//     }

//     /**
//      * Download a document.
//      *
//      * @param  int  $documentId
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function downloadDocument($documentId, Request $request)
//     {
//         $user = $request->user();
//         $document = Document::with('medicalRecord.patient')->findOrFail($documentId);

//         // Check if the user has permission to download this document
//         if ($user->isPatient() && $document->medicalRecord->patient_id !== $user->patient->id) {
//             return response()->json([
//                 'message' => 'You do not have permission to download this document',
//             ], 403);
//         }

//         // Check if the file exists
//         if (!Storage::exists($document->file_path)) {
//             return response()->json([
//                 'message' => 'File not found',
//             ], 404);
//         }

//         return Storage::download($document->file_path, $document->title);
//     }
// }



if (!Auth::user()->hasAnyRole(['nurse', 'healthofficer', 'bsc_nurse'])) {
    abort(403, 'Unauthorized');
}


<div class="card mb-4">
<div class="card-header">Actions</div>
<div class="card-body">
    <a href="{{ route('staff.lab-requests.create', $patient->id) }}" class="btn btn-outline-secondary">Request Lab Test</a>
    <a href="{{ route('staff.prescriptions.create', $patient->id) }}" class="btn btn-outline-secondary">Write Prescription</a>
</div>
</div>










    /**
     * Display a listing of the prescriptions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Prescription::with(['patient.user', 'physician.user', 'medicalRecord', 'items.medication']);

        if ($user->isPatient()) {
            $query->where('patient_id', $user->patient->id);
        } elseif ($user->isPhysician()) {
            $query->where('prescribed_by', $user->physician->id);
        }

        // Filter by patient
        if ($request->has('patient_id') && ($user->isAdmin() || $user->isPhysician() || $user->isReception())) {
            $query->where('patient_id', $request->patient_id);
        }

        $prescriptions = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'prescriptions' => $prescriptions,
        ]);
    }

    /**
     * Store a newly created prescription in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'medical_record_id' => 'required|exists:medical_records,id',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.medication_id' => 'required|exists:medications,id',
            'items.*.dosage' => 'required|string',
            'items.*.frequency' => 'required|string',
            'items.*.duration' => 'required|string',
            'items.*.instructions' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();
        
        // Check if the user is a physician
        if (!$user->isPhysician()) {
            return response()->json([
                'message' => 'Only physicians can create prescriptions',
            ], 403);
        }

        // Create the prescription
        $prescription = Prescription::create([
            'patient_id' => $request->patient_id,
            'medical_record_id' => $request->medical_record_id,
            'prescribed_by' => $user->physician->id,
            'prescription_date' => now(),
            'notes' => $request->notes,
            'status' => 'active',
        ]);

        // Create prescription items
        foreach ($request->items as $item) {
            // Check if medication has enough stock
            $medication = Medication::findOrFail($item['medication_id']);
            if ($medication->current_stock < $item['quantity']) {
                return response()->json([
                    'message' => "Insufficient stock for medication: {$medication->name}",
                ], 400);
            }

            PrescriptionItem::create([
                'prescription_id' => $prescription->id,
                'medication_id' => $item['medication_id'],
                'dosage' => $item['dosage'],
                'frequency' => $item['frequency'],
                'duration' => $item['duration'],
                'instructions' => $item['instructions'] ?? null,
                'quantity' => $item['quantity'],
                'status' => 'prescribed',
            ]);

            // Update medication stock
            $medication->current_stock -= $item['quantity'];
            $medication->save();
        }

        // Create notification for the patient
        Notification::create([
            'user_id' => $prescription->patient->user_id,
            'title' => 'New Prescription',
            'message' => 'A new prescription has been created for you',
            'type' => 'prescription',
            'related_id' => $prescription->id,
            'related_type' => Prescription::class,
        ]);

        return response()->json([
            'message' => 'Prescription created successfully',
            'prescription' => $prescription->load(['patient.user', 'physician.user', 'medicalRecord', 'items.medication']),
        ], 201);
    }

    /**
     * Display the specified prescription.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $user = $request->user();
        $prescription = Prescription::with(['patient.user', 'physician.user', 'medicalRecord', 'items.medication'])
            ->findOrFail($id);

        // Check if the user has permission to view this prescription
        if ($user->isPatient() && $prescription->patient_id !== $user->patient->id) {
            return response()->json([
                'message' => 'You do not have permission to view this prescription',
            ], 403);
        }

        return response()->json([
            'prescription' => $prescription,
        ]);
    }



    Jossey password  fcBiprgwGh









    resources/views/app.blade.php
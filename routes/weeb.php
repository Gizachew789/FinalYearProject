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


Haile passwor  dN22msatCY



Nati  p1NSqv7mPG

Abeni Bnyffa5UwH

    resources/views/app.blade.php





    //////
    @extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome, {{ $user->name }}</h1>
    <p class="mb-4">This is your shared staff dashboard.</p>

    {{-- Appointments Section --}}
    <div class="card mb-4">
        <div class="card-header">Booked Appointments</div>
        <div class="card-body">
            @if($appointments->isEmpty())
                <p>No appointments available.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                            <td>{{ $appointment->patient->name }}</td>
                                <td>{{ $appointment->appointment_date }}</td>
                                <td>{{ $appointment->appointment_time }}</td>
                                <td>{{ ucfirst($appointment->status) }}</td>
                                <td>
                                  @if($appointment->status == 'pending')
                               <form method="POST" action="{{ route('staff.appointments.accept', $appointment->patient_id) }}">
                                  @csrf
                                 <button type="submit" class="btn btn-sm btn-success mb-1">Accept</button>
                                 </form>
                               @else
                                     <a href="{{ route('staff.patients.show', $appointment->patient_id) }}" class="btn btn-sm btn-primary mb-1">View</a>
                                 <a href="{{ route('staff.lab-requests.create', ['patient_id' => $appointment->patient_id]) }}" class="btn btn-sm btn-outline-secondary mb-1">Lab Test</a>
                                 <a href="{{ route('staff.prescriptions.create', ['patient_id' => $appointment->patient_id]) }}" class="btn btn-sm btn-outline-secondary">Prescribe</a>
                               @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    {{-- Medical History Section --}}
    @if(isset($patient))
    <div class="card mb-4">
        <div class="card-header">Medical History - {{ $patient->name }}</div>
        <div class="card-body">
            @if($patient->medicalRecords->isEmpty())
                <p>No medical records found.</p>
            @else
                <ul>
                    @foreach($patient->medicalRecords as $record)
                        <li>{{ $record->created_at->format('Y-m-d') }}: {{ $record->summary }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{-- Upload New Medical Record --}}
    <div class="card mb-4">
        <div class="card-header">Upload New Medical Document</div>
        <div class="card-body">
            <form action="{{ route('staff.medical_records.store', ['patient_id' => $patient->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="document">Medical Document (PDF or Image)</label>
                    <input type="file" name="document" class="form-control" required>
                </div>
                <div class="form-group mt-2">
                    <label for="notes">Notes</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="Enter summary or notes..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Upload</button>
            </form>
        </div>
    </div>
 

    {{-- Lab Test Results --}}
   <div class="card mb-4">
    <div class="card-header">Lab Test Results</div>
    <div class="card-body">
        @if($patient->results->isEmpty())
            <p>No lab test results found.</p>
        @else
            <ul>
                @foreach($patient->results as $result)
                    <li>
                        {{ $result->disease_type }} - {{ $result->result }} 
                        ({{ $result->result_date->format('Y-m-d') }})
                        @if($result->testedBy) <!-- Assuming the 'testedBy' is the relationship name for technician -->
                            - Added by: {{ $result->testedBy->name }}
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
   </div>



    @endif
</div>
@endsection
///////////////////////////////////////////////////////////
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


// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth','role:Admin'])->group(function () {
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
    Route::post('/attendance/{user}/confirm', [AttendanceController::class, 'confirm'])->name('attendance.confirm'); // Confirm a user's attendance

    // Inventory management
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index'); // View all inventory items
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create'); // Create a new inventory item
    Route::get('/inventory/{id}', [InventoryController::class, 'show'])->name('inventory.show');  
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store'); // Store a new inventory item
    Route::get('/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit'); // Edit an inventory item
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update'); // Update an inventory item
    Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy'); // Delete an inventory item
    Route::get('/inventory/low-stock', [InventoryController::class, 'lowStock'])->name('inventory.lowStock'); // view low stock item
 
         // patient management
         Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
         Route::get('/patients/{patient_id}', [PatientController::class, 'show'])->name('patients.show');
         Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
         Route::get('/patients/{patient_id}/edit', [PatientController::class, 'edit'])->name('patients.edit');
         Route::put('/patients/{patient_id}', [PatientController::class, 'update'])->name('patients.update');
         Route::delete('/patients/{patient_id}', [PatientController::class, 'destroy'])->name('patients.destroy');


});


// @if (Route::has('register'))
//     <p>Register route exists!</p>
//     <a href="{{ route('register') }}">Register</a>
// @endif

// Reception routes
Route::prefix('reception')->name('reception.')->middleware(['auth', 'role:Reception'])->group(function () {
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



// Bsc_Nurse, Nurse and HealthOfficer routes
Route::prefix('staff')->middleware(['auth', 'role:Nurse|Health_Officer'])->name('staff.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'staffDashboard'])->name('dashboard');


    // Appointments
    Route::post('/appointments/{patient}/accept', [AppointmentController::class, 'accept'])->name('appointments.accept');

    // Patients
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/{patient_id}', [PatientController::class, 'showPatient'])->name('patients.show');

    // Medical Records
    Route::post('/medical-records', [MedicalRecordController::class, 'store'])->name('medical_records.store');

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
    Route::get('/medical_records/{patient_id}/create', [PatientMedicalHistoryController::class, 'cre    ate'])->name('medical_history.create');
});
    Route::get('/patients/search', [PatientController::class, 'search'])->name('staff.patients.search');
    Route::get('/lab_results/search', [ResultController::class, 'search'])->name('lab-results.search');


// Result routes
Route::resource('results', ResultController::class);

// LabReport routes
Route::resource('lab_reports', LabReportController::class);

// Lab Technician routes
Route::prefix('lab-technician')->name('lab.')->middleware(['auth', 'role:Lab_Technician'])->group(function () {
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
    Route::get('/results/{patient_id}', [ResultController::class, 'index'])->name('results.index'); // fixed route definition
});


// Pharmacist routes
Route::middleware(['auth', 'role:Pharmacist'])->prefix('pharmacist')->name('pharmacist.')->group(function () {
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
    Route::delete('appointments/cancel', [PatientAppointmentController::class, 'cancel'])->name('appointments.cancel');

    Route::get('/medical-history', [PatientMedicalHistoryController::class, 'index'])->name('medical_history.index');

});

Route::get('/search', [SearchController::class, 'index'])->name('search');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
 it is like this is there a problem in it


 ///////////////////////////////////////////
 [2025-05-20 06:37:47] local.INFO: Is user authenticated after login? {"status":true}   the authentication is returning true but still it is getting me back to the login page <?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $role = $user->getRoleNames()->first(); // get role from Spatie
            Log::info('Login attempt', [
                'email' => $request->email,
                'role' => $role ?? 'N/A'
            ]);
Auth::guard('admin')->login($user);
Log::info('Is user authenticated after login?', ['status' => Auth::guard('admin')->check()]);
            // Authenticate with the correct guard based on role
            match ($role) {
                'Admin' => Auth::guard('admin')->login($user),
                'Reception' => Auth::guard('reception')->login($user),
                'Lab_Technician' => Auth::guard('lab_technician')->login($user),
                'Pharmacist' => Auth::guard('pharmacist')->login($user),
                'Nurse' => Auth::guard('nurse')->login($user),
                'Health_Officer' => Auth::guard('health_officer')->login($user),
                default => Auth::guard('web')->login($user),
            };

            $request->session()->regenerate();

            // Redirect based on role
            return match ($role) {
                'Admin' => redirect()->route('admin.dashboard'),
                'Reception' => redirect()->route('reception.dashboard'),
                'Nurse', 'Health_Officer' => redirect()->route('staff.dashboard'),
                'Lab_Technician' => redirect()->route('lab-technician.dashboard'),
                'Pharmacist' => redirect()->route('pharmacist.dashboard'),
                default => redirect('/'),
            };
        }

        // Authenticate patient if no matching staff user
        $patient = Patient::where('email', $request->email)->first();
        if ($patient && Hash::check($request->password, $patient->password)) {
            Auth::guard('patient')->login($patient);
            $request->session()->regenerate();
            return redirect()->route('patient.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        foreach (['web', 'admin', 'reception', 'lab_technician', 'pharmacist', 'nurse', 'health_officer', 'patient'] as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'Logged out successfully.');
    }
}





/////////////////////////////////////////
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function staffDashboard()
    {
        $user = Auth::user();

        // Load all appointments for staff to view
        $appointments = Appointment::with(['patient.user'])
            ->orderBy('appointment_date', 'asc')
            ->get();
            // Try to get a patient associated with the first valid appointment
            $patient = null;
           

            foreach ($appointments as $appointment) {
                if ($appointment->patient ) {
                    $patient = Patient::with(['user', 'medicalRecords', 'labResults', 'prescriptions'])
                    ->find($appointment->patient_id);
                    break; // Only load the first available patient
                }
            }
            Log::info('A loaded for staff dashboard', ['patient' => $patient]);

        return view('staff.dashboard', [
            'user' => $user,
            'appointments' => $appointments,
            'patient' => $patient,
        ]);
    }
}








/////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
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

    // Patients
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/{patient_id}', [PatientController::class, 'showPatient'])->name('patients.show');

    // Medical Records
    Route::post('/medical-records', [MedicalRecordController::class, 'store'])->name('medical_records.store');

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

Route::get('/patients/search', [PatientController::class, 'search'])->name('staff.patients.search');
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




//////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////
<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    /**
     * Display a listing of the patients.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::all();
        return view('admin.patients.index', compact('patients'));
        
    }

    public function create()
   {
    return view('admin.patients.create');
  }
 /**
 * Show the form for editing the specified patient.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
  public function edit($id)
   {
    $patient = Patient::with('user')->findOrFail($id);
    return view('admin.patients.edit', compact('patient'));
   }


    /**
     * Store a newly created patient in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string|unique:patients',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'age' => 'required|integer',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'department' => 'required|string',
            'year_of_study' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $patient = Patient::create([
            'patient_id' => $request->patient_id,
            'name' => $request->name,
            'gender' => $request->gender,
            'age' => $request->age,
            'phone' => $request->phone,
            'email' => $request->email,
            'department' => $request->department,
            'year_of_study' => $request->year_of_study,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Patient created successfully',
            'patient' => $patient->load('user'),
        ], 201);
    }

    /**
     * Display the specified patient.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($patient_id)
    {
        $patient = Patient::find($patient_id);
    
        if (!$patient) {
            return redirect()->route('admin.patients.index')->with('error', 'Patient not found.');
        }
    
        return view('admin.patients.show', compact('patient'));
    }

    public function showPatient($patient_id)
    {
        $patient = Patient::with('labRequests')->find($patient_id);
      
        return view('staff.patients.show', compact('patient'));
    }
    /**
     * Update the specified patient in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'id' => 'sometimes|required|string|unique:patients,id,' . $id,
            'name' => 'sometimes|required|string|max:255',
            'gender' => 'sometimes|required|in:male,female',
            'age' => 'sometimes|required|integer',
            'phone' => 'sometimes|required|string|max:15',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $patient->user_id,
            'department' => 'sometimes|required|string',
            'year_of_study' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $patient->update([
            'patient_id' => $request->id ?? $patient->id,
            'name' => $request->name ?? $patient->name,
            'gender' => $request->gender ?? $patient->gender,
            'age' => $request->age ?? $patient->age,
            'phone' => $request->phone ?? $patient->phone,
            'email' => $request->email ?? $patient->email,
            'department' => $request->department ?? $patient->department,
            'year_of_study' => $request->year_of_study ?? $patient->year_of_study,
        ]);
        $patients = Patient::all();
        return view('admin.patients.index', compact('patients'))->with('message', 'Patient updated successfully');
    }

    /**
     * Remove the specified patient from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($patient_id)
    {
        $patient = Patient::findOrFail($patient_id); // returns a model instance
        $patient->delete();

        return redirect()->route('admin.patients.index')->with('success', 'Patient deleted successfully.');

    }

    /**
     * Get the medical history of the specified patient.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function medicalHistory($id)
    {
        $patient = Patient::with('user')->findOrFail($id);
        $user = auth()->user();
    
        // Allow access if:
        // - the user is the patient themselves
        // - the user is a Nurse or Health Officer
        if (
            $user->id !== $patient->user_id &&
            !$user->isNurse() &&
            !$user->isHealthOfficer()
        ) {
            abort(403, 'Unauthorized access to patient medical history.');
        }
    
        // Load the patient's medical records and related data
        $medicalHistory = $patient->medicalRecords()
            ->with(['prescriptions.items.medication']) // No physician, so just prescriptions
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('patients.index', [
            'patient' => $patient,
            'medicalHistory' => $medicalHistory,
        ]);
    }
    

    /**
     * Get the appointment history of the specified patient.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function appointmentHistory($id)
    {
        $patient = Patient::with('user')->findOrFail($id);
        $user = auth()->user();
    
        // Authorization: only the patient themselves, nurses, or health officers can access
        if (
            $user->id !== $patient->user_id &&
            !$user->isNurse() &&
            !$user->isHealthOfficer()
        ) {
            abort(403, 'Unauthorized access to patient appointment history.');
        }
    
        // Get the appointment history with relevant relations (e.g., assigned staff)
        $appointmentHistory = $patient->appointments()
            ->with(['assignedBy']) // replace 'physician.user' with a valid relation or remove
            ->orderBy('appointment_date', 'desc')
            ->get();
      
        return view('staff.patients.show', [
            'patient' => $patient,
            'appointmentHistory' => $appointmentHistory,
        ]);
    }
    
   public function search(Request $request)
 {    
Log::info('Search request received', ['request' => $request->all()]);
    $patientId = $request->input('patient_id');
   
    $patient = Patient::where('patient_id', $patientId)->first();
    

    return view('staff.patients.show', compact('patient'));
 }
}



////////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////





////////////////////////////
<div class="modal fade" id="userManagementModal" tabindex="-1" aria-labelledby="userManagementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="userManagementModalLabel"><i class="fas fa-users me-2"></i>User Management</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Filter and Add User -->
                <div class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" id="userSearch" class="form-control" placeholder="Search users...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select id="userRoleFilter" class="form-select">
                                <option value="">All Roles</option>
                                <option value="Admin">Admin</option>
                                <option value="Nurse">Nurse</option>
                                <option value="Reception">Receptionist</option>
                                <option value="Lab_Technician">Lab Technician</option>
                                <option value="Pharmacist">Pharmacist</option>
                                <option value="Health_Officer">Health Officer</option>
                            </select>
                        </div>
                        <div class="col-md-2 text-end">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registerUserModal">
                                <i class="fas fa-user-plus me-1"></i> Add
                            </button>
                        </div>
                    </div>
                </div>

                <!-- User Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><span class="badge bg-primary">{{ $user->role }}</span></td>
                                    <td>
                                        <span class="badge bg-{{ $user->status == 'Active' ? 'success' : 'secondary' }}">
                                            {{ $user->status }}
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-primary">
                                                <i class="fas fa-edit"></i> edit
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i> delete
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline-info">
                                                <i class="fas fa-eye"></i> view
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" disabled>Save changes</button>
            </div>
        </div>
    </div>
</div>






//////////////////////////////////
//////////////////////////////////////////
/////////////////////////////////////////
<tbody>
    @forelse($appointments as $appointment)
        <tr>
            <td class="fw-bold">{{ $appointment->id }}</td>
            <td>
                {{ $appointment->patient->name ?? 'Unknown' }}
                <span class="text-muted">({{ $appointment->patient->patient_id ?? 'N/A' }})</span>
            </td>
            <td>{{ $appointment->date->format('Y-m-d') }}</td>
            <td>{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}</td>
            <td>
                @php
                    $statusClass = [
                        'scheduled' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger'
                    ][$appointment->status] ?? 'secondary';
                @endphp
                <span class="badge bg-{{ $statusClass }}">{{ ucfirst($appointment->status) }}</span>
            </td>
            <td>
                <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" title="View Details">
                    <i class="fas fa-eye"></i>
                </button>
                @if($appointment->status === 'scheduled')
                    <form method="POST" action="{{ route('appointments.complete', $appointment->id) }}" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-sm btn-outline-success me-1" data-bs-toggle="tooltip" title="Mark as Completed">
                            <i class="fas fa-check"></i>
                        </button>
                    </form>
                    <form method="POST" action="{{ route('appointments.cancel', $appointment->id) }}" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Cancel Appointment">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                @else
                    <button class="btn btn-sm btn-outline-secondary me-1" disabled>
                        <i class="fas fa-check"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary" disabled>
                        <i class="fas fa-times"></i>
                    </button>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center text-muted">No upcoming appointments found.</td>
        </tr>
    @endforelse
</tbody>







///////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
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
                            <!-- <h5 class="mb-0">{{ __('Admin Dashboard') }}</h5> -->
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
                            <button type="submit" class="btn btn-info w-100"><i class="fas fa-filter me-2"></i>Filter</button>
                        </div>
                    </div>
                </form>

                <hr>

               <!--  <h5 class="mt-4"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Low Stock Medications</h5> -->
                <div class="table-responsive">
                    <table class="table table-bordered table-sm align-middle">
                        <thead class="table-warning">
                           <!--  <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Current Stock</th>
                                <th>Reorder Level</th>
                            </tr>
                        </thead> -->
                        @if(isset($low_stock))
    <tbody>
        @forelse($low_stock as $med)
           <!--  <tr>
                <td>{{ $med->name }}</td>
                <td>{{ $med->category }}</td>
                <td>{{ $med->current_stock }}</td>
                <td>{{ $med->reorder_level }}</td>
            </tr> -->
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
                           <!--  <tr>
                                <th>Name</th>
                                <th>Total Used</th>
                                <th>Current Stock</th>
                            </tr> -->
                        </thead>
                        @if(isset($most_used))
                        <tbody>
                            @forelse($most_used as $used)
                                <!-- <tr>
                                    <td>{{ $used->medication->name ?? 'N/A' }}</td>
                                    <td>{{ $used->total_used }}</td>
                                    <td>{{ $used->medication->current_stock ?? 'N/A' }}</td>
                                </tr> -->
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
                <option value="Medicine" {{ request('inventory_category') == 'Medicine' ? 'selected' : '' }}>Medicine</option>
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
                                <option value="Medicine">Medicine</option>
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
                            <th>Role</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(isset($users) && $users->count()>0)   
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
                        @else
                     <tr><td colspan="7" class="text-center">No users found</td></tr>
                        @endif
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
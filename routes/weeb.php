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


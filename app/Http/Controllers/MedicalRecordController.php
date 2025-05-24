<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Document;
use App\Models\MedicalRecord;
use App\Models\Notification;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = MedicalRecord::with(['patient', 'appointment']);
    
        // If the logged-in user is a patient, filter only their records
        if ($user->hasRole('patient')) {
            $patient = \App\Models\Patient::where('user_id', $user->id)->first();
            if ($patient) {
                $query->where('patient_id', $patient->id);
            } else {
                abort(403, 'No linked patient profile found.');
            }
        }
    
        // If the user is a nurse/health officer/BSc nurse, they can view all patients
        if ($user->hasAnyRole(['nurse', 'healthofficer', 'bsc_nurse']) && $request->has('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }
    
        $medicalRecords = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('medical_records.index', compact('medicalRecords'));
    }
    

    public function create()
    {
        $patients = Patient::with('user')->get();
        $appointments = Appointment::all();

        return view('staff.medical_records.create', compact('patients', 'appointments'));
    }

   public function store(Request $request)
{
    $request->validate([
        'patient_id' => 'required|exists:patients,patient_id',
        'lab_results_id' => 'nullable|exists:results,id',
        'diagnosis' => 'nullable|string',
        'prescription' => 'nullable|string',
        'treatment' => 'nullable|string',
        'follow_up_date' => 'nullable|date',
        'visit_date' => 'nullable|date',
        'appointment_id' => 'nullable|exists:appointments,id',
    ]);

    $user = $request->user();

    if (!$user->hasAnyRole(['nurse', 'healthofficer', 'bsc_nurse'])) {
        abort(403, 'Unauthorized');
    }

    $medicalRecord = MedicalRecord::create([
        'patient_id' => $request->patient_id,
        'created_by' => $user->id,
        'diagnosis' => $request->diagnosis,
        'treatment' => $request->treatment,
        'prescription' => $request->prescription,
        'visit_date' => $request->visit_date ?? now(), // default to current date if not provided
        'follow_up_date' => $request->follow_up_date,
        'lab_results_id' => $request->lab_results_id,
    ]);

    if ($request->appointment_id) {
        $appointment = Appointment::find($request->appointment_id);
        if ($appointment) {
            $appointment->status = 'completed';
            $appointment->save();
        }
    }

    Notification::create([
        'user_id' => $medicalRecord->patient->user_id,
        'title' => 'New Medical Record',
        'message' => 'A new medical record has been created for you.',
        'type' => 'system',
        'related_id' => $medicalRecord->id,
        'related_type' => MedicalRecord::class,
    ]);

    return redirect()->route('medical_records.index')->with('success', 'Medical record created successfully.');
}


    public function show($id)
    {
        $medicalRecord = MedicalRecord::with(['patient.user', 'appointment', 'documents'])->findOrFail($id);
        return view('medical_records.show', compact('medicalRecord'));
    }

    public function uploadDocumentForm($id)
    {
        $medicalRecord = MedicalRecord::findOrFail($id);
        return view('medical_records.upload_document', compact('medicalRecord'));
    }

    public function uploadDocument(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240',
            'document_date' => 'nullable|date',
        ]);

        $user = $request->user();
        $medicalRecord = MedicalRecord::findOrFail($id);

        if (!$user->hasAnyRole(['nurse', 'healthofficer', 'bsc_nurse'])) {
            abort(403, 'Unauthorized');
        }

        $path = $request->file('file')->store('documents');

        $document = Document::create([
            'medical_record_id' => $medicalRecord->id,
            'title' => $request->title,
            'file_path' => $path,
            'file_type' => $request->file('file')->getMimeType(),
            'description' => $request->description,
            'document_date' => $request->document_date ?? now(),
        ]);

        Notification::create([
            'user_id' => $medicalRecord->patient->user_id,
            'title' => 'New Document Uploaded',
            'message' => 'A new document has been uploaded to your medical record.',
            'type' => 'system',
            'related_id' => $document->id,
            'related_type' => Document::class,
        ]);

        return redirect()->route('medical_records.show', $medicalRecord->id)->with('success', 'Document uploaded successfully.');
    }

    public function downloadDocument($documentId)
    {
        $document = Document::with('medicalRecord.patient')->findOrFail($documentId);

        if (!Storage::exists($document->file_path)) {
            abort(404, 'File not found');
        }

        return Storage::download($document->file_path, $document->title);
    }
}

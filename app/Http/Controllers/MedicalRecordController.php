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
   dd($request->all());

    // Build the data array
    $data = [
        'patient_id' => $request->patient_id,
        'created_by' => $user->id,
        'diagnosis' => $request->diagnosis,
        'treatment' => $request->treatment,
        'prescription' => $request->prescription,
        'visit_date' => $request->visit_date ?? now(),
        'follow_up_date' => $request->follow_up_date,
        'lab_results_id' => $request->lab_result_id,
    ];

    $medicalRecord = MedicalRecord::create($data);

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
        $patient = Patient::with(['medicalHistory.createdBy', 'medicalHistory.labResult'])->findOrFail($id);
        $medicalRecord = MedicalRecord::with(['patient.user', 'appointment', 'documents'])->findOrFail($id);
        return view('medical_records.show', compact('medicalRecord'));
        return view('staff.patients.show', compact('patient'));
    }

    /* public function uploadDocumentForm($id)
    {
        $medicalRecord = MedicalRecord::findOrFail($id);
        return view('medical_records.upload_document', compact('medicalRecord'));
    } */

    public function uploadMedicalDocument(Request $request, $patient_id)
{
    try {
        // Ensure the patient exists
         $patient = Patient::where('patient_id', $patient_id)->firstOrFail();

        // Validate the uploaded file
        $request->validate([
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
        ]);

        $file = $request->file('document');

        if (!$file->isValid()) {
            return back()->withErrors(['error' => 'The uploaded file is invalid.']);
        }

        $fileType = $file->getClientOriginalExtension() === 'pdf' ? 'pdf' : 'image';

        $filePath = $file->store('medical_documents', 'public');

        $document = MedicalDocument::create([
            'patient_id' => 'BDU1203250', // FIXED HERE
            'file_path' => $filePath,
            'file_type' => $fileType,
        ]);

        Log::info('Medical document uploaded', [
            'patient_id' => $patient->patient_id,
            'document_id' => $document->id,
            'file_path' => $filePath
        ]);

        return redirect()->route('staff.patients.show', $patient->patient_id)
            ->with('success', 'Medical document uploaded successfully.');

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return back()->withErrors(['error' => 'Patient not found.']);
    } catch (\Exception $e) {
        Log::error('Failed to upload medical document', [
            'patient_id' => $patient_id,
            'error' => $e->getMessage()
        ]);
        return back()->withErrors([
            'error' => 'Failed to upload medical document: ' . $e->getMessage()
        ]);
    }
}


    public function downloadDocument($documentId)
    {
        $document = Document::with('medicalRecord.patient')->findOrFail($documentId);

        if (!Storage::exists($document->file_path)) {
            abort(404, 'File not found');
        }

        return Storage::download($document->file_path, $document->title);
    }

    public function search(Request $request)
{
    $request->validate([
        'patient_id' => 'required|integer',
    ]);

    $patient = Patient::with(['medicalRecords', 'medicalDocuments'])
        ->find($request->patient_id);

    if (!$patient) {
        return back()->with('error', 'Patient not found.');
    }

    return view('staff.medical_records.index', compact('patient'));
}

}

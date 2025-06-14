<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\MedicalRecord;
use App\Models\MedicalDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with(['user', 'labRequests', 'medicalHistory'])->get();
        return view('staff.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function show(Patient $patient)
    {
        $patient = Patient::with(['user', 'labRequests', 'medicalHistory'])->findOrFail($patient->id);
        Log::info('Patient show', ['patient_id' => $patient->id, 'has_user' => !is_null($patient->user)]);
        return view('admin.patients.show', compact('patient'));
    }

    public function showPatient($patientOrId)
{
    // Determine if parameter is Patient model or ID:
    if ($patientOrId instanceof \App\Models\Patient) {
        $patient = $patientOrId;  // model is auto-resolved by route-model binding
    } else {
        // Manual fetch by ID because param is an ID
        $patient = \App\Models\Patient::with(['user', 'labRequests', 'medicalHistory.createdBy'])
            ->findOrFail($patientOrId);
    }

    // Determine which view to load based on the current route name:
    $routeName = request()->route()->getName();

    if ($routeName === 'staff.patients.show') {
        // If route is /patients/{patient}, use this view
        // (adjust path if needed)
        return view('staff.patients.show', compact('patient'));
    }

    // For the other route 'staff/patients/{patient_id}', load a different blade:
    return view('admin.patients.show', compact('patient')); 
}



 public function edit($patient_id)
{
    $patient = Patient::where('patient_id', $patient_id)->firstOrFail();

    return view('admin.patients.edit', compact('patient'));
}


    public function update(Request $request, Patient $patient)
    {
        // Add validation and update logic here
        $patient->update($request->all());
        return redirect()->route('admin.patients.show', $patient)->with('success', 'Patient updated successfully');
    }

  public function destroy($patient_id)
{
    $patient = Patient::where('patient_id', $patient_id)->firstOrFail();
    $patient->delete();

    return redirect()->back()->with('success', 'Patient deleted successfully');
}


    public function search(Request $request)
    {
         $patient_id = $request->query('patient_id');
        $patients = Patient::where('patient_id',$patient_id )
            // ->orWhereHas('user', function ($q) use ($query) {
            //     $q->where('name', 'like', "%$query%");
            // })
            ->with(['labRequests', 'medicalHistory'])
            ->first();
        return view('staff.patients.show', compact('patients'));
    }

    public function storeMedicalRecord(Request $request, $patient_id)
    {
        Log::info($request->all());
        $patient = Patient::findOrFail($patient_id);
        $user = Auth::guard('nurse')->user() ?: Auth::guard('health_officer')->user();
        // if (!$user) {
        //     Log::warning('No authenticated staff user found for storing medical record.', ['patient_id' => $patient_id]);
        //     return redirect()->route('login')->withErrors(['auth' => 'Please log in to store a medical record.']);
        // }
        $request->validate([
            'diagnosis' => 'required|string|max:255',
            'treatment' => 'nullable|string|max:1000',
            'prescription' => 'nullable|string|max:1000',
            'visit_date' => 'required|date',
            'follow_up_date' => 'nullable|date|after_or_equal:visit_date',
            /* 'results_id' => 'nullable|exists:results,id', */
            
        ]);

        try {
            $medicalRecord = MedicalRecord::create([
                'patient_id' =>  $patient->patient_id,
                'created_by' => $user->id,
                'diagnosis' => $request->diagnosis,
                'treatment' => $request->treatment,
                'prescription' => $request->prescription,
                'visit_date' => $request->visit_date,
                'follow_up_date' => $request->follow_up_date,
                /* 'results_id' => $request->results_id, */
            ]);

            Log::info('Medical record created', [
                'patient_id' => $patient->patient_id,
                'record_id' => $medicalRecord->id,
                'created_by' => $user->id
            ]);

            return redirect()->route('staff.patients.show', $patient->patient_id)
                ->with('success', 'Medical record created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create medical record', [
                'patient_id' => $patient->patient_id,
                'error' => $e->getMessage()
            ]);
            return back()->withErrors(['error' => 'Failed to create medical record. Please try again.']);
        }
    }

 public function uploadMedicalDocument(Request $request, $patient_id)
{
    try {
        // Debug log to verify incoming ID
        Log::debug('uploadMedicalDocument called with patient_id:', ['patient_id' => $patient_id]);

        // Check if patient ID is empty or null
        if (empty($patient_id)) {
            Log::error('Empty patient_id received in uploadMedicalDocument');
            return back()->withErrors(['error' => 'No patient ID received.']);
        }

        // Ensure the patient exists
        $patient = Patient::find($patient_id);
        if (!$patient) {
            Log::error('Patient not found with ID:', ['patient_id' => $patient_id]);
            return back()->withErrors(['error' => 'Patient not found.']);
        }

        // Validate the uploaded file
        $request->validate([
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
        ]);

        $file = $request->file('document');

        // Check if file is valid
        if (!$file->isValid()) {
            Log::warning('Invalid file uploaded for patient_id: ' . $patient_id);
            return back()->withErrors(['error' => 'The uploaded file is invalid.']);
        }

        // Determine file type
        $fileType = $file->getClientOriginalExtension() === 'pdf' ? 'pdf' : 'image';

        // Store file in 'public/medical_documents'
        $filePath = $file->store('medical_documents', 'public');

        // Create the document record
        $document = MedicalDocument::create([
            'patient_id' => $patient_id,
            'file_path' => $filePath,
            'file_type' => $fileType,
        ]);

        // Log success
        Log::info('Medical document uploaded', [
            'patient_id' => $patient->id,
            'document_id' => $document->id,
            'file_path' => $filePath
        ]);

        return redirect()->route('staff.patients.show', $patient->id)
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





public function listPatients(Request $request)
{
            Log::info('Patient show', $request->all());

          $query = Patient::query();
    if ($request->filled('patient_search')) {
        $query->where('patient_id', $request->input('patient_search'));
    }
    $patients = $query->latest()->paginate(10);
    
    return view('admin.dashboard', compact('patients'));
}
}
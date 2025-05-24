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
        $patient = Patient::findOrFail($patient_id);
        // $user = Auth::guard('nurse')->user() ?: Auth::guard('health_officer')->user();
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
            'results_id' => 'nullable|exists:results,id',
        ]);

        try {
            $medicalRecord = MedicalRecord::create([
                'patient_id' => $patient->id,
                'created_by' => $user->id,
                'diagnosis' => $request->diagnosis,
                'treatment' => $request->treatment,
                'prescription' => $request->prescription,
                'visit_date' => $request->visit_date,
                'follow_up_date' => $request->follow_up_date,
                'results_id' => $request->results_id,
            ]);

            Log::info('Medical record created', [
                'patient_id' => $patient->id,
                'record_id' => $medicalRecord->id,
                'created_by' => $user->id
            ]);

            return redirect()->route('staff.patients.show', $patient->id)
                ->with('success', 'Medical record created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create medical record', [
                'patient_id' => $patient->id,
                'error' => $e->getMessage()
            ]);
            return back()->withErrors(['error' => 'Failed to create medical record. Please try again.']);
        }
    }

    public function uploadMedicalDocument(Request $request, $patient_id)
    {
        $patient = Patient::findOrFail($patient_id);
        // $user = Auth::guard('nurse')->user() ?: Auth::guard('health_officer')->user();
        // if (!$user) {
        //     Log::warning('No authenticated staff user found for uploading medical document.', ['patient_id' => $patient_id]);
        //     return redirect()->route('login')->withErrors(['auth' => 'Please log in to upload a medical document.']);
        // }

        $request->validate([
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);

        try {
            $file = $request->file('document');
            $fileType = $file->getClientOriginalExtension() === 'pdf' ? 'pdf' : 'image';
            $filePath = $file->store('medical_documents', 'public');

            $document = MedicalDocument::create([
                'patient_id' => $patient->id,
                'file_path' => $filePath,
                'file_type' => $fileType,

            ]);

            Log::info('Medical document uploaded', [
                'patient_id' => $patient->id,
                'document_id' => $document->id,
                'file_path' => $filePath
            ]);

            return redirect()->route('staff.patients.show', $patient->id)
                ->with('success', 'Medical document uploaded successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to upload medical document', [
                'patient_id' => $patient->id,
                'error' => $e->getMessage()
            ]);
            return back()->withErrors(['error' => 'Failed to upload medical document. Please try again.']);
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
<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PatientMedicalHistoryController extends Controller
{
    /**
     * Display a listing of the patient's medical history.
     */
    public function index()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            Log::warning('No authenticated patient found for medical history index.');
            return redirect()->route('login')->withErrors(['auth' => 'Please log in to view your medical history.']);
        }

        // Load medical history sorted by latest visit date
        $medicalRecords = MedicalRecord::where('patient_id', auth()->user()->patient_id)->latest()->get();
        Log::info('Patient medical history retrieved', [
            'patient_id' => $patient->patient_id,
            'record_count' => $medicalRecords->count()
        ]);

        return view('patient.medical_history.index', compact('medicalRecords'));
    }

    /**
     * Show the form for creating a new medical history record.
     */
    public function create()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            Log::warning('No authenticated patient found for medical history create.');
            return redirect()->route('login')->withErrors(['auth' => 'Please log in to create a medical history record.']);
        }

        return view('patient.medical_history.create', compact('patient'));
    }

    /**
     * Store a newly created medical history record in storage.
     */
    public function store(Request $request)
    {
        // $patient = Auth::guard('patient')->user();
        // if (!$patient) {
        //     Log::warning('No authenticated patient found for medical history store.');
        //     return redirect()->route('login')->withErrors(['auth' => 'Please log in to create a medical history record.']);
        // }

        $request->validate([
            'diagnosis' => 'required|string|max:255',
            'treatment' => 'nullable|string|max:1000',
            'prescription' => 'nullable|string|max:1000',
            'visit_date' => 'required|date',
            'follow_up_date' => 'nullable|date|after_or_equal:visit_date',
            'lab_results_id' => 'nullable|exists:lab_results,id',
        ]);

        try {
            $medicalRecord = MedicalRecord::create([
                'patient_id' => $patient->id,
                'created_by' => $patient->id, // Patient creates their own record
                'diagnosis' => $request->diagnosis,
                'treatment' => $request->treatment,
                'prescription' => $request->prescription,
                'visit_date' => $request->visit_date,
                'follow_up_date' => $request->follow_up_date,
                'lab_results_id' => $request->lab_results_id,
            ]);

            Log::info('Medical history record created', [
                'patient_id' => $patient->id,
                'record_id' => $medicalRecord->id
            ]);

            return redirect()->route('patient.medical_history.index')
                ->with('success', 'Medical history record created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create medical history record', [
                'patient_id' => $patient->id,
                'error' => $e->getMessage()
            ]);
            return back()->withErrors(['error' => 'Failed to create medical history record. Please try again.']);
        }
    }

    /**
     * Display the specified medical history record.
     */
    public function show($id)
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            Log::warning('No authenticated patient found for medical history show.', ['record_id' => $id]);
            return redirect()->route('login')->withErrors(['auth' => 'Please log in to view your medical history.']);
        }

        $medicalRecord = MedicalRecord::where('patient_id', $patient->id)
            ->findOrFail($id);

        Log::info('Medical history record retrieved', [
            'patient_id' => $patient->id,
            'record_id' => $medicalRecord->id
        ]);

        return view('patient.medical_history.show', compact('medicalRecord'));
    }

    /**
     * Show the form for editing a medical history record.
     */
    public function edit($id)
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            Log::warning('No authenticated patient found for medical history edit.', ['record_id' => $id]);
            return redirect()->route('login')->withErrors(['auth' => 'Please log in to edit your medical history.']);
        }

        $medicalRecord = MedicalRecord::where('patient_id', $patient->id)
            ->findOrFail($id);

        Log::info('Medical history record retrieved for edit', [
            'patient_id' => $patient->id,
            'record_id' => $medicalRecord->id
        ]);

        return view('patient.medical_history.edit', compact('medicalRecord', 'patient'));
    }

    /**
     * Update the specified medical history record in storage.
     */
    public function update(Request $request, $id)
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            Log::warning('No authenticated patient found for medical history update.', ['record_id' => $id]);
            return redirect()->route('login')->withErrors(['auth' => 'Please log in to update your medical history.']);
        }

        $request->validate([
            'diagnosis' => 'required|string|max:255',
            'treatment' => 'nullable|string|max:1000',
            'prescription' => 'nullable|string|max:1000',
            'visit_date' => 'required|date',
            'follow_up_date' => 'nullable|date|after_or_equal:visit_date',
            'lab_results_id' => 'nullable|exists:lab_results,id',
        ]);

        try {
            $medicalRecord = MedicalRecord::where('patient_id', $patient->id)->findOrFail($id);
            $medicalRecord->update([
                'diagnosis' => $request->diagnosis,
                'treatment' => $request->treatment,
                'prescription' => $request->prescription,
                'visit_date' => $request->visit_date,
                'follow_up_date' => $request->follow_up_date,
                'lab_results_id' => $request->lab_results_id,
                'created_by' => $patient->id, // Update created_by to current patient
            ]);

            Log::info('Medical history record updated', [
                'patient_id' => $patient->id,
                'record_id' => $medicalRecord->id
            ]);

            return redirect()->route('patient.medical_history.index')
                ->with('success', 'Medical history record updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update medical history record', [
                'patient_id' => $patient->id,
                'record_id' => $id,
                'error' => $e->getMessage()
            ]);
            return back()->withErrors(['error' => 'Failed to update medical history record. Please try again.']);
        }
    }
}
<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientMedicalHistoryController extends Controller
{
    /**
     * Display a listing of the patient's medical history.
     */
    public function index()
    {
        // Example: Retrieve the logged-in patient's medical history
        // $medicalHistory = auth()->user()->medicalHistory;
        $user = auth()->user();

        // Example relationship: $user->medicalHistory
        $medicalHistory = $user->medicalHistory()->with('doctor')->latest()->get();
    
        return view('patient.medical_history.index', compact('medicalHistory'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\LabRequest;
use Illuminate\Support\Facades\Auth;

class LabRequestController extends Controller
{
    // Show the form to create a lab request
    public function create($patientId)
    {
        $patient = Patient::findOrFail($patientId);

        // Only allow specific roles to create lab requests
        // if (!Auth::user()->hasAnyRole(['nurse', 'healthofficer', 'bsc_nurse'])) {
        //     abort(403, 'Unauthorized');
        // }

        return view('staff.lab-requests.create', compact('patient'));
    }

    // Store the lab request
    public function store(Request $request, $patientId)
    {
        
        $request->validate([
            'test_name' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $patient = Patient::findOrFail($patientId);

    
        LabRequest::create([
            'patient_id' => $patient->id,
            'requested_by' => Auth::id(),
            'test_name' => $request->test_name,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('staff.patients.show', $patient->id)->with('success', 'Lab request submitted.');
    }

    public function index()
    {
        // Only allow specific roles to view lab requests
        if (!Auth::user()->hasAnyRole(['nurse', 'healthofficer', 'bsc_nurse'])) {
            abort(403, 'Unauthorized');
        }

        $labRequests = LabRequest::latest()->paginate(10);
        return view('staff.lab-requests.index', compact('labRequests'));
    }

    public function show($id)
    {
        $labRequest = LabRequest::with('patient')->findOrFail($id);

        // Only allow specific roles to view lab request details
        // if (!Auth::user()->hasAnyRole(['nurse', 'healthofficer', 'bsc_nurse'])) {
        //     abort(403, 'Unauthorized');
        // }

        return view('staff.lab-requests.show', compact('labRequest'));
    }
}

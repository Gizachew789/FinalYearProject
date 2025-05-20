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

    public function __construct()
    {
    $this->middleware('auth');
   
    $this->middleware('permission:labtest-request-view', ['only' => ['labtest-request', 'view']]);
  
     }
    public function create($patient_id)
    {
        // Find the patient by ID
        $patient = Patient::with('user')->find($patient_id);
    
        \Log::debug($patient);

        // If patient is not found, return an error or redirect
        if (!$patient) {
            return redirect()->route('some.route')->withErrors('Patient not found.');
        }
    
        // Pass the patient to the view
        return view('staff.lab-requests.create', compact('patient'));
    }
    

    // Store the lab request
    public function store(Request $request, $patient_id)

    {
        // Validate the form input
        $request->validate([
            'test_name' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);
    
        // Retrieve the patient using the patient ID
        $patient = Patient::findOrFail($patient_id);
    
        // Create the LabRequest with the necessary data
        LabRequest::create([
            'patient_id' => $patient->patient_id,
            'requested_by' => Auth::id(),
            'test_name' => $request->test_name,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);
    
        // Redirect to the patient's page with a success message
        return redirect()->route('staff.patients.show', ['patient_id' => $patient_id])->with('success', 'Lab request submitted.');
    }
    

    public function index()
    {
        // Only allow specific roles to view lab requests
        if (!Auth::user()->hasAnyRole(['nurse', 'healthofficer', 'bsc_nurse'])) {
            abort(403, 'Unauthorized');
        }

        $labRequests = LabRequest::latest()->paginate(10);
        return view('staff.lab.index', compact('labRequests'));
    }

    public function show($id)
    {
        $labRequest = LabRequest::with('patient')->findOrFail($id);

        // Only allow specific roles to view lab request details
        // if (!Auth::user()->hasAnyRole(['nurse', 'healthofficer', 'bsc_nurse'])) {
        //     abort(403, 'Unauthorized');
        // }

        return view('staff.lab.show', compact('labRequest'));
    }

    public function dashboard()
    {
        // Get all patients (you can filter as needed)
        $patients = Patient::all(); // or filter based on the current user, etc.

        // Return the dashboard view and pass patients data
        return view('lab-technician.dashboard', compact('patients'));
    }
}

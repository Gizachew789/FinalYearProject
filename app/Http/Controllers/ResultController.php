<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    
   public function index($patient_id)
{
    $patient = Patient::with('results.tested_by_user')
                ->where('patient_id', $patient_id)
                ->firstOrFail(); // find by patient_id column

    $results = $patient->results;

    return view('staff.lab-results.index', compact('patient', 'results'));
}

public function showResultsModal()
{
    $results = Result::with(['patient', 'testedBy'])->latest()->get();
    return view('lab_technician.lab_requests.index', compact('results'));
}
        
   public function search(Request $request)
 {    
     Log::info('Search request received', ['request' => $request->all()]);
     $patientId = $request->input('query');
      $patient = Patient::with('results.tested_by_user')
                ->where('patient_id', $patientId)
                ->firstOrFail(); 
     $result = Result::where('patient_id', $patientId)->first();
     

    return view('lab-technician.results.show', compact('result','patient'));
 }

    // Show the details of a single result
   public function show($result_id)
{
    $result = Result::findOrFail($result_id); // retrieve from DB by ID
    return view('lab.results.show', compact('result')); // or your actual view path
}

    // Show the form to create a new result
    public function create()
    {
        $patients = Patient::all();
        $users = User::all();
        return view('lab-technician.results.create', compact('patients', 'users'));
    }

    // Store a new result in the database
   public function store(Request $request)
{
    $validated = $request->validate([
        'patient_id'     => 'required|exists:patients,patient_id',
        'tested_by'      => 'required|exists:users,id',
        'disease_type'   => 'required|string|max:255',
        'sample_type'    => 'required|string|max:255',
        'result'         => 'required|string|in:Positive,Negative',
        'recommendation' => 'nullable|string|max:1000',
        'result_date'    => 'required|date',
    ]);
    Result::create($validated);
    return redirect()->route('lab.results.index', ['patient_id' => $request->patient_id])
                 ->with('success', 'Result saved successfully.');
}

    // Show the form to edit an existing result
    public function edit(Result $result)
    {
        $patients = Patient::all();

        return redirect()->route('lab.results.edit', compact('result', 'patients'));
    }

    // Update an existing result in the database
    public function update(Request $request, Result $result)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'disease_type' => 'required|string|max:255',
            'sample_type' => 'required|in:Blood,Saliva,Tissue,Waste',
            'result' => 'required|in:Positive,Negative',
            'recommendation' => 'nullable|string|max:255',
            'result_date' => 'required|date',
        ]);

        $result->update([
            'patient_id' => $request->patient_id,
            'disease_type' => $request->disease_type,
            'sample_type' => $request->sample_type,
            'result' => $request->result,
            'recommendation' => $request->input('recommendation'),
            'result_date' => $request->result_date,
        ]);

        return redirect()->route('lab.results.index')->with('success', 'Test result updated successfully.');
    }

    // Delete a result from the database
    public function destroy(Result $result)
    {
        $result->delete();

        return redirect()->route('lab.results.index')->with('success', 'Test result deleted successfully.');
    }
}

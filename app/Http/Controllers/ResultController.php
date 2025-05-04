<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display a list of all results
    public function index()
    {
        $results = Result::with('patient', 'tested_by_user') // eager load patient and user
            ->orderBy('result_date', 'desc')
            ->get();

        return view('results.index', compact('results'));
    }

    // Show the details of a single result
    public function show(Result $result)
    {
        return view('results.show', compact('result'));
    }

    // Show the form to create a new result
    public function create()
    {
        $patients = Patient::all();
        $users = User::all();
        return view('results.create', compact('patients', 'users'));
    }

    // Store a new result in the database
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'disease_type' => 'required|string|max:255',
            'sample_type' => 'required|in:Blood,Saliva,Tissue,Waste',
            'result' => 'required|in:Positive,Negative',
            'Recommendation' => 'nullable|string|max:255',
            'result_date' => 'required|date',
        ]);

        Result::create([
            'patient_id' => $request->input('patient_id'),
            'tested_by' => auth()->id(), // automatically assign current lab technician
            'disease_type' => $request->input('disease_type'),
            'sample_type' => $request->input('sample_type'),
            'result' => $request->input('result'),
            'Recommendation' => $request->input('Recommendation'),
            'result_date' => $request->input('result_date'),
        ]);

        return redirect()->route('results.index')->with('success', 'Test result created successfully.');
    }

    // Show the form to edit an existing result
    public function edit(Result $result)
    {
        $patients = Patient::all();

        return view('results.edit', compact('result', 'patients'));
    }

    // Update an existing result in the database
    public function update(Request $request, Result $result)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'disease_type' => 'required|string|max:255',
            'sample_type' => 'required|in:Blood,Saliva,Tissue,Waste',
            'result' => 'required|in:Positive,Negative',
            'Recommendation' => 'nullable|string|max:255',
            'result_date' => 'required|date',
        ]);

        $result->update([
            'patient_id' => $request->patient_id,
            'disease_type' => $request->disease_type,
            'sample_type' => $request->sample_type,
            'result' => $request->result,
            'recommendation' => $request->input('Recommendation'),
            'result_date' => $request->result_date,
        ]);

        return redirect()->route('results.index')->with('success', 'Test result updated successfully.');
    }

    // Delete a result from the database
    public function destroy(Result $result)
    {
        $result->delete();

        return redirect()->route('results.index')->with('success', 'Test result deleted successfully.');
    }
}

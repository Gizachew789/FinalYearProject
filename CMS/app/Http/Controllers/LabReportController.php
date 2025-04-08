<?php

namespace App\Http\Controllers;

use App\Models\LabReport;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class LabReportController extends Controller
{
    /**
     * Display a listing of the lab reports.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch all lab reports (or use pagination for large data sets)
        $labReports = LabReport::with('patient', 'user')->get();
        
        return view('lab_reports.index', compact('labReports'));
    }

    /**
     * Show the form for creating a new lab report.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Fetch patients and users for dropdown selection
        $patients = Patient::all();
        $users = User::all();
        
        return view('lab_reports.create', compact('patients', 'users'));
    }

    /**
     * Store a newly created lab report in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'report_data' => 'required|string',  // Add specific validation rules as needed
        ]);

        // Create a new lab report
        LabReport::create([
            'patient_id' => $request->patient_id,
            'user_id' => $request->user_id,
            'report_data' => $request->report_data,  // Example field
        ]);

        // Redirect to the lab reports index page with success message
        return redirect()->route('lab_reports.index')->with('success', 'Lab report created successfully.');
    }

    /**
     * Display the specified lab report.
     *
     * @param  \App\Models\LabReport  $labReport
     * @return \Illuminate\Http\Response
     */
    public function show(LabReport $labReport)
    {
        // Load the lab report along with patient and user relations
        $labReport->load('patient', 'user');

        return view('lab_reports.show', compact('labReport'));
    }

    /**
     * Show the form for editing the specified lab report.
     *
     * @param  \App\Models\LabReport  $labReport
     * @return \Illuminate\Http\Response
     */
    public function edit(LabReport $labReport)
    {
        // Fetch patients and users for dropdown selection
        $patients = Patient::all();
        $users = User::all();

        return view('lab_reports.edit', compact('labReport', 'patients', 'users'));
    }

    /**
     * Update the specified lab report in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LabReport  $labReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LabReport $labReport)
    {
        // Validate the request
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'user_id' => 'required|exists:users,id',
            'report_data' => 'required|string',
        ]);

        // Update the lab report
        $labReport->update([
            'patient_id' => $request->patient_id,
            'user_id' => $request->user_id,
            'report_data' => $request->report_data,  // Example field
        ]);

        // Redirect to the lab reports index page with success message
        return redirect()->route('lab_reports.index')->with('success', 'Lab report updated successfully.');
    }

    /**
     * Remove the specified lab report from storage.
     *
     * @param  \App\Models\LabReport  $labReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(LabReport $labReport)
    {
        // Delete the lab report
        $labReport->delete();

        // Redirect to the lab reports index page with success message
        return redirect()->route('lab_reports.index')->with('success', 'Lab report deleted successfully.');
    }
}

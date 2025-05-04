<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    /**
     * Display a listing of the patients.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::all();
        return view('admin.patients.index', compact('patients'));
    }

    public function create()
   {
    return view('admin.patients.create');
  }
 /**
 * Show the form for editing the specified patient.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
  public function edit($id)
   {
    $patient = Patient::with('user')->findOrFail($id);
    return view('admin.patients.edit', compact('patient'));
   }


    /**
     * Store a newly created patient in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string|unique:patients',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'age' => 'required|integer',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'department' => 'required|string',
            'year_of_study' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $patient = Patient::create([
            'id' => $request->id,
            'name' => $request->name,
            'gender' => $request->gender,
            'age' => $request->age,
            'phone' => $request->phone,
            'email' => $request->email,
            'department' => $request->department,
            'year_of_study' => $request->year_of_study,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Patient created successfully',
            'patient' => $patient->load('user'),
        ], 201);
    }

    /**
     * Display the specified patient.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::find($id);
    
        if (!$patient) {
            return redirect()->route('admin.patients.index')->with('error', 'Patient not found.');
        }
    
        return view('admin.patients.show', compact('patient'));
    }

    /**
     * Update the specified patient in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'id' => 'sometimes|required|string|unique:patients,id,' . $id,
            'name' => 'sometimes|required|string|max:255',
            'gender' => 'sometimes|required|in:male,female',
            'age' => 'sometimes|required|integer',
            'phone' => 'sometimes|required|string|max:15',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $patient->user_id,
            'department' => 'sometimes|required|string',
            'year_of_study' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        $patient->update([
            'id' => $request->id ?? $patient->id,
            'name' => $request->name ?? $patient->name,
            'gender' => $request->gender ?? $patient->gender,
            'age' => $request->age ?? $patient->age,
            'phone' => $request->phone ?? $patient->phone,
            'email' => $request->email ?? $patient->email,
            'department' => $request->department ?? $patient->department,
            'year_of_study' => $request->year_of_study ?? $patient->year_of_study,
        ]);
        $patients = Patient::all();
        return view('admin.patients.index', compact('patients'))->with('message', 'Patient updated successfully');
    }

    /**
     * Remove the specified patient from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id); // returns a model instance
        $patient->delete();

        return redirect()->route('admin.patients.index')->with('success', 'Patient deleted successfully.');

    }

    /**
     * Get the medical history of the specified patient.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function medicalHistory($id)
    {
        $patient = Patient::with('user')->findOrFail($id);
        $user = auth()->user();
    
        // Allow access if:
        // - the user is the patient themselves
        // - the user is a Nurse or Health Officer
        if (
            $user->id !== $patient->user_id &&
            !$user->isNurse() &&
            !$user->isHealthOfficer()
        ) {
            abort(403, 'Unauthorized access to patient medical history.');
        }
    
        // Load the patient's medical records and related data
        $medicalHistory = $patient->medicalRecords()
            ->with(['prescriptions.items.medication']) // No physician, so just prescriptions
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('patients.index', [
            'patient' => $patient,
            'medicalHistory' => $medicalHistory,
        ]);
    }
    

    /**
     * Get the appointment history of the specified patient.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function appointmentHistory($id)
    {
        $patient = Patient::with('user')->findOrFail($id);
        $user = auth()->user();
    
        // Authorization: only the patient themselves, nurses, or health officers can access
        if (
            $user->id !== $patient->user_id &&
            !$user->isNurse() &&
            !$user->isHealthOfficer()
        ) {
            abort(403, 'Unauthorized access to patient appointment history.');
        }
    
        // Get the appointment history with relevant relations (e.g., assigned staff)
        $appointmentHistory = $patient->appointments()
            ->with(['assignedBy']) // replace 'physician.user' with a valid relation or remove
            ->orderBy('appointment_date', 'desc')
            ->get();
    
        return view('patients.show', [
            'patient' => $patient,
            'appointmentHistory' => $appointmentHistory,
        ]);
    }
    
}


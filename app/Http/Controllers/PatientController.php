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
        $patients = Patient::with('user')->get();
        return view('patients.index', ['patients' => $patients]);
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'student_id' => 'required|string|unique:patients',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'nullable|string',
            'emergency_contact_name' => 'required|string',
            'emergency_contact_phone' => 'required|string',
            'department' => 'required|string',
            'year_of_study' => 'required|string',
            'blood_group' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient',
        ]);

        $patient = Patient::create([
            'user_id' => $user->id,
            'student_id' => $request->student_id,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'department' => $request->department,
            'year_of_study' => $request->year_of_study,
            'blood_group' => $request->blood_group,
            'allergies' => $request->allergies,
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
        $patient = Patient::with(['user', 'appointments', 'medicalRecords', 'prescriptions'])->findOrFail($id);
        return view('patients.show', ['patient' => $patient]);
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
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $patient->user_id,
            'student_id' => 'sometimes|required|string|unique:patients,student_id,' . $id,
            'date_of_birth' => 'sometimes|required|date',
            'gender' => 'sometimes|required|in:male,female,other',
            'address' => 'nullable|string',
            'emergency_contact_name' => 'sometimes|required|string',
            'emergency_contact_phone' => 'sometimes|required|string',
            'department' => 'sometimes|required|string',
            'year_of_study' => 'sometimes|required|string',
            'blood_group' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $patient->user->update([
            'name' => $request->name ?? $patient->user->name,
            'email' => $request->email ?? $patient->user->email,
        ]);

        $patient->update([
            'student_id' => $request->student_id ?? $patient->student_id,
            'date_of_birth' => $request->date_of_birth ?? $patient->date_of_birth,
            'gender' => $request->gender ?? $patient->gender,
            'address' => $request->address ?? $patient->address,
            'emergency_contact_name' => $request->emergency_contact_name ?? $patient->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone ?? $patient->emergency_contact_phone,
            'department' => $request->department ?? $patient->department,
            'year_of_study' => $request->year_of_study ?? $patient->year_of_study,
            'blood_group' => $request->blood_group ?? $patient->blood_group,
            'allergies' => $request->allergies ?? $patient->allergies,
        ]);

        return response()->json([
            'message' => 'Patient updated successfully',
            'patient' => $patient->load('user'),
        ]);
    }

    /**
     * Remove the specified patient from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $user = $patient->user;

        $patient->delete();
        $user->delete();

        return response()->json([
            'message' => 'Patient deleted successfully',
        ]);
    }

    /**
     * Get the medical history of the specified patient.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function medicalHistory($id)
    {
        $patient = Patient::findOrFail($id);
        $medicalHistory = $patient->medicalRecords()
            ->with(['physician.user', 'prescriptions.items.medication'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'patient' => $patient->load('user'),
            'medical_history' => $medicalHistory,
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
        $patient = Patient::findOrFail($id);
        $appointmentHistory = $patient->appointments()
            ->with(['physician.user'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        return response()->json([
            'patient' => $patient->load('user'),
            'appointment_history' => $appointmentHistory,
        ]);
    }
}


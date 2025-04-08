<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Physician;
use App\Models\Reception;
use App\Models\LabTechnician;
use App\Models\Pharmacist;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,patient,physician,reception,lab_technician,pharmacist',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'status' => 'active',
        ]);

        if ($request->role ==='admin'){
            $adminValidator = Validator::make($request->all(),
            [
                'staff_id' => 'required|string|max:255|unique:admins',
                'qualification' => 'nullable|string|max:255',
                'license_number' => 'nullable|string|max:255',
            ]);

            if($adminValidator->fails())
            {
                $user->delete();
                return response()->json(['errors' => $adminValidator->errors()], 422);  
            }

            admin::create([
                'user_id' => $user->id,
                'staff_id' => $request->staff_id,
                'age' => $request->age,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'email'=> $request->email,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'date_joined' => now(),
                'license_number' => $request->license_number,
            ]);
           
        } elseif ($request->role === 'patient') {
            $patientValidator = Validator::make($request->all(), [
                'student_id' => 'required|string|max:255|unique:patients',
                'age' => 'fillable|integer',
                'gender' => 'fillable|in:male,female,other',
                'department' => 'fillable|string|max:255',
                'year_of_study' => 'fillable|string|max:255',
                'blood_group' => 'nullable|string|max:10',
            ]);

            if ($patientValidator->fails()) {
                $user->delete();
                return response()->json(['errors' => $patientValidator->errors()], 422);
            }

            Patient::create([
                'user_id' => $user->id,
                'student_id' => $request->student_id,
                'age' => $request->age,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'department' => $request->department,
                'year_of_study' => $request->year_of_study,
                'blood_group' => $request->blood_group,
            ]);

        } elseif ($request->role === 'physician') {
            $physicianValidator = Validator::make($request->all(), [
                'staff_id' => 'required|string|max:255|unique:physicians',
                'qualification' => 'nullable|string|max:255',
                'license_number' => 'nullable|string|max:255',
            ]);

            if ($physicianValidator->fails()) {
                $user->delete();
                return response()->json(['errors' => $physicianValidator->errors()], 422);
            }

            Physician::create([
                'user_id' => $user->id,
                'staff_id' => $request->staff_id,
                'age' => $request->age,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'email'=> $request->email,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'date_joined' => now(),
                'license_number' => $request->license_number,
            ]);

        } elseif ($request->role === 'reception') {
            $receptionValidator = Validator::make($request->all(), [
                'staff_id' => 'required|string|max:255|unique:receptions',
                'age' => 'fillable|integer',
                'gender' => 'fillable|in:male,female,other',
            ]);

            if ($receptionValidator->fails()) {
                $user->delete();
                return response()->json(['errors' => $receptionValidator->errors()], 422);
            }

            Reception::create([
                'user_id' => $user->id,
                'staff_id' => $request->staff_id,
                'age' => $request->age,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'email' => $request->email,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'date_joined' => now(),
            ]);
        } elseif ($request->role === 'labTechnician') {
            $labTechnicianValidator = Validator::make($request->all(), [
                'staff_id' => 'required|string|max:255|unique:receptions',
                'age' => 'fillable|integer',
                'gender' => 'fillable|in:male,female,other',
            ]);

            if ($labTechnicianValidator->fails()) {
                $user->delete();
                return response()->json(['errors' => $labTechnicianValidator->errors()], 422);
            }

            labTechnician::create([
                'user_id' => $user->id,
                'staff_id' => $request->staff_id,
                'age' => $request->age,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'email' => $request->email,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'date_joined' => now(),
            ]);
        } elseif ($request->role === 'pharmacist') {
            $pharmacistValidator = Validator::make($request->all(), [
                'staff_id' => 'required|string|max:255|unique:receptions',
                'age' => 'fillable|integer',
                'gender' => 'fillable|in:male,female,other',
            ]);

            if ($pharmacistValidator->fails()) {
                $user->delete();
                return response()->json(['errors' => $pharmacistValidator->errors()], 422);
            }

            pharmacist::create([
                'user_id' => $user->id,
                'staff_id' => $request->staff_id,
                'age' => $request->age,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'email' => $request->email,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'date_joined' => now(),
            ]);
        } 

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Login a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login credentials',
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        if ($user->status !== 'active') {
            return response()->json([
                'message' => 'Your account is inactive. Please contact the administrator.',
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Logout a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    /**
     * Get the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        $user = $request->user();

        if ($user->isPatient()) {
            $user->load('patient');
        } elseif ($user->isPhysician()) {
            $user->load('physician');
        } elseif ($user->isReception()) {
            $user->load('reception');
        }

        return response()->json([
            'user' => $user,
        ]);
    }
}


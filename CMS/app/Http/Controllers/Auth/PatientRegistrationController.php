<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PatientRegistrationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('reception');
    }

    /**
     * Show the patient registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.reception.register-patient');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'fillable|string|max:20',
            'student_id' => 'required|string|max:50|unique:patients',
            'age' => 'fillable|integer',
            'gender' => 'fillable|in:male,female',
            'department' => 'nullable|string|max:255',
            'year_of_study' => 'nullable|string|max:50',
            'blood_group' => 'nullable|string|max:10',
             //'address' => 'nullable|string',
            // 'emergency_contact_name' => 'nullable|string|max:255',
            // 'emergency_contact_phone' => 'nullable|string|max:20',
            //'allergies' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        try {
            DB::beginTransaction();

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'patient',
                'phone' => $request->phone,
                //'status' => 'active',
            ]);
            return response()->json(['message' => 'User registered successfully']);

            // Create patient profile
            Patient::create([
                 'name' => $request->name,
                'student_id' => $request->student_id,
                'age' => $request->age,
                'gender' => $request->gender,
                'department' => $request->department,
                'year_of_study' => $request->year_of_study,
                'blood_group' => $request->blood_group,
                //'address' => $request->address,
                // 'emergency_contact_name' => $request->emergency_contact_name,
                // 'emergency_contact_phone' => $request->emergency_contact_phone,
                //'allergies' => $request->allergies,
            ]);

            DB::commit();

            return redirect()->route('reception.patients.dashboard')
                ->with('success', 'Patient registered successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Registration failed: ' . $e->getMessage())
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }
}


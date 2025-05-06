<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserPasswordMail;
use Illuminate\Support\Str;


class PatientRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('reception.patients.register'); // Your registration form view
    }

    public function register(Request $request)
    {
        
        $validated = $request->validate([
            'id' => 'required|string|regex:/^BDU\d{7}$/|unique:patients,patient_id', // Patient ID must be provided and unique
            'name' => 'required|string|max:255',
            'gender' => 'required',
            'age' => 'nullable|integer',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:patients,email',
            'department' => 'nullable|string|max:255',
            'year_of_study' => 'nullable|string|max:255',   
        ]);
    
          $patient = Patient::create([
            'patient_id' => $validated['id'], // manually set ID
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'age' => $validated['age'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'department' => $validated['department'],
            'year_of_study' => $validated['year_of_study'],
            'password' => bcrypt(1234),
        ]);
    
        return view('reception.dashboard')->with('success', 'Patient registered successfully!');
    }
    

}

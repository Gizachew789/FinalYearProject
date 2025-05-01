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
        'name' => 'required|string|max:255',
        'gender' => 'required',
        'age' => 'integer',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|unique:patients,email',
        'department' => 'string|max:255',
        'year_of_study' => 'string|max:255',   
    ]);

    // ✅ Define and encrypt the random password
    // $randomPassword = Str::random(8);
    // $hashedPassword = bcrypt($randomPassword);

    // ✅ Save the new patient with the hashed password
    $patient = Patient::create([
        'name' => $validated['name'],
        'gender' => $validated['gender'],
        'age' => $validated['age'],
        'phone' => $validated['phone'],
        'email' => $validated['email'],
        'department' => $validated['department'],
        'year_of_study' => $validated['year_of_study'],
        'password' => bcrypt(1234),
    ]);

    // ✅ Send email with the plain password
    // Mail::to($user->email)->send(new NewUserPasswordMail($randomPassword));

    return view('reception.dashboard')->with('success', 'Patient registered successfully!');
}

}

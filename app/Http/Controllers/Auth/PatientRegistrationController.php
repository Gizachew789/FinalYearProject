<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserPasswordMail;

class PatientRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('reception.patients.register'); // Your registration form view
    }

    public function register(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required|in:male,female',
            'age' => 'nullable|integer',
            'phone' => 'nullable|string|max:20',
        ]);

        // Generate a random password for the patient
        $randomPassword = str_random(8); // Adjust length as needed
        $password = bcrypt($randomPassword); // Encrypt the password before saving

        // Create the patient user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'gender' => $validated['gender'],
            'age' => $validated['age'],
            'phone' => $validated['phone'],
            'role' => 'Patient',
            'password' => $password, // Store encrypted password
        ]);

        // Send the random password to the patient's email
        Mail::to($user->email)->send(new NewUserPasswordMail($randomPassword));

        return redirect()->route('reception.dashboard')->with('success', 'Patient registered successfully!');
    }
}

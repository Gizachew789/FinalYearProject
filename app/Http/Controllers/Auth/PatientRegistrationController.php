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
        'email' => 'required|email|unique:users,email',
        'gender' => 'required',
        'age' => 'integer',
        'phone' => 'string|max:20',
    ]);

    // ✅ Define and encrypt the random password
    $randomPassword = Str::random(8);
    $hashedPassword = bcrypt($randomPassword);

    // ✅ Save the new patient with the hashed password
    $user = Patient::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'gender' => $validated['gender'],
        'age' => $validated['age'],
        'phone_number' => $validated['phone'],
        'password' => $hashedPassword,
    ]);

    // ✅ Send email with the plain password
    Mail::to($user->email)->send(new NewUserPasswordMail($randomPassword));

    return redirect()->route('reception.dashboard')->with('success', 'Patient registered successfully!');
}

}

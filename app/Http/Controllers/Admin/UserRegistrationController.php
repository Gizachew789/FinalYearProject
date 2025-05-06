<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserPasswordMail;
use Spatie\Permission\Models\Role;

class UserRegistrationController extends Controller
{


    public function create()
    {
        return view('admin.register-user');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|integer',
            'gender' => 'required|in:male,female',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:Reception,Pharmacist,Lab_Technician,Health_Officer,Bsc_Nurse',
        ]);

        $randomPassword = \Str::random(10);

        $user = User::create([
            'name' => $validated['name'],
            'age' => $validated['age'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => $randomPassword,
        ]);

        // Assign role via spatie (based on role field)
        $user->assignRole($validated['role']);

        // Send the password email
        Mail::to($user->email)->send(new NewUserPasswordMail($randomPassword));

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'User registered successfully! Temporary password: ' . $randomPassword);
    }
}

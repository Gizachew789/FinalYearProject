<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRegistrationController extends Controller
{
    public function create()
    {
        return view('admin.register-user');
    }




    public function store(Request $request)
 {
    
    // dd($request->all()); // TEMP: Use this to debug

     $validated = $request->validate([
        'name' => 'required|string|max:255',
        'age' => 'nullable|integer',
        'gender' => 'nullable|in:male,female',
        'phone' => 'nullable|string|max:20',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'nullable|in:admin,reception,pharmacist,lab_technician,health_Officer,Bsc_Nurse',
    ]);

   User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'age' => $validated['age'],
        'gender' => $validated['gender'],
        'phone' => $validated['phone'],
        'role' => $validated['role'],
    ]);



    return redirect()->route('admin.dashboard')->with('success', 'User registered successfully!');
}


 }


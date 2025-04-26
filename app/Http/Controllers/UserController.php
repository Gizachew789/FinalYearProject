<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10); // Retrieve all users
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,  // Allow current user email to be unchanged
            'role' => 'required|in:Admin,Reception,Pharmacist,Lab_Technician,Health_Officer,Nurse',
        ]);
    
        // Update the user info with validated data
        $user->update($validated);
    
        // Redirect back to the users list
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete(); // Delete user
        return redirect()->route('admin.users.index');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(15);
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
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'role' => 'required|in:admin,healthOfficer,reception,lab_technician,pharmacist',
        'phone' => 'nullable|string|max:20',
        'status' => 'required|in:active,inactive',
    ]);

    $user->update($validated);

    return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
}

public function destroy(User $user)
{
    $user->delete(); // Delete user
    return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
}
}

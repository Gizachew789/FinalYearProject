<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class userController extends Controller
{
    public function index()
{
    $users = User::all(); // Retrieve all users
    return view('users.index', compact('users'));
}

public function show(User $user)
{
    return view('users.show', compact('user'));
}

public function edit(User $user)
{
    return view('users.edit', compact('user'));
}

public function update(Request $request, User $user)
{
    $user->update($request->all()); // Update user info
    return redirect()->route('users.index');
}

public function destroy(User $user)
{
    $user->delete(); // Delete user
    return redirect()->route('users.index');
}

}

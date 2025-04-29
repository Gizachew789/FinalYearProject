<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate the login request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to find the user by email
        $user = User::where('email', $request->email)->first();

        // Check if the user exists and the password is correct
        if ($user && Hash::check($request->password, $user->password)) {
            // Log the user in
            Auth::login($user);

            // Redirect based on user's role
            if ($user->role == 'Admin') {
                return redirect()->route('admin.dashboard')->with('message', 'Login successful');
            } elseif ($user->role == 'Reception') {
                return redirect()->route('reception.dashboard')->with('message', 'Login successful');
            } elseif ($user->role == 'Physician') {
                return redirect()->route('physician.dashboard')->with('message', 'Login successful');
            } elseif ($user->role == 'Lab_Technician') {
                return redirect()->route('lab.dashboard')->with('message', 'Login successful');
            } elseif ($user->role == 'Pharmacist') {
                return redirect()->route('pharmacist.dashboard')->with('message', 'Login successful');
            } elseif ($user->role == 'Patient') {
                return redirect()->route('patient.dashboard')->with('message', 'Login successful');
            }
        }

        // Redirect back with an error if credentials are invalid
        return redirect()->route('login')->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    /**
     * Redirect the user based on their role after authentication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->role == 'Admin') {
            return redirect()->route('admin.dashboard')->with('message', 'Login successful');
        } elseif ($user->role == 'Reception') {
            return redirect()->route('reception.dashboard')->with('message', 'Login successful');
        } elseif ($user->role == 'Physician') {
            return redirect()->route('physician.dashboard')->with('message', 'Login successful');
        } elseif ($user->role == 'Lab_Technician') {
            return redirect()->route('lab.dashboard')->with('message', 'Login successful');
        } elseif ($user->role == 'Pharmacist') {
            return redirect()->route('pharmacist.dashboard')->with('message', 'Login successful');
        } elseif ($user->role == 'Patient') {
            return redirect()->route('patient.dashboard')->with('message', 'Login successful');
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'Logged out successfully.');
    }
}

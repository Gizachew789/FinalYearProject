<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        // Validate login inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate as a User (staff)
        $user = User::where('email', $request->email)->first();

        // Check if user exists and password is correct
        if ($user && Hash::check($request->password, $user->password)) {
            // Based on role, authenticate with the corresponding guard
            switch ($user->role) {
                case 'Admin':
                    Auth::guard('admin')->login($user);
                    break;
                case 'Reception':
                    Auth::guard('reception')->login($user);
                    break;
                case 'Lab_Technician':
                    Auth::guard('lab_technician')->login($user);
                    break;
                case 'Pharmacist':
                    Auth::guard('pharmacist')->login($user);
                    break;
                case 'Nurse':
                    Auth::guard('nurse')->login($user);
                    break;
                case 'Health_Officer':
                    Auth::guard('health_officer')->login($user);
                    break;
                default:
                    Auth::guard('web')->login($user);
            }

            // Regenerate session to avoid session fixation
            $request->session()->regenerate();

            // Redirect based on the user's role
            return match ($user->role) {
                'Admin' => redirect()->route('admin.dashboard'),
                'Reception' => redirect()->route('reception.dashboard'),
                'Nurse', 'Health_Officer' => redirect()->route('staff.dashboard'),
                'Lab_Technician' => redirect()->route('lab-technician.dashboard'),
                'Pharmacist' => redirect()->route('pharmacist.dashboard'),
                default => redirect('/'), // Default redirect for other roles (e.g., User)
            };
        }

        // Attempt to authenticate as a Patient
        $patient = Patient::where('email', $request->email)->first();

        if ($patient && Hash::check($request->password, $patient->password)) {
            Auth::guard('patient')->login($patient);
            $request->session()->regenerate();
            return redirect()->route('patient.dashboard');
        }

        // If authentication fails for both User and Patient
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }

    // Logout functionality
    public function logout(Request $request)
    {
        // Logout from all possible guards
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        if (Auth::guard('patient')->check()) {
            Auth::guard('patient')->logout();
        }

        // Logout guards for other roles
        Auth::guard('admin')->logout();
        Auth::guard('reception')->logout();
        Auth::guard('lab_technician')->logout();
        Auth::guard('pharmacist')->logout();
        Auth::guard('nurse')->logout();
        Auth::guard('health_officer')->logout();

        // Invalidate and regenerate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'Logged out successfully.');
    }
}

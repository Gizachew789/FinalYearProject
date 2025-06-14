<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /* use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
   /*  public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:reception')->except('logout');
        $this->middleware('guest:lab_technician')->except('logout');
        $this->middleware('guest:pharmacist')->except('logout');
        $this->middleware('guest:patient')->except('logout');
        $this->middleware('guest:nurse')->except('logout');
        $this->middleware('guest:health_officer')->except('logout');
        $this->middleware('auth:admin,reception,lab_technician,pharmacist,patient,nurse,health_officer')->only('logout');
    } */

    /**
     * Handle post-authentication redirection based on guard and role.
  
     */
    /* protected function authenticated(Request $request, $user)
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::guard('reception')->check()) {
            return redirect()->route('reception.dashboard');
        } elseif (Auth::guard('lab_technician')->check()) {
            return redirect()->route('lab.dashboard');
        } elseif (Auth::guard('pharmacist')->check()) {
            return redirect()->route('pharmacist.dashboard');
        } elseif (Auth::guard('patient')->check()) {
            return redirect()->route('patient.dashboard');
        } elseif (Auth::guard('nurse')->check() || Auth::guard('health_officer')->check()) {
            return redirect()->route('staff.dashboard');
        }

        return redirect('/home');
    } */

    public function showLoginForm()
        {
            return view('auth.login');
        }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

       $user = User::where('email', $request->email)->first();
      

        if ($user && Hash::check($request->password, $user->password)) {
            $role = $user->getRoleNames()->first();
            Log::info('Login attempt', [
                'email' => $request->email,
                'role' => $role ?? 'N/A'
            ]);

            // Authenticate with the correct guard based on role
            $guard = match ($role) {
                'Admin' => 'admin',
                'Reception' => 'reception',
                'Lab_Technician' => 'lab_technician',
                'Pharmacist' => 'pharmacist',
                'Nurse' => 'nurse',
                'Health_Officer' => 'health_officer',
                default => 'web',
            };
            Auth::guard($guard)->login($user);
            Log::info('Is user authenticated after login?', ['status' => Auth::guard($guard)->check(), 'guard' => $guard]);

            $request->session()->regenerate();

            // Redirect based on role
            return match ($role) {
                'Admin' => redirect()->route('admin.dashboard'),
                'Reception' => redirect()->route('reception.dashboard'),
                'Nurse', 'Health_Officer' => redirect()->route('staff.dashboard'),
                'Lab_Technician' => redirect()->route('lab.dashboard'),
                'Pharmacist' => redirect()->route('pharmacist.dashboard'),
                default => redirect('/'),
            };
        }

        $patient = Patient::where('email', $request->email)->first();
        if ($patient && Hash::check($request->password, $patient->password)) {
            Auth::guard('patient')->login($patient);
            Log::info('Is patient authenticated after login?', ['status' => Auth::guard('patient')->check()]);
            $request->session()->regenerate();
            return redirect()->route('patient.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }


    public function logout(Request $request)
    {
        foreach (['web', 'admin', 'reception', 'lab_technician', 'pharmacist', 'nurse', 'health_officer', 'patient'] as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'Logged out successfully.');
    }



    /**
     * Show the password reset request form.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Send a password reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }
}
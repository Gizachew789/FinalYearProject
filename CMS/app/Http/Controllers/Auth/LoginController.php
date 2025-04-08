<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
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
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    

  

     
     public function login(Request $request)
     {
         $user = User::where('email', $request->email)->first();
     
         if ($user && Hash::check($request->password, $user->password)) { // ✅ Check hashed password
             Auth::login($user);
             return redirect('/admin/dashboard')->with('message', 'Login successful');
         }
     
         return redirect("/login")->with(['error' => 'Invalid credentials'], 401);
     }
     
    //     public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput($request->except('password'));
    //     }

    //     $credentials = $request->only('email', 'password');
    //     $remember = $request->filled('remember');

    //     if (Auth::attempt($credentials, $remember)) {
    //         $request->session()->regenerate();
            
    //         $user = Auth::user();
            
    //         if ($user->status !== 'active') {
    //             Auth::logout();
                
    //             throw ValidationException::withMessages([
    //                 'email' => ['Your account is inactive. Please contact the administrator.'],
    //             ]);
    //         }
            
    //         // Redirect based on user role
    //         return $this->redirectBasedOnRole($user);
    //     }

    //     throw ValidationException::withMessages([
    //         'email' => [trans('auth.failed')],
    //     ]);
    // }

    /**
     * Redirect the user based on their role.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectBasedOnRole(User $user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'physician':
                return redirect()->route('physician.dashboard');
            case 'reception':
                return redirect()->route('reception.dashboard');
            case 'lab_technician':
                return redirect()->route('lab.dashboard');
            case 'pharmacist':
                return redirect()->route('pharmacy.dashboard');
            case 'patient':
                return redirect()->route('patient.dashboard');
            default:
                return redirect('/');
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

        return redirect('/');
    }
}


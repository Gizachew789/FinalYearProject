<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StaffDashboardController extends Controller
{
    /**
     * Display the shared dashboard for Nurse, Bsc_Nurse, and Health_Officer.
     *
     * @return \Illuminate\View\View
     */
    $appointments = Appointment::with('patient')->get();

    
    public function index()
    {
        $user = Auth::user();

        // Optional: You can perform role-based customization here
        switch ($user->role) {
            case 'Nurse':
                // Nurse-specific logic
                break;
            case 'Bsc_Nurse':
                // Bsc Nurse-specific logic
                break;
            case 'Health_Officer':
                // Health Officer-specific logic
                break;
        }

        return view('staff.dashboard', compact('user', 'appointments', 'patient'));
    }
}

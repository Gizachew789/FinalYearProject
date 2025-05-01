<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Patient;

class DashboardController extends Controller
{
    public function staffDashboard()
    {
        $user = Auth::user();

        // Load all appointments for staff to view
        $appointments = Appointment::with(['patient.user'])
            ->orderBy('appointment_date', 'asc')
            ->get();

        // Try to get a patient associated with the first valid appointment
        $patient = null;

        foreach ($appointments as $appointment) {
            if ($appointment->patient && $appointment->patient->user) {
                $patient = Patient::with(['user', 'medicalRecords', 'labResults', 'prescriptions'])
                    ->find($appointment->patient_id);
                break; // Only load the first available patient
            }
        }

        return view('staff.dashboard', [
            'user' => $user,
            'appointments' => $appointments,
            'patient' => $patient,
        ]);
    }
}

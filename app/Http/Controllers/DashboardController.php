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

        // Load appointments with patient and their associated user
        $appointments = Appointment::with(['patient.user'])
            ->orderBy('appointment_date', 'asc')
            ->get();

        // Optional: Load a specific patient with related data if needed
        // For now, just get the first patient from appointments if exists
        $firstAppointmentWithPatient = $appointments->firstWhere(fn($appt) => $appt->patient && $appt->patient->user);

        $patient = null;
        if ($firstAppointmentWithPatient) {
            $patient = Patient::with(['user', 'medicalRecords', 'labResults', 'prescriptions'])
                ->find($firstAppointmentWithPatient->patient_id);
        }

        return view('staff.dashboard', compact('user', 'appointments', 'patient'));
    }
}

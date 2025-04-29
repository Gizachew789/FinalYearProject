<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalRecord;


class PatientAppointmentController extends Controller
{
    /**
     * Show the form for creating a new appointment.
     */
    public function create()
    {
        return view('patient.appointments.create');
    }

    /**
     * Store a new appointment for the authenticated patient.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date'   => ['required', 'date', 'after_or_equal:today'],
            'time'   => ['required'],
            'reason' => ['required', 'string', 'max:1000'],
        ]);

        Appointment::create([
            'patient_id'        => Auth::id(),
            'created_by'        => Auth::id(), // ✅ required field
            'appointment_date'  => $validated['date'],
            'appointment_time'  => $validated['time'],
            'reason'            => $validated['reason'],
            'status'            => 'pending',
        ]);
        

        return redirect()->route('patient.dashboard')->with('success', 'Appointment requested successfully.');
    }

    public function dashboard()
{
    $userId = Auth::id();

    $upcomingAppointments = Appointment::where('patient_id', $userId)
        ->where('status', 'upcoming')
        ->orderBy('appointment_date', 'asc')
        ->get();

    $pendingAppointments = Appointment::where('patient_id', $userId)
        ->where('status', 'pending')
        ->orderBy('appointment_date', 'asc')
        ->get();

    $completedAppointments = Appointment::where('patient_id', $userId)
        ->where('status', 'completed')
        ->orderBy('appointment_date', 'desc')
        ->get();

    $medicalRecords = MedicalRecord::where('patient_id', $userId)->get();

    return view('patient.dashboard', compact(
        'upcomingAppointments',
        'pendingAppointments',
        'completedAppointments',
        'medicalRecords'
    ));
}

}


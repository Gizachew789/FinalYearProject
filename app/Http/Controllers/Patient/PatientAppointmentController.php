<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Log;


class PatientAppointmentController extends Controller
{
    /**
     * Show the form for creating a new appointment.
     */

     public function index()
     {
         // Get all appointments for all patients
         $appointments = Appointment::with('patient')->get();
     
         $upcomingAppointments = $appointments->where('status', 'scheduled');
         $pendingAppointments = $appointments->where('status', 'pending');
         $completedAppointments = $appointments->where('status', 'completed');
     
         // Each patient sees their own medical records only
         $medicalRecords = MedicalRecord::where('patient_id', auth()->user()->patient_id)->latest()->get();
     
         return view('patient.dashboard', compact(
             'upcomingAppointments',
             'pendingAppointments',
             'completedAppointments',
             'medicalRecords'
         ));
     }

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


    // This part will not be reached until dd() is removed
    Appointment::create([
        'patient_id'        => Auth::id(),
        'created_by'        => Auth::user()->patient_id,
        'appointment_date'  => $validated['date'],
        'appointment_time'  => $validated['time'],
        'reason'            => $validated['reason'],
        'status'            => 'pending',  // Set default status
    ]);
    return redirect()->route('patient.dashboard')->with('success', 'Appointment Booked Successfully!!!');
 }

 public function cancel(Appointment $appointment)
{
    // Ensure the current user is the one who booked the appointment (or has the right permission)
    if ($appointment->patient_id !== Auth::id()) {
        return redirect()->route('patient.dashboard')->with('error', 'You can only cancel your own appointments.');
    }

    // Set the appointment status to 'canceled'
    $appointment->update([
        'status' => 'canceled'
    ]);

    // Optionally, you can add any other logic, such as notifying the user or others about the cancellation.

    return redirect()->route('patient.dashboard')->with('success', 'Appointment canceled successfully.');
}

  

  public function dashboard()
  {
      // Show all appointments (not just the ones booked by this user)
      $upcomingAppointments = Appointment::where('status', 'upcoming')
          ->orderBy('appointment_date', 'asc')
          ->get();
  
      $pendingAppointments = Appointment::where('status', 'pending')
          ->orderBy('appointment_date', 'asc')
          ->get();
  
      // But only fetch medical records for the logged-in patient
      $userId = Auth::id();
      $medicalRecords = MedicalRecord::where('patient_id', $userId)->get();
  
      return view('patient.dashboard', compact(
          'upcomingAppointments',
          'pendingAppointments',
          'medicalRecords'
      ));
  }
  
}

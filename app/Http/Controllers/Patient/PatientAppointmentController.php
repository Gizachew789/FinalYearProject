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

   public function index(Request $request)
{
    $query = Appointment::with(['patient', 'creator']); // Assuming you have a 'creator' relationship

    if ($request->filled('appointment_status')) {
        $query->where('status', $request->appointment_status);
    }

    $appointments = $query->latest()->get();

    return view('patient.dashboard', compact('appointments'));
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

    $user = Auth::user();

    Appointment::create([
        'patient_id'        => $user->patient_id,
        'appointment_date'  => $validated['date'],
        'appointment_time'  => $validated['time'],
        'reason'            => $validated['reason'],
        'status'            => 'pending',
        // 'created_by' => removed
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

  

  /* public function dashboard()
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
  } */
  
 /* public function fetchAppointments(Request $request)
    {
        Log::info("logo",$request->all());
        // Start the query with relationships loaded
        $query = Appointment::with(['patient', 'creator']);

        // Filter by status if provided
        if ($request->filled('appointment_status')) {
            $query->where('status', $request->appointment_status);
        }

        // Paginate results
        $appointments = $query->latest()->paginate(10);

        // Fetch users for user management (from original controller)
        $usersQuery = User::with('roles');
        if ($request->filled('user_search')) {
            $search = $request->user_search;
            $usersQuery->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        if ($request->filled('user_role')) {
            $role = $request->user_role;
            $usersQuery->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }
        $users = $usersQuery->latest()->paginate(10);

        // Fetch medications for inventory management (from original controller)

        // Return the view with all data
        return view('patient.dashboard', compact('appointments'));
    } */



  
}

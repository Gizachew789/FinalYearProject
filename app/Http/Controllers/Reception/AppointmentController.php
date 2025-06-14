<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    // Display all appointments
  public function index(Request $request)
{
    $query = Appointment::with('patient');

    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->whereHas('patient', function ($q2) use ($search) {
                $q2->where('name', 'like', "%{$search}%")
                   ->orWhere('patient_id', $search);
            })
            ->orWhere('appointment_date', 'like', "%{$search}%")
            ->orWhere('status', 'like', "%{$search}%");
        });
    }

    $appointments = $query->latest()->get();

    // Dynamically choose view for staff or reception
    $view = view()->exists('staff.appointments.index')
        ? 'staff.appointments.index'
        : 'reception.appointments.index';

    return view($view, compact('appointments'));
}



    // Show the appointment creation form
    public function create()
    { 
        $patients = Patient::all(); // To select the patient while booking
        $receptions = User::role('Reception')->get();
        return view('reception.appointments.create', compact('patients', 'receptions'));
    }

    // Store a new appointment
   public function store(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'patient_id' => 'required|exists:patients,patient_id',
        'appointment_date' => 'required|date',
        'appointment_time' => 'required|date_format:H:i',
        'reason' => 'nullable|string|max:255',
    ]);

    // Create a new appointment
    Appointment::create([
        'patient_id' => $request->input('patient_id'),
        'appointment_date' => $request->input('appointment_date'),
        'appointment_time' => $request->input('appointment_time'),
        'reason' => $request->input('reason'),
        'reception_id' => $request->input('reception_id'), // keep this if you're using it
        // 'created_by' => removed
    ]);

    // Redirect to a specific page (e.g., appointment index page)
    return redirect()->route('reception.appointments.index')->with('success', 'Appointment booked successfully.');
}


    // Optional: View a single appointment
    public function show(Appointment $appointment)
    {
        return view('reception.appointments.show', compact('appointment'));
    }

    // Optional: Edit appointment (not necessary now but useful)
    // public function edit(Appointment $appointment)
    // {
    //     $patients = Patient::all();
    //     return view('reception.appointments.edit', compact('appointment', 'patients'));
    // }

    // Optional: Update appointment
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,patient_id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'reason' => 'nullable|string|max:500',
        ]);

        $appointment->update($validated);

        return redirect()->route('reception.appointments.index')->with('success', 'Appointment updated successfully.');
    }
    public function accept($patientId)
    {
        $appointments = Appointment::where('patient_id', $patientId)->get();
    
        if ($appointments->isEmpty()) {
            return redirect()->route('staff.dashboard')->with('error', 'Appointment not found.');
        }
    
        // Complete the appointment
        foreach ($appointments as $appointment) {

        $appointment->status = 'completed';
        $appointment->save();
        }
    
        return view('staff.appointments.accept', compact('appointment'));
    }
    

    // Optional: Delete appointment
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('staff.appointments.index')->with('success', 'Appointment deleted successfully.');
    }

//     public function search(Request $request)
// {
//     $request->validate([
//         'search' => 'required|string',
//     ]);
//  $search =$request->query("search");
//     $appointments = Appointment::with('patient')
//         ->where('patient_id', $search)
//         ->get();

//     return view('staff.appointments.show', compact('appointments')); // or whichever view contains your modal
// }

public function showappointment(){
    $appointments = Appointment::get();
    return view('staff.appointments.show', compact('appointments')); // or whichever view contains your modal
 }

 public function showAppointments()
{
    $appointments = Appointment::whereDate('date', '>=', Carbon::today())
        ->orderBy('date')
        ->orderBy('time')
        ->get();

    return view('reception.dashboard', compact('appointments'));
}
  public function fetchAppointments(Request $request)
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
        return view('reception.dashboard', compact('appointments'));
    }
    
        public function dashboard()
    {
        $appointments = Appointment::with(['patient','reception','creator'])
            ->orderBy('appointment_date', 'asc')
            ->take(10) 
            ->get();

        return view('reception.dashboard', compact('appointments'));
    }
 }


 

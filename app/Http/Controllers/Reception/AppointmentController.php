<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Display all appointments
    public function index()
    {
        $appointments = Appointment::with('patient')->latest()->get(); // eager load patient

        return view('reception.appointments.index', compact('appointments'));
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
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'reason' => 'nullable|string|max:255',
            'reception_id' => 'required|exists:users,id',
            'created_by' => 'required|string',
        ]);

        // Create a new appointment
        Appointment::create([
            'patient_id' => $request->input('patient_id'),
            'appointment_date' => $request->input('appointment_date'),
            'appointment_time' => $request->input('appointment_time'),
            'reason' => $request->input('reason'),
            'reception_id' => $request->input('reception_id'),
            'created_by' => $request->input('created_by'),
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
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'reason' => 'nullable|string|max:500',
        ]);

        $appointment->update($validated);

        return redirect()->route('reception.appointments.index')->with('success', 'Appointment updated successfully.');
    }

    public function accept($id)
  {
    $appointment = Appointment::findOrFail($id);
    $appointment->status = 'confirmed';
    $appointment->save();

    return redirect()->back()->with('success', 'Appointment accepted successfully.');
  }

    // Optional: Delete appointment
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('reception.appointments.index')->with('success', 'Appointment deleted successfully.');
    }
 }

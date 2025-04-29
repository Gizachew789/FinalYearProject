<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
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
        return view('reception.appointments.create', compact('patients'));
    }

    // Store a new appointment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'description' => 'nullable|string|max:500',
        ]);

        Appointment::create($validated);

        return redirect()->route('reception.appointments.index')->with('success', 'Appointment booked successfully.');
    }

    // Optional: View a single appointment
    public function show(Appointment $appointment)
    {
        return view('reception.appointments.show', compact('appointment'));
    }

    // Optional: Edit appointment (not necessary now but useful)
    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();
        return view('reception.appointments.edit', compact('appointment', 'patients'));
    }

    // Optional: Update appointment
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'description' => 'nullable|string|max:500',
        ]);

        $appointment->update($validated);

        return redirect()->route('reception.appointments.index')->with('success', 'Appointment updated successfully.');
    }

    // Optional: Delete appointment
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('reception.appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}

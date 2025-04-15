<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Notification;
use App\Models\Physician;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the appointments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Appointment::with(['patient.user', 'physician.user']);

        if ($user->isPatient()) {
            $query->where('patient_id', $user->patient->id);
        } elseif ($user->isPhysician()) {
            $query->where('physician_id', $user->physician->id);
        }

        // Filter by date
        if ($request->has('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $appointments = $query->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->paginate(10);

        return response()->json([
            'appointments' => $appointments,
        ]);
    }

    /**
     * Store a newly created appointment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'physician_id' => 'required|exists:physicians,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'reason' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();
        
        // Check if the user is a patient or reception
        if (!$user->isPatient() && !$user->isReception() && !$user->isAdmin()) {
            return response()->json([
                'message' => 'Only patients, reception staff, or admins can book appointments',
            ], 403);
        }

        // If patient is booking, ensure they're booking for themselves
        if ($user->isPatient() && $user->patient->id != $request->patient_id) {
            return response()->json([
                'message' => 'You can only book appointments for yourself',
            ], 403);
        }

        // Check if the physician exists and is available
        $physician = Physician::findOrFail($request->physician_id);
        
        // Create the appointment
        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'physician_id' => $request->physician_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'reason' => $request->reason,
            'status' => 'pending',
            'created_by' => $user->id,
        ]);

        // Create notification for the physician
        Notification::create([
            'user_id' => $physician->user_id,
            'title' => 'New Appointment',
            'message' => 'You have a new appointment request',
            'type' => 'appointment',
            'related_id' => $appointment->id,
            'related_type' => Appointment::class,
        ]);

        // Create notification for the patient if booked by reception
        if ($user->isReception() || $user->isAdmin()) {
            $patient = Patient::findOrFail($request->patient_id);
            Notification::create([
                'user_id' => $patient->user_id,
                'title' => 'New Appointment',
                'message' => 'An appointment has been scheduled for you',
                'type' => 'appointment',
                'related_id' => $appointment->id,
                'related_type' => Appointment::class,
            ]);
        }

        return response()->json([
            'message' => 'Appointment created successfully',
            'appointment' => $appointment->load(['patient.user', 'physician.user']),
        ], 201);
    }

    /**
     * Display the specified appointment.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $user = $request->user();
        $appointment = Appointment::with(['patient.user', 'physician.user'])->findOrFail($id);

        // Check if the user has permission to view this appointment
        if ($user->isPatient() && $appointment->patient_id !== $user->patient->id) {
            return response()->json([
                'message' => 'You do not have permission to view this appointment',
            ], 403);
        }

        if ($user->isPhysician() && $appointment->physician_id !== $user->physician->id) {
            return response()->json([
                'message' => 'You do not have permission to view this appointment',
            ], 403);
        }

        return response()->json([
            'appointment' => $appointment,
        ]);
    }

    /**
     * Update the specified appointment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();
        $appointment = Appointment::findOrFail($id);

        // Check if the user has permission to update this appointment
        if ($user->isPatient() && $appointment->patient_id !== $user->patient->id) {
            return response()->json([
                'message' => 'You do not have permission to update this appointment',
            ], 403);
        }

        if ($user->isPhysician() && $appointment->physician_id !== $user->physician->id) {
            return response()->json([
                'message' => 'You do not have permission to update this appointment',
            ], 403);
        }

        // Patients can only cancel appointments
        if ($user->isPatient() && $request->status !== 'cancelled') {
            return response()->json([
                'message' => 'Patients can only cancel appointments',
            ], 403);
        }

        $oldStatus = $appointment->status;
        $appointment->status = $request->status;
        $appointment->notes = $request->notes;
        $appointment->save();

        // Create notification for the patient if status changed by physician or reception
        if (($user->isPhysician() || $user->isReception() || $user->isAdmin()) && $oldStatus !== $request->status) {
            Notification::create([
                'user_id' => $appointment->patient->user_id,
                'title' => 'Appointment Status Updated',
                'message' => 'Your appointment status has been updated to ' . $request->status,
                'type' => 'appointment',
                'related_id' => $appointment->id,
                'related_type' => Appointment::class,
            ]);
        }

        // Create notification for the physician if appointment cancelled by patient
        if ($user->isPatient() && $request->status === 'cancelled') {
            Notification::create([
                'user_id' => $appointment->physician->user_id,
                'title' => 'Appointment Cancelled',
                'message' => 'An appointment has been cancelled by a patient',
                'type' => 'appointment',
                'related_id' => $appointment->id,
                'related_type' => Appointment::class,
            ]);
        }

        return response()->json([
            'message' => 'Appointment updated successfully',
            'appointment' => $appointment->load(['patient.user', 'physician.user']),
        ]);
    }

    /**
     * Remove the specified appointment from storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $user = $request->user();
        
        // Only admins can delete appointments
        if (!$user->isAdmin()) {
            return response()->json([
                'message' => 'Only administrators can delete appointments',
            ], 403);
        }

        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return response()->json([
            'message' => 'Appointment deleted successfully',
        ]);
    }

    /**
     * Get available physicians for appointments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function availablePhysicians(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Get day of week from the date
        $dayOfWeek = strtolower(date('l', strtotime($request->date)));

        // Get physicians with schedules for that day
        $physicians = Physician::with(['user', 'schedules' => function ($query) use ($dayOfWeek) {
            $query->where('day_of_week', $dayOfWeek)
                  ->where('is_available', true);
        }])
        ->whereHas('schedules', function ($query) use ($dayOfWeek) {
            $query->where('day_of_week', $dayOfWeek)
                  ->where('is_available', true);
        })
        ->get();

        return response()->json([
            'physicians' => $physicians,
        ]);
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Dashboard;
use App\Models\Medication;
use App\Models\Patient;
use App\Models\Physician;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics and user-specific dashboard settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $stats = [];

        // Get or create user's dashboard
        $dashboard = Dashboard::firstOrCreate(['user_id' => $user->id]);

        // Admin and reception can see all stats
        if ($user->isAdmin() || $user->isReception()) {
            // Total patients
            $stats['total_patients'] = Patient::count();

            // Total physicians
            $stats['total_physicians'] = Physician::count();

            // Total appointments today
            $stats['appointments_today'] = Appointment::whereDate('appointment_date', today())->count();

            // Appointments by status
            $stats['appointments_by_status'] = Appointment::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status')
                ->toArray();

            // Low stock medications
            $stats['low_stock_medications'] = Medication::whereRaw('current_stock <= reorder_level')->count();

            // Recent appointments
            $stats['recent_appointments'] = Appointment::with(['patient.user', 'physician.user'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        // Physician-specific stats
        if ($user->isPhysician()) {
            // Physician's appointments today
            $stats['appointments_today'] = Appointment::where('physician_id', $user->physician->id)
                ->whereDate('appointment_date', today())
                ->count();

            // Physician's upcoming appointments
            $stats['upcoming_appointments'] = Appointment::with(['patient.user'])
                ->where('physician_id', $user->physician->id)
                ->where('appointment_date', '>=', today())
                ->where('status', '!=', 'cancelled')
                ->orderBy('appointment_date')
                ->orderBy('appointment_time')
                ->limit(5)
                ->get();

            // Physician's appointment stats
            $stats['appointments_by_status'] = Appointment::where('physician_id', $user->physician->id)
                ->select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status')
                ->toArray();
        }

        // Patient-specific stats
        if ($user->isPatient()) {
            // Patient's upcoming appointments
            $stats['upcoming_appointments'] = Appointment::with(['physician.user'])
                ->where('patient_id', $user->patient->id)
                ->where('appointment_date', '>=', today())
                ->where('status', '!=', 'cancelled')
                ->orderBy('appointment_date')
                ->orderBy('appointment_time')
                ->limit(5)
                ->get();

            // Patient's recent prescriptions
            $stats['recent_prescriptions'] = $user->patient->prescriptions()
                ->with(['physician.user', 'items.medication'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        return response()->json([
            'stats' => $stats,
            'dashboard' => $dashboard,
        ]);
    }

    /**
     * Update user's dashboard settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSettings(Request $request)
    {
        $user = $request->user();
        $dashboard = Dashboard::firstOrCreate(['user_id' => $user->id]);

        $validatedData = $request->validate([
            'layout' => 'nullable|json',
            'preferences' => 'nullable|json',
        ]);

        $dashboard->update($validatedData);

        return response()->json([
            'message' => 'Dashboard settings updated successfully',
            'dashboard' => $dashboard,
        ]);
    }

    /**
     * Get appointment statistics.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function appointmentStats(Request $request)
    {
        $user = $request->user();
        
        // Only admin and reception can access this
        if (!$user->isAdmin() && !$user->isReception()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 404);
        }

        // Appointments by day of week
        $appointmentsByDay = Appointment::select(
                DB::raw('DAYNAME(appointment_date) as day'),
                DB::raw('count(*) as count')
            )
            ->groupBy('day')
            ->orderByRaw('FIELD(day, "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday")')
            ->get()
            ->pluck('count', 'day')
            ->toArray();

        // Appointments by month
        $appointmentsByMonth = Appointment::select(
                DB::raw('MONTHNAME(appointment_date) as month'),
                DB::raw('count(*) as count')
            )
            ->groupBy('month')
            ->orderByRaw('MONTH(appointment_date)')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        return response()->json([
            'by_day' => $appointmentsByDay,
            'by_month' => $appointmentsByMonth,
        ]);
    }
}


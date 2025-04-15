<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    /**
     * Generate appointment reports.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function appointmentReports(Request $request)
    {
        $user = $request->user();
        
        // Only admin and reception can access this
        if (!$user->isAdmin() && !$user->isReception()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        // Date range filter
        $startDate = $request->input('start_date', now()->subMonth());
        $endDate = $request->input('end_date', now());

        // Appointments by status
        $appointmentsByStatus = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Appointments by reception
        $appointmentsByReception = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->select('reception_id', DB::raw('count(*) as total_appointments'))
            ->groupBy('reception_id')
            ->with('reception.user:id,name')
            ->get();

        // Appointments by day of week
        $appointmentsByDay = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->select(DB::raw('DAYNAME(appointment_date) as day'), DB::raw('count(*) as count'))
            ->groupBy('day')
            ->orderByRaw('FIELD(day, "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday")')
            ->get();

        return response()->json([
            'by_status' => $appointmentsByStatus,
            'by_reception' => $appointmentsByReception,
            'by_day' => $appointmentsByDay,
            'date_range' => [
                'start_date' => $startDate,
                'end_date' => $endDate
            ]
        ]);
    }

    /**
     * Generate inventory reports.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function inventoryReports(Request $request)
    {
        $user = $request->user();
        
        // Only admin and users can access this
        if (!$user->isAdmin() && !$user->isUser()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        // Date range filter
        $startDate = $request->input('start_date', now()->subMonth());
        $endDate = $request->input('end_date', now());

        // Low stock medications
        $lowStockMedications = Medication::whereRaw('current_stock <= reorder_level')
            ->orderBy('current_stock')
            ->get();

        // Most used medications
        $mostUsedMedications = InventoryTransaction::whereBetween('transaction_date', [$startDate, $endDate])
            ->where('transaction_type', 'out')
            ->select('medication_id', DB::raw('SUM(quantity) as total_used'))
            ->groupBy('medication_id')
            ->with('medication:id,name,current_stock')
            ->orderByDesc('total_used')
            ->limit(10)
            ->get();


        return response()->json([
            'low_stock' => $lowStockMedications,
            'most_used' => $mostUsedMedications,
            'date_range' => [
                'start_date' => $startDate,
                'end_date' => $endDate
            ]
        ]);
    }

    /**
     * Generate user performance reports.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userPerformanceReports(Request $request)
    {
        $user = $request->user();
        
        // Only admin and users can access this
        if (!$user->isAdmin() && !$user->isUser()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        // Date range filter
        $startDate = $request->input('start_date', now()->subMonth());
        $endDate = $request->input('end_date', now());

        // Appointments completed by reception
        $appointmentsByReception = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->select(
                'reception_id',
                DB::raw('count(*) as total_appointments'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_appointments'),
                DB::raw('SUM(CASE WHEN status = "cancelled" THEN 1 ELSE 0 END) as cancelled_appointments')
            )
            ->groupBy('reception_id')
            ->with('reception.user:id,name')
            ->get();

        // Medical records created by user
        $medicalRecordsByUser = DB::table('medical_records')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('created_by', DB::raw('count(*) as count'))
            ->groupBy('created_by')
            ->get();

        // Prescriptions by user
        $prescriptionsByUser = DB::table('prescriptions')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('prescribed_by', DB::raw('count(*) as count'))
            ->groupBy('prescribed_by')
            ->get();

        return response()->json([
            'appointments' => $appointmentsByReception,
            'medical_records' => $medicalRecordsByUser,
            'prescriptions' => $prescriptionsByUser,
            'date_range' => [
                'start_date' => $startDate,
                'end_date' => $endDate
            ]
        ]);
    }

    /**
     * Export report as CSV or PDF.
     *
     * @param  string  $type
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportReport($type, Request $request)
    {
        $user = $request->user();
        
        // Only admin and reception can access this
        if (!$user->isAdmin() && !$user->isReception()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $reportType = $request->input('report_type', 'appointments');
        $format = $request->input('format', 'csv');
        
        // Generate report data based on type
        switch ($reportType) {
            case 'appointments':
                $data = $this->generateAppointmentReportData($request);
                break;
            case 'inventory':
                $data = $this->generateInventoryReportData($request);
                break;
            case 'users':
                $data = $this->generateUserReportData($request);
                break;
            default:
                return response()->json([
                    'message' => 'Invalid report type',
                ], 400);
        }

        // Export based on format
        if ($format === 'csv') {
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $reportType . '_report.csv"',
            ];

            $callback = function() use ($data) {
                $file = fopen('php://output', 'w');
                
                // Add headers
                fputcsv($file, array_keys($data[0]));
                
                // Add data
                foreach ($data as $row) {
                    fputcsv($file, $row);
                }
                
                fclose($file);
            };

            return Response::stream($callback, 200, $headers);
        } else {
            // For PDF, we would typically use a library like DomPDF
            // This is a simplified example
            return response()->json([
                'message' => 'PDF export not implemented in this example',
            ], 501);
        }
    }

    /**
     * Generate appointment report data for export.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function generateAppointmentReportData(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth());
        $endDate = $request->input('end_date', now());

        $appointments = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->with(['patient.user', 'reception.user'])
            ->get();

        $data = [];
        foreach ($appointments as $appointment) {
            $data[] = [
                'ID' => $appointment->id,
                'Patient' => $appointment->patient->user->name,
                'Reception' => $appointment->reception->user->name,
                'Date' => $appointment->appointment_date,
                'Time' => $appointment->appointment_time,
                'Status' => $appointment->status,
                'Reason' => $appointment->reason,
            ];
        }

        return $data;
    }

    /**
     * Generate inventory report data for export.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function generateInventoryReportData(Request $request)
    {
        $medications = Medication::all();

        $data = [];
        foreach ($medications as $medication) {
            $data[] = [
                'ID' => $medication->id,
                'Name' => $medication->name,
                'Category' => $medication->category,
                'Current Stock' => $medication->current_stock,
                'Reorder Level' => $medication->reorder_level,
                'Unit' => $medication->unit,
                'Manufacturer' => $medication->manufacturer,
                'Expiry Date' => $medication->expiry_date,
            ];
        }

        return $data;
    }

    /**
     * Generate user report data for export.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function generateUserReportData(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth());
        $endDate = $request->input('end_date', now());

        $users = User::with('physician')->get();

        $data = [];
        foreach ($users as $user) {
            $appointmentCount = Appointment::where('physician_id', $user->id) // Updated to use $user->id
                ->whereBetween('appointment_date', [$startDate, $endDate])
                ->count();
                
            $completedAppointments = Appointment::where('physician_id', $user->id)
                ->where('status', 'completed')
                ->whereBetween('appointment_date', [$startDate, $endDate])
                ->count();

            $data[] = [
                'ID' => $user->id,
                'Name' => $user->physician->name,
                'Specialization' => $user->physician->specialization, // Updated to use $user->physician
                'Total Appointments' => $appointmentCount,
                'Completed Appointments' => $completedAppointments,
                'Completion Rate' => $appointmentCount > 0 ? round(($completedAppointments / $appointmentCount) * 100, 2) . '%' : '0%',
            ];
        }

        return $data;
    }
}


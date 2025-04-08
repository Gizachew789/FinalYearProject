<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Medication;
use App\Models\Physician;
use App\Models\InventoryTransaction;
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

        // Appointments by physician
        $appointmentsByPhysician = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->select('physician_id', DB::raw('count(*) as count'))
            ->groupBy('physician_id')
            ->with('physician.user:id,name')
            ->get();

        // Appointments by day of week
        $appointmentsByDay = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->select(DB::raw('DAYNAME(appointment_date) as day'), DB::raw('count(*) as count'))
            ->groupBy('day')
            ->orderByRaw('FIELD(day, "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday")')
            ->get();

        return response()->json([
            'by_status' => $appointmentsByStatus,
            'by_physician' => $appointmentsByPhysician,
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
        
        // Only admin and reception can access this
        if (!$user->isAdmin() && !$user->isReception()) {
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

        // Inventory value
        $inventoryValue = Medication::sum(DB::raw('current_stock * price'));

        return response()->json([
            'low_stock' => $lowStockMedications,
            'most_used' => $mostUsedMedications,
            'inventory_value' => $inventoryValue,
            'date_range' => [
                'start_date' => $startDate,
                'end_date' => $endDate
            ]
        ]);
    }

    /**
     * Generate physician performance reports.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function physicianPerformanceReports(Request $request)
    {
        $user = $request->user();
        
        // Only admin can access this
        if (!$user->isAdmin()) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        // Date range filter
        $startDate = $request->input('start_date', now()->subMonth());
        $endDate = $request->input('end_date', now());

        // Appointments completed by physician
        $appointmentsByPhysician = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->select(
                'physician_id',
                DB::raw('count(*) as total_appointments'),
                DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed_appointments'),
                DB::raw('SUM(CASE WHEN status = "cancelled" THEN 1 ELSE 0 END) as cancelled_appointments')
            )
            ->groupBy('physician_id')
            ->with('physician.user:id,name')
            ->get();

        // Medical records created by physician
        $medicalRecordsByPhysician = DB::table('medical_records')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('created_by', DB::raw('count(*) as count'))
            ->groupBy('created_by')
            ->get();

        // Prescriptions by physician
        $prescriptionsByPhysician = DB::table('prescriptions')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('prescribed_by', DB::raw('count(*) as count'))
            ->groupBy('prescribed_by')
            ->get();

        return response()->json([
            'appointments' => $appointmentsByPhysician,
            'medical_records' => $medicalRecordsByPhysician,
            'prescriptions' => $prescriptionsByPhysician,
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
            case 'physicians':
                $data = $this->generatePhysicianReportData($request);
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
            ->with(['patient.user', 'physician.user'])
            ->get();

        $data = [];
        foreach ($appointments as $appointment) {
            $data[] = [
                'ID' => $appointment->id,
                'Patient' => $appointment->patient->user->name,
                'Physician' => $appointment->physician->user->name,
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
                'Price' => $medication->price,
                'Manufacturer' => $medication->manufacturer,
                'Expiry Date' => $medication->expiry_date,
            ];
        }

        return $data;
    }

    /**
     * Generate physician report data for export.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function generatePhysicianReportData(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth());
        $endDate = $request->input('end_date', now());

        $physicians = Physician::with('user')->get();

        $data = [];
        foreach ($physicians as $physician) {
            $appointmentCount = Appointment::where('physician_id', $physician->id)
                ->whereBetween('appointment_date', [$startDate, $endDate])
                ->count();
                
            $completedAppointments = Appointment::where('physician_id', $physician->id)
                ->where('status', 'completed')
                ->whereBetween('appointment_date', [$startDate, $endDate])
                ->count();

            $data[] = [
                'ID' => $physician->id,
                'Name' => $physician->user->name,
                'Specialization' => $physician->specialization,
                'Total Appointments' => $appointmentCount,
                'Completed Appointments' => $completedAppointments,
                'Completion Rate' => $appointmentCount > 0 ? round(($completedAppointments / $appointmentCount) * 100, 2) . '%' : '0%',
            ];
        }

        return $data;
    }
}


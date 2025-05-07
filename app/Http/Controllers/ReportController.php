<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Medication;
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
     * 
     * 
     */
    public function __construct()
    {
    $this->middleware('auth');
   
    $this->middleware('permission:report-manage', ['only' => ['report', 'manage']]);
  
     }

    public function appointmentReports(Request $request)
    {
       
 
        // $user = $request->user();

        // \Log::info('Current user:', [
        //     'id' => $user->id,
        //     'roles' => $user->getRoleNames(),
        // ]);
        
        // // Only admin and reception can access this
        // if (!$user->isAdmin() && !$user->isReception()) {
        //     \Log::warning('Access blocked', [
        //         'is_admin' => $user->isAdmin(),
        //         'is_reception' => $user->isReception(),
        //     ]);
        //     abort(403, 'Unauthorized');
        // }
    
        // Date range filter
        $startDate = $request->input('start_date', now()->subMonth());
        $endDate = $request->input('end_date', now());
        
        // Status filter (if provided)
        $statusFilter = $request->input('status');
    
        // Appointments query with date range and status filter
        $appointmentsQuery = Appointment::whereBetween('appointment_date', [$startDate, $endDate]);
    
        if ($statusFilter) {
            $appointmentsQuery->where('status', $statusFilter);
        }
    
        // Fetching the appointments with pagination and related data
        $appointments = $appointmentsQuery->with('patient', 'reception') // Ensure relationships are defined correctly in models
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);
    
        // Return the view with the appointments data
        return view('admin.reports.appointments', compact('appointments'));
    }
    
    /**
     * Generate inventory reports.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function inventoryReports(Request $request)
{
    // $user = $request->user();
    
    // // Only admin and users can access this
    // if (!$user->isAdmin()) {
    //     return response()->json([
    //         'message' => 'Unauthorized',
    //     ], 403);
    // }

    // Date range filters
    $startDate = $request->input('start_date', now()->subMonth());
    $endDate = $request->input('end_date', now());

    // Base query for medications
    $medicationQuery = Medication::query();

    // Filter by category
    if ($request->filled('category')) {
        $medicationQuery->where('category', $request->input('category'));
    }

    // Filter by search keyword (name)
    if ($request->filled('search')) {
        $medicationQuery->where('name', 'like', '%' . $request->input('search') . '%');
    }

    // Filter by low stock
    if ($request->input('low_stock') === 'true') {
        $medicationQuery->whereColumn('current_stock', '<=', 'reorder_level');
    }

    // Final filtered result
    $lowStockMedications = $medicationQuery->orderBy('current_stock')->get();

    // Most used medications
    $mostUsedMedications = InventoryTransaction::whereBetween('transaction_date', [$startDate, $endDate])
        ->where('transaction_type', 'out')
        ->select('medication_id', DB::raw('SUM(quantity) as total_used'))
        ->groupBy('medication_id')
        ->with('medication:id,name,current_stock')
        ->orderByDesc('total_used')
        ->limit(10)
        ->get();

    // All distinct categories for filter dropdown
    $categories = Medication::select('category')->distinct()->pluck('category');

    return view('admin.reports.inventory', [
        'low_stock' => $lowStockMedications,
        'most_used' => $mostUsedMedications,
        'date_range' => [
            'start_date' => $startDate,
            'end_date' => $endDate
        ],
        'categories' => $categories,
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
        // $user = $request->user();
    
        // // Only admin and users can access this
        // if (!$user->isAdmin() && !$user->isUser()) {
        //     return response()->json([
        //         'message' => 'Unauthorized',
        //     ], 403);
        // }
    
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
            ->with('reception.user:id,name') // Ensure you're fetching the user data for reception
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
            ->select('prescriber_id', DB::raw('count(*) as count'))
            ->groupBy('prescriber_id')
            ->get();
    
        // Fetch users for the performance reports (if you want to show them in the report)
        $users = User::whereIn('id', $appointmentsByReception->pluck('reception_id') // Collect reception_ids
            ->merge($medicalRecordsByUser->pluck('created_by')) // Collect created_by from medical records
            ->merge($prescriptionsByUser->pluck('prescriber_id'))) // Collect prescriber_ids from prescriptions
            ->get();
    
        return view('admin.reports.user_performance', [
            'appointments' => $appointmentsByReception,
            'medical_records' => $medicalRecordsByUser,
            'prescriptions' => $prescriptionsByUser,
            'date_range' => [
                'start_date' => $startDate,
                'end_date' => $endDate
            ],
            'users' => $users // Pass the users data to the view
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
        // Get date range from request or default to last month to today
        $startDate = $request->input('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
    
        // Fetch appointments within the date range
        $appointments = Appointment::whereBetween('appointment_date', [$startDate, $endDate])
            ->with(['patient.user', 'reception.user']) // Eager load patient and reception users
            ->get();
    
        // Prepare the data for the report
        $data = [];
        foreach ($appointments as $appointment) {
            // Handle cases where relations might be missing (e.g., optional relationships)
            $data[] = [
                'ID' => $appointment->id,
                'Patient' => optional($appointment->patient->user)->name ?? 'N/A',
                'Reception' => optional($appointment->reception->user)->name ?? 'N/A',
                'Date' => $appointment->appointment_date,
                'Time' => $appointment->appointment_time,
                'Status' => ucfirst($appointment->status),  // Capitalize status
                'Reason' => $appointment->reason,
            ];
        }
    
        return $data;
    }


       public function generateAppointmentReport(Request $request)
   {
     $reportData = $this->generateAppointmentReportData($request);

     // Process or export the data (e.g., to CSV, Excel, etc.)
     // Return the data to the view, or initiate file download
     return view('admin.reports.appointment_report', compact('reportData'));
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


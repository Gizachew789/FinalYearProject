<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class AttendanceController extends Controller
{
    /**
     * Display a listing of the attendances.
     */

public function index()
{
    $today = Carbon::today()->toDateString();

    // Fetch all users with their roles
    $users = User::with('roles')->get();

    // Get all today's attendance records indexed by user_id for quick access
    $attendances = Attendance::whereDate('date', $today)
        ->get()
        ->keyBy('user_id');

    return view('admin.attendance.index', compact('users', 'attendances'));
}



    /**
     * Store a newly created attendance in storage.
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'date' => 'required|date',
       /*  'check_in' => 'nullable|date_format:H:i',
        'check_out' => 'nullable|date_format:H:i', */
        'status' => 'required|in:present,absent,late,half_day',
    ]);

    $attendance = new Attendance([
        'user_id' => $validated['user_id'],
        'date' => $validated['date'],
       /*  'check_in' => $validated['check_in'] ?? null,
        'check_out' => $validated['check_out'] ?? null, */
        'status' => $validated['status'],
    ]);

    $attendance->save();

    return response()->json(['message' => 'Attendance recorded successfully.']);
}






    /**
     * Display the specified attendance.
     */
    public function show(Attendance $attendance)
    {
        return view('admin.attendance.show', compact('attendance'));
    }


     // Show confirmation form

     public function confirmForm($id)
    {
        $attendance = Attendance::with('user')->findOrFail($id);

        return view('admin.attendance.confirm', compact('attendance'));
    }

    public function confirm(Request $request, Attendance $attendance)
    {
        // Process logic...
    
        $attendances = Attendance::with('user')->orderBy('date', 'desc')->paginate(10);
    
        return view('admin.attendance.index', compact('attendances'));
    }
    

    // Show attendance form
    public function create()
    {
        // Get all users, or you can add a filter for specific user roles if needed.
        $users = User::all(); // This gets all users
    
        // Return the create view with the list of users
        return view('admin.attendance.create', compact('users'));
    }
    
}
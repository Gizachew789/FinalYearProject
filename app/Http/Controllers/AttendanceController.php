<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AttendanceController extends Controller
{
    /**
     * Display a listing of the attendances.
     */
    public function index(Request $request)
    {
        $query = Attendance::with('user'); // changed staff to user

        if ($request->has('user_id')) { // updated to user_id
            $query->where('user_id', $request->user_id); // updated to user_id
        }

        if ($request->has('date')) {
            $query->whereDate('date', $request->date);
        }

        $attendance = Attendance::latest()->first();
        $attendances = $query->orderBy('date', 'desc')->paginate(10);
       return view('admin.attendance.index', compact('attendances', 'attendance'));

           $user = Auth::user(); // or however you want to get the user
         return view('admin.attendance.index', compact('attendances', 'user'));

    }

    /**
     * Store a newly created attendance in storage.
     */
    public function store(Request $request)
   {
    $validatedData = $request->validate([
        'user_id' => 'required|exists:users,id',
        'date' => 'required|date',
        'check_in' => 'required|date',
        'check_out' => 'nullable|date',
        'status' => 'required|string|in:present,absent,late,half_day',
    ]);

    // Create a new attendance record
    Attendance::create([
        'user_id' => $validatedData['user_id'],
        'date' => $validatedData['date'],
        'check_in' => $validatedData['check_in'],
        'check_out' => $validatedData['check_out'],
        'status' => $validatedData['status'],
    ]);

    return redirect()->route('admin.attendance.index')->with('success', 'Attendance record added successfully!');
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
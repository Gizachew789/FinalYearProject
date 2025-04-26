<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        $attendances = $query->orderBy('date', 'desc')->paginate(10);

        return view('admin.attendance.index', compact('attendances')); 

    }

    /**
     * Store a newly created attendance in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id', // updated to user_id
            'date' => 'required|date',
            'check_in' => 'required|date_format:Y-m-d H:i:s',
            'check_out' => 'nullable|date_format:Y-m-d H:i:s|after:check_in',
            'status' => 'required|in:present,absent,late,half_day',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $attendance = Attendance::create($request->only(['user_id', 'date', 'check_in', 'check_out', 'status'])); // updated to user_id

        return response()->json([
            'message' => 'Attendance recorded successfully',
            'attendance' => $attendance->load('user'), // changed staff to user
        ], 201);
    }

    /**
     * Display the specified attendance.
     */
    public function show($userid)
    {
        $attendance = Attendance::with('user')->where('user_id', $userid)->latest()->firstOrFail();
        return view('admin.attendance.show', compact('attendance'));
    }


     // Show confirmation form

     public function confirmForm(User $user)
    {
        return view('admin.attendance.confirm', compact('user'));
    }

    public function confirm(Request $request, User $user)
    {
        // Process logic...
    
        $attendances = Attendance::with('user')->orderBy('date', 'desc')->paginate(10);
    
        return view('admin.attendance.index', compact('attendances'));
    }
    

    // Show attendance form
  public function create()
  {
    $users = User::where('role', '!=', 'user')->get(); // or filter roles as needed
    return view('admin.attendance.store', compact('users'));
  }
}
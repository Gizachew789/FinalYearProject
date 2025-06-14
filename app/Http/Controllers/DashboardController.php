<?php 
namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Medication;


class DashboardController extends Controller
{

   public function index(Request $request)
{
    // 1. Get categories for dropdown
    $categories = Medication::select('category')
                  ->distinct()
                  ->orderBy('category')
                  ->pluck('category');

    // 2. Build the main inventory query
    $query = Medication::query();

    // Apply search filter
    if ($request->inventory_search) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', '%'.$request->inventory_search.'%')
              ->orWhere('description', 'like', '%'.$request->inventory_search.'%');
        });
    }

    // Apply category filter
    if ($request->inventory_category) {
        $query->where('category', $request->inventory_category);
    }

    // 3. Get paginated results
    $medications = $query->latest()->paginate(10);

    // Load users
    $users = User::with('roles')->paginate(10);
    $patients = Patient::paginate(10);

    // 4. Return view
    return view('admin.dashboard', compact('categories', 'medications', 'users','patients'));
}

    public function staffDashboard()
    {
        $user = Auth::guard('nurse')->user() ?: Auth::guard('health_officer')->user();
        if (!$user) {
            Log::warning('No authenticated staff user found for staff dashboard.');
            return redirect()->route('login')->withErrors(['auth' => 'Please log in to access the dashboard.']);
        }

        // Load patients with their medical history
        $patients = Patient::with(['user', 'labRequests', 'medicalHistory'])
            ->latest()
            ->get();

        Log::info('Staff dashboard loaded', [
            'user_id' => $user->id,
            'patient_count' => $patients->count()
        ]);

        return view('staff.dashboard', compact('patients'));
    }


public function fetchUsers(Request $request)
{
    // Start the query with the 'roles' relationship loaded
    $query = User::with('roles');

    // Apply search by ID or email
    if ($request->filled('user_search')) {
        $search = $request->user_search;
        $query->where(function ($q) use ($search) {
            $q->where('id', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%');
        });
    }

    // Filter by role if provided
    if ($request->filled('user_role')) {
        $role = $request->user_role;
        $query->whereHas('roles', function ($q) use ($role) {
            $q->where('name', $role);
        });
    }

    // Paginate results
    $users = $query->latest()->paginate(10);



    $categories = Medication::select('category')
                  ->distinct()
                  ->orderBy('category')
                  ->pluck('category');

    // 2. Build the main inventory query
    $query = Medication::query();

    // Apply search filter
    if ($request->inventory_search) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'like', '%'.$request->inventory_search.'%')
              ->orWhere('description', 'like', '%'.$request->inventory_search.'%');
        });
    }

    // Apply category filter
    if ($request->inventory_category) {
        $query->where('category', $request->inventory_category);
    }

    // 3. Get paginated results
    $medications = $query->latest()->paginate(10);

    // Return the view with users
    return view('admin.dashboard', compact('users','categories','medications'));
}


}
<?php 
namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
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
}
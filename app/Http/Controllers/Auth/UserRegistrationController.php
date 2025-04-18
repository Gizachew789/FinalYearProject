<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\LabTechnician;
use App\Models\Pharmacist;
use App\Models\healthOfficer;
use App\Models\Reception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserRegistrationController extends Controller
{
    /**
     * Show the staff registration form.
     *
     * @return \Inertia\Response
     */
    public function showRegistrationForm()
    {
        return inertia('admin/UserRegistration');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,healthOfficer,reception,lab_technician,pharmacist',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female',
            'date_of_birth' => 'nullable|date',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'license_number' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        try {
            DB::beginTransaction();

            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'phone' => $request->phone,
                'status' => 'active',
            ]);

            // Create role-specific profile
            switch ($request->role) {
                case 'admin':
                    $this->createAdmin($user, $request);
                    break;
                case 'healthOfficer':
                    $this->createhealthOfficer($user, $request);
                    break;
                case 'reception':
                    $this->createReception($user, $request);
                    break;
                case 'lab_technician':
                    $this->createLabTechnician($user, $request);
                    break;
                case 'pharmacist':
                    $this->createPharmacist($user, $request);
                    break;
            }

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success', 'Staff member registered successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Registration failed: ' . $e->getMessage())
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }

    /**
     * Create an admin profile.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function createAdmin(User $user, Request $request)
    {
        Admin::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'department' => $request->department,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'date_joined' => now(),
        ]);
    }

    /**
     * Create a health officer profile.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function createhealthOfficer(User $user, Request $request)
    {
        healthOfficer::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'department' => $request->department,
            'specialization' => $request->specialization,
            'qualification' => $request->qualification,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'date_joined' => now(),
            'license_number' => $request->license_number,
        ]);
    }

    /**
     * Create a reception profile.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function createReception(User $user, Request $request)
    {
        Reception::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'department' => $request->department,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'date_joined' => now(),
        ]);
    }

    /**
     * Create a lab technician profile.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function createLabTechnician(User $user, Request $request)
    {
        LabTechnician::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'department' => $request->department,
            'specialization' => $request->specialization,
            'qualification' => $request->qualification,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'date_joined' => now(),
            'license_number' => $request->license_number,
        ]);
    }

    /**
     * Create a pharmacist profile.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function createPharmacist(User $user, Request $request)
    {
        Pharmacist::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'department' => $request->department,
            'qualification' => $request->qualification,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'date_joined' => now(),
            'license_number' => $request->license_number,
        ]);
    }
}
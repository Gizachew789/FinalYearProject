<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles;
    use HasFactory, Notifiable;

    protected $guard_name = 'web';

    protected $fillable = [
        'name',
        'age',
        'gender',
        'phone',
        'email',
        'role',  // keep for backward compatibility
        'password',
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        if (!empty($value) && !\Illuminate\Support\Str::startsWith($value, '$2y$')) {
            $this->attributes['password'] = bcrypt($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }

    // Updated role check methods supporting both Spatie and role column
    public function isAdmin()
    {
        return $this->hasRole('Admin') || $this->role === 'Admin';
    }

    public function isHealthOfficer()
    {
        return $this->hasRole('Health_Officer') || $this->role === 'Health_Officer';
    }

    public function isReception()
    {
        return $this->hasRole('Reception') || $this->role === 'Reception';
    }

    public function isLabTechnician()
    {
        return $this->hasRole('Lab_Technician') || $this->role === 'Lab_Technician';
    }

    public function isPharmacist()
    {
        return $this->hasRole('Pharmacist') || $this->role === 'Pharmacist';
    }

    public function isNurse()
    {
        return $this->hasRole('Nurse') || $this->role === 'Nurse';
    }

    public function isPatient()
    {
        return $this->hasRole('Patient') || $this->role === 'Patient';
    }

    public function isUser()
    {
        return $this->hasRole('User') || $this->role === 'User';
    }

    // Relationships
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function healthOfficer()
    {
        return $this->hasOne(HealthOfficer::class);
    }

    public function reception()
    {
        return $this->hasOne(Reception::class);
    }

    public function labTechnician()
    {
        return $this->hasOne(LabTechnician::class);
    }

    public function pharmacist()
    {
        return $this->hasOne(Pharmacist::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function nurse()
    {
        return $this->hasOne(Nurse::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'tested_by');
    }
}

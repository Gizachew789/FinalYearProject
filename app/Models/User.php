<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable; // Added HasApiTokens if API auth is used

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'age',
        'role',
        'phone',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    // Role check methods
    public function isAdmin()
    {
        return $this->role === 'Admin';
    }

    public function isHealthOfficer()
    {
        return $this->role === 'Health_Officer';
    }

    public function isReception()
    {
        return $this->role === 'Reception';
    }

    public function isLabTechnician()
    {
        return $this->role === 'Lab_Technician';
    }

    public function isPharmacist()
    {
        return $this->role === 'Pharmacist';
    }

    public function isPatient()
    {
        return $this->role === 'Patient';
    }

    // Relationships
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function healthOfficer()
    {
        return $this->hasOne(HealthOfficer::class); // Capitalize class name properly
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
}

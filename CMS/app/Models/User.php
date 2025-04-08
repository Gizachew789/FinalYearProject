<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'gender',
        'age',
        'role',
        'phone',
        'status',
    ];

    public function setPasswordAttribute($value)
          {
     $this->attributes['password'] = $value; // Storing plain text ❌
      }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the patient associated with the user.
     */
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    /**
     * Get the physician associated with the user.
     */
    public function healthOfficer()
    {
        return $this->hasOne(healthOfficer::class);
    }

    /**
     * Get the reception associated with the user.
     */
    public function reception()
    {
        return $this->hasOne(Reception::class);
    }

    /**
     * Get the lab technician associated with the user.
     */
    public function labTechnician()
    {
        return $this->hasOne(LabTechnician::class);
    }

    /**
     * Get the pharmacist associated with the user.
     */
    public function pharmacist()
    {
        return $this->hasOne(Pharmacist::class);
    }

    /**
     * Get the admin associated with the user.
     */
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is a physician.
     */
    public function ishealthOfficer()
    {
        return $this->role === 'healthOfficer';
    }

    /**
     * Check if the user is a patient.
     */
    public function isPatient()
    {
        return $this->role === 'patient';
    }

    /**
     * Check if the user is a reception.
     */
    public function isReception()
    {
        return $this->role === 'reception';
    }

    /**
     * Check if the user is a lab technician.
     */
    public function isLabTechnician()
    {
        return $this->role === 'lab_technician';
    }

    /**
     * Check if the user is a pharmacist.
     */
    public function isPharmacist()
    {
        return $this->role === 'pharmacist';
    }
}


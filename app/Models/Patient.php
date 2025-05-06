<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // <-- Change this
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable // <-- Extend Authenticatable instead of Model
{
    use HasFactory, Notifiable;

    /**
     * If you're using patient_id as the primary key
     */
    protected $primaryKey = 'patient_id';
    public $incrementing = false;
    protected $keyType = 'string'; // Change to 'int' if numeric IDs are used

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'patient_id',
        'name',
        'gender',
        'age',
        'phone',
        'email',
        'department',
        'year_of_study',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email' => 'string',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(Medicalrecord::class);
    }

    public function labResults()
    {
        return $this->hasMany(Result::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id', // University student ID
        'name',
        'gender',
        'age',
        'phone_number', 
        'email',
        'department',
        'year_of_study',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email' => 'string',
    ];

    /**
     * Get the user that owns the patient.
     */
   public function user()
    {
        return $this->belongsTo(User::class);
    } 

    /**
     * Get the appointments for the patient.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the medical records for the patient.
     */
    public function medicalRecords()
    {
        return $this->hasMany(Medicalrecord::class);
    }

    public function labResults()
   {
    return $this->hasMany(Result::class); // Replace Result with your actual model name for lab results
   }

    /**
     * Get the prescriptions for the patient.
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}


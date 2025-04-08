<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'age',
        'gender',
        'phone',
        'email',
        'emergency_contact_name',
        'emergency_contact_phone',
        'date_joined',
        'shift',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'date_joined' => 'date',
    ];

    /**
     * Get the user that owns the physician.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the schedules for the physician.
     */
    public function schedules()
    {
        return $this->hasMany(PhysicianSchedule::class);
    }

    /**
     * Get the appointments for the physician.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the medical records created by the physician.
     */
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'created_by');
    }

    /**
     * Get the prescriptions created by the physician.
     */
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'prescribed_by');
    }
}


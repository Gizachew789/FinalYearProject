<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; // <-- Change this
use Illuminate\Notifications\Notifiable;

class Patient extends Authenticatable
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
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email' => 'string',
    ];


        public function setPasswordAttribute($value)
    {
        if (!empty($value) && !\Illuminate\Support\Str::startsWith($value, '$2y$')) {
            $this->attributes['password'] = bcrypt($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }
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

    public function medicalHistory()
    {
        return $this->hasMany(MedicalRecord::class, 'patient_id'); 
    }
    
    public function medicalDocuments()
    {
        return $this->hasMany(MedicalDocument::class, 'patient_id', 'patient_id');
    }

    public function labResults()
    {
        return $this->hasMany(Result::class, 'patient_id');
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'patient_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'patient_id');
    }

    public function labRequests()
    {
        return $this->hasMany(LabRequest::class, 'patient_id', 'patient_id');
    }
}


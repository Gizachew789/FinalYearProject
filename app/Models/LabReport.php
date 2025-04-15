<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabReport extends Model
{
    use HasFactory;

    // Specify the table associated with the model (optional if it follows Laravel's naming convention)
    protected $table = 'lab_reports';

    // The attributes that are mass assignable
    protected $fillable = [
        'patient_id', 
        'physician_id', 
        'report_date', 
        'test_type',
        'test_results',
        'status',
    ];

    // The attributes that should be cast to native types
    protected $casts = [
        'report_date' => 'datetime',
    ];

    /**
     * Get the patient that owns the lab report.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the physician who created the lab report.
     */
    public function physician()
    {
        return $this->belongsTo(User::class, 'physician_id');
    }

    /**
     * Get the results of the lab report.
     */
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    /**
     * Define any other necessary methods here for business logic or calculations.
     */
}

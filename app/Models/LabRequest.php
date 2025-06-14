<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'requested_by',
        'test_name',
        'notes',
        'status',
    ];

    /**
     * Get the patient for the lab request.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    /**
     * Get the user (staff) who requested the lab test.
     */
    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}

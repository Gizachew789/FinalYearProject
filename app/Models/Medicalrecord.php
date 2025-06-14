<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicalrecord extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'medical_records'; // Ensure correct table name

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'created_by',
        'diagnosis',
        'treatment',
        'prescription',
        'visit_date',
        'follow_up_date',
        'lab_results_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'visit_date' => 'date',
        'follow_up_date' => 'date',
    ];

    /**
     * Relationships
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function labResults()
    {
        return $this->belongsTo(Result::class, 'lab_results_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

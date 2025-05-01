<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'prescriber_id',
        'medication_id',
        'dosage',
        'instructions',
        'frequency',
        'status',
        'duration',
    ];

    /**
     * The patient that the prescription is for.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * The user (e.g., nurse or health officer) who prescribed.
     */
    public function prescriber()
    {
        return $this->belongsTo(User::class, 'prescriber_id');
    }
}

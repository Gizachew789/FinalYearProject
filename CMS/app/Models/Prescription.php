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
        'user_id', // University staff ID
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
     * Get the user that owns the pharmacist.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the prescriptions dispensed by the pharmacist.
     */
    public function dispensedPrescriptions()
    {
        return $this->hasMany(Prescription::class, 'dispensed_by');
    }
}


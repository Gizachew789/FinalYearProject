<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicalrecord extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admins_id',
        'staff_id', // University staff ID
        'name',
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
        //'date_of_birth' => 'date',
        'date_joined' => 'date',
    ];

    /**
     * Get the user that owns the reception.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the appointments created by the reception.
     */
    public function createdAppointments()
    {
        return $this->hasMany(Appointment::class, 'created_by');
    }
}


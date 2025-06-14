<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    'patient_id',
    'tested_by',
    'disease_type',
    'sample_type',
    'result',
    'recommendation',
    'result_date',
];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'result_date' => 'date',
    ];

     public function patient()
  {
    return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
  }

  public function tested_by_user()
  {
      return $this->belongsTo(User::class, 'tested_by');
  }
  
}


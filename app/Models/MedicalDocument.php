<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalDocument extends Model
{
    protected $fillable = ['patient_id', 'file_path', 'file_type'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }


}
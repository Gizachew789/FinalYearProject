<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['medication_id', 'name', 'current_stock', 'reorder_level', 'quantity'];
}


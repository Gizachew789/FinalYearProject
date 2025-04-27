<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'inventory_name',
        'inventory_type',
        'description',
        'medication_id',
        'transaction_type', // in, out
        'quantity',
        'transaction_date',
        'performed_by', // user_id
        'reference',
        'notes',
        'batch_number',
        'supplier',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'transaction_date' => 'datetime',
    ];

    /**
     * Get the medication associated with the inventory transaction.
     */
    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }

    // public function inventory()
    // {
    //     return $this->belongsTo(inventory::class);
    // }

    /**
     * Get the user who performed the inventory transaction.
     */
    public function performer()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}


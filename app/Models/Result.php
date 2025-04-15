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
        'name',
        'generic_name',
        'category',
        'manufacturer',
        'dosage_form',
        'strength',
        'quantity',
        'expiry_date',
        'description',
        'supplied_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expiry_date' => 'date',
    ];

    /**
     * Get the prescription items for this medicine.
     */
    public function prescriptionItems()
    {
        return $this->hasMany(PrescriptionItem::class);
    }

    /**
     * Get the inventory transactions for this medicine.
     */
    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }
}


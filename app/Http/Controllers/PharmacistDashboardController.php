<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\DB;

class PharmacistDashboardController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::with(['patient.user', 'medications'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Get current inventory status per medication
        $inventory = \App\Models\Medication::with(['inventoryTransactions' => function ($query) {
            $query->select('medication_id', 'transaction_type', DB::raw('SUM(quantity) as total'))
                  ->groupBy('medication_id', 'transaction_type');
        }])->get()->map(function ($medication) {
            $in = $medication->inventoryTransactions->where('transaction_type', 'in')->sum('total');
            $out = $medication->inventoryTransactions->where('transaction_type', 'out')->sum('total');
            $medication->current_quantity = $in - $out;
            return $medication;
        });
    
        return view('pharmacist.dashboard', compact('prescriptions', 'inventory'));
    }
    

    public function dispense(Request $request, $prescriptionId)
    {
        $request->validate([
            'medication_ids' => 'required|array',
            'quantities' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->medication_ids as $index => $medicationId) {
                $quantityToReduce = $request->quantities[$index];

                $inventoryItem = InventoryTransaction::where('medication_id', $medicationId)->first();
                if (!$inventoryItem || $inventoryItem->quantity < $quantityToReduce) {
                    throw new \Exception('Insufficient inventory for medication ID: ' . $medicationId);
                }

                $inventoryItem->decrement('quantity', $quantityToReduce);
            }

            // Mark prescription as confirmed
            $prescription = Prescription::findOrFail($prescriptionId);
            $prescription->status = 'confirmed';
            $prescription->confirmed_by = auth()->id();
            $prescription->save();
            
            DB::commit();

            return redirect()->back()->with('success', 'Prescription dispensed and inventory updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

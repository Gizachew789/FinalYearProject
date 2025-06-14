<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\Medication;
use Illuminate\Support\Facades\DB;

class PharmacistDashboardController extends Controller
{
   public function index()
    {
        
        $prescriptions = Prescription::with(['patient', 'prescriber', 'medication'])->latest()->get();
        $medicationByMedicationId = Medication::all()->keyBy('medication_id');

        return view('pharmacist.dashboard', compact('prescriptions'));
    }

    public function confirm($id)
    {
        $prescription = Prescription::findOrFail($id);
        $medication = Medication::where('id', $prescription->medication_id)->first();

        $requiredQuantity = $prescription->dosage ?? 1; // default to 1 if dosage not set
          /* dd($requiredQuantity, $medication->quantity); */
       if ($medication && $medication->current_stock >= $requiredQuantity) {
        $medication->current_stock -= $requiredQuantity;
            $medication->save();

            $prescription->status = 'confirmed';
            $prescription->save();

            return redirect()->back()->with('success', 'Prescription confirmed and medication dispensed.');
        }

        return redirect()->back()->with('error', 'Not enough storage to confirm prescription.');
    }

    public function reject($id)
    {
        $prescription = Prescription::findOrFail($id);
        $prescription->status = 'rejected';
        $prescription->save();

        return redirect()->back()->with('success', 'Prescription rejected successfully.');
    }

    public function show($id)
    {
        $prescription = Prescription::with(['patient', 'prescriber', 'medication'])->findOrFail($id);
        return view('pharmacist.prescriptions.show', compact('prescription'));
    }

    public function dispense(Request $request, $id)
    {
        // You can implement this if you want a dedicated 'dispense' logic
    }
}

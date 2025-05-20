<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\Notification;
use App\Models\Prescription;
use App\Models\Patient;
use App\Models\PrescriptionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class PrescriptionController extends Controller
{

         // Show the form to create a new prescription
    public function create($patient_id)
    {
        $patient = Patient::findOrFail($patient_id);
        $medications = Medication::all();

        return view('staff.prescriptions.create', compact('patient', 'medications'));
    }

    // Store the prescription
    public function store(Request $request, $patient_id)
    {
        $request->validate([
            'medication_id' => 'required|integer|exists:medications,id',
            'dosage' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'frequency' => 'required|string',
            'duration' => 'required|string|max:255',
        ]);

        Prescription::create([
            'patient_id' => $patient_id,
            'prescriber_id' => Auth::id(),
            'medication_id' => $request->medication_id,
            'dosage' => $request->dosage,
            'instructions' => $request->instructions,
            'frequency' => $request->frequency,
            'duration' => $request->duration,
        ]);

        return redirect()->route('staff.patients.show', ['patient_id' => $patient_id])->with('success', 'Prescription added successfully.');
    }

    /**
     * Update the status of a prescription item.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @param  int  $itemId
     * @return \Illuminate\Http\Response
     */
    public function updateItemStatus(Request $request, $id, $itemId)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:prescribed,dispensed,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();
        $prescription = Prescription::findOrFail($id);
        $prescriptionItem = PrescriptionItem::where('prescription_id', $id)
            ->where('id', $itemId)
            ->firstOrFail();

        // Check if the user has permission to update this prescription item
        if (!$user->isAdmin() && !$user->isReception() && !$user->isPhysician()) {
            return response()->json([
                'message' => 'Only physicians, reception staff, and administrators can update prescription item status',
            ], 403);
        }

        // If cancelling, return medication to stock
        if ($request->status === 'cancelled' && $prescriptionItem->status !== 'cancelled') {
            $medication = Medication::findOrFail($prescriptionItem->medication_id);
            $medication->current_stock += $prescriptionItem->quantity;
            $medication->save();
        }

        // Update the prescription item status
        $prescriptionItem->status = $request->status;
        $prescriptionItem->save();

        // Check if all items are dispensed or cancelled to update prescription status
        $allItemsProcessed = PrescriptionItem::where('prescription_id', $id)
            ->whereNotIn('status', ['dispensed', 'cancelled'])
            ->count() === 0;

        if ($allItemsProcessed) {
            $prescription->status = 'completed';
            $prescription->save();
        }

        return response()->json([
            'message' => 'Prescription item status updated successfully',
            'prescription_item' => $prescriptionItem->load('medication'),
        ]);
    }
}


<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\Notification;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the prescriptions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Prescription::with(['patient.user', 'physician.user', 'medicalRecord', 'items.medication']);

        if ($user->isPatient()) {
            $query->where('patient_id', $user->patient->id);
        } elseif ($user->isPhysician()) {
            $query->where('prescribed_by', $user->physician->id);
        }

        // Filter by patient
        if ($request->has('patient_id') && ($user->isAdmin() || $user->isPhysician() || $user->isReception())) {
            $query->where('patient_id', $request->patient_id);
        }

        $prescriptions = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'prescriptions' => $prescriptions,
        ]);
    }

    /**
     * Store a newly created prescription in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'medical_record_id' => 'required|exists:medical_records,id',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.medication_id' => 'required|exists:medications,id',
            'items.*.dosage' => 'required|string',
            'items.*.frequency' => 'required|string',
            'items.*.duration' => 'required|string',
            'items.*.instructions' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();
        
        // Check if the user is a physician
        if (!$user->isPhysician()) {
            return response()->json([
                'message' => 'Only physicians can create prescriptions',
            ], 403);
        }

        // Create the prescription
        $prescription = Prescription::create([
            'patient_id' => $request->patient_id,
            'medical_record_id' => $request->medical_record_id,
            'prescribed_by' => $user->physician->id,
            'prescription_date' => now(),
            'notes' => $request->notes,
            'status' => 'active',
        ]);

        // Create prescription items
        foreach ($request->items as $item) {
            // Check if medication has enough stock
            $medication = Medication::findOrFail($item['medication_id']);
            if ($medication->current_stock < $item['quantity']) {
                return response()->json([
                    'message' => "Insufficient stock for medication: {$medication->name}",
                ], 400);
            }

            PrescriptionItem::create([
                'prescription_id' => $prescription->id,
                'medication_id' => $item['medication_id'],
                'dosage' => $item['dosage'],
                'frequency' => $item['frequency'],
                'duration' => $item['duration'],
                'instructions' => $item['instructions'] ?? null,
                'quantity' => $item['quantity'],
                'status' => 'prescribed',
            ]);

            // Update medication stock
            $medication->current_stock -= $item['quantity'];
            $medication->save();
        }

        // Create notification for the patient
        Notification::create([
            'user_id' => $prescription->patient->user_id,
            'title' => 'New Prescription',
            'message' => 'A new prescription has been created for you',
            'type' => 'prescription',
            'related_id' => $prescription->id,
            'related_type' => Prescription::class,
        ]);

        return response()->json([
            'message' => 'Prescription created successfully',
            'prescription' => $prescription->load(['patient.user', 'physician.user', 'medicalRecord', 'items.medication']),
        ], 201);
    }

    /**
     * Display the specified prescription.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $user = $request->user();
        $prescription = Prescription::with(['patient.user', 'physician.user', 'medicalRecord', 'items.medication'])
            ->findOrFail($id);

        // Check if the user has permission to view this prescription
        if ($user->isPatient() && $prescription->patient_id !== $user->patient->id) {
            return response()->json([
                'message' => 'You do not have permission to view this prescription',
            ], 403);
        }

        return response()->json([
            'prescription' => $prescription,
        ]);
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


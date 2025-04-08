<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Document;
use App\Models\MedicalRecord;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the medical records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = MedicalRecord::with(['patient.user', 'physician.user', 'appointment']);

        if ($user->isPatient()) {
            $query->where('patient_id', $user->patient->id);
        } elseif ($user->isPhysician()) {
            $query->where('created_by', $user->physician->id);
        }

        // Filter by patient
        if ($request->has('patient_id') && ($user->isAdmin() || $user->isPhysician() || $user->isReception())) {
            $query->where('patient_id', $request->patient_id);
        }

        $medicalRecords = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'medical_records' => $medicalRecords,
        ]);
    }

    /**
     * Store a newly created medical record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'diagnosis' => 'nullable|string',
            'symptoms' => 'nullable|string',
            'treatment' => 'nullable|string',
            'notes' => 'nullable|string',
            'follow_up_date' => 'nullable|date',
            'vital_signs' => 'nullable|json',
            'lab_results' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();
        
        // Check if the user is a physician
        if (!$user->isPhysician()) {
            return response()->json([
                'message' => 'Only physicians can create medical records',
            ], 403);
        }

        // Create the medical record
        $medicalRecord = MedicalRecord::create([
            'patient_id' => $request->patient_id,
            'appointment_id' => $request->appointment_id,
            'created_by' => $user->physician->id,
            'diagnosis' => $request->diagnosis,
            'symptoms' => $request->symptoms,
            'treatment' => $request->treatment,
            'notes' => $request->notes,
            'follow_up_date' => $request->follow_up_date,
            'vital_signs' => $request->vital_signs,
            'lab_results' => $request->lab_results,
        ]);

        // Update appointment status if provided
        if ($request->appointment_id) {
            $appointment = Appointment::find($request->appointment_id);
            if ($appointment) {
                $appointment->status = 'completed';
                $appointment->save();
            }
        }

        // Create notification for the patient
        Notification::create([
            'user_id' => $medicalRecord->patient->user_id,
            'title' => 'New Medical Record',
            'message' => 'A new medical record has been created for you',
            'type' => 'system',
            'related_id' => $medicalRecord->id,
            'related_type' => MedicalRecord::class,
        ]);

        return response()->json([
            'message' => 'Medical record created successfully',
            'medical_record' => $medicalRecord->load(['patient.user', 'physician.user', 'appointment']),
        ], 201);
    }

    /**
     * Display the specified medical record.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $user = $request->user();
        $medicalRecord = MedicalRecord::with(['patient.user', 'physician.user', 'appointment', 'documents', 'prescriptions.items.medication'])
            ->findOrFail($id);

        // Check if the user has permission to view this medical record
        if ($user->isPatient() && $medicalRecord->patient_id !== $user->patient->id) {
            return response()->json([
                'message' => 'You do not have permission to view this medical record',
            ], 403);
        }

        return response()->json([
            'medical_record' => $medicalRecord,
        ]);
    }

    /**
     * Update the specified medical record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'diagnosis' => 'nullable|string',
            'symptoms' => 'nullable|string',
            'treatment' => 'nullable|string',
            'notes' => 'nullable|string',
            'follow_up_date' => 'nullable|date',
            'vital_signs' => 'nullable|json',
            'lab_results' => 'nullable|json',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();
        $medicalRecord = MedicalRecord::findOrFail($id);

        // Check if the user has permission to update this medical record
        if (!$user->isAdmin() && !$user->isPhysician()) {
            return response()->json([
                'message' => 'Only physicians and admins can update medical records',
            ], 403);
        }

        // Physicians can only update their own records unless they're admins
        if ($user->isPhysician() && !$user->isAdmin() && $medicalRecord->created_by !== $user->physician->id) {
            return response()->json([
                'message' => 'You can only update medical records that you created',
            ], 403);
        }

        // Update the medical record
        $medicalRecord->diagnosis = $request->diagnosis ?? $medicalRecord->diagnosis;
        $medicalRecord->symptoms = $request->symptoms ?? $medicalRecord->symptoms;
        $medicalRecord->treatment = $request->treatment ?? $medicalRecord->treatment;
        $medicalRecord->notes = $request->notes ?? $medicalRecord->notes;
        $medicalRecord->follow_up_date = $request->follow_up_date ?? $medicalRecord->follow_up_date;
        $medicalRecord->vital_signs = $request->vital_signs ?? $medicalRecord->vital_signs;
        $medicalRecord->lab_results = $request->lab_results ?? $medicalRecord->lab_results;
        $medicalRecord->save();

        return response()->json([
            'message' => 'Medical record updated successfully',
            'medical_record' => $medicalRecord->load(['patient.user', 'physician.user', 'appointment']),
        ]);
    }

    /**
     * Upload a document to a medical record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadDocument(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240', // 10MB max
            'document_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();
        $medicalRecord = MedicalRecord::findOrFail($id);

        // Check if the user has permission to upload documents
        if (!$user->isAdmin() && !$user->isPhysician()) {
            return response()->json([
                'message' => 'Only physicians and admins can upload documents',
            ], 403);
        }

        // Store the file
        $file = $request->file('file');
        $path = $file->store('documents');
        
        // Create the document record
        $document = Document::create([
            'medical_record_id' => $medicalRecord->id,
            'uploaded_by' => $user->id,
            'title' => $request->title,
            'file_path' => $path,
            'file_type' => $file->getClientMimeType(),
            'description' => $request->description,
            'document_date' => $request->document_date ?? now(),
        ]);

        // Create notification for the patient
        Notification::create([
            'user_id' => $medicalRecord->patient->user_id,
            'title' => 'New Document Uploaded',
            'message' => 'A new document has been uploaded to your medical record',
            'type' => 'system',
            'related_id' => $document->id,
            'related_type' => Document::class,
        ]);

        return response()->json([
            'message' => 'Document uploaded successfully',
            'document' => $document,
        ], 201);
    }

    /**
     * Download a document.
     *
     * @param  int  $documentId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function downloadDocument($documentId, Request $request)
    {
        $user = $request->user();
        $document = Document::with('medicalRecord.patient')->findOrFail($documentId);

        // Check if the user has permission to download this document
        if ($user->isPatient() && $document->medicalRecord->patient_id !== $user->patient->id) {
            return response()->json([
                'message' => 'You do not have permission to download this document',
            ], 403);
        }

        // Check if the file exists
        if (!Storage::exists($document->file_path)) {
            return response()->json([
                'message' => 'File not found',
            ], 404);
        }

        return Storage::download($document->file_path, $document->title);
    }
}


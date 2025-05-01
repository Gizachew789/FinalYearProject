<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\InventoryTransaction;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * Display a listing of the medications.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Medication::query();

        // Filter by category
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Filter by low stock
        if ($request->has('low_stock') && $request->low_stock === 'true') {
            $query->whereRaw('current_stock <= reorder_level');
        }

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $medications = $query->orderBy('name')->paginate(15);

        return view('admin.inventory.index', compact('medications'));
    }

    /**
     * Show the form for creating a new medication.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.inventory.create');
    }

    /**
     * Store a newly created medication in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'current_stock' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'manufacturer' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $medication = Medication::create($request->all());

        return redirect()->route('admin.inventory.index')->with('success', 'Medication added successfully');
    }

    /**
     * Display the specified medication.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $medication = Medication::findOrFail($id);
        return view('admin.inventory.show', compact('medication'));
    }

    /**
     * Show the form for editing the specified medication.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $medication = Medication::findOrFail($id);
        return view('admin.inventory.edit', compact('medication'));
    }

    /**
     * Update the specified medication in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $medication = Medication::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'reorder_level' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'expiry_date' => 'nullable|date',
            'manufacturer' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $medication->update($request->all());

        return redirect()->route('inventory.index')->with('success', 'Medication updated successfully');
    }

    /**
     * Remove the specified medication from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $medication = Medication::findOrFail($id);
        $medication->delete();

        return redirect()->route('inventory.index')->with('success', 'Medication deleted successfully');
    }

    /**
     * Update the stock of a medication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStock(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer',
            'transaction_type' => 'required|in:in,out',
            'reason' => 'required|string|max:255',
            'batch_number' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $medication = Medication::findOrFail($id);

        if ($request->transaction_type === 'out' && $medication->current_stock < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock available');
        }

        DB::transaction(function () use ($request, $medication) {
            // Update medication stock
            $medication->current_stock += $request->transaction_type === 'in' ? $request->quantity : -$request->quantity;
            $medication->save();

            // Create inventory transaction
            InventoryTransaction::create([
                'medication_id' => $medication->id,
                'quantity' => $request->quantity,
                'transaction_type' => $request->transaction_type,
                'reason' => $request->reason,
                'batch_number' => $request->batch_number,
                'expiry_date' => $request->expiry_date,
                'performed_by' => auth()->id(),
            ]);

            // Check if stock is low and notify admins and pharmacists
            if ($medication->current_stock <= $medication->reorder_level) {
                $this->notifyLowStock($medication);
            }
        });

        return redirect()->route('inventory.index')->with('success', 'Stock updated successfully');
    }

    /**
     * Get low stock medications.
     *
     * @return \Illuminate\Http\Response
     */
    public function lowStock()
    {
        $lowStockMedications = Medication::whereRaw('current_stock <= reorder_level')
            ->orderBy('name')
            ->get();

        return view('admin.inventory.lowStock', compact('lowStockMedications'));
    }

    /**
     * Notify admins and pharmacists about low stock.
     *
     * @param  \App\Models\Medication  $medication
     * @return void
     */
    private function notifyLowStock(Medication $medication)
    {
        $users = User::whereIn('role', ['admin', 'pharmacist'])->get();

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Low Stock Alert',
                'message' => "The stock of {$medication->name} is low. Current stock: {$medication->current_stock}",
                'type' => 'inventory',
            ]);
        }
    }
}

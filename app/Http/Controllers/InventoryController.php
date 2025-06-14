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
     */
    public function index(Request $request)
    {
        // 1. Get distinct categories for the filter dropdown
        $categories = Medication::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        // 2. Build the base query
        $query = Medication::query();

        // 3. Apply search filter if provided
        if ($request->inventory_search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->inventory_search . '%')
                  ->orWhere('description', 'like', '%' . $request->inventory_search . '%');
            });
        }
      

        // 4. Apply category filter if selected
        if ($request->inventory_category) {
            $query->where('category', $request->inventory_category);
        }

        // 5. Paginate results
        $medicine = $query->latest()->paginate(10);

        // 6. Return to view
        return view('admin.dashboard', compact('categories', 'medicine'));
      
    }

    public function editStock(Request $request)
{
    $request->validate([
        'medication_id' => 'required|exists:medications,id',
        'reduce_amount' => 'required|integer|min:1',
    ]);

    $medication = Medication::findOrFail($request->medication_id);

    // Ensure stock does not go negative
    $medication->current_stock = max(0, $medication->current_stock - $request->reduce_amount);
    $medication->save();

    return redirect()->back()->with('success', 'Stock updated successfully.');
}


    /**
     * Show the form for creating a new medication.
     */
    public function create()
    {
        return view('admin.inventory.create');
    }

    /**
     * Store a newly created medication in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'unit' => 'required|string',
            'current_stock' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'manufacturer' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Medication::create($request->all());

        return redirect()->route('admin.inventory.index')->with('success', 'Medication added successfully');
    }

    /**
     * Display the specified medication.
     */
    public function show($id)
    {
        $medication = Medication::findOrFail($id);
        return view('admin.inventory.show', compact('medication'));
    }

    /**
     * Show the form for editing the specified medication.
     */
    public function edit($id)
    {
        $medication = Medication::findOrFail($id);
        return view('admin.inventory.edit', compact('medication'));
    }

    /**
     * Update the specified medication in storage.
     */
    public function update(Request $request, $id)
    {
        $medication = Medication::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'reorder_level' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'manufacturer' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $medication->update($request->all());

        return redirect()->route('admin.inventory.index')->with('success', 'Medication updated successfully');
    }

    /**
     * Remove the specified medication from storage.
     */
    public function destroy($id)
    {
        $medication = Medication::findOrFail($id);
        $medication->delete();

        return redirect()->route('admin.inventory.index')->with('success', 'Medication deleted successfully');
    }

    /**
     * Update the stock of a medication.
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

            // Notify if stock is low
            if ($medication->current_stock <= $medication->reorder_level) {
                $this->notifyLowStock($medication);
            }
        });

        return redirect()->route('admin.inventory.index')->with('success', 'Stock updated successfully');
    }

    /**
     * Get low stock medications.
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

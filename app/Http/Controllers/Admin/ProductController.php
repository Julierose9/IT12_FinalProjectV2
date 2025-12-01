<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PullOut;
use App\Models\Product;
use App\Models\Employee;
use Illuminate\Http\Request;

class PullOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pullOuts = PullOut::with(['product', 'employee'])
                            ->orderBy('DatePullOut', 'desc')
                            ->get();
        
        return view('admin.pullout', compact('pullOuts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and store pullout data
        $validated = $request->validate([
            'ProductID' => 'required|exists:products,ProductID',
            'EmployeeID' => 'required|exists:employees,EmployeeID',
            'Qty' => 'required|integer|min:1',
            'Reason' => 'required|string',
            'DatePullOut' => 'required|date',
        ]);

        // Generate PullOutID
        $pullOutId = 'PO-' . date('Ymd') . '-' . str_pad(PullOut::count() + 1, 3, '0', STR_PAD_LEFT);
        
        PullOut::create([
            'PullOutID' => $pullOutId,
            'ProductID' => $validated['ProductID'],
            'EmployeeID' => $validated['EmployeeID'],
            'PullOutQty' => $validated['Qty'],
            'PullOutReason' => $validated['Reason'],
            'DatePullOut' => $validated['DatePullOut'],
        ]);

        return redirect()->route('admin.pullout')
            ->with('success', 'Pullout record created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pullOut = PullOut::findOrFail($id);
        $pullOut->delete();
        
        return redirect()->route('admin.pullout')
            ->with('success', 'Pullout record deleted successfully!');
    }
}
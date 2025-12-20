<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 


class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::withCount('products')
            ->orderBy('SupplierName')
            ->get();

        return view('admin.supplier', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'SupplierName'      => 'required|string|max:255',
            // Exactly 11 digits, starting with 09 (e.g. 09123456789)
            'SupplierContactNo' => 'required|string|size:11|regex:/^09\d{9}$/',
            'Address'           => 'required|string',
            'Status'            => 'required|in:Active,Inactive'
        ]);

        // Auto-generate SupplierID: SUP001, SUP002...
        $lastSupplier = Supplier::orderBy('SupplierID', 'desc')->first();
        $newId = $lastSupplier ? intval(substr($lastSupplier->SupplierID, 3)) + 1 : 1;
        $supplierId = 'SUP' . str_pad($newId, 3, '0', STR_PAD_LEFT);

        Supplier::create([
            'SupplierID' => $supplierId,
            'SupplierName' => $request->SupplierName,
            'SupplierContactNo' => $request->SupplierContactNo,
            'Address' => $request->Address,
            'Status' => $request->Status,
        ]);

        return redirect()->route('admin.supplier')
            ->with('success', 'Supplier created successfully!');
    }

    public function edit($id)
    {
        // Use where clause with SupplierID instead of find()
        $supplier = DB::table('Suppliers')
            ->where('SupplierID', $id)
            ->first();
    
        if (!$supplier) {
            return redirect()->route('admin.supplier')->with('error', 'Supplier not found.');
        }
    
        return response()->json($supplier);
    }
    
    public function update(Request $request, $id)
    {
        // Find supplier by SupplierID
        $supplier = DB::table('Suppliers')
            ->where('SupplierID', $id)
            ->first();
    
        if (!$supplier) {
            return redirect()->route('admin.supplier')->with('error', 'Supplier not found.');
        }
    
        $request->validate([
            'SupplierName'      => 'required|string|max:255',
            'SupplierContactNo' => 'required|string|size:11|regex:/^09\d{9}$/',
            'Address'           => 'required|string',
            'Status'            => 'required|in:Active,Inactive'
        ]);
    
        DB::table('Suppliers')
            ->where('SupplierID', $id)
            ->update([
                'SupplierName' => $request->SupplierName,
                'SupplierContactNo' => $request->SupplierContactNo,
                'Address' => $request->Address,
                'Status' => $request->Status,
                'updated_at' => now(),
            ]);
    
        return redirect()->route('admin.supplier')
            ->with('success', 'Supplier updated successfully!');
    }
    
    public function destroy($id)
    {
        $supplier = DB::table('Suppliers')
            ->where('SupplierID', $id)
            ->first();
    
        if (!$supplier) {
            return redirect()->route('admin.supplier')->with('error', 'Supplier not found.');
        }
    
        // Check if supplier has products
        $productCount = DB::table('Products')
            ->where('SupplierID', $id)
            ->count();
    
        if ($productCount > 0) {
            return back()->with('error', 'Cannot delete supplier with linked products!');
        }
    
        DB::table('Suppliers')
            ->where('SupplierID', $id)
            ->delete();
    
        return back()->with('success', 'Supplier deleted successfully!');
    }
    
    public function show($id)
    {
        $supplier = DB::table('Suppliers')
            ->where('SupplierID', $id)
            ->first();
    
        if (!$supplier) {
            return response()->json(['error' => 'Supplier not found.'], 404);
        }
    
        // Get products count
        $productsCount = DB::table('Products')
            ->where('SupplierID', $id)
            ->count();
    
        $supplier->products_count = $productsCount;
    
        return response()->json($supplier);
    }
}
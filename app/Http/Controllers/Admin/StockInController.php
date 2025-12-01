<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockIn;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    public function index()
    {
        // Get existing products
        $existingProducts = Product::where('ProductStatus', 'Active')->get();
        
        // Get suppliers and categories
        $suppliers = Supplier::all();
        $categories = Category::all();
        
        // Get all stock-ins with product info
        $stockIns = StockIn::with(['product', 'supplier'])
            ->orderBy('DateRcvd', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.stockin', compact(
            'existingProducts', 
            'suppliers', 
            'categories', 
            'stockIns'
        ));
    }
    
    public function storeForExisting(Request $request)
    {
        $request->validate([
            'ProductID' => 'required|exists:products,ProductID',
            'SupplierID' => 'required|exists:suppliers,SupplierID',
            'Qty' => 'required|integer|min:1',
            'ProdStatus' => 'required|in:Good,Damaged,Expired,Returned',
            'DateRcvd' => 'required|date',
        ]);
        
        StockIn::create([
            'ProductID' => $request->ProductID,
            'SupplierID' => $request->SupplierID,
            'Qty' => $request->Qty,
            'ProdStatus' => $request->ProdStatus,
            'DateRcvd' => $request->DateRcvd,
        ]);
        
        return redirect()->route('admin.stockin')
            ->with('success', 'Stock added successfully for existing product!');
    }
    
 // In StockInController - Alternative storeNewItem method without temp fields
public function storeNewItem(Request $request)
{
    $request->validate([
        'SKUNumber' => 'required|unique:products,SKUNumber', // Check uniqueness
        'ProductName' => 'required|string|max:255',
        'SupplierID' => 'required|exists:suppliers,SupplierID',
        'Qty' => 'required|integer|min:1',
        'ProdStatus' => 'required|in:Good,Damaged',
        'DateRcvd' => 'required|date',
        'CategoryID' => 'nullable|exists:categories,CategoryID',
        'ProductDescription' => 'nullable|string',
        'ReorderLevel' => 'nullable|integer|min:0',
        'OriginalPrice' => 'required|numeric|min:0',
        'RetailPrice' => 'required|numeric|min:0',
    ]);

    DB::beginTransaction();
    try {
        // 1. Create Product FIRST
        $product = Product::create([
            'SKUNumber' => $request->SKUNumber,
            'ProductName' => $request->ProductName,
            'ProductDescription' => $request->ProductDescription,
            'CategoryID' => $request->CategoryID,
            'ReorderLevel' => $request->ReorderLevel ?? 10,
            'SupplierID' => $request->SupplierID,
            'ProductStatus' => 'Active'
        ]);

        // 2. Create Pricing
        Pricing::create([
            'ProductID' => $request->SKUNumber,
            'OriginalPrice' => $request->OriginalPrice,
            'RetailPrice' => $request->RetailPrice,
            'MarkupRate' => (($request->RetailPrice - $request->OriginalPrice) / $request->OriginalPrice) * 100,
            'EffectiveDate' => now(),
            'IsActive' => true
        ]);

        // 3. Create StockIn record linked to the product
        StockIn::create([
            'ProductID' => $request->SKUNumber, // Link to the new product
            'SupplierID' => $request->SupplierID,
            'Qty' => $request->Qty,
            'ProdStatus' => $request->ProdStatus,
            'DateRcvd' => $request->DateRcvd,
            // No temp fields needed
        ]);

        DB::commit();

        return redirect()->route('admin.stockin')
            ->with('success', 'Product created and stocked successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->with('error', 'Error: ' . $e->getMessage())
            ->withInput();
    }
}
}
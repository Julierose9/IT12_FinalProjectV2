<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockIn;
use App\Models\Category;
use App\Models\Pricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $existingProducts = Product::where('ProductStatus', 'Available')
            ->with(['category', 'supplier'])
            ->with(['pricing' => function ($query) {
                $query->where('IsActive', 'yes')
                      ->orderByDesc('EffectiveDate')
                      ->limit(1);
            }])
            ->get();

        $stockIns = StockIn::with([
                'product.category',
                'product.supplier',
                'product.pricing' => function ($query) {
                    $query->where('IsActive', 'yes')
                          ->orderByDesc('EffectiveDate')
                          ->limit(1);
                }
            ])
            ->orderByDesc('DateRcvd')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.stockin', compact(
            'existingProducts',
            'categories',
            'stockIns'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ProductID' => 'required|exists:products,ProductID',
            'Qty' => 'required|integer|min:1',
            'ProdStatus' => 'required|in:Received,Defective,Expired',
            'DateRcvd' => 'required|date',
            'OriginalPrice' => 'required|numeric|min:0',
            'MarkupRate' => 'required|numeric|min:0',
            'RetailPrice' => 'required|numeric|min:0',
            'ReorderLevel' => 'nullable|integer|min:1',
            'ExpirationDate' => 'nullable|date',
            'Size' => 'nullable|string|max:50',
            'Type' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($request) {
            $stockIn = StockIn::create([
                'ProductID' => $request->ProductID,
                'SupplierID' => $request->SupplierID,
                'Qty' => $request->Qty,
                'ProdStatus' => $request->ProdStatus,
                'DateRcvd' => $request->DateRcvd,
                'ExpirationDate' => $request->filled('ExpirationDate') ? $request->ExpirationDate : null,
                'Size' => $request->filled('Size') ? $request->Size : null,
                'Type' => $request->filled('Type') ? $request->Type : null,
            ]);

            $product = Product::findOrFail($request->ProductID);

            if ($request->ProdStatus === 'Received') {
                $product->StockQty += $request->Qty;
            }

            if ($request->filled('ReorderLevel') && $request->ReorderLevel > 0) {
                $product->ReorderLevel = $request->ReorderLevel;
            }

            if ($request->filled('Size')) {
                $product->Size = $request->Size;
            }
            if ($request->filled('Type')) {
                $product->Type = $request->Type;
            }

            $product->save();

            Pricing::where('ProductID', $product->ProductID)
                ->where('IsActive', 'yes')
                ->update(['IsActive' => 'no']);
            
            Pricing::create([
                'ProductID' => $product->ProductID,
                'OriginalPrice' => $request->OriginalPrice,
                'MarkupRate' => $request->MarkupRate,
                'RetailPrice' => $request->RetailPrice,
                'EffectiveDate' => now(),
                'IsActive' => 'yes'
            ]);
        });

        return redirect()->route('admin.stockin')->with('success', 'Stock added successfully!');
    }

    public function show($id)
    {
        try {
            $stock = StockIn::with([
                'product.category',
                'product.supplier',
                'product.pricing' => function ($query) {
                    $query->where('IsActive', 'yes')
                          ->orderByDesc('EffectiveDate')
                          ->limit(1);
                },
                'supplier'
            ])->findOrFail($id);

            $pricing = $stock->product->pricing->first();

            return response()->json([
                'success' => true,
                'stock_in' => $stock,
                'product' => $stock->product,
                'pricing' => $pricing,
                'supplier' => $stock->supplier ?? $stock->product->supplier,
                'category' => $stock->product->category
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Stock record not found.'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Qty' => 'required|integer|min:1',
            'ProdStatus' => 'required|in:Received,Defective,Expired',
            'DateRcvd' => 'required|date',
            'OriginalPrice' => 'required|numeric|min:0',
            'MarkupRate' => 'required|numeric|min:0',
            'RetailPrice' => 'required|numeric|min:0',
            'ReorderLevel' => 'nullable|integer|min:1',
            'ExpirationDate' => 'nullable|date',
            'Size' => 'nullable|string|max:50',
            'Type' => 'nullable|string|max:100',
        ]);
    
        DB::transaction(function () use ($request, $id) {
            $stockIn = StockIn::findOrFail($id);
            $product = $stockIn->product;
    
            // Calculate stock adjustment based on status changes
            $oldQty = $stockIn->Qty;
            $newQty = $request->Qty;
            $oldStatus = $stockIn->ProdStatus;
            $newStatus = $request->ProdStatus;
    
            // Adjust product stock
            if ($oldStatus === 'Received' && $newStatus !== 'Received') {
                // Was Received, now not Received - subtract old quantity
                $product->StockQty -= $oldQty;
            } elseif ($oldStatus !== 'Received' && $newStatus === 'Received') {
                // Was not Received, now Received - add new quantity
                $product->StockQty += $newQty;
            } elseif ($oldStatus === 'Received' && $newStatus === 'Received') {
                // Both Received - adjust by difference
                $product->StockQty += ($newQty - $oldQty);
            }
            // If neither old nor new is Received, no stock adjustment
    
            $product->StockQty = max(0, $product->StockQty);
    
            // Update reorder level if provided
            if ($request->filled('ReorderLevel') && $request->ReorderLevel > 0) {
                $product->ReorderLevel = $request->ReorderLevel;
            }
    
            // Update conditional fields
            if ($request->filled('Size')) {
                $product->Size = $request->Size;
            }
            if ($request->filled('Type')) {
                $product->Type = $request->Type;
            }
    
            $product->save();
    
            // Update stock in record
            $stockIn->Qty = $newQty;
            $stockIn->ProdStatus = $newStatus;
            $stockIn->DateRcvd = $request->DateRcvd;
            $stockIn->ExpirationDate = $request->filled('ExpirationDate') ? $request->ExpirationDate : null;
            $stockIn->Size = $request->filled('Size') ? $request->Size : null;
            $stockIn->Type = $request->filled('Type') ? $request->Type : null;
            $stockIn->save();
    
            // Update pricing
            Pricing::where('ProductID', $product->ProductID)
                ->where('IsActive', 'yes')
                ->update(['IsActive' => 'no']);
            
            Pricing::create([
                'ProductID' => $product->ProductID,
                'OriginalPrice' => $request->OriginalPrice,
                'MarkupRate' => $request->MarkupRate,
                'RetailPrice' => $request->RetailPrice,
                'EffectiveDate' => now(),
                'IsActive' => 'yes'
            ]);
        });
    
        return response()->json([
            'success' => true,
            'message' => 'Stock record updated successfully!',
            'updatedStock' => StockIn::with(['product', 'product.pricing'])->find($id)
        ]);
    }
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $stockIn = StockIn::findOrFail($id);
            $product = $stockIn->product;

            if ($stockIn->ProdStatus === 'Received') {
                $product->StockQty -= $stockIn->Qty;
                $product->StockQty = max(0, $product->StockQty);
                $product->save();
            }

            $stockIn->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Stock record deleted successfully.'
        ]);
    }

    // Add this method for product pricing API
    public function getProductPricing($id)
    {
        try {
            $product = Product::with(['pricing' => function($query) {
                $query->where('IsActive', 'yes')
                      ->orderByDesc('EffectiveDate')
                      ->first();
            }])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $product->ProductID,
                    'name' => $product->ProductName,
                    'sku' => $product->SKUNumber,
                    'stock_qty' => $product->StockQty,
                    'reorder_level' => $product->ReorderLevel,
                    'supplier_name' => $product->supplier->SupplierName ?? 'No Supplier',
                    'supplier_id' => $product->supplier->SupplierID ?? null,
                    'category_id' => $product->category->CategoryID ?? null,
                    'category_name' => $product->category->CategoryName ?? 'No Category',
                    'size' => $product->Size ?? '',
                    'type' => $product->Type ?? '',
                    'cost_price' => $product->pricing->OriginalPrice ?? 0,
                    'markup_rate' => $product->pricing->MarkupRate ?? 30,
                    'retail_price' => $product->pricing->RetailPrice ?? 0
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Product not found'
            ], 404);
        }
    }
}
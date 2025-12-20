<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'supplier'])
            ->orderBy('ProductID')
            ->get();

        $categories = Category::withCount('products')->get();
        $suppliers = Supplier::all();

        return view('admin.products', compact(
            'products',
            'categories',
            'suppliers'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ProductName'        => 'required|string|max:255',
            'ProductDescription' => 'nullable|string',
            'CategoryID'         => 'required|exists:categories,CategoryID',
            'SupplierID'         => 'required|exists:suppliers,SupplierID',
            'ProductStatus'      => 'required|in:Available,Phased Out',
        ]);

        DB::beginTransaction();
        try {
            // Generate ProductID: e.g., "PROD0001" (WITHOUT DASH)
            $lastProduct = Product::orderByDesc('ProductID')->first();
            
            if ($lastProduct) {
                // Extract number from ProductID (handles PROD0001 format)
                if (preg_match('/PROD(\d+)/', $lastProduct->ProductID, $matches)) {
                    $nextNumber = (int)$matches[1] + 1;
                } else {
                    $nextNumber = 1;
                }
            } else {
                $nextNumber = 1;
            }
            
            $productID = 'PROD' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            
            // Generate SKU based on category
            $category = Category::findOrFail($request->CategoryID);
            $prefix = strtoupper(substr($category->CategoryName, 0, 3));
            
            // Find the last SKU for this category prefix
            $lastSKU = Product::where('SKUNumber', 'LIKE', $prefix . '-%')
                ->orderByDesc('SKUNumber')
                ->first();
            
            if ($lastSKU) {
                // Extract number from SKU (e.g., BEA-0001 -> 1)
                if (preg_match('/-(\d+)$/', $lastSKU->SKUNumber, $matches)) {
                    $nextSKUNumber = (int)$matches[1] + 1;
                } else {
                    $nextSKUNumber = 1;
                }
            } else {
                $nextSKUNumber = 1;
            }
            
            $skuNumber = $prefix  . str_pad($nextSKUNumber, 4, '0', STR_PAD_LEFT);

            // Check if SKU already exists (safety check)
            $existingSKU = Product::where('SKUNumber', $skuNumber)->first();
            if ($existingSKU) {
                // If SKU exists, increment until we find a unique one
                $counter = $nextSKUNumber;
                do {
                    $counter++;
                    $skuNumber = $prefix . '-' . str_pad($counter, 4, '0', STR_PAD_LEFT);
                } while (Product::where('SKUNumber', $skuNumber)->exists());
            }

            // Create Product
            $product = Product::create([
                'ProductID'          => $productID,
                'SKUNumber'          => $skuNumber,
                'ProductName'        => $request->ProductName,
                'ProductDescription' => $request->ProductDescription,
                'CategoryID'         => $request->CategoryID,
                'SupplierID'         => $request->SupplierID,
                'ProductStatus'      => $request->ProductStatus,
            ]);

            DB::commit();

            return redirect()->route('admin.products')
                ->with('success', "Product created successfully! Product ID: <strong>{$productID}</strong>, SKU: <strong>{$skuNumber}</strong>");

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Product creation failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to create product: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'ProductName'        => 'required|string|max:255',
            'ProductDescription' => 'nullable|string',
            'CategoryID'         => 'required|exists:categories,CategoryID',
            'SupplierID'         => 'required|exists:suppliers,SupplierID',
            'ProductStatus'      => 'required|in:Available,Phase Out',
        ]);

        try {
            $product->update([
                'ProductName'       => $request->ProductName,
                'ProductDescription'=> $request->ProductDescription,
                'CategoryID'        => $request->CategoryID,
                'SupplierID'        => $request->SupplierID,
                'ProductStatus'     => $request->ProductStatus,
            ]);

            return redirect()->route('admin.products')
                ->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update product: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);

            // Check if product has any stock records
            if ($product->stockIns()->exists()) {
                return redirect()->back()
                    ->with('error', 'Cannot delete product. It has stock records. Please remove stock records first in the Stock In module.');
            }

            $product->delete();

            DB::commit();

            return redirect()->route('admin.products')
                ->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }
}
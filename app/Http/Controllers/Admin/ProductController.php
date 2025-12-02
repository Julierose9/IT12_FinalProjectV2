<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Pricing;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\StockIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'supplier', 'pricing'])
            ->orderBy('ProductName')
            ->get();

        $categories = Category::withCount('products')->get();
        $suppliers = Supplier::all();
        
        // Show recent stock-ins with their products
        $recentStock = StockIn::with(['product', 'supplier'])
            ->orderBy('DateRcvd', 'desc')
            ->limit(10)
            ->get();

        return view('admin.products', compact(
            'products', 
            'categories', 
            'suppliers',
            'recentStock'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'SKUNumber' => 'required|unique:products,SKUNumber',
            'ProductName' => 'required|string|max:255',
            'ProductDescription' => 'nullable|string',
            'CategoryID' => 'nullable|exists:categories,CategoryID',
            'ReorderLevel' => 'required|integer|min:0',
            'SupplierID' => 'required|exists:suppliers,SupplierID',
            'ProductStatus' => 'required|in:Active,Inactive',
            'OriginalPrice' => 'required|numeric|min:0',
            'RetailPrice' => 'required|numeric|min:0',
            'initial_quantity' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Create Product
            $product = Product::create([
                'SKUNumber' => $request->SKUNumber,
                'ProductName' => $request->ProductName,
                'ProductDescription' => $request->ProductDescription,
                'CategoryID' => $request->CategoryID,
                'ReorderLevel' => $request->ReorderLevel,
                'SupplierID' => $request->SupplierID,
                'ProductStatus' => $request->ProductStatus
            ]);

            // Create Pricing
            Pricing::create([
                'ProductID' => $request->SKUNumber,
                'OriginalPrice' => $request->OriginalPrice,
                'RetailPrice' => $request->RetailPrice,
                'MarkupRate' => (($request->RetailPrice - $request->OriginalPrice) / $request->OriginalPrice) * 100,
                'EffectiveDate' => now(),
                'IsActive' => true
            ]);

            // Create initial stock record if quantity provided
            if ($request->filled('initial_quantity') && $request->initial_quantity > 0) {
                StockIn::create([
                    'StockInID' => 'STK-' . time(),
                    'ProductID' => $request->SKUNumber,
                    'SupplierID' => $request->SupplierID,
                    'Qty' => $request->initial_quantity,
                    'ProdStatus' => 'Received',
                    'DateRcvd' => now(),
                ]);
            }

            DB::commit();

            $message = 'Product created successfully!';
            if ($request->filled('initial_quantity')) {
                $message .= ' Initial stock added.';
            }

            return redirect()->route('admin.products')
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error creating product: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $product = Product::with(['category', 'supplier', 'pricing'])->findOrFail($id);
        return response()->json($product);
    }

    public function edit($id)
    {
        $product = Product::with('pricing')->findOrFail($id);
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('admin.partials.edit-product-form', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'ProductName' => 'required|string|max:255',
            'ProductDescription' => 'nullable|string',
            'CategoryID' => 'nullable|exists:categories,CategoryID',
            'ReorderLevel' => 'required|integer|min:0',
            'SupplierID' => 'nullable|exists:suppliers,SupplierID',
            'ProductStatus' => 'required|in:Active,Inactive'
        ]);

        try {
            $product->update([
                'ProductName' => $request->ProductName,
                'ProductDescription' => $request->ProductDescription,
                'CategoryID' => $request->CategoryID,
                'ReorderLevel' => $request->ReorderLevel,
                'SupplierID' => $request->SupplierID,
                'ProductStatus' => $request->ProductStatus
            ]);

            return redirect()->route('admin.products')
                ->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating product: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            
            // Check if product has stock records
            $hasStock = StockIn::where('ProductID', $id)->exists();
            
            if ($hasStock) {
                return redirect()->back()
                    ->with('error', 'Cannot delete product. It has stock records. Delete stock records first.');
            }
            
            // Delete associated pricing records
            Pricing::where('ProductID', $id)->delete();
            
            // Delete the product
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

    public function updatePricing(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,SKUNumber',
            'retail_price' => 'required|numeric|min:0',
            'original_price' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();
        try {
            // Deactivate old pricing
            Pricing::where('ProductID', $request->product_id)
                ->update(['IsActive' => false]);

            // Create new pricing
            Pricing::create([
                'ProductID' => $request->product_id,
                'OriginalPrice' => $request->original_price,
                'RetailPrice' => $request->retail_price,
                'MarkupRate' => (($request->retail_price - $request->original_price) / $request->original_price) * 100,
                'EffectiveDate' => now(),
                'IsActive' => true
            ]);

            DB::commit();

            return redirect()->route('admin.products')
                ->with('success', 'Product pricing updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating pricing: ' . $e->getMessage());
        }
    }

    public function updateSinglePricing(Request $request, $id)
    {
        $request->validate([
            'retail_price' => 'required|numeric|min:0',
            'original_price' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();
        try {
            // Deactivate old pricing
            Pricing::where('ProductID', $id)
                ->update(['IsActive' => false]);

            // Create new pricing
            Pricing::create([
                'ProductID' => $id,
                'OriginalPrice' => $request->original_price,
                'RetailPrice' => $request->retail_price,
                'MarkupRate' => (($request->retail_price - $request->original_price) / $request->original_price) * 100,
                'EffectiveDate' => now(),
                'IsActive' => true
            ]);

            DB::commit();

            return redirect()->route('admin.products')
                ->with('success', 'Product pricing updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating pricing: ' . $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('search');
        
        $products = Product::with(['category', 'supplier', 'pricing'])
            ->when($searchTerm, function($query) use ($searchTerm) {
                $query->where('ProductName', 'like', "%{$searchTerm}%")
                    ->orWhere('ProductDescription', 'like', "%{$searchTerm}%")
                    ->orWhere('SKUNumber', 'like', "%{$searchTerm}%");
            })
            ->orderBy('ProductName')
            ->get();

        return response()->json($products);
    }
}
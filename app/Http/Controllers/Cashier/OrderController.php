<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\InventoryMovement;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\StockIn;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InventoryReportController extends Controller
{
    public function index(Request $request)
    {
        // Get all products with categories
        $query = Product::with(['category'])
            ->where('ProductStatus', 'Active');
        
        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ProductID', 'like', '%' . $search . '%')
                  ->orWhere('ProductName', 'like', '%' . $search . '%')
                  ->orWhere('SKUNumber', 'like', '%' . $search . '%')
                  ->orWhereHas('category', function($q2) use ($search) {
                      $q2->where('CategoryName', 'like', '%' . $search . '%');
                  });
            });
        }
        
        // Get the products first
        $products = $query->orderBy('ProductName')->get();
        
        // Calculate stock for each product
        $products = $products->map(function($product) {
            $product->current_stock = $this->calculateProductStock($product->ProductID);
            return $product;
        });
        
        // Apply stock status filters
        if ($request->has('stock_status') && is_array($request->stock_status) && count($request->stock_status) > 0) {
            $products = $products->filter(function($product) use ($request) {
                $statusMatch = false;
                foreach ($request->stock_status as $status) {
                    if ($status == 'instock' && $product->current_stock > ($product->ReorderLvl ?? 0)) {
                        $statusMatch = true;
                    } elseif ($status == 'low' && $product->current_stock > 0 && $product->current_stock <= ($product->ReorderLvl ?? 5)) {
                        $statusMatch = true;
                    } elseif ($status == 'out' && $product->current_stock <= 0) {
                        $statusMatch = true;
                    }
                }
                return $statusMatch;
            });
        }
        
        // Apply category filters
        if ($request->has('categories') && is_array($request->categories) && count($request->categories) > 0) {
            $products = $products->filter(function($product) use ($request) {
                return in_array($product->CatID, $request->categories);
            });
        }
        
        // Get categories for filter dropdown
        $categories = Category::orderBy('CategoryName')->get();
        
        // Paginate the results manually
        $page = $request->get('page', 1);
        $perPage = 20;
        $paginatedProducts = new \Illuminate\Pagination\LengthAwarePaginator(
            $products->forPage($page, $perPage),
            $products->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        
        // Calculate summary statistics
        $totalProducts = $products->count();
        $inStockCount = $products->where('current_stock', '>', 0)->count();
        $lowStockCount = $products->where('current_stock', '>', 0)
            ->where('current_stock', '<=', function($product) {
                return $product->ReorderLvl ?? 5;
            })->count();
        $outOfStockCount = $products->where('current_stock', '<=', 0)->count();
        
        // Get recent inventory movements
        $recentMovements = InventoryMovement::with(['product'])
            ->orderBy('ChangeDateTime', 'desc')
            ->take(30)
            ->get();
        
        return view('admin.inventory', compact(
            'products', 
            'paginatedProducts',
            'categories', 
            'recentMovements',
            'totalProducts',
            'inStockCount',
            'lowStockCount',
            'outOfStockCount'
        ));
    }
    
    // Calculate product stock
    private function calculateProductStock($productId)
    {
        // Calculate from StockIn table
        $stockInTotal = StockIn::where('ProductID', $productId)
            ->where('ProdStatus', 'Good')
            ->sum('Qty');
        
        // Calculate from InventoryMovements (sales)
        $salesDeduction = InventoryMovement::where('ProductID', $productId)
            ->where('ChangeType', 'Decrease')
            ->sum('QtyChange');
        
        return max(0, $stockInTotal - $salesDeduction);
    }
    
    public function productTransactions($id)
    {
        $product = Product::findOrFail($id);
        
        // Get inventory movements for this product
        $movements = InventoryMovement::where('ProductID', $id)
            ->orderBy('ChangeDateTime', 'desc')
            ->take(50)
            ->get();
        
        // Get sales data from orders
        $sales = OrderDetail::with(['order.employee'])
            ->where('ProductID', $id)
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();
        
        // Calculate current stock
        $currentStock = $this->calculateProductStock($id);
        
        if (request()->ajax()) {
            return view('admin.inventory.partials.transactions', compact(
                'product', 
                'movements', 
                'sales',
                'currentStock'
            ));
        }
        
        return view('admin.inventory.transactions', compact(
            'product', 
            'movements', 
            'sales',
            'currentStock'
        ));
    }
    
    public function export(Request $request)
    {
        // Get all products
        $products = Product::with(['category'])
            ->where('ProductStatus', 'Active')
            ->orderBy('ProductName')
            ->get()
            ->map(function($product) {
                $product->current_stock = $this->calculateProductStock($product->ProductID);
                return $product;
            });
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="inventory_report_' . date('Y-m-d') . '.csv"',
        ];
        
        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'Product ID',
                'SKU',
                'Product Name',
                'Category',
                'Current Stock',
                'Reorder Level',
                'Stock Status',
                'Cost Price',
                'Selling Price',
                'Total Value (Cost)',
                'Last Updated'
            ]);
            
            // Add data rows
            foreach ($products as $product) {
                $status = 'In Stock';
                if ($product->current_stock <= 0) {
                    $status = 'Out of Stock';
                } elseif ($product->current_stock <= ($product->ReorderLvl ?? 5)) {
                    $status = 'Low Stock';
                }
                
                $totalValue = $product->current_stock * ($product->CostPrice ?? 0);
                
                fputcsv($file, [
                    $product->ProductID,
                    $product->SKUNumber,
                    $product->ProductName,
                    $product->category?->CategoryName ?? 'Uncategorized',
                    $product->current_stock,
                    $product->ReorderLvl ?? 5,
                    $status,
                    number_format($product->CostPrice ?? 0, 2),
                    number_format($product->SellingPrice ?? 0, 2),
                    number_format($totalValue, 2),
                    $product->updated_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
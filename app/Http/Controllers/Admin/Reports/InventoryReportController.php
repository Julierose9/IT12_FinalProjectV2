<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\InventoryMovement;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\StockIn;
use App\Models\PullOut;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class InventoryReportController extends Controller
{
    public function index(Request $request)
    {
        // Get all products with categories and pricing
        $query = Product::with(['category', 'pricing'])
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
        // Calculate from StockIn table (only count 'Received' status)
        $stockInTotal = StockIn::where('ProductID', $productId)
            ->where('ProdStatus', 'Received')
            ->sum('Qty');
        
        // Calculate from OrderDetails (sales/orders) - Pull-outs are separate
        $salesDeduction = OrderDetail::where('ProductID', $productId)
            ->whereHas('order', function($query) {
                $query->where('OrderStatus', 'Completed');
            })
            ->sum('OrderQty');
        
        // Calculate total pulled out quantity (separate from sales)
        $pulledOutQty = PullOut::where('ProductID', $productId)
            ->sum('PullOutQty');
        
        // Available stock = Stock In - Sales (Orders) - Pull Outs
        return max(0, $stockInTotal - $salesDeduction - $pulledOutQty);
    }
    
    public function productTransactions($id)
    {
        $product = Product::with(['category', 'pricing'])->findOrFail($id);
        
        // Get stock in records
        $stockIns = StockIn::with(['supplier'])
            ->where('ProductID', $id)
            ->orderBy('DateRcvd', 'desc')
            ->take(50)
            ->get();
        
        // Get pull out records
        $pullOuts = PullOut::with(['employee'])
            ->where('ProductID', $id)
            ->orderBy('DatePullOut', 'desc')
            ->take(50)
            ->get();
        
        // Get sales data from orders
        $sales = OrderDetail::with(['order.employee'])
            ->where('ProductID', $id)
            ->whereHas('order', function($query) {
                $query->where('OrderStatus', 'Completed');
            })
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get();
        
        // Get inventory movements for this product
        $movements = InventoryMovement::where('ProductID', $id)
            ->orderBy('ChangeDateTime', 'desc')
            ->take(50)
            ->get();
        
        // Calculate current stock
        $currentStock = $this->calculateProductStock($id);
        
        // Return partial view for AJAX requests
        if (request()->ajax() || request()->wantsJson() || request()->header('X-Requested-With') == 'XMLHttpRequest') {
            return view('admin.inventory.partials.transactions', compact(
                'product', 
                'stockIns',
                'pullOuts',
                'sales',
                'movements',
                'currentStock'
            ));
        }
        
        // Return full page view for non-AJAX requests
        return view('admin.inventory.transactions', compact(
            'product', 
            'stockIns',
            'pullOuts',
            'sales',
            'movements',
            'currentStock'
        ));
    }
    
    public function export(Request $request)
    {
        // Get all products with computed stock
        $products = Product::with(['category', 'pricing'])
            ->where('ProductStatus', 'Active')
            ->orderBy('ProductName')
            ->get()
            ->map(function($product) {
                $product->current_stock = $this->calculateProductStock($product->ProductID);
                return $product;
            });

        $generatedAt = Carbon::now();

        $pdf = Pdf::loadView('admin.reports.inventory_pdf', [
            'products' => $products,
            'generatedAt' => $generatedAt,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('inventory_report_' . $generatedAt->format('Y-m-d') . '.pdf');
    }
}


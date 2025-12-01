<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class InventoryReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ProdID', 'LIKE', "%{$search}%")
                  ->orWhere('ProdName', 'LIKE', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('CatName', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        // Status filter
        if ($request->filled('status')) {
            // Convert string to array if needed
            $statuses = is_array($request->status) ? $request->status : explode(',', $request->status);
            
            if (!in_array('all', $statuses)) {
                $query->where(function($q) use ($statuses) {
                    if (in_array('instock', $statuses)) {
                        $q->orWhereRaw('CurrentStock > ReorderLvl');
                    }
                    if (in_array('low', $statuses)) {
                        $q->orWhereRaw('CurrentStock <= ReorderLvl');
                    }
                });
            }
        }
        
        // Category filter
        if ($request->filled('category')) {
            // Convert string to array if needed
            $categories = is_array($request->category) ? $request->category : explode(',', $request->category);
            
            if (!in_array('all', $categories)) {
                $query->whereIn('category_id', $categories);
            }
        }
        
        // Stock level filter
        if ($request->filled('stock_level') && $request->stock_level != 'all') {
            switch ($request->stock_level) {
                case 'critical':
                    $query->whereRaw('CurrentStock <= ReorderLvl');
                    break;
                case 'medium':
                    $query->whereRaw('CurrentStock > ReorderLvl AND CurrentStock <= (ReorderLvl * 2)');
                    break;
                case 'high':
                    $query->whereRaw('CurrentStock > (ReorderLvl * 2)');
                    break;
            }
        }
        
        // Date filter
        if ($request->filled('date_from')) {
            $query->whereDate('updated_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('updated_at', '<=', $request->date_to);
        }
        
        // Order by last updated (most recent first)
        $query->orderBy('updated_at', 'desc');
        
        // Get all categories for filter dropdown
        $categories = Category::all();
        
        // Paginate results (20 per page by default)
        $perPage = $request->get('per_page', 20);
        $products = $query->paginate($perPage)->appends($request->except('page'));
        
        // Calculate statistics for the filtered results
        $allProducts = $query->get(); // Get all filtered products for stats
        
        $stats = [
            'total_products' => $allProducts->count(),
            'in_stock' => $allProducts->filter(function($product) {
                return $product->CurrentStock > $product->ReorderLvl;
            })->count(),
            'low_stock' => $allProducts->filter(function($product) {
                return $product->CurrentStock <= $product->ReorderLvl;
            })->count(),
            'total_value' => $allProducts->sum(function($product) {
                return $product->CurrentStock * ($product->ProdPrice ?? 0);
            }),
        ];
        
        return view('admin.reports.inventory', compact('products', 'categories', 'stats'));
    }
    
    public function export(Request $request)
    {
        $query = Product::with('category');
        
        // Apply same filters as index method
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('ProdID', 'LIKE', "%{$search}%")
                  ->orWhere('ProdName', 'LIKE', "%{$search}%");
            });
        }
        
        if ($request->filled('status')) {
            $statuses = is_array($request->status) ? $request->status : explode(',', $request->status);
            if (!in_array('all', $statuses)) {
                $query->where(function($q) use ($statuses) {
                    if (in_array('instock', $statuses)) {
                        $q->orWhereRaw('CurrentStock > ReorderLvl');
                    }
                    if (in_array('low', $statuses)) {
                        $q->orWhereRaw('CurrentStock <= ReorderLvl');
                    }
                });
            }
        }
        
        if ($request->filled('category')) {
            $categories = is_array($request->category) ? $request->category : explode(',', $request->category);
            if (!in_array('all', $categories)) {
                $query->whereIn('category_id', $categories);
            }
        }
        
        if ($request->filled('stock_level') && $request->stock_level != 'all') {
            switch ($request->stock_level) {
                case 'critical':
                    $query->whereRaw('CurrentStock <= ReorderLvl');
                    break;
                case 'medium':
                    $query->whereRaw('CurrentStock > ReorderLvl AND CurrentStock <= (ReorderLvl * 2)');
                    break;
                case 'high':
                    $query->whereRaw('CurrentStock > (ReorderLvl * 2)');
                    break;
            }
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('updated_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('updated_at', '<=', $request->date_to);
        }
        
        $products = $query->orderBy('updated_at', 'desc')->get();
        
        $csvData = [];
        $csvData[] = ['Product ID', 'Product Name', 'SKU', 'Category', 'Current Stock', 'Reorder Level', 'Status', 'Last Updated'];
        
        foreach ($products as $product) {
            $status = $product->CurrentStock <= $product->ReorderLvl ? 'Low Stock' : 'In Stock';
            
            $csvData[] = [
                $product->ProdID,
                $product->ProdName,
                $product->ProdID,
                $product->category->CatName ?? 'N/A',
                $product->CurrentStock,
                $product->ReorderLvl,
                $status,
                $product->updated_at->format('Y-m-d H:i:s')
            ];
        }
        
        $filename = 'inventory_report_' . date('Y-m-d_H-i') . '.csv';
        
        return response()->streamDownload(function() use ($csvData) {
            $output = fopen('php://output', 'w');
            // Add BOM for UTF-8
            fputs($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
            foreach ($csvData as $row) {
                fputcsv($output, $row);
            }
            fclose($output);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
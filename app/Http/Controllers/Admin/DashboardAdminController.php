<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Employee;
use App\Models\Category;
use App\Models\StockIn;
use App\Models\PullOut;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Check if user is authenticated and is admin
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if user is admin
        if (Auth::user()->Role !== 'Admin') {
            abort(403, 'Unauthorized access. Admin role required.');
        }

        // Get authenticated user
        $user = Auth::user();
        $today = Carbon::today();
        
        // Get employee details if available
        $employeeName = $user->Username ?? 'Administrator';
        $employeeId = $user->EmployeeID ?? null;
        
        if ($employeeId) {
            $employee = Employee::where('EmployeeID', $employeeId)->first();
            if ($employee) {
                // Format employee name like in your EmployeeController
                $firstName = $employee->EmployeeFName ?? '';
                $middleName = $employee->EmployeeMName ? $employee->EmployeeMName . ' ' : '';
                $lastName = $employee->EmployeeLName ?? '';
                $employeeName = trim("{$firstName} {$middleName}{$lastName}");
            }
        }

        // Get dashboard statistics with try-catch to avoid any errors
        $totalProducts = Product::count();
        
        // Get stock out today (pullouts for today)
        $stockOutToday = 0;
        try {
            $stockOutToday = PullOut::whereDate('DatePullOut', $today)
                ->sum('PullOutQty') ?? 0;
        } catch (\Exception $e) {
            // Log error if needed
            \Log::error('Error getting stock out today: ' . $e->getMessage());
        }
        
        // Get near expiry products from stock_in table
        $nearExpiry = 0;
        try {
            $nearExpiry = StockIn::whereNotNull('ExpirationDate')
                ->whereDate('ExpirationDate', '<=', Carbon::now()->addDays(30))
                ->whereDate('ExpirationDate', '>', Carbon::now())
                ->count();
        } catch (\Exception $e) {
            \Log::error('Error getting near expiry: ' . $e->getMessage());
        }
        
        // Calculate low stock items (less than 20)
        $lowStock = 0;
        try {
            $lowStock = Product::where('StockQty', '<', 20)->count();
        } catch (\Exception $e) {
            \Log::error('Error getting low stock: ' . $e->getMessage());
        }
        
        // Get top products (most stock quantity)
        $topProducts = collect([]);
        try {
            $topProducts = Product::with('category')
                ->orderBy('StockQty', 'desc')
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            \Log::error('Error getting top products: ' . $e->getMessage());
        }
        
        // Get all categories for filters
        $categories = Category::all();
        
        // Get recent stock ins (last 7 days)
        $recentStockIns = 0;
        try {
            $recentStockIns = StockIn::whereDate('DateRcvd', '>=', Carbon::now()->subDays(7))
                ->sum('Qty') ?? 0;
        } catch (\Exception $e) {
            \Log::error('Error getting recent stock ins: ' . $e->getMessage());
        }
        
        // Get recent pullouts (last 7 days)
        $recentPullouts = 0;
        try {
            $recentPullouts = PullOut::whereDate('DatePullOut', '>=', Carbon::now()->subDays(7))
                ->sum('PullOutQty') ?? 0;
        } catch (\Exception $e) {
            \Log::error('Error getting recent pullouts: ' . $e->getMessage());
        }
        
        // Get inventory status stats
        $healthyStock = 0;
        $warningStock = 0;
        $criticalStock = 0;
        try {
            $healthyStock = Product::where('StockQty', '>', 20)->count();
            $warningStock = Product::whereBetween('StockQty', [11, 20])->count();
            $criticalStock = Product::where('StockQty', '<=', 10)->count();
        } catch (\Exception $e) {
            \Log::error('Error getting inventory status: ' . $e->getMessage());
        }

        // Prepare stats array for the view
        $stats = [
            'totalProducts' => $totalProducts,
            'stockOutToday' => $stockOutToday,
            'nearExpiry' => $nearExpiry,
            'lowStock' => $lowStock,
            'healthyStock' => $healthyStock,
            'warningStock' => $warningStock,
            'criticalStock' => $criticalStock,
        ];

        return view('admin.dashboard', [
            'user' => $user,
            'employeeName' => $employeeName,
            'employeeId' => $employeeId,
            'today' => $today,
            'stats' => $stats, // Pass stats as array
            'topProducts' => $topProducts,
            'categories' => $categories,
            'recentStockIns' => $recentStockIns,
            'recentPullouts' => $recentPullouts
        ]);
    }

    // API endpoint for real-time dashboard data
    public function getDashboardData(Request $request)
    {
        // Check if user is authenticated and is admin
        if (!Auth::check() || Auth::user()->Role !== 'Admin') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $date = $request->get('date', date('Y-m-d'));
        $startDate = Carbon::parse($date)->startOfDay();
        
        // Get basic stats
        $stats = [
            'totalProducts' => Product::count(),
            'stockOutToday' => PullOut::whereDate('DatePullOut', $date)->sum('PullOutQty') ?? 0,
            'nearExpiry' => StockIn::whereNotNull('ExpirationDate')
                ->whereDate('ExpirationDate', '<=', Carbon::now()->addDays(30))
                ->whereDate('ExpirationDate', '>', Carbon::now())
                ->count(),
            'lowStock' => Product::where('StockQty', '<', 20)->count(),
            'healthyStock' => Product::where('StockQty', '>', 20)->count(),
            'warningStock' => Product::whereBetween('StockQty', [11, 20])->count(),
            'criticalStock' => Product::where('StockQty', '<=', 10)->count(),
        ];

        // Get stock movement data (last 7 days)
        $stockMovementLabels = [];
        $stockMovementData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::parse($date)->subDays($i);
            $stockMovementLabels[] = $day->format('D');
            
            // Get stock in for this day
            $stockIn = StockIn::whereDate('DateRcvd', $day)->sum('Qty') ?? 0;
            // Get pullouts for this day
            $stockOut = PullOut::whereDate('DatePullOut', $day)->sum('PullOutQty') ?? 0;
            
            $stockMovementData[] = $stockIn - $stockOut;
        }

        // Get sales by category data (this month)
        $categories = Category::all();
        $salesByCategoryLabels = [];
        $salesByCategoryData = [];
        
        foreach ($categories as $category) {
            // Get products in this category
            $productIds = Product::where('CategoryID', $category->CategoryID)
                ->pluck('ProductID')
                ->toArray();
            
            // Get total pullouts for these products this month
            $totalSold = 0;
            if (!empty($productIds)) {
                $totalSold = PullOut::whereIn('ProductID', $productIds)
                    ->whereMonth('DatePullOut', $startDate->month)
                    ->whereYear('DatePullOut', $startDate->year)
                    ->sum('PullOutQty') ?? 0;
            }
            
            $salesByCategoryLabels[] = $category->CategoryName;
            $salesByCategoryData[] = $totalSold;
        }

        // Get inventory status data
        $inventoryStatusData = [
            $stats['healthyStock'],
            $stats['warningStock'],
            $stats['criticalStock']
        ];

        // Get top moving products (this week)
        $topProducts = Product::select('products.*', 
                DB::raw('COALESCE(SUM(pullouts.PullOutQty), 0) as total_sold')
            )
            ->leftJoin('pullouts', function($join) use ($startDate) {
                $join->on('products.ProductID', '=', 'pullouts.ProductID')
                     ->whereBetween('pullouts.DatePullOut', [
                         $startDate->copy()->startOfWeek(),
                         $startDate->copy()->endOfWeek()
                     ]);
            })
            ->with('category')
            ->groupBy('products.ProductID', 'products.ProductName', 'products.Description', 
                     'products.Price', 'products.StockQty', 'products.CategoryID', 
                     'products.SupplierID', 'products.Image', 'products.created_at', 
                     'products.updated_at')
            ->orderBy('total_sold', 'DESC')
            ->limit(10)
            ->get();

        // Format top products for API response
        $formattedTopProducts = $topProducts->map(function($product) {
            return [
                'id' => $product->ProductID,
                'name' => $product->ProductName,
                'sku' => $product->SKUNumber ?? 'N/A',
                'category' => $product->category->CategoryName ?? 'N/A',
                'sold' => $product->total_sold,
                'stock' => $product->StockQty
            ];
        });

        return response()->json([
            'stats' => $stats,
            'charts' => [
                'stockMovement' => [
                    'labels' => $stockMovementLabels,
                    'data' => $stockMovementData
                ],
                'salesByCategory' => [
                    'labels' => $salesByCategoryLabels,
                    'data' => $salesByCategoryData
                ],
                'inventoryStatus' => [
                    'labels' => ['Healthy', 'Low Stock', 'Critical'],
                    'data' => $inventoryStatusData
                ]
            ],
            'topProducts' => $formattedTopProducts,
            'date' => $date
        ]);
    }
}
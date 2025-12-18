<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use App\Models\StockIn;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        $todaySales = $this->getTodaySales($today);
        $weeklyStats = $this->getWeeklyStats($today);
        $monthlyStats = $this->getMonthlyStats($today);
        $topProductsToday = $this->getTopProductsToday($today);
        $recentOrders = $this->getRecentOrders($today);
        $lowStockProducts = $this->getLowStockProducts();
        $paymentBreakdown = $this->getPaymentBreakdown($today);
        
        return view('cashier.dashboard', compact(
            'todaySales',
            'weeklyStats',
            'monthlyStats',
            'topProductsToday',
            'recentOrders',
            'lowStockProducts',
            'paymentBreakdown',
            'today'
        ));
    }

    /**
     * API endpoint for dashboard stats (real-time data)
     */
    public function apiDashboardStats()
    {
        $today = Carbon::today();
        
        $todaySales = $this->getTodaySales($today);
        $topProducts = $this->getTopProductsToday($today, 5);
        $salesByHour = $this->getSalesByHour();
        $salesTrend = $this->getSalesTrend();
        
        return response()->json([
            'today_sales' => $todaySales,
            'top_products' => $topProducts,
            'sales_by_hour' => $salesByHour,
            'sales_trend' => $salesTrend,
        ]);
    }
    
    private function getTodaySales(Carbon $date)
    {
        $startOfDay = $date->copy()->startOfDay();
        $endOfDay = $date->copy()->endOfDay();
        
        $orders = Order::whereBetween('OrderDateTime', [$startOfDay, $endOfDay])->get();
        
        $totalItems = 0;
        foreach ($orders as $order) {
            $totalItems += $order->details->sum('OrderQty');
        }
        
        return [
            'total_sales' => $orders->sum('GrandTotal'),
            'total_orders' => $orders->count(),
            'total_items' => $totalItems,
            'average_order_value' => $orders->count() > 0 ? $orders->avg('GrandTotal') : 0,
        ];
    }
    
    private function getWeeklyStats(Carbon $date)
    {
        $startOfWeek = $date->copy()->startOfWeek();
        $endOfWeek = $date->copy()->endOfWeek();
        
        $weeklySales = Order::whereBetween('OrderDateTime', [$startOfWeek, $endOfWeek])
            ->sum('GrandTotal');
            
        $lastWeekStart = $date->copy()->subWeek()->startOfWeek();
        $lastWeekEnd = $date->copy()->subWeek()->endOfWeek();
        
        $lastWeekSales = Order::whereBetween('OrderDateTime', [$lastWeekStart, $lastWeekEnd])
            ->sum('GrandTotal');
            
        $growth = $lastWeekSales > 0 
            ? (($weeklySales - $lastWeekSales) / $lastWeekSales) * 100 
            : ($weeklySales > 0 ? 100 : 0);
            
        return [
            'total_sales' => $weeklySales,
            'growth' => $growth,
        ];
    }
    
    private function getMonthlyStats(Carbon $date)
    {
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();
        
        $monthlySales = Order::whereBetween('OrderDateTime', [$startOfMonth, $endOfMonth])
            ->sum('GrandTotal');
            
        $lastMonthStart = $date->copy()->subMonth()->startOfMonth();
        $lastMonthEnd = $date->copy()->subMonth()->endOfMonth();
        
        $lastMonthSales = Order::whereBetween('OrderDateTime', [$lastMonthStart, $lastMonthEnd])
            ->sum('GrandTotal');
            
        $growth = $lastMonthSales > 0 
            ? (($monthlySales - $lastMonthSales) / $lastMonthSales) * 100 
            : ($monthlySales > 0 ? 100 : 0);
            
        return [
            'total_sales' => $monthlySales,
            'growth' => $growth,
        ];
    }
    
    private function getTopProductsToday(Carbon $date, $limit = 5)
    {
        $startOfDay = $date->copy()->startOfDay();
        $endOfDay = $date->copy()->endOfDay();
        
        return OrderDetail::join('orders', 'order_details.OrderID', '=', 'orders.OrderID')
            ->join('products', 'order_details.ProductID', '=', 'products.ProductID')
            ->join('pricing', function($join) {
                $join->on('products.ProductID', '=', 'pricing.ProductID')
                     ->where('pricing.IsActive', '=', 'yes')
                     ->whereRaw('pricing.EffectiveDate = (
                         SELECT MAX(EffectiveDate) 
                         FROM pricing p2 
                         WHERE p2.ProductID = pricing.ProductID 
                         AND p2.IsActive = "yes"
                     )');
            })
            ->whereBetween('orders.OrderDateTime', [$startOfDay, $endOfDay])
            ->select(
                'products.ProductID',
                'products.ProductName',
                'products.SKUNumber',
                DB::raw('SUM(order_details.OrderQty) as total_quantity'),
                DB::raw('SUM(order_details.OrderQty * pricing.RetailPrice) as total_sales')
            )
            ->groupBy('products.ProductID', 'products.ProductName', 'products.SKUNumber')
            ->orderBy('total_quantity', 'desc')
            ->limit($limit)
            ->get();
    }
    
    private function getRecentOrders(Carbon $date)
    {
        $startOfDay = $date->copy()->startOfDay();
        $endOfDay = $date->copy()->endOfDay();
        
        return Order::with(['details.product'])
            ->whereBetween('OrderDateTime', [$startOfDay, $endOfDay])
            ->orderBy('OrderDateTime', 'desc')
            ->limit(5)
            ->get();
    }
    
    private function getLowStockProducts()
    {
        // OPTION 1: Select specific columns only (Recommended for better performance)
        $products = Product::select([
                'products.ProductID',
                'products.ProductName',
                'products.SKUNumber',
                'products.ReorderLevel',
                'products.ProductStatus',
                DB::raw('COALESCE(SUM(stock_in.Qty), 0) as total_stock')
            ])
            ->leftJoin('stock_in', 'products.ProductID', '=', 'stock_in.ProductID')
            ->where('products.ProductStatus', 'Active')
            ->groupBy([
                'products.ProductID',
                'products.ProductName',
                'products.SKUNumber',
                'products.ReorderLevel',
                'products.ProductStatus'
            ])
            ->havingRaw('total_stock <= products.ReorderLevel')
            ->orderBy('total_stock', 'asc')
            ->limit(5)
            ->get();
        
        return $products;
    }
    
    // OPTION 2: If you need all product columns, use a subquery approach
    private function getLowStockProductsAlternative()
    {
        // First, get product IDs with low stock using a subquery
        $lowStockProductIds = DB::table('products')
            ->select('products.ProductID', DB::raw('COALESCE(SUM(stock_in.Qty), 0) as total_stock'))
            ->leftJoin('stock_in', 'products.ProductID', '=', 'stock_in.ProductID')
            ->where('products.ProductStatus', 'Active')
            ->groupBy('products.ProductID')
            ->havingRaw('total_stock <= products.ReorderLevel')
            ->orderBy('total_stock', 'asc')
            ->limit(5)
            ->pluck('products.ProductID');
        
        // Then get full product models with relationships
        return Product::with(['supplier', 'category'])
            ->whereIn('ProductID', $lowStockProductIds)
            ->get()
            ->each(function ($product) {
                // Add the total_stock value to each product
                $product->total_stock = DB::table('stock_in')
                    ->where('ProductID', $product->ProductID)
                    ->sum('Qty') ?? 0;
            });
    }
    
    // OPTION 3: Disable strict mode for this query only (Not recommended)
    private function getLowStockProductsWithAnyMode()
    {
        // Store current mode
        $strictMode = DB::select("SELECT @@sql_mode as mode")[0]->mode;
        
        // Remove ONLY_FULL_GROUP_BY from sql_mode
        $newMode = str_replace('ONLY_FULL_GROUP_BY,', '', $strictMode);
        DB::statement("SET sql_mode = '{$newMode}'");
        
        try {
            $products = Product::select('products.*', DB::raw('COALESCE(SUM(stock_in.Qty), 0) as total_stock'))
                ->leftJoin('stock_in', 'products.ProductID', '=', 'stock_in.ProductID')
                ->where('products.ProductStatus', 'Active')
                ->groupBy('products.ProductID')
                ->havingRaw('total_stock <= products.ReorderLevel')
                ->orderBy('total_stock', 'asc')
                ->limit(5)
                ->get();
        } finally {
            // Restore original mode
            DB::statement("SET sql_mode = '{$strictMode}'");
        }
        
        return $products;
    }
    
    private function getPaymentBreakdown(Carbon $date)
    {
        $startOfDay = $date->copy()->startOfDay();
        $endOfDay = $date->copy()->endOfDay();
        
        $results = DB::table('orders')
            ->join('payments', 'orders.OrderID', '=', 'payments.OrderID')
            ->whereBetween('orders.OrderDateTime', [$startOfDay, $endOfDay])
            ->select(
                'payments.PaymentType',
                DB::raw('COUNT(DISTINCT orders.OrderID) as order_count'),
                DB::raw('SUM(orders.GrandTotal) as total_sales')
            )
            ->groupBy('payments.PaymentType')
            ->get();
            
        $breakdown = [];
        foreach ($results as $result) {
            $breakdown[$result->PaymentType] = [
                'orders' => $result->order_count,
                'sales' => $result->total_sales,
                'percentage' => 0,
            ];
        }
        
        $totalSales = $results->sum('total_sales');
        if ($totalSales > 0) {
            foreach ($breakdown as $method => $data) {
                $breakdown[$method]['percentage'] = ($data['sales'] / $totalSales) * 100;
            }
        }
        
        return $breakdown;
    }
    
    /**
     * Additional helper method to get sales by hour
     */
    public function getSalesByHour()
    {
        $today = Carbon::today();
        $startOfDay = $today->copy()->startOfDay();
        $endOfDay = $today->copy()->endOfDay();
        
        $salesByHour = Order::whereBetween('OrderDateTime', [$startOfDay, $endOfDay])
            ->select(
                DB::raw('HOUR(OrderDateTime) as hour'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(GrandTotal) as total_sales')
            )
            ->groupBy(DB::raw('HOUR(OrderDateTime)'))
            ->orderBy('hour')
            ->get();
        
        // Fill in missing hours with zero values
        $result = [];
        for ($hour = 0; $hour < 24; $hour++) {
            $found = $salesByHour->firstWhere('hour', $hour);
            $result[] = [
                'hour' => $hour,
                'orders' => $found ? $found->order_count : 0,
                'sales' => $found ? $found->total_sales : 0,
            ];
        }
        
        return $result;
    }

    /**
     * Get sales trend for last 7 days
     */
    private function getSalesTrend()
    {
        $today = Carbon::today();
        $result = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $startOfDay = $date->copy()->startOfDay();
            $endOfDay = $date->copy()->endOfDay();

            $sales = Order::whereBetween('OrderDateTime', [$startOfDay, $endOfDay])
                ->select(
                    DB::raw('COUNT(*) as order_count'),
                    DB::raw('SUM(GrandTotal) as total_sales')
                )
                ->first();

            $result[] = [
                'date' => $date->toDateString(),
                'order_count' => $sales->order_count ?? 0,
                'total_sales' => $sales->total_sales ?? 0,
            ];
        }

        return $result;
    }
}
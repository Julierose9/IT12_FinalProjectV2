<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Employee;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Add this import
use Carbon\Carbon;

class DailySalesController extends Controller
{
    /**
     * Display daily sales report
     */
    public function index(Request $request)
{
    $user = Auth::user();
        
        // Get employee details from users->employees relationship
        $employee = null;
        $employeeName = 'Cashier';
        $employeeId = null;
        
        if ($user && $user->EmployeeID) {
            $employee = Employee::where('EmployeeID', $user->EmployeeID)->first();
            if ($employee) {
                $employeeName = $employee->EmployeeFName . ' ' . $employee->EmployeeLName;
                $employeeId = $employee->EmployeeID;
            }
        }
    
    // Get request parameters with defaults
    $selectedDate = Carbon::parse($request->get('date', Carbon::today()->toDateString()));
    $period = $request->get('period', 'daily');
    $category = $request->get('category', 'all');
    $paymentMethod = $request->get('method', 'all');
    $salesRange = $request->get('range', 'all');
    
    // Get all data
    $salesData = $this->getSalesData($selectedDate, $period, $category, $paymentMethod, $salesRange);
    $topProducts = $this->getTopProducts($selectedDate, $period, 5, $paymentMethod, $salesRange);
    $breakdown = $this->getPaymentBreakdown($selectedDate, $period, $paymentMethod, $salesRange);
    $salesTrend = $this->getSalesTrend($selectedDate, $period);
    $categories = Category::orderBy('CategoryName')->get();
    
    // Calculate summary statistics
    $totalSales = collect($breakdown)->sum('sales');
    $totalTransactions = collect($breakdown)->sum('orders');
    $averageTransaction = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;
    $topPaymentMethod = collect($breakdown)->sortByDesc('sales')->keys()->first() ?? 'Cash';
    
    return view('cashier.dailysales', compact(
        'salesData',
        'categories',
        'topProducts',
        'breakdown',
        'salesTrend',
        'selectedDate',
        'period',
        'category',
        'paymentMethod',
        'salesRange',
        'employee',
        'employeeName',
        'employeeId',
        'totalSales',
        'totalTransactions',
        'averageTransaction',
        'topPaymentMethod'
    ));
}
    
    /**
     * Get sales data based on selected period
     */
    private function getSalesData(Carbon $date, $period = 'daily', $category = 'all', $paymentMethod = 'all', $salesRange = 'all')
    {
        $data = [
            'total_sales' => 0,
            'total_orders' => 0,
            'total_items' => 0,
            'average_order_value' => 0,
            'total_discount' => 0,
            'total_tax' => 0,
            'sales_by_hour' => [],
            'category_breakdown' => [],
            'orders' => [],
        ];
        
        // Base query for orders
        $orderQuery = Order::query();
        
        // Apply date filter based on period
        if ($period === 'daily') {
            $orderQuery->whereDate('OrderDateTime', $date);
            $endDate = $date->copy();
        } elseif ($period === 'weekly') {
            $startDate = $date->copy()->startOfWeek();
            $endDate = $date->copy()->endOfWeek();
            $orderQuery->whereBetween('OrderDateTime', [$startDate, $endDate]);
        } elseif ($period === 'monthly') {
            $startDate = $date->copy()->startOfMonth();
            $endDate = $date->copy()->endOfMonth();
            $orderQuery->whereBetween('OrderDateTime', [$startDate, $endDate]);
        }
        
        // Apply payment method filter
        if ($paymentMethod !== 'all') {
            $orderQuery->whereHas('payment', function($q) use ($paymentMethod) {
                $methods = explode(',', $paymentMethod);
                $q->whereIn('PaymentType', $methods);
            });
        }
        
        // Apply sales range filter
        if ($salesRange !== 'all') {
            switch ($salesRange) {
                case 'high':
                    $orderQuery->where('GrandTotal', '>', 1000);
                    break;
                case 'medium':
                    $orderQuery->whereBetween('GrandTotal', [500, 1000]);
                    break;
                case 'low':
                    $orderQuery->where('GrandTotal', '<', 500);
                    break;
            }
        }
        
        // Get orders with details
        $orders = $orderQuery->with(['details.product.category'])
            ->orderBy('OrderDateTime', 'desc')
            ->get();
        
        // Calculate totals
        $data['total_orders'] = $orders->count();
        $data['total_sales'] = $orders->sum('GrandTotal');
        $data['total_discount'] = $orders->sum('DiscountAmount');
        
        // Calculate total items and category breakdown
        $categoryBreakdown = [];
        $totalItems = 0;
        
        foreach ($orders as $order) {
            foreach ($order->details as $detail) {
                $totalItems += $detail->OrderQty;
                
                $categoryName = $detail->product->category->CategoryName ?? 'Uncategorized';
                
                if (!isset($categoryBreakdown[$categoryName])) {
                    $categoryBreakdown[$categoryName] = [
                        'quantity' => 0,
                        'sales' => 0,
                    ];
                }
                
                $categoryBreakdown[$categoryName]['quantity'] += $detail->OrderQty;
                $categoryBreakdown[$categoryName]['sales'] += $detail->OrderQty * ($detail->product->pricing->RetailPrice ?? 0);
            }
        }
        
        $data['total_items'] = $totalItems;
        $data['category_breakdown'] = $categoryBreakdown;
        
        // Calculate average order value
        $data['average_order_value'] = $data['total_orders'] > 0 
            ? $data['total_sales'] / $data['total_orders'] 
            : 0;
        
        // Get sales by hour (for daily period only)
        if ($period === 'daily') {
            $data['sales_by_hour'] = $this->getSalesByHour($date);
        }
        
        // Filter by category if specified
        if ($category !== 'all') {
            $filteredOrders = $orders->filter(function($order) use ($category) {
                foreach ($order->details as $detail) {
                    if (($detail->product->category->CategoryName ?? '') === $category) {
                        return true;
                    }
                }
                return false;
            });
            
            $data['orders'] = $filteredOrders->values();
        } else {
            $data['orders'] = $orders;
        }
        
        // Get previous period data for comparison
        $previousPeriodData = $this->getPreviousPeriodData($date, $period);
        $data['previous_period'] = $previousPeriodData;
        
        // Calculate growth
        $data['sales_growth'] = $previousPeriodData['total_sales'] > 0 
            ? (($data['total_sales'] - $previousPeriodData['total_sales']) / $previousPeriodData['total_sales']) * 100 
            : ($data['total_sales'] > 0 ? 100 : 0);
        
        $data['orders_growth'] = $previousPeriodData['total_orders'] > 0 
            ? (($data['total_orders'] - $previousPeriodData['total_orders']) / $previousPeriodData['total_orders']) * 100 
            : ($data['total_orders'] > 0 ? 100 : 0);
        
        return $data;
    }
    
    /**
     * Get sales data grouped by hour for daily report
     */
    private function getSalesByHour(Carbon $date)
    {
        $salesByHour = [];
        
        for ($hour = 0; $hour < 24; $hour++) {
            $salesByHour[$hour] = [
                'hour' => $hour,
                'formatted_hour' => sprintf('%02d:00', $hour),
                'sales' => 0,
                'orders' => 0,
            ];
        }
        
        $orders = Order::whereDate('OrderDateTime', $date)
            ->select(
                DB::raw('HOUR(OrderDateTime) as hour'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(GrandTotal) as total_sales')
            )
            ->groupBy(DB::raw('HOUR(OrderDateTime)'))
            ->orderBy('hour')
            ->get();
        
        foreach ($orders as $order) {
            $hour = (int)$order->hour;
            if (isset($salesByHour[$hour])) {
                $salesByHour[$hour]['sales'] = (float)$order->total_sales;
                $salesByHour[$hour]['orders'] = (int)$order->order_count;
            }
        }
        
        return array_values($salesByHour);
    }
    
    /**
     * Get top selling products
     */
    private function getTopProducts(Carbon $date, $period = 'daily', $limit = 5, $paymentMethod = 'all', $salesRange = 'all')
    {
        $query = OrderDetail::join('orders', 'order_details.OrderID', '=', 'orders.OrderID')
            ->join('products', 'order_details.ProductID', '=', 'products.ProductID')
            ->leftJoin('payments', 'orders.OrderID', '=', 'payments.OrderID')
            ->select(
                'products.ProductID',
                'products.ProductName',
                'products.SKUNumber',
                DB::raw('SUM(order_details.OrderQty) as total_quantity'),
                DB::raw('COUNT(DISTINCT orders.OrderID) as order_count'),
                DB::raw('SUM(order_details.OrderQty * (SELECT RetailPrice FROM pricing WHERE ProductID = products.ProductID AND IsActive = "yes" ORDER BY EffectiveDate DESC LIMIT 1)) as total_sales')
            )
            ->groupBy('products.ProductID', 'products.ProductName', 'products.SKUNumber');
        
        // Apply date filter based on period
        if ($period === 'daily') {
            $query->whereDate('orders.OrderDateTime', $date);
        } elseif ($period === 'weekly') {
            $startDate = $date->copy()->startOfWeek();
            $endDate = $date->copy()->endOfWeek();
            $query->whereBetween('orders.OrderDateTime', [$startDate, $endDate]);
        } elseif ($period === 'monthly') {
            $startDate = $date->copy()->startOfMonth();
            $endDate = $date->copy()->endOfMonth();
            $query->whereBetween('orders.OrderDateTime', [$startDate, $endDate]);
        }
        
        // Apply payment method filter
        if ($paymentMethod !== 'all') {
            $methods = explode(',', $paymentMethod);
            $query->whereIn('payments.PaymentType', $methods);
        }
        
        // Apply sales range filter (this is tricky for individual products, so we'll skip for now)
        
        return $query->orderBy('total_quantity', 'desc')
            ->limit($limit)
            ->get();
    }
    
    /**
     * Get payment method breakdown
     */
    private function getPaymentBreakdown(Carbon $date, $period = 'daily', $paymentMethod = 'all', $salesRange = 'all')
    {
        $query = Order::select(
            'payments.PaymentType',
            DB::raw('COUNT(orders.OrderID) as order_count'),
            DB::raw('SUM(orders.GrandTotal) as total_sales')
        )
        ->join('payments', 'orders.OrderID', '=', 'payments.OrderID')
        ->groupBy('payments.PaymentType');
        
        // Apply date filter based on period
        if ($period === 'daily') {
            $query->whereDate('orders.OrderDateTime', $date);
        } elseif ($period === 'weekly') {
            $startDate = $date->copy()->startOfWeek();
            $endDate = $date->copy()->endOfWeek();
            $query->whereBetween('orders.OrderDateTime', [$startDate, $endDate]);
        } elseif ($period === 'monthly') {
            $startDate = $date->copy()->startOfMonth();
            $endDate = $date->copy()->endOfMonth();
            $query->whereBetween('orders.OrderDateTime', [$startDate, $endDate]);
        }
        
        // Apply payment method filter
        if ($paymentMethod !== 'all') {
            $methods = explode(',', $paymentMethod);
            $query->whereIn('payments.PaymentType', $methods);
        }
        
        // Apply sales range filter
        if ($salesRange !== 'all') {
            switch ($salesRange) {
                case 'high':
                    $query->having('total_sales', '>', 1000);
                    break;
                case 'medium':
                    $query->havingBetween('total_sales', [500, 1000]);
                    break;
                case 'low':
                    $query->having('total_sales', '<', 500);
                    break;
            }
        }
        
        $results = $query->get();
        
        $breakdown = [];
        foreach ($results as $result) {
            $breakdown[$result->PaymentType] = [
                'orders' => $result->order_count,
                'sales' => $result->total_sales,
                'percentage' => 0, // Will be calculated later
            ];
        }
        
        // Calculate percentages
        $totalSales = $results->sum('total_sales');
        if ($totalSales > 0) {
            foreach ($breakdown as $method => $data) {
                $breakdown[$method]['percentage'] = ($data['sales'] / $totalSales) * 100;
            }
        }
        
        return $breakdown;
    }
    
    /**
     * Get sales trend for charts
     */
    private function getSalesTrend(Carbon $date, $period = 'daily')
    {
        $trend = [];
        
        if ($period === 'daily') {
            // Last 7 days including today
            for ($i = 6; $i >= 0; $i--) {
                $currentDate = $date->copy()->subDays($i);
                $sales = Order::whereDate('OrderDateTime', $currentDate)->sum('GrandTotal');
                $orders = Order::whereDate('OrderDateTime', $currentDate)->count();
                
                $trend[] = [
                    'date' => $currentDate->toDateString(),
                    'label' => $currentDate->format('D, M j'),
                    'sales' => $sales,
                    'orders' => $orders,
                ];
            }
        } elseif ($period === 'weekly') {
            // Last 4 weeks
            for ($i = 3; $i >= 0; $i--) {
                $weekStart = $date->copy()->subWeeks($i)->startOfWeek();
                $weekEnd = $date->copy()->subWeeks($i)->endOfWeek();
                
                $sales = Order::whereBetween('OrderDateTime', [$weekStart, $weekEnd])->sum('GrandTotal');
                $orders = Order::whereBetween('OrderDateTime', [$weekStart, $weekEnd])->count();
                
                $trend[] = [
                    'date' => $weekStart->toDateString(),
                    'label' => 'Week ' . $weekStart->format('W, M j'),
                    'sales' => $sales,
                    'orders' => $orders,
                ];
            }
        } elseif ($period === 'monthly') {
            // Last 6 months
            for ($i = 5; $i >= 0; $i--) {
                $month = $date->copy()->subMonths($i);
                $monthStart = $month->copy()->startOfMonth();
                $monthEnd = $month->copy()->endOfMonth();
                
                $sales = Order::whereBetween('OrderDateTime', [$monthStart, $monthEnd])->sum('GrandTotal');
                $orders = Order::whereBetween('OrderDateTime', [$monthStart, $monthEnd])->count();
                
                $trend[] = [
                    'date' => $monthStart->toDateString(),
                    'label' => $month->format('M Y'),
                    'sales' => $sales,
                    'orders' => $orders,
                ];
            }
        }
        
        return $trend;
    }
    
    /**
     * Get previous period data for comparison
     */
    private function getPreviousPeriodData(Carbon $date, $period = 'daily')
    {
        $previousDate = $date->copy();
        
        if ($period === 'daily') {
            $previousDate->subDay();
        } elseif ($period === 'weekly') {
            $previousDate->subWeek();
        } elseif ($period === 'monthly') {
            $previousDate->subMonth();
        }
        
        $data = [
            'total_sales' => 0,
            'total_orders' => 0,
            'date' => $previousDate->toDateString(),
        ];
        
        if ($period === 'daily') {
            $data['total_sales'] = Order::whereDate('OrderDateTime', $previousDate)->sum('GrandTotal');
            $data['total_orders'] = Order::whereDate('OrderDateTime', $previousDate)->count();
        } elseif ($period === 'weekly') {
            $startDate = $previousDate->copy()->startOfWeek();
            $endDate = $previousDate->copy()->endOfWeek();
            $data['total_sales'] = Order::whereBetween('OrderDateTime', [$startDate, $endDate])->sum('GrandTotal');
            $data['total_orders'] = Order::whereBetween('OrderDateTime', [$startDate, $endDate])->count();
        } elseif ($period === 'monthly') {
            $startDate = $previousDate->copy()->startOfMonth();
            $endDate = $previousDate->copy()->endOfMonth();
            $data['total_sales'] = Order::whereBetween('OrderDateTime', [$startDate, $endDate])->sum('GrandTotal');
            $data['total_orders'] = Order::whereBetween('OrderDateTime', [$startDate, $endDate])->count();
        }
        
        return $data;
    }
    
    /**
     * Export daily sales report
     */
    public function export(Request $request)
    {
        $date = $request->get('date', Carbon::today()->toDateString());
        $period = $request->get('period', 'daily');
        $category = $request->get('category', 'all');
        
        $selectedDate = Carbon::parse($date);
        $salesData = $this->getSalesData($selectedDate, $period, $category);
        $topProducts = $this->getTopProducts($selectedDate, $period);
        $paymentBreakdown = $this->getPaymentBreakdown($selectedDate, $period);
        
        // Generate CSV or PDF export
        // This is a simplified version - you might want to use a library like Laravel Excel
        
        $filename = "sales_report_{$period}_{$date}.csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($salesData, $topProducts, $paymentBreakdown, $selectedDate, $period) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ["Daily Sales Report"]);
            fputcsv($file, ["Period: " . ucfirst($period), "Date: " . $selectedDate->format('F j, Y')]);
            fputcsv($file, []); // Empty row
            
            // Summary
            fputcsv($file, ["SUMMARY"]);
            fputcsv($file, ["Total Sales", "₱" . number_format($salesData['total_sales'], 2)]);
            fputcsv($file, ["Total Orders", $salesData['total_orders']]);
            fputcsv($file, ["Total Items Sold", $salesData['total_items']]);
            fputcsv($file, ["Average Order Value", "₱" . number_format($salesData['average_order_value'], 2)]);
            fputcsv($file, ["Total Discount", "₱" . number_format($salesData['total_discount'], 2)]);
            fputcsv($file, []); // Empty row
            
            // Top Products
            fputcsv($file, ["TOP SELLING PRODUCTS"]);
            fputcsv($file, ["Product", "SKU", "Quantity Sold", "Total Sales"]);
            foreach ($topProducts as $product) {
                fputcsv($file, [
                    $product->ProductName,
                    $product->SKUNumber,
                    $product->total_quantity,
                    "₱" . number_format($product->total_sales, 2)
                ]);
            }
            fputcsv($file, []); // Empty row
            
            // Payment Breakdown
            fputcsv($file, ["PAYMENT METHOD BREAKDOWN"]);
            fputcsv($file, ["Method", "Orders", "Sales", "Percentage"]);
            foreach ($paymentBreakdown as $method => $data) {
                fputcsv($file, [
                    $method,
                    $data['orders'],
                    "₱" . number_format($data['sales'], 2),
                    number_format($data['percentage'], 1) . '%'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Get sales data for API/JSON response
     */
    public function apiSalesData(Request $request)
    {
        $date = $request->get('date', Carbon::today()->toDateString());
        $period = $request->get('period', 'daily');
        $category = $request->get('category', 'all');
        
        $selectedDate = Carbon::parse($date);
        $salesData = $this->getSalesData($selectedDate, $period, $category);
        $topProducts = $this->getTopProducts($selectedDate, $period);
        $paymentBreakdown = $this->getPaymentBreakdown($selectedDate, $period);
        $salesTrend = $this->getSalesTrend($selectedDate, $period);
        
        return response()->json([
            'success' => true,
            'data' => [
                'summary' => [
                    'total_sales' => $salesData['total_sales'],
                    'total_orders' => $salesData['total_orders'],
                    'total_items' => $salesData['total_items'],
                    'average_order_value' => $salesData['average_order_value'],
                    'sales_growth' => $salesData['sales_growth'],
                    'orders_growth' => $salesData['orders_growth'],
                ],
                'top_products' => $topProducts,
                'payment_breakdown' => $paymentBreakdown,
                'sales_trend' => $salesTrend,
                'category_breakdown' => $salesData['category_breakdown'],
                'sales_by_hour' => $salesData['sales_by_hour'],
                'selected_date' => $selectedDate->toDateString(),
                'period' => $period,
            ]
        ]);
    }

    /**
     * Export daily sales as PDF
     */
    public function exportPDF(Request $request)
    {
        $selectedDate = Carbon::parse($request->get('date', Carbon::today()->toDateString()));
        $paymentMethod = $request->get('method', 'all');
        $salesRange = $request->get('range', 'all');
        $period = $request->get('period', 'daily');

        $breakdown = $this->getPaymentBreakdown($selectedDate, $period, $paymentMethod, $salesRange);
        
        $totalSales = 0;
        $totalTransactions = 0;
        
        foreach ($breakdown as $method => $data) {
            $totalSales += $data['sales'];
            $totalTransactions += $data['orders'];
        }

        $pdf = \PDF::loadView('cashier.dailysales_pdf', [
            'breakdown' => $breakdown,
            'totalSales' => $totalSales,
            'totalTransactions' => $totalTransactions,
            'selectedDate' => $selectedDate,
        ])->setPaper('a4', 'portrait');

        return $pdf->download('daily-sales-' . $selectedDate->format('Y-m-d') . '.pdf');
    }
}
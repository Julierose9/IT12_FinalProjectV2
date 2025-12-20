<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Schema;
use Mpdf\Mpdf; // Correct MPDF class
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;



class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['employee', 'items.product', 'payment']);
        
        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('OrderID', 'like', '%' . $search . '%')
                  ->orWhere('PaymentMethod', 'like', '%' . $search . '%')
                  ->orWhereHas('employee', function($q2) use ($search) {
                      $q2->where('EmployeeFName', 'like', '%' . $search . '%')
                         ->orWhere('EmployeeLName', 'like', '%' . $search . '%');
                  });
            });
        }
        
        // Apply custom date range filter
        if ($request->has('start_date') && $request->has('end_date') && $request->start_date && $request->end_date) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('OrderDateTime', [$startDate, $endDate]);
        }
        
        // Apply time period filter
        if ($request->has('time_period') && $request->time_period && $request->time_period !== 'all') {
            $now = Carbon::now();
            switch ($request->time_period) {
                case 'today':
                    $query->whereDate('OrderDateTime', $now->toDateString());
                    break;
                    
                case 'week':
                    $startOfWeek = $now->copy()->startOfWeek();
                    $endOfWeek = $now->copy()->endOfWeek();
                    $query->whereBetween('OrderDateTime', [$startOfWeek, $endOfWeek]);
                    break;
                    
                case 'month':
                    $startOfMonth = $now->copy()->startOfMonth();
                    $endOfMonth = $now->copy()->endOfMonth();
                    $query->whereBetween('OrderDateTime', [$startOfMonth, $endOfMonth]);
                    break;
                    
                // 'custom' is handled by date range above
            }
        }
        
        // Apply order status filters (Completed/Cancelled)
        if ($request->has('status') && is_array($request->status) && count($request->status) > 0) {
            // Map 'completed' to 'Completed' and 'cancelled' to 'Cancelled'
            $statuses = array_map(function($status) {
                return ucfirst($status);
            }, $request->status);
            
            $query->whereIn('OrderStatus', $statuses);
        }
        
        // Apply payment method filters
        if ($request->has('payment_method') && is_array($request->payment_method) && count($request->payment_method) > 0) {
            $query->whereIn('PaymentMethod', $request->payment_method);
        }
        
        // Order by latest first
        $query->orderBy('OrderDateTime', 'desc');
        
        // Clone query for summary calculations
        $summaryQuery = clone $query;
        
    
        $sampleOrder = Order::first();
        if ($sampleOrder) {
           
        }
        
        // Calculate total amount - check which column has the total
        // Common column names: TotalAmount, Total, OrderTotal, Amount
        $totalAmount = 0;
        $totalOrders = $summaryQuery->count();
        
        // Try to get the sum using possible column names
        try {
            // Try different possible column names
            if (Schema::hasColumn('orders', 'GrandTotal')) {
                $totalAmount = $summaryQuery->sum('GrandTotal');
            } elseif (Schema::hasColumn('orders', 'TotalAmount')) {
                $totalAmount = $summaryQuery->sum('TotalAmount');
            } elseif (Schema::hasColumn('orders', 'Total')) {
                $totalAmount = $summaryQuery->sum('Total');
            } elseif (Schema::hasColumn('orders', 'OrderTotal')) {
                $totalAmount = $summaryQuery->sum('OrderTotal');
            } elseif (Schema::hasColumn('orders', 'Amount')) {
                $totalAmount = $summaryQuery->sum('Amount');
            } else {
                // If no total column exists, calculate from order items
                $ordersForSum = $summaryQuery->get();
                foreach ($ordersForSum as $order) {
                    $totalAmount += $order->items->sum(function($item) {
                        return $item->Quantity * $item->Price;
                    });
                }
            }
        } catch (\Exception $e) {
            // If there's an error, fall back to calculating from items
            $ordersForSum = $summaryQuery->get();
            foreach ($ordersForSum as $order) {
                $totalAmount += $order->items->sum(function($item) {
                    return $item->Quantity * $item->Price;
                });
            }
        }
        
        // Paginate results
        $orders = $query->paginate(20);
        
        return view('admin.transaction', compact('orders', 'totalAmount', 'totalOrders'));
    }
    
    public function show($id)
    {
        $order = Order::with(['employee', 'items.product', 'payment'])->findOrFail($id);
        
        if (request()->ajax()) {
            // Return partial view for modal
            return view('admin.transactions.partials.details', compact('order'));
        }
        
        return view('admin.transactions.show', compact('order'));
    }
    
    public function receipt($id)
    {
        $order = Order::with(['employee', 'items.product'])->findOrFail($id);
        return view('admin.transactions.receipt', compact('order'));
    }
    
    public function export(Request $request)
    {
        $query = Order::with(['employee', 'items.product', 'payment']);
        
        // Apply the same filters as index
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('OrderID', 'like', '%' . $search . '%')
                  ->orWhere('PaymentMethod', 'like', '%' . $search . '%')
                  ->orWhereHas('employee', function($q2) use ($search) {
                      $q2->where('EmployeeFName', 'like', '%' . $search . '%')
                         ->orWhere('EmployeeLName', 'like', '%' . $search . '%');
                  });
            });
        }
        
        if ($request->has('start_date') && $request->has('end_date') && $request->start_date && $request->end_date) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('OrderDateTime', [$startDate, $endDate]);
        }
        
        if ($request->has('time_period') && $request->time_period) {
            $now = Carbon::now();
            switch ($request->time_period) {
                case 'today':
                    $query->whereDate('OrderDateTime', $now->toDateString());
                    break;
                case 'week':
                    $startOfWeek = $now->copy()->startOfWeek();
                    $endOfWeek = $now->copy()->endOfWeek();
                    $query->whereBetween('OrderDateTime', [$startOfWeek, $endOfWeek]);
                    break;
                case 'month':
                    $startOfMonth = $now->copy()->startOfMonth();
                    $endOfMonth = $now->copy()->endOfMonth();
                    $query->whereBetween('OrderDateTime', [$startOfMonth, $endOfMonth]);
                    break;
            }
        }
        
        if ($request->has('status') && is_array($request->status) && count($request->status) > 0) {
            $statuses = array_map(function($status) {
                return ucfirst($status);
            }, $request->status);
            
            $query->whereIn('OrderStatus', $statuses);
        }
        
        if ($request->has('payment_method') && is_array($request->payment_method) && count($request->payment_method) > 0) {
            $query->whereIn('PaymentMethod', $request->payment_method);
        }
        
        $query->orderBy('OrderDateTime', 'desc');
        
        // Clone query for summary calculations
        $summaryQuery = clone $query;
        
        // Calculate total amount using the same logic as index()
        $totalAmount = 0;
        $totalOrders = $summaryQuery->count();
        
        try {
            // Try different possible column names
            if (Schema::hasColumn('orders', 'GrandTotal')) {
                $totalAmount = $summaryQuery->sum('GrandTotal');
            } elseif (Schema::hasColumn('orders', 'TotalAmount')) {
                $totalAmount = $summaryQuery->sum('TotalAmount');
            } elseif (Schema::hasColumn('orders', 'Total')) {
                $totalAmount = $summaryQuery->sum('Total');
            } elseif (Schema::hasColumn('orders', 'OrderTotal')) {
                $totalAmount = $summaryQuery->sum('OrderTotal');
            } elseif (Schema::hasColumn('orders', 'Amount')) {
                $totalAmount = $summaryQuery->sum('Amount');
            } else {
                // If no total column exists, calculate from order items
                $ordersForSum = $summaryQuery->get();
                foreach ($ordersForSum as $order) {
                    $totalAmount += $order->items->sum(function($item) {
                        return $item->Quantity * $item->Price;
                    });
                }
            }
        } catch (\Exception $e) {
            // If there's an error, fall back to calculating from items
            $ordersForSum = $summaryQuery->get();
            foreach ($ordersForSum as $order) {
                $totalAmount += $order->items->sum(function($item) {
                    return $item->Quantity * $item->Price;
                });
            }
        }
        
        $orders = $query->get();
        
        return $this->exportToPDF($orders, $totalAmount, $totalOrders);
    }

private function exportToPDF($orders, $totalAmount, $totalOrders, $dateFrom = null, $dateTo = null)
{
    $html = view('admin.transaction_pdf', [
        'orders' => $orders,
        'totalAmount' => $totalAmount,
        'totalOrders' => $totalOrders,
        'dateFrom' => $dateFrom,
        'dateTo' => $dateTo
    ])->render();
    
    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4-L', // Landscape
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 15,
        'margin_bottom' => 15,
        'margin_header' => 10,
        'margin_footer' => 10
    ]);
    
    $mpdf->WriteHTML($html);
    
    $filename = 'transaction_report_' . ($dateFrom ?? 'all') . '_to_' . ($dateTo ?? 'all') . '_' . now()->format('Y-m-d_H-i-s') . '.pdf';
    
    return response($mpdf->Output($filename, 'D'), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"'
    ]);
}
}
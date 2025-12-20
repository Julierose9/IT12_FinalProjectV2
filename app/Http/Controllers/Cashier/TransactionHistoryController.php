<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class TransactionHistoryController extends Controller
{
    public function index(Request $request)
    {
        // Base query with relationships so the blade can show cashier, items, and payment
        $query = Order::with(['employee', 'payment', 'items'])
            ->withCount('items as items_count');
        
        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $query->where('OrderID', 'like', '%' . $request->search . '%');
        }
        
        // Apply date filter
        if ($request->has('date')) {
            $date = Carbon::parse($request->date);
            $query->whereDate('OrderDateTime', $date);
        }
        
        // Apply time period filter
        if ($request->has('period')) {
            $now = Carbon::now();
            switch ($request->period) {
                case 'today':
                    $query->whereDate('OrderDateTime', $now);
                    break;
                case 'week':
                    $query->whereBetween('OrderDateTime', [$now->startOfWeek(), $now->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('OrderDateTime', $now->month)
                          ->whereYear('OrderDateTime', $now->year);
                    break;
                // 'all' shows all records
            }
        }
        
        // Apply order status filters
        if ($request->has('order_status') && is_array($request->order_status) && count($request->order_status) > 0) {
            $query->whereIn('OrderStatus', $request->order_status);
        }
        
        // Apply payment method filters
        if ($request->has('payment_method') && is_array($request->payment_method) && count($request->payment_method) > 0) {
            $query->whereIn('PaymentMethod', $request->payment_method);
        }
        
        // Apply payment status filters
        if ($request->has('payment_status') && is_array($request->payment_status) && count($request->payment_status) > 0) {
            $query->whereIn('PaymentStatus', $request->payment_status);
        }
        
        // Order by latest first
        $query->orderBy('OrderDateTime', 'desc');
        
        // Paginate results (simple pagination)
        $orders = $query->paginate(20);
        
        return view('cashier.transactionhistory', compact('orders'));
    }
    public function receipt($id)
{
    $order = Order::with(['employee', 'details.product', 'payment'])
        ->findOrFail($id);
    
    return view('cashier.receipt', compact('order'));
}
}
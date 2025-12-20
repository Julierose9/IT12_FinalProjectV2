<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\InventoryMovement;
use App\Models\StockIn;
use App\Models\PullOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Get current employee
        $employee = auth()->user()->employee ?? null;
        $employeeId = $employee->EmployeeID ?? null;
        // Use correct column names from Employee model
        $employeeName = $employee 
            ? trim(($employee->EmployeeFName ?? '') . ' ' . ($employee->EmployeeLName ?? ''))
            : 'Cashier';

        // Get products with available stock
        $products = Product::with(['category', 'pricing'])
            ->where('ProductStatus', 'Available')
            ->get()
            ->map(function ($product) {
                // Calculate available stock
                $stockInTotal = StockIn::where('ProductID', $product->ProductID)
                    ->where('ProdStatus', 'Received')
                    ->sum('Qty');
                
                $pulledOutQty = PullOut::where('ProductID', $product->ProductID)
                    ->sum('PullOutQty');
                
                // Calculate sales from completed orders
                $salesDeduction = OrderDetail::where('ProductID', $product->ProductID)
                    ->whereHas('order', function($query) {
                        $query->where('OrderStatus', 'Completed');
                    })
                    ->sum('OrderQty');
                
                $product->available_stock = max(0, $stockInTotal - $pulledOutQty - $salesDeduction);
                return $product;
            })
            ->filter(function ($product) {
                return $product->available_stock > 0;
            });

        // Get orders
        $orders = Order::with(['details.product', 'employee', 'payment'])
            ->orderBy('OrderDateTime', 'desc')
            ->paginate(15);

        // Get payments
        $payments = Payment::with(['order.employee'])
            ->whereHas('order')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('cashier.sales', compact('products', 'orders', 'payments', 'employeeId', 'employeeName'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ProductID' => 'required|exists:products,ProductID',
            'Quantity' => 'required|integer|min:1',
            'EmployeeID' => 'required|exists:employees,EmployeeID',
            'PaymentType' => 'required|in:Cash,GCash',
            'PaymentReference' => 'nullable|string|max:255',
            'AmountPaid' => 'nullable|numeric|min:0',
            'DiscountType' => 'nullable|in:None,Senior,PWD',
            'DiscountAmount' => 'nullable|numeric|min:0',
        ], [
            'PaymentReference.required_if' => 'GCash reference number is required when payment type is GCash',
        ]);
    
        // Add conditional validation for GCash
        if ($request->PaymentType === 'GCash') {
            $request->validate([
                'PaymentReference' => 'required|string|max:255',
            ]);
        }
    
        try {
            DB::beginTransaction();
    
            // Get product with pricing
            $product = Product::with('pricing')->findOrFail($request->ProductID);
            $unitPrice = $product->pricing->RetailPrice ?? 0;
    
            // Calculate available stock
            $stockInTotal = StockIn::where('ProductID', $product->ProductID)
                ->where('ProdStatus', 'Received')
                ->sum('Qty');
            
            $pulledOutQty = PullOut::where('ProductID', $product->ProductID)
                ->sum('PullOutQty');
            
            // Calculate sales from completed orders
            $salesDeduction = OrderDetail::where('ProductID', $product->ProductID)
                ->whereHas('order', function($query) {
                    $query->where('OrderStatus', 'Completed');
                })
                ->sum('OrderQty');
            
            $availableStock = max(0, $stockInTotal - $pulledOutQty - $salesDeduction);
    
            // Validate stock availability
            if ($request->Quantity > $availableStock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Available: ' . $availableStock
                ], 400);
            }
    
            // Calculate order totals
            $subTotal = $unitPrice * $request->Quantity;
            $discountAmount = $request->DiscountAmount ?? 0;
            $grandTotal = $subTotal - $discountAmount;
    
            // Generate OrderID
            $lastOrder = Order::orderBy('OrderID', 'desc')->first();
            $lastId = $lastOrder ? intval(substr($lastOrder->OrderID, 3)) : 0;
            $orderId = 'ORD' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
    
            // Calculate payment info
            $amountPaid = $request->AmountPaid ?? $grandTotal;
            $balance = max(0, $grandTotal - $amountPaid);
    
            // Create Order - Check what columns actually exist in your orders table
            $orderData = [
                'OrderID'          => $orderId,
                'EmployeeID'       => $request->EmployeeID,
                'OrderDateTime'    => now(),
                'OrderStatus'      => 'Completed',
                'SubTotal'         => $subTotal,
                'DiscountType'     => $request->DiscountType ?? 'None',
                'DiscountAmount'   => $discountAmount,
                'GrandTotal'       => $grandTotal,
            ];
            
            // Add optional fields if they exist in your schema
            if (\Schema::hasColumn('orders', 'DiscountRate')) {
                $orderData['DiscountRate'] = $request->DiscountType == 'None' ? 0 : 20;
            }
            
            $order = Order::create($orderData);
    
            // Generate OrderDetailID
            $lastDetail = OrderDetail::orderBy('OrderDetailsID', 'desc')->first();
            $lastDetailId = $lastDetail ? intval(substr($lastDetail->OrderDetailsID, 2)) : 0;
            $detailId = 'OD' . str_pad($lastDetailId + 1, 4, '0', STR_PAD_LEFT);
    
            // Create OrderDetail
            OrderDetail::create([
                'OrderDetailsID' => $detailId,
                'OrderID' => $orderId,
                'ProductID' => $request->ProductID,
                'OrderQty' => $request->Quantity,
            ]);
    
            // Generate PaymentID
            $lastPayment = Payment::orderBy('PaymentID', 'desc')->first();
            $lastPayId = $lastPayment ? intval(substr($lastPayment->PaymentID, 3)) : 0;
            $paymentId = 'PAY' . str_pad($lastPayId + 1, 4, '0', STR_PAD_LEFT);
    
            // Create Payment record - ONLY include fields that exist in your payments table
            $paymentData = [
                'PaymentID'       => $paymentId,
                'OrderID'         => $orderId,
                'PaymentType'     => $request->PaymentType,
                'ReferenceNumber' => $request->PaymentReference,
            ];
            
            // Add additional fields if they exist in your payments table schema
            if (\Schema::hasColumn('payments', 'AmountPaid')) {
                $paymentData['AmountPaid'] = $amountPaid;
            }
            
            if (\Schema::hasColumn('payments', 'Balance')) {
                $paymentData['Balance'] = $balance;
            }
            
            if (\Schema::hasColumn('payments', 'PaymentStatus')) {
                $paymentData['PaymentStatus'] = $balance <= 0 ? 'Paid' : 'Unpaid';
            }
            
            if (\Schema::hasColumn('payments', 'PaymentDate')) {
                $paymentData['PaymentDate'] = now();
            }
            
            Payment::create($paymentData);
    
            // Generate InventoryMovementID
            $lastMovement = InventoryMovement::orderBy('InventoryID', 'desc')->first();
            $lastMovId = $lastMovement ? intval(substr($lastMovement->InventoryID, 3)) : 0;
            $movementId = 'INV' . str_pad($lastMovId + 1, 4, '0', STR_PAD_LEFT);
    
            // Create InventoryMovement record for stock deduction (sale)
            InventoryMovement::create([
                'InventoryID'    => $movementId,
                'ProductID'      => $request->ProductID,
                'QtyChange'      => $request->Quantity,
                'ChangeType'     => 'Decrease',
                'ChangeDateTime' => now(),
            ]);
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Order created successfully!',
                'orderId' => $orderId,
                'grandTotal' => number_format($grandTotal, 2),
            ]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error creating order: ' . $e->getMessage()
            ], 500);
        }
    }
    public function show($id)
    {
        $order = Order::with(['details.product.pricing', 'employee', 'payment'])
            ->findOrFail($id);
        
        // Build detail payload with computed pricing
        $details = $order->details->map(function ($detail) {
            $price = $detail->product->pricing->RetailPrice ?? 0;
            return [
                'ProductName' => $detail->product->ProductName ?? 'N/A',
                'UnitPrice' => $price,
                'Quantity' => $detail->OrderQty,
                'Subtotal' => $price * $detail->OrderQty,
            ];
        });
        
        $employee = $order->employee;
        $employeeName = $employee
            ? trim(($employee->EmployeeFName ?? '') . ' ' . ($employee->EmployeeLName ?? ''))
            : null;

        return response()->json([
            'success' => true,
            'order' => [
                'OrderID'        => $order->OrderID,
                'OrderDateTime'  => $order->OrderDateTime,
                'OrderStatus'    => $order->OrderStatus,
                'SubTotal'       => $order->SubTotal,
                'DiscountAmount' => $order->DiscountAmount,
                'GrandTotal'     => $order->GrandTotal,
                'PaymentType'    => $order->payment->PaymentType ?? 'Cash',
                'Employee'       => [
                    'EmployeeName' => $employeeName,
                    'EmployeeID'   => $employee->EmployeeID ?? null,
                ],
            ],
            'details' => $details,
        ]);
    }

    public function getProductDetails($id)
    {
        $product = Product::with(['pricing', 'category'])->findOrFail($id);
        
        // Calculate available stock
        $stockInTotal = StockIn::where('ProductID', $product->ProductID)
            ->where('ProdStatus', 'Received')
            ->sum('Qty');
        
            $pulledOutQty = PullOut::where('ProductID', $product->ProductID)
                ->sum('PullOutQty');
            
            // Calculate sales from completed orders
            $salesDeduction = OrderDetail::where('ProductID', $product->ProductID)
                ->whereHas('order', function($query) {
                    $query->where('OrderStatus', 'Completed');
                })
                ->sum('OrderQty');
            
            $availableStock = max(0, $stockInTotal - $pulledOutQty - $salesDeduction);

        return response()->json([
            'success' => true,
            'product' => [
                'ProductID' => $product->ProductID,
                'ProductName' => $product->ProductName,
                'SKUNumber' => $product->SKUNumber,
                'Price' => $product->pricing->RetailPrice ?? 0,
                'AvailableStock' => $availableStock,
            ],
        ]);
    }
}

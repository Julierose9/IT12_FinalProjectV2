<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Employee;
use App\Models\Product;
use App\Models\StockIn;
use App\Models\PullOut;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index()
    {
        // Get current employee
        $employee = Auth::user()->employee ?? null;
        $employeeId = $employee->EmployeeID ?? null;
        $employeeName = $employee 
            ? trim(($employee->EmployeeFName ?? '') . ' ' . ($employee->EmployeeLName ?? ''))
            : 'Cashier';

        // Get payments with order and employee information
        $payments = Payment::with([
            'order.employee',
            'order.details.product'
        ])
        ->orderBy('PaymentDate', 'desc')
        ->paginate(10);
        
        return view('cashier.payments', compact('payments', 'employeeId', 'employeeName'));
    }

    /**
     * Store a newly created payment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'OrderID' => 'required|exists:orders,OrderID',
            'PaymentType' => 'required|in:Cash,GCash',
            'ReferenceNumber' => 'nullable|string|max:255',
            'AmountPaid' => 'required|numeric|min:0',
            'PaymentStatus' => 'nullable|in:Pending,Paid,Refunded',
        ]);

        try {
            DB::beginTransaction();

            // Get the order
            $order = Order::findOrFail($request->OrderID);
            
            // Calculate balance
            $amountPaid = $request->AmountPaid;
            $balance = max(0, $order->GrandTotal - $amountPaid);
            
            // Determine payment status
            $paymentStatus = $request->PaymentStatus;
            if (!$paymentStatus) {
                $paymentStatus = $balance <= 0 ? 'Paid' : 'Partial';
            }

            // Generate PaymentID
            $lastPayment = Payment::orderBy('PaymentID', 'desc')->first();
            $lastPayId = $lastPayment ? intval(substr($lastPayment->PaymentID, 3)) : 0;
            $paymentId = 'PAY' . str_pad($lastPayId + 1, 4, '0', STR_PAD_LEFT);

            // Create payment
            $payment = Payment::create([
                'PaymentID' => $paymentId,
                'OrderID' => $order->OrderID,
                'PaymentType' => $request->PaymentType,
                'ReferenceNumber' => $request->ReferenceNumber,
                'AmountPaid' => $amountPaid,
                'Balance' => $balance,
                'PaymentStatus' => $paymentStatus,
                'PaymentDate' => now(),
            ]);

            // Update order payment status
            $order->PaymentStatus = $paymentStatus;
            $order->AmountPaid = ($order->AmountPaid ?? 0) + $amountPaid;
            $order->Balance = $balance;
            $order->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment recorded successfully!',
                'paymentId' => $paymentId,
                'amountPaid' => number_format($amountPaid, 2),
                'balance' => number_format($balance, 2),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error recording payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified payment.
     */
    public function show($id)
    {
        // Use find instead of findOrFail so we can always return JSON (not HTML error pages)
        $payment = Payment::with([
            'order.employee',
            'order.details.product.pricing',
        ])->find($id);

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment not found.',
            ], 404);
        }

        $order = $payment->order;

        // Build order items with pricing information
        $items = [];
        $computedSubtotal = 0;

        if ($order) {
            foreach ($order->details as $detail) {
                $product = $detail->product;
                $pricing = $product ? $product->pricing : null;

                // Guard against missing pricing relation
                $price = $pricing ? $pricing->RetailPrice : 0;
                $qty = $detail->OrderQty ?? 0;
                $lineTotal = $price * $qty;
                $computedSubtotal += $lineTotal;

                $items[] = [
                    'product'  => [
                        'ProductName' => $product->ProductName ?? 'N/A',
                    ],
                    'UnitPrice' => $price,
                    'Quantity'  => $qty,
                    'Subtotal'  => $lineTotal,
                ];
            }
        }

        $subTotal   = $order->SubTotal ?? $computedSubtotal;
        $discount   = $order->DiscountAmount ?? 0;
        $grandTotal = $order->GrandTotal ?? ($subTotal - $discount);

        return response()->json([
            'success' => true,
            'payment' => [
                'PaymentID'       => $payment->PaymentID,
                'OrderID'         => $payment->OrderID,
                'PaymentType'     => $payment->PaymentType ?: 'Cash',
                'ReferenceNumber' => $payment->ReferenceNumber,
                'PaymentDate'     => $payment->PaymentDate,
                'PaymentStatus'   => $payment->PaymentStatus,
                'AmountPaid'      => $payment->AmountPaid,
                'Balance'         => $payment->Balance,
                'order'           => [
                    'OrderID'        => $order->OrderID ?? null,
                    'SubTotal'       => $subTotal,
                    'DiscountAmount' => $discount,
                    'GrandTotal'     => $grandTotal,
                    'details'        => $items,
                ],
            ],
        ]);
    }

    /**
     * Update the specified payment.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'PaymentType' => 'sometimes|required|in:Cash,GCash',
            'ReferenceNumber' => 'nullable|string|max:255',
            'AmountPaid' => 'sometimes|required|numeric|min:0',
            'PaymentStatus' => 'sometimes|required|in:Pending,Paid,Refunded,Partial',
        ]);

        try {
            DB::beginTransaction();

            $payment = Payment::findOrFail($id);
            $order = $payment->order;

            // Update payment fields
            if ($request->has('PaymentType')) {
                $payment->PaymentType = $request->PaymentType;
            }
            
            if ($request->has('ReferenceNumber')) {
                $payment->ReferenceNumber = $request->ReferenceNumber;
            }
            
            if ($request->has('AmountPaid')) {
                $amountPaid = $request->AmountPaid;
                $balance = max(0, $order->GrandTotal - $amountPaid);
                
                $payment->AmountPaid = $amountPaid;
                $payment->Balance = $balance;
                $payment->PaymentStatus = $balance <= 0 ? 'Paid' : 'Partial';
                
                // Update order payment status
                $order->AmountPaid = $amountPaid;
                $order->Balance = $balance;
                $order->PaymentStatus = $balance <= 0 ? 'Paid' : 'Partial';
                $order->save();
            }
            
            if ($request->has('PaymentStatus')) {
                $payment->PaymentStatus = $request->PaymentStatus;
                
                // Update order payment status
                $order->PaymentStatus = $request->PaymentStatus;
                $order->save();
            }
            
            $payment->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment updated successfully!',
                'paymentId' => $payment->PaymentID,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error updating payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified payment.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $payment = Payment::findOrFail($id);
            $order = $payment->order;
            
            // Reset order payment status
            $order->AmountPaid = max(0, ($order->AmountPaid ?? 0) - $payment->AmountPaid);
            $order->Balance = $order->GrandTotal - $order->AmountPaid;
            $order->PaymentStatus = $order->Balance > 0 ? 'Unpaid' : 'Paid';
            $order->save();
            
            // Delete payment
            $payment->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment deleted successfully!',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error deleting payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get payments for a specific order.
     */
    public function getOrderPayments($orderId)
    {
        $payments = Payment::where('OrderID', $orderId)
            ->orderBy('PaymentDate', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'payments' => $payments,
            'totalPaid' => number_format($payments->sum('AmountPaid'), 2),
        ]);
    }

    /**
     * Print payment receipt.
     */
    public function printReceipt($id)
    {
        $payment = Payment::with([
            'order.employee',
            'order.details.product.pricing',
        ])->findOrFail($id);

        $order = $payment->order;
        
        // Calculate totals
        $items = [];
        $subTotal = 0;
        
        foreach ($order->details as $detail) {
            $product = $detail->product;
            $pricing = $product ? $product->pricing : null;
            $price = $pricing ? $pricing->RetailPrice : 0;
            $qty = $detail->OrderQty ?? 0;
            $lineTotal = $price * $qty;
            $subTotal += $lineTotal;
            
            $items[] = [
                'name' => $product->ProductName ?? 'N/A',
                'price' => $price,
                'quantity' => $qty,
                'total' => $lineTotal,
            ];
        }
        
        $discount = $order->DiscountAmount ?? 0;
        $grandTotal = $subTotal - $discount;
        
        // Prepare receipt data
        $receiptData = [
            'receiptNumber' => $payment->PaymentID,
            'orderNumber' => $order->OrderID,
            'date' => $payment->PaymentDate ?? now(),
            'cashier' => $order->employee 
                ? trim(($order->employee->EmployeeFName ?? '') . ' ' . ($order->employee->EmployeeLName ?? ''))
                : 'Cashier',
            'items' => $items,
            'subtotal' => $subTotal,
            'discount' => $discount,
            'grandTotal' => $grandTotal,
            'paymentType' => $payment->PaymentType,
            'amountPaid' => $payment->AmountPaid,
            'change' => max(0, $payment->AmountPaid - $grandTotal),
            'reference' => $payment->ReferenceNumber,
        ];
        
        // Return receipt view (you'll need to create this view)
        return view('cashier.receipt', $receiptData);
    }

    /**
     * Process refund for a payment.
     */
    public function refund(Request $request, $id)
    {
        $request->validate([
            'refundAmount' => 'required|numeric|min:0',
            'refundReason' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $payment = Payment::findOrFail($id);
            
            // Validate refund amount
            if ($request->refundAmount > $payment->AmountPaid) {
                return response()->json([
                    'success' => false,
                    'message' => 'Refund amount cannot exceed amount paid.',
                ], 400);
            }
            
            // Create refund payment record
            $lastPayment = Payment::orderBy('PaymentID', 'desc')->first();
            $lastPayId = $lastPayment ? intval(substr($lastPayment->PaymentID, 3)) : 0;
            $refundId = 'REF' . str_pad($lastPayId + 1, 4, '0', STR_PAD_LEFT);
            
            $refundPayment = Payment::create([
                'PaymentID' => $refundId,
                'OrderID' => $payment->OrderID,
                'PaymentType' => 'Refund',
                'ReferenceNumber' => 'REFUND-' . $refundId,
                'AmountPaid' => -$request->refundAmount, // Negative amount for refund
                'Balance' => $payment->Balance + $request->refundAmount,
                'PaymentStatus' => 'Refunded',
                'PaymentDate' => now(),
                'notes' => 'Refund: ' . $request->refundReason,
            ]);
            
            // Update original payment
            $payment->PaymentStatus = 'Partially Refunded';
            if ($request->refundAmount == $payment->AmountPaid) {
                $payment->PaymentStatus = 'Fully Refunded';
            }
            $payment->save();
            
            // Update order
            $order = $payment->order;
            $order->AmountPaid = max(0, $order->AmountPaid - $request->refundAmount);
            $order->Balance = $order->GrandTotal - $order->AmountPaid;
            $order->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Refund processed successfully!',
                'refundId' => $refundId,
                'refundAmount' => number_format($request->refundAmount, 2),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error processing refund: ' . $e->getMessage()
            ], 500);
        }
    }
}
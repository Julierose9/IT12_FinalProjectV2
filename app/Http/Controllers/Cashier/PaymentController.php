<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Employee;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        // Get payments with order and employee information
        $payments = Payment::with([
            'order.employee'
        ])
        ->orderBy('PaymentDate', 'desc')
        ->paginate(10);
        
        return view('cashier.payments', compact('payments'));
    }
    
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
                'Amount'          => $payment->Amount,
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
}
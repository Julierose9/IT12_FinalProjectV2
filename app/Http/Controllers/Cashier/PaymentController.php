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
            'order.employee' => function($query) {
                $query->select('id', 'EmployeeID', 'EmployeeFName', 'EmployeeLName');
            }
        ])
        ->orderBy('PaymentDate', 'desc')
        ->paginate(10);
        
        return view('cashier.payments', compact('payments'));
    }
    
    public function show($id)
    {
        $payment = Payment::with([
            'order.employee' => function($query) {
                $query->select('id', 'EmployeeID', 'EmployeeFName', 'EmployeeLName');
            },
            'order.details.product' => function($query) {
                $query->select('ProductID', 'ProductName', 'SKUNumber');
            }
        ])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'payment' => $payment,
        ]);
    }
}
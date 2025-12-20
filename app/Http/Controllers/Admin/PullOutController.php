<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PullOut;
use App\Models\StockIn;
use App\Models\Product;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PullOutController extends Controller
{
    public function index()
    {
        // Get current logged in employee
        $currentEmployee = null;
        $user = Auth::user();
        
        if ($user) {
            // Try to get employee from user relationship
            if (method_exists($user, 'employee') && $user->employee) {
                $currentEmployee = $user->employee;
            } 
            // If user has employee fields directly
            elseif (isset($user->EmployeeID)) {
                $currentEmployee = Employee::find($user->EmployeeID);
            }
        }
        
        // Get all pullouts with relationships
        $pullOuts = PullOut::with(['product.supplier', 'employee'])
            ->orderBy('DatePullOut', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get products with available stock
        $products = Product::with(['supplier', 'category', 'pricing' => function($query) {
            $query->where('IsActive', 'yes')->latest('EffectiveDate')->first();
        }])
        ->where('ProductStatus', 'Available')
        ->get()
        ->map(function ($product) {
            // Calculate total stock in quantity for this product
            $totalStockIn = StockIn::where('ProductID', $product->ProductID)
                ->where('ProdStatus', 'Received')
                ->sum('Qty');
            
            // Calculate total pulled out quantity for this product
            $pulledOutQty = PullOut::where('ProductID', $product->ProductID)
                ->sum('PullOutQty');
            
            $product->available_qty = max(0, $totalStockIn - $pulledOutQty);
            $product->total_stock_in = $totalStockIn;
            $product->total_pulled_out = $pulledOutQty;
            return $product;
        })
        ->filter(function ($product) {
            return $product->available_qty > 0;
        })
        ->values(); // Reset array keys
        
        // Get active employees
        $employees = Employee::where('EmployeeStatus', 'Available')->get();
        
        return view('admin.pullout', compact(
            'pullOuts', 
            'products', 
            'employees',
            'currentEmployee'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'SKUNumber' => 'required|exists:products,SKUNumber',
            'EmployeeID' => 'required|exists:employees,EmployeeID',
            'PullOutQty' => 'required|integer|min:1',
            'PullOutReason' => 'required|string|max:255',
            'PullOutType' => 'required|in:Damaged,Expired,Return,Theft,Quality Control,Other',
            'DatePullOut' => 'required|date',
        ]);

        try {
            DB::beginTransaction();
            
            // Get the product by SKU
            $product = Product::where('SKUNumber', $request->SKUNumber)->firstOrFail();
            
            // Calculate total stock in quantity for this product
            $totalStockIn = StockIn::where('ProductID', $product->ProductID)
                ->where('ProdStatus', 'Received')
                ->sum('Qty');
            
            // Calculate total already pulled out quantity for this product
            $pulledOutQty = PullOut::where('ProductID', $product->ProductID)
                ->sum('PullOutQty');
            
            $availableQty = max(0, $totalStockIn - $pulledOutQty);
            
            // Validate quantity
            if ($request->PullOutQty > $availableQty) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Pullout quantity exceeds available stock. Available: ' . $availableQty);
            }
            
            // Generate PullOutID
            $lastPullOut = PullOut::orderBy('PullOutID', 'desc')->first();
            $lastId = $lastPullOut ? intval(substr($lastPullOut->PullOutID, 2)) : 0;
            $pullOutId = 'PO' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
            
            // Create pullout record
            $pullOut = PullOut::create([
                'PullOutID' => $pullOutId,
                'ProductID' => $product->ProductID,
                'EmployeeID' => $request->EmployeeID,
                'PullOutQty' => $request->PullOutQty,
                'PullOutReason' => $request->PullOutReason,
                'PullOutType' => $request->PullOutType,
                'DatePullOut' => $request->DatePullOut,
            ]);
            
            // Update product stock quantity (deduct from StockQty)
            $product->StockQty = max(0, $product->StockQty - $request->PullOutQty);
            $product->save();
            
            DB::commit();
            
            return redirect()->route('admin.pullout')
                ->with('success', 'Pullout record added successfully! Stock has been deducted.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error adding pullout: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $pullOut = PullOut::with(['product.supplier', 'product.category', 'product.pricing', 'employee'])
                ->findOrFail($id);
                
            return response()->json([
                'success' => true,
                'data' => $pullOut,
                'product_name' => $pullOut->product->ProductName ?? 'N/A',
                'sku' => $pullOut->product->SKUNumber ?? 'N/A',
                'employee_name' => ($pullOut->employee->EmpFName ?? '') . ' ' . ($pullOut->employee->EmpLName ?? ''),
                'formatted_date' => \Carbon\Carbon::parse($pullOut->DatePullOut)->format('M d, Y'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Pullout record not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $pullOut = PullOut::findOrFail($id);
            $productId = $pullOut->ProductID;
            $quantity = $pullOut->PullOutQty;
            
            // Restore product stock quantity
            $product = Product::find($productId);
            if ($product) {
                $product->StockQty += $quantity;
                $product->save();
            }
            
            // Delete pullout record
            $pullOut->delete();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pullout record deleted successfully! Stock has been restored.'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Error deleting pullout: ' . $e->getMessage()
            ], 500);
        }
    }
}
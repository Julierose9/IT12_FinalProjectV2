<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PullOut;
use App\Models\StockIn;
use App\Models\Product;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PullOutController extends Controller
{
    public function index()
    {
        // Get all pullouts with relationships
        $pullOuts = PullOut::with(['product.supplier', 'employee'])
            ->orderBy('DatePullOut', 'desc')
            ->get();
        
        // Get products with available stock
        $products = Product::with(['supplier', 'category', 'pricing'])
            ->whereHas('stockIns', function($query) {
                $query->where('ProdStatus', 'Received');
            })
            ->get()
            ->map(function ($product) {
                // Calculate total stock in quantity for this product
                $totalStockIn = StockIn::where('ProductID', $product->ProductID)
                    ->where('ProdStatus', 'Received')
                    ->sum('Qty');
                
                // Calculate total pulled out quantity for this product by ProductID
                $pulledOutQty = PullOut::where('ProductID', $product->ProductID)
                    ->sum('PullOutQty');
                
                $product->available_qty = $totalStockIn - $pulledOutQty;
                $product->total_stock_in = $totalStockIn;
                $product->total_pulled_out = $pulledOutQty;
                return $product;
            })
            ->filter(function ($product) {
                return $product->available_qty > 0;
            });
        
        // Get active employees
        $employees = Employee::where('EmployeeStatus', 'Active')->get();
        
        return view('admin.pullout', compact('pullOuts', 'products', 'employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'SKUNumber' => 'required|exists:products,SKUNumber',
            'EmployeeID' => 'required|exists:employees,EmployeeID',
            'PullOutQty' => 'required|integer|min:1',
            'PullOutReason' => 'required|in:Damaged,Expired,Returned to supplier',
            'PullOutType' => 'required|string',
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
            
            // Calculate total already pulled out quantity for this product by ProductID
            $pulledOutQty = PullOut::where('ProductID', $product->ProductID)
                ->sum('PullOutQty');
            $availableQty = $totalStockIn - $pulledOutQty;
            
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
            
            // Create pullout record using ProductID (converted from SKUNumber)
            $pullOut = PullOut::create([
                'PullOutID' => $pullOutId,
                'ProductID' => $product->ProductID,
                'EmployeeID' => $request->EmployeeID,
                'PullOutQty' => $request->PullOutQty,
                'PullOutReason' => $request->PullOutReason,
                'PullOutType' => $request->PullOutType,
                'DatePullOut' => $request->DatePullOut,
            ]);
            
            // Update product stock quantity
            $product->StockQty -= $request->PullOutQty;
            $product->save();
            
            DB::commit();
            
            return redirect()->route('admin.pullout.index')
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
        $pullOut = PullOut::with(['product.supplier', 'product.category', 'product.pricing', 'employee'])
            ->findOrFail($id);
            
        return response()->json([
            'success' => true,
            'data' => $pullOut,
            'product_name' => $pullOut->product->ProductName ?? 'N/A',
            'sku' => $pullOut->product->SKUNumber ?? 'N/A',
            'employee_name' => $pullOut->employee->EmpFName . ' ' . $pullOut->employee->EmpLName ?? 'N/A',
            'formatted_date' => \Carbon\Carbon::parse($pullOut->DatePullOut)->format('M d, Y'),
        ]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $pullOut = PullOut::findOrFail($id);
            
            // Restore product stock quantity
            $product = Product::find($pullOut->ProductID);
            if ($product) {
                $product->StockQty += $pullOut->PullOutQty;
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
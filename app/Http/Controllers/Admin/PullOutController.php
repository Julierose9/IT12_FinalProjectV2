<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PullOut;
use App\Models\Product;
use App\Models\Employee;
use Illuminate\Http\Request;

class PullOutController extends Controller
{
    public function index(Request $request)
    {
        $query = PullOut::with(['product', 'employee'])->orderBy('DatePullOut', 'desc');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('PullOutID', 'like', "%{$search}%")
                  ->orWhereHas('product', fn($p) => $p->where('ProdName', 'like', "%{$search}%"))
                  ->orWhereHas('employee', fn($e) => $e->whereRaw("CONCAT(EmpFName, ' ', EmpLName) LIKE ?", ["%{$search}%"]));
            });
        }

        // Filter by reason
        if ($request->filled('reason')) {
            $query->whereIn('PullOutReason', $request->reason);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('DatePullOut', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('DatePullOut', '<=', $request->date_to);
        }

        $pullOuts = $query->paginate(15)->withQueryString();
        $products = Product::all();
        $employees = Employee::all();

        return view('admin.pullout', compact('pullOuts', 'products', 'employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ProductID' => 'required|exists:products,ProductID',
            'EmployeeID' => 'required|exists:employees,EmployeeID',
            'Qty' => 'required|integer|min:1',
            'Reason' => 'required|string',
            'DatePullOut' => 'required|date',
        ]);

        $pullOutId = 'PO-' . date('Ymd') . '-' . str_pad(PullOut::count() + 1, 4, '0', STR_PAD_LEFT);

        PullOut::create([
            'PullOutID' => $pullOutId,
            'ProductID' => $validated['ProductID'],
            'EmployeeID' => $validated['EmployeeID'],
            'PullOutQty' => $validated['Qty'],
            'PullOutReason' => $validated['Reason'],
            'DatePullOut' => $validated['DatePullOut'],
        ]);

        return redirect()->route('admin.pullout')
            ->with('success', 'Pullout created successfully!');
    }

    public function edit(PullOut $pullOut)
    {
        $products = Product::all();
        $employees = Employee::all();

        return response()->json([
            'pullOut' => $pullOut->load('product', 'employee'),
            'products' => $products,
            'employees' => $employees,
        ]);
    }

    public function update(Request $request, PullOut $pullOut)
    {
        $validated = $request->validate([
            'ProductID' => 'required|exists:products,ProductID',
            'EmployeeID' => 'required|exists:employees,EmployeeID',
            'Qty' => 'required|integer|min:1',
            'Reason' => 'required|string',
            'DatePullOut' => 'required|date',
        ]);

        $pullOut->update([
            'ProductID' => $validated['ProductID'],
            'EmployeeID' => $validated['EmployeeID'],
            'PullOutQty' => $validated['Qty'],
            'PullOutReason' => $validated['Reason'],
            'DatePullOut' => $validated['DatePullOut'],
        ]);

        return redirect()->route('admin.pullout')
            ->with('success', 'Pullout updated successfully!');
    }

    public function destroy(PullOut $pullOut)
    {
        $pullOut->delete();

        return redirect()->route('admin.pullout')
            ->with('success', 'Pullout deleted successfully!');
    }
}
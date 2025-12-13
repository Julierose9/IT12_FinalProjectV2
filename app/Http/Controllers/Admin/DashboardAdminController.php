<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Employee;
use App\Models\Category;
use App\Models\StockIn;
use App\Models\PullOut;
use Carbon\Carbon;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Check if user is authenticated and is admin
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if user is admin
        if (Auth::user()->Role !== 'Admin') {
            abort(403, 'Unauthorized access. Admin role required.');
        }

        // Get authenticated user
        $user = Auth::user();
        $today = Carbon::today();
        
        // Get employee details if available
        $employeeName = $user->Username ?? 'Administrator';
        $employeeId = $user->EmployeeID ?? null;
        
        if ($employeeId) {
            $employee = Employee::where('EmployeeID', $employeeId)->first();
            if ($employee) {
                // Format employee name like in your EmployeeController
                $firstName = $employee->EmployeeFName ?? '';
                $middleName = $employee->EmployeeMName ? $employee->EmployeeMName . ' ' : '';
                $lastName = $employee->EmployeeLName ?? '';
                $employeeName = trim("{$firstName} {$middleName}{$lastName}");
            }
        }

        // Get dashboard statistics with try-catch to avoid any errors
        $totalProducts = Product::count();
        
        // Get stock out today (pullouts for today)
        $stockOutToday = 0;
        try {
            $stockOutToday = PullOut::whereDate('DatePullOut', $today)
                ->sum('PullOutQty') ?? 0;
        } catch (\Exception $e) {
            // Log error if needed
            \Log::error('Error getting stock out today: ' . $e->getMessage());
        }
        
        // Get near expiry products from stock_in table
        $nearExpiry = 0;
        try {
            $nearExpiry = StockIn::whereNotNull('ExpirationDate')
                ->whereDate('ExpirationDate', '<=', Carbon::now()->addDays(30))
                ->whereDate('ExpirationDate', '>', Carbon::now())
                ->count();
        } catch (\Exception $e) {
            \Log::error('Error getting near expiry: ' . $e->getMessage());
        }
        
        // Calculate low stock items (less than 20)
        $lowStock = 0;
        try {
            $lowStock = Product::where('StockQty', '<', 20)->count();
        } catch (\Exception $e) {
            \Log::error('Error getting low stock: ' . $e->getMessage());
        }
        
        // Get top products (most stock quantity)
        $topProducts = collect([]);
        try {
            $topProducts = Product::with('category')
                ->orderBy('StockQty', 'desc')
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            \Log::error('Error getting top products: ' . $e->getMessage());
        }
        
        // Get all categories for filters
        $categories = Category::all();
        
        // Get recent stock ins (last 7 days)
        $recentStockIns = 0;
        try {
            $recentStockIns = StockIn::whereDate('DateRcvd', '>=', Carbon::now()->subDays(7))
                ->sum('Qty') ?? 0;
        } catch (\Exception $e) {
            \Log::error('Error getting recent stock ins: ' . $e->getMessage());
        }
        
        // Get recent pullouts (last 7 days)
        $recentPullouts = 0;
        try {
            $recentPullouts = PullOut::whereDate('DatePullOut', '>=', Carbon::now()->subDays(7))
                ->sum('PullOutQty') ?? 0;
        } catch (\Exception $e) {
            \Log::error('Error getting recent pullouts: ' . $e->getMessage());
        }

        return view('admin.dashboard', [
            'user' => $user,
            'employeeName' => $employeeName,
            'employeeId' => $employeeId,
            'today' => $today,
            'totalProducts' => $totalProducts,
            'stockOutToday' => $stockOutToday,
            'nearExpiry' => $nearExpiry,
            'lowStock' => $lowStock,
            'topProducts' => $topProducts,
            'categories' => $categories,
            'recentStockIns' => $recentStockIns,
            'recentPullouts' => $recentPullouts
        ]);
    }
}
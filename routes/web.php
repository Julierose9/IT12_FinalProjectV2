<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PullOutController;
use App\Http\Controllers\Admin\StockInController;
use App\Http\Controllers\Admin\Reports\InventoryReportController;
use App\Http\Controllers\Cashier\DailySalesController;
use App\Http\Controllers\Cashier\OrderController;
use App\Http\Controllers\Cashier\PaymentController;
use App\Http\Controllers\Cashier\DashboardController;
use App\Http\Controllers\Cashier\TransactionHistoryController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\TransactionController;
use Illuminate\Http\Request; // ← added for password reset

// ==================== PUBLIC ROUTES ====================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Password reset routes
    Route::post('/verify-email', [LoginController::class, 'verifyEmail'])->name('password.email');
    Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('password.reset');
Route::get('/', fn() => redirect()->route('login'));

// ==================== PROTECTED ROUTES (auth required) ====================
Route::middleware('auth')->group(function () {

    // ==================== ADMIN ROUTES ====================
    Route::prefix('admin')->name('admin.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');

        // ==================== ACCOUNTS ====================
        Route::get('/accounts', [AccountController::class, 'index'])->name('accounts');
        Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');
        Route::get('/accounts/{id}', [AccountController::class, 'show'])->name('accounts.show');
        Route::get('/accounts/{id}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
        Route::put('/accounts/{id}', [AccountController::class, 'update'])->name('accounts.update');
        Route::delete('/accounts/{id}', [AccountController::class, 'destroy'])->name('accounts.destroy');

        // ==================== SUPPLIERS ====================
        Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');
        Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
        Route::get('/supplier/{id}', [SupplierController::class, 'show'])->name('supplier.show');
        Route::put('/supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

        // ==================== EMPLOYEES ====================
        Route::get('/employees', [EmployeeController::class, 'index'])->name('employees');
        Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
        Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
        
        Route::post('/employees/{employee}/remove-inactive', [EmployeeController::class, 'removeInactiveCashier'])
            ->name('employees.removeInactive');
        Route::post('/employees/batch-remove-inactive', [EmployeeController::class, 'batchRemoveInactiveCashiers'])
            ->name('employees.batchRemoveInactive');
        
        Route::get('/employees/api/list', [EmployeeController::class, 'getEmployees'])->name('employees.api.list');

        // ==================== PRODUCTS ====================
        Route::get('/products', [ProductController::class, 'index'])->name('products');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::post('/products/update-pricing', [ProductController::class, 'updatePricing'])->name('products.update-pricing');
        Route::put('/products/{id}/update-pricing', [ProductController::class, 'updateSinglePricing'])->name('products.update-single-pricing');
        Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
        
        // ==================== STOCK IN ROUTES ====================
        Route::get('/stockin', [StockInController::class, 'index'])->name('stockin');
        Route::post('/stockin', [StockInController::class, 'store'])->name('stockin.store');
        Route::get('/stockin/{id}', [StockInController::class, 'show'])->name('stockin.show');      
        Route::delete('/stockin/{id}', [StockInController::class, 'destroy'])->name('stockin.destroy');
        Route::get('/api/product-pricing/{id}', [StockInController::class, 'getProductPricing'])
            ->name('api.product.pricing');

        // ==================== PULLOUT ROUTES ====================
        Route::get('/pullout', [PullOutController::class, 'index'])->name('pullout');
        Route::post('/pullout', [PullOutController::class, 'store'])->name('pullout.store');
        Route::get('/pullout/{id}', [PullOutController::class, 'show'])->name('pullout.show');
        Route::get('/pullout/{id}/edit', [PullOutController::class, 'edit'])->name('pullout.edit');
        Route::put('/pullout/{id}', [PullOutController::class, 'update'])->name('pullout.update');
        Route::delete('/pullout/{id}', [PullOutController::class, 'destroy'])->name('pullout.destroy');

        // ==================== CATEGORIES ====================
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // ==================== TRANSACTION REPORT ROUTES ====================
        Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
        Route::get('/transaction/{id}/details', [TransactionController::class, 'show'])->name('transaction.details');
        Route::get('/transaction/{id}/receipt', [TransactionController::class, 'receipt'])->name('transaction.receipt');
        Route::get('/transaction/export/{type}', [TransactionController::class, 'export'])->name('transaction.export.type');

        Route::get('/transaction/export', [TransactionController::class, 'export'])->name('transaction.export');
        Route::get('/admin/transaction/export/csv', [TransactionController::class, 'exportCSV'])->name('admin.transaction.export.csv');

        // ==================== INVENTORY REPORT ====================
        Route::get('/inventory', [InventoryReportController::class, 'index'])->name('inventory');
        Route::get('/inventory/{id}/transactions', [InventoryReportController::class, 'productTransactions'])
            ->name('inventory.transactions');

        // ==================== REPORTS GROUP ====================
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/inventory', [InventoryReportController::class, 'index'])
                ->name('inventory');
            Route::get('/inventory/export', [InventoryReportController::class, 'export'])
                ->name('inventory.export');
        });
    }); // End of admin group

    // ==================== CASHIER ROUTES ====================
    Route::prefix('cashier')->name('cashier.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/api/dashboard/stats', [DashboardController::class, 'apiDashboardStats'])->name('api.dashboard.stats');
        Route::get('/dailysales', [DailySalesController::class, 'index'])->name('daily.sales');
        Route::get('/dailysales/export', [DailySalesController::class, 'exportPDF'])->name('daily.sales.export');
        Route::get('/sales', [OrderController::class, 'index'])->name('sales');
        Route::post('/sales', [OrderController::class, 'store'])->name('sales.store');
        Route::get('/sales/{id}', [OrderController::class, 'show'])->name('sales.show');
        Route::put('/sales/{id}/archive', [OrderController::class, 'archive'])->name('sales.archive');
        Route::get('/api/product/{id}', [OrderController::class, 'getProductDetails'])->name('api.product.details');
            Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
            Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
            Route::get('/payments/{id}', [PaymentController::class, 'show'])->name('payments.show');
            Route::put('/payments/{id}', [PaymentController::class, 'update'])->name('payments.update');
            Route::delete('/payments/{id}', [PaymentController::class, 'destroy'])->name('payments.destroy');
            Route::get('/orders/{orderId}/payments', [PaymentController::class, 'getOrderPayments'])->name('orders.payments');
            Route::get('/payments/{id}/receipt', [PaymentController::class, 'printReceipt'])->name('payments.receipt');
            Route::post('/payments/{id}/refund', [PaymentController::class, 'refund'])->name('payments.refund');
        
        Route::get('/transaction-history', [TransactionHistoryController::class, 'index'])->name('transaction.history');
        Route::get('cashier/transaction/{id}/receipt', [TransactionHistoryController::class, 'receipt'])->name('cashier.transaction.receipt');
    });

}); 

// ==================== LOGOUT ROUTE ====================
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/login');
})->name('logout');
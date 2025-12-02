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
use App\Http\Controllers\Admin\Reports\InventoryReportController; // Add this import

// ==================== PUBLIC ROUTES ====================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', fn() => redirect()->route('login'));

// ==================== PROTECTED ROUTES (auth required) ====================
Route::middleware('auth')->group(function () {

    // ==================== ADMIN ROUTES ====================
    Route::prefix('admin')->name('admin.')->group(function () {

        // Dashboard
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

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
        Route::get('/employees/{id}', [EmployeeController::class, 'show'])->name('employees.show');
        Route::put('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

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
        Route::post('/stockin/existing', [StockInController::class, 'storeForExisting'])->name('stockin.existing');
        Route::post('/stockin/newitem', [StockInController::class, 'storeNewItem'])->name('stockin.newitem');
        Route::post('/products/convert', [ProductController::class, 'convert'])->name('products.convert');

        // ==================== PULLOUT ROUTES ====================
        Route::get('/pullout', [PullOutController::class, 'index'])->name('pullout');
        Route::post('/pullout', [PullOutController::class, 'store'])->name('pullout.store');
        Route::delete('/pullout/{id}', [PullOutController::class, 'destroy'])->name('pullout.destroy');

        // ==================== CATEGORIES ====================
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // ==================== TRANSACTION ====================
        Route::get('/transaction', fn() => view('admin.transaction'))->name('transaction');

        // ==================== INVENTORY REPORT ====================
        // Main inventory report page (alias for admin.inventory)
        Route::get('/inventory', [InventoryReportController::class, 'index'])
            ->name('inventory');
        
        // ==================== REPORTS GROUP ====================
        Route::prefix('reports')->name('reports.')->group(function () {
            // Inventory report (alternative URL, same as above)
            Route::get('/inventory', [InventoryReportController::class, 'index'])
                ->name('inventory');
            
            // Inventory export
            Route::get('/inventory/export', [InventoryReportController::class, 'export'])
                ->name('inventory.export');
        });
    }); // End of admin group

    // ==================== CASHIER ROUTES ====================
    Route::prefix('cashier')->name('cashier.')->group(function () {
        Route::get('/dashboard', fn() => view('cashier.dashboard'))->name('dashboard');
        Route::get('/daily-sales', fn() => view('cashier.daily-sales'))->name('daily.sales');
        Route::get('/sales', fn() => view('cashier.sales'))->name('sales');
        Route::get('/transaction-history', fn() => view('cashier.transactionhistory'))->name('transaction.history');
    });

}); // End of auth middleware group

// ==================== LOGOUT ROUTE ====================
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/login');
})->name('logout');
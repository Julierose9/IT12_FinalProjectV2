<?php

use Illuminate\Support\Facades\Route;

// AUTH CONTROLLERS
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// ADMIN CONTROLLERS
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\StockInController;
use App\Http\Controllers\Admin\PullOutController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\InventoryController;

// CASHIER CONTROLLERS
use App\Http\Controllers\Cashier\DashboardController as CashierDashboardController;
use App\Http\Controllers\Cashier\OrderController as CashierOrderController;
use App\Http\Controllers\Cashier\PaymentController as CashierPaymentController;
use App\Http\Controllers\Cashier\TransactionController as CashierTransactionController;
use App\Http\Controllers\Cashier\DailySalesController;


// ===========================
// PUBLIC ROUTES
// ===========================

Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


// ===========================
// AUTHENTICATED ROUTES
// ===========================

Route::middleware('auth')->group(function () {

    // ======================
    // ADMIN ROUTES
    // ======================
    Route::prefix('admin')->name('admin.')->group(function () {
        

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Accounts
        Route::prefix('accounts')->name('accounts.')->group(function () {
            Route::get('/', [AccountController::class, 'index'])->name('index');
            Route::get('/create', [AccountController::class, 'create'])->name('create');
            Route::post('/', [AccountController::class, 'store'])->name('store');
            Route::get('/{account}', [AccountController::class, 'show'])->name('show');
            Route::get('/{account}/edit', [AccountController::class, 'edit'])->name('edit');
            Route::put('/{account}', [AccountController::class, 'update'])->name('update');
            Route::delete('/{account}', [AccountController::class, 'destroy'])->name('destroy');
            Route::post('/{account}/reset-password', [AccountController::class, 'resetPassword'])->name('reset-password');
        });

        // RECORDS
        Route::prefix('records')->name('records.')->group(function () {

            // Suppliers
            Route::prefix('suppliers')->name('suppliers.')->group(function () {
                Route::get('/', [SupplierController::class, 'index'])->name('index');
                Route::get('/create', [SupplierController::class, 'create'])->name('create');
                Route::post('/', [SupplierController::class, 'store'])->name('store');
                Route::get('/{supplier}', [SupplierController::class, 'show'])->name('show');
                Route::get('/{supplier}/edit', [SupplierController::class, 'edit'])->name('edit');
                Route::put('/{supplier}', [SupplierController::class, 'update'])->name('update');
                Route::delete('/{supplier}', [SupplierController::class, 'destroy'])->name('destroy');
            });

            // Employees
            Route::prefix('employees')->name('employees.')->group(function () {
                Route::get('/', [EmployeeController::class, 'index'])->name('index');
                Route::get('/create', [EmployeeController::class, 'create'])->name('create');
                Route::post('/', [EmployeeController::class, 'store'])->name('store');
                Route::get('/{employee}', [EmployeeController::class, 'show'])->name('show');
                Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('edit');
                Route::put('/{employee}', [EmployeeController::class, 'update'])->name('update');
                Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('destroy');
            });

            // Products
            Route::prefix('products')->name('products.')->group(function () {
                Route::get('/', [ProductController::class, 'index'])->name('index');
                Route::get('/create', [ProductController::class, 'create'])->name('create');
                Route::post('/', [ProductController::class, 'store'])->name('store');
                Route::get('/{product}', [ProductController::class, 'show'])->name('show');
                Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
                Route::put('/{product}', [ProductController::class, 'update'])->name('update');
                Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
            });
        });

        // TRANSACTIONS
        Route::prefix('transactions')->name('transactions.')->group(function () {

            // Stock-In
            Route::prefix('stock-in')->name('stock-in.')->group(function () {
                Route::get('/', [StockInController::class, 'index'])->name('index');
                Route::get('/create', [StockInController::class, 'create'])->name('create');
                Route::post('/', [StockInController::class, 'store'])->name('store');
                Route::get('/{stockIn}', [StockInController::class, 'show'])->name('show');
                Route::get('/{stockIn}/edit', [StockInController::class, 'edit'])->name('edit');
                Route::put('/{stockIn}', [StockInController::class, 'update'])->name('update');
                Route::delete('/{stockIn}', [StockInController::class, 'destroy'])->name('destroy');
            });

            // Pullouts
            Route::prefix('pullouts')->name('pullouts.')->group(function () {
                Route::get('/', [PullOutController::class, 'index'])->name('index');
                Route::get('/create', [PullOutController::class, 'create'])->name('create');
                Route::post('/', [PullOutController::class, 'store'])->name('store');
                Route::get('/{pullOut}', [PullOutController::class, 'show'])->name('show');
                Route::get('/{pullOut}/edit', [PullOutController::class, 'edit'])->name('edit');
                Route::put('/{pullOut}', [PullOutController::class, 'update'])->name('update');
                Route::delete('/{pullOut}', [PullOutController::class, 'destroy'])->name('destroy');
            });
        });

        // REPORTS
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/daily-sales', fn() => view('admin.reports.daily-sales'))->name('daily-sales');
            Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');
            Route::get('/payment-summary', fn() => view('admin.reports.payment-summary'))->name('payment-summary');
            Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
            Route::get('/pullouts', fn() => view('admin.reports.pullouts'))->name('pullouts');
        });

        // SETTINGS
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', fn() => view('admin.settings.index'))->name('index');
        });
    });

    // ======================
    // CASHIER ROUTES
    // ======================
    Route::prefix('cashier')->name('cashier.')->group(function () {

        // Dashboard
        Route::get('/dashboard', [CashierDashboardController::class, 'index'])->name('dashboard');

        // Combined Sales
        Route::prefix('sales')->name('sales.')->group(function () {
            Route::get('/', [CashierOrderController::class, 'sales'])->name('index');
        });

        // Orders
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [CashierOrderController::class, 'index'])->name('index');
            Route::get('/create', [CashierOrderController::class, 'create'])->name('create');
            Route::post('/', [CashierOrderController::class, 'store'])->name('store');
            Route::get('/{order}', [CashierOrderController::class, 'show'])->name('show');
            Route::put('/{order}', [CashierOrderController::class, 'update'])->name('update');
            Route::delete('/{order}', [CashierOrderController::class, 'destroy'])->name('destroy');
            Route::post('/{order}/process-payment', [CashierOrderController::class, 'processPayment'])->name('process-payment');
            Route::post('/{order}/update-status', [CashierOrderController::class, 'updateStatus'])->name('update-status');
        });

        // Payments
        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/', [CashierPaymentController::class, 'index'])->name('index');
            Route::get('/create', [CashierPaymentController::class, 'create'])->name('create');
            Route::post('/', [CashierPaymentController::class, 'store'])->name('store');
            Route::get('/{payment}', [CashierPaymentController::class, 'show'])->name('show');
            Route::put('/{payment}', [CashierPaymentController::class, 'update'])->name('update');
            Route::post('/{payment}/refund', [CashierPaymentController::class, 'refund'])->name('refund');
        });

        // Transactions
        Route::prefix('transactions')->name('transactions.')->group(function () {
            Route::get('/', [CashierTransactionController::class, 'index'])->name('index');
            Route::get('/{transaction}', [CashierTransactionController::class, 'show'])->name('show');
            Route::get('/{transaction}/receipt', [CashierTransactionController::class, 'receipt'])->name('receipt');
        });

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/daily-sales', [DailySalesController::class, 'dailySales'])->name('daily-sales');
            Route::get('/transactions', fn() => view('cashier.reports.transactions'))->name('transactions');
            Route::get('/payment-summary', fn() => view('cashier.reports.payment-summary'))->name('payment-summary');
        });

        // Settings
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', fn() => view('cashier.settings.index'))->name('index');
            Route::get('/profile', fn() => view('cashier.settings.profile'))->name('profile');
        });
    });

});


// FALLBACK
Route::fallback(fn() => redirect()->route('login'));

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Transaction Report | Dora's Oshoppe</title>

  <!-- Bootstrap + FontAwesome + Poppins -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary-color: #3b3183;
      --secondary-color: #6c757d;
      --success-color: #23b07a;
      --danger-color: #e05252;
      --warning-color: #f08a24;
      --light-bg: #f5f7fb;
      --card-shadow: 0 2px 4px rgba(0,0,0,0.04);
    }
    body { font-family: 'Poppins', sans-serif; background: var(--light-bg); padding-top: 0; }

    /* Sidebar */
    .sidebar {
      min-width: 220px; max-width: 220px; background: #fff;
      border-right: 1px solid #eef2f7; height: 100vh; position: fixed;
      top: 0; left: 0; padding: 22px; display: flex; flex-direction: column;
      overflow: hidden; transition: all 0.3s ease; z-index: 1000;
    }
    .sidebar.mobile-open { transform: translateX(0); }
    .brand { display: flex; align-items: center; gap: 10px; margin-bottom: 18px; }
    .brand img { width: 40px; height: 40px; object-fit: contain; }
    .sidebar .nav-link {
      color: #5b5f72; padding: 12px 8px; border-radius: 10px;
      font-size: 0.95rem; display: flex; align-items: center;
      transition: all 0.2s ease;
    }
    .sidebar .nav-link.active { background: #efeaff; color: var(--primary-color); font-weight: 600; }
    .sidebar .nav-link:hover { background: #f8f9fa; transform: translateX(2px); }
    .sidebar .nav-link i { width: 20px; margin-right: 10px; text-align: center; }
    .sidebar-nav { flex: 1; overflow-y: auto; margin-top: 18px; }
    .nav.flex-column.ms-3 { border-left: 2px solid #eef2f7; margin-left: 12px !important; padding-left: 8px; }
    .nav.flex-column.ms-3 .nav-link { padding: 10px 12px; font-size: 0.9rem; border-radius: 6px; }

    /* Mobile */
    .sidebar-toggle { display: none; position: fixed; top: 15px; left: 15px; z-index: 1001;
      background: var(--primary-color); color: white; border: none; border-radius: 8px;
      width: 40px; height: 40px; font-size: 1.2rem; }
    .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0,0,0,0.5); z-index: 999; }
    .sidebar-overlay.active { display: block; }

    /* Content */
    .content-wrap { margin-left: 240px; padding: 28px; transition: all 0.3s ease; }
    .topbar { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 22px; }
    .page-title-section h4 { margin-bottom: 4px; }
    .user-section { display: flex; flex-direction: column; align-items: flex-end; gap: 16px; min-width: 300px; }
    .user-avatar { width: 44px; height: 44px; border-radius: 10px; object-fit: cover; }
    .user-dropdown-toggle { background: none; border: none; display: flex; align-items: center; gap: 12px;
      cursor: pointer; padding: 8px; border-radius: 8px; }
    .user-dropdown-toggle:hover { background: #f8f9fa; }
    .user-dropdown-menu { position: absolute; top: 100%; right: 0; background: white;
      border: 1px solid #dee2e6; border-radius: 8px; padding: 8px 0; min-width: 150px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-top: 8px; display: none; z-index: 1000; }
    .user-dropdown-menu.show { display: block; }
    .user-dropdown-item { padding: 8px 16px; display: flex; align-items: center; gap: 8px;
      color: #5b5f72; background: none; border: none; width: 100%; text-align: left; cursor: pointer; }
    .user-dropdown-item:hover { background: #f8f9fa; color: var(--primary-color); }

    /* Search & Filter */
    .filter-container { display: flex; flex-direction: column; align-items: flex-end; gap: 8px; width: 100%; }
    .search-filter-section { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
    .search-input { max-width: 400px; width: 100%; min-width: 250px; }
    .filter-toggle { background: #fff; border: 1px solid #dee2e6; border-radius: 8px;
      padding: 10px 12px; display: flex; align-items: center; gap: 6px; cursor: pointer; }
    .filter-toggle.active { background: var(--primary-color); color: white; border-color: var(--primary-color); }
    .filter-menu { position: absolute; top: 100%; right: 0; background: white; border: 1px solid #dee2e6;
      border-radius: 8px; padding: 16px; min-width: 240px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      margin-top: 8px; display: none; z-index: 1000; }
    .filter-menu.show { display: block; }
    .active-filters { display: none; gap: 8px; flex-wrap: wrap; }
    .active-filters.has-filters { display: flex; }
    .filter-tag { background: #e9ecef; border: 1px solid #dee2e6; border-radius: 16px;
      padding: 4px 12px; font-size: 0.8rem; display: flex; align-items: center; gap: 6px; }
    .filter-tag-remove { background: none; border: none; cursor: pointer; color: var(--secondary-color); }

    /* Table */
    .table-card { border-radius: 12px; border: none; box-shadow: var(--card-shadow); overflow: hidden; }
    .table th { font-weight: 600; color: #5b5f72; font-size: 0.85rem; text-transform: uppercase;
      letter-spacing: 0.5px; padding: 12px 16px; white-space: nowrap; }
    .table td { padding: 16px; vertical-align: middle; border-color: #f1f3f4; }
    .status-badge { padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 500; }
    .status-active { background: #e8f5e8; color: var(--success-color); }
    .status-inactive { background: #f8f9fa; color: var(--danger-color); }
    .status-completed { background: #e8f5e8; color: var(--success-color); }
    .status-cancelled { background: #fde8e8; color: var(--danger-color); }

    /* Stats Cards */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }
    
    .stat-card {
      background: white;
      border-radius: 12px;
      padding: 24px;
      box-shadow: var(--card-shadow);
      transition: transform 0.2s ease;
    }
    
    .stat-card:hover {
      transform: translateY(-2px);
    }
    
    .stat-title {
      color: #5b5f72;
      font-size: 0.9rem;
      font-weight: 500;
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    
    .stat-value {
      font-size: 2rem;
      font-weight: 700;
      color: var(--primary-color);
      margin-bottom: 4px;
    }
    
    .stat-change {
      font-size: 0.85rem;
      display: flex;
      align-items: center;
      gap: 4px;
    }
    
    .stat-change.positive {
      color: var(--success-color);
    }
    
    .stat-change.negative {
      color: var(--danger-color);
    }

    /* Tabs */
    .nav-tabs .nav-link { color: #5b5f72; border: none; padding: 12px 20px; font-weight: 500; }
    .nav-tabs .nav-link.active { color: var(--primary-color); background-color: #efeaff; border-bottom: 2px solid var(--primary-color); }

    /* Responsive */
    @media (max-width: 991.98px) {
      .sidebar { transform: translateX(-100%); width: 280px; box-shadow: 2px 0 10px rgba(0,0,0,0.1); }
      .sidebar.mobile-open { transform: translateX(0); }
      .sidebar-toggle, .sidebar-overlay { display: block; }
      .content-wrap { margin-left: 0; padding: 70px 16px 16px; }
      .topbar { flex-direction: column; align-items: stretch; }
      .user-section, .filter-container { align-items: stretch; min-width: 100%; }
      .search-input { min-width: 100%; }
      .stats-grid { grid-template-columns: 1fr; }
    }
    
    @media (max-width: 575.98px) {
      .content-wrap { padding: 70px 8px 8px; }
      .table th, .table td { padding: 10px 6px; font-size: 0.85rem; }
      .action-buttons { flex-direction: column; }
      .stat-card { padding: 16px; }
      .stat-value { font-size: 1.5rem; }
    }
  </style>
</head>
<body>
@php
    // Create empty collections if variables don't exist
    $transactions = $transactions ?? collect([]);
    $period = $period ?? 'monthly';
@endphp

<!-- Mobile Toggle & Overlay -->
<button class="sidebar-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

{{-- Sidebar --}}
<aside class="sidebar" id="sidebar">
    <div class="brand">
        <img src="{{ asset('images/logo_.png') }}" alt="Logo">
        <div class="brand-text">
            <div style="font-weight:600">Dora's Oshoppe</div>
            <small class="text-muted">Gift Shop</small>
        </div>
    </div>

    <div class="sidebar-nav">
        <nav class="nav flex-column">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a class="nav-link" href="{{ route('admin.accounts') }}">
                <i class="fas fa-user-circle"></i>
                <span>Accounts</span>
            </a>

            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#recordsSubmenu">
                <i class="fas fa-archive"></i>
                <span>Records</span>
            </a>
            <div class="collapse show" id="recordsSubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link" href="{{ route('admin.supplier') }}">
                        <i class="fas fa-truck"></i>
                        <span>Suppliers</span>
                    </a>
                    <a class="nav-link" href="{{ route('admin.employees') }}">
                        <i class="fas fa-users"></i>
                        <span>Employees</span>
                    </a>
                    <a class="nav-link" href="{{ route('admin.products') }}">
                        <i class="fas fa-box"></i>
                        <span>Products</span>
                    </a>
                </div>
            </div>

            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#transactionsSubmenu">
                <i class="fas fa-exchange-alt"></i>
                <span>Inventory</span>
            </a>
            <div class="collapse" id="transactionsSubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link" href="{{ route('admin.stockin') }}">
                        <i class="fas fa-arrow-circle-down"></i>
                        <span>Stock In</span>
                    </a>
                    <a class="nav-link" href="{{ route('admin.pullout') }}">
                        <i class="fas fa-arrow-circle-up"></i>
                        <span>Pullouts</span>
                    </a>
                </div>
            </div>

            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#reportsSubmenu">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
            </a>
            <div class="collapse show" id="reportsSubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link active" href="{{ route('admin.transaction') }}">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Transaction</span>
                    </a>
                    <a class="nav-link" href="{{ route('admin.inventory') }}">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Inventory</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>
</aside>

<!-- Main Content -->
<main class="content-wrap" id="contentWrap">
  <div class="topbar">
    <div class="page-title-section">
      <h4 class="mb-1">Transaction Report</h4>
      <small class="text-muted">View completed and cancelled sales</small>
    </div>
    <div class="user-section">
      <div class="user-dropdown">
        <button class="user-dropdown-toggle" id="userDropdownToggle">
          <img src="{{ asset('images/logo_.png') }}" alt="avatar" class="user-avatar">
          <div class="user-details">
            <div class="user-name">Dora</div>
            <div class="user-role">Administrator</div>
          </div>
          <i class="fas fa-chevron-down" style="font-size: 0.8rem;"></i>
        </button>
        <div class="user-dropdown-menu" id="userDropdownMenu">
          <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="user-dropdown-item"><i class="fas fa-sign-out-alt me-2"></i> Sign Out</button>
          </form>
        </div>
      </div>

      <div class="filter-container">
        <div class="search-filter-section">
          <div class="input-group search-input">
            <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
            <input type="text" class="form-control" placeholder="Search transactions..." id="searchInput">
          </div>
          <div class="filter-dropdown">
            <button class="filter-toggle" id="filterToggle"><i class="fas fa-filter"></i> Filter <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i></button>
            <div class="filter-menu" id="filterMenu">
              <!-- Time Period Filter -->
              <div class="filter-section">
                <div class="filter-section-title">Time Period</div>
                <div class="filter-options">
                  <div class="filter-option">
                    <input type="radio" name="timePeriod" id="period-today" {{ $period == 'daily' ? 'checked' : '' }}>
                    <label for="period-today">Today</label>
                  </div>
                  <div class="filter-option">
                    <input type="radio" name="timePeriod" id="period-week">
                    <label for="period-week">This Week</label>
                  </div>
                  <div class="filter-option">
                    <input type="radio" name="timePeriod" id="period-month" {{ $period == 'monthly' ? 'checked' : '' }}>
                    <label for="period-month">This Month</label>
                  </div>
                  <div class="filter-option">
                    <input type="radio" name="timePeriod" id="period-custom">
                    <label for="period-custom">Custom Range</label>
                  </div>
                </div>
                <div class="date-inputs" id="customDateRange" style="display: none;">
                  <div class="date-input">
                    <input type="date" id="dateFrom" placeholder="From Date">
                  </div>
                  <div class="date-input">
                    <input type="date" id="dateTo" placeholder="To Date">
                  </div>
                </div>
              </div>
              
              <!-- Transaction Status Filters -->
              <div class="filter-section">
                <div class="filter-section-title">Transaction Status</div>
                <div class="filter-options">
                  <div class="filter-option">
                    <input type="checkbox" id="status-completed" checked>
                    <label for="status-completed">Completed</label>
                  </div>
                  <div class="filter-option">
                    <input type="checkbox" id="status-cancelled" checked>
                    <label for="status-cancelled">Cancelled</label>
                  </div>
                </div>
              </div>
              
              <!-- Payment Method Filters -->
              <div class="filter-section">
                <div class="filter-section-title">Payment Method</div>
                <div class="filter-options">
                  <div class="filter-option">
                    <input type="checkbox" id="payment-all" checked>
                    <label for="payment-all">All Methods</label>
                  </div>
                  <div class="filter-option">
                    <input type="checkbox" id="payment-cash">
                    <label for="payment-cash">Cash</label>
                  </div>
                  <div class="filter-option">
                    <input type="checkbox" id="payment-card">
                    <label for="payment-card">Card</label>
                  </div>
                  <div class="filter-option">
                    <input type="checkbox" id="payment-digital">
                    <label for="payment-digital">Digital Wallet</label>
                  </div>
                </div>
              </div>
              
              <div class="filter-actions">
                <button class="btn-apply" id="applyFilters">Apply</button>
                <button class="btn-clear" id="clearFilters">Reset</button>
              </div>
            </div>
          </div>
        </div>
        <div class="active-filters" id="activeFilters"></div>
      </div>
    </div>
  </div>



  {{-- Transaction Table --}}
  <div class="card table-card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h5 class="card-title mb-0">Transaction History</h5>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.transaction') }}?period={{ $period }}&export=csv" class="btn btn-success">
            <i class="fas fa-file-export me-2"></i>Export CSV
          </a>
          <a href="{{ route('admin.transaction') }}?period={{ $period }}&export=pdf" class="btn btn-danger">
            <i class="fas fa-file-pdf me-2"></i>Export PDF
          </a>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Transaction ID</th>
              <th>Cashier</th>
              <th>Items</th>
              <th>Total Amount</th>
              <th>Payment</th>
              <th>Status</th>
              <th>Date & Time</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="transactionsTableBody">
            @forelse($transactions as $transaction)
            <tr>
              <td>
                <strong>#{{ $transaction->TransactionID ?? $transaction->id ?? 'N/A' }}</strong>
              </td>
              <td>
                <div class="d-flex align-items-center">
                  <div>
                    <div style="font-weight:600">{{ $transaction->cashier->EmpFName ?? 'System' }} {{ $transaction->cashier->EmpLName ?? '' }}</div>
                    <small class="text-muted">{{ $transaction->cashier->EmployeeID ?? 'Auto' }}</small>
                  </div>
                </div>
              </td>
              <td>
                <span class="text-muted">{{ $transaction->items_count ?? 0 }} items</span>
              </td>
              <td>
                <strong>₱{{ number_format($transaction->total_amount ?? 0, 2) }}</strong>
              </td>
              <td>
                @php
                  $paymentMethod = $transaction->payment_method ?? 'Cash';
                  $paymentColors = [
                    'Cash' => 'text-primary',
                    'Card' => 'text-success',
                    'Digital Wallet' => 'text-warning',
                    'Credit' => 'text-info'
                  ];
                @endphp
                <span class="{{ $paymentColors[$paymentMethod] ?? 'text-secondary' }}">
                  {{ $paymentMethod }}
                </span>
              </td>
              <td>
                @if(($transaction->status ?? 'Completed') === 'Completed')
                  <span class="status-badge status-completed">Completed</span>
                @elseif(($transaction->status ?? 'Completed') === 'Cancelled')
                  <span class="status-badge status-cancelled">Cancelled</span>
                @else
                  <span class="status-badge bg-secondary">{{ $transaction->status ?? 'Pending' }}</span>
                @endif
              </td>
              <td>
                <small class="text-muted">
                  @if(isset($transaction->created_at))
                    {{ $transaction->created_at->format('M d, Y H:i') }}
                  @else
                    {{ date('M d, Y') }}
                  @endif
                </small>
              </td>
              <td>
                <div class="btn-group">
                  <button class="btn btn-sm btn-outline-primary view-transaction" 
                          data-bs-toggle="modal" 
                          data-bs-target="#viewTransactionModal"
                          data-transaction-id="{{ $transaction->TransactionID ?? $transaction->id }}"
                          data-cashier="{{ ($transaction->cashier->EmpFName ?? 'System') . ' ' . ($transaction->cashier->EmpLName ?? '') }}"
                          data-items="{{ $transaction->items_count ?? 0 }}"
                          data-total="{{ number_format($transaction->total_amount ?? 0, 2) }}"
                          data-payment="{{ $transaction->payment_method ?? 'Cash' }}"
                          data-status="{{ $transaction->status ?? 'Completed' }}"
                          data-date="{{ isset($transaction->created_at) ? $transaction->created_at->format('M d, Y H:i') : date('M d, Y H:i') }}">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button class="btn btn-sm btn-outline-danger delete-transaction" 
                          data-bs-toggle="modal" 
                          data-bs-target="#deleteTransactionModal"
                          data-transaction-id="{{ $transaction->TransactionID ?? $transaction->id }}"
                          data-amount="₱{{ number_format($transaction->total_amount ?? 0, 2) }}">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h5>No transactions found</h5>
                <p class="text-muted">No transactions have been recorded for the selected period.</p>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Simple transaction count --}}
      <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
          Total: {{ count($transactions) }} transaction(s)
        </div>
      </div>
    </div>
  </div>

</main>

{{-- View Transaction Modal --}}
<div class="modal fade" id="viewTransactionModal" tabindex="-1" aria-labelledby="viewTransactionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewTransactionModalLabel">Transaction Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Transaction ID</label>
              <input type="text" class="form-control" id="viewTransactionId" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Date & Time</label>
              <input type="text" class="form-control" id="viewTransactionDate" readonly>
            </div>
          </div>
        </div>
        
        <div class="row mb-3">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Cashier</label>
              <input type="text" class="form-control" id="viewTransactionCashier" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Status</label>
              <input type="text" class="form-control" id="viewTransactionStatus" readonly>
            </div>
          </div>
        </div>
        
        <div class="row mb-3">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Payment Method</label>
              <input type="text" class="form-control" id="viewTransactionPayment" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Total Amount</label>
              <input type="text" class="form-control" id="viewTransactionTotal" readonly>
            </div>
          </div>
        </div>
        
        <div class="mb-3">
          <label class="form-label">Items Purchased</label>
          <div class="table-responsive">
            <table class="table table-sm" id="transactionItemsTable">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <!-- Items will be populated dynamically -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="window.print()">
          <i class="fas fa-print me-2"></i>Print Receipt
        </button>
      </div>
    </div>
  </div>
</div>

{{-- Delete Transaction Modal --}}
<div class="modal fade" id="deleteTransactionModal" tabindex="-1" aria-labelledby="deleteTransactionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteTransactionModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this transaction? This action cannot be undone.</p>
        <p><strong>Transaction ID: <span id="deleteTransactionId"></span></strong></p>
        <p><strong>Amount: <span id="deleteTransactionAmount"></span></strong></p>
        <div class="alert alert-warning">
          <i class="fas fa-exclamation-triangle me-2"></i>
          Deleting this transaction will remove it from all reports and cannot be recovered.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <form id="deleteTransactionForm" method="POST" style="display: inline;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Delete Transaction</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle for mobile
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('mobile-open');
            sidebarOverlay.classList.toggle('active');
        });
    }
    
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.remove('active');
        });
    }
    
    // User dropdown
    const userDropdownToggle = document.getElementById('userDropdownToggle');
    const userDropdownMenu = document.getElementById('userDropdownMenu');
    
    if (userDropdownToggle) {
        userDropdownToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdownMenu.classList.toggle('show');
        });
        
        document.addEventListener('click', function() {
            userDropdownMenu.classList.remove('show');
        });
    }
    
    // Filter toggle
    const filterToggle = document.getElementById('filterToggle');
    const filterMenu = document.getElementById('filterMenu');
    
    if (filterToggle) {
        filterToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            filterMenu.classList.toggle('show');
            filterToggle.classList.toggle('active');
        });
        
        document.addEventListener('click', function() {
            filterMenu.classList.remove('show');
            filterToggle.classList.remove('active');
        });
    }
    
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#transactionsTableBody tr');
            
            rows.forEach(row => {
                const transactionId = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const cashier = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const amount = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                
                if (transactionId.includes(searchTerm) || cashier.includes(searchTerm) || amount.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // View Transaction Modal
    const viewTransactionButtons = document.querySelectorAll('.view-transaction');
    viewTransactionButtons.forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('viewTransactionId').value = this.dataset.transactionId;
            document.getElementById('viewTransactionDate').value = this.dataset.date;
            document.getElementById('viewTransactionCashier').value = this.dataset.cashier;
            document.getElementById('viewTransactionStatus').value = this.dataset.status;
            document.getElementById('viewTransactionPayment').value = this.dataset.payment;
            document.getElementById('viewTransactionTotal').value = '₱' + this.dataset.total;
            
            // For now, we'll add dummy items. In a real app, you'd fetch these from the server
            const itemsTable = document.querySelector('#transactionItemsTable tbody');
            itemsTable.innerHTML = `
                <tr>
                    <td>Sample Product 1</td>
                    <td>2</td>
                    <td>₱150.00</td>
                    <td>₱300.00</td>
                </tr>
                <tr>
                    <td>Sample Product 2</td>
                    <td>1</td>
                    <td>₱250.00</td>
                    <td>₱250.00</td>
                </tr>
            `;
        });
    });
    
    // Delete Transaction Modal
    const deleteTransactionButtons = document.querySelectorAll('.delete-transaction');
    deleteTransactionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const form = document.getElementById('deleteTransactionForm');
            form.action = `/admin/transactions/${this.dataset.transactionId}`;
            document.getElementById('deleteTransactionId').textContent = this.dataset.transactionId;
            document.getElementById('deleteTransactionAmount').textContent = this.dataset.amount;
        });
    });
    
    // Filter functionality
    const activeFilters = document.getElementById('activeFilters');
    const customDateRange = document.getElementById('customDateRange');
    const applyFiltersBtn = document.getElementById('applyFilters');
    const clearFiltersBtn = document.getElementById('clearFilters');
    
    // Show/hide custom date range
    document.querySelectorAll('input[name="timePeriod"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.id === 'period-custom') {
                customDateRange.style.display = 'flex';
            } else {
                customDateRange.style.display = 'none';
            }
        });
    });
    
    // Apply filters
    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', function() {
            filterMenu.classList.remove('show');
            filterToggle.classList.remove('active');
            updateActiveFilters();
        });
    }
    
    // Clear filters
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', function() {
            // Reset all checkboxes and radios
            document.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                if (cb.id !== 'payment-all') cb.checked = false;
            });
            document.getElementById('payment-all').checked = true;
            document.getElementById('status-completed').checked = true;
            document.getElementById('status-cancelled').checked = true;
            
            // Set time period based on current period
            @if($period == 'daily')
                document.getElementById('period-today').checked = true;
            @elseif($period == 'monthly')
                document.getElementById('period-month').checked = true;
            @endif
            
            customDateRange.style.display = 'none';
            activeFilters.classList.remove('has-filters');
            activeFilters.innerHTML = '';
        });
    }
    
    function updateActiveFilters() {
        const filters = [];
        
        // Time period
        const timePeriod = document.querySelector('input[name="timePeriod"]:checked');
        if (timePeriod && timePeriod.id !== 'period-month') {
            filters.push({
                type: 'timePeriod',
                text: timePeriod.id === 'period-today' ? 'Today' : 
                      timePeriod.id === 'period-week' ? 'This Week' : 'Custom Range'
            });
        }
        
        // Status
        const statuses = [];
        if (!document.getElementById('status-completed').checked) statuses.push('Completed');
        if (!document.getElementById('status-cancelled').checked) statuses.push('Cancelled');
        if (statuses.length > 0) {
            filters.push({
                type: 'status',
                text: 'Excluding: ' + statuses.join(', ')
            });
        }
        
        // Payment methods
        if (!document.getElementById('payment-all').checked) {
            const methods = [];
            if (document.getElementById('payment-cash').checked) methods.push('Cash');
            if (document.getElementById('payment-card').checked) methods.push('Card');
            if (document.getElementById('payment-digital').checked) methods.push('Digital Wallet');
            if (methods.length > 0) {
                filters.push({
                    type: 'payment',
                    text: 'Payment: ' + methods.join(', ')
                });
            }
        }
        
        // Update active filters display
        if (filters.length > 0) {
            activeFilters.classList.add('has-filters');
            activeFilters.innerHTML = filters.map(filter => 
                `<div class="filter-tag">
                    <span>${filter.text}</span>
                    <button class="filter-tag-remove" data-type="${filter.type}">×</button>
                </div>`
            ).join('');
            
            // Add remove functionality
            document.querySelectorAll('.filter-tag-remove').forEach(btn => {
                btn.addEventListener('click', function() {
                    const type = this.dataset.type;
                    if (type === 'timePeriod') {
                        document.getElementById('period-month').checked = true;
                    } else if (type === 'status') {
                        document.getElementById('status-completed').checked = true;
                        document.getElementById('status-cancelled').checked = true;
                    } else if (type === 'payment') {
                        document.getElementById('payment-all').checked = true;
                    }
                    updateActiveFilters();
                });
            });
        } else {
            activeFilters.classList.remove('has-filters');
            activeFilters.innerHTML = '';
        }
    }
    
    // Show success/error messages
    @if(session('success'))
        showAlert('success', '{{ session('success') }}');
    @endif
    
    @if(session('error'))
        showAlert('error', '{{ session('error') }}');
    @endif
    
    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.style.position = 'fixed';
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '1050';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
});
</script>
</body>
</html>
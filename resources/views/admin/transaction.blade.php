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

    /* Sidebar - identical to Accounts */
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

    /* Mobile */
    .sidebar-toggle { display: none; position: fixed; top: 15px; left: 15px; z-index: 1001;
      background: var(--primary-color); color: white; border: none; border-radius: 8px;
      width: 40px; height: 40px; font-size: 1.2rem; }
    .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; }

    /* Content */
    .content-wrap { margin-left: 240px; padding: 28px; transition: all 0.3s ease; }
    .topbar { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 22px; }
    .page-title-section h4 { margin-bottom: 4px; }
    
    /* ========== USER SECTION STYLES ========== */
    .user-section {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 16px;
      min-width: 300px;
    }
    
    .user-info {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    
    .user-details {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }
    
    .user-name {
      font-weight: 600;
      font-size: 1rem;
      line-height: 1.2;
    }
    
    .user-role {
      color: var(--secondary-color);
      font-size: 0.875rem;
      line-height: 1.2;
    }
    
    .user-avatar {
      width: 44px;
      height: 44px;
      border-radius: 10px;
      object-fit: cover;
    }
    
    /* User dropdown for sign out */
    .user-dropdown {
      position: relative;
    }
    
    .user-dropdown-toggle {
      background: none;
      border: none;
      display: flex;
      align-items: center;
      gap: 12px;
      cursor: pointer;
      padding: 8px;
      border-radius: 8px;
      transition: background 0.2s;
    }
    
    .user-dropdown-toggle:hover {
      background: #f8f9fa;
    }
    
    .user-dropdown-menu {
      position: absolute;
      top: 100%;
      right: 0;
      background: white;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 8px 0;
      min-width: 150px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      z-index: 1000;
      margin-top: 8px;
      display: none;
    }
    
    .user-dropdown-item {
      padding: 8px 16px;
      display: flex;
      align-items: center;
      gap: 8px;
      color: #5b5f72;
      text-decoration: none;
      transition: background 0.2s;
      border: none;
      background: none;
      width: 100%;
      text-align: left;
      cursor: pointer;
    }
    
    .user-dropdown-item:hover {
      background: #f8f9fa;
      color: var(--primary-color);
    }

    /* ========== FILTER & SEARCH STYLES ========== */
    .search-filter-section {
      display: flex;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap;
      justify-content: space-between;
      width: 100%;
    }

    /* Filter container styling */
    .filter-container {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 8px;
      width: 100%;
    }

    /* Search and filter in one line */
    .search-filter-row {
      display: flex;
      align-items: center;
      gap: 12px;
      width: 100%;
      flex-wrap: nowrap;
    }

    /* Search input takes available space */
    .search-input {
      flex: 1;
      min-width: 250px;
      max-width: 500px;
    }

    /* Filter dropdown styling */
    .filter-dropdown {
      position: relative;
      flex-shrink: 0;
    }

    /* Filter toggle button */
    .filter-toggle {
      background: #fff;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 10px 16px;
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      white-space: nowrap;
      transition: all 0.2s ease;
    }

    .filter-toggle:hover {
      background: #f8f9fa;
      border-color: #adb5bd;
    }

    .filter-toggle.active {
      background: var(--primary-color);
      color: white;
      border-color: var(--primary-color);
    }

    /* Filter menu */
    .filter-menu {
      position: absolute;
      top: 100%;
      right: 0;
      background: white;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 20px;
      min-width: 300px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.15);
      margin-top: 8px;
      display: none;
      z-index: 1000;
    }

    .filter-menu.show {
      display: block;
    }

    /* Filter sections */
    .filter-section { 
      margin-bottom: 16px; 
    }

    .filter-section:last-child { 
      margin-bottom: 0; 
    }

    .filter-section-title { 
      font-weight: 600; 
      font-size: 0.875rem; 
      margin-bottom: 8px; 
      color: var(--primary-color); 
    }

    .filter-option { 
      display: flex; 
      align-items: center; 
      gap: 8px; 
      padding: 6px 0; 
      cursor: pointer; 
    }

    .filter-option label { 
      cursor: pointer; 
      font-size: 0.875rem; 
      margin: 0; 
    }

    .filter-actions { 
      display: flex; 
      gap: 8px; 
      margin-top: 12px; 
      padding-top: 12px; 
      border-top: 1px solid #eef2f7; 
    }

    .btn-apply, .btn-clear { 
      flex: 1; 
      border: none; 
      padding: 8px 16px; 
      border-radius: 4px; 
      font-size: 0.875rem; 
      cursor: pointer; 
    }

    .btn-apply { 
      background: var(--primary-color); 
      color: white; 
    }

    .btn-apply:hover { 
      background: #2a2265; 
    }

    .btn-clear { 
      background: var(--secondary-color); 
      color: white; 
    }

    .btn-clear:hover { 
      background: #5a6268; 
    }

    /* Active filters */
    .active-filters { 
      display: none; 
      align-items: center; 
      gap: 8px; 
      margin-bottom: 16px; 
      flex-wrap: wrap; 
      width: 100%; 
      justify-content: flex-end; 
    }

    .active-filters.has-filters { 
      display: flex; 
    }

    .filter-tag { 
      background: #e9ecef; 
      border: 1px solid #dee2e6; 
      border-radius: 16px; 
      padding: 4px 12px;
      font-size: 0.8rem; 
      display: flex; 
      align-items: center; 
      gap: 6px; 
    }

    .filter-tag-remove { 
      background: none; 
      border: none; 
      cursor: pointer; 
      color: var(--secondary-color);
      padding: 0; 
      width: 16px; 
      height: 16px; 
      display: flex; 
      align-items: center; 
      justify-content: center; 
    }

    /* Date inputs */
    .date-inputs {
      display: flex;
      gap: 8px;
      margin-top: 8px;
    }

    .date-input {
      flex: 1;
    }

    .date-input input {
      width: 100%;
      padding: 6px 8px;
      border: 1px solid #dee2e6;
      border-radius: 4px;
      font-size: 0.875rem;
    }

    /* Table */
    .table-card { border-radius: 12px; border: none; box-shadow: var(--card-shadow); overflow: hidden; }
    .table th { 
      border-top: none; 
      font-weight: 600; 
      color: #5b5f72; 
      font-size: 0.85rem; 
      text-transform: uppercase;
      letter-spacing: 0.5px; 
      padding: 12px 16px; 
      white-space: nowrap; 
    }
    
    .table td { 
      padding: 16px; 
      vertical-align: middle; 
      border-color: #f1f3f4; 
    }
    
    .status-badge { 
      padding: 6px 12px; 
      border-radius: 20px; 
      font-size: 0.75rem; 
      font-weight: 500; 
      white-space: nowrap; 
    }
    
    .status-completed { 
      background: #e8f5e8; 
      color: #23b07a; 
    }
    
    .status-cancelled { 
      background: #fde8e8; 
      color: #e05252; 
    }

    /* Transaction details modal */
    .transaction-details-modal .modal-body {
      max-height: 70vh;
      overflow-y: auto;
    }

    .transaction-item {
      border-bottom: 1px solid #eef2f7;
      padding: 12px 0;
    }

    .transaction-item:last-child {
      border-bottom: none;
    }

    .item-name {
      font-weight: 600;
      margin-bottom: 4px;
    }

    .item-details {
      display: flex;
      justify-content: space-between;
      color: #6c757d;
      font-size: 0.875rem;
    }

    .transaction-summary {
      background-color: #f8f9fa;
      border-radius: 8px;
      padding: 16px;
      margin-top: 20px;
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
    }

    .summary-row.total {
      font-weight: 600;
      font-size: 1.1rem;
      border-top: 1px solid #dee2e6;
      padding-top: 12px;
      margin-top: 12px;
    }

    /* Empty state */
    .empty-state {
      text-align: center;
      padding: 60px 20px;
    }

    .empty-state i {
      font-size: 4rem;
      color: #dee2e6;
      margin-bottom: 16px;
    }

    .empty-state h5 {
      color: #6c757d;
      margin-bottom: 8px;
    }

    .empty-state p {
      color: #adb5bd;
      margin-bottom: 0;
    }

    /* Responsive */
    @media (max-width: 991.98px) {
      .sidebar { transform: translateX(-100%); width: 280px; box-shadow: 2px 0 10px rgba(0,0,0,0.1); }
      .sidebar.mobile-open { transform: translateX(0); }
      .sidebar-toggle, .sidebar-overlay { display: flex !important; }
      .content-wrap { margin-left: 0; padding: 70px 16px 16px; }
      .topbar { flex-direction: column; align-items: stretch; }
      .user-section, .filter-container { align-items: stretch; min-width: 100%; }
      .search-input { min-width: 100%; }
      .filter-menu { right: auto; left: 0; }
    }
  </style>
</head>
<body>

@php
    // Get employee data
    $user = Auth::user() ?? null;
    $employeeName = 'Admin'; // Default
    $employeeId = null;
    
    if ($user) {
        if (isset($user->employee) && $user->employee) {
            $employeeName = $user->employee->EmployeeName ?? 
                           ($user->employee->EmployeeFName . ' ' . $user->employee->EmployeeLName) ?? 
                           $user->name;
            $employeeId = $user->employee->EmployeeID ?? null;
        }
        elseif (isset($user->EmployeeName)) {
            $employeeName = $user->EmployeeName;
            $employeeId = $user->EmployeeID ?? null;
        }
        else {
            $employeeName = $user->name ?? 'Admin';
        }
    }

    // Get orders data from controller
    $orders = $orders ?? collect([]);
    $totalAmount = $totalAmount ?? 0;
    $totalOrders = $totalOrders ?? $orders->count();
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
      <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
      <a class="nav-link" href="{{ route('admin.accounts') }}"><i class="fas fa-user-circle"></i> <span>Accounts</span></a>

      <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#recordsSubmenu">
        <i class="fas fa-archive"></i> <span>Records</span>
      </a>
      <div class="collapse" id="recordsSubmenu">
        <div class="nav flex-column ms-3">
          <a class="nav-link" href="{{ route('admin.supplier') }}"><i class="fas fa-truck"></i> Suppliers</a>
          <a class="nav-link" href="{{ route('admin.employees') }}"><i class="fas fa-users"></i> Employees</a>
          <a class="nav-link" href="{{ route('admin.products') }}"><i class="fas fa-box"></i> Products</a>
        </div>
      </div>

      <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#transactionsSubmenu">
        <i class="fas fa-exchange-alt"></i> <span>Inventory</span>
      </a>
      <div class="collapse" id="transactionsSubmenu">
        <div class="nav flex-column ms-3">
          <a class="nav-link" href="{{ route('admin.stockin') }}"><i class="fas fa-arrow-circle-down"></i> Stock In</a>
          <a class="nav-link" href="{{ route('admin.pullout') }}"><i class="fas fa-arrow-circle-up"></i> Pullouts</a>
        </div>
      </div>

      <a class="nav-link dropdown-toggle active" href="#" data-bs-toggle="collapse" data-bs-target="#reportsSubmenu">
        <i class="fas fa-chart-bar"></i> <span>Reports</span>
      </a>
      <div class="collapse show" id="reportsSubmenu">
        <div class="nav flex-column ms-3">
          <a class="nav-link active" href="{{ route('admin.transaction') }}"><i class="fas fa-file-invoice-dollar"></i> Transaction</a>
          <a class="nav-link" href="{{ route('admin.inventory') }}"><i class="fas fa-clipboard-list"></i> Inventory</a>
        </div>
      </div>
    </nav>
  </div>
</aside>

<main class="content-wrap" id="contentWrap">
  <div class="topbar">
    <div class="page-title-section">
      <h4 class="mb-1">Transaction Report</h4>
    </div>

    <div class="user-section">
      <div class="user-dropdown">
        <button class="user-dropdown-toggle" id="userDropdownToggle">
          <img src="{{ asset('images/logo_.png') }}" alt="avatar" class="user-avatar">
          <div class="user-details">
            <div class="user-name">{{ $employeeName }}</div>
            <div class="user-role">
              @if($employeeId)
                Admin
              @endif
            </div>
          </div>
          <i class="fas fa-chevron-down" style="font-size: 0.8rem;"></i>
        </button>
        
        <div class="user-dropdown-menu" id="userDropdownMenu">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="user-dropdown-item">
              <i class="fas fa-sign-out-alt me-2"></i> Sign Out
            </button>
          </form>
        </div>
      </div>

      <div class="filter-container">
        <form method="GET" action="{{ route('admin.transaction') }}" class="search-filter-section" id="filterForm">
          <div class="search-filter-row">
            <div class="input-group search-input">
              <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
              <input type="text" class="form-control" name="search" placeholder="Search transactions..." id="searchInput" value="{{ request('search') }}">
            </div>

            <div class="filter-dropdown">
              <button type="button" class="filter-toggle" id="filterToggle">
                <i class="fas fa-filter"></i> <span>Filter</span>
                <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
              </button>
              
              <div class="filter-menu" id="filterMenu">
                <div class="filter-section">
                  <div class="filter-section-title">Time Period</div>
                  <div class="filter-options">
                    <div class="filter-option">
                      <input type="radio" name="time_period" id="period-today" value="today" {{ request('time_period') == 'today' ? 'checked' : '' }}>
                      <label for="period-today">Today</label>
                    </div>
                    <div class="filter-option">
                      <input type="radio" name="time_period" id="period-week" value="week" {{ !request('time_period') || request('time_period') == 'week' ? 'checked' : '' }}>
                      <label for="period-week">This Week</label>
                    </div>
                    <div class="filter-option">
                      <input type="radio" name="time_period" id="period-month" value="month" {{ request('time_period') == 'month' ? 'checked' : '' }}>
                      <label for="period-month">This Month</label>
                    </div>
                    <div class="filter-option">
                      <input type="radio" name="time_period" id="period-custom" value="custom" {{ request('time_period') == 'custom' ? 'checked' : '' }}>
                      <label for="period-custom">Custom Range</label>
                    </div>
                  </div>
                  
                  <div class="date-inputs" id="customDateRange" style="{{ request('time_period') == 'custom' ? 'display: flex;' : 'display: none;' }}">
                    <div class="date-input">
                      <input type="date" name="start_date" id="dateFrom" value="{{ request('start_date') }}" placeholder="From Date">
                    </div>
                    <div class="date-input">
                      <input type="date" name="end_date" id="dateTo" value="{{ request('end_date') }}" placeholder="To Date">
                    </div>
                  </div>
                </div>
                
                <div class="filter-section">
                  <div class="filter-section-title">Transaction Status</div>
                  <div class="filter-options">
                    <div class="filter-option">
                      <input type="checkbox" name="status[]" id="status-completed" value="completed" {{ in_array('completed', request('status', [])) || !request('status') ? 'checked' : '' }}>
                      <label for="status-completed">Completed</label>
                    </div>
                    <div class="filter-option">
                      <input type="checkbox" name="status[]" id="status-cancelled" value="cancelled" {{ in_array('cancelled', request('status', [])) || !request('status') ? 'checked' : '' }}>
                      <label for="status-cancelled">Cancelled</label>
                    </div>
                  </div>
                </div>
                
                <div class="filter-section">
                  <div class="filter-section-title">Payment Method</div>
                  <div class="filter-options">
                    <div class="filter-option">
                      <input type="checkbox" name="payment_method[]" id="payment-cash" value="Cash" {{ in_array('Cash', request('payment_method', [])) || !request('payment_method') ? 'checked' : '' }}>
                      <label for="payment-cash">Cash</label>
                    </div>
                    <div class="filter-option">
                      <input type="checkbox" name="payment_method[]" id="payment-card" value="Card" {{ in_array('Card', request('payment_method', [])) || !request('payment_method') ? 'checked' : '' }}>
                      <label for="payment-card">Card</label>
                    </div>
                    <div class="filter-option">
                      <input type="checkbox" name="payment_method[]" id="payment-online" value="Online" {{ in_array('Online', request('payment_method', [])) || !request('payment_method') ? 'checked' : '' }}>
                      <label for="payment-online">Online</label>
                    </div>
                  </div>
                </div>
                
                <div class="filter-actions">
                  <button type="submit" class="btn-apply" id="applyFilters">Apply Filters</button>
                  <button type="button" class="btn-clear" id="clearFilters">Reset Filters</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        
        <div class="active-filters {{ request()->except('page') ? 'has-filters' : '' }}" id="activeFilters">
          @if(request()->except('page'))
            <span class="text-muted">Active filters:</span>
            @foreach(request()->except('page') as $key => $value)
              @if(!empty($value))
                <div class="filter-tag">
                  {{ $key }}: {{ is_array($value) ? implode(', ', $value) : $value }}
                  <button type="button" class="filter-tag-remove" data-filter="{{ $key }}">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              @endif
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>

  {{-- Alerts --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
      <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
      <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="card table-card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h5 class="card-title mb-0">Transaction History</h5>
        <div class="d-flex gap-2">
          <a href="{{ route('admin.transaction.export', ['type' => 'csv']) . '?' . http_build_query(request()->except('page')) }}" class="btn btn-success">
            <i class="fas fa-file-csv me-1"></i> Export CSV
          </a>
          <a href="{{ route('admin.transaction.export', ['type' => 'pdf']) . '?' . http_build_query(request()->except('page')) }}" class="btn btn-danger">
            <i class="fas fa-file-pdf me-1"></i> Export PDF
          </a>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle" id="transactionTable">
          <thead class="table-light">
            <tr>
              <th>Transaction ID</th>
              <th>Cashier</th>
              <th>Items</th>
              <th>Amount</th>
              <th>Payment</th>
              <th>Status</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="transactionTableBody">
            @forelse($orders as $order)
            <tr data-status="{{ $order->OrderStatus }}" 
                data-payment="{{ $order->PaymentMethod }}"
                data-date="{{ $order->OrderDateTime }}">
              <td><strong>#{{ $order->OrderID }}</strong></td>
              <td>
                <div class="fw-semibold">
                  {{ $order->employee->EmployeeFName ?? 'System' }} {{ $order->employee->EmployeeLName ?? '' }}
                </div>
                @if($order->employee?->EmployeeID)
                  <small class="text-muted">ID: {{ $order->employee->EmployeeID }}</small>
                @endif
              </td>
              <td>{{ $order->items->count() }} items</td>
              <td><strong>₱{{ number_format($order->TotalAmount, 2) }}</strong></td>
              <td>
                @php
                  $paymentMethod = $order->PaymentMethod ?? 'Cash';
                  $paymentBadgeClass = '';
                  if($paymentMethod == 'Cash') $paymentBadgeClass = 'bg-success';
                  elseif($paymentMethod == 'Card') $paymentBadgeClass = 'bg-info';
                  elseif($paymentMethod == 'Online') $paymentBadgeClass = 'bg-primary';
                  elseif($paymentMethod == 'GCash') $paymentBadgeClass = 'bg-primary';
                @endphp
                <span class="badge {{ $paymentBadgeClass }}">{{ $paymentMethod }}</span>
              </td>
              <td>
                @if($order->OrderStatus === 'Completed')
                  <span class="status-badge status-completed">Completed</span>
                @elseif($order->OrderStatus === 'Cancelled')
                  <span class="status-badge status-cancelled">Cancelled</span>
                @else
                  <span class="status-badge">{{ $order->OrderStatus }}</span>
                @endif
              </td>
              <td>
                <div>{{ \Carbon\Carbon::parse($order->OrderDateTime)->format('M d, Y') }}</div>
                <small class="text-muted">{{ \Carbon\Carbon::parse($order->OrderDateTime)->format('h:i A') }}</small>
              </td>
              <td>
                <div class="action-buttons">
                  {{-- View Details Button --}}
                  <button class="btn btn-sm btn-outline-primary view-transaction" 
                          data-bs-toggle="modal" 
                          data-bs-target="#viewTransactionModal"
                          data-order-id="{{ $order->OrderID }}">
                    <i class="fas fa-eye"></i>
                  </button>
                  
                  {{-- Print Receipt Button --}}
                  <button class="btn btn-sm btn-outline-secondary print-receipt" 
                          data-order-id="{{ $order->OrderID }}">
                    <i class="fas fa-print"></i>
                  </button>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-5">
                <div class="empty-state">
                  <i class="fas fa-file-invoice-dollar fa-2x mb-3"></i>
                  <h5>No transaction records found</h5>
                  <p class="mb-0">Transactions will appear here once made</p>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
          Total: {{ $orders->total() }} transaction(s) | 
          Showing: {{ $orders->firstItem() ?? 0 }}-{{ $orders->lastItem() ?? 0 }} |
          Total Amount: <strong>₱{{ number_format($totalAmount, 2) }}</strong>
        </div>
        
        {{-- Pagination --}}
        @if($orders->hasPages())
          <nav>
            {{ $orders->withQueryString()->links() }}
          </nav>
        @endif
      </div>
    </div>
  </div>
</main>

<!-- View Transaction Modal -->
<div class="modal fade transaction-details-modal" id="viewTransactionModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-3">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold"><i class="fas fa-file-invoice-dollar me-2"></i>Transaction Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="transactionDetailsContent">
        <!-- Content will be loaded dynamically -->
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary print-receipt-modal">
          <i class="fas fa-print me-1"></i> Print Receipt
        </button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Sidebar functionality
  const sidebar = document.getElementById('sidebar');
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebarOverlay = document.getElementById('sidebarOverlay');
  
  sidebarToggle.addEventListener('click', () => {
    sidebar.classList.toggle('mobile-open');
    sidebarOverlay.classList.toggle('active');
  });
  
  sidebarOverlay.addEventListener('click', () => {
    sidebar.classList.remove('mobile-open');
    sidebarOverlay.classList.remove('active');
  });
  
  // User dropdown
  document.getElementById('userDropdownToggle')?.addEventListener('click', function(e) {
    e.stopPropagation();
    const menu = document.getElementById('userDropdownMenu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
  });
  
  document.addEventListener('click', function() {
    document.getElementById('userDropdownMenu').style.display = 'none';
  });
  
  // Filter functionality
  const filterToggle = document.getElementById('filterToggle');
  const filterMenu = document.getElementById('filterMenu');
  const filterForm = document.getElementById('filterForm');
  
  filterToggle?.addEventListener('click', function(e) {
    e.stopPropagation();
    const visible = filterMenu.style.display === 'block';
    filterMenu.style.display = visible ? 'none' : 'block';
    filterToggle.classList.toggle('active', !visible);
  });
  
  document.addEventListener('click', function() {
    filterMenu.style.display = 'none';
    filterToggle.classList.remove('active');
  });
  
  filterMenu?.addEventListener('click', function(e) {
    e.stopPropagation();
  });
  
  // Show/hide custom date range
  document.querySelectorAll('input[name="time_period"]').forEach(radio => {
    radio.addEventListener('change', function() {
      const customDateRange = document.getElementById('customDateRange');
      if (this.value === 'custom') {
        customDateRange.style.display = 'flex';
      } else {
        customDateRange.style.display = 'none';
        document.getElementById('dateFrom').value = '';
        document.getElementById('dateTo').value = '';
      }
    });
  });
  
  // Clear filters button
  document.getElementById('clearFilters')?.addEventListener('click', function() {
    // Reset form and submit
    filterForm.reset();
    // Set default time period
    document.getElementById('period-week').checked = true;
    document.getElementById('customDateRange').style.display = 'none';
    
    // Remove all query parameters and submit
    const url = new URL(window.location.href);
    url.search = '';
    window.location.href = url.toString();
  });
  
  // Remove individual filter tags
  document.querySelectorAll('.filter-tag-remove').forEach(button => {
    button.addEventListener('click', function() {
      const filterName = this.dataset.filter;
      const url = new URL(window.location.href);
      url.searchParams.delete(filterName);
      window.location.href = url.toString();
    });
  });
  
  // View order details
  document.querySelectorAll('.view-transaction').forEach(button => {
    button.addEventListener('click', function() {
      const orderId = this.dataset.orderId;
      
      // Show loading
      document.getElementById('transactionDetailsContent').innerHTML = `
        <div class="text-center py-5">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <p class="mt-2">Loading transaction details...</p>
        </div>
      `;
      
      // Load order details via AJAX
      fetch(`/admin/transaction/${orderId}/details`)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.text();
        })
        .then(html => {
          document.getElementById('transactionDetailsContent').innerHTML = html;
          
          // Store order ID for print button
          document.querySelector('.print-receipt-modal').dataset.orderId = orderId;
        })
        .catch(error => {
          console.error('Error:', error);
          document.getElementById('transactionDetailsContent').innerHTML = 
            '<div class="alert alert-danger">Error loading transaction details. Please try again.</div>';
        });
    });
  });
  
  // Print receipt (table button)
  document.querySelectorAll('.print-receipt').forEach(button => {
    button.addEventListener('click', function() {
      const orderId = this.dataset.orderId;
      printReceipt(orderId);
    });
  });
  
  // Print receipt (modal button)
  document.querySelector('.print-receipt-modal')?.addEventListener('click', function() {
    const orderId = this.dataset.orderId;
    if (orderId) {
      printReceipt(orderId);
    }
  });
  
  function printReceipt(orderId) {
    // Open print window with receipt
    const url = `/admin/transaction/${orderId}/receipt`;
    const printWindow = window.open(url, '_blank');
    
    setTimeout(() => {
      if (printWindow) {
        printWindow.print();
      } else {
        alert('Please allow pop-ups to print receipts');
      }
    }, 500);
  }
  
  // Auto-hide alerts after 5 seconds
  setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
      const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
      bsAlert.close();
    });
  }, 5000);
});
</script>
</body>
</html>
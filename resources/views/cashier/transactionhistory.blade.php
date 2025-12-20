<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Transaction History | Dora's Oshopee</title>
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
    .brand { display: flex; align-items: center; gap: 10px; margin-bottom: 18px; flex-shrink: 0; }
    .brand img { width: 100px; height: auto; object-fit: contain; }
    .sidebar .nav-link {
      color: #5b5f72; padding: 10px 8px; border-radius: 10px;
      font-size: 0.95rem; display: flex; align-items: center;
      transition: all 0.2s ease;
    }
    .sidebar .nav-link.active { background: #efeaff; color: var(--primary-color); font-weight: 600; }
    .sidebar .nav-link:hover { background: #f8f9fa; }
    .sidebar .nav-link i { width: 20px; margin-right: 10px; text-align: center; }
    .sidebar-nav { flex: 1; overflow-y: auto; overflow-x: hidden; margin-top: 18px; }
    .nav.flex-column.ms-3 { border-left: 2px solid #eef2f7; margin-left: 12px !important; padding-left: 8px; }
    .nav.flex-column.ms-3 .nav-link { padding: 10px 12px; font-size: 0.9rem; border-radius: 6px; }

    /* Mobile sidebar toggle */
    .sidebar-toggle { display: none; position: fixed; top: 15px; left: 15px; z-index: 1001;
      background: var(--primary-color); color: white; border: none; border-radius: 8px;
      width: 40px; height: 40px; font-size: 1.2rem; }
    .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0,0,0,0.5); z-index: 999; }
    .sidebar-overlay.active { display: block; }

    /* Main content */
    .content-wrap { margin-left: 240px; padding: 28px; transition: all 0.3s ease; }
    .topbar { 
      display: flex; 
      justify-content: space-between; 
      flex-wrap: wrap; 
      gap: 16px; 
      margin-bottom: 22px; 
      align-items: flex-start;
    }
    .page-title-section h4 { margin-bottom: 4px; }
           
    /* User section */
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

    /* Search & filter section */
    .search-filter-section {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: space-between;
        width: 100%;
    }

    .filter-container {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
        width: 100%;
    }

    .search-filter-row {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        flex-wrap: nowrap;
    }

    .search-input {
        flex: 1;
        min-width: 250px;
        max-width: 500px;
    }

    .filter-dropdown {
        position: relative;
        flex-shrink: 0;
    }

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
    
    .filter-options {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    
    .filter-option {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 0;
        cursor: pointer;
    }
    
    .filter-option input[type="checkbox"],
    .filter-option input[type="radio"] {
        margin: 0;
    }
    
    .filter-option label {
        cursor: pointer;
        font-size: 0.875rem;
        margin: 0;
    }
    
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
    
    .filter-actions {
        display: flex;
        gap: 8px;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #eef2f7;
        flex-wrap: nowrap;
        justify-content: space-between;
    }

    .btn-apply, .btn-clear {
        flex: 1;
        min-width: 0;
        white-space: nowrap;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 0.875rem;
        cursor: pointer;
        transition: background 0.2s;
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

    /* Active filter indicator */
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

    .filter-container {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
        margin-top: 20px;
    }

    /* Date picker */
    .date-picker-container {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Table */
    .table-card { 
        border-radius: 12px; 
        border: none; 
        box-shadow: var(--card-shadow); 
        overflow: hidden; 
        background: white;
        padding: 24px;
    }
    .table { border: none; }
    .table th { 
        font-weight: 600; 
        color: #5b5f72; 
        font-size: 0.85rem; 
        text-transform: uppercase;
        letter-spacing: 0.5px; 
        padding: 12px 16px; 
        white-space: nowrap; 
        border-bottom: 2px solid #eef2f7;
    }
    .table td { 
        padding: 16px; 
        vertical-align: middle; 
        border-color: #f1f3f4; 
        border-bottom: 1px solid #f1f3f4;
    }
    .table tbody tr:hover { background-color: #f8f9fa; }
    
    /* Status text colors */
    .status-text {
        font-weight: 600;
    }
    
    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 30px;
    }

    /* Alert styles */
    .alert {
        border: none;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 16px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .alert-warning {
        background: #fff3cd;
        color: #856404;
        border-left: 4px solid #ffc107;
    }
    
    .alert-info {
        background: #d1ecf1;
        color: #0c5460;
        border-left: 4px solid #17a2b8;
    }

    /* Responsive design */
    @media (max-width: 991.98px) {
        .sidebar { 
            transform: translateX(-100%); 
            width: 280px; 
            box-shadow: 2px 0 10px rgba(0,0,0,0.1); 
        }
        .sidebar.mobile-open { transform: translateX(0); }
        .sidebar-toggle, .sidebar-overlay { display: block; }
        .content-wrap { 
            margin-left: 0; 
            padding: 70px 16px 16px; 
        }
        .topbar { 
            flex-direction: column; 
            align-items: stretch; 
        }
        .user-section, .filter-container { 
            align-items: stretch; 
            min-width: 100%; 
        }
        .search-input { 
            min-width: 100%; 
            max-width: 100%; 
        }
        
        .search-filter-row {
            flex-wrap: wrap;
        }
        
        .search-input {
            max-width: 100%;
            min-width: 100%;
        }
        
        .filter-toggle {
            width: 100%;
            justify-content: center;
        }
        
        .filter-menu {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 400px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .user-dropdown-toggle {
            justify-content: space-between;
        }

        .user-details {
            align-items: flex-start;
            text-align: left;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .table th, .table td {
            padding: 12px 10px;
            font-size: 0.85rem;
        }
    }

    @media (max-width: 767.98px) {
        .content-wrap { 
            padding: 70px 12px 12px; 
        }
        
        .table-card {
            padding: 16px;
        }
        
        .table th, .table td {
            padding: 10px 8px;
            font-size: 0.8rem;
        }
        
        .date-picker-container .input-group {
            flex-direction: column;
        }
        
        .date-picker-container .btn {
            width: 100%;
            margin-top: 8px;
        }
        
        .search-filter-section {
            flex-direction: column;
            align-items: stretch;
        }
        
        .date-picker-container,
        .filter-dropdown {
            width: 100%;
        }
        
        .date-picker-container .input-group {
            width: 100%;
        }
        
        .user-dropdown-toggle {
            padding: 12px;
        }
    }

    @media (max-width: 575.98px) {
        .content-wrap { 
            padding: 70px 8px 8px; 
        }
        
        .table th, .table td { 
            padding: 8px 6px; 
            font-size: 0.75rem; 
        }
        
        /* Hide less important columns on small screens */
        .table th:nth-child(5), .table td:nth-child(5),
        .table th:nth-child(6), .table td:nth-child(6) {
            display: none;
        }
        
        .pagination .page-link {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .page-title-section h4 {
            font-size: 1.25rem;
        }
        
        .user-name {
            font-size: 0.9rem;
        }
        
        .user-role {
            font-size: 0.75rem;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
        }
    }

    @media (max-width: 375px) {
        .table th:nth-child(3), .table td:nth-child(3) {
            display: none;
        }
        
        .brand img {
            width: 60px;
        }
        
        .sidebar {
            padding: 16px 12px;
        }
    }
  </style>
</head>
<body>

<!-- PHP CODE: GET EMPLOYEE DATA -->
@php
    $user = Auth::user() ?? null;
    $employeeName = 'Cashier';
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
            $employeeName = $user->name ?? 'Cashier';
        }
    }
@endphp

<!-- MOBILE SIDEBAR TOGGLE -->
<button class="sidebar-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <div class="brand">
        <img src="{{ asset('images/logo_.png') }}" alt="Logo">
        <div>
            <div style="font-weight:600">Dora's Oshoppe</div>
            <small class="text-muted">Gift Shop</small>
        </div>
    </div>

    <div class="sidebar-nav">
        <nav class="nav flex-column">
            <!-- DASHBOARD LINK -->
            <a class="nav-link " href="{{ route('cashier.dashboard') }}">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>

            <!-- TRANSACTIONS DROPDOWN -->
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#salesSubmenu">
                <i class="fas fa-cash-register me-2"></i> Transactions
            </a>
            <div class="collapse show" id="salesSubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link" href="{{ route('cashier.sales') }}">
                        <i class="fas fa-shopping-bag me-2"></i> Sales
                    </a>
                    <a class="nav-link active" href="{{ route('cashier.transaction.history') }}">
                        <i class="fas fa-history me-2"></i> Transaction History
                    </a>
                </div>
            </div>

            <!-- REPORTS DROPDOWN -->
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#reportsSubmenu">
                <i class="fas fa-chart-bar me-2"></i> Reports
            </a>
            <div class="collapse" id="reportsSubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link" href="{{ route('cashier.daily.sales') }}">
                        <i class="fas fa-chart-line me-2"></i> Daily Sales
                    </a>
                </div>
            </div>
        </nav>
    </div>
</aside>

<!-- MAIN CONTENT -->
<main class="content-wrap" id="contentWrap">
    <!-- TOP HEADER: TITLE + USER -->
    <div class="topbar">
        <div class="page-title-section">
            <h4 class="mb-1">Transaction History</h4>
            <small class="text-muted">Complete order and payment records</small>
        </div>

        <div class="user-section">
            <!-- USER INFO SECTION -->
            <div class="user-dropdown">
                <button class="user-dropdown-toggle" id="userDropdownToggle">
                    <img src="{{ asset('images/logo_.png') }}" alt="avatar" class="user-avatar">
                    <div class="user-details">
                        <div class="user-name">{{ $employeeName }}</div>
                        <div class="user-role">
                            @if($employeeId)
                                 Cashier
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
            
            <!-- FILTER CONTAINER -->
            <div class="filter-container">
                <!-- SEARCH AND FILTER SECTION -->
                <div class="search-filter-section">
                    <div class="input-group search-input">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Search by Order ID..."
                               value="{{ request('search') }}"
                               id="searchInput">
                    </div>
                    
                    <!-- DATE PICKER -->
                    <div class="date-picker-container">
                        <form method="GET" action="{{ route('cashier.transaction.history') }}" id="dateFilterForm">
                            <div class="input-group">
                                <input type="date"
                                       name="date"
                                       class="form-control"
                                       value="{{ request('date') ?? date('Y-m-d') }}"
                                       id="dateFilter">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-calendar-check"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- FILTER DROPDOWN -->
                    <div class="filter-dropdown">
                        <button class="filter-toggle" id="filterToggle">
                            <i class="fas fa-filter"></i>
                            <span>Filter</span>
                            <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
                        </button>
                        
                        <div class="filter-menu" id="filterMenu" style="display: none;">
                            <!-- TIME PERIOD FILTER -->
                            <div class="filter-section">
                                <div class="filter-section-title">Time Period</div>
                                <div class="filter-options">
                                    <div class="filter-option">
                                        <input type="radio" name="timePeriod" id="period-today" {{ request('period') == 'today' ? 'checked' : '' }}>
                                        <label for="period-today">Today</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="radio" name="timePeriod" id="period-week" {{ !request('period') || request('period') == 'week' ? 'checked' : '' }}>
                                        <label for="period-week">This Week</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="radio" name="timePeriod" id="period-month" {{ request('period') == 'month' ? 'checked' : '' }}>
                                        <label for="period-month">This Month</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="radio" name="timePeriod" id="period-all" {{ request('period') == 'all' ? 'checked' : '' }}>
                                        <label for="period-all">All Time</label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- ORDER STATUS FILTERS -->
                            <div class="filter-section">
                                <div class="filter-section-title">Order Status</div>
                                <div class="filter-options">
                                    @php
                                        $orderStatuses = request('order_status', []);
                                    @endphp
                                    <div class="filter-option">
                                        <input type="checkbox" id="status-all" {{ empty($orderStatuses) ? 'checked' : '' }}>
                                        <label for="status-all">All Status</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="status-completed" {{ in_array('Completed', $orderStatuses) ? 'checked' : '' }}>
                                        <label for="status-completed">Completed</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="status-pending" {{ in_array('Pending', $orderStatuses) ? 'checked' : '' }}>
                                        <label for="status-pending">Pending</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="status-cancelled" {{ in_array('Cancelled', $orderStatuses) ? 'checked' : '' }}>
                                        <label for="status-cancelled">Cancelled</label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- PAYMENT METHOD FILTERS -->
                            <div class="filter-section">
                                <div class="filter-section-title">Payment Methods</div>
                                <div class="filter-options">
                                    @php
                                        $paymentMethods = request('payment_method', []);
                                    @endphp
                                    <div class="filter-option">
                                        <input type="checkbox" id="method-all" {{ empty($paymentMethods) ? 'checked' : '' }}>
                                        <label for="method-all">All Methods</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="method-cash" {{ in_array('Cash', $paymentMethods) ? 'checked' : '' }}>
                                        <label for="method-cash">Cash</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="method-gcash" {{ in_array('GCash', $paymentMethods) ? 'checked' : '' }}>
                                        <label for="method-gcash">GCash</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="method-card" {{ in_array('Card', $paymentMethods) ? 'checked' : '' }}>
                                        <label for="method-card">Card</label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- PAYMENT STATUS FILTERS -->
                            <div class="filter-section">
                                <div class="filter-section-title">Payment Status</div>
                                <div class="filter-options">
                                    @php
                                        $paymentStatuses = request('payment_status', []);
                                    @endphp
                                    <div class="filter-option">
                                        <input type="checkbox" id="payment-all" {{ empty($paymentStatuses) ? 'checked' : '' }}>
                                        <label for="payment-all">All Status</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="payment-paid" {{ in_array('Paid', $paymentStatuses) ? 'checked' : '' }}>
                                        <label for="payment-paid">Paid</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="payment-unpaid" {{ in_array('Unpaid', $paymentStatuses) ? 'checked' : '' }}>
                                        <label for="payment-unpaid">Unpaid</label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- FILTER ACTION BUTTONS -->
                            <div class="filter-actions">
                                <button type="button" class="btn-apply" id="applyFilters">Apply Filters</button>
                                <button type="button" class="btn-clear" id="clearFilters">Reset Filters</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- ACTIVE FILTERS DISPLAY -->
                <div class="active-filters" id="activeFilters">
                    @if(request()->hasAny(['search', 'date', 'period', 'order_status', 'payment_method', 'payment_status']))
                        @if(request('search'))
                            <div class="filter-tag">
                                <span>Search: "{{ request('search') }}"</span>
                                <button class="filter-tag-remove" data-filter="search">×</button>
                            </div>
                        @endif
                        @if(request('date'))
                            <div class="filter-tag">
                                <span>Date: {{ request('date') }}</span>
                                <button class="filter-tag-remove" data-filter="date">×</button>
                            </div>
                        @endif
                        @if(request('period') && request('period') != 'week')
                            <div class="filter-tag">
                                <span>Period: {{ ucfirst(request('period')) }}</span>
                                <button class="filter-tag-remove" data-filter="period">×</button>
                            </div>
                        @endif
                        @if(request('order_status'))
                            @foreach(request('order_status') as $status)
                                <div class="filter-tag">
                                    <span>Order: {{ $status }}</span>
                                    <button class="filter-tag-remove" data-filter="order_status-{{ $status }}">×</button>
                                </div>
                            @endforeach
                        @endif
                        @if(request('payment_method'))
                            @foreach(request('payment_method') as $method)
                                <div class="filter-tag">
                                    <span>Method: {{ $method }}</span>
                                    <button class="filter-tag-remove" data-filter="payment_method-{{ $method }}">×</button>
                                </div>
                            @endforeach
                        @endif
                        @if(request('payment_status'))
                            @foreach(request('payment_status') as $status)
                                <div class="filter-tag">
                                    <span>Payment: {{ $status }}</span>
                                    <button class="filter-tag-remove" data-filter="payment_status-{{ $status }}">×</button>
                                </div>
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- SUCCESS/ERROR MESSAGES -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{!! session('success') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- TRANSACTION HISTORY TABLE -->
    <div class="table-card">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h5 class="card-title mb-0">Transaction Records</h5>
            <div>
                @php
                    $totalOrders = 0;
                    if(isset($orders) && method_exists($orders, 'total')) {
                        $totalOrders = $orders->total();
                    }
                @endphp
                <span class="badge bg-primary">Total: {{ $totalOrders }}</span>
                @if(request()->hasAny(['search', 'date', 'period', 'order_status', 'payment_method', 'payment_status']))
                    <a href="{{ route('cashier.transaction.history') }}" class="btn btn-outline-primary btn-sm ms-2">
                        <i class="fas fa-sync-alt"></i> Reset
                    </a>
                @endif
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
                        <th>Cashier</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders ?? [] as $order)
                        @php
                            $orderStatus = $order->OrderStatus ?? 'Pending';
                            $orderStatusClass = '';
                            if ($orderStatus == 'Completed') {
                                $orderStatusClass = 'text-success';
                            } elseif ($orderStatus == 'Cancelled') {
                                $orderStatusClass = 'text-danger';
                            } else {
                                $orderStatusClass = 'text-warning';
                            }

                            $paymentStatus = $order->payment ? ($order->payment->PaymentStatus ?? 'Unpaid') : 'Unpaid';
                            $paymentStatusClass = $paymentStatus == 'Paid' ? 'text-success' : 'text-danger';

                            $paymentMethod = $order->payment ? ($order->payment->PaymentType ?? 'Cash') : 'Cash';
                            $paymentMethodClass = '';
                            if ($paymentMethod == 'Cash') {
                                $paymentMethodClass = 'text-success';
                            } elseif ($paymentMethod == 'GCash') {
                                $paymentMethodClass = 'text-primary';
                            } else {
                                $paymentMethodClass = 'text-info';
                            }

                            $orderDate = $order->OrderDateTime ?? $order->created_at ?? now();
                            if ($orderDate instanceof \Carbon\Carbon) {
                                $formattedDate = $orderDate->format('M d, Y h:i A');
                            } else {
                                $formattedDate = \Carbon\Carbon::parse($orderDate)->format('M d, Y h:i A');
                            }

                            $totalAmount = $order->GrandTotal ?? $order->SubTotal ?? 0;
                            $formattedAmount = '₱' . number_format($totalAmount, 2);

                            $itemsCount = $order->items_count ?? ($order->orderItems->count() ?? 0);
                            if ($itemsCount == 0) {
                                $itemsCount = $order->order_items_count ?? 0;
                            }

                            $cashierName = $order->employee->EmployeeFName ?? '';
                            $cashierLastName = $order->employee->EmployeeLName ?? '';
                            if ($cashierName && $cashierLastName) {
                                $cashierName = $cashierName . ' ' . $cashierLastName;
                            } elseif ($order->employee->EmployeeName ?? false) {
                                $cashierName = $order->employee->EmployeeName;
                            } else {
                                $cashierName = 'Unknown';
                            }
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $order->OrderID ?? $order->id ?? 'N/A' }}</strong>
                            </td>
                            <td>
                                <small class="text-muted">{{ $formattedDate }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $itemsCount }} item{{ $itemsCount != 1 ? 's' : '' }}</span>
                            </td>
                            <td>
                                <strong>{{ $formattedAmount }}</strong>
                            </td>
                            <td>
                                <span class="{{ $paymentMethodClass }}">
                                    {{ $paymentMethod }}
                                </span>
                            </td>
                            <td>
                                <span class="{{ $paymentStatusClass }}">
                                    {{ $paymentStatus }}
                                </span>
                            </td>
                            <td>
                                <span class="{{ $orderStatusClass }}">
                                    {{ $orderStatus }}
                                </span>
                            </td>
                            <td>
                                <small>{{ $cashierName }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" 
                                            class="btn btn-outline-primary view-order-btn"
                                            data-order-id="{{ $order->OrderID ?? $order->id }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#orderDetailsModal">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if($order->payment)
                                        <button type="button" 
                                                class="btn btn-outline-info view-payment-btn"
                                                data-payment-id="{{ $order->payment->PaymentID }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewPaymentModal">
                                            <i class="fas fa-credit-card"></i>
                                        </button>
                                    @endif
                                    @if($orderStatus != 'Completed')
                                        <a href="{{ route('cashier.sales.edit', $order->OrderID ?? $order->id) }}" 
                                           class="btn btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-2x mb-3"></i><br>
                                    No transaction records found
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        @if(isset($orders) && $orders instanceof \Illuminate\Pagination\LengthAwarePaginator && $orders->hasPages())
            <div class="pagination-container">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <!-- PREVIOUS PAGE LINK -->
                        @if($orders->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link"><i class="fas fa-chevron-left"></i></span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $orders->previousPageUrl() }}" rel="prev">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        <!-- PAGINATION ELEMENTS -->
                        @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                            @if($page == $orders->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        <!-- NEXT PAGE LINK -->
                        @if($orders->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $orders->nextPageUrl() }}" rel="next">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link"><i class="fas fa-chevron-right"></i></span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        @endif
    </div>

    <!-- ORDER DETAILS MODAL -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="orderDetailsContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="printReceiptBtn">
                        <i class="fas fa-print"></i> Print Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- VIEW PAYMENT MODAL -->
<div class="modal fade" id="viewPaymentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Details - <span id="viewPaymentId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- PAYMENT INFORMATION -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Payment Information</h6>
                        <p class="mb-1"><strong>Payment ID:</strong> <span id="viewPaymentNo"></span></p>
                        <p class="mb-1"><strong>Order ID:</strong> <span id="viewPaymentOrderId"></span></p>
                        <p class="mb-1"><strong>Date:</strong> <span id="viewPaymentDate"></span></p>
                        <p class="mb-0"><strong>Status:</strong> <span id="viewPaymentStatus"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Payment Details</h6>
                        <p class="mb-1"><strong>Payment Method:</strong> <span id="paymentMethodType"></span></p>
                        <p class="mb-1"><strong>Reference No:</strong> <span id="viewPaymentReference"></span></p>
                        <p class="mb-0"><strong>Amount:</strong> <span id="viewPaymentAmount" class="text-success"></span></p>
                    </div>
                </div>

                <!-- ORDER ITEMS TABLE -->
                <h6>Order Items</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
                        <tbody id="viewPaymentItems"></tbody>
                    </table>
                </div>

                <!-- PAYMENT SUMMARY -->
                <div class="row mt-4">
                    <div class="col-md-6 offset-md-6">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Subtotal:</span><strong id="viewPaymentSubtotal">₱0.00</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Discount:</span><strong id="viewPaymentDiscount" class="text-danger">-₱0.00</strong>
                        </div>
                        <div class="d-flex justify-content-between mt-2 pt-2 border-top">
                            <span class="h6">Grand Total:</span><strong class="h5 text-success" id="viewPaymentGrandTotal">₱0.00</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- EXTERNAL JAVASCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- INTERNAL JAVASCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ========== SIDEBAR FUNCTIONALITY ==========
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const contentWrap = document.getElementById('contentWrap');

        function toggleSidebar() {
            sidebar.classList.toggle('mobile-open');
            sidebarOverlay.classList.toggle('active');
        }

        function closeSidebar() {
            sidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.remove('active');
        }

        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);

        // ========== USER DROPDOWN FUNCTIONALITY ==========
        const userDropdownToggle = document.getElementById('userDropdownToggle');
        const userDropdownMenu = document.getElementById('userDropdownMenu');

        if (userDropdownToggle && userDropdownMenu) {
            userDropdownToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdownMenu.style.display = 
                    userDropdownMenu.style.display === 'block' ? 'none' : 'block';
            });

            document.addEventListener('click', function(e) {
                if (!userDropdownToggle.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                    userDropdownMenu.style.display = 'none';
                }
            });
        }

        // ========== FILTER TOGGLE FUNCTIONALITY ==========
        const filterToggle = document.getElementById('filterToggle');
        const filterMenu = document.getElementById('filterMenu');

        if (filterToggle && filterMenu) {
            filterToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                filterMenu.classList.toggle('show');
                filterToggle.classList.toggle('active');
            });

            document.addEventListener('click', function(e) {
                if (!filterToggle.contains(e.target) && !filterMenu.contains(e.target)) {
                    filterMenu.classList.remove('show');
                    filterToggle.classList.remove('active');
                }
            });
        }

        // ========== FILTER FUNCTIONALITY ==========
        const applyFiltersBtn = document.getElementById('applyFilters');
        const clearFiltersBtn = document.getElementById('clearFilters');
        const searchInput = document.getElementById('searchInput');
        const dateFilter = document.getElementById('dateFilter');
        const activeFilters = document.getElementById('activeFilters');

        function buildFilterUrl() {
            const baseUrl = "{{ route('cashier.transaction.history') }}";
            const params = new URLSearchParams();
            
            if (searchInput.value) {
                params.append('search', searchInput.value);
            }
            
            if (dateFilter.value) {
                params.append('date', dateFilter.value);
            }
            
            const timePeriod = document.querySelector('input[name="timePeriod"]:checked');
            if (timePeriod && timePeriod.id !== 'period-week') {
                const periodMap = {
                    'period-today': 'today',
                    'period-week': 'week',
                    'period-month': 'month',
                    'period-all': 'all'
                };
                params.append('period', periodMap[timePeriod.id]);
            }
            
            const orderStatusFilters = [];
            const orderStatusCheckboxes = ['status-completed', 'status-pending', 'status-cancelled'];
            orderStatusCheckboxes.forEach(id => {
                const checkbox = document.getElementById(id);
                if (checkbox && checkbox.checked) {
                    const statusMap = {
                        'status-completed': 'Completed',
                        'status-pending': 'Pending',
                        'status-cancelled': 'Cancelled'
                    };
                    orderStatusFilters.push(statusMap[id]);
                }
            });
            if (orderStatusFilters.length > 0) {
                orderStatusFilters.forEach(status => {
                    params.append('order_status[]', status);
                });
            }
            
            const paymentMethodFilters = [];
            const methodCheckboxes = ['method-cash', 'method-gcash', 'method-card'];
            methodCheckboxes.forEach(id => {
                const checkbox = document.getElementById(id);
                if (checkbox && checkbox.checked) {
                    const methodMap = {
                        'method-cash': 'Cash',
                        'method-gcash': 'GCash',
                        'method-card': 'Card'
                    };
                    paymentMethodFilters.push(methodMap[id]);
                }
            });
            if (paymentMethodFilters.length > 0) {
                paymentMethodFilters.forEach(method => {
                    params.append('payment_method[]', method);
                });
            }
            
            const paymentStatusFilters = [];
            const paymentCheckboxes = ['payment-paid', 'payment-unpaid'];
            paymentCheckboxes.forEach(id => {
                const checkbox = document.getElementById(id);
                if (checkbox && checkbox.checked) {
                    const statusMap = {
                        'payment-paid': 'Paid',
                        'payment-unpaid': 'Unpaid'
                    };
                    paymentStatusFilters.push(statusMap[id]);
                }
            });
            if (paymentStatusFilters.length > 0) {
                paymentStatusFilters.forEach(status => {
                    params.append('payment_status[]', status);
                });
            }
            
            const queryString = params.toString();
            return queryString ? `${baseUrl}?${queryString}` : baseUrl;
        }

        if (applyFiltersBtn) {
            applyFiltersBtn.addEventListener('click', function() {
                window.location.href = buildFilterUrl();
            });
        }

        if (clearFiltersBtn) {
            clearFiltersBtn.addEventListener('click', function() {
                window.location.href = "{{ route('cashier.transaction.history') }}";
            });
        }

        // ========== ACTIVE FILTER TAG REMOVAL ==========
        const filterTagRemoveButtons = document.querySelectorAll('.filter-tag-remove');
        filterTagRemoveButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                let url = new URL(window.location.href);
                
                if (filter === 'search') {
                    url.searchParams.delete('search');
                } else if (filter === 'date') {
                    url.searchParams.delete('date');
                } else if (filter === 'period') {
                    url.searchParams.delete('period');
                } else if (filter.startsWith('order_status-')) {
                    const status = filter.replace('order_status-', '');
                    let orderStatuses = url.searchParams.getAll('order_status[]');
                    orderStatuses = orderStatuses.filter(s => s !== status);
                    url.searchParams.delete('order_status[]');
                    orderStatuses.forEach(s => url.searchParams.append('order_status[]', s));
                } else if (filter.startsWith('payment_method-')) {
                    const method = filter.replace('payment_method-', '');
                    let methods = url.searchParams.getAll('payment_method[]');
                    methods = methods.filter(m => m !== method);
                    url.searchParams.delete('payment_method[]');
                    methods.forEach(m => url.searchParams.append('payment_method[]', m));
                } else if (filter.startsWith('payment_status-')) {
                    const status = filter.replace('payment_status-', '');
                    let statuses = url.searchParams.getAll('payment_status[]');
                    statuses = statuses.filter(s => s !== status);
                    url.searchParams.delete('payment_status[]');
                    statuses.forEach(s => url.searchParams.append('payment_status[]', s));
                }
                
                window.location.href = url.toString();
            });
        });

        function updateActiveFiltersDisplay() {
            if (activeFilters) {
                const hasFilters = activeFilters.querySelector('.filter-tag') !== null;
                if (hasFilters) {
                    activeFilters.classList.add('has-filters');
                } else {
                    activeFilters.classList.remove('has-filters');
                }
            }
        }

        updateActiveFiltersDisplay();

        // ========== VIEW ORDER DETAILS FUNCTIONALITY ==========
        const viewOrderButtons = document.querySelectorAll('.view-order-btn');
        const orderDetailsModal = document.getElementById('orderDetailsModal');
        const orderDetailsContent = document.getElementById('orderDetailsContent');
        const printReceiptBtn = document.getElementById('printReceiptBtn');

        let currentOrderId = null;

        viewOrderButtons.forEach(button => {
            button.addEventListener('click', function() {
                currentOrderId = this.getAttribute('data-order-id');
                loadOrderDetails(currentOrderId);
            });
        });

        function loadOrderDetails(orderId) {
            orderDetailsContent.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;

            fetch(`/cashier/sales/${orderId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Transform the data to match expected format
                    const transformedData = {
                        OrderID: data.order.OrderID,
                        OrderDateTime: data.order.OrderDateTime,
                        OrderStatus: data.order.OrderStatus,
                        PaymentStatus: data.order.OrderStatus === 'Completed' ? 'Paid' : 'Unpaid',
                        PaymentType: data.order.PaymentType,
                        Notes: null,
                        cashier: {
                            EmployeeName: data.order.Employee.EmployeeName
                        },
                        employee: {
                            EmployeeName: data.order.Employee.EmployeeName
                        },
                        items: data.details.map(detail => ({
                            product_name: detail.ProductName,
                            ProductName: detail.ProductName,
                            price: detail.UnitPrice,
                            Price: detail.UnitPrice,
                            quantity: detail.Quantity,
                            Quantity: detail.Quantity
                        }))
                    };
                    
                    const orderDetailsHTML = formatOrderDetails(transformedData);
                    orderDetailsContent.innerHTML = orderDetailsHTML;
                    
                    printReceiptBtn.onclick = function() {
                        printOrderReceipt(transformedData);
                    };
                })
                .catch(error => {
                    console.error('Error loading order details:', error);
                    orderDetailsContent.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Failed to load order details. Please try again.
                        </div>
                    `;
                });
        }

        function formatOrderDetails(orderData) {
            const orderDate = new Date(orderData.created_at || orderData.OrderDate);
            const formattedDate = orderDate.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            const subtotal = orderData.items?.reduce((sum, item) => {
                return sum + (item.price * item.quantity);
            }, 0) || orderData.TotalAmount || 0;

            const tax = subtotal * 0.12;
            const total = subtotal + tax;

            let itemsTable = '';
            if (orderData.items && orderData.items.length > 0) {
                itemsTable = `
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${orderData.items.map(item => `
                                <tr>
                                    <td>${item.product_name || item.ProductName || 'N/A'}</td>
                                    <td class="text-end">₱${parseFloat(item.price || item.Price || 0).toFixed(2)}</td>
                                    <td class="text-end">${item.quantity || item.Quantity || 0}</td>
                                    <td class="text-end">₱${(parseFloat(item.price || item.Price || 0) * (item.quantity || item.Quantity || 0)).toFixed(2)}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                `;
            }

            return `
                <div class="order-details">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Order Information</h6>
                            <p><strong>Order ID:</strong> ${orderData.OrderID || orderData.id || 'N/A'}</p>
                            <p><strong>Date:</strong> ${formattedDate}</p>
                            <p><strong>Cashier:</strong> ${(orderData.employee?.EmployeeFName || '') + ' ' + (orderData.employee?.EmployeeLName || '') || orderData.employee?.EmployeeName || 'Unknown'}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Status</h6>
                            <p><strong>Order Status:</strong> 
                                <span class="${getOrderStatusClass(orderData.OrderStatus)}">
                                    ${orderData.OrderStatus || 'Pending'}
                                </span>
                            </p>
                            <p><strong>Payment Status:</strong> 
                                <span class="${getPaymentStatusClass(orderData.PaymentStatus)}">
                                    ${orderData.PaymentStatus || 'Unpaid'}
                                </span>
                            </p>
                            <p><strong>Payment Method:</strong> 
                                <span class="${getPaymentMethodClass(orderData.PaymentType)}">
                                    ${orderData.PaymentType || 'Cash'}
                                </span>
                            </p>
                        </div>
                    </div>

                    <h6>Order Items</h6>
                    ${itemsTable || '<p class="text-muted">No items found</p>'}

                    <div class="row mt-4">
                        <div class="col-md-6 offset-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td>Subtotal:</td>
                                    <td class="text-end">₱${subtotal.toFixed(2)}</td>
                                </tr>
                                <tr>
                                    <td>Tax (12%):</td>
                                    <td class="text-end">₱${tax.toFixed(2)}</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <th class="text-end">₱${total.toFixed(2)}</th>
                                </tr>
                            </table>
                        </div>
                    </div>

                    ${orderData.Notes ? `
                        <div class="alert alert-info mt-3">
                            <strong>Notes:</strong> ${orderData.Notes}
                        </div>
                    ` : ''}
                </div>
            `;
        }

        // ========== VIEW PAYMENT DETAILS FUNCTIONALITY ==========
        const viewPaymentButtons = document.querySelectorAll('.view-payment-btn');

        viewPaymentButtons.forEach(button => {
            button.addEventListener('click', function() {
                const paymentId = this.getAttribute('data-payment-id');
                loadPaymentDetails(paymentId);
            });
        });

        function loadPaymentDetails(paymentId) {
            fetch(`/cashier/payments/${paymentId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Payment details loaded:', data);
                    
                    // Update modal title
                    document.getElementById('viewPaymentId').textContent = '#' + (data.payment.PaymentID || data.payment.id || 'N/A');
                    
                    // Update payment information
                    document.getElementById('viewPaymentNo').textContent = data.payment.PaymentID || data.payment.id || 'N/A';
                    document.getElementById('viewPaymentOrderId').textContent = '#' + (data.payment.OrderID || data.payment.order_id || 'N/A');
                    document.getElementById('viewPaymentDate').textContent = data.payment.PaymentDate ? new Date(data.payment.PaymentDate).toLocaleString() : 'N/A';
                    document.getElementById('viewPaymentStatus').textContent = data.payment.PaymentStatus || 'Unpaid';
                    
                    // Update payment details
                    document.getElementById('paymentMethodType').textContent = data.payment.PaymentType || 'Cash';
                    document.getElementById('viewPaymentReference').textContent = data.payment.ReferenceNumber || 'N/A';
                    document.getElementById('viewPaymentAmount').textContent = '₱' + (parseFloat(data.payment.Amount || 0).toFixed(2));
                    
                    // Update order items
                    const itemsContainer = document.getElementById('viewPaymentItems');
                    if (data.payment.order && data.payment.order.details) {
                        const itemsHTML = data.payment.order.details.map(item => `
                            <tr>
                                <td>${item.product.ProductName || 'N/A'}</td>
                                <td>₱${parseFloat(item.UnitPrice || 0).toFixed(2)}</td>
                                <td>${item.Quantity || 0}</td>
                                <td>₱${parseFloat(item.Subtotal || 0).toFixed(2)}</td>
                            </tr>
                        `).join('');
                        itemsContainer.innerHTML = itemsHTML;
                    } else {
                        itemsContainer.innerHTML = '<tr><td colspan="4" class="text-center">No items found</td></tr>';
                    }
                    
                    // Update payment summary
                    const subtotal = data.payment.order ? data.payment.order.SubTotal : 0;
                    const discount = parseFloat(data.payment.order ? data.payment.order.DiscountAmount : 0);
                    const grandTotal = parseFloat(data.payment.Amount || 0);
                    
                    document.getElementById('viewPaymentSubtotal').textContent = '₱' + subtotal.toFixed(2);
                    document.getElementById('viewPaymentDiscount').textContent = '-₱' + discount.toFixed(2);
                    document.getElementById('viewPaymentGrandTotal').textContent = '₱' + grandTotal.toFixed(2);
                    
                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('viewPaymentModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error loading payment details:', error);
                    alert('Failed to load payment details. Please try again.');
                });
        }

        function getOrderStatusClass(status) {
            switch(status) {
                case 'Completed': return 'text-success';
                case 'Cancelled': return 'text-danger';
                default: return 'text-warning';
            }
        }

        function getPaymentStatusClass(status) {
            return status === 'Paid' ? 'text-success' : 'text-danger';
        }

        function getPaymentMethodClass(method) {
            switch(method) {
                case 'Cash': return 'text-success';
                case 'GCash': return 'text-primary';
                case 'Card': return 'text-info';
                default: return 'text-secondary';
            }
        }

        // Print receipt function (used by both table buttons and modal)
function printOrderReceipt(orderId) {
    const url = `/cashier/transaction/${orderId}/receipt`; // New route to load receipt view
    const printWindow = window.open(url, '_blank');
    
    if (printWindow) {
        printWindow.onload = function() {
            setTimeout(() => {
                printWindow.print();
                // Optional: printWindow.close(); // Uncomment to auto-close after printing
            }, 500);
        };
    } else {
        alert('Please allow pop-ups to print receipts');
    }
}

// Update your existing print buttons to use this function
document.querySelectorAll('.print-receipt').forEach(button => {
    button.addEventListener('click', function() {
        const orderId = this.dataset.orderId;
        printReceipt(orderId);
    });
});

document.querySelector('.print-receipt-modal')?.addEventListener('click', function() {
    const orderId = this.dataset.orderId;
    if (orderId) printReceipt(orderId);
});

        // ========== SEARCH FUNCTIONALITY WITH DEBOUNCE ==========
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (searchInput.value.length >= 2 || searchInput.value.length === 0) {
                    window.location.href = buildFilterUrl();
                }
            }, 500);
        });

        // Initialize Bootstrap tooltips
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        // Close modals on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openModals = document.querySelectorAll('.modal.show');
                openModals.forEach(modal => {
                    bootstrap.Modal.getInstance(modal)?.hide();
                });
            }
        });
    });
</script>
</body>
</html>
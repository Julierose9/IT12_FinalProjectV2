<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Daily Sales | Dora's Oshopee</title>
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
    .brand img { width: 80px; height: auto; object-fit: contain; }
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

    /* Stats cards */
    .stats-card { 
        border-radius:12px; 
        padding:20px; 
        box-shadow: var(--card-shadow); 
        background:#fff;
        transition: transform 0.2s ease;
    }
    .stats-card:hover {
        transform: translateY(-2px);
    }
    .stats-card h3 { font-size:1.75rem; font-weight:700; margin:0; }
    .stats-card small { color:#6c757d; }
    .stats-card .card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 15px;
    }
    .stats-card .card-icon.primary { background: #efeaff; color: var(--primary-color); }
    .stats-card .card-icon.success { background: #e8f5e8; color: var(--success-color); }
    .stats-card .card-icon.warning { background: #fff3cd; color: var(--warning-color); }
    .stats-card .card-icon.info { background: #e0f2fe; color: #0284c7; }

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
    
    /* Progress bars */
    .progress { 
        height: 20px; 
        border-radius: 10px; 
        background-color: #eef2f7; 
        overflow: visible; 
        position: relative;
    }
    .progress-bar { 
        border-radius: 10px; 
        position: relative; 
        transition: width 1s ease-in-out;
    }
    .progress-bar::after {
        content: attr(data-width) '%';
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
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
        
        .row-cols-md-2 > * {
            flex: 0 0 auto;
            width: 50%;
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
        
        .stats-card {
            padding: 16px;
        }
        
        .stats-card h3 {
            font-size: 1.5rem;
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
        
        .row-cols-1 > * {
            flex: 0 0 auto;
            width: 100%;
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
        
        /* Hide % of Sales column on small screens */
        .table th:nth-child(4), .table td:nth-child(4) {
            display: none;
        }
        
        .progress {
            height: 16px;
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
        
        .stats-card h3 {
            font-size: 1.25rem;
        }
        
        .stats-card .card-icon {
            width: 40px;
            height: 40px;
            font-size: 1.25rem;
        }
    }

    @media (max-width: 375px) {
        .table th:nth-child(2), .table td:nth-child(2) {
            display: none;
        }
        
        .brand img {
            width: 60px;
        }
        
        .sidebar {
            padding: 16px 12px;
        }
        
        .export-btn-text {
            display: none;
        }
        
        .export-btn-icon {
            display: inline-block;
        }
    }
    
    .export-btn-icon {
        display: none;
    }
  </style>
</head>
<body>

<!-- PHP CODE: GET EMPLOYEE DATA AND DATE HANDLING -->
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
    
    use Carbon\Carbon;
    $selectedDate = $selectedDate ?? Carbon::today();
    $displayDate = $selectedDate->format('F d, Y');
    
    $breakdown = $breakdown ?? [];
    $totalSales = $totalSales ?? 0;
    $totalTransactions = $totalTransactions ?? 0;
    $averageTransaction = $averageTransaction ?? 0;
    $topPaymentMethod = $topPaymentMethod ?? 'Cash';
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
            <a class="nav-link" href="{{ route('cashier.dashboard') }}">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>

            <!-- TRANSACTIONS DROPDOWN -->
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#salesSubmenu">
                <i class="fas fa-cash-register me-2"></i> Transactions
            </a>
            <div class="collapse" id="salesSubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link" href="{{ route('cashier.sales') }}">
                        <i class="fas fa-shopping-bag me-2"></i> Sales
                    </a>
                    <a class="nav-link" href="{{ route('cashier.transaction.history') }}">
                        <i class="fas fa-history me-2"></i> Transaction History
                    </a>
                </div>
            </div>

            <!-- REPORTS DROPDOWN -->
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#reportsSubmenu">
                <i class="fas fa-chart-bar me-2"></i> Reports
            </a>
            <div class="collapse show" id="reportsSubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link active" href="{{ route('cashier.daily.sales') }}">
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
            <h4 class="mb-1">Daily Sales Report</h4>
            <small class="text-muted">{{ $displayDate }}</small>
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
                <!-- DATE PICKER AND FILTER SECTION -->
                <div class="search-filter-section">
                    <!-- DATE PICKER -->
                    <div class="date-picker-container">
                        <form method="GET" action="{{ route('cashier.daily.sales') }}" id="dateFilterForm">
                            <div class="input-group">
                                <input type="date"
                                       name="date"
                                       class="form-control"
                                       value="{{ $selectedDate->format('Y-m-d') }}"
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
                            <!-- REPORT TYPE FILTER -->
                            <div class="filter-section">
                                <div class="filter-section-title">Report Type</div>
                                <div class="filter-options">
                                    <div class="filter-option">
                                        <input type="radio" name="reportType" id="report-daily" checked>
                                        <label for="report-daily">Daily Report</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="radio" name="reportType" id="report-weekly">
                                        <label for="report-weekly">Weekly Summary</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="radio" name="reportType" id="report-monthly">
                                        <label for="report-monthly">Monthly Summary</label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- PAYMENT METHOD FILTERS -->
                            <div class="filter-section">
                                <div class="filter-section-title">Payment Methods</div>
                                <div class="filter-options">
                                    <div class="filter-option">
                                        <input type="checkbox" id="method-all" checked>
                                        <label for="method-all">All Methods</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="method-cash">
                                        <label for="method-cash">Cash</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="method-gcash">
                                        <label for="method-gcash">GCash</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="method-card">
                                        <label for="method-card">Card</label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- SALES RANGE FILTERS -->
                            <div class="filter-section">
                                <div class="filter-section-title">Sales Range</div>
                                <div class="filter-options">
                                    <div class="filter-option">
                                        <input type="radio" name="salesRange" id="range-all" checked>
                                        <label for="range-all">All Sales</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="radio" name="salesRange" id="range-high">
                                        <label for="range-high">High Value (> ₱1,000)</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="radio" name="salesRange" id="range-medium">
                                        <label for="range-medium">Medium (₱500 - ₱1,000)</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="radio" name="salesRange" id="range-low">
                                        <label for="range-low">Low Value (< ₱500)</label>
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
                    @if(request()->hasAny(['date', 'method', 'range']))
                        @if(request('date') && request('date') != Carbon::today()->format('Y-m-d'))
                            <div class="filter-tag">
                                <span>Date: {{ request('date') }}</span>
                                <button class="filter-tag-remove" data-filter="date">×</button>
                            </div>
                        @endif
                        @if(request('method') && request('method') != 'all')
                            <div class="filter-tag">
                                <span>Method: {{ ucfirst(request('method')) }}</span>
                                <button class="filter-tag-remove" data-filter="method">×</button>
                            </div>
                        @endif
                        @if(request('range') && request('range') != 'all')
                            <div class="filter-tag">
                                <span>Range: {{ ucfirst(request('range')) }}</span>
                                <button class="filter-tag-remove" data-filter="range">×</button>
                            </div>
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

    <!-- BREAKDOWN TABLE -->
    <div class="table-card">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h5 class="card-title mb-0">Sales by Payment Method</h5>
            <div>
                @if(request()->hasAny(['date', 'method', 'range']))
                    <a href="{{ route('cashier.daily.sales') }}" class="btn btn-outline-primary btn-sm ms-2">
                        <i class="fas fa-sync-alt"></i> Reset
                    </a>
                @endif
                <button class="btn btn-success btn-sm ms-2" onclick="exportCSV()" id="exportBtn">
                    <i class="fas fa-download me-1"></i>
                    <span class="export-btn-text">Export CSV</span>
                    <span class="export-btn-icon">Export</span>
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover" id="salesTable">
                <thead>
                    <tr>
                        <th>Payment Method</th>
                        <th>Transactions</th>
                        <th>Total Amount</th>
                        <th>% of Sales</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($breakdown as $method => $data)
                        @php
                            $methodName = ucfirst(str_replace('_', ' ', $method));
                            $percentage = $data['percentage'] ?? 0;
                            $amount = $data['amount'] ?? 0;
                            $count = $data['count'] ?? 0;
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $methodName }}</strong>
                            </td>
                            <td>
                                {{ $count }}
                            </td>
                            <td>
                                <strong class="text-success">₱{{ number_format($amount, 2) }}</strong>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="progress" style="flex: 1;">
                                        <div class="progress-bar bg-success" 
                                             data-width="{{ number_format($percentage, 1) }}"
                                             style="width: 0%;">
                                            {{ number_format($percentage, 1) }}%
                                        </div>
                                    </div>
                                    <small class="text-muted" style="min-width: 50px; text-align: right;">
                                        {{ number_format($percentage, 1) }}%
                                    </small>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-2x mb-3"></i><br>
                                    No sales data available for the selected date
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(!empty($breakdown))
                <tfoot>
                    <tr class="table-light">
                        <th>Total</th>
                        <th>{{ $totalTransactions }}</th>
                        <th class="text-success">₱{{ number_format($totalSales, 2) }}</th>
                        <th>100%</th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>

        <div class="text-end mt-3">
            <small class="text-muted">Report generated on {{ now()->format('M d, Y h:i A') }}</small>
        </div>
    </div>
</main>

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
        const dateFilter = document.getElementById('dateFilter');
        const activeFilters = document.getElementById('activeFilters');

        function buildFilterUrl() {
            const baseUrl = "{{ route('cashier.daily.sales') }}";
            const params = new URLSearchParams();
            
            if (dateFilter.value && dateFilter.value !== "{{ Carbon::today()->format('Y-m-d') }}") {
                params.append('date', dateFilter.value);
            }
            
            const reportType = document.querySelector('input[name="reportType"]:checked');
            if (reportType && reportType.id !== 'report-daily') {
                const reportMap = {
                    'report-weekly': 'weekly',
                    'report-monthly': 'monthly'
                };
                params.append('report_type', reportMap[reportType.id] || 'daily');
            }
            
            let selectedMethods = [];
            if (document.getElementById('method-all').checked) {
                selectedMethods = ['all'];
            } else {
                const methodCheckboxes = ['method-cash', 'method-gcash', 'method-card'];
                methodCheckboxes.forEach(id => {
                    const checkbox = document.getElementById(id);
                    if (checkbox && checkbox.checked) {
                        const methodMap = {
                            'method-cash': 'cash',
                            'method-gcash': 'gcash',
                            'method-card': 'card'
                        };
                        selectedMethods.push(methodMap[id]);
                    }
                });
            }
            
            if (selectedMethods.length > 0 && !(selectedMethods.length === 1 && selectedMethods[0] === 'all')) {
                params.append('method', selectedMethods.join(','));
            }
            
            const salesRange = document.querySelector('input[name="salesRange"]:checked');
            if (salesRange && salesRange.id !== 'range-all') {
                const rangeMap = {
                    'range-high': 'high',
                    'range-medium': 'medium',
                    'range-low': 'low'
                };
                params.append('range', rangeMap[salesRange.id] || 'all');
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
                window.location.href = "{{ route('cashier.daily.sales') }}";
            });
        }

        // ========== ACTIVE FILTER TAG REMOVAL ==========
        const filterTagRemoveButtons = document.querySelectorAll('.filter-tag-remove');
        filterTagRemoveButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                let url = new URL(window.location.href);
                
                if (filter === 'date') {
                    url.searchParams.delete('date');
                } else if (filter === 'method') {
                    url.searchParams.delete('method');
                } else if (filter === 'range') {
                    url.searchParams.delete('range');
                } else if (filter === 'report_type') {
                    url.searchParams.delete('report_type');
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

        // ========== ANIMATE PROGRESS BARS ==========
        function animateProgressBars() {
            const progressBars = document.querySelectorAll('.progress-bar[data-width]');
            progressBars.forEach(bar => {
                const width = parseFloat(bar.getAttribute('data-width'));
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width + '%';
                }, 100);
            });
        }

        setTimeout(animateProgressBars, 300);

        // ========== CSV EXPORT FUNCTION ==========
        window.exportCSV = function() {
            const table = document.getElementById('salesTable');
            let csv = [];
            
            let headerRow = [];
            const headers = table.querySelectorAll('thead th');
            headers.forEach(header => {
                headerRow.push(header.innerText);
            });
            csv.push(headerRow.join(','));
            
            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                let rowData = [];
                const cells = row.querySelectorAll('td');
                cells.forEach((cell, index) => {
                    if (index === 3) {
                        const percentage = cell.querySelector('.text-muted')?.innerText || '0%';
                        rowData.push(percentage.replace('%', '%'));
                    } else {
                        rowData.push(cell.innerText.replace(/[₱,]/g, ''));
                    }
                });
                csv.push(rowData.join(','));
            });
            
            const footer = table.querySelector('tfoot');
            if (footer) {
                let footerRow = [];
                const footerCells = footer.querySelectorAll('th, td');
                footerCells.forEach(cell => {
                    footerRow.push(cell.innerText.replace(/[₱,]/g, ''));
                });
                csv.push(footerRow.join(','));
            }
            
            const csvContent = csv.join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            
            @php
                $exportDate = $selectedDate->format('Y-m-d');
                $fileName = "daily-sales-{$exportDate}.csv";
            @endphp
            
            link.setAttribute('href', url);
            link.setAttribute('download', '{{ $fileName }}');
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            const exportBtn = document.getElementById('exportBtn');
            const originalHTML = exportBtn.innerHTML;
            exportBtn.innerHTML = '<i class="fas fa-check me-1"></i> Exported!';
            exportBtn.classList.remove('btn-success');
            exportBtn.classList.add('btn-primary');
            
            setTimeout(() => {
                exportBtn.innerHTML = originalHTML;
                exportBtn.classList.remove('btn-primary');
                exportBtn.classList.add('btn-success');
            }, 2000);
        };

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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sales Management | Dora's Oshoppe</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
        body { 
            font-family: 'Poppins', sans-serif; 
            background: var(--light-bg); 
            padding-top: 0; 
        }

        /* Required field indicator */
        .form-label.required::after {
            content: " *";
            color: var(--danger-color);
        }

        /* Sidebar */
        .sidebar {
            min-width: 220px; 
            max-width: 220px; 
            background: #fff;
            border-right: 1px solid #eef2f7; 
            height: 100vh; 
            position: fixed;
            top: 0; 
            left: 0; 
            padding: 22px; 
            display: flex; 
            flex-direction: column;
            overflow: hidden; 
            transition: all 0.3s ease; 
            z-index: 1000;
        }
        .sidebar.mobile-open { 
            transform: translateX(0); 
        }
        .brand { 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            margin-bottom: 18px; 
        }
        .brand img { 
            width: 40px; 
            height: 40px; 
            object-fit: contain; 
        }
        .sidebar .nav-link {
            color: #5b5f72; 
            padding: 12px 8px; 
            border-radius: 10px;
            font-size: 0.95rem; 
            display: flex; 
            align-items: center;
            transition: all 0.2s ease;
        }
        .sidebar .nav-link.active { 
            background: #efeaff; 
            color: var(--primary-color); 
            font-weight: 600; 
        }
        .sidebar .nav-link:hover { 
            background: #f8f9fa; 
            transform: translateX(2px); 
        }
        .sidebar .nav-link i { 
            width: 20px; 
            margin-right: 10px; 
            text-align: center; 
        }
        .sidebar-nav { 
            flex: 1; 
            overflow-y: auto; 
            margin-top: 18px; 
        }
        .nav.flex-column.ms-3 { 
            border-left: 2px solid #eef2f7; 
            margin-left: 12px !important; 
            padding-left: 8px; 
        }
        .nav.flex-column.ms-3 .nav-link { 
            padding: 10px 12px; 
            font-size: 0.9rem; 
            border-radius: 6px; 
        }

        /* Mobile sidebar toggle */
        .sidebar-toggle { 
            display: none; 
            position: fixed; 
            top: 15px; 
            left: 15px; 
            z-index: 1001;
            background: var(--primary-color); 
            color: white; 
            border: none; 
            border-radius: 8px;
            width: 40px; 
            height: 40px; 
            font-size: 1.2rem; 
        }
        .sidebar-overlay { 
            display: none; 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%;
            background: rgba(0,0,0,0.5); 
            z-index: 999; 
        }
        .sidebar-overlay.active { 
            display: block; 
        }

        /* Main content */
        .content-wrap { 
            margin-left: 240px; 
            padding: 28px; 
            transition: all 0.3s ease; 
        }
        .topbar { 
            display: flex; 
            justify-content: space-between; 
            flex-wrap: wrap; 
            gap: 16px; 
            margin-bottom: 22px; 
        }
        .page-title-section h4 { 
            margin-bottom: 4px; 
        }
                
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

        /* Search and filter section */
        .filter-container {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
            width: 100%;
            margin-bottom: 20px;
        }

        .search-filter-section {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: space-between;
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
            height: 38px;
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
        
        .filter-option input[type="checkbox"] {
            margin: 0;
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

        /* Active filters display */
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

        /* Table styling */
        .table-card { 
            border-radius: 12px; 
            border: none; 
            box-shadow: var(--card-shadow); 
            overflow: hidden; 
        }
        .table th { 
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
        
        /* Status badges */
        .status-badge { 
            padding: 6px 12px; 
            border-radius: 20px; 
            font-size: 0.75rem; 
            font-weight: 500; 
        }
        .status-completed {  
            color: var(--success-color); 
        }
        .status-pending { 
            color: var(--warning-color); 
        }
        .status-archived {  
            color: var(--danger-color); 
        }
        
        /* Payment method badges */
        .method-badge { 
            padding: 4px 10px; 
            border-radius: 12px; 
            font-size: 0.7rem; 
            font-weight: 500; 
        }
        .method-cash { 
            background-color: #e8f5e8; 
            color: var(--success-color); 
        }
        .method-gcash {  
            background-color: #e0f2fe; 
            color: #0284c7; 
        }
        .method-card {  
            background-color: #efeaff; 
            color: var(--primary-color); 
        }

        /* Stats cards */
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
        .nav-tabs { 
            border-bottom: 2px solid #eef2f7; 
            margin-bottom: 24px; 
        }
        .nav-tabs .nav-link { 
            color: #5b5f72; 
            border: none; 
            padding: 12px 20px; 
            font-weight: 500; 
            border-radius: 8px 8px 0 0; 
            margin-right: 4px; 
            transition: all 0.2s;
        }
        .nav-tabs .nav-link:hover { 
            background: #f8f9fa; 
            color: var(--primary-color); 
        }
        .nav-tabs .nav-link.active { 
            color: var(--primary-color); 
            background-color: #fff; 
            border-bottom: 2px solid var(--primary-color);
        }

        /* Modal styles */
        .modal-lg .modal-content { 
            border-radius: 12px; 
            border: none; 
        }
        .modal-header { 
            border-bottom: 1px solid #eef2f7; 
            padding: 20px 24px; 
        }
        .modal-body { 
            padding: 24px; 
        }
        .modal-footer { 
            border-top: 1px solid #eef2f7; 
            padding: 20px 24px; 
        }

        /* Read-only form fields */
        .readonly-field {
            background-color: #f8f9fa;
            cursor: not-allowed;
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
        
        /* Order form specific */
        .order-summary {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 16px;
            margin-top: 16px;
        }
        
        .order-total {
            font-size: 1.25rem;
            font-weight: 600;
        }
        
        /* Loading spinner */
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
        .view-payment-order {
            color: #000 !important;
            font-weight: 600;
        }

        .view-payment-order:hover {
            color: var(--primary-color) !important;
            text-decoration: underline !important;
        }

        /* Responsive design */
        @media (max-width: 991.98px) {
            .sidebar { 
                transform: translateX(-100%); 
                width: 280px; 
                box-shadow: 2px 0 10px rgba(0,0,0,0.1); 
            }
            .sidebar.mobile-open { 
                transform: translateX(0); 
            }
            .sidebar-toggle, .sidebar-overlay { 
                display: block; 
            }
            .content-wrap { 
                margin-left: 0; 
                padding: 70px 16px 16px; 
            }
            .topbar { 
                flex-direction: column; 
                align-items: stretch; 
            }
            .user-section { 
                align-items: stretch; 
                min-width: 100%; 
            }
            .search-filter-section {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }
            
            .search-input {
                min-width: 100%;
                max-width: 100%;
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
        }
        
        @media (max-width: 575.98px) {
            .content-wrap { 
                padding: 70px 8px 8px; 
            }
            .table th, .table td { 
                padding: 10px 6px; 
                font-size: 0.85rem; 
            }
            .action-buttons { 
                flex-direction: column; 
            }
            .stat-card { 
                padding: 16px; 
            }
            .stat-value { 
                font-size: 1.5rem; 
            }
            
            .modal-body { 
                padding: 16px; 
            }
            .modal-header, .modal-footer { 
                padding: 16px; 
            }
            
            .form-control, .form-select {
                font-size: 0.9rem;
            }
            
            .btn-group-sm .btn {
                padding: 0.25rem 0.5rem;
            }
        }
    </style>
</head>
<body>

<!-- MOBILE SIDEBAR TOGGLE -->
<button class="sidebar-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- SIDEBAR -->
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
            <a class="nav-link" href="{{ route('cashier.dashboard') }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>

            <a class="nav-link dropdown-toggle active" href="#" data-bs-toggle="collapse" data-bs-target="#salesSubmenu">
                <i class="fas fa-cash-register"></i>
                <span>Transactions</span>
            </a>
            <div class="collapse show" id="salesSubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link active" href="{{ route('cashier.sales') }}">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Sales</span>
                    </a>
                    <a class="nav-link" href="{{ route('cashier.transaction.history') }}">
                        <i class="fas fa-history"></i>
                        <span>Transaction History</span>
                    </a>
                </div>
            </div>

            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#reportsSubmenu">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
            </a>
            <div class="collapse" id="reportsSubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link" href="{{ route('cashier.daily.sales') }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Daily Sales</span>
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
            <h4 class="mb-1">Sales Management</h4>
            <small class="text-muted">Manage orders and payments</small>
        </div>

        <div class="user-section">
            <!-- USER INFO SECTION -->
            <div class="user-dropdown">
                <button class="user-dropdown-toggle" id="userDropdownToggle">
                    <img src="{{ asset('images/logo_.png') }}" alt="avatar" class="user-avatar">
                    <div class="user-details">
                        <div class="user-name">{{ $employeeName }}</div>
                        <div class="user-role">{{ $user->Role ?? 'Cashier' }}</div>
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
            
            <!-- SEARCH AND FILTER SECTION -->
            <div class="filter-container">
                <div class="search-filter-section">
                    <div class="input-group search-input">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input class="form-control" placeholder="Search orders, products, employee..." id="searchInput" />
                    </div>
                    
                    <div class="filter-dropdown">
                        <button class="filter-toggle" id="filterToggle">
                            <i class="fas fa-filter"></i>
                            <span>Filter</span>
                            <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
                        </button>
                        
                        <div class="filter-menu" id="filterMenu" style="display: none;">
                            <!-- ORDER STATUS FILTER -->
                            <div class="filter-section">
                                <div class="filter-section-title">Filter by Order Status</div>
                                <div class="filter-options">
                                    <div class="filter-option">
                                        <input type="checkbox" id="order-status-all" checked>
                                        <label for="order-status-all">All Status</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="status-completed-filter">
                                        <label for="status-completed-filter">Completed</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="status-pending-filter">
                                        <label for="status-pending-filter">Pending</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="status-archived-filter">
                                        <label for="status-archived-filter">Archived</label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- PAYMENT METHOD FILTER -->
                            <div class="filter-section">
                                <div class="filter-section-title">Filter by Payment Method</div>
                                <div class="filter-options">
                                    <div class="filter-option">
                                        <input type="checkbox" id="payment-all" checked>
                                        <label for="payment-all">All Methods</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="payment-cash-filter">
                                        <label for="payment-cash-filter">Cash</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="payment-gcash-filter">
                                        <label for="payment-gcash-filter">GCash</label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- DATE RANGE FILTER -->
                            <div class="filter-section">
                                <div class="filter-section-title">Filter by Date</div>
                                <div class="date-range">
                                    <div class="mb-2">
                                        <label class="form-label small mb-1">From Date</label>
                                        <input type="date" class="form-control form-control-sm" id="dateFromFilter">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small mb-1">To Date</label>
                                        <input type="date" class="form-control form-control-sm" id="dateToFilter">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- FILTER ACTION BUTTONS -->
                            <div class="filter-actions">
                                <button class="btn-apply" id="applyFilters">Apply Filters</button>
                                <button class="btn-clear" id="clearFilters">Reset Filters</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- ACTIVE FILTERS DISPLAY -->
                <div class="active-filters" id="activeFilters">
                    <!-- Filter tags dynamically added -->
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

    <!-- TABS NAVIGATION -->
    <ul class="nav nav-tabs" id="salesTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab">
                <i></i>Orders
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button" role="tab">
                <i></i>Payments
            </button>
        </li>
    </ul>

    <!-- TAB CONTENT -->
    <div class="tab-content" id="salesTabContent">
        <!-- ORDERS TAB -->
        <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
            <div class="card table-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                        <h5 class="card-title mb-0">Order Records</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createOrderModal">
                            <i class="fas fa-plus me-2"></i>Record Order
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ORDER ID</th>
                                    <th>EMPLOYEE</th>
                                    <th>DATE</th>
                                    <th>ITEMS</th>
                                    <th>GRAND TOTAL</th>
                                    <th>PAYMENT</th>
                                    <th>STATUS</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody id="ordersTableBody">
                                @if(isset($orders) && $orders->count() > 0)
                                    @foreach($orders as $order)
                                    <tr data-status="{{ strtolower($order->OrderStatus) }}" data-payment="{{ strtolower($order->PaymentType ?? 'n/a') }}" data-date="{{ \Carbon\Carbon::parse($order->OrderDateTime)->format('Y-m-d') }}">
                                        <td><strong>{{ $order->OrderID }}</strong></td>
                                        <td>
                                            <div style="font-weight:600">
                                                {{ $order->employee->EmpFName ?? $order->employee->EmployeeName ?? 'N/A' }} 
                                                {{ $order->employee->EmpLName ?? '' }}
                                            </div>
                                            <small class="text-muted">{{ $order->employee->EmployeeID ?? '' }}</small>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($order->OrderDateTime)->format('M d, Y h:i A') }}</td>
                                        <td>
                                            <div style="font-weight:600">{{ $order->details->count() }} item(s)</div>
                                            <small class="text-muted">
                                                @foreach($order->details as $detail)
                                                    {{ $detail->product->ProductName ?? 'N/A' }}
                                                    @if(!$loop->last), @endif
                                                @endforeach
                                            </small>
                                        </td>
                                        <td><strong class="text-success">₱{{ number_format($order->GrandTotal, 2) }}</strong></td>
                                        <td>
                                            @if($order->payment)
                                            <span class="status-badge status-completed">Paid</span>
                                            @else
                                            <span class="status-badge status-pending">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($order->OrderStatus == 'Completed')
                                            <span class="status-badge status-completed">Completed</span>
                                            @elseif($order->OrderStatus == 'Archived')
                                            <span class="status-badge status-archived">Archived</span>
                                            @else
                                            <span class="status-badge status-pending">{{ $order->OrderStatus }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary view-order" 
                                                        data-order-id="{{ $order->OrderID }}"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#viewOrderModal">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-warning archive-order" 
                                                        data-order-id="{{ $order->OrderID }}"
                                                        data-order-code="{{ $order->OrderID }}"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#archiveOrderModal">
                                                    <i class="fas fa-archive"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-shopping-cart fa-2x mb-3"></i>
                                                <p class="mb-0">No orders found. Click "Record Order" to create one.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if(isset($orders) && $orders->count() > 0)
                    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                        <div class="text-muted">
                            Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} orders
                        </div>
                        {{ $orders->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- PAYMENTS TAB -->
        <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
            <div class="card table-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                        <h5 class="card-title mb-0">Payment Records</h5>
                        <div class="text-muted">
                            @if(isset($payments))
                                Total: {{ $payments->total() }} payment(s)
                            @endif
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>PAYMENT ID</th>
                                    <th>ORDER</th>
                                    <th>EMPLOYEE</th>
                                    <th>AMOUNT</th>
                                    <th>METHOD</th>
                                    <th>DATE</th>
                                    <th>STATUS</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody id="paymentsTableBody">
                                @if(isset($payments) && $payments->count() > 0)
                                    @foreach($payments as $payment)
                                    <tr>
                                        <td><strong>{{ $payment->PaymentID }}</strong></td>
                                        <td>
                                            <a href="javascript:void(0)" class="text-decoration-none view-payment-order" 
                                            data-order-id="{{ $payment->OrderID }}">
                                                <strong class="text-dark">{{ $payment->OrderID }}</strong>
                                            </a>
                                        </td>
                                        <td>
                                            <div style="font-weight:600">
                                                {{ $payment->order->employee->EmpFName ?? $payment->order->employee->EmployeeName ?? 'N/A' }}
                                                {{ $payment->order->employee->EmpLName ?? '' }}
                                            </div>
                                            <small class="text-muted">{{ $payment->order->employee->EmployeeID ?? '' }}</small>
                                        </td>
                                        <td><strong class="text-success">₱{{ number_format($payment->Amount ?? 0, 2) }}</strong></td>
                                        <td>
                                            @if($payment->PaymentType == 'Cash')
                                            <span class="method-badge method-cash">Cash</span>
                                            @elseif($payment->PaymentType == 'GCash')
                                            <span class="method-badge method-gcash">GCash</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment->PaymentDate)
                                                {{ \Carbon\Carbon::parse($payment->PaymentDate)->format('M d, Y h:i A') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment->PaymentStatus == 'Completed')
                                            <span class="status-badge status-completed">Completed</span>
                                            @else
                                            <span class="status-badge status-pending">{{ $payment->PaymentStatus ?? 'Pending' }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary view-payment" 
                                                        data-payment-id="{{ $payment->PaymentID }}"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#viewPaymentModal">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-success print-receipt" 
                                                        data-payment-id="{{ $payment->PaymentID }}">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-credit-card fa-2x mb-3"></i>
                                                <p class="mb-0">No payment records found.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if(isset($payments) && $payments->count() > 0)
                    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                        <div class="text-muted">
                            Showing {{ $payments->firstItem() ?? 0 }} to {{ $payments->lastItem() ?? 0 }} of {{ $payments->total() }} payments
                        </div>
                        {{ $payments->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>

<!-- CREATE ORDER MODAL -->
<div class="modal fade" id="createOrderModal" tabindex="-1" aria-labelledby="createOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createOrderModalLabel">Record New Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createOrderForm" method="POST" action="{{ route('cashier.sales.store') }}">
                @csrf
                <div class="modal-body">
                    <!-- PRODUCT SELECTION -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label required">Product</label>
                            <select class="form-select" id="productSelect" required>
                                <option value="">Select Product</option>
                                @if(isset($products) && $products->count() > 0)
                                    @foreach($products as $product)
                                        @php
                                            $price = $product->pricing->RetailPrice ?? $product->current_price ?? 0;
                                            $availableStock = $product->available_stock ?? 0;
                                        @endphp
                                        @if($availableStock > 0)
                                            <option value="{{ $product->ProductID }}" 
                                                    data-sku="{{ $product->SKUNumber }}"
                                                    data-size="{{ $product->Size ?? '' }}"
                                                    data-category="{{ $product->category->CategoryName ?? '' }}"
                                                    data-price="{{ $price }}"
                                                    data-stock="{{ $availableStock }}">
                                                {{ $product->ProductName }} - ₱{{ number_format($price, 2) }} (Stock: {{ $availableStock }})
                                            </option>
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            <input type="hidden" name="ProductID" id="selectedProductID">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label required">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="Quantity" 
                                min="1" value="1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">SKU Number</label>
                            <input type="text" class="form-control readonly-field" id="skuDisplay" readonly>
                        </div>
                    </div>

                    <!-- SIZE DISPLAY (CLOTHING ONLY) -->
                    <div class="row mb-3" id="sizeRow" style="display: none;">
                        <div class="col-md-6">
                            <label class="form-label">Size</label>
                            <input type="text" class="form-control readonly-field" id="sizeDisplay" readonly>
                        </div>
                    </div>

                    <!-- EMPLOYEE INFORMATION -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Employee</label>
                            <div class="form-control readonly-field">
                                <strong>{{ $employeeName ?? 'Cashier' }}</strong> 
                                @if($employeeId)
                                <br><small>ID: {{ $employeeId }}</small>
                                @endif
                            </div>
                            <input type="hidden" name="EmployeeID" value="{{ $employeeId }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Unit Price</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control readonly-field" id="unitPriceDisplay" readonly>
                        </div>
                        </div>
                    </div>
                    
                    <!-- DISCOUNT SECTION -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Discount Type</label>
                            <select class="form-select" id="discountType" name="DiscountType">
                                <option value="None" selected>No Discount</option>
                                <option value="Senior">Senior Citizen (20%)</option>
                                <option value="PWD">PWD (20%)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Discount Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control readonly-field" id="discountAmountDisplay" readonly>
                                <input type="hidden" name="DiscountAmount" id="discountAmount">
                            </div>
                        </div>
                    </div>

                    <!-- PAYMENT SECTION -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label required">Payment Type</label>
                            <select class="form-select" id="paymentType" name="PaymentType" required>
                                <option value="">Select Payment</option>
                                <option value="Cash">Cash</option>
                                <option value="GCash">GCash</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Subtotal</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control readonly-field" id="subtotalDisplay" readonly>
                                <input type="hidden" name="SubTotal" id="subtotal">
                            </div>
                        </div>
                    </div>

                    <!-- CONDITIONAL FIELDS BASED ON PAYMENT TYPE -->
                    <div id="cashFields" style="display: none;">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label required">Amount Tendered</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" class="form-control" id="amountTendered" 
                                        step="0.01" min="0" name="AmountTendered">
                                </div>
                                <small class="text-muted">Enter amount received from customer</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Change</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control readonly-field" id="changeDisplay" readonly>
                                </div>
                                <small class="text-muted">Change to be given to customer</small>
                            </div>
                        </div>
                    </div>

                    <div id="gcashFields" style="display: none;">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label required">GCash Reference Number</label>
                                <input type="text" class="form-control" id="gcashReference" 
                                    name="PaymentReference" placeholder="Enter GCash reference number">
                                <small class="text-muted">Enter the transaction reference number from GCash</small>
                            </div>
                        </div>
                    </div>

                    <!-- GRAND TOTAL -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-success">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 mb-0">Grand Total:</span>
                                    <span class="h4" id="grandTotalDisplay">₱0.00</span>
                                    <input type="hidden" name="GrandTotal" id="grandTotal">
                                    <input type="hidden" name="AmountPaid" id="amountPaid" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- LOADING SPINNER -->
                    <div class="loading-spinner" id="orderLoading">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Processing...</span>
                        </div>
                        <p class="mt-2">Processing order...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitOrderBtn">
                        <i class="fas fa-check me-2"></i>Complete Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- VIEW ORDER MODAL -->
<div class="modal fade" id="viewOrderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details - <span id="viewOrderId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- ORDER INFORMATION -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Order Information</h6>
                        <p class="mb-1"><strong>Order ID:</strong> <span id="viewOrderNo"></span></p>
                        <p class="mb-1"><strong>Date:</strong> <span id="viewOrderDate"></span></p>
                        <p class="mb-1"><strong>Status:</strong> <span id="viewOrderStatus"></span></p>
                        <p class="mb-0"><strong>Payment:</strong> <span id="viewPaymentMethod"></span></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Employee</h6>
                        <p class="mb-0"><strong>Processed by:</strong> <span id="viewEmployee"></span></p>
                    </div>
                </div>

                <!-- ORDER ITEMS TABLE -->
                <h6>Order Items</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
                        <tbody id="viewOrderItems"></tbody>
                    </table>
                </div>

                <!-- ORDER SUMMARY -->
                <div class="row mt-4">
                    <div class="col-md-6 offset-md-6">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Subtotal:</span><strong id="viewSubtotal">₱0.00</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Discount:</span><strong id="viewDiscount" class="text-danger">-₱0.00</strong>
                        </div>
                        <div class="d-flex justify-content-between mt-2 pt-2 border-top">
                            <span class="h6">Grand Total:</span><strong class="h5 text-success" id="viewGrandTotal">₱0.00</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-print me-2"></i>Print Receipt
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ARCHIVE ORDER MODAL -->
<div class="modal fade" id="archiveOrderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Archive Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to archive this order?</p>
                <p><strong id="archiveOrderId"></strong></p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Archived orders can be restored from the archive section.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="archiveOrderForm" method="POST" style="display: inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-archive me-2"></i>Archive Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

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
                        <p class="mb-1"><strong>Payment Method:</strong> <span id="viewPaymentMethod"></span></p>
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
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary print-payment-receipt">
                    <i class="fas fa-print me-2"></i>Print Receipt
                </button>
            </div>
        </div>
    </div>
</div>

<!-- EXTERNAL JAVASCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- INTERNAL JAVASCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables for order calculations
    let unitPrice = 0;
    let subtotal = 0;
    let discountAmount = 0;
    let grandTotal = 0;
    
    // ========== SIDEBAR FUNCTIONALITY ==========
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
    
    // ========== USER DROPDOWN FUNCTIONALITY ==========
    document.getElementById('userDropdownToggle')?.addEventListener('click', function(e) {
        e.stopPropagation();
        const menu = document.getElementById('userDropdownMenu');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function() {
        document.getElementById('userDropdownMenu').style.display = 'none';
    });

    // ========== FILTER DROPDOWN FUNCTIONALITY ==========
    const filterToggle = document.getElementById('filterToggle');
    const filterMenu = document.getElementById('filterMenu');
    const activeFilters = document.getElementById('activeFilters');
    const searchInput = document.getElementById('searchInput');
    const ordersTableBody = document.getElementById('ordersTableBody');
    
    // Store current filters
    let currentFilters = {
        status: [],
        payment: ['cash', 'gcash', 'n/a'],
        dateFrom: '',
        dateTo: '',
        search: ''
    };
    
    // Filter toggle functionality
    filterToggle?.addEventListener('click', function(e) {
        e.stopPropagation();
        const isVisible = filterMenu.style.display === 'block';
        filterMenu.style.display = isVisible ? 'none' : 'block';
        filterToggle.classList.toggle('active', !isVisible);
    });
    
    document.addEventListener('click', function() {
        filterMenu.style.display = 'none';
        filterToggle.classList.remove('active');
    });
    
    filterMenu?.addEventListener('click', function(e) {
        e.stopPropagation();
    });
    
    // ========== SEARCH AND FILTER FUNCTIONALITY ==========
    searchInput?.addEventListener('input', function() {
        currentFilters.search = this.value.toLowerCase();
        filterOrders();
    });
    
    const dateFromFilter = document.getElementById('dateFromFilter');
    const dateToFilter = document.getElementById('dateToFilter');
    
    if (dateFromFilter) {
        dateFromFilter.addEventListener('change', function() {
            currentFilters.dateFrom = this.value;
            filterOrders();
        });
    }
    
    if (dateToFilter) {
        dateToFilter.addEventListener('change', function() {
            currentFilters.dateTo = this.value;
            filterOrders();
        });
    }
    
    // Apply filters
    document.getElementById('applyFilters')?.addEventListener('click', function() {
        filterMenu.style.display = 'none';
        filterToggle.classList.remove('active');
        updateCurrentFilters();
        updateActiveFilters();
        filterOrders();
    });
    
    // Clear filters
    document.getElementById('clearFilters')?.addEventListener('click', function() {
        document.querySelectorAll('.filter-option input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        document.getElementById('order-status-all').checked = true;
        document.getElementById('payment-all').checked = true;
        if (dateFromFilter) dateFromFilter.value = '';
        if (dateToFilter) dateToFilter.value = '';
        if (searchInput) searchInput.value = '';
        currentFilters = {
            status: [],
            payment: ['cash', 'gcash', 'n/a'],
            dateFrom: '',
            dateTo: '',
            search: ''
        };
        updateActiveFilters();
        filterOrders();
    });
    
    function updateCurrentFilters() {
        // Update status filters
        currentFilters.status = [];
        if (document.getElementById('order-status-all').checked) {
            currentFilters.status = ['completed', 'pending', 'archived'];
        } else {
            if (document.getElementById('status-completed-filter').checked) {
                currentFilters.status.push('completed');
            }
            if (document.getElementById('status-pending-filter').checked) {
                currentFilters.status.push('pending');
            }
            if (document.getElementById('status-archived-filter').checked) {
                currentFilters.status.push('archived');
            }
        }
        
        // Update payment filters
        currentFilters.payment = [];
        if (document.getElementById('payment-all').checked) {
            currentFilters.payment = ['cash', 'gcash', 'n/a'];
        } else {
            if (document.getElementById('payment-cash-filter').checked) {
                currentFilters.payment.push('cash');
            }
            if (document.getElementById('payment-gcash-filter').checked) {
                currentFilters.payment.push('gcash');
            }
            if (currentFilters.payment.length === 0) {
                currentFilters.payment = ['cash', 'gcash', 'n/a'];
            }
        }
        
        // Update date filters
        currentFilters.dateFrom = dateFromFilter ? dateFromFilter.value : '';
        currentFilters.dateTo = dateToFilter ? dateToFilter.value : '';
    }
    
    function updateActiveFilters() {
        if (activeFilters) {
            activeFilters.innerHTML = '';
            const hasCustomFilters = 
                currentFilters.status.length !== 3 ||
                currentFilters.payment.length !== 2 ||
                currentFilters.dateFrom !== '' ||
                currentFilters.dateTo !== '' ||
                currentFilters.search !== '';
            
            if (!hasCustomFilters) {
                activeFilters.classList.remove('has-filters');
                return;
            }
            
            activeFilters.classList.add('has-filters');
            
            if (currentFilters.status.length !== 3) {
                currentFilters.status.forEach(status => {
                    const statusTag = createFilterTag(
                        `Status: ${status.charAt(0).toUpperCase() + status.slice(1)}`,
                        `status-${status}`
                    );
                    activeFilters.appendChild(statusTag);
                });
            }
            
            if (currentFilters.payment.length !== 2) {
                currentFilters.payment.forEach(payment => {
                    const paymentTag = createFilterTag(
                        `Payment: ${payment.charAt(0).toUpperCase() + payment.slice(1)}`,
                        `payment-${payment}`
                    );
                    activeFilters.appendChild(paymentTag);
                });
            }
            
            if (currentFilters.dateFrom || currentFilters.dateTo) {
                let dateText = 'Date: ';
                if (currentFilters.dateFrom && currentFilters.dateTo) {
                    dateText += `${formatDate(currentFilters.dateFrom)} to ${formatDate(currentFilters.dateTo)}`;
                } else if (currentFilters.dateFrom) {
                    dateText += `From ${formatDate(currentFilters.dateFrom)}`;
                } else if (currentFilters.dateTo) {
                    dateText += `To ${formatDate(currentFilters.dateTo)}`;
                }
                const dateTag = createFilterTag(dateText, 'date-range');
                activeFilters.appendChild(dateTag);
            }
            
            if (currentFilters.search !== '') {
                const searchTag = createFilterTag(`Search: "${currentFilters.search}"`, 'search');
                activeFilters.appendChild(searchTag);
            }
        }
    }
    
    function createFilterTag(text, filterType) {
        const tag = document.createElement('div');
        tag.className = 'filter-tag';
        const span = document.createElement('span');
        span.textContent = text;
        const removeBtn = document.createElement('button');
        removeBtn.className = 'filter-tag-remove';
        removeBtn.setAttribute('data-filter', filterType);
        removeBtn.innerHTML = '×';
        removeBtn.addEventListener('click', function() {
            removeFilter(filterType);
        });
        tag.appendChild(span);
        tag.appendChild(removeBtn);
        return tag;
    }
    
    function removeFilter(filterType) {
        if (filterType.startsWith('status-')) {
            const filterName = filterType.replace('status-', '');
            const index = currentFilters.status.indexOf(filterName);
            if (index > -1) {
                currentFilters.status.splice(index, 1);
            }
        } else if (filterType.startsWith('payment-')) {
            const filterName = filterType.replace('payment-', '');
            const index = currentFilters.payment.indexOf(filterName);
            if (index > -1) {
                currentFilters.payment.splice(index, 1);
            }
        } else if (filterType === 'date-range') {
            currentFilters.dateFrom = '';
            currentFilters.dateTo = '';
            if (dateFromFilter) dateFromFilter.value = '';
            if (dateToFilter) dateToFilter.value = '';
        } else if (filterType === 'search') {
            currentFilters.search = '';
            if (searchInput) searchInput.value = '';
        }
        updateFilterInputs();
        updateActiveFilters();
        filterOrders();
    }
    
    function updateFilterInputs() {
        if (document.getElementById('order-status-all')) {
            document.getElementById('order-status-all').checked = currentFilters.status.length === 3;
            document.getElementById('status-completed-filter').checked = currentFilters.status.includes('completed');
            document.getElementById('status-pending-filter').checked = currentFilters.status.includes('pending');
            document.getElementById('status-archived-filter').checked = currentFilters.status.includes('archived');
        }
        
        if (document.getElementById('payment-all')) {
            document.getElementById('payment-all').checked = currentFilters.payment.length === 2;
            document.getElementById('payment-cash-filter').checked = currentFilters.payment.includes('cash');
            document.getElementById('payment-gcash-filter').checked = currentFilters.payment.includes('gcash');
        }
    }
    
    function filterOrders() {
        if (ordersTableBody) {
            const rows = ordersTableBody.getElementsByTagName('tr');
            let visibleCount = 0;
            
            for (let row of rows) {
                if (row.cells.length < 2) continue;
                
                const orderId = row.cells[0]?.textContent?.toLowerCase() || '';
                const employeeName = row.cells[1]?.textContent?.toLowerCase() || '';
                const items = row.cells[3]?.textContent?.toLowerCase() || '';
                const status = row.dataset.status || '';
                const payment = row.dataset.payment || '';
                const dateStr = row.dataset.date || '';
                
                const searchMatch = currentFilters.search === '' || 
                                   orderId.includes(currentFilters.search) || 
                                   employeeName.includes(currentFilters.search) ||
                                   items.includes(currentFilters.search);
                
                const statusMatch = currentFilters.status.length === 0 || 
                                   currentFilters.status.includes(status);
                
                const paymentMatch = currentFilters.payment.length === 0 || 
                                   payment === '' || currentFilters.payment.includes(payment);
                
                let dateMatch = true;
                if (currentFilters.dateFrom || currentFilters.dateTo) {
                    const orderDate = new Date(dateStr);
                    const fromDate = currentFilters.dateFrom ? new Date(currentFilters.dateFrom) : null;
                    const toDate = currentFilters.dateTo ? new Date(currentFilters.dateTo) : null;
                    
                    if (fromDate && orderDate < fromDate) {
                        dateMatch = false;
                    }
                    if (toDate && orderDate > toDate) {
                        dateMatch = false;
                    }
                }
                
                if (searchMatch && statusMatch && paymentMatch && dateMatch) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            }
            
            const countElement = document.querySelector('.text-muted');
            if (countElement && visibleCount > 0) {
                const totalRows = rows.length;
                countElement.textContent = `Showing ${visibleCount} of ${totalRows} orders`;
            }
        }
    }
    
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });
    }
    
    // ========== ORDER FORM CALCULATIONS ==========
    // Product selection handler
    document.getElementById('productSelect')?.addEventListener('change', function() {
        const productId = this.value;
        const selectedOption = this.options[this.selectedIndex];
        
        if (productId) {
            document.getElementById('selectedProductID').value = productId;
            document.getElementById('skuDisplay').value = selectedOption.dataset.sku || '';
            
            const category = selectedOption.dataset.category || '';
            const size = selectedOption.dataset.size || '';
            const sizeRow = document.getElementById('sizeRow');
            const sizeDisplay = document.getElementById('sizeDisplay');
            
            if (category.toLowerCase().includes('clothing') && size) {
                sizeRow.style.display = 'block';
                sizeDisplay.value = size;
            } else {
                sizeRow.style.display = 'none';
                sizeDisplay.value = '';
            }
            
            unitPrice = parseFloat(selectedOption.dataset.price) || 0;
            document.getElementById('unitPriceDisplay').value = unitPrice.toFixed(2);
            
            const stock = parseInt(selectedOption.dataset.stock) || 0;
            const quantityInput = document.getElementById('quantity');
            quantityInput.max = stock;
            
            if (parseInt(quantityInput.value) > stock) {
                quantityInput.value = stock;
                    showAlert(`Only ${stock} units available. Quantity adjusted.`, 'warning');
            }
            
            calculateTotals();
        } else {
            resetForm();
        }
    });
    
    // Quantity change handler
    document.getElementById('quantity')?.addEventListener('input', calculateTotals);
    
    // Discount type change handler
    document.getElementById('discountType')?.addEventListener('change', calculateTotals);
    
    // Payment type change handler
    document.getElementById('paymentType')?.addEventListener('change', function() {
        const paymentType = this.value;
        document.getElementById('cashFields').style.display = paymentType === 'Cash' ? 'block' : 'none';
        document.getElementById('gcashFields').style.display = paymentType === 'GCash' ? 'block' : 'none';
        
        const amountTendered = document.getElementById('amountTendered');
        const gcashRef = document.getElementById('gcashReference');
        
        if (paymentType === 'Cash') {
            amountTendered.required = true;
            gcashRef.required = false;
            gcashRef.value = '';
        } else if (paymentType === 'GCash') {
            amountTendered.required = false;
            amountTendered.value = '';
            gcashRef.required = true;
            document.getElementById('changeDisplay').value = '0.00';
        }
        
        updateAmountPaid();
        calculateChange();
    });
    
    // Amount tendered change handler
    document.getElementById('amountTendered')?.addEventListener('input', function() {
        updateAmountPaid();
        calculateChange();
    });
    
    // Calculate totals function
    function calculateTotals() {
        const quantity = parseInt(document.getElementById('quantity')?.value) || 0;
        const discountType = document.getElementById('discountType')?.value;
        
        subtotal = unitPrice * quantity;
        if (document.getElementById('subtotalDisplay')) {
            document.getElementById('subtotalDisplay').value = subtotal.toFixed(2);
            document.getElementById('subtotal').value = subtotal;
        }
        
        let discountRate = 0;
        if (discountType === 'Senior' || discountType === 'PWD') {
            discountRate = 20;
        }
        
        discountAmount = subtotal * (discountRate / 100);
        if (document.getElementById('discountAmountDisplay')) {
            document.getElementById('discountAmountDisplay').value = discountAmount.toFixed(2);
            document.getElementById('discountAmount').value = discountAmount;
        }
        
        grandTotal = subtotal - discountAmount;
        if (document.getElementById('grandTotalDisplay')) {
            document.getElementById('grandTotalDisplay').textContent = '₱' + grandTotal.toFixed(2);
            document.getElementById('grandTotal').value = grandTotal;
        }
        
        updateAmountPaid();
        calculateChange();
    }
    
    // Calculate change function
    function calculateChange() {
        if (document.getElementById('paymentType')?.value === 'Cash' && document.getElementById('changeDisplay')) {
            const amountTendered = parseFloat(document.getElementById('amountTendered').value) || 0;
            const change = amountTendered - grandTotal;
            document.getElementById('changeDisplay').value = change.toFixed(2);
        }
    }

    // Sync amount paid with current payment type
    function updateAmountPaid() {
        const paymentType = document.getElementById('paymentType')?.value;
        const amountPaidInput = document.getElementById('amountPaid');
        if (!amountPaidInput) return;
        
        if (paymentType === 'Cash') {
            const amountTendered = parseFloat(document.getElementById('amountTendered')?.value) || 0;
            amountPaidInput.value = amountTendered;
        } else if (paymentType === 'GCash') {
            amountPaidInput.value = grandTotal;
        } else {
            amountPaidInput.value = 0;
        }

        // Keep the hidden field in sync if FormData was already created in devtools
        amountPaidInput.setAttribute('value', amountPaidInput.value);
    }
    
    // Reset form function
    function resetForm() {
        if (document.getElementById('selectedProductID')) {
            document.getElementById('selectedProductID').value = '';
            document.getElementById('skuDisplay').value = '';
            document.getElementById('sizeDisplay').value = '';
            document.getElementById('unitPriceDisplay').value = '0.00';
            document.getElementById('subtotalDisplay').value = '0.00';
            document.getElementById('discountAmountDisplay').value = '0.00';
            document.getElementById('grandTotalDisplay').textContent = '₱0.00';
            document.getElementById('amountTendered').value = '';
            document.getElementById('changeDisplay').value = '';
            document.getElementById('gcashReference').value = '';
            document.getElementById('amountPaid').value = 0;
            
            unitPrice = 0;
            subtotal = 0;
            discountAmount = 0;
            grandTotal = 0;
        }
    }
    
    // ========== ARCHIVE ORDER FUNCTIONALITY ==========
    document.querySelectorAll('.archive-order').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.dataset.orderId;
            const orderCode = this.dataset.orderCode;
            const form = document.getElementById('archiveOrderForm');
            
            if (document.getElementById('archiveOrderId')) {
                document.getElementById('archiveOrderId').textContent = `Order ${orderCode}`;
                form.action = `/cashier/sales/${orderId}/archive`;
            }
        });
    });
    
    // ========== VIEW ORDER FUNCTIONALITY ==========
    document.querySelectorAll('.view-order').forEach(button => {
        button.addEventListener('click', function() {
            const orderId = this.dataset.orderId;
            
            fetch(`/cashier/sales/${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const order = data.order;
                        
                        document.getElementById('viewOrderId').textContent = order.OrderID;
                        document.getElementById('viewOrderNo').textContent = order.OrderID;
                        document.getElementById('viewOrderDate').textContent = 
                            new Date(order.OrderDateTime).toLocaleString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        document.getElementById('viewOrderStatus').textContent = order.OrderStatus;
                        document.getElementById('viewPaymentMethod').textContent = order.PaymentType || 'N/A';
                        document.getElementById('viewEmployee').textContent = 
                            `${order.Employee?.EmployeeName || 'N/A'} (${order.Employee?.EmployeeID || 'N/A'})`;
                        
                        const itemsContainer = document.getElementById('viewOrderItems');
                        itemsContainer.innerHTML = '';
                        
                        data.details.forEach(detail => {
                            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${detail.ProductName || 'N/A'}</td>
                <td>₱${parseFloat(detail.UnitPrice || 0).toFixed(2)}</td>
                <td>${detail.Quantity || 0}</td>
                <td>₱${parseFloat(detail.Subtotal || 0).toFixed(2)}</td>
            `;
                            itemsContainer.appendChild(row);
                        });
                        
        document.getElementById('viewSubtotal').textContent = `₱${parseFloat(order.SubTotal).toFixed(2)}`;
        document.getElementById('viewDiscount').textContent = `-₱${parseFloat(order.DiscountAmount).toFixed(2)}`;
        document.getElementById('viewGrandTotal').textContent = `₱${parseFloat(order.GrandTotal).toFixed(2)}`;
                    }
                })
                .catch(error => {
                    console.error('Error fetching order details:', error);
                    showAlert('Error loading order details. Please try again.', 'error');
                });
        });
    });
    
    // ========== ORDER FORM SUBMISSION ==========
    const createOrderForm = document.getElementById('createOrderForm');
    if (createOrderForm) {
        createOrderForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submitOrderBtn');
            const loadingSpinner = document.getElementById('orderLoading');
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            loadingSpinner.style.display = 'block';
            
        // Ensure calculated fields are synced before submission
        updateAmountPaid();
        
        const formData = new FormData(this);
        // Force AmountPaid into the payload to satisfy validation
        formData.set('AmountPaid', document.getElementById('amountPaid')?.value || '0');

        // Debug: log outgoing payload keys/values to help diagnose 422s
        console.log('Submitting order payload:');
        for (const [key, value] of formData.entries()) {
            console.log(`${key}:`, value);
        }
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                const contentType = response.headers.get('content-type') || '';
                let payload = null;
                
                if (contentType.includes('application/json')) {
                    payload = await response.json();
                } else {
                    const text = await response.text();
                    throw new Error(text || 'Unexpected non-JSON response');
                }
                
                if (!response.ok) {
                    // Laravel validation errors (422) or other failure responses
                    if (payload?.errors) {
                        const flatErrors = Object.values(payload.errors).flat().join('\n');
                        throw new Error(flatErrors || payload.message || 'Validation failed.');
                    }
                    throw new Error(payload?.message || 'Request failed.');
                }
                
                return payload;
            })
            .then(data => {
                if (data.success) {
                    showAlert(`Order created successfully!\nOrder ID: ${data.orderId}\nTotal: ₱${data.grandTotal}`, 'success');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('createOrderModal'));
                    modal.hide();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showAlert('Error: ' + (data.message || 'Unknown error'), 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const msg = error?.message?.slice(0, 500) || 'An error occurred. Please try again.';
                showAlert(`An error occurred. Please try again.\n${msg}`, 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Complete Order';
                loadingSpinner.style.display = 'none';
            });
        });
    }
    
    // ========== PAYMENTS FUNCTIONALITY ==========
    document.querySelectorAll('.view-payment').forEach(button => {
        button.addEventListener('click', function() {
            const paymentId = this.dataset.paymentId;
            
            fetch(`/cashier/payments/${paymentId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const payment = data.payment;
                        const order = payment.order;
                        
                        document.getElementById('viewPaymentId').textContent = payment.PaymentID;
                        document.getElementById('viewPaymentNo').textContent = payment.PaymentID;
                        document.getElementById('viewPaymentOrderId').textContent = payment.OrderID;
                        document.getElementById('viewPaymentDate').textContent = 
                            new Date(payment.PaymentDate).toLocaleString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        document.getElementById('viewPaymentStatus').textContent = payment.PaymentStatus;
                        document.getElementById('viewPaymentMethod').textContent = payment.PaymentType;
                        document.getElementById('viewPaymentReference').textContent = payment.ReferenceNumber || 'N/A';
                        document.getElementById('viewPaymentAmount').textContent = `₱${parseFloat(payment.Amount).toFixed(2)}`;
                        
                        const itemsContainer = document.getElementById('viewPaymentItems');
                        itemsContainer.innerHTML = '';
                        
                        if (order && order.details) {
                            order.details.forEach(detail => {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                                    <td>${detail.product?.ProductName || 'N/A'}</td>
                                    <td>₱${parseFloat(detail.UnitPrice || 0).toFixed(2)}</td>
                                    <td>${detail.Quantity || detail.OrderQty || 0}</td>
                                    <td>₱${parseFloat(detail.Subtotal || 0).toFixed(2)}</td>
                                `;
                                itemsContainer.appendChild(row);
                            });
                            
                            document.getElementById('viewPaymentSubtotal').textContent = `₱${parseFloat(order.SubTotal || 0).toFixed(2)}`;
                            document.getElementById('viewPaymentDiscount').textContent = `-₱${parseFloat(order.DiscountAmount || 0).toFixed(2)}`;
                            document.getElementById('viewPaymentGrandTotal').textContent = `₱${parseFloat(order.GrandTotal || 0).toFixed(2)}`;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error fetching payment details:', error);
                    showAlert('Error loading payment details. Please try again.', 'error');
                });
        });
    });
    
    document.querySelectorAll('.view-payment-order').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const orderId = this.dataset.orderId;
            
            const viewOrderBtn = document.querySelector(`.view-order[data-order-id="${orderId}"]`);
            if (viewOrderBtn) {
                viewOrderBtn.click();
                document.getElementById('orders-tab').click();
            } else {
                showAlert('Order details not found. The order might not exist anymore.', 'warning');
            }
        });
    });
    
    document.querySelectorAll('.print-receipt').forEach(button => {
        button.addEventListener('click', function() {
            const paymentId = this.dataset.paymentId;
            showAlert(`Printing receipt for payment ${paymentId}`, 'info');
        });
    });
    
    document.querySelector('.print-payment-receipt')?.addEventListener('click', function() {
        const paymentId = document.getElementById('viewPaymentNo').textContent;
        showAlert(`Printing receipt for payment ${paymentId}`, 'info');
    });
    
    // ========== HELPER FUNCTIONS ==========
    function showAlert(message, type = 'info') {
        const existingAlerts = document.querySelectorAll('.alert-dismissible:not(.alert-success):not(.alert-danger):not(.alert-warning):not(.alert-info)');
        existingAlerts.forEach(alert => alert.remove());
        
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        
        let icon = 'fa-info-circle';
        if (type === 'success') icon = 'fa-check-circle';
        if (type === 'error') icon = 'fa-exclamation-circle';
        if (type === 'warning') icon = 'fa-exclamation-triangle';
        
        alertDiv.innerHTML = `
            <i class="fas ${icon} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const topbar = document.querySelector('.topbar');
        if (topbar) {
            topbar.parentNode.insertBefore(alertDiv, topbar.nextSibling);
        }
        
        setTimeout(() => {
            if (alertDiv.parentNode) {
                const bsAlert = new bootstrap.Alert(alertDiv);
                bsAlert.close();
            }
        }, 5000);
    }
    
    // ========== INITIALIZE ==========
    calculateTotals();
    updateCurrentFilters();
    updateActiveFilters();
    filterOrders();
    
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
    
    document.getElementById('createOrderModal')?.addEventListener('hidden.bs.modal', function() {
        resetForm();
        calculateTotals();
    });
});
</script>
</body>
</html>
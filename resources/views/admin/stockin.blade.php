<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Stock In | Dora's Oshoppe</title>
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

        /* ========== SIDEBAR STYLES ========== */
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

        .sidebar.collapsed { min-width: 70px; max-width: 70px; }
        .sidebar.collapsed .brand-text,
        .sidebar.collapsed .nav-link span:not(.fa),
        .sidebar.collapsed .nav-link .fa-chevron-down { display: none; }
        .sidebar.collapsed .brand { justify-content: center; }
        .sidebar.collapsed .nav-link { justify-content: center; text-align: center; }
        .sidebar.collapsed .nav-link i { margin-right: 0; }

        .brand { display: flex; align-items: center; gap: 10px; margin-bottom: 18px; flex-shrink: 0; }
        .brand img { width: 40px; height: 40px; object-fit: contain; }
        .brand-text { flex: 1; }

        .sidebar .nav-link { 
            color: #5b5f72; padding: 12px 8px; border-radius: 10px; font-size: 0.95rem;
            display: flex; align-items: center; transition: all 0.2s ease;
        }
        .sidebar .nav-link.active { background: #efeaff; color: var(--primary-color); font-weight: 600; }
        .sidebar .nav-link:hover { background: #f8f9fa; transform: translateX(2px); }
        .sidebar .nav-link i { width: 20px; margin-right: 10px; text-align: center; }

        .sidebar-nav { flex: 1; overflow-y: auto; margin-top: 18px; }
        .nav .nav.flex-column.ms-3 { border-left: 2px solid #eef2f7; margin-left: 12px !important; padding-left: 8px; }
        .nav .nav.flex-column.ms-3 .nav-link { padding: 10px 12px; font-size: 0.9rem; border-radius: 6px; }

        .sidebar-toggle { display: none; position: fixed; top: 15px; left: 15px; z-index: 1001;
            background: var(--primary-color); color: white; border: none; border-radius: 8px;
            width: 40px; height: 40px; align-items: center; justify-content: center; font-size: 1.2rem; }
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); z-index: 999; }

        /* ========== CONTENT AREA ========== */
        .content-wrap { margin-left: 240px; padding: 28px; transition: all 0.3s ease; }
        .content-wrap.expanded { margin-left: 0; }

        .topbar { display: flex; gap: 16px; align-items: flex-start; justify-content: space-between;
            margin-bottom: 22px; flex-wrap: wrap; }
        .page-title-section { flex: 1; min-width: 250px; }

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

        /* ========== TABLE ========== */
        .table-card { 
            border-radius: 12px; 
            border: none; 
            box-shadow: var(--card-shadow); 
            overflow: hidden; 
        }
        
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
        
        .status-received { 
            color: var(--success-color); 
        }
        
        .status-defective { 
            color: var(--danger-color); 
        }
        
        .status-expired { 
            color: var(--warning-color); 
        }

        .action-buttons { 
            display: flex; 
            gap: 4px; 
            flex-wrap: nowrap; 
        }
        
        .action-buttons .btn { 
            padding: 6px 8px; 
            font-size: 0.8rem; 
        }

        /* Low stock warning */
        .low-stock {
            background-color: #fff3cd !important;
            border-left: 4px solid #ffc107;
        }
        
        .low-stock-warning {
            color: #856404;
            font-size: 0.8rem;
            font-weight: 500;
            margin-top: 4px;
        }

        /* ========== FORM STYLES ========== */
        .form-label.required::after {
            content: " *";
            color: var(--danger-color);
        }
        
        .readonly-field {
            background-color: #f8f9fa;
            color: #6c757d;
            cursor: not-allowed;
        }
        
        .supplier-info {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 2px;
        }
        
        .product-info-line {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
        }
        
        .category-badge {
            font-size: 0.75rem;
            padding: 2px 8px;
        }

        /* ========== MODAL STYLES ========== */
        .modal-content {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .modal-header {
            border-bottom: 1px solid #eef2f7;
            padding: 20px 24px;
        }
        
        /* ========== RESPONSIVE ========== */
        @media (max-width: 991.98px) {
            .sidebar { 
                position: fixed; 
                transform: translateX(-100%); 
                z-index: 1000; 
                width: 280px; 
                max-width: 280px; 
                box-shadow: 2px 0 10px rgba(0,0,0,0.1); 
            }
            
            .sidebar.mobile-open { 
                transform: translateX(0); 
            }
            
            .sidebar-toggle, .sidebar-overlay { 
                display: flex !important; 
            }
            
            .content-wrap { 
                margin-left: 0; 
                padding: 70px 16px 16px; 
            }
            
            .topbar { 
                flex-direction: column; 
                align-items: stretch; 
                gap: 20px; 
            }
            
            .user-section, .search-filter-section { 
                min-width: 100%; 
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
        // Check if user has an employee record
        // Method 1: If user has employee relationship
        if (isset($user->employee) && $user->employee) {
            $employeeName = $user->employee->EmployeeName ?? 
                           ($user->employee->EmployeeFName . ' ' . $user->employee->EmployeeLName) ?? 
                           $user->name;
            $employeeId = $user->employee->EmployeeID ?? null;
        }
        // Method 2: If user has direct employee fields
        elseif (isset($user->EmployeeName)) {
            $employeeName = $user->EmployeeName;
            $employeeId = $user->EmployeeID ?? null;
        }
        // Method 3: Fallback to user's name
        else {
            $employeeName = $user->name ?? 'Admin';
        }
    }
    
    // Set default date
    $today = date('Y-m-d');
@endphp


<!-- Mobile Sidebar Toggle -->
<button class="sidebar-toggle" id="sidebarToggle">
    <i class="fas fa-bars"></i>
</button>
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
                    <a class="nav-link" href="{{ route('admin.supplier') }}"><i class="fas fa-truck"></i> <span>Suppliers</span></a>
                    <a class="nav-link" href="{{ route('admin.employees') }}"><i class="fas fa-users"></i> <span>Employees</span></a>
                    <a class="nav-link" href="{{ route('admin.products') }}"><i class="fas fa-box"></i> <span>Products</span></a>
                </div>
            </div>

            <a class="nav-link dropdown-toggle active" href="#" data-bs-toggle="collapse" data-bs-target="#inventorySubmenu">
                <i class="fas fa-exchange-alt"></i> <span>Inventory</span>
            </a>
            <div class="collapse show" id="inventorySubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link active" href="{{ route('admin.stockin') }}"><i class="fas fa-arrow-circle-down"></i> <span>Stock In</span></a>
                    <a class="nav-link" href="{{ route('admin.pullout') }}"><i class="fas fa-arrow-circle-up"></i> <span>Pullouts</span></a>
                </div>
            </div>

            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#reportsSubmenu">
                <i class="fas fa-chart-bar"></i> <span>Reports</span>
            </a>
            <div class="collapse" id="reportsSubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link" href="{{ route('admin.transaction') }}"><i class="fas fa-file-invoice-dollar"></i> <span>Transaction</span></a>
                    <a class="nav-link" href="{{ route('admin.inventory') }}"><i class="fas fa-clipboard-list"></i> <span>Inventory</span></a>
                </div>
            </div>
        </nav>
    </div>
</aside>

<main class="content-wrap" id="contentWrap">
    <div class="topbar">
        <div class="page-title-section">
            <h4 class="mb-1">Stock In Management</h4>
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
                <div class="search-filter-section">
                    <div class="input-group search-input">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search stock records..." id="searchInput">
                    </div>

                    <div class="filter-dropdown">
                        <button class="filter-toggle" id="filterToggle">
                            <i class="fas fa-filter"></i> <span>Filter</span>
                            <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
                        </button>

                        <div class="filter-menu" id="filterMenu">
                            <div class="filter-section">
                                <div class="filter-section-title">Product Status</div>
                                <div class="filter-options">
                                    <div class="filter-option"><input type="checkbox" id="status-all" checked><label for="status-all">All Status</label></div>
                                    <div class="filter-option"><input type="checkbox" id="status-received"><label for="status-received">Received</label></div>
                                    <div class="filter-option"><input type="checkbox" id="status-defective"><label for="status-defective">Defective</label></div>
                                    <div class="filter-option"><input type="checkbox" id="status-expired"><label for="status-expired">Expired</label></div>
                                </div>
                            </div>

                            <div class="filter-section">
                                <div class="filter-section-title">By Category</div>
                                <div class="filter-options">
                                    <div class="filter-option"><input type="checkbox" id="category-all" checked><label for="category-all">All Categories</label></div>
                                    @foreach($categories as $cat)
                                    <div class="filter-option"><input type="checkbox" id="category-{{ $cat->CategoryID }}"><label for="category-{{ $cat->CategoryID }}">{{ $cat->CategoryName }}</label></div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="filter-actions">
                                <button class="btn-apply" id="applyFilters">Apply Filters</button>
                                <button class="btn-clear" id="clearFilters">Reset Filters</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="active-filters" id="activeFilters"></div>
            </div>
        </div>
    </div>

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

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>Please fix the following errors:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card table-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <h5 class="card-title mb-0">Stock In Records</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStockModal">
                    <i class="fas fa-plus me-2"></i>Add Stock
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="stockTable">
                    <thead class="table-light">
                        <tr>
                            <th>StockInID</th>
                            <th>Product Information</th>
                            <th>Qty</th>
                            <th>Status</th>
                            <th>Date Received</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="stockTableBody">
                        @forelse($stockIns as $stock)
                        @php
                            $isLowStock = $stock->product && $stock->product->StockQty <= $stock->product->ReorderLevel;
                        @endphp
                        <tr data-status="{{ $stock->ProdStatus }}" data-category="{{ $stock->product->category->CategoryID ?? '' }}"
                            class="{{ $isLowStock ? 'low-stock' : '' }}" id="stock-row-{{ $stock->StockInID }}">
                            <td><strong>{{ $stock->StockInID }}</strong></td>
                            <td>
                                <div class="product-info-line">
                                    <div class="fw-semibold">{{ $stock->product->ProductName ?? 'Product Not Found' }}</div>
                                </div>
                                <div class="text-muted small">SKU: {{ $stock->product->SKUNumber ?? 'N/A' }}</div>
                                
                                @if($stock->product && $stock->product->supplier)
                                <div class="supplier-info">
                                    <i ></i>
                                    {{ $stock->product->supplier->SupplierName }}
                                </div>
                                @endif
                                
                                @if($isLowStock && $stock->product)
                                <div class="low-stock-warning">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Low stock! Current: {{ $stock->product->StockQty }} | Reorder level: {{ $stock->product->ReorderLevel }}
                                </div>
                                @endif
                            </td>
                            <td><span class="badge bg-primary fs-6">{{ $stock->Qty }}</span></td>
                            <td>
                                @if($stock->ProdStatus == 'Received')
                                    <span class="status-badge status-received">Good</span>
                                @elseif($stock->ProdStatus == 'Defective')
                                    <span class="status-badge status-defective">Damaged</span>
                                @elseif($stock->ProdStatus == 'Expired')
                                    <span class="status-badge status-expired">Expired</span>
                                @else
                                    <span class="badge bg-secondary">{{ $stock->ProdStatus }}</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($stock->DateRcvd)->format('M d, Y') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-outline-primary view-stock" 
                                            data-stock-id="{{ $stock->StockInID }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-stock" 
                                            data-stock-id="{{ $stock->StockInID }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-2x mb-3"></i>
                                <h5>No stock records found</h5>
                                <p class="mb-0">Add your first stock record using the "Add Stock" button</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Add Stock Modal -->
<div class="modal fade" id="addStockModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Stock In</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="{{ route('admin.stockin.store') }}" method="POST" id="stockInForm">
                @csrf
                <div class="modal-body">
                    <!-- Product Selection -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label class="form-label required">Product</label>
                            <select class="form-select" name="ProductID" id="productSelect" required>
                                <option value="">-- Select Product --</option>
                                @foreach($existingProducts as $product)
                                    <option value="{{ $product->ProductID }}"
                                        data-sku="{{ $product->SKUNumber }}"
                                        data-supplier-name="{{ $product->supplier?->SupplierName }}"
                                        data-supplier-id="{{ $product->SupplierID }}"
                                        data-category-id="{{ $product->CategoryID }}"
                                        data-category-name="{{ $product->category?->CategoryName }}"
                                        data-size="{{ $product->Size }}"
                                        data-type="{{ $product->Type }}"
                                        data-current-stock="{{ $product->StockQty ?? 0 }}"
                                        data-reorder-level="{{ $product->ReorderLevel ?? 10 }}"
                                        data-cost-price="{{ $product->OriginalPrice ?? 0 }}"
                                        data-markup-rate="{{ $product->MarkupRate ?? 30 }}">
                                        {{ $product->ProductID }} - {{ $product->ProductName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">SKU Number</label>
                            <input type="text" class="form-control" id="skuDisplay" readonly>
                        </div>
                    </div>

                    <!-- Supplier Information -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Supplier Information</label>
                            <div class="form-control readonly-field">
                                <strong id="supplierDisplay">-</strong>
                            </div>
                            <input type="hidden" name="SupplierID" id="supplierIdHidden">
                        </div>
                    </div>

                    <!-- Conditional Fields Row -->
                    <div class="row mb-3">
                        <!-- Expiration Date (Conditional: Beauty category) -->
                        <div class="col-md-4" id="expirationField" style="display:none;">
                            <label class="form-label">Expiration Date</label>
                            <input type="date" class="form-control" name="ExpirationDate" id="expirationDate">
                        </div>

                        <!-- Size (Conditional: RTW category) -->
                        <div class="col-md-4" id="sizeField" style="display:none;">
                            <label class="form-label">Size</label>
                            <input type="text" class="form-control" name="Size" id="sizeInput" placeholder="e.g., S, M, L, XL">
                        </div>

                        <!-- Type (Conditional: Jewelry, Accessories, School Supplies, Bags) -->
                        <div class="col-md-4" id="typeField" style="display:none;">
                            <label class="form-label">Type</label>
                            <input type="text" class="form-control" name="Type" id="typeInput" placeholder="e.g., Necklace, Earring, etc.">
                        </div>
                    </div>

                    <!-- Quantity & Date -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label required">Quantity Received</label>
                            <input type="number" min="1" class="form-control" name="Qty" id="qtyInput" required value="1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Reorder Level</label>
                            <input type="number" min="1" class="form-control" name="ReorderLevel" id="reorderLevelInput" value="10">
                            <small class="text-muted">This updates the product's reorder level</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">Date & Time Received</label>
                            <input type="datetime-local" class="form-control" name="DateRcvd" id="dateReceived" value="{{ date('Y-m-d\TH:i') }}" required>
                        </div>
                    </div>

                    <!-- Stock Information -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="id-info">
                                <div class="row text-center">
                                    <div class="col-md-4 border-end">
                                        <small class="text-muted d-block">Current Stock</small>
                                        <strong id="currentStock" class="fs-5">0</strong> units
                                    </div>
                                    <div class="col-md-4 border-end">
                                        <small class="text-muted d-block">After Adding</small>
                                        <strong id="afterAdding" class="fs-5">0</strong> units
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted d-block">Reorder Level</small>
                                        <strong id="reorderLevelDisplay" class="fs-5">0</strong> units
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Low Stock Warning -->
                    <div class="alert alert-warning mb-3" id="reorderAlert" style="display:none;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>
                            <strong>Low Stock Warning!</strong>
                            <span id="reorderText" class="small d-block"></span>
                        </div>
                    </div>

                    <!-- Status Selection -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label required">Product Status</label>
                            <select class="form-select" name="ProdStatus" required id="prodStatusSelect">
                                <option value="Received">Good Condition</option>
                                <option value="Defective">Damaged/Defective</option>
                                <option value="Expired">Expired</option>
                            </select>
                        </div>
                    </div>

                    <!-- Pricing Section -->
                    <div class="mb-4">
                        <h6 class="mb-3">Pricing Information</h6>
                        <div class="row g-3">
                            <!-- Cost Price -->
                            <div class="col-md-4">
                                <label class="form-label required">Cost Price (₱)</label>
                                <input type="number" step="0.01" min="0" class="form-control" 
                                       id="costPrice" name="OriginalPrice" required placeholder="0.00">
                            </div>

                            <!-- Markup Rate -->
                            <div class="col-md-4">
                                <label class="form-label required">Markup Rate (%)</label>
                                <input type="number" step="0.1" min="0" class="form-control" 
                                       id="markupRate" name="MarkupRate" required value="30" placeholder="30">
                            </div>

                            <!-- Retail Price (Calculated) -->
                            <div class="col-md-4">
                                <label class="form-label required">Retail Price (₱)</label>
                                <input type="text" class="form-control" id="retailPriceDisplay" readonly>
                                <input type="hidden" name="RetailPrice" id="retailPriceHidden">
                            </div>
                        </div>
                        <div class="row mt-2 text-center">
                            <div class="col-md-4">
                                <small class="text-muted">Cost: <span id="costSummary">₱0.00</span></small>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Markup: <span id="markupSummary">0%</span></small>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Retail: <span id="retailSummary">₱0.00</span></small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-2"></i> Add Stock
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Stock Modal -->
<div class="modal fade" id="viewStockModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-3">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold"><i class="fas fa-eye me-2"></i>Stock Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewStockContent">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteStockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this stock record?</p>
                <p class="text-muted small">This action cannot be undone. The product stock quantity will be adjusted accordingly.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteStockForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Record</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== SIDEBAR FUNCTIONALITY ==========
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
    
    // ========== USER DROPDOWN ==========
    document.getElementById('userDropdownToggle')?.addEventListener('click', function(e) {
        e.stopPropagation();
        const menu = document.getElementById('userDropdownMenu');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    });
    
    document.addEventListener('click', function() {
        document.getElementById('userDropdownMenu').style.display = 'none';
    });
    
    // ========== FILTER FUNCTIONALITY ==========
    const filterToggle = document.getElementById('filterToggle');
    const filterMenu = document.getElementById('filterMenu');
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('stockTableBody');
    const applyFiltersBtn = document.getElementById('applyFilters');
    const clearFiltersBtn = document.getElementById('clearFilters');
    
    filterToggle?.addEventListener('click', function(e) {
        e.stopPropagation();
        filterMenu.classList.toggle('show');
        filterToggle.classList.toggle('active', filterMenu.classList.contains('show'));
    });
    
    document.addEventListener('click', function(e) {
        if (!filterMenu.contains(e.target) && !filterToggle.contains(e.target)) {
            filterMenu.classList.remove('show');
            filterToggle.classList.remove('active');
        }
    });
    
    // Apply filters
    applyFiltersBtn?.addEventListener('click', function() {
        filterMenu.classList.remove('show');
        filterToggle.classList.remove('active');
        applyFilters();
    });
    
    // Clear filters
    clearFiltersBtn?.addEventListener('click', function() {
        document.querySelectorAll('.filter-option input[type="checkbox"]').forEach(cb => {
            cb.checked = cb.id.includes('-all');
        });
        searchInput.value = '';
        applyFilters();
    });
    
    // Search functionality
    searchInput?.addEventListener('input', applyFilters);
    
    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusFilters = [];
        const categoryFilters = [];
        
        // Get status filters
        if (!document.getElementById('status-all').checked) {
            if (document.getElementById('status-received').checked) statusFilters.push('Received');
            if (document.getElementById('status-defective').checked) statusFilters.push('Defective');
            if (document.getElementById('status-expired').checked) statusFilters.push('Expired');
        }
        
        // Get category filters
        if (!document.getElementById('category-all').checked) {
            @foreach($categories as $cat)
            if (document.getElementById('category-{{ $cat->CategoryID }}')?.checked) {
                categoryFilters.push('{{ $cat->CategoryID }}');
            }
            @endforeach
        }
        
        // Filter rows
        const rows = tableBody.querySelectorAll('tr');
        let visibleCount = 0;
        
        rows.forEach(row => {
            if (row.cells.length < 2) {
                row.style.display = '';
                visibleCount++;
                return;
            }
            
            const text = row.textContent.toLowerCase();
            const status = row.dataset.status;
            const category = row.dataset.category;
            
            // Check search
            const searchMatch = searchTerm === '' || text.includes(searchTerm);
            
            // Check status
            const statusMatch = statusFilters.length === 0 || statusFilters.includes(status);
            
            // Check category
            const categoryMatch = categoryFilters.length === 0 || categoryFilters.includes(category);
            
            // Show/hide row
            if (searchMatch && statusMatch && categoryMatch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    // ========== ADD STOCK MODAL FUNCTIONALITY ==========
    // Form elements
    const productSelect = document.getElementById('productSelect');
    const skuDisplay = document.getElementById('skuDisplay');
    const supplierDisplay = document.getElementById('supplierDisplay');
    const supplierIdHidden = document.getElementById('supplierIdHidden');
    
    // Conditional fields containers
    const expirationField = document.getElementById('expirationField');
    const sizeField = document.getElementById('sizeField');
    const typeField = document.getElementById('typeField');
    
    // Conditional fields inputs
    const expirationDate = document.getElementById('expirationDate');
    const sizeInput = document.getElementById('sizeInput');
    const typeInput = document.getElementById('typeInput');
    
    // Stock information
    const currentStockEl = document.getElementById('currentStock');
    const afterAddingEl = document.getElementById('afterAdding');
    const reorderLevelDisplay = document.getElementById('reorderLevelDisplay');
    const reorderLevelInput = document.getElementById('reorderLevelInput');
    
    // Low stock warning
    const reorderAlert = document.getElementById('reorderAlert');
    const reorderText = document.getElementById('reorderText');
    
    // Quantity input
    const qtyInput = document.getElementById('qtyInput');
    
    // Pricing fields
    const costPrice = document.getElementById('costPrice');
    const markupRate = document.getElementById('markupRate');
    const retailPriceDisplay = document.getElementById('retailPriceDisplay');
    const retailPriceHidden = document.getElementById('retailPriceHidden');
    const costSummary = document.getElementById('costSummary');
    const markupSummary = document.getElementById('markupSummary');
    const retailSummary = document.getElementById('retailSummary');
    
    // Date received
    const dateReceived = document.getElementById('dateReceived');
    const prodStatusSelect = document.getElementById('prodStatusSelect');
    
    // Set default date-time to current
    const now = new Date();
    const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
    dateReceived.value = localDateTime;

    // Product selection handler
    productSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (selectedOption.value) {
            // Update displayed info
            skuDisplay.value = selectedOption.dataset.sku || 'N/A';
            supplierDisplay.textContent = selectedOption.dataset.supplierName || 'No Supplier';
            supplierIdHidden.value = selectedOption.dataset.supplierId || '';
            
            // Get category info
            const categoryId = selectedOption.dataset.categoryId || '';
            const categoryName = selectedOption.dataset.categoryName || '';
            
            // Handle conditional fields based on category
            handleConditionalFields(categoryId, categoryName, selectedOption);
            
            // Update stock information
            updateStockInformation(selectedOption);
            
            // Update pricing
            updatePricingInformation(selectedOption);
            
            // Check for low stock
            checkReorderLevel();
        } else {
            // Clear all fields if no product selected
            resetForm();
        }
    });

    // Handle conditional fields based on category
    function handleConditionalFields(categoryId, categoryName, selectedOption) {
        // Reset all conditional fields
        hideAllConditionalFields();
        
        // Beauty & Skincare category (show expiration date)
        // Assuming Beauty category has ID 3 or contains 'beauty'/'skincare' in name
        if (categoryId == '3' || categoryName.toLowerCase().includes('beauty') || 
            categoryName.toLowerCase().includes('skincare')) {
            expirationField.style.display = 'block';
            // Set default expiration date (2 years from now)
            const twoYears = new Date();
            twoYears.setFullYear(twoYears.getFullYear() + 2);
            expirationDate.valueAsDate = twoYears;
        }
        
        // RTW/Clothing category (show size)
        if (categoryName.toLowerCase().includes('rtw') || 
            categoryName.toLowerCase().includes('clothing') ||
            categoryName.toLowerCase().includes('apparel')) {
            sizeField.style.display = 'block';
            sizeInput.value = selectedOption.dataset.size || '';
        }
        
        // Jewelry, Accessories, School Supplies, Bags category (show type)
        const typeCategories = ['jewelry', 'accessories', 'school supplies', 'bags', 'stationery'];
        const categoryLower = categoryName.toLowerCase();
        
        if (typeCategories.some(typeCat => categoryLower.includes(typeCat))) {
            typeField.style.display = 'block';
            typeInput.value = selectedOption.dataset.type || '';
        }
    }

    // Hide all conditional fields
    function hideAllConditionalFields() {
        expirationField.style.display = 'none';
        sizeField.style.display = 'none';
        typeField.style.display = 'none';
        
        expirationDate.value = '';
        sizeInput.value = '';
        typeInput.value = '';
    }

    // Update stock information
    function updateStockInformation(selectedOption) {
        const currentStock = parseInt(selectedOption.dataset.currentStock) || 0;
        const reorderLevel = parseInt(selectedOption.dataset.reorderLevel) || 10;
        const qty = parseInt(qtyInput.value) || 0;
        const status = prodStatusSelect.value;
        
        currentStockEl.textContent = currentStock;
        reorderLevelDisplay.textContent = reorderLevel;
        reorderLevelInput.value = reorderLevel;
        
        // Only add quantity if status is "Received"
        if (status === 'Received') {
            afterAddingEl.textContent = currentStock + qty;
        } else {
            afterAddingEl.textContent = currentStock;
        }
    }

    // Update pricing information
    function updatePricingInformation(selectedOption) {
        const cost = parseFloat(selectedOption.dataset.costPrice) || 0;
        const markup = parseFloat(selectedOption.dataset.markupRate) || 30;
        
        costPrice.value = cost > 0 ? cost.toFixed(2) : '';
        markupRate.value = markup;
        calculateRetailPrice();
    }

    // Calculate retail price
    function calculateRetailPrice() {
        const cost = parseFloat(costPrice.value) || 0;
        const markup = parseFloat(markupRate.value) || 0;
        
        if (cost > 0 && markup >= 0) {
            const retail = cost + (cost * markup / 100);
            retailPriceDisplay.value = '₱' + retail.toFixed(2);
            retailPriceHidden.value = retail.toFixed(2);
            
            // Update summary
            costSummary.textContent = '₱' + cost.toFixed(2);
            markupSummary.textContent = markup + '%';
            retailSummary.textContent = '₱' + retail.toFixed(2);
        } else {
            retailPriceDisplay.value = '';
            retailPriceHidden.value = '';
            costSummary.textContent = '₱0.00';
            markupSummary.textContent = '0%';
            retailSummary.textContent = '₱0.00';
        }
    }

    // Check reorder level
    function checkReorderLevel() {
        const currentStock = parseInt(currentStockEl.textContent) || 0;
        const reorderLevel = parseInt(reorderLevelDisplay.textContent) || 10;
        const qty = parseInt(qtyInput.value) || 0;
        const status = prodStatusSelect.value;
        
        if (status === 'Received') {
            const newTotal = currentStock + qty;
            afterAddingEl.textContent = newTotal;
            afterAddingEl.className = newTotal <= reorderLevel ? 'fs-5 text-danger' : 'fs-5 text-primary';
            
            if (newTotal <= reorderLevel) {
                reorderAlert.style.display = 'flex';
                if (newTotal === 0) {
                    reorderText.textContent = 'Product will be OUT OF STOCK after this entry!';
                } else if (newTotal < reorderLevel) {
                    reorderText.textContent = Stock will be BELOW reorder level (${reorderLevel} units) after adding.;
                } else {
                    reorderText.textContent = Stock will be AT reorder level (${reorderLevel} units) after adding.;
                }
            } else {
                reorderAlert.style.display = 'none';
            }
        } else {
            // For Defective/Expired items, stock doesn't increase
            afterAddingEl.textContent = currentStock;
            afterAddingEl.className = 'fs-5 text-primary';
            reorderAlert.style.display = 'none';
        }
    }

    // Reset form function
    function resetForm() {
        skuDisplay.value = '';
        supplierDisplay.textContent = '-';
        supplierIdHidden.value = '';
        
        hideAllConditionalFields();
        
        currentStockEl.textContent = '0';
        afterAddingEl.textContent = '0';
        reorderLevelDisplay.textContent = '0';
        reorderLevelInput.value = '10';
        
        reorderAlert.style.display = 'none';
        
        costPrice.value = '';
        markupRate.value = '30';
        retailPriceDisplay.value = '';
        retailPriceHidden.value = '';
        costSummary.textContent = '₱0.00';
        markupSummary.textContent = '0%';
        retailSummary.textContent = '₱0.00';
        
        qtyInput.value = '1';
    }

    // Quantity change handler
    qtyInput.addEventListener('input', function() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption.value) {
            updateStockInformation(selectedOption);
            checkReorderLevel();
        }
    });

    // Status change handler
    prodStatusSelect.addEventListener('change', function() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption.value) {
            updateStockInformation(selectedOption);
            checkReorderLevel();
        }
    });

    // Reorder level change handler
    reorderLevelInput.addEventListener('input', function() {
        reorderLevelDisplay.textContent = this.value || '0';
    });

    // Pricing calculation listeners
    costPrice.addEventListener('input', calculateRetailPrice);
    markupRate.addEventListener('input', calculateRetailPrice);

    // Initialize calculation on page load
    calculateRetailPrice();

    // Initialize form reset when modal is closed
    const addStockModal = document.getElementById('addStockModal');
    if (addStockModal) {
        addStockModal.addEventListener('hidden.bs.modal', function() {
            productSelect.selectedIndex = 0;
            resetForm();
            dateReceived.value = localDateTime;
        });
    }
    
    // ========== VIEW STOCK DETAILS ==========
    document.querySelectorAll(.view-stock).forEach(button => {
        button.addEventListener(click, function() {
            const stockId = this.dataset.stockId;
            loadStockDetails(stockId);
        });
    });

    // Function to load stock details
    function loadStockDetails(stockId) {
        const viewContent = document.getElementById(viewStockContent);
        
        // Show loading state
        viewContent.innerHTML = 
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3 text-muted">Loading stock details...</p>
            </div>
        ;
        
        // Show modal
        const viewModal = new bootstrap.Modal(document.getElementById(viewStockModal));
        viewModal.show();
        
        // Load stock details via AJAX
        fetch(/admin/stockin/${stockId})
            .then(response => {
                if (!response.ok) {
                    throw new Error(HTTP ${response.status});
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Format the stock details HTML
                    const html = formatStockDetails(data);
                    viewContent.innerHTML = html;
                } else {
                    viewContent.innerHTML = 
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            ${data.error || 'Error loading stock details'}
                        </div>
                    ;
                }
            })
            .catch(error => {
                console.error('Error loading stock details:', error);
                viewContent.innerHTML = 
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Error loading stock details. Please try again.
                    </div>
                ;
            });
    }

    // Function to format stock details
    function formatStockDetails(data) {
        const stock = data.stock_in;
        const product = data.product;
        const pricing = data.pricing;
        const supplier = product?.supplier;
        const category = product?.category;
        
        // Helper functions
        const getValue = (value, fallback = 'N/A') => value !== null && value !== undefined ? value : fallback;
        const formatDate = (dateString) => {
            if (!dateString) return 'N/A';
            return new Date(dateString).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        };
        
        const formatDateTime = (dateString) => {
            if (!dateString) return 'N/A';
            return new Date(dateString).toLocaleString('en-US', {
                dateStyle: 'long',
                timeStyle: 'short'
            });
        };
        
        // Status badge
        let statusBadge = '';
        if (stock.ProdStatus === 'Received') {
            statusBadge = '<span class="badge bg-success">Good Condition</span>';
        } else if (stock.ProdStatus === 'Defective') {
            statusBadge = '<span class="badge bg-danger">Damaged/Defective</span>';
        } else if (stock.ProdStatus === 'Expired') {
            statusBadge = '<span class="badge bg-warning text-dark">Expired</span>';
        } else {
            statusBadge = <span class="badge bg-secondary">${stock.ProdStatus}</span>;
        }
        
        // Check if low stock
        const isLowStock = product && product.StockQty <= product.ReorderLevel;
        
        return 
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="p-4 bg-light rounded-3 mb-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="mb-2">${getValue(product?.ProductName)}</h4>
                                    <p class="mb-1"><strong>Stock In ID:</strong> ${stock.StockInID}</p>
                                    <p class="mb-0"><strong>SKU:</strong> ${getValue(product?.SKUNumber)}</p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="display-6 text-primary">+${stock.Qty}</div>
                                    <p class="text-muted">Units Received</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                ${isLowStock ? 
                <div class="alert alert-warning mb-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Low Stock Warning!</strong> 
                    Current stock (${product.StockQty}) is at or below reorder level (${product.ReorderLevel})
                </div> 
                : ''}
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Basic Information</h6>
                                <p class="mb-2"><strong>Status:</strong> ${statusBadge}</p>
                                <p class="mb-2"><strong>Date Received:</strong> ${formatDateTime(stock.DateRcvd)}</p>
                                ${stock.ExpirationDate ? 
                                <p class="mb-2"><strong>Expiration Date:</strong> ${formatDate(stock.ExpirationDate)}</p> 
                                : ''}
                                ${product?.Size ? 
                                <p class="mb-2"><strong>Size:</strong> ${product.Size}</p> 
                                : ''}
                                ${product?.Type ? 
                                <p class="mb-2"><strong>Type:</strong> ${product.Type}</p> 
                                : ''}
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3"><i class="fas fa-box me-2"></i>Product Information</h6>
                                <p class="mb-2">
                                    <strong>Category:</strong> 
                                    <span class="badge bg-light text-dark">${getValue(category?.CategoryName)}</span>
                                </p>
                                <p class="mb-2"><strong>Supplier:</strong> ${getValue(supplier?.SupplierName)}</p>
                                ${supplier?.ContactNumber ? 
                                <p class="mb-2"><strong>Supplier Contact:</strong> ${supplier.ContactNumber}</p> 
                                : ''}
                                ${supplier?.Address ? 
                                <p class="mb-2"><strong>Supplier Address:</strong> ${supplier.Address}</p> 
                                : ''}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3"><i class="fas fa-tags me-2"></i>Pricing Information</h6>
                                <div class="row text-center">
                                    <div class="col-md-4 border-end py-3">
                                        <small class="text-muted d-block">Cost Price</small>
                                        <strong class="fs-5">₱${parseFloat(pricing?.OriginalPrice || 0).toFixed(2)}</strong>
                                    </div>
                                    <div class="col-md-4 border-end py-3">
                                        <small class="text-muted d-block">Markup Rate</small>
                                        <strong class="fs-5">${parseFloat(pricing?.MarkupRate || 0).toFixed(1)}%</strong>
                                    </div>
                                    <div class="col-md-4 py-3">
                                        <small class="text-muted d-block">Retail Price</small>
                                        <strong class="fs-5 text-success">₱${parseFloat(pricing?.RetailPrice || 0).toFixed(2)}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3"><i class="fas fa-chart-line me-2"></i>Stock Movement</h6>
                                <div class="row text-center">
                                    <div class="col-md-3 py-3">
                                        <small class="text-muted d-block">Before This Entry</small>
                                        <strong class="fs-5">${product ? (product.StockQty - stock.Qty) : 'N/A'}</strong>
                                    </div>
                                    <div class="col-md-3 py-3">
                                        <small class="text-muted d-block">This Entry</small>
                                        <strong class="fs-5 text-primary">+${stock.Qty}</strong>
                                    </div>
                                    <div class="col-md-3 py-3">
                                        <small class="text-muted d-block">Current Stock</small>
                                        <strong class="fs-5 ${isLowStock ? 'text-danger' : 'text-success'}">${getValue(product?.StockQty)}</strong>
                                    </div>
                                    <div class="col-md-3 py-3">
                                        <small class="text-muted d-block">Reorder Level</small>
                                        <strong class="fs-5">${getValue(product?.ReorderLevel)}</strong>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ;
    }

    // ========== DELETE STOCK FUNCTIONALITY ==========
    let currentStockIdToDelete = null;
    
    // Add event listeners to delete buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-stock')) {
            const button = e.target.closest('.delete-stock');
            currentStockIdToDelete = button.dataset.stockId;
            showDeleteConfirmation();
        }
    });

    // Show delete confirmation modal
    function showDeleteConfirmation() {
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteStockModal'));
        deleteModal.show();
        
        // Set up the delete form action
        const deleteForm = document.getElementById('deleteStockForm');
        deleteForm.action = /admin/stockin/${currentStockIdToDelete};
    }

    // Handle delete form submission
    document.getElementById('deleteStockForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const stockId = currentStockIdToDelete;
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Deleting...';
        submitBtn.disabled = true;
        
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ _method: 'DELETE' })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Remove the row from the table
                const row = document.getElementById(stock-row-${stockId});
                if (row) {
                    row.remove();
                }
                
                // Show success message
                showAlert('success', data.message || 'Stock record deleted successfully');
                
                // Close the modal
                const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteStockModal'));
                deleteModal.hide();
                
                // Check if table is now empty
                const remainingRows = tableBody.querySelectorAll('tr');
                if (remainingRows.length === 0 || (remainingRows.length === 1 && remainingRows[0].cells.length > 2)) {
                    // Add empty state row
                    const emptyRow = document.createElement('tr');
                    emptyRow.innerHTML = 
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-box-open fa-2x mb-3"></i>
                            <h5>No stock records found</h5>
                            <p class="mb-0">Add your first stock record using the "Add Stock" button</p>
                        </td>
                    ;
                    tableBody.appendChild(emptyRow);
                }
            } else {
                showAlert('danger', data.error || 'Failed to delete stock record');
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            showAlert('danger', error.error || error.message || 'Failed to delete stock record');
        })
        .finally(() => {
            // Reset button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });

    // Helper function to show alerts
    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = alert alert-${type} alert-dismissible fade show;
        alertDiv.innerHTML = 
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        ;
        
        // Insert after topbar
        const topbar = document.querySelector('.topbar');
        topbar.parentNode.insertBefore(alertDiv, topbar.nextSibling);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alertDiv);
            bsAlert.close();
        }, 5000);
    }

    // Auto-hide alerts after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.alert:not(.alert-warning):not(.alert-info)').forEach(alert => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>
</body>
</html>
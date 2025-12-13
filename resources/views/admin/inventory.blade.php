<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Inventory Report | Dora's Oshoppe</title>

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

    /* Sidebar - identical to Accounts & Transaction */
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
    
    .status-instock { 
      background: #e8f5e8; 
      color: #23b07a; 
    }
    
    .status-low { 
      background: #fde8e8; 
      color: #e05252; 
    }
    
    .status-out { 
      background: #fde8e8; 
      color: #e05252; 
    }

    /* Stock Bar */
    .stock-bar { width: 60px; height: 6px; background: #e9ecef; border-radius: 3px; overflow: hidden; display: inline-block; }
    .stock-fill { height: 100%; border-radius: 3px; }
    .stock-high { background: #23b07a; }
    .stock-medium { background: #f08a24; }
    .stock-low { background: #e05252; }

    /* Tab Navigation */
    .nav-tabs {
      border-bottom: 1px solid #dee2e6;
      margin-bottom: 20px;
    }
    
    .nav-tabs .nav-link {
      color: #5b5f72;
      border: none;
      padding: 12px 24px;
      font-weight: 500;
      border-radius: 8px 8px 0 0;
    }
    
    .nav-tabs .nav-link:hover {
      border-color: transparent;
      color: var(--primary-color);
    }
    
    .nav-tabs .nav-link.active {
      background-color: #fff;
      border-bottom: 3px solid var(--primary-color);
      color: var(--primary-color);
      font-weight: 600;
    }

    /* Tabs content */
    .tab-content {
      padding: 0;
    }

    /* Transaction History Modal */
    .transaction-history-modal .modal-body {
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
      .nav-tabs .nav-link {
        padding: 8px 16px;
        font-size: 0.875rem;
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

    // Get inventory data
    $products = $products ?? collect([]);
    $lowStockCount = 0;
    $outOfStockCount = 0;
    
    foreach ($products as $product) {
        if (($product->current_stock ?? 0) <= 0) {
            $outOfStockCount++;
        } elseif (($product->current_stock ?? 0) <= ($product->ReorderLvl ?? 0)) {
            $lowStockCount++;
        }
    }
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
          <a class="nav-link" href="{{ route('admin.transaction') }}"><i class="fas fa-file-invoice-dollar"></i> Transaction</a>
          <a class="nav-link active" href="{{ route('admin.inventory') }}"><i class="fas fa-clipboard-list"></i> Inventory</a>
        </div>
      </div>
    </nav>
  </div>
</aside>

<main class="content-wrap" id="contentWrap">
  <div class="topbar">
    <div class="page-title-section">
      <h4 class="mb-1">Inventory Report</h4>
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
        <form method="GET" action="{{ route('admin.inventory') }}" class="search-filter-section" id="filterForm">
          <div class="search-filter-row">
            <div class="input-group search-input">
              <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
              <input type="text" class="form-control" name="search" placeholder="Search Product ID, Name, Category..." id="searchInput" value="{{ request('search') }}">
            </div>

            <div class="filter-dropdown">
              <button type="button" class="filter-toggle" id="filterToggle">
                <i class="fas fa-filter"></i> <span>Filter</span>
                <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
              </button>
              
              <div class="filter-menu" id="filterMenu">
                <div class="filter-section">
                  <div class="filter-section-title">Stock Status</div>
                  <div class="filter-options">
                    <div class="filter-option">
                      <input type="checkbox" name="stock_status[]" id="status-instock" value="instock" {{ in_array('instock', request('stock_status', [])) || !request('stock_status') ? 'checked' : '' }}>
                      <label for="status-instock">In Stock</label>
                    </div>
                    <div class="filter-option">
                      <input type="checkbox" name="stock_status[]" id="status-low" value="low" {{ in_array('low', request('stock_status', [])) || !request('stock_status') ? 'checked' : '' }}>
                      <label for="status-low">Low Stock</label>
                    </div>
                    <div class="filter-option">
                      <input type="checkbox" name="stock_status[]" id="status-out" value="out" {{ in_array('out', request('stock_status', [])) || !request('stock_status') ? 'checked' : '' }}>
                      <label for="status-out">Out of Stock</label>
                    </div>
                  </div>
                </div>
                
                <div class="filter-section">
                  <div class="filter-section-title">Category</div>
                  <div class="filter-options">
                    @foreach($categories ?? [] as $category)
                    <div class="filter-option">
                      <input type="checkbox" name="categories[]" id="category-{{ $category->CatID ?? $category->id }}" value="{{ $category->CatID ?? $category->id }}" {{ in_array($category->CatID ?? $category->id, request('categories', [])) || !request('categories') ? 'checked' : '' }}>
                      <label for="category-{{ $category->CatID ?? $category->id }}">{{ $category->CatName }}</label>
                    </div>
                    @endforeach
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

  {{-- Inventory Summary Cards --}}
  <div class="row mb-4">
    <div class="col-md-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-muted mb-2">Total Products</h6>
              <h3 class="mb-0">{{ $products->count() }}</h3>
            </div>
            <div class="bg-light p-3 rounded-circle">
              <i class="fas fa-box text-primary fa-2x"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-muted mb-2">In Stock</h6>
              <h3 class="mb-0">{{ $products->count() - $lowStockCount - $outOfStockCount }}</h3>
            </div>
            <div class="bg-light p-3 rounded-circle">
              <i class="fas fa-check-circle text-success fa-2x"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-muted mb-2">Low Stock</h6>
              <h3 class="mb-0">{{ $lowStockCount }}</h3>
            </div>
            <div class="bg-light p-3 rounded-circle">
              <i class="fas fa-exclamation-triangle text-warning fa-2x"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-muted mb-2">Out of Stock</h6>
              <h3 class="mb-0">{{ $outOfStockCount }}</h3>
            </div>
            <div class="bg-light p-3 rounded-circle">
              <i class="fas fa-times-circle text-danger fa-2x"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Tab Navigation --}}
  <ul class="nav nav-tabs" id="inventoryTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab">
        <i class="fas fa-box me-2"></i>Products Inventory
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="transactions-tab" data-bs-toggle="tab" data-bs-target="#transactions" type="button" role="tab">
        <i class="fas fa-exchange-alt me-2"></i>Stock Transactions
      </button>
    </li>
  </ul>

  {{-- Tab Content --}}
  <div class="tab-content" id="inventoryTabsContent">
    {{-- Products Tab --}}
    <div class="tab-pane fade show active" id="products" role="tabpanel">
      <div class="card table-card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h5 class="card-title mb-0">Current Inventory</h5>
            <div class="d-flex gap-2">
              <a href="{{ route('admin.reports.inventory.export') . '?' . http_build_query(request()->except('page')) }}" class="btn btn-success">
                <i class="fas fa-file-csv me-1"></i> Export CSV
              </a>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-hover align-middle" id="inventoryTable">
              <thead class="table-light">
                <tr>
                  <th>Product ID</th>
                  <th>Product Name</th>
                  <th>Category</th>
                  <th>Current Stock</th>
                  <th>Reorder Level</th>
                  <th>Status</th>
                  <th>Price</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="inventoryTableBody">
                @forelse($paginatedProducts ?? $products as $product)
                <tr data-stock="{{ $product->current_stock }}" 
                    data-category="{{ $product->CatID }}">
                  <td><strong>#{{ $product->ProductID }}</strong></td>
                  <td>
                    <div class="fw-semibold">{{ $product->ProductName }}</div>
                    <small class="text-muted">SKU: {{ $product->SKUNumber }}</small>
                  </td>
                  <td>{{ $product->category?->CategoryName ?? 'Uncategorized' }}</td>
                  <td>
                    <div style="display:flex; align-items:center; gap:8px;">
                      <strong>{{ $product->current_stock }}</strong>
                      <div class="stock-bar">
                        @php
                          $reorderLevel = $product->ReorderLvl ?? 5;
                          $maxStock = max($reorderLevel * 3, $product->current_stock);
                          $percent = $product->current_stock > 0 ? min(100, ($product->current_stock / max(1, $maxStock)) * 100) : 0;
                          $fill = 'stock-high';
                          if ($product->current_stock <= 0) {
                            $fill = 'stock-low';
                          } elseif ($product->current_stock <= $reorderLevel) {
                            $fill = 'stock-low';
                          } elseif ($product->current_stock <= $reorderLevel * 2) {
                            $fill = 'stock-medium';
                          }
                        @endphp
                        <div class="stock-fill {{ $fill }}" style="width:{{ $percent }}%"></div>
                      </div>
                    </div>
                  </td>
                  <td>{{ $product->ReorderLvl ?? 5 }}</td>
                  <td>
                    @if($product->current_stock <= 0)
                      <span class="status-badge status-out">Out of Stock</span>
                    @elseif($product->current_stock <= ($product->ReorderLvl ?? 5))
                      <span class="status-badge status-low">Low Stock</span>
                    @else
                      <span class="status-badge status-instock">In Stock</span>
                    @endif
                  </td>
                  <td>
                    <div>₱{{ number_format($product->SellingPrice ?? $product->Price ?? 0, 2) }}</div>
                    <small class="text-muted">Cost: ₱{{ number_format($product->CostPrice ?? 0, 2) }}</small>
                  </td>
                  <td>
                    <div class="action-buttons">
                      <button class="btn btn-sm btn-outline-primary view-transaction-history" 
                              data-bs-toggle="modal" 
                              data-bs-target="#transactionHistoryModal"
                              data-product-id="{{ $product->ProductID }}">
                        <i class="fas fa-history"></i>
                      </button>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="8" class="text-center py-5">
                    <div class="empty-state">
                      <i class="fas fa-box fa-2x mb-3"></i>
                      <h5>No products found</h5>
                      <p class="mb-0">Add products to see them here</p>
                    </div>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
              @if(isset($paginatedProducts))
                Total: {{ $paginatedProducts->total() }} product(s) | 
                Showing: {{ $paginatedProducts->firstItem() ?? 0 }}-{{ $paginatedProducts->lastItem() ?? 0 }} |
              @else
                Total: {{ $products->count() }} product(s) | 
              @endif
              @if($lowStockCount > 0)
                <span class="text-warning">{{ $lowStockCount }} low stock</span> |
              @endif
              @if($outOfStockCount > 0)
                <span class="text-danger">{{ $outOfStockCount }} out of stock</span>
              @endif
            </div>
            
            {{-- Pagination --}}
            @if(isset($paginatedProducts) && $paginatedProducts->hasPages())
              <nav>
                {{ $paginatedProducts->withQueryString()->links() }}
              </nav>
            @endif
          </div>
        </div>
      </div>
    </div>

    {{-- Transactions Tab --}}
    <div class="tab-pane fade" id="transactions" role="tabpanel">
      <div class="card table-card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title mb-0">Stock Transaction History</h5>
          </div>

          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th>Date</th>
                  <th>Type</th>
                  <th>Product</th>
                  <th>Quantity</th>
                  <th>Reference</th>
                  <th>Notes</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentMovements ?? [] as $movement)
                <tr>
                  <td>{{ $movement->ChangeDateTime->format('M d, Y h:i A') }}</td>
                  <td>
                    @if($movement->ChangeType == 'Decrease')
                      <span class="badge bg-danger">Sale</span>
                    @elseif($movement->ChangeType == 'Increase')
                      <span class="badge bg-success">Stock In</span>
                    @else
                      <span class="badge bg-secondary">{{ $movement->ChangeType }}</span>
                    @endif
                  </td>
                  <td>{{ $movement->product->ProductName ?? 'Product #' . $movement->ProductID }}</td>
                  <td>
                    @if($movement->ChangeType == 'Decrease')
                      <span class="text-danger">-{{ $movement->QtyChange }}</span>
                    @else
                      <span class="text-success">+{{ $movement->QtyChange }}</span>
                    @endif
                  </td>
                  <td>
                    @if($movement->reference_type == 'order')
                      Order #{{ $movement->reference_id }}
                    @elseif($movement->reference_type == 'stock_in')
                      Stock In #{{ $movement->reference_id }}
                    @elseif($movement->reference_type == 'pullout')
                      Pullout #{{ $movement->reference_id }}
                    @else
                      {{ $movement->reference_id ?? '-' }}
                    @endif
                  </td>
                  <td>{{ $movement->notes ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center py-5 text-muted">No stock transactions found</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Transaction History Modal -->
<div class="modal fade transaction-history-modal" id="transactionHistoryModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-3">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold"><i class="fas fa-history me-2"></i>Product Transaction History</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="transactionHistoryContent">
        <!-- Content will be loaded dynamically -->
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
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
  
  // Clear filters button
  document.getElementById('clearFilters')?.addEventListener('click', function() {
    // Reset form and submit
    filterForm.reset();
    
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
  
  // View transaction history for product
  document.querySelectorAll('.view-transaction-history').forEach(button => {
    button.addEventListener('click', function() {
      const productId = this.dataset.productId;
      
      // Show loading
      document.getElementById('transactionHistoryContent').innerHTML = `
        <div class="text-center py-5">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <p class="mt-2">Loading transaction history...</p>
        </div>
      `;
      
      // Load transaction history via AJAX
      fetch(`/admin/inventory/${productId}/transactions`)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.text();
        })
        .then(html => {
          document.getElementById('transactionHistoryContent').innerHTML = html;
        })
        .catch(error => {
          console.error('Error:', error);
          document.getElementById('transactionHistoryContent').innerHTML = 
            '<div class="alert alert-danger">Error loading transaction history. Please try again.</div>';
        });
    });
  });
  
  // Search functionality
  const searchInput = document.getElementById('searchInput');
  const inventoryTableBody = document.getElementById('inventoryTableBody');
  
  searchInput?.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = inventoryTableBody.querySelectorAll('tr');
    
    rows.forEach(row => {
      if (row.cells.length < 2) {
        row.style.display = '';
        return;
      }
      
      const text = row.textContent.toLowerCase();
      const searchMatch = searchTerm === '' || text.includes(searchTerm);
      
      // Show/hide row
      row.style.display = searchMatch ? '' : 'none';
    });
  });
  
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
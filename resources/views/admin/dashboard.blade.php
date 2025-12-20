<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard | Dora's Oshoppe</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --sidebar-width: 240px;
      --primary-color: #3b3183;
      --primary-light: #efeaff;
      --secondary-color: #6c757d;
      --success-color: #23b07a;
      --danger-color: #e05252;
      --warning-color: #f08a24;
      --info-color: #17a2b8;
      --light-bg: #f5f7fb;
      --card-shadow: 0 2px 4px rgba(0,0,0,0.04);
    }
    
    body { 
      font-family: 'Poppins', sans-serif; 
      background: var(--light-bg);
      margin: 0;
      padding: 0;
      height: 100vh;
    }
    
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

    .sidebar.collapsed {
      min-width: 70px;
      max-width: 70px;
    }

    .sidebar.collapsed .brand-text,
    .sidebar.collapsed .nav-link span:not(.fa),
    .sidebar.collapsed .nav-link .fa-chevron-down {
      display: none;
    }

    .sidebar.collapsed .brand {
      justify-content: center;
    }

    .sidebar.collapsed .nav-link {
      justify-content: center;
      text-align: center;
    }

    .sidebar.collapsed .nav-link i {
      margin-right: 0;
    }

    .brand { 
      display: flex; 
      align-items: center; 
      gap: 10px; 
      margin-bottom: 18px; 
      flex-shrink: 0; 
    }

    .brand img { 
      width: 100px; 
      height: 100px;
      object-fit: contain;
    }

    .brand-text {
      flex: 1;
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
      background: var(--primary-light); 
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
      overflow-x: hidden;
      margin-top: 18px;
    }
    
    .sidebar-nav::-webkit-scrollbar {
      width: 4px;
    }
    
    .sidebar-nav::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }
    
    .sidebar-nav::-webkit-scrollbar-thumb {
      background: #c1c1c1;
      border-radius: 10px;
    }
    
    .sidebar-nav::-webkit-scrollbar-thumb:hover {
      background: #a8a8a8;
    }
    
    .nav .nav-link.dropdown-toggle::after {
      float: right;
      margin-top: 6px;
      margin-left: auto;
    }
    
    .nav .nav.flex-column.ms-3 {
      border-left: 2px solid #eef2f7;
      margin-left: 12px !important;
      padding-left: 8px;
    }
    
    .nav .nav.flex-column.ms-3 .nav-link {
      padding: 10px 12px;
      font-size: 0.9rem;
      border-radius: 6px;
    }
    
    .content-wrap { 
      margin-left: 240px; 
      transition: all 0.3s ease;
      height: 100vh;
      overflow-y: auto;
      background: var(--light-bg);
    }

    .content-wrap.expanded {
      margin-left: 0;
    }

    .topbar { 
      background: var(--light-bg);
      display: flex; 
      align-items: flex-start; 
      justify-content: space-between; 
      margin-bottom: 22px; 
      flex-wrap: wrap;
      padding: 28px 28px 0 28px;
      position: sticky;
      top: 0;
      z-index: 100;
      gap: 20px;
    }

    .page-header-container {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      width: 100%;
      flex-wrap: wrap;
      gap: 20px;
    }

    .page-title-section {
      flex: 1;
      min-width: 300px;
    }

    .user-section {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 16px;
      min-width: 300px;
      width: auto;
      max-width: 800px;
      margin-left: auto;
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

    .main-content {
      padding: 0 28px 28px 28px;
    }

    .date-filter-section {
      display: flex;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap;
      justify-content: space-between;
      width: 100%;
      margin-top: 20px;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
  opacity: 0;
  cursor: pointer;
}


    /* Date picker styling */
    .date-picker-container {
      flex-shrink: 0;
      position: relative;
    }

    .date-picker-container .input-group {
      width: auto;
      min-width: 220px;
    }

    .date-picker-container .form-control {
      width: 170px;
      padding-right: 40px;
    }

    .date-picker-container .input-group-text {
      background: var(--primary-color);
      border-color: var(--primary-color);
      color: white;
      cursor: pointer;
    }

    /* Stats Cards with Updated Colors */
    .stat-card { 
      border-radius: 12px; 
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      border: none;
      box-shadow: var(--card-shadow);
      cursor: pointer;
      position: relative;
      overflow: hidden;
      text-decoration: none !important;
      color: inherit !important;
      display: block;
    }
    
    .stat-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 6px 12px rgba(0,0,0,0.1);
      color: inherit !important;
    }
    
    .stat-card::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: transparent;
      transition: background 0.2s ease;
    }
    
    .stat-card:hover::after {
      background: var(--primary-color);
    }
    
    .stat-icon { 
      width: 44px; 
      height: 44px; 
      border-radius: 10px; 
      display: flex; 
      align-items: center; 
      justify-content: center; 
      flex-shrink: 0;
    }
    
    .icon-primary,
.icon-success,
.icon-warning,
.icon-danger,
.icon-info {
  background: rgba(59, 49, 131, 0.12); /* soft purple */
  color: var(--primary-color);
}
    
    .card-small { 
      border-radius: 12px; 
      height: 100%;
      border: none;
      box-shadow: var(--card-shadow);
    }
    
    .chart-container {
      position: relative;
      height: 250px; /* Fixed height to prevent stretching */
      width: 100%;
    }
    
    .mobile-menu-toggle {
      display: none;
      position: fixed;
      top: 20px;
      left: 20px;
      z-index: 1001;
      background: var(--primary-color);
      color: white;
      border: none;
      border-radius: 5px;
      padding: 10px;
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
    
    .content-wrap::-webkit-scrollbar {
      width: 8px;
    }
    
    .content-wrap::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }
    
    .content-wrap::-webkit-scrollbar-thumb {
      background: #c1c1c1;
      border-radius: 10px;
    }
    
    .content-wrap::-webkit-scrollbar-thumb:hover {
      background: #a8a8a8;
    }
    
    /* Badge for stats */
    .stat-badge {
      position: absolute;
      top: 10px;
      right: 10px;
      background: rgba(255, 255, 255, 0.9);
      color: var(--primary-color);
      padding: 2px 8px;
      border-radius: 10px;
      font-size: 0.7rem;
      font-weight: 600;
      display: none;
    }
    
    .stat-card:hover .stat-badge {
      display: block;
    }
    
    @media (max-width: 1200px) {
      .chart-container {
        height: 220px;
      }
    }
    
    @media (max-width: 992px) {
      .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        z-index: 1000;
        width: 280px;
        max-width: 280px;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
      }
      
      .sidebar.mobile-open {
        transform: translateX(0);
      }
      
      .content-wrap {
        margin-left: 0;
        padding: 70px 0 0 0;
      }
      
      .mobile-menu-toggle {
        display: flex;
      }
      
      .topbar {
        padding: 20px 16px 0 16px;
        flex-direction: column;
        align-items: stretch;
      }
      
      .page-header-container {
        flex-direction: column;
        align-items: stretch;
      }
      
      .user-section {
        align-items: flex-start;
        min-width: 100%;
        margin-left: 0;
      }
      
      .user-dropdown-menu {
        right: auto;
        left: 0;
      }
      
      .date-filter-container {
        align-items: stretch;
      }
      
      .date-picker-container .input-group {
        width: 100%;
      }
      
      .date-picker-container .form-control {
        width: 100%;
      }

      .main-content {
        padding: 0 16px 16px 16px;
      }
    }
    
    @media (max-width: 768px) {
      .stat-card {
        margin-bottom: 15px;
      }
      
      .chart-container {
        height: 200px;
      }
      
      .content-wrap {
        padding: 70px 0 0 0;
      }

      .topbar {
        margin-bottom: 16px;
        padding: 20px 12px 0 12px;
      }

      .date-filter-section {
        flex-direction: column;
      }

      .date-picker-container {
        width: 100%;
      }

      .main-content {
        padding: 0 12px 12px 12px;
      }
    }
    
    @media (max-width: 576px) {
      h4 {
        font-size: 1.3rem;
      }
      
      .content-wrap {
        padding: 70px 0 0 0;
      }

      .sidebar {
        width: 100%;
        max-width: 100%;
      }

      .user-info {
        flex-direction: column;
        text-align: center;
      }

      .topbar {
        padding: 20px 8px 0 8px;
      }

      .main-content {
        padding: 0 8px 8px 8px;
      }
      
      .chart-container {
        height: 180px;
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
    
    // Set default date
    $today = date('Y-m-d');
@endphp

<button class="mobile-menu-toggle" id="mobileMenuToggle">
  <i class="fas fa-bars"></i>
</button>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

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
          <a class="nav-link active" href="{{ route('admin.dashboard') }}">
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
          <div class="collapse" id="recordsSubmenu">
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
          <div class="collapse" id="reportsSubmenu">
              <div class="nav flex-column ms-3">
                  <a class="nav-link" href="{{ route('admin.transaction') }}">
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

<main class="content-wrap" id="contentWrap">
  <div class="topbar">
    <!-- Page header with user dropdown on same line -->
    <div class="page-header-container">
      <div class="page-title-section">
        <h4 class="mb-1">Dashboard</h4>
        <p class="text-muted mb-0">Overview of your inventory and sales</p>
      </div>

      <!-- User Section -->
      <div class="user-section">
        <!-- User Info Section with Dropdown -->
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
        
        <!-- Date Filter Container -->
        <div class="date-filter-container">
          <div class="date-filter-section">
            <!-- Date Picker Only -->
            <div class="date-picker-container">
              <div class="input-group">
                <input type="date" class="form-control" id="dateFilter" value="{{ $today }}">
                <span class="input-group-text" id="calendarTrigger">
  <i class="fas fa-calendar-alt"></i>
</span>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="main-content">
    <!-- Stats Cards with Quick Links - Updated Colors -->
    <div class="row g-3 mb-4">
      <div class="col-xl-3 col-md-6">
        <a href="{{ route('admin.products') }}" class="stat-card">
          <div class="card p-3">
            <span class="stat-badge">View Products</span>
            <div class="d-flex">
              <div class="stat-icon me-3 icon-primary">
                <i class="fas fa-box"></i>
              </div>
              <div class="flex-fill d-flex flex-column">
                <small class="text-muted">Total Products</small>
                <div class="mt-auto text-end" style="font-weight:700; font-size:20px;" id="totalProducts">
                  {{ $stats['totalProducts'] ?? 0 }}
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xl-3 col-md-6">
        <a href="{{ route('admin.pullout') }}" class="stat-card">
          <div class="card p-3">
            <span class="stat-badge">View Pullouts</span>
            <div class="d-flex">
              <div class="stat-icon me-3 icon-info">
                <i class="fas fa-arrow-up"></i>
              </div>
              <div class="flex-fill d-flex flex-column">
                <small class="text-muted">Stock Out Today</small>
                <div class="mt-auto text-end" style="font-weight:700; font-size:20px;" id="stockOutToday">
                  {{ $stats['stockOutToday'] ?? 0 }}
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xl-3 col-md-6">
        <a href="{{ route('admin.products') }}?filter=near_expiry" class="stat-card">
          <div class="card p-3">
            <span class="stat-badge">Check Expiry</span>
            <div class="d-flex">
              <div class="stat-icon me-3 icon-warning">
                <i class="fas fa-clock"></i>
              </div>
              <div class="flex-fill d-flex flex-column">
                <small class="text-muted">Products Near Expiry</small>
                <div class="mt-auto text-end" style="font-weight:700; font-size:20px;" id="nearExpiry">
                  {{ $stats['nearExpiry'] ?? 0 }}
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xl-3 col-md-6">
        <a href="{{ route('admin.products') }}?filter=low_stock" class="stat-card">
          <div class="card p-3">
            <span class="stat-badge">Restock Items</span>
            <div class="d-flex">
              <div class="stat-icon me-3 icon-danger">
                <i class="fas fa-exclamation-triangle"></i>
              </div>
              <div class="flex-fill d-flex flex-column">
                <small class="text-muted">Low Stock Items</small>
                <div class="mt-auto text-end" style="font-weight:700; font-size:20px;" id="lowStock">
                  {{ $stats['lowStock'] ?? 0 }}
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>

    <!-- SIMPLIFIED GRAPHS SECTION -->
    <div class="row g-3">
      <!-- Stock Movement Chart -->
      <div class="col-lg-6">
        <div class="card p-3 card-small mb-3">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <strong>Stock Movement</strong>
            <small class="text-muted" id="trendPeriod">Last 7 Days</small>
          </div>
          <div class="chart-container">
            <canvas id="trendChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Sales by Category Chart -->
      <div class="col-lg-6">
        <div class="card p-3 card-small mb-3">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <strong>Sales by Category</strong>
            <small class="text-muted" id="salesPeriod">This Month</small>
          </div>
          <div class="chart-container">
            <canvas id="salesChart"></canvas>
          </div>
        </div>
      </div>

      <!-- Top Moving Products -->
      <div class="col-lg-8">
        <div class="card p-3 card-small">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <strong>Top Moving Products</strong>
            <small class="text-muted" id="topProductsPeriod">This Week</small>
          </div>
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Category</th>
                  <th class="text-end">Units Sold</th>
                  <th class="text-end">Stock</th>
                </tr>
              </thead>
              <tbody id="topProductsList">
                @if(isset($topProducts) && count($topProducts) > 0)
                  @foreach($topProducts as $product)
                  <tr>
                    <td>
                      <div style="font-weight:600">{{ $product->ProductName }}</div>
                      <small class="text-muted">SKU: {{ $product->SKUNumber }}</small>
                    </td>
                    <td>{{ $product->category->CategoryName ?? 'N/A' }}</td>
                    <td class="text-end">
                      <span class="badge bg-primary">{{ $product->total_sold ?? 0 }}</span>
                    </td>
                    <td class="text-end">
                      @php
                        $stockClass = 'bg-success';
                        if($product->Stock <= 10) {
                          $stockClass = 'bg-danger';
                        } elseif($product->Stock <= 20) {
                          $stockClass = 'bg-warning';
                        }
                      @endphp
                      <span class="badge {{ $stockClass }}">{{ $product->Stock ?? 0 }}</span>
                    </td>
                  </tr>
                  @endforeach
                @else
                  <tr>
                    <td colspan="4" class="text-center text-muted py-3">
                      <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                      No sales data available
                    </td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Inventory Status -->
      <div class="col-lg-4">
        <div class="card p-3 card-small">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <strong>Inventory Status</strong>
            <small class="text-muted">Current</small>
          </div>
          <div class="chart-container">
            <canvas id="inventoryChart"></canvas>
          </div>
          <div class="row mt-3 text-center">
            <div class="col-4">
              <div class="text-success fw-bold" id="healthyStock">{{ $stats['healthyStock'] ?? 0 }}</div>
              <small class="text-muted">Healthy</small>
            </div>
            <div class="col-4">
              <div class="text-warning fw-bold" id="warningStock">{{ $stats['warningStock'] ?? 0 }}</div>
              <small class="text-muted">Low</small>
            </div>
            <div class="col-4">
              <div class="text-danger fw-bold" id="criticalStock">{{ $stats['criticalStock'] ?? 0 }}</div>
              <small class="text-muted">Critical</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Mobile sidebar toggle functionality
  const sidebar = document.getElementById('sidebar');
  const mobileMenuToggle = document.getElementById('mobileMenuToggle');
  const sidebarOverlay = document.getElementById('sidebarOverlay');
  const contentWrap = document.getElementById('contentWrap');

  mobileMenuToggle.addEventListener('click', function() {
    sidebar.classList.toggle('mobile-open');
    sidebarOverlay.classList.toggle('active');
    document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
  });

  sidebarOverlay.addEventListener('click', function() {
    sidebar.classList.remove('mobile-open');
    sidebarOverlay.classList.remove('active');
    document.body.style.overflow = '';
  });

  document.querySelectorAll('.sidebar .nav-link').forEach(link => {
    link.addEventListener('click', function() {
      if (window.innerWidth < 992) {
        sidebar.classList.remove('mobile-open');
        sidebarOverlay.classList.remove('active');
        document.body.style.overflow = '';
      }
    });
  });

  // User dropdown functionality
  const userDropdownToggle = document.getElementById('userDropdownToggle');
  const userDropdownMenu = document.getElementById('userDropdownMenu');
  
  // Toggle user dropdown
  userDropdownToggle.addEventListener('click', function(e) {
    e.stopPropagation();
    const isVisible = userDropdownMenu.style.display === 'block';
    userDropdownMenu.style.display = isVisible ? 'none' : 'block';
  });
  
  // Close dropdown when clicking outside
  document.addEventListener('click', function() {
    userDropdownMenu.style.display = 'none';
  });
  
  // Close dropdown when clicking on a menu item
  document.querySelectorAll('.user-dropdown-item').forEach(item => {
    item.addEventListener('click', function() {
      userDropdownMenu.style.display = 'none';
    });
  });

  // ========== DATE FILTER FUNCTIONALITY ==========
  const dateFilter = document.getElementById('dateFilter');

  const calendarTrigger = document.getElementById('calendarTrigger');

// Open date picker when calendar icon is clicked
calendarTrigger.addEventListener('click', () => {
  if (dateFilter.showPicker) {
    dateFilter.showPicker(); // Chrome, Edge, Brave
  } else {
    dateFilter.focus(); // Fallback
  }
});

  
  // Auto-apply date filter on change
  dateFilter.addEventListener('change', function() {
    applyDateFilter(this.value);
  });

  async function applyDateFilter(date) {
    // Show loading state
    showLoading();
    
    try {
      // Fetch data for selected date
      const response = await fetch('/api/dashboard-data?date=' + date, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      });
      
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      
      const data = await response.json();
      
      // Update dashboard with real data
      updateDashboardWithData(data);
      hideLoading();
      
      // Show success message
      showToast(`Dashboard updated for ${formatDate(date)}`);
      
    } catch (error) {
      console.error('Error fetching dashboard data:', error);
      hideLoading();
      showError('Failed to update dashboard data');
    }
  }

  async function loadInitialDashboardData() {
    try {
      // Fetch initial dashboard data
      const response = await fetch('/api/dashboard-data', {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      });
      
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      
      const data = await response.json();
      
      // Initialize charts with real data
      initializeChartsWithData(data);
      
    } catch (error) {
      console.error('Error loading initial dashboard data:', error);
      // Use fallback data if API fails
      useFallbackData();
    }
  }

  function updateDashboardWithData(data) {
    // Update stats
    document.getElementById('totalProducts').textContent = data.stats.totalProducts || 0;
    document.getElementById('stockOutToday').textContent = data.stats.stockOutToday || 0;
    document.getElementById('nearExpiry').textContent = data.stats.nearExpiry || 0;
    document.getElementById('lowStock').textContent = data.stats.lowStock || 0;
    
    // Update inventory status
    document.getElementById('healthyStock').textContent = data.stats.healthyStock || 0;
    document.getElementById('warningStock').textContent = data.stats.warningStock || 0;
    document.getElementById('criticalStock').textContent = data.stats.criticalStock || 0;
    
    // Update charts if they exist
    if (window.trendChart && data.charts.stockMovement) {
      updateChartData(trendChart, data.charts.stockMovement.labels, data.charts.stockMovement.data);
    }
    
    if (window.salesChart && data.charts.salesByCategory) {
      updateChartData(salesChart, data.charts.salesByCategory.labels, data.charts.salesByCategory.data);
    }
    
    if (window.inventoryChart && data.charts.inventoryStatus) {
      updateChartData(inventoryChart, data.charts.inventoryStatus.labels, data.charts.inventoryStatus.data);
    }
    
    // Update period labels
    const formattedDate = formatDate(data.date || dateFilter.value);
    document.getElementById('trendPeriod').textContent = `Week of ${formattedDate}`;
    document.getElementById('salesPeriod').textContent = `Month of ${new Date(data.date || dateFilter.value).toLocaleString('default', { month: 'long' })}`;
    
    // Update top products table
    updateTopProductsTable(data.topProducts || []);
  }

  function updateTopProductsTable(products) {
    const tbody = document.getElementById('topProductsList');
    if (!tbody) return;
    
    if (products.length === 0) {
      tbody.innerHTML = `
        <tr>
          <td colspan="4" class="text-center text-muted py-3">
            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
            No sales data available
          </td>
        </tr>
      `;
      return;
    }
    
    let html = '';
    products.forEach(product => {
      let stockClass = 'bg-success';
      if (product.stock <= 10) {
        stockClass = 'bg-danger';
      } else if (product.stock <= 20) {
        stockClass = 'bg-warning';
      }
      
      html += `
        <tr>
          <td>
            <div style="font-weight:600">${product.name}</div>
            <small class="text-muted">SKU: ${product.sku}</small>
          </td>
          <td>${product.category || 'N/A'}</td>
          <td class="text-end">
            <span class="badge bg-primary">${product.sold || 0}</span>
          </td>
          <td class="text-end">
            <span class="badge ${stockClass}">${product.stock || 0}</span>
          </td>
        </tr>
      `;
    });
    
    tbody.innerHTML = html;
  }

  function initializeChartsWithData(data) {
    // Initialize Stock Movement Chart with real data
    if (document.getElementById('trendChart') && data.charts.stockMovement) {
      trendChart = new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
          labels: data.charts.stockMovement.labels || ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
          datasets: [{
            label: 'Stock Movements',
            data: data.charts.stockMovement.data || [0, 0, 0, 0, 0, 0, 0],
            borderColor: '#3b3183',
            backgroundColor: 'rgba(59, 49, 131, 0.05)',
            tension: 0.4,
            fill: true,
            pointRadius: 4,
            pointBackgroundColor: '#3b3183',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { 
            legend: { display: false },
            tooltip: {
              backgroundColor: '#3b3183',
              titleColor: '#fff',
              bodyColor: '#fff'
            }
          },
          scales: {
            y: { 
              beginAtZero: true,
              ticks: {
                callback: function(value) {
                  return value;
                }
              },
              grid: { color: 'rgba(0,0,0,0.05)' }
            },
            x: { 
              grid: { display: false } 
            }
          }
        }
      });
    }

    // Initialize Sales by Category Chart with real data
    if (document.getElementById('salesChart') && data.charts.salesByCategory) {
      salesChart = new Chart(document.getElementById('salesChart'), {
        type: 'bar',
        data: {
          labels: data.charts.salesByCategory.labels || [],
          datasets: [{
            label: 'Sales',
            data: data.charts.salesByCategory.data || [],
            backgroundColor: [
              '#3b3183',
              '#5a4fa3',
              '#796dc3',
              '#988ce3',
              '#b7abff'
            ],
            borderWidth: 0,
            borderRadius: 4
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { 
            legend: { display: false },
            tooltip: {
              backgroundColor: '#3b3183',
              titleColor: '#fff',
              bodyColor: '#fff',
              callbacks: {
                label: function(context) {
                  return `${context.label}: ${context.parsed.y} sales`;
                }
              }
            }
          },
          scales: {
            y: { 
              beginAtZero: true,
              grid: { color: 'rgba(0,0,0,0.05)' },
              ticks: {
                callback: function(value) {
                  return value;
                }
              }
            },
            x: { 
              grid: { display: false } 
            }
          }
        }
      });
    }

    // Initialize Inventory Status Chart with real data
    if (document.getElementById('inventoryChart') && data.charts.inventoryStatus) {
      inventoryChart = new Chart(document.getElementById('inventoryChart'), {
        type: 'doughnut',
        data: {
          labels: data.charts.inventoryStatus.labels || ['Healthy', 'Low Stock', 'Critical'],
          datasets: [{
            data: data.charts.inventoryStatus.data || [0, 0, 0],
            backgroundColor: [
              '#23b07a',
              '#f08a24',
              '#e05252'
            ],
            borderWidth: 2,
            borderColor: '#fff'
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          cutout: '70%',
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                padding: 15,
                usePointStyle: true,
                font: {
                  size: 11
                }
              }
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  let label = context.label || '';
                  if (label) {
                    label += ': ';
                  }
                  label += context.parsed + ' items';
                  return label;
                }
              }
            }
          }
        }
      });
    }
  }

  function useFallbackData() {
    // Fallback to server-side data
    if (window.trendChart) {
      updateChartData(trendChart, 
        ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'], 
        [120, 150, 110, 180, 170, 210, 190]
      );
    }
    
    if (window.salesChart) {
      updateChartData(salesChart,
        ['Beauty', 'Clothing', 'Accessories', 'Gifts', 'Other'],
        [35, 25, 20, 15, 5]
      );
    }
    
    if (window.inventoryChart) {
      const healthy = parseInt('{{ $stats["healthyStock"] ?? 60 }}');
      const warning = parseInt('{{ $stats["warningStock"] ?? 25 }}');
      const critical = parseInt('{{ $stats["criticalStock"] ?? 15 }}');
      
      updateChartData(inventoryChart,
        ['Healthy', 'Low Stock', 'Critical'],
        [healthy, warning, critical]
      );
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

  function updateChartData(chart, labels, data) {
    if (chart) {
      chart.data.labels = labels;
      chart.data.datasets[0].data = data;
      chart.update();
    }
  }

  // Utility functions
  function showLoading() {
    // Add subtle loading effect to stats cards
    document.querySelectorAll('.stat-card').forEach(card => {
      card.style.opacity = '0.8';
    });
    
    // Show loading indicator on charts
    document.querySelectorAll('.chart-container').forEach(container => {
      const loadingDiv = document.createElement('div');
      loadingDiv.className = 'chart-loading';
      loadingDiv.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
      loadingDiv.style.cssText = `
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 20px;
        color: var(--primary-color);
        z-index: 10;
      `;
      container.appendChild(loadingDiv);
    });
  }

  function hideLoading() {
    // Remove loading effect
    document.querySelectorAll('.stat-card').forEach(card => {
      card.style.opacity = '1';
    });
    
    // Remove loading indicators
    document.querySelectorAll('.chart-loading').forEach(loading => {
      loading.remove();
    });
  }

  function showToast(message) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'position-fixed bottom-0 end-0 p-3';
    toast.style.zIndex = '1050';
    
    toast.innerHTML = `
      <div class="toast show" role="alert">
        <div class="toast-header bg-primary text-white">
          <strong class="me-auto">Dashboard Updated</strong>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
          <i class="fas fa-check-circle text-success me-2"></i>${message}
        </div>
      </div>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
      toast.remove();
    }, 3000);
  }

  function showError(message) {
    // Create error toast
    const toast = document.createElement('div');
    toast.className = 'position-fixed bottom-0 end-0 p-3';
    toast.style.zIndex = '1050';
    
    toast.innerHTML = `
      <div class="toast show" role="alert">
        <div class="toast-header bg-danger text-white">
          <strong class="me-auto">Error</strong>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
          <i class="fas fa-exclamation-circle me-2"></i>${message}
        </div>
      </div>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
      toast.remove();
    }, 5000);
  }

  // Close dropdowns on window resize
  window.addEventListener('resize', function() {
    if (window.innerWidth >= 992) {
      sidebar.classList.remove('mobile-open');
      sidebarOverlay.classList.remove('active');
      document.body.style.overflow = '';
    }
    
    // Close dropdowns on mobile view
    if (window.innerWidth < 992) {
      userDropdownMenu.style.display = 'none';
    }
  });

  // Load initial dashboard data when page loads
  document.addEventListener('DOMContentLoaded', function() {
    // Load initial data from server
    loadInitialDashboardData();
    
    // Auto-refresh dashboard every 5 minutes
    setInterval(loadInitialDashboardData, 5 * 60 * 1000);
  });
</script>
</body>
</html>
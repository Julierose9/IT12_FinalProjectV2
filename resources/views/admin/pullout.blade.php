<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Pullouts | Dora's Oshoppe</title>
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
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
    }

    .content-wrap { 
      margin-left: 240px; 
      padding: 28px;
      transition: all 0.3s ease;
    }

    .content-wrap.expanded {
      margin-left: 0;
    }

    .topbar { 
      background: transparent; 
      display: flex; 
      gap: 16px; 
      align-items: flex-start; 
      justify-content: space-between; 
      margin-bottom: 22px; 
      flex-wrap: wrap;
    }

    .page-title-section {
      flex: 1;
      min-width: 250px;
    }

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
    
    .status-damaged {
      color: var(--danger-color);
    }
    
    .status-expired {
      color: var(--warning-color);
    }

    .status-return {
      color: var(--success-color);
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

    .modal-header {
      border-bottom: 1px solid #eef2f7;
      padding: 20px 24px;
    }
    
    .modal-footer {
      border-top: 1px solid #eef2f7;
      padding: 16px 24px;
    }
    
    .modal-title {
      font-weight: 600;
      color: var(--primary-color);
    }

    .form-label.required::after {
      content: " *";
      color: var(--danger-color);
    }

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

      .sidebar-toggle {
        display: flex;
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
      
      .page-title-section {
        min-width: 100%;
        text-align: center;
      }
      
      .user-section {
        align-items: stretch;
        min-width: 100%;
      }
      
      .search-filter-section {
        justify-content: center;
        flex-wrap: wrap;
      }
      
      .search-input {
        min-width: 100%;
        max-width: 100%;
      }
      
      .filter-menu {
        right: auto;
        left: 0;
        min-width: 280px;
      }
      
      .filter-toggle {
        min-width: 120px;
      }
      
      .user-dropdown-menu {
        right: auto;
        left: 0;
      }
      
      .filter-container {
        align-items: stretch;
      }

      .user-dropdown {
        width: 100%;
      }

      .user-dropdown-toggle {
        width: 100%;
        justify-content: center;
      }

      .table-responsive {
        border-radius: 8px;
      }

      .table th,
      .table td {
        padding: 12px 8px;
        font-size: 0.9rem;
      }

      .action-buttons {
        flex-direction: column;
        gap: 4px;
      }

      .action-buttons .btn {
        padding: 4px 6px;
        font-size: 0.75rem;
      }
    }

    @media (max-width: 767.98px) {
      .content-wrap {
        padding: 70px 12px 12px;
      }

      .topbar {
        margin-bottom: 16px;
      }

      .table-card .card-body {
        padding: 16px;
      }

      .table th,
      .table td {
        padding: 10px 6px;
        font-size: 0.85rem;
      }

      .modal-dialog {
        margin: 20px auto;
      }

      .filter-menu {
        min-width: 250px;
      }

      .search-filter-section {
        flex-direction: column;
      }

      .search-input,
      .filter-toggle {
        width: 100%;
      }
    }

    @media (max-width: 575.98px) {
      .content-wrap {
        padding: 70px 8px 8px;
      }

      .sidebar {
        width: 100%;
        max-width: 100%;
      }

      .table-responsive {
        font-size: 0.8rem;
      }

      .table th,
      .table td {
        padding: 8px 4px;
      }

      .modal-dialog {
        margin: 10px auto;
      }

      .modal-body .row {
        margin-left: -8px;
        margin-right: -8px;
      }

      .modal-body .col-md-6 {
        padding-left: 8px;
        padding-right: 8px;
      }
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

    .alert {
      border: none;
      border-radius: 8px;
      padding: 12px 16px;
      margin-bottom: 20px;
    }

    .alert-success {
      background: #d4edda;
      color: #155724;
    }

    .alert-danger {
      background: #f8d7da;
      color: #721c24;
    }

    .alert-warning {
      background: #fff3cd;
      color: #856404;
    }
    
    .alert-info {
      background: #d1ecf1;
      color: #0c5460;
    }

    .empty-state {
      text-align: center;
      padding: 40px 20px;
    }
    
    .empty-state i {
      font-size: 3rem;
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

    .stock-info-card {
      background-color: #f8f9fa;
      border-left: 4px solid var(--primary-color);
      padding: 12px 16px;
      border-radius: 6px;
      margin-top: 8px;
    }
    
    .stock-info-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 4px;
    }
    
    .stock-info-item:last-child {
      margin-bottom: 0;
    }
    
    .stock-info-label {
      color: #6c757d;
      font-size: 0.875rem;
    }
    
    .stock-info-value {
      font-weight: 600;
      color: var(--primary-color);
    }
    
    .low-stock-warning {
      color: var(--danger-color);
      font-size: 0.875rem;
      margin-top: 4px;
    }
  </style>
</head>
<body>
@php
    $user = Auth::user() ?? null;
    $employeeName = 'Admin';
    $employeeId = null;
    $currentEmployee = null;
    
    if ($user) {
        // Try to get employee from user relationship
        if (method_exists($user, 'employee') && $user->employee) {
            $employee = $user->employee;
            $employeeName = $employee->EmployeeName ?? 
                           ($employee->EmployeeFName . ' ' . $employee->EmployeeLName) ?? 
                           $user->name;
            $employeeId = $employee->EmployeeID ?? null;
            $currentEmployee = $employee;
        }
        // If user has direct employee fields
        elseif (isset($user->EmployeeName)) {
            $employeeName = $user->EmployeeName;
            $employeeId = $user->EmployeeID ?? null;
            $currentEmployee = $user;
        }
        // Fallback
        else {
            $employeeName = $user->name ?? 'Admin';
        }
    }
    
    // Get all employees for dropdown
    $employees = isset($employees) ? $employees : collect([]);
    $pullOuts = isset($pullOuts) ? $pullOuts : collect([]);
    $products = isset($products) ? $products : collect([]);
@endphp

<button class="sidebar-toggle" id="sidebarToggle">
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

      <a class="nav-link dropdown-toggle active" href="#" data-bs-toggle="collapse" data-bs-target="#transactionsSubmenu">
        <i class="fas fa-exchange-alt"></i>
        <span>Inventory</span>
      </a>
      <div class="collapse show" id="transactionsSubmenu">
        <div class="nav flex-column ms-3">
          <a class="nav-link" href="{{ route('admin.stockin') }}">
            <i class="fas fa-arrow-circle-down"></i>
            <span>Stock In</span>
          </a>
          <a class="nav-link active" href="{{ route('admin.pullout') }}">
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
    <div class="page-title-section">
      <h4 class="mb-1">Pullouts Management</h4>
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
            <input class="form-control" placeholder="Search pullout records..." id="searchInput" />
          </div>
          
          <div class="filter-dropdown">
            <button class="filter-toggle" id="filterToggle">
              <i class="fas fa-filter"></i>
              <span>Filter</span>
              <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
            </button>
            
            <div class="filter-menu" id="filterMenu" style="display: none;">
              <div class="filter-section">
                <div class="filter-section-title">Pullout Type</div>
                <div class="filter-options">
                  <div class="filter-option">
                    <input type="checkbox" id="type-damaged" checked>
                    <label for="type-damaged">Damaged</label>
                  </div>
                  <div class="filter-option">
                    <input type="checkbox" id="type-expired" checked>
                    <label for="type-expired">Expired</label>
                  </div>
                  <div class="filter-option">
                    <input type="checkbox" id="type-return" checked>
                    <label for="type-return">Return to Supplier</label>
                  </div>
                </div>
              </div>
              
              <div class="filter-section">
                <div class="filter-section-title">Time Period</div>
                <div class="filter-options">
                  <div class="filter-option">
                    <input type="radio" name="timePeriod" id="period-today">
                    <label for="period-today">Today</label>
                  </div>
                  <div class="filter-option">
                    <input type="radio" name="timePeriod" id="period-week" checked>
                    <label for="period-week">This Week</label>
                  </div>
                  <div class="filter-option">
                    <input type="radio" name="timePeriod" id="period-month">
                    <label for="period-month">This Month</label>
                  </div>
                  <div class="filter-option">
                    <input type="radio" name="timePeriod" id="period-custom">
                    <label for="period-custom">Custom Range</label>
                  </div>
                </div>
                <div class="date-inputs mt-2" id="customDateRange" style="display: none;">
                  <div class="mb-2">
                    <input type="date" class="form-control form-control-sm" id="dateFrom" placeholder="From Date">
                  </div>
                  <div>
                    <input type="date" class="form-control form-control-sm" id="dateTo" placeholder="To Date">
                  </div>
                </div>
              </div>
              
              <div class="filter-actions">
                <button class="btn-apply" id="applyFilters">Apply Filters</button>
                <button class="btn-clear" id="clearFilters">Reset Filters</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4">
      <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4">
      <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4">
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
        <h5 class="card-title mb-0">Pullout Records</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPulloutModal">
          <i class="fas fa-plus me-2"></i>New Pullout
        </button>
      </div>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Pullout ID</th>
              <th>Product</th>
              <th>Employee</th>
              <th>Quantity</th>
              <th>Reason</th>
              <th>Type</th>
              <th>Date Pulled Out</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="pulloutTableBody">
            @forelse($pullOuts as $pullOut)
            <tr data-type="{{ $pullOut->PullOutType }}" data-date="{{ \Carbon\Carbon::parse($pullOut->DatePullOut)->format('Y-m-d') }}">
              <td><strong>{{ $pullOut->PullOutID }}</strong></td>
              <td>
                <div style="font-weight:600">{{ $pullOut->product->ProductName ?? 'N/A' }}</div>
                <div class="text-muted small">SKU: {{ $pullOut->product->SKUNumber ?? '' }}</div>
                <div class="text-muted small">ID: {{ $pullOut->ProductID ?? '' }}</div>
              </td>
              <td>
                @php
                  $employeeName = 'N/A';
                  $employeeId = '';
                  
                  if ($pullOut->employee) {
                    $employeeName = ($pullOut->employee->EmployeeFName ?? $pullOut->employee->EmpFName ?? '') . ' ' . 
                                   ($pullOut->employee->EmployeeLName ?? $pullOut->employee->EmpLName ?? '');
                    $employeeId = $pullOut->employee->EmployeeID ?? '';
                  }
                @endphp
                <div style="font-weight:600">{{ trim($employeeName) ?: 'N/A' }}</div>
                <div class="text-muted small">{{ $employeeId }}</div>
              </td>
              <td>
                <div style="font-weight:600" class="text-danger">-{{ $pullOut->PullOutQty }}</div>
              </td>
              <td>
                <div class="text small">{{ $pullOut->PullOutReason ?? 'N/A' }}</div>
              </td>
              <td>
                @if($pullOut->PullOutType == 'Damaged')
                  <span class="status-badge status-damaged">Damaged</span>
                @elseif($pullOut->PullOutType == 'Expired')
                  <span class="status-badge status-expired">Expired</span>
                @elseif($pullOut->PullOutType == 'Return')
                  <span class="status-badge status-return">Returned</span>
                @else
                  <span class="badge bg-secondary">{{ $pullOut->PullOutType }}</span>
                @endif
              </td>
              <td>
                <div class="text-muted small">{{ \Carbon\Carbon::parse($pullOut->DatePullOut)->format('M d, Y') }}</div>
              </td>
              <td>
                <div class="action-buttons">
                  <button class="btn btn-sm btn-outline-primary view-pullout-btn" 
                          data-id="{{ $pullOut->PullOutID }}"
                          data-product-name="{{ $pullOut->product->ProductName ?? 'N/A' }}"
                          data-sku="{{ $pullOut->product->SKUNumber ?? '' }}"
                          data-product-id="{{ $pullOut->ProductID }}"
                          data-employee-name="{{ trim($employeeName) ?: 'N/A' }}"
                          data-employee-id="{{ $employeeId }}"
                          data-qty="{{ $pullOut->PullOutQty }}"
                          data-reason="{{ $pullOut->PullOutReason }}"
                          data-type="{{ $pullOut->PullOutType }}"
                          data-date="{{ \Carbon\Carbon::parse($pullOut->DatePullOut)->format('M d, Y') }}"
                          title="View">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button class="btn btn-sm btn-outline-danger delete-pullout-btn" 
                          data-id="{{ $pullOut->PullOutID }}"
                          data-product="{{ $pullOut->product->ProductName ?? 'N/A' }}"
                          data-qty="{{ $pullOut->PullOutQty }}"
                          data-reason="{{ $pullOut->PullOutReason }}"
                          title="Delete">
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-5">
                <div class="empty-state">
                  <i class="fas fa-box-open fa-2x mb-3"></i>
                  <h5>No pullout records found</h5>
                  <p class="mb-0">Add your first pullout record using the "New Pullout" button</p>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
          <i class="fas fa-list me-2"></i>Total: <span id="totalCount">{{ count($pullOuts) }}</span> record{{ count($pullOuts) !== 1 ? 's' : '' }}
        </div>
      </div>
    </div>
  </div>
</main>

<div class="modal fade" id="addPulloutModal" tabindex="-1" aria-labelledby="addPulloutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPulloutModalLabel">New Pullout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.pullout.store') }}" method="POST" id="pulloutForm">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="SKUNumber" class="form-label required">Product</label>
                <select class="form-select" id="SKUNumber" name="SKUNumber" required onchange="updateStockInfo()">
                  <option value="">Select Product</option>
                  @if(count($products) > 0)
                    @foreach($products as $product)
                      @php
                        $availableQty = $product->available_qty ?? $product->StockQty ?? 0;
                      @endphp
                      <option value="{{ $product->SKUNumber }}" 
                        data-product-id="{{ $product->ProductID }}"
                        data-product-name="{{ $product->ProductName ?? 'N/A' }}"
                        data-sku="{{ $product->SKUNumber ?? 'N/A' }}"
                        data-available-qty="{{ $availableQty }}"
                        data-current-stock="{{ $product->StockQty ?? 0 }}"
                        data-supplier="{{ $product->supplier->SupplierName ?? 'N/A' }}"
                        data-retail-price="{{ $product->pricing->RetailPrice ?? 0 }}"
                        data-original-price="{{ $product->pricing->OriginalPrice ?? 0 }}"
                        data-category="{{ $product->category->CategoryName ?? 'N/A' }}">
                        {{ $product->SKUNumber }} - {{ $product->ProductName }} (Available: {{ $availableQty }})
                      </option>
                    @endforeach
                  @else
                    <option value="" disabled>No products with available stock</option>
                  @endif
                </select>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="mb-3">
              <label class="form-label">Employee</label>
                            <div class="form-control readonly-field">
                                <strong>{{ $employeeName ?? 'Cashier' }}</strong> 
                                @if($employeeId)
                                <br><small>ID: {{ $employeeId }}</small>
                                @endif
                            </div>
                            <input type="hidden" name="EmployeeID" value="{{ $employeeId }}">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="PullOutQty" class="form-label required">Quantity</label>
                <div class="input-group">
                  <input type="number" class="form-control" id="PullOutQty" name="PullOutQty" min="1" required oninput="validateQuantity()">
                  <span class="input-group-text">units</span>
                </div>
                <div class="text-danger mt-1" id="quantityError" style="display: none;">
                  <i class="fas fa-exclamation-circle"></i> Cannot exceed available quantity
                </div>
                <small class="text-muted" id="availableQtyInfo">Available: <span id="maxAvailableQty">0</span> units</small>
              </div>
            </div>
            
            <div class="col-md-8">
              <div class="mb-3">
                <label for="PullOutReason" class="form-label required">Reason</label>
                <input type="text" class="form-control" id="PullOutReason" name="PullOutReason" 
                       placeholder="e.g., Product damaged during handling, Expired goods, Return to supplier" 
                       required maxlength="255">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="PullOutType" class="form-label required">Pullout Type</label>
                <select class="form-select" id="PullOutType" name="PullOutType" required>
                  <option value="">Select Type</option>
                  <option value="Damaged">Damaged</option>
                  <option value="Expired">Expired</option>
                  <option value="Return">Return to Supplier</option>
                  <option value="Theft">Theft/Loss</option>
                  <option value="Quality Control">Quality Control</option>
                  <option value="Other">Other</option>
                </select>
              </div>
            </div>
            
            <div class="col-md-8">
              <div class="mb-3">
                <label for="DatePullOut" class="form-label required">Date Pulled Out</label>
                <input type="date" class="form-control" id="DatePullOut" name="DatePullOut" value="{{ date('Y-m-d') }}" required>
              </div>
            </div>
          </div>

          <div class="mb-3" id="stockInfoCard" style="display: none;">
            <div class="card">
              <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Product Information</h6>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 mb-2">
                    <small class="text-muted d-block">Product Name</small>
                    <strong id="displayProductName">-</strong>
                  </div>
                  <div class="col-md-6 mb-2">
                    <small class="text-muted d-block">SKU Number</small>
                    <strong id="displaySKU">-</strong>
                  </div>
                  <div class="col-md-6 mb-2">
                    <small class="text-muted d-block">Category</small>
                    <strong id="displayCategory">-</strong>
                  </div>
                  <div class="col-md-6 mb-2">
                    <small class="text-muted d-block">Available Quantity</small>
                    <strong id="displayAvailableQty" class="text-primary">0</strong>
                  </div>
                  <div class="col-md-6 mb-2">
                    <small class="text-muted d-block">Current Stock in System</small>
                    <strong id="displayCurrentStock" class="text-info">0</strong>
                  </div>
                  <div class="col-md-6 mb-2">
                    <small class="text-muted d-block">Supplier</small>
                    <strong id="displaySupplier">-</strong>
                  </div>
                  <div class="col-md-6 mb-2">
                    <small class="text-muted d-block">Cost Price</small>
                    <strong id="displayCostPrice">₱0.00</strong>
                  </div>
                  <div class="col-md-6 mb-2">
                    <small class="text-muted d-block">Retail Price</small>
                    <strong id="displayRetailPrice">₱0.00</strong>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="alert alert-warning py-2" id="stockWarning" style="display: none;">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <span id="stockWarningText"></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="submitPulloutBtn">Pullout</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="viewPulloutModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pullout Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label"><strong>Pullout ID</strong></label>
            <div class="form-control bg-light" id="viewPulloutID">-</div>
          </div>
          
          <div class="col-md-6">
            <label class="form-label"><strong>Date Pulled Out</strong></label>
            <div class="form-control bg-light" id="viewDatePullOut">-</div>
          </div>
          
          <div class="col-md-12">
            <label class="form-label"><strong>Product Information</strong></label>
            <div class="card bg-light">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <small class="text-muted d-block">Product Name</small>
                    <strong id="viewProductName">-</strong>
                  </div>
                  <div class="col-md-6">
                    <small class="text-muted d-block">SKU Number</small>
                    <strong id="viewSKU">-</strong>
                  </div>
                  <div class="col-md-6">
                    <small class="text-muted d-block">Product ID</small>
                    <strong id="viewProductID">-</strong>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-12">
            <label class="form-label"><strong>Employee Information</strong></label>
            <div class="card bg-light">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <small class="text-muted d-block">Employee Name</small>
                    <strong id="viewEmployeeName">-</strong>
                  </div>
                  <div class="col-md-6">
                    <small class="text-muted d-block">Employee ID</small>
                    <strong id="viewEmployeeID">-</strong>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-4">
            <label class="form-label"><strong>Quantity</strong></label>
            <div class="form-control bg-light text-danger" id="viewPullOutQty">-</div>
          </div>
          
          <div class="col-md-4">
            <label class="form-label"><strong>Type</strong></label>
            <div class="form-control bg-light" id="viewPullOutType">-</div>
          </div>

          <div class="col-md-12">
            <label class="form-label"><strong>Reason (Description)</strong></label>
            <div class="form-control bg-light" id="viewPullOutReason">-</div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deletePulloutModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="text-center mb-4">
          <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
          <h5>Are you sure you want to delete this pullout?</h5>
          <p class="text-muted">This action will restore the stock quantity and cannot be undone.</p>
        </div>
        <div class="card bg-light">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <small class="text-muted d-block">Pullout ID</small>
                <strong id="deletePulloutID">-</strong>
              </div>
              <div class="col-md-6">
                <small class="text-muted d-block">Product</small>
                <strong id="deleteProductName">-</strong>
              </div>
              <div class="col-md-6">
                <small class="text-muted d-block">Quantity</small>
                <strong id="deletePullOutQty">-</strong>
              </div>
              <div class="col-md-6">
                <small class="text-muted d-block">Reason</small>
                <strong id="deletePullOutReason">-</strong>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete Pullout</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Sidebar functionality
  const sidebar = document.getElementById('sidebar');
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebarOverlay = document.getElementById('sidebarOverlay');
  const contentWrap = document.getElementById('contentWrap');

  sidebarToggle.addEventListener('click', function() {
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

  // Update stock info when product is selected
  function updateStockInfo() {
    const skuSelect = document.getElementById('SKUNumber');
    const selectedOption = skuSelect.options[skuSelect.selectedIndex];
    const stockInfoCard = document.getElementById('stockInfoCard');
    const stockWarning = document.getElementById('stockWarning');
    const availableQtyInfo = document.getElementById('availableQtyInfo');
    
    if (selectedOption.value) {
      stockInfoCard.style.display = 'block';
      availableQtyInfo.style.display = 'block';
      
      document.getElementById('displayProductName').textContent = selectedOption.dataset.productName || '-';
      document.getElementById('displaySKU').textContent = selectedOption.dataset.sku || '-';
      document.getElementById('displayCategory').textContent = selectedOption.dataset.category || '-';
      
      const availableQty = parseInt(selectedOption.dataset.availableQty) || 0;
      const currentStock = parseInt(selectedOption.dataset.currentStock) || 0;
      
      document.getElementById('displayAvailableQty').textContent = availableQty;
      document.getElementById('displayCurrentStock').textContent = currentStock;
      document.getElementById('displaySupplier').textContent = selectedOption.dataset.supplier || '-';
      document.getElementById('maxAvailableQty').textContent = availableQty;
      
      const costPrice = parseFloat(selectedOption.dataset.originalPrice) || 0;
      const retailPrice = parseFloat(selectedOption.dataset.retailPrice) || 0;
      document.getElementById('displayCostPrice').textContent = '₱' + costPrice.toFixed(2);
      document.getElementById('displayRetailPrice').textContent = '₱' + retailPrice.toFixed(2);
      
      document.getElementById('PullOutQty').value = '';
      document.getElementById('quantityError').style.display = 'none';
      document.getElementById('submitPulloutBtn').disabled = false;
      
      if (availableQty < 10) {
        stockWarning.style.display = 'block';
        document.getElementById('stockWarningText').textContent = `Low stock warning! Only ${availableQty} units available.`;
      } else {
        stockWarning.style.display = 'none';
      }
      
      if (availableQty === 0) {
        stockWarning.style.display = 'block';
        document.getElementById('stockWarningText').textContent = 'Out of stock! Cannot pull out this product.';
        document.getElementById('submitPulloutBtn').disabled = true;
      }
    } else {
      stockInfoCard.style.display = 'none';
      stockWarning.style.display = 'none';
      availableQtyInfo.style.display = 'none';
      document.getElementById('maxAvailableQty').textContent = '0';
    }
  }

  // Validate quantity input
  function validateQuantity() {
    const quantityInput = document.getElementById('PullOutQty');
    const quantity = parseInt(quantityInput.value) || 0;
    const maxQty = parseInt(document.getElementById('maxAvailableQty').textContent) || 0;
    const quantityError = document.getElementById('quantityError');
    const submitBtn = document.getElementById('submitPulloutBtn');
    
    if (quantity > maxQty) {
      quantityError.style.display = 'block';
      submitBtn.disabled = true;
    } else if (quantity <= 0) {
      quantityError.style.display = 'block';
      quantityError.innerHTML = '<i class="fas fa-exclamation-circle"></i> Quantity must be greater than 0';
      submitBtn.disabled = true;
    } else {
      quantityError.style.display = 'none';
      submitBtn.disabled = false;
    }
  }

  // Filter functionality
  const filterToggle = document.getElementById('filterToggle');
  const filterMenu = document.getElementById('filterMenu');
  const searchInput = document.getElementById('searchInput');
  const pulloutTableBody = document.getElementById('pulloutTableBody');
  const totalCount = document.getElementById('totalCount');
  
  const userDropdownToggle = document.getElementById('userDropdownToggle');
  const userDropdownMenu = document.getElementById('userDropdownMenu');
  
  let currentFilters = {
    types: ['Damaged', 'Expired', 'Return'],
    search: ''
  };
  
  filterToggle.addEventListener('click', function(e) {
    e.stopPropagation();
    const isVisible = filterMenu.style.display === 'block';
    filterMenu.style.display = isVisible ? 'none' : 'block';
    filterToggle.classList.toggle('active', !isVisible);
  });
  
  userDropdownToggle.addEventListener('click', function(e) {
    e.stopPropagation();
    const isVisible = userDropdownMenu.style.display === 'block';
    userDropdownMenu.style.display = isVisible ? 'none' : 'block';
  });
  
  document.addEventListener('click', function() {
    filterMenu.style.display = 'none';
    filterToggle.classList.remove('active');
    userDropdownMenu.style.display = 'none';
  });
  
  filterMenu.addEventListener('click', function(e) {
    e.stopPropagation();
  });
  
  userDropdownMenu.addEventListener('click', function(e) {
    e.stopPropagation();
  });
  
  // Time period radio buttons
  document.querySelectorAll('input[name="timePeriod"]').forEach(radio => {
    radio.addEventListener('change', function() {
      if (this.id === 'period-custom') {
        document.getElementById('customDateRange').style.display = 'block';
      } else {
        document.getElementById('customDateRange').style.display = 'none';
      }
    });
  });
  
  // Search input
  searchInput.addEventListener('input', function() {
    currentFilters.search = this.value.toLowerCase();
    filterPullouts();
  });
  
  // Apply filters button
  document.getElementById('applyFilters').addEventListener('click', function() {
    filterMenu.style.display = 'none';
    filterToggle.classList.remove('active');
    
    // Update current filters
    currentFilters.types = [];
    if (document.getElementById('type-damaged').checked) {
      currentFilters.types.push('Damaged');
    }
    if (document.getElementById('type-expired').checked) {
      currentFilters.types.push('Expired');
    }
    if (document.getElementById('type-return').checked) {
      currentFilters.types.push('Return');
    }
    
    // Handle date filtering
    const timePeriod = document.querySelector('input[name="timePeriod"]:checked')?.id;
    if (timePeriod === 'period-custom') {
      const dateFrom = document.getElementById('dateFrom').value;
      const dateTo = document.getElementById('dateTo').value;
      currentFilters.dateFrom = dateFrom;
      currentFilters.dateTo = dateTo;
    } else {
      currentFilters.dateFrom = null;
      currentFilters.dateTo = null;
    }
    
    filterPullouts();
  });
  
  // Clear filters button
  document.getElementById('clearFilters').addEventListener('click', function() {
    document.getElementById('type-damaged').checked = true;
    document.getElementById('type-expired').checked = true;
    document.getElementById('type-return').checked = true;
    document.getElementById('period-week').checked = true;
    
    document.getElementById('customDateRange').style.display = 'none';
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    
    searchInput.value = '';
    
    currentFilters = {
      types: ['Damaged', 'Expired', 'Return'],
      search: ''
    };
    
    filterPullouts();
  });
  
  // Filter pullouts function
  function filterPullouts() {
    const rows = pulloutTableBody.getElementsByTagName('tr');
    let visibleCount = 0;
    
    for (let row of rows) {
      if (row.style.display === 'none') continue;
      
      const text = row.textContent.toLowerCase();
      const type = row.getAttribute('data-type');
      const date = row.getAttribute('data-date');
      
      const searchMatch = currentFilters.search === '' || text.includes(currentFilters.search);
      const typeMatch = currentFilters.types.includes(type);
      
      let dateMatch = true;
      if (currentFilters.dateFrom && currentFilters.dateTo) {
        const rowDate = new Date(date);
        const fromDate = new Date(currentFilters.dateFrom);
        const toDate = new Date(currentFilters.dateTo);
        toDate.setDate(toDate.getDate() + 1); // Include end date
        
        dateMatch = rowDate >= fromDate && rowDate < toDate;
      }
      
      if (searchMatch && typeMatch && dateMatch) {
        row.style.display = '';
        visibleCount++;
      } else {
        row.style.display = 'none';
      }
    }
    
    totalCount.textContent = visibleCount;
  }
  
  // Initialize on page load
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('DatePullOut').value = new Date().toISOString().split('T')[0];
    
    // Initialize filter checkboxes
    document.getElementById('type-damaged').checked = true;
    document.getElementById('type-expired').checked = true;
    document.getElementById('type-return').checked = true;
    document.getElementById('period-week').checked = true;
    
    filterPullouts();
  });

  // Window resize handler
  window.addEventListener('resize', function() {
    if (window.innerWidth >= 992) {
      sidebar.classList.remove('mobile-open');
      sidebarOverlay.classList.remove('active');
      document.body.style.overflow = '';
    }
  });

  // Auto-close alerts after 5 seconds
  document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    }, 5000);
  });

  // View pullout details
  document.addEventListener('click', function(e) {
    if (e.target.closest('.view-pullout-btn')) {
      const btn = e.target.closest('.view-pullout-btn');
      
      document.getElementById('viewPulloutID').textContent = btn.getAttribute('data-id');
      document.getElementById('viewDatePullOut').textContent = btn.getAttribute('data-date');
      document.getElementById('viewProductName').textContent = btn.getAttribute('data-product-name');
      document.getElementById('viewSKU').textContent = btn.getAttribute('data-sku');
      document.getElementById('viewProductID').textContent = btn.getAttribute('data-product-id');
      document.getElementById('viewEmployeeName').textContent = btn.getAttribute('data-employee-name');
      document.getElementById('viewEmployeeID').textContent = btn.getAttribute('data-employee-id');
      document.getElementById('viewPullOutQty').textContent = `-${btn.getAttribute('data-qty')}`;
      document.getElementById('viewPullOutReason').textContent = btn.getAttribute('data-reason');
      document.getElementById('viewPullOutType').textContent = btn.getAttribute('data-type');
      
      const viewModal = new bootstrap.Modal(document.getElementById('viewPulloutModal'));
      viewModal.show();
    }
    
    // Delete pullout
    if (e.target.closest('.delete-pullout-btn')) {
      const btn = e.target.closest('.delete-pullout-btn');
      const pulloutId = btn.getAttribute('data-id');
      const productName = btn.getAttribute('data-product');
      const qty = btn.getAttribute('data-qty');
      const reason = btn.getAttribute('data-reason');
      
      document.getElementById('deletePulloutID').textContent = pulloutId;
      document.getElementById('deleteProductName').textContent = productName;
      document.getElementById('deletePullOutQty').textContent = `-${qty}`;
      document.getElementById('deletePullOutReason').textContent = reason;
      
      const deleteModal = new bootstrap.Modal(document.getElementById('deletePulloutModal'));
      deleteModal.show();
      
      const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
      const originalText = confirmDeleteBtn.innerHTML;
      
      // Set up delete confirmation
      confirmDeleteBtn.onclick = function() {
        confirmDeleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Deleting...';
        confirmDeleteBtn.disabled = true;
        
        fetch(`/admin/pullout/${pulloutId}`, {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            showAlert('success', data.message);
            
            const row = btn.closest('tr');
            row.style.transition = 'opacity 0.3s';
            row.style.opacity = '0';
            
            setTimeout(() => {
              row.remove();
              
              const totalRows = document.querySelectorAll('#pulloutTableBody tr').length;
              document.getElementById('totalCount').textContent = totalRows;
              
              deleteModal.hide();
              
              confirmDeleteBtn.innerHTML = originalText;
              confirmDeleteBtn.disabled = false;
              
              // Reload after a short delay to update data
              setTimeout(() => {
                location.reload();
              }, 1000);
            }, 300);
          } else {
            showAlert('error', data.message);
            confirmDeleteBtn.innerHTML = originalText;
            confirmDeleteBtn.disabled = false;
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showAlert('error', 'Error deleting pullout. Please try again.');
          confirmDeleteBtn.innerHTML = originalText;
          confirmDeleteBtn.disabled = false;
        });
      };
    }
  });

  // Show alert function
  function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
      <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle me-2"></i>
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const topbar = document.querySelector('.topbar');
    topbar.parentNode.insertBefore(alertDiv, topbar.nextSibling);
    
    setTimeout(() => {
      const bsAlert = new bootstrap.Alert(alertDiv);
      bsAlert.close();
    }, 5000);
  }
  
</script>
</body>
</html>
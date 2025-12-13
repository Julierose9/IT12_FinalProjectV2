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
      width: 40px; 
      height: 40px;
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
      gap: 16px; 
      align-items: flex-start; 
      justify-content: space-between; 
      margin-bottom: 22px; 
      flex-wrap: wrap;
      padding: 28px 28px 0 28px;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .page-title-section {
      flex: 1;
      min-width: 250px;
    }

    /* ========== USER SECTION STYLES ========== */
    .user-section {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 16px;
      min-width: 300px;
      width: 100%;
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

    .main-content {
      padding: 0 28px 28px 28px;
    }

    /* ========== SEARCH & FILTER STYLES ========== */
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

    /* Date Picker Container */
    .date-picker-container {
      flex-shrink: 0;
    }

    .date-picker-container .input-group {
      width: auto;
      min-width: 200px;
    }

    .date-picker-container .form-control {
      width: 150px;
    }

    .date-picker-container .btn {
      padding: 8px 12px;
    }

    /* Filter toggle button without text */
    .filter-toggle {
      background: #fff;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 10px 12px;
      display: flex;
      align-items: center;
      gap: 6px;
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

    /* Filter Menu */
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

    /* Stats Cards - Quick Links */
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
    
    .card-small { 
      border-radius: 12px; 
      height: 100%;
      border: none;
      box-shadow: var(--card-shadow);
    }
    
    .chart-container {
      position: relative;
      height: 100%;
      min-height: 200px;
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
        min-height: 180px;
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
      
      .user-section {
        align-items: stretch;
        min-width: 100%;
      }
      
      .search-filter-section {
        flex-wrap: wrap;
      }
      
      .search-input {
        min-width: 100%;
      }
      
      .date-picker-container {
        flex: 1;
      }
      
      .date-picker-container .input-group {
        width: 100%;
      }
      
      .date-picker-container .form-control {
        width: 100%;
      }
      
      .user-dropdown-menu {
        right: auto;
        left: 0;
      }
      
      .filter-container {
        align-items: stretch;
      }
      
      .active-filters {
        justify-content: flex-start;
      }

      .user-dropdown {
        width: 100%;
      }

      .user-dropdown-toggle {
        width: 100%;
        justify-content: center;
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
        min-height: 160px;
      }
      
      .content-wrap {
        padding: 70px 0 0 0;
      }

      .topbar {
        margin-bottom: 16px;
        padding: 20px 12px 0 12px;
      }

      .search-filter-section {
        flex-direction: column;
      }

      .date-picker-container,
      .filter-dropdown {
        width: 100%;
      }
      
      .filter-toggle {
        width: 100%;
        justify-content: center;
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
    <div class="page-title-section">
      <h4 class="mb-1">Dashboard</h4>
      <p class="text-muted mb-0">Overview of your inventory and sales</p>
    </div>

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
      
      <!-- Filter Container with Search/Filter and Active Filters -->
      <div class="filter-container">
        <!-- Search and Filter Section -->
        <div class="search-filter-section">
          <!-- Expanded Search Bar -->
          <div class="input-group search-input">
            <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
            <input type="text" class="form-control" placeholder="Search products, suppliers..." id="searchInput">
          </div>
          
          <!-- Date Picker -->
          <div class="date-picker-container">
            <div class="input-group">
              <input type="date" class="form-control" id="dateFilter" value="{{ $today }}">
              <button class="btn btn-outline-primary" type="button" id="applyDateFilter">
                <i class="fas fa-calendar-check"></i>
              </button>
            </div>
          </div>
          
          <!-- Relevant Filter Dropdown -->
          <div class="filter-dropdown">
            <button class="filter-toggle" id="filterToggle">
              <i class="fas fa-filter"></i>
              <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
            </button>
            
            <div class="filter-menu" id="filterMenu">
              <!-- Time Period Filter -->
              <div class="filter-section">
                <div class="filter-section-title">Time Period</div>
                <div class="filter-options">
                  <div class="filter-option">
                    <input type="radio" name="timePeriod" id="period-today" checked>
                    <label for="period-today">Today</label>
                  </div>
                  <div class="filter-option">
                    <input type="radio" name="timePeriod" id="period-week">
                    <label for="period-week">This Week</label>
                  </div>
                  <div class="filter-option">
                    <input type="radio" name="timePeriod" id="period-month">
                    <label for="period-month">This Month</label>
                  </div>
                  <div class="filter-option">
                    <input type="radio" name="timePeriod" id="period-quarter">
                    <label for="period-quarter">This Quarter</label>
                  </div>
                  <div class="filter-option">
                    <input type="radio" name="timePeriod" id="period-year">
                    <label for="period-year">This Year</label>
                  </div>
                </div>
              </div>
              
              <!-- Category Filter -->
              <div class="filter-section">
                <div class="filter-section-title">Category</div>
                <div class="filter-options">
                  <div class="filter-option">
                    <input type="checkbox" id="category-all" checked>
                    <label for="category-all">All Categories</label>
                  </div>
                  @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $category)
                      <div class="filter-option">
                        <input type="checkbox" id="category-{{ $category->CategoryID }}">
                        <label for="category-{{ $category->CategoryID }}">{{ $category->CategoryName }}</label>
                      </div>
                    @endforeach
                  @else
                    <div class="text-muted" style="font-size: 0.8rem;">No categories available</div>
                  @endif
                </div>
              </div>
              
              <!-- Stock Status Filter -->
              <div class="filter-section">
                <div class="filter-section-title">Stock Status</div>
                <div class="filter-options">
                  <div class="filter-option">
                    <input type="radio" name="stockStatus" id="status-all" checked>
                    <label for="status-all">All Items</label>
                  </div>
                  <div class="filter-option">
                    <input type="radio" name="stockStatus" id="status-low">
                    <label for="status-low">Low Stock</label>
                  </div>
                  <div class="filter-option">
                    <input type="radio" name="stockStatus" id="status-normal">
                    <label for="status-normal">Normal Stock</label>
                  </div>
                  <div class="filter-option">
                    <input type="radio" name="stockStatus" id="status-high">
                    <label for="status-high">High Stock</label>
                  </div>
                </div>
              </div>
              
              <!-- Expiry Status Filter -->
              <div class="filter-section">
                <div class="filter-section-title">Expiry Status</div>
                <div class="filter-options">
                  <div class="filter-option">
                    <input type="radio" name="expiryStatus" id="expiry-all" checked>
                    <label for="expiry-all">All Items</label>
                  </div>
                  <div class="filter-option">
                    <input type="radio" name="expiryStatus" id="expiry-near">
                    <label for="expiry-near">Near Expiry</label>
                  </div>
                  <div class="filter-option">
                    <input type="radio" name="expiryStatus" id="expiry-safe">
                    <label for="expiry-safe">Safe</label>
                  </div>
                </div>
              </div>
              
              <!-- Action Buttons -->
              <div class="filter-actions">
                <button class="btn-apply" id="applyFilters">Apply Filters</button>
                <button class="btn-clear" id="clearFilters">Reset Filters</button>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Active Filters Display -->
        <div class="active-filters" id="activeFilters">
          <!-- Filter tags will be dynamically added here -->
        </div>
      </div>
    </div>
  </div>

  <div class="main-content">
    <!-- Stats Cards with Quick Links -->
    <div class="row g-3 mb-4">
      <div class="col-xl-3 col-md-6">
        <a href="{{ route('admin.products') }}" class="stat-card">
          <div class="card p-3">
            <span class="stat-badge">View Products</span>
            <div class="d-flex">
              <div class="stat-icon me-3" style="background:#f3d6ff;">
                <i class="fas fa-box" style="color:#5a3e6b;"></i>
              </div>
              <div class="flex-fill d-flex flex-column">
                <small class="text-muted">Total Products</small>
                <div class="mt-auto text-end" style="font-weight:700; font-size:20px;" id="totalProducts">
                  {{ $totalProducts ?? 0 }}
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
              <div class="stat-icon me-3" style="background:#fff2e0;">
                <i class="fas fa-arrow-up" style="color:#f08a24;"></i>
              </div>
              <div class="flex-fill d-flex flex-column">
                <small class="text-muted">Stock Out Today</small>
                <div class="mt-auto text-end" style="font-weight:700; font-size:20px;" id="stockOutToday">
                  {{ $stockOutToday ?? 0 }}
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
              <div class="stat-icon me-3" style="background:#fff8e1;">
                <i class="fas fa-clock" style="color:#ff9800;"></i>
              </div>
              <div class="flex-fill d-flex flex-column">
                <small class="text-muted">Products Near Expiry</small>
                <div class="mt-auto text-end" style="font-weight:700; font-size:20px;" id="nearExpiry">
                  {{ $nearExpiry ?? 0 }}
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
              <div class="stat-icon me-3" style="background:#fff0f0;">
                <i class="fas fa-exclamation-triangle" style="color:#e05252;"></i>
              </div>
              <div class="flex-fill d-flex flex-column">
                <small class="text-muted">Low Stock Items</small>
                <div class="mt-auto text-end" style="font-weight:700; font-size:20px;" id="lowStock">
                  {{ $lowStock ?? 0 }}
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>

    <div class="row g-3">
      <div class="col-lg-8">
        <div class="card p-3 card-small mb-3">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <strong>Stock Movement Trend</strong>
            <small class="text-muted" id="trendPeriod">This week</small>
          </div>
          <div class="chart-container">
            <canvas id="trendChart"></canvas>
          </div>
        </div>

        <div class="row g-3">
          <div class="col-md-6">
            <div class="card p-3 card-small">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <strong>Sales by Category</strong>
                <small class="text-muted" id="salesPeriod">Monthly</small>
              </div>
              <div class="chart-container">
                <canvas id="pieChart"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card p-3 card-small">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <strong>Inventory Value</strong>
                <small class="text-muted" id="valuePeriod">By Category</small>
              </div>
              <div class="chart-container">
                <canvas id="doughnutChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card p-3 card-small mb-3">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <strong>Top Moving Products</strong>
            <small class="text-muted" id="topProductsPeriod">This Week</small>
          </div>
          <ul class="list-unstyled mb-0" id="topProductsList">
            @if(isset($topProducts) && count($topProducts) > 0)
              @foreach($topProducts as $product)
                <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                  <div>
                    <div style="font-weight:600">{{ $product->ProductName }}</div>
                    <small class="text-muted">SKU: {{ $product->SKUNumber }}</small>
                  </div>
                  <div>
                    <span class="badge bg-light text-dark">{{ $product->total_sold ?? 0 }} units</span>
                  </div>
                </li>
              @endforeach
            @else
              <li class="text-center py-3 text-muted">No data available</li>
            @endif
          </ul>
        </div>

        <div class="card p-3 card-small">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <strong>Inventory Turnover Rate</strong>
            <small class="text-muted" id="turnoverPeriod">Monthly</small>
          </div>
          <div class="chart-container">
            <canvas id="areaChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-3 mt-3">
      <div class="col-md-6">
        <div class="card p-3 card-small">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <strong>Stock vs Recorded</strong>
            <small class="text-muted">Discrepancy Analysis</small>
          </div>
          <div class="chart-container">
            <canvas id="barChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card p-3 card-small">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <strong>Supplier Performance</strong>
            <small class="text-muted">Delivery Timeliness</small>
          </div>
          <div class="chart-container">
            <canvas id="radarChart"></canvas>
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

  // ========== FILTER FUNCTIONALITY ==========
  const filterToggle = document.getElementById('filterToggle');
  const filterMenu = document.getElementById('filterMenu');
  const activeFilters = document.getElementById('activeFilters');
  const searchInput = document.getElementById('searchInput');
  const dateFilter = document.getElementById('dateFilter');
  const applyDateFilter = document.getElementById('applyDateFilter');
  
  let currentFilters = {
    timePeriod: 'Today',
    categories: ['All Categories'],
    stockStatus: 'All Items',
    expiryStatus: 'All Items',
    date: '{{ $today }}',
    search: ''
  };
  
  // Filter toggle
  filterToggle.addEventListener('click', function(e) {
    e.stopPropagation();
    const isVisible = filterMenu.style.display === 'block';
    filterMenu.style.display = isVisible ? 'none' : 'block';
    filterToggle.classList.toggle('active', !isVisible);
  });
  
  // Close filter menu when clicking outside
  document.addEventListener('click', function() {
    filterMenu.style.display = 'none';
    filterToggle.classList.remove('active');
  });
  
  // Prevent closing when clicking inside filter menu
  filterMenu.addEventListener('click', function(e) {
    e.stopPropagation();
  });
  
  // Apply filters button
  document.getElementById('applyFilters').addEventListener('click', function() {
    filterMenu.style.display = 'none';
    filterToggle.classList.remove('active');
    
    updateCurrentFilters();
    updateActiveFilters();
    applyDashboardFilters();
  });
  
  // Clear filters button
  document.getElementById('clearFilters').addEventListener('click', function() {
    // Reset all checkboxes and radio buttons
    document.querySelectorAll('.filter-option input[type="checkbox"]').forEach(checkbox => {
      checkbox.checked = false;
    });
    
    document.querySelectorAll('.filter-option input[type="radio"]').forEach(radio => {
      radio.checked = false;
    });
    
    // Set default values
    document.getElementById('period-today').checked = true;
    document.getElementById('category-all').checked = true;
    document.getElementById('status-all').checked = true;
    document.getElementById('expiry-all').checked = true;
    
    searchInput.value = '';
    dateFilter.value = '{{ $today }}';
    
    currentFilters = {
      timePeriod: 'Today',
      categories: ['All Categories'],
      stockStatus: 'All Items',
      expiryStatus: 'All Items',
      date: '{{ $today }}',
      search: ''
    };
    
    updateActiveFilters();
    resetDashboardData();
  });
  
  // Apply date filter
  applyDateFilter.addEventListener('click', function() {
    currentFilters.date = dateFilter.value;
    applyDashboardFilters();
    
    // Add date filter tag
    updateActiveFilters();
  });
  
  // Search input event (debounced)
  let searchTimeout;
  searchInput.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
      currentFilters.search = this.value.toLowerCase();
      applyDashboardFilters();
      updateActiveFilters();
    }, 500);
  });
  
  function updateCurrentFilters() {
    // Time period
    if (document.getElementById('period-today').checked) {
      currentFilters.timePeriod = 'Today';
    } else if (document.getElementById('period-week').checked) {
      currentFilters.timePeriod = 'This Week';
    } else if (document.getElementById('period-month').checked) {
      currentFilters.timePeriod = 'This Month';
    } else if (document.getElementById('period-quarter').checked) {
      currentFilters.timePeriod = 'This Quarter';
    } else if (document.getElementById('period-year').checked) {
      currentFilters.timePeriod = 'This Year';
    }
    
    // Categories
    currentFilters.categories = [];
    if (document.getElementById('category-all').checked) {
      currentFilters.categories.push('All Categories');
    } else {
      @if(isset($categories))
        @foreach($categories as $category)
          if (document.getElementById('category-{{ $category->CategoryID }}').checked) {
            currentFilters.categories.push('{{ $category->CategoryName }}');
          }
        @endforeach
      @endif
    }
    
    // Stock status
    if (document.getElementById('status-all').checked) {
      currentFilters.stockStatus = 'All Items';
    } else if (document.getElementById('status-low').checked) {
      currentFilters.stockStatus = 'Low Stock';
    } else if (document.getElementById('status-normal').checked) {
      currentFilters.stockStatus = 'Normal Stock';
    } else if (document.getElementById('status-high').checked) {
      currentFilters.stockStatus = 'High Stock';
    }
    
    // Expiry status
    if (document.getElementById('expiry-all').checked) {
      currentFilters.expiryStatus = 'All Items';
    } else if (document.getElementById('expiry-near').checked) {
      currentFilters.expiryStatus = 'Near Expiry';
    } else if (document.getElementById('expiry-safe').checked) {
      currentFilters.expiryStatus = 'Safe';
    }
    
    currentFilters.search = searchInput.value.toLowerCase();
  }
  
  function updateActiveFilters() {
    activeFilters.innerHTML = '';
    
    const hasCustomFilters = 
      currentFilters.timePeriod !== 'Today' ||
      currentFilters.categories.length !== 1 || 
      currentFilters.categories[0] !== 'All Categories' ||
      currentFilters.stockStatus !== 'All Items' ||
      currentFilters.expiryStatus !== 'All Items' ||
      currentFilters.date !== '{{ $today }}' ||
      currentFilters.search !== '';
    
    if (!hasCustomFilters) {
      activeFilters.classList.remove('has-filters');
      return;
    }
    
    activeFilters.classList.add('has-filters');
    
    // Time period filter tag
    if (currentFilters.timePeriod !== 'Today') {
      const timeTag = createFilterTag(`Period: ${currentFilters.timePeriod}`, 'time-period');
      activeFilters.appendChild(timeTag);
    }
    
    // Category filter tags
    if (currentFilters.categories.length > 0 && 
      (currentFilters.categories.length > 1 || currentFilters.categories[0] !== 'All Categories')) {
      currentFilters.categories.forEach(category => {
        const categoryTag = createFilterTag(`Category: ${category}`, `category-${category.toLowerCase().replace(/\s+/g, '-')}`);
        activeFilters.appendChild(categoryTag);
      });
    }
    
    // Stock status filter tag
    if (currentFilters.stockStatus !== 'All Items') {
      const stockTag = createFilterTag(`Stock: ${currentFilters.stockStatus}`, 'stock-status');
      activeFilters.appendChild(stockTag);
    }
    
    // Expiry status filter tag
    if (currentFilters.expiryStatus !== 'All Items') {
      const expiryTag = createFilterTag(`Expiry: ${currentFilters.expiryStatus}`, 'expiry-status');
      activeFilters.appendChild(expiryTag);
    }
    
    // Date filter tag
    if (currentFilters.date !== '{{ $today }}') {
      const dateTag = createFilterTag(`Date: ${currentFilters.date}`, 'date');
      activeFilters.appendChild(dateTag);
    }
    
    // Search filter tag
    if (currentFilters.search !== '') {
      const searchTag = createFilterTag(`Search: "${currentFilters.search}"`, 'search');
      activeFilters.appendChild(searchTag);
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
    if (filterType === 'time-period') {
      currentFilters.timePeriod = 'Today';
      document.getElementById('period-today').checked = true;
    } else if (filterType.startsWith('category-')) {
      currentFilters.categories = ['All Categories'];
      document.getElementById('category-all').checked = true;
      @if(isset($categories))
        @foreach($categories as $category)
          document.getElementById('category-{{ $category->CategoryID }}').checked = false;
        @endforeach
      @endif
    } else if (filterType === 'stock-status') {
      currentFilters.stockStatus = 'All Items';
      document.getElementById('status-all').checked = true;
    } else if (filterType === 'expiry-status') {
      currentFilters.expiryStatus = 'All Items';
      document.getElementById('expiry-all').checked = true;
    } else if (filterType === 'date') {
      currentFilters.date = '{{ $today }}';
      dateFilter.value = '{{ $today }}';
    } else if (filterType === 'search') {
      currentFilters.search = '';
      searchInput.value = '';
    }
    
    updateActiveFilters();
    applyDashboardFilters();
  }
  
  function applyDashboardFilters() {
    // Show loading state
    showLoading();
    
    // Update chart labels with current filter
    updateChartPeriods(currentFilters.timePeriod);
    
    // In a real application, you would make an AJAX call here
    // For now, we'll simulate loading and update
    setTimeout(() => {
      // Update stats based on filters (simulated)
      updateStatsBasedOnFilters(currentFilters);
      
      // Update charts
      updateCharts(currentFilters);
      
      hideLoading();
      
      // Show success message
      showToast('Dashboard filters applied!');
    }, 1000);
  }
  
  function resetDashboardData() {
    // Reset to default data
    updateChartPeriods('Today');
    resetStats();
    resetCharts();
    
    showToast('Filters cleared! Dashboard reset to default view.');
  }

  function updateChartPeriods(period) {
    const periodText = period === 'Today' ? 'Today' : 
                      period === 'This Week' ? 'This week' :
                      period === 'This Month' ? 'This month' :
                      period === 'This Quarter' ? 'This quarter' :
                      period === 'This Year' ? 'This year' : 'Today';
    
    document.getElementById('trendPeriod').textContent = periodText;
    document.getElementById('salesPeriod').textContent = periodText;
    document.getElementById('valuePeriod').textContent = periodText;
    document.getElementById('topProductsPeriod').textContent = periodText;
    document.getElementById('turnoverPeriod').textContent = periodText;
  }

  // Update stats based on filters (simulated)
  function updateStatsBasedOnFilters(filters) {
    // In a real app, this would be an AJAX call to get updated stats
    // For demo purposes, we'll just update with random values
    
    const totalProducts = document.getElementById('totalProducts');
    const stockOutToday = document.getElementById('stockOutToday');
    const nearExpiry = document.getElementById('nearExpiry');
    const lowStock = document.getElementById('lowStock');
    
    // Generate random values based on filters
    const baseTotal = 150;
    const baseStockOut = 24;
    const baseNearExpiry = 8;
    const baseLowStock = 12;
    
    // Adjust based on filters (simulated logic)
    let multiplier = 1;
    if (filters.timePeriod === 'This Week') multiplier = 0.8;
    if (filters.timePeriod === 'This Month') multiplier = 1;
    if (filters.timePeriod === 'This Quarter') multiplier = 1.2;
    if (filters.timePeriod === 'This Year') multiplier = 1.5;
    
    if (filters.stockStatus === 'Low Stock') {
      lowStock.textContent = Math.floor(baseLowStock * 1.5);
      totalProducts.textContent = Math.floor(baseTotal * 0.9);
    } else if (filters.stockStatus === 'High Stock') {
      lowStock.textContent = Math.floor(baseLowStock * 0.5);
      totalProducts.textContent = Math.floor(baseTotal * 1.1);
    } else {
      lowStock.textContent = baseLowStock;
      totalProducts.textContent = baseTotal;
    }
    
    if (filters.expiryStatus === 'Near Expiry') {
      nearExpiry.textContent = Math.floor(baseNearExpiry * 1.8);
    } else {
      nearExpiry.textContent = baseNearExpiry;
    }
    
    stockOutToday.textContent = Math.floor(baseStockOut * multiplier);
  }

  // Reset stats to original
  function resetStats() {
    // Reset to original values (in real app, would fetch from server)
    document.getElementById('totalProducts').textContent = '{{ $totalProducts ?? 0 }}';
    document.getElementById('stockOutToday').textContent = '{{ $stockOutToday ?? 0 }}';
    document.getElementById('nearExpiry').textContent = '{{ $nearExpiry ?? 0 }}';
    document.getElementById('lowStock').textContent = '{{ $lowStock ?? 0 }}';
  }

  // Update charts based on filters
  function updateCharts(filters) {
    // In a real app, you would update chart data via AJAX
    // For demo, we'll just regenerate with slightly different data
    
    const trendData = generateTrendData(filters.timePeriod);
    if (window.trendChart) {
      updateChartData(trendChart, trendData.labels, trendData.data);
    }
    
    const turnoverData = generateTurnoverData(filters.timePeriod);
    if (window.areaChart) {
      updateChartData(areaChart, turnoverData.labels, turnoverData.data);
    }
  }

  // Reset charts to original
  function resetCharts() {
    // Reset charts to original data
    if (window.trendChart) {
      updateChartData(trendChart, ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'], [120, 150, 110, 180, 170, 210, 190]);
    }
    if (window.areaChart) {
      updateChartData(areaChart, ['Jan','Feb','Mar','Apr','May','Jun'], [30,45,28,55,40,65]);
    }
  }

  // Utility functions
  function generateTrendData(period) {
    const days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
    let data = [];
    
    // Generate different data based on period
    switch(period) {
      case 'Today':
        data = [50, 60, 55, 70, 65, 80, 75];
        break;
      case 'This Week':
        data = [120, 150, 110, 180, 170, 210, 190];
        break;
      case 'This Month':
        data = [200, 220, 180, 240, 230, 280, 260];
        break;
      case 'This Quarter':
        data = [300, 320, 280, 350, 340, 380, 360];
        break;
      case 'This Year':
        data = [400, 420, 380, 450, 440, 480, 460];
        break;
      default:
        data = [120, 150, 110, 180, 170, 210, 190];
    }
    
    return { labels: days, data: data };
  }

  function generateTurnoverData(period) {
    const months = ['Jan','Feb','Mar','Apr','May','Jun'];
    let data = [];
    
    switch(period) {
      case 'Today':
      case 'This Week':
        data = [10, 15, 8, 20, 15, 25];
        break;
      case 'This Month':
        data = [30,45,28,55,40,65];
        break;
      case 'This Quarter':
        data = [50,65,48,75,60,85];
        break;
      case 'This Year':
        data = [70,85,68,95,80,105];
        break;
      default:
        data = [30,45,28,55,40,65];
    }
    
    return { labels: months, data: data };
  }

  function updateChartData(chart, labels, data) {
    if (chart) {
      chart.data.labels = labels;
      chart.data.datasets[0].data = data;
      chart.update();
    }
  }

  function showLoading() {
    // Add loading state to stats cards
    document.querySelectorAll('.stat-card').forEach(card => {
      card.style.opacity = '0.7';
    });
    
    // Show loading spinner on filter button
    const applyBtn = document.getElementById('applyFilters');
    if (applyBtn) {
      const originalHTML = applyBtn.innerHTML;
      applyBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Applying...';
      applyBtn.disabled = true;
      
      setTimeout(() => {
        applyBtn.innerHTML = originalHTML;
        applyBtn.disabled = false;
      }, 1000);
    }
  }

  function hideLoading() {
    // Remove loading state
    document.querySelectorAll('.stat-card').forEach(card => {
      card.style.opacity = '1';
    });
  }

  function showToast(message) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'position-fixed bottom-0 end-0 p-3';
    toast.style.zIndex = '1050';
    
    toast.innerHTML = `
      <div class="toast show" role="alert">
        <div class="toast-header">
          <strong class="me-auto">Dashboard</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
          ${message}
        </div>
      </div>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
      toast.remove();
    }, 3000);
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
      filterMenu.style.display = 'none';
      filterToggle.classList.remove('active');
    }
  });

  // Chart instances (global for updates)
  let trendChart, areaChart, pieChart, doughnutChart, barChart, radarChart;

  // Chart initialization
  document.addEventListener('DOMContentLoaded', function() {
    // Trend Chart
    if (document.getElementById('trendChart')) {
      trendChart = new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
          labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
          datasets: [{
            label: 'Stock movements',
            data: [120, 150, 110, 180, 170, 210, 190],
            borderColor: '#4B50A3',
            backgroundColor: 'rgba(75,80,163,0.14)',
            tension: 0.35,
            fill: true,
            pointRadius: 3
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { display: false } },
          scales: {
            y: { beginAtZero: true, ticks: { stepSize: 50 } },
            x: { grid: { display: false } }
          }
        }
      });
    }

    // Area Chart
    if (document.getElementById('areaChart')) {
      areaChart = new Chart(document.getElementById('areaChart'), {
        type: 'line',
        data: {
          labels: ['Jan','Feb','Mar','Apr','May','Jun'],
          datasets: [{
            label: 'Turnover',
            data: [30,45,28,55,40,65],
            borderColor: '#23b07a',
            backgroundColor: 'rgba(35,176,122,0.12)',
            fill: true,
            tension: 0.4
          }]
        },
        options: { 
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { display: false } }, 
          scales: { 
            y: { beginAtZero: true },
            x: { grid: { display: false } }
          } 
        }
      });
    }

    // Bar Chart
    if (document.getElementById('barChart')) {
      barChart = new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
          labels: ['Prod A','Prod B','Prod C','Prod D'],
          datasets: [{
            label: 'Discrepancy',
            data: [5, 12, 8, 3],
            backgroundColor: ['#ff8a8a','#ffd27a','#9ad0ff','#c7b3ff']
          }]
        },
        options: { 
          responsive: true,
          maintainAspectRatio: false,
          plugins: { legend: { display: false } }, 
          scales: { 
            y: { beginAtZero: true },
            x: { grid: { display: false } }
          } 
        }
      });
    }

    // Pie Chart
    if (document.getElementById('pieChart')) {
      pieChart = new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
          labels: ['Beauty & Cosmetics', 'Clothing', 'Accessories', 'Gift Items'],
          datasets: [{
            data: [35, 25, 20, 20],
            backgroundColor: [
              '#FF6384',
              '#36A2EB',
              '#FFCE56',
              '#4BC0C0'
            ],
            borderWidth: 2,
            borderColor: '#fff'
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                padding: 15,
                usePointStyle: true
              }
            }
          }
        }
      });
    }

    // Doughnut Chart
    if (document.getElementById('doughnutChart')) {
      doughnutChart = new Chart(document.getElementById('doughnutChart'), {
        type: 'doughnut',
        data: {
          labels: ['Beauty', 'Clothing', 'Accessories', 'Gifts', 'Other'],
          datasets: [{
            data: [30, 25, 20, 15, 10],
            backgroundColor: [
              '#FF6384',
              '#36A2EB',
              '#FFCE56',
              '#4BC0C0',
              '#9966FF'
            ],
            borderWidth: 2,
            borderColor: '#fff'
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom',
              labels: {
                padding: 15,
                usePointStyle: true
              }
            }
          }
        }
      });
    }

    // Radar Chart
    if (document.getElementById('radarChart')) {
      radarChart = new Chart(document.getElementById('radarChart'), {
        type: 'radar',
        data: {
          labels: ['Timeliness', 'Quality', 'Price', 'Communication', 'Reliability'],
          datasets: [{
            label: 'Supplier A',
            data: [85, 90, 75, 80, 95],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            pointBackgroundColor: 'rgba(54, 162, 235, 1)'
          }, {
            label: 'Supplier B',
            data: [70, 85, 90, 65, 80],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            pointBackgroundColor: 'rgba(255, 99, 132, 1)'
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            r: {
              angleLines: {
                display: true
              },
              suggestedMin: 0,
              suggestedMax: 100
            }
          }
        }
      });
    }
  });
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Employees | Dora's Oshopee</title>
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
    .search-input { 
      max-width: 400px; 
      width: 100%; 
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
    .filter-container {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 8px;
      margin-top: 20px;
      width: 100%;
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
    .status-active {
      color: #155724;
    }
    .status-inactive {
      color: #721c24;
    }
    .status-on-leave {
      color: #856404;
    }
    .role-badge {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 500;
      white-space: nowrap;
    }
    .role-admin {
      color: var(--primary-color);
    }
    .role-cashier {
      color: #1a73e8;
    }
    .role-sales-person {
      color: #23b07a;
    }
    
    .days-badge {
      padding: 2px 8px;
      border-radius: 10px;
      font-size: 0.7rem;
      font-weight: 600;
      margin-top: 3px;
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
    @media (max-width: 1199.98px) {
      .sidebar {
        min-width: 200px;
        max-width: 200px;
      }
      .content-wrap {
        margin-left: 220px;
        padding: 24px;
      }
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
      .status-badge,
      .role-badge {
        padding: 4px 8px;
        font-size: 0.7rem;
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
      .btn-group {
        flex-direction: column;
        width: 100%;
      }
      .btn-group .btn {
        border-radius: 4px !important;
        margin-bottom: 4px;
      }
    }
    @media print {
      .sidebar,
      .topbar .user-section,
      .btn,
      .action-buttons {
        display: none !important;
      }
      .content-wrap {
        margin-left: 0 !important;
        padding: 0 !important;
      }
      .table-card {
        box-shadow: none !important;
        border: 1px solid #dee2e6 !important;
      }
    }
    @media (max-width: 768px) {
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
    }
  </style>
</head>
<body>
@php
    $user = Auth::user() ?? null;
    $employeeName = 'Admin';
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
      <div class="collapse show" id="recordsSubmenu">
        <div class="nav flex-column ms-3">
          <a class="nav-link" href="{{ route('admin.supplier') }}">
            <i class="fas fa-truck"></i>
            <span>Suppliers</span>
          </a>
          <a class="nav-link active" href="{{ route('admin.employees') }}">
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
      <h4 class="mb-1">Employee Management</h4>
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
            <input class="form-control" placeholder="Search employees..." id="searchInput" />
          </div>
          
          <div class="filter-dropdown">
            <button class="filter-toggle" id="filterToggle">
              <i class="fas fa-filter"></i>
              <span>Filter</span>
              <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
            </button>
            
            <div class="filter-menu" id="filterMenu" style="display: none;">
              <div class="filter-section">
                <div class="filter-section-title">Employee Status</div>
                <div class="filter-options">
                  <div class="filter-option">
                    <input type="checkbox" id="status-active" checked>
                    <label for="status-active">Active</label>
                  </div>
                  <div class="filter-option">
                    <input type="checkbox" id="status-inactive" checked>
                    <label for="status-inactive">Inactive</label>
                  </div>
                  <div class="filter-option">
                    <input type="checkbox" id="status-on-leave" checked>
                    <label for="status-on-leave">On Leave</label>
                  </div>
                </div>
              </div>
              
              <div class="filter-section">
                <div class="filter-section-title">Employee Role</div>
                <div class="filter-options">
                  <div class="filter-option">
                    <input type="checkbox" id="role-all" checked>
                    <label for="role-all">All Roles</label>
                  </div>
                  <div class="filter-option">
                    <input type="checkbox" id="role-admin">
                    <label for="role-admin">Administrator</label>
                  </div>
                  <div class="filter-option">
                    <input type="checkbox" id="role-cashier">
                    <label for="role-cashier">Cashier</label>
                  </div>
                  <div class="filter-option">
                    <input type="checkbox" id="role-sales-person">
                    <label for="role-sales-person">Sales Person</label>
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
        
        <div class="active-filters" id="activeFilters">
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

  @if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show mb-4">
      <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(session('info'))
    <div class="alert alert-info alert-dismissible fade show mb-4">
      <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
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
        <h5 class="card-title mb-0">Employee Records</h5>
        <div class="d-flex gap-2">
          @php
            $eligibleForRemoval = $employees->filter(function($employee) {
              return in_array($employee->Role, ['Cashier', 'Sales Person']) && 
                     $employee->EmployeeStatus === 'Inactive' && 
                     $employee->removed_at && 
                     \Carbon\Carbon::now()->diffInDays($employee->removed_at) > 30;
            })->count();
          @endphp
          
          @if($eligibleForRemoval > 0)
            <form action="{{ route('admin.employees.batchRemoveInactive') }}" method="POST">
              @csrf
              <button type="submit" class="btn btn-danger" onclick="return confirm('Remove all {{ $eligibleForRemoval }} eligible inactive employees?')">
                <i class="fas fa-users-slash me-2"></i>Remove Inactive ({{ $eligibleForRemoval }})
              </button>
            </form>
          @endif
          
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
            <i class="fas fa-plus me-2"></i>New Employee
          </button>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Employee ID</th>
              <th>Employee Name</th>
              <th>Contact Number</th>
              <th>Role</th>
              <th>Status</th>
              <th>Date Added</th>
              <th>Removed Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody id="employeesTableBody">
            @forelse($employees as $employee)
              @php
                $daysInactive = $employee->removed_at ? \Carbon\Carbon::now()->diffInDays($employee->removed_at) : 0;
                $shouldBeRemoved = in_array($employee->Role, ['Cashier', 'Sales Person']) && 
                                  $employee->EmployeeStatus === 'Inactive' && 
                                  $employee->removed_at && 
                                  $daysInactive > 30;
              @endphp
              <tr>
                <td>
                  <strong>{{ str_pad($employee->EmployeeID, 3, '0', STR_PAD_LEFT) }}</strong>
                </td>
                <td>
                  <div class="d-flex align-items-center">
                    <div>
                      <div style="font-weight:600">
                        {{ $employee->EmployeeFName }} 
                        {{ $employee->EmployeeMName ? $employee->EmployeeMName . '.' : '' }} 
                        {{ $employee->EmployeeLName }}
                      </div>
                      <small class="text-muted">
                        @if($employee->EmployeeEmail)
                          {{ $employee->EmployeeEmail }}
                        @else
                          No email linked
                        @endif
                      </small>
                    </div>
                  </div>
                </td>
                <td>
                  <div style="font-weight:500">{{ $employee->EmployeeContactNum ?? 'N/A' }}</div>
                </td>
                <td>
                  @if($employee->Role === 'Admin')
                    <span class="role-badge role-admin">Admin</span>
                  @elseif($employee->Role === 'Cashier')
                    <span class="role-badge role-cashier">Cashier</span>
                  @elseif($employee->Role === 'Sales Person')
                    <span class="role-badge role-sales-person">Sales Person</span>
                  @else
                    <span class="role-badge">{{ $employee->Role ?? 'Employee' }}</span>
                  @endif
                </td>
                <td>
                  @if($employee->EmployeeStatus === 'Active')
                    <span class="status-badge status-active">Active</span>
                  @elseif($employee->EmployeeStatus === 'Inactive')
                    <span class="status-badge status-inactive">Inactive</span>
                  @else
                    <span class="status-badge status-on-leave">{{ $employee->EmployeeStatus ?? 'Active' }}</span>
                  @endif
                </td>
                <td>
                  <small class="text-muted">{{ $employee->created_at ? $employee->created_at->format('M d, Y') : 'N/A' }}</small>
                </td>
                <td>
                  @if($employee->removed_at)
                    <small class="text-danger d-block">
                      {{ $employee->removed_at->format('M d, Y') }}
                    </small>
                    @if(in_array($employee->Role, ['Cashier', 'Sales Person']) && $employee->EmployeeStatus === 'Inactive')
                      <span class="badge bg-warning text-dark days-badge">
                        {{ $daysInactive }}/30 days
                        @if($shouldBeRemoved)
                          <i class="fas fa-exclamation-circle ms-1"></i>
                        @endif
                      </span>
                    @endif
                  @else
                    <span class="text-muted">—</span>
                  @endif
                </td>
                <td>
                  <div class="action-buttons">
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewModal{{ $employee->EmployeeID }}" title="View">
                      <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $employee->EmployeeID }}" title="Edit">
                      <i class="fas fa-pencil"></i>
                    </button>
                    
                    @if($shouldBeRemoved)
                      <form action="{{ route('admin.employees.removeInactive', $employee->EmployeeID) }}" method="POST" class="d-inline">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-sm btn-danger" title="Permanently Remove Inactive Employee" onclick="return confirm('Permanently remove this inactive employee?\n\nName: {{ $employee->EmployeeFName }} {{ $employee->EmployeeLName }}\nID: EMP{{ str_pad($employee->EmployeeID, 3, '0', STR_PAD_LEFT) }}\nRole: {{ $employee->Role }}\n\nThis action cannot be undone!')">
                          <i class="fas fa-user-slash"></i>
                        </button>
                      </form>
                    @endif
                    
                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $employee->EmployeeID }}" title="Delete">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center text-muted py-4">
                  <i class="fas fa-users fa-2x mb-3"></i>
                  <p>No employees found.</p>
                  <small>Add your first employee using the "New Employee" button.</small>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
          <i class="fas fa-list me-2"></i>Total: <span id="totalCount">{{ count($employees) }}</span> record{{ count($employees) !== 1 ? 's' : '' }}
        </div>
        @php
          $inactiveEmployees = $employees->whereIn('Role', ['Cashier', 'Sales Person'])->where('EmployeeStatus', 'Inactive');
        @endphp
        @if($inactiveEmployees->count() > 0)
          <div class="text-muted">
            <i class="fas fa-user-slash me-1"></i> Inactive Employees: {{ $inactiveEmployees->count() }}
            @if($eligibleForRemoval > 0)
              <span class="badge bg-danger ms-2">{{ $eligibleForRemoval }} ready for removal</span>
            @endif
          </div>
        @endif
      </div>
    </div>
  </div>
</main>

<div class="modal fade" id="addEmployeeModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('admin.employees.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create New Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <label class="form-label">First Name <span class="text-danger">*</span></label>
              <input type="text" name="EmployeeFName" class="form-control" value="{{ old('EmployeeFName') }}" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label">Last Name <span class="text-danger">*</span></label>
              <input type="text" name="EmployeeLName" class="form-control" value="{{ old('EmployeeLName') }}" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label">Middle Initial</label>
              <input type="text" name="EmployeeMName" class="form-control" maxlength="1" value="{{ old('EmployeeMName') }}">
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label">Contact Number <span class="text-danger">*</span></label>
              <input type="text" name="EmployeeContactNum" class="form-control" value="{{ old('EmployeeContactNum') }}" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label">Role <span class="text-danger">*</span></label>
              <select name="Role" class="form-select" required>
                <option value="Cashier" {{ old('Role') == 'Cashier' ? 'selected' : '' }}>Cashier</option>
                <option value="Admin" {{ old('Role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Sales Person" {{ old('Role') == 'Sales Person' ? 'selected' : '' }}>Sales Person</option>
              </select>
              <small class="text-muted">Note: Inactive cashiers and sales persons will be eligible for removal after 30 days</small>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label">Status <span class="text-danger">*</span></label>
              <select name="EmployeeStatus" class="form-select" required>
                <option value="Active" {{ old('EmployeeStatus') == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ old('EmployeeStatus') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="On Leave" {{ old('EmployeeStatus') == 'On Leave' ? 'selected' : '' }}>On Leave</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create Employee</button>
        </div>
      </div>
    </form>
  </div>
</div>

@foreach($employees as $employee)
<div class="modal fade" id="viewModal{{ $employee->EmployeeID }}" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-user me-2"></i>Employee Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-12 col-md-6"><strong>Employee ID:</strong> {{ str_pad($employee->EmployeeID, 3, '0', STR_PAD_LEFT) }}</div>
          <div class="col-12 col-md-6"><strong>Name:</strong> {{ $employee->EmployeeFName }} {{ $employee->EmployeeMName ? $employee->EmployeeMName . '.' : '' }} {{ $employee->EmployeeLName }}</div>
          <div class="col-12 col-md-6"><strong>Contact:</strong> {{ $employee->EmployeeContactNum ?? '—' }}</div>
          <div class="col-12 col-md-6">
            <strong>Email:</strong> 
            @if($employee->EmployeeEmail)
              {{ $employee->EmployeeEmail }}
            @else
              <span class="text-muted">No email linked</span>
            @endif
          </div>
          <div class="col-12 col-md-6"><strong>Role:</strong> 
            <span class="role-badge {{ $employee->Role === 'Admin' ? 'role-admin' : ($employee->Role === 'Cashier' ? 'role-cashier' : ($employee->Role === 'Sales Person' ? 'role-sales-person' :  '')) }}">{{ $employee->Role }}</span>
          </div>
          <div class="col-12 col-md-6"><strong>Status:</strong> 
            <span class="status-badge {{ $employee->EmployeeStatus === 'Active' ? 'status-active' : ($employee->EmployeeStatus === 'Inactive' ? 'status-inactive' : 'status-on-leave') }}">
              {{ $employee->EmployeeStatus }}
            </span>
          </div>
          <div class="col-12 col-md-6"><strong>Date Added:</strong> {{ $employee->created_at ? $employee->created_at->format('M d, Y H:i') : '—' }}</div>
          <div class="col-12 col-md-6"><strong>Last Updated:</strong> {{ $employee->updated_at ? $employee->updated_at->format('M d, Y H:i') : '—' }}</div>
          @if($employee->removed_at)
            <div class="col-12 col-md-6"><strong>Removed Date:</strong> {{ $employee->removed_at->format('M d, Y H:i') }}</div>
            @if(in_array($employee->Role, ['Cashier', 'Sales Person']) && $employee->EmployeeStatus === 'Inactive')
              <div class="col-12 col-md-6">
                <strong>Days Inactive:</strong> 
                <span class="badge bg-warning text-dark">
                  {{ \Carbon\Carbon::now()->diffInDays($employee->removed_at) }}/30 days
                </span>
              </div>
            @endif
          @endif
          
          @if($employee->EmployeeStatus === 'Inactive')
            <div class="col-12">
              <div class="alert alert-warning mt-3">
                <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Inactive Consequences:</h6>
                <ul class="mb-0">
                  @foreach($employee->getInactiveConsequences() as $consequence)
                    <li>{{ $consequence }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
          @endif
        </div>
      </div>
      <div class="modal-footer">
        @if(in_array($employee->Role, ['Cashier', 'Sales Person']) && $employee->EmployeeStatus === 'Inactive' && $employee->removed_at && \Carbon\Carbon::now()->diffInDays($employee->removed_at) > 30)
          <form action="{{ route('admin.employees.removeInactive', $employee->EmployeeID) }}" method="POST" class="me-auto">
            @csrf
            @method('POST')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Permanently remove this inactive employee?')">
              <i class="fas fa-user-slash me-2"></i>Remove Permanently
            </button>
          </form>
        @endif
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editModal{{ $employee->EmployeeID }}" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form action="{{ route('admin.employees.update', $employee->EmployeeID) }}" method="POST">
      @csrf @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <label class="form-label">First Name <span class="text-danger">*</span></label>
              <input type="text" name="EmployeeFName" class="form-control" value="{{ old('EmployeeFName', $employee->EmployeeFName) }}" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label">Last Name <span class="text-danger">*</span></label>
              <input type="text" name="EmployeeLName" class="form-control" value="{{ old('EmployeeLName', $employee->EmployeeLName) }}" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label">Middle Initial</label>
              <input type="text" name="EmployeeMName" class="form-control" maxlength="1" value="{{ old('EmployeeMName', $employee->EmployeeMName) }}">
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label">Contact Number <span class="text-danger">*</span></label>
              <input type="text" name="EmployeeContactNum" class="form-control" value="{{ old('EmployeeContactNum', $employee->EmployeeContactNum) }}" required>
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label">Role <span class="text-danger">*</span></label>
              <select name="Role" class="form-select" required>
                <option value="Cashier" {{ old('Role', $employee->Role) == 'Cashier' ? 'selected' : '' }}>Cashier</option>
                <option value="Admin" {{ old('Role', $employee->Role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Sales Person" {{ old('Role', $employee->Role) == 'Sales Person' ? 'selected' : '' }}>Sales Person</option>
              </select>
              @if(in_array($employee->Role, ['Cashier', 'Sales Person']) && $employee->EmployeeStatus === 'Inactive')
                <small class="text-danger">
                  <i class="fas fa-exclamation-triangle me-1"></i> This employee has been inactive since {{ $employee->removed_at ? $employee->removed_at->format('M d, Y') : 'N/A' }}
                </small>
              @endif
            </div>
            <div class="col-12 col-md-6">
              <label class="form-label">Status <span class="text-danger">*</span></label>
              <select name="EmployeeStatus" class="form-select" required>
                <option value="Active" {{ old('EmployeeStatus', $employee->EmployeeStatus) == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ old('EmployeeStatus', $employee->EmployeeStatus) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="On Leave" {{ old('EmployeeStatus', $employee->EmployeeStatus) == 'On Leave' ? 'selected' : '' }}>On Leave</option>
              </select>
              @if(in_array($employee->Role, ['Cashier', 'Sales Person']))
                <small class="text-muted">Inactive employees will be marked for removal after 30 days</small>
              @endif
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Employee</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="deleteModal{{ $employee->EmployeeID }}" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('admin.employees.destroy', $employee->EmployeeID) }}" method="POST">
      @csrf @method('DELETE')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-danger"><i class="fas fa-trash me-2"></i>Delete Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to <strong>permanently delete</strong> this employee?</p>
          <div class="alert alert-danger">
            <strong>{{ $employee->EmployeeFName }} {{ $employee->EmployeeLName }}</strong><br>
            <small>EMP{{ str_pad($employee->EmployeeID, 3, '0', STR_PAD_LEFT) }}</small>
            @if(in_array($employee->Role, ['Cashier', 'Sales Person']) && $employee->EmployeeStatus === 'Inactive' && $employee->removed_at)
              <br><small class="text-warning">Inactive for {{ \Carbon\Carbon::now()->diffInDays($employee->removed_at) }} days</small>
            @endif
          </div>
          <p class="text-danger"><strong>This action cannot be undone.</strong></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Yes, Delete Permanently</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
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

  const filterToggle = document.getElementById('filterToggle');
  const filterMenu = document.getElementById('filterMenu');
  const activeFilters = document.getElementById('activeFilters');
  const searchInput = document.getElementById('searchInput');
  const employeesTableBody = document.getElementById('employeesTableBody');
  const totalCount = document.getElementById('totalCount');
  
  const userDropdownToggle = document.getElementById('userDropdownToggle');
  const userDropdownMenu = document.getElementById('userDropdownMenu');
  
  let currentFilters = {
    status: ['Active', 'Inactive', 'On Leave'],
    roles: ['All Roles'],
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
  
  searchInput.addEventListener('input', function() {
    currentFilters.search = this.value.toLowerCase();
    filterEmployees();
  });
  
  document.getElementById('applyFilters').addEventListener('click', function() {
    filterMenu.style.display = 'none';
    filterToggle.classList.remove('active');
    updateCurrentFilters();
    updateActiveFilters();
    filterEmployees();
  });
  
  document.getElementById('clearFilters').addEventListener('click', function() {
    document.querySelectorAll('.filter-option input[type="checkbox"]').forEach(checkbox => {
      checkbox.checked = false;
    });
    
    document.getElementById('status-active').checked = true;
    document.getElementById('status-inactive').checked = true;
    document.getElementById('status-on-leave').checked = true;
    document.getElementById('role-all').checked = true;
    
    searchInput.value = '';
    
    currentFilters = {
      status: ['Active', 'Inactive', 'On Leave'],
      roles: ['All Roles'],
      search: ''
    };
    
    updateActiveFilters();
    filterEmployees();
  });
  
  function updateCurrentFilters() {
    currentFilters.status = [];
    if (document.getElementById('status-active').checked) {
      currentFilters.status.push('Active');
    }
    if (document.getElementById('status-inactive').checked) {
      currentFilters.status.push('Inactive');
    }
    if (document.getElementById('status-on-leave').checked) {
      currentFilters.status.push('On Leave');
    }
    
    currentFilters.roles = [];
    if (document.getElementById('role-all').checked) {
      currentFilters.roles.push('All Roles');
    } else {
      if (document.getElementById('role-admin').checked) {
        currentFilters.roles.push('Admin');
      }
      if (document.getElementById('role-cashier').checked) {
        currentFilters.roles.push('Cashier');
      }
      if (document.getElementById('role-sales-person').checked) {
        currentFilters.roles.push('Sales Person');
      }
      
    }
  }
  
  function updateActiveFilters() {
    activeFilters.innerHTML = '';
    
    const hasCustomFilters = 
      currentFilters.status.length < 3 ||
      currentFilters.roles.length !== 1 || 
      currentFilters.roles[0] !== 'All Roles' ||
      currentFilters.search !== '';
    
    if (!hasCustomFilters) {
      activeFilters.classList.remove('has-filters');
      return;
    }
    
    activeFilters.classList.add('has-filters');
    
    if (currentFilters.status.length < 3) {
      currentFilters.status.forEach(status => {
        const statusTag = createFilterTag(`Status: ${status}`, `status-${status.toLowerCase().replace(' ', '-')}`);
        activeFilters.appendChild(statusTag);
      });
    }
    
    if (currentFilters.roles.length > 0 && 
        (currentFilters.roles.length > 1 || currentFilters.roles[0] !== 'All Roles')) {
      currentFilters.roles.forEach(role => {
        const roleTag = createFilterTag(`Role: ${role}`, `role-${role.toLowerCase().replace(' ', '-')}`);
        activeFilters.appendChild(roleTag);
      });
    }
    
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
    if (filterType.startsWith('status-')) {
      const filterName = filterType.replace('status-', '').replace('-', ' ');
      const index = currentFilters.status.indexOf(
        filterName.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
      );
      if (index > -1) {
        currentFilters.status.splice(index, 1);
      }
    } else if (filterType.startsWith('role-')) {
      const filterName = filterType.replace('role-', '').replace('-', ' ');
      const index = currentFilters.roles.indexOf(
        filterName.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
      );
      if (index > -1) {
        currentFilters.roles.splice(index, 1);
      }
    } else if (filterType === 'search') {
      currentFilters.search = '';
      searchInput.value = '';
    }
    
    updateFilterInputs();
    updateActiveFilters();
    filterEmployees();
  }
  
  function updateFilterInputs() {
    document.getElementById('status-active').checked = currentFilters.status.includes('Active');
    document.getElementById('status-inactive').checked = currentFilters.status.includes('Inactive');
    document.getElementById('status-on-leave').checked = currentFilters.status.includes('On Leave');
    
    document.getElementById('role-all').checked = currentFilters.roles.includes('All Roles');
    document.getElementById('role-admin').checked = currentFilters.roles.includes('Admin');
    document.getElementById('role-cashier').checked = currentFilters.roles.includes('Cashier');
    document.getElementById('role-sales-person').checked = currentFilters.roles.includes('Sales Person');
  }
  
  function filterEmployees() {
    const rows = employeesTableBody.getElementsByTagName('tr');
    let visibleCount = 0;
    
    for (let row of rows) {
      if (row.style.display === 'none') continue;
      
      const name = row.cells[1].textContent.toLowerCase();
      const role = row.cells[3].textContent.trim();
      const status = row.cells[4].textContent.trim();
      
      const searchMatch = currentFilters.search === '' || name.includes(currentFilters.search);
      
      const roleMatch = currentFilters.roles.includes('All Roles') || currentFilters.roles.includes(role);
      
      const statusMatch = currentFilters.status.includes(status);
      
      if (searchMatch && roleMatch && statusMatch) {
        row.style.display = '';
        visibleCount++;
      } else {
        row.style.display = 'none';
      }
    }
    
    totalCount.textContent = visibleCount;
  }
  
  document.addEventListener('DOMContentLoaded', function() {
    filterEmployees();
  });

  window.addEventListener('resize', function() {
    if (window.innerWidth >= 992) {
      sidebar.classList.remove('mobile-open');
      sidebarOverlay.classList.remove('active');
      document.body.style.overflow = '';
    }
  });

  document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    }, 5000);
  });

  document.addEventListener('DOMContentLoaded', function() {
    const rows = employeesTableBody.getElementsByTagName('tr');
    for (let row of rows) {
      const removeButton = row.querySelector('.btn-danger');
      if (removeButton) {
        row.classList.add('table-warning');
      }
    }
  });
</script>
</body>
</html>
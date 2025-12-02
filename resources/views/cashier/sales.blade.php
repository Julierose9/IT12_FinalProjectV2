<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sales Management | Dora's Oshoppe</title>

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

    /* Sidebar */
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
    .nav.flex-column.ms-3 .nav-link { padding: 10px 12px; font-size: 0.9rem; border-radius: 6px; }

    /* Mobile */
    .sidebar-toggle { display: none; position: fixed; top: 15px; left: 15px; z-index: 1001;
      background: var(--primary-color); color: white; border: none; border-radius: 8px;
      width: 40px; height: 40px; font-size: 1.2rem; }
    .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0,0,0,0.5); z-index: 999; }
    .sidebar-overlay.active { display: block; }

    /* Content */
    .content-wrap { margin-left: 240px; padding: 28px; transition: all 0.3s ease; }
    .topbar { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 22px; }
    .page-title-section h4 { margin-bottom: 4px; }
    .user-section { display: flex; flex-direction: column; align-items: flex-end; gap: 16px; min-width: 300px; }
    .user-avatar { width: 44px; height: 44px; border-radius: 10px; object-fit: cover; }
    .user-dropdown-toggle { background: none; border: none; display: flex; align-items: center; gap: 12px;
      cursor: pointer; padding: 8px; border-radius: 8px; }
    .user-dropdown-toggle:hover { background: #f8f9fa; }
    .user-dropdown-menu { position: absolute; top: 100%; right: 0; background: white;
      border: 1px solid #dee2e6; border-radius: 8px; padding: 8px 0; min-width: 150px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-top: 8px; display: none; z-index: 1000; }
    .user-dropdown-menu.show { display: block; }
    .user-dropdown-item { padding: 8px 16px; display: flex; align-items: center; gap: 8px;
      color: #5b5f72; background: none; border: none; width: 100%; text-align: left; cursor: pointer; }
    .user-dropdown-item:hover { background: #f8f9fa; color: var(--primary-color); }

    /* Search & Filter */
    .filter-container { display: flex; flex-direction: column; align-items: flex-end; gap: 8px; width: 100%; }
    .search-filter-section { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
    .search-input { max-width: 400px; width: 100%; min-width: 250px; }
    .filter-toggle { background: #fff; border: 1px solid #dee2e6; border-radius: 8px;
      padding: 10px 12px; display: flex; align-items: center; gap: 6px; cursor: pointer; }
    .filter-toggle.active { background: var(--primary-color); color: white; border-color: var(--primary-color); }
    .filter-menu { position: absolute; top: 100%; right: 0; background: white; border: 1px solid #dee2e6;
      border-radius: 8px; padding: 16px; min-width: 240px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      margin-top: 8px; display: none; z-index: 1000; }
    .filter-menu.show { display: block; }
    .active-filters { display: none; gap: 8px; flex-wrap: wrap; }
    .active-filters.has-filters { display: flex; }
    .filter-tag { background: #e9ecef; border: 1px solid #dee2e6; border-radius: 16px;
      padding: 4px 12px; font-size: 0.8rem; display: flex; align-items: center; gap: 6px; }
    .filter-tag-remove { background: none; border: none; cursor: pointer; color: var(--secondary-color); }

    /* Table */
    .table-card { border-radius: 12px; border: none; box-shadow: var(--card-shadow); overflow: hidden; }
    .table th { font-weight: 600; color: #5b5f72; font-size: 0.85rem; text-transform: uppercase;
      letter-spacing: 0.5px; padding: 12px 16px; white-space: nowrap; }
    .table td { padding: 16px; vertical-align: middle; border-color: #f1f3f4; }
    
    /* Status Badges */
    .status-badge { padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 500; }
    .status-paid {  color: var(--success-color); }
    .status-pending { color: var(--warning-color); }
    .status-unpaid {  color: var(--danger-color); }
    
    /* Payment method badges */
    .method-badge { padding: 4px 10px; border-radius: 12px; font-size: 0.7rem; font-weight: 500; }
    .method-cash { color: var(--success-color); }
    .method-gcash {  color: #0284c7; }
    .method-card {  color: var(--primary-color); }

    /* Stats Cards */
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
    .nav-tabs { border-bottom: 2px solid #eef2f7; margin-bottom: 24px; }
    .nav-tabs .nav-link { 
      color: #5b5f72; border: none; padding: 12px 20px; font-weight: 500; 
      border-radius: 8px 8px 0 0; margin-right: 4px; transition: all 0.2s;
    }
    .nav-tabs .nav-link:hover { background: #f8f9fa; color: var(--primary-color); }
    .nav-tabs .nav-link.active { 
      color: var(--primary-color); background-color: #fff; 
      border-bottom: 2px solid var(--primary-color);
    }

    /* Quick Action Cards */
    .quick-actions {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 16px;
      margin-bottom: 30px;
    }
    
    .action-card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      text-align: center;
      box-shadow: var(--card-shadow);
      transition: all 0.3s ease;
      cursor: pointer;
      border: 2px solid transparent;
    }
    
    .action-card:hover {
      transform: translateY(-4px);
      border-color: var(--primary-color);
      box-shadow: 0 4px 12px rgba(59, 49, 131, 0.1);
    }
    
    .action-icon {
      width: 50px;
      height: 50px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 12px;
      font-size: 1.5rem;
    }
    
    .action-card.primary .action-icon {
      background: #efeaff;
      color: var(--primary-color);
    }
    
    .action-card.success .action-icon {
      background: #e8f5e8;
      color: var(--success-color);
    }
    
    .action-card.warning .action-icon {
      background: #fff3cd;
      color: var(--warning-color);
    }
    
    .action-card.danger .action-icon {
      background: #fde8e8;
      color: var(--danger-color);
    }
    
    .action-title {
      font-weight: 600;
      font-size: 0.95rem;
      margin-bottom: 4px;
      color: var(--primary-color);
    }
    
    .action-desc {
      font-size: 0.8rem;
      color: var(--secondary-color);
    }

    /* Modal */
    .modal-lg .modal-content { border-radius: 12px; border: none; }
    .modal-header { border-bottom: 1px solid #eef2f7; padding: 20px 24px; }
    .modal-body { padding: 24px; }
    .modal-footer { border-top: 1px solid #eef2f7; padding: 20px 24px; }

    /* Responsive */
    @media (max-width: 991.98px) {
      .sidebar { transform: translateX(-100%); width: 280px; box-shadow: 2px 0 10px rgba(0,0,0,0.1); }
      .sidebar.mobile-open { transform: translateX(0); }
      .sidebar-toggle, .sidebar-overlay { display: block; }
      .content-wrap { margin-left: 0; padding: 70px 16px 16px; }
      .topbar { flex-direction: column; align-items: stretch; }
      .user-section, .filter-container { align-items: stretch; min-width: 100%; }
      .search-input { min-width: 100%; }
      .stats-grid { grid-template-columns: 1fr; }
      .quick-actions { grid-template-columns: repeat(2, 1fr); }
    }
    
    @media (max-width: 575.98px) {
      .content-wrap { padding: 70px 8px 8px; }
      .table th, .table td { padding: 10px 6px; font-size: 0.85rem; }
      .action-buttons { flex-direction: column; }
      .stat-card { padding: 16px; }
      .stat-value { font-size: 1.5rem; }
      .quick-actions { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>
@php
    // Create empty collections if variables don't exist
    $orders = $orders ?? collect([]);
    $payments = $payments ?? collect([]);
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

<!-- Main Content -->
<main class="content-wrap" id="contentWrap">
  <div class="topbar">
    <div class="page-title-section">
      <h4 class="mb-1">Sales Management</h4>
      <small class="text-muted">Manage orders and payments</small>
    </div>
    <div class="user-section">
      <div class="user-dropdown">
        <button class="user-dropdown-toggle" id="userDropdownToggle">
          <img src="{{ asset('images/logo_.png') }}" alt="avatar" class="user-avatar">
          <div class="user-details">
            <div class="user-name">Cashier</div>
            <div class="user-role">Cashier</div>
          </div>
          <i class="fas fa-chevron-down" style="font-size: 0.8rem;"></i>
        </button>
        <div class="user-dropdown-menu" id="userDropdownMenu">
          <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="user-dropdown-item"><i class="fas fa-sign-out-alt me-2"></i> Sign Out</button>
          </form>
        </div>
      </div>

      <div class="filter-container">
        <div class="search-filter-section">
          <div class="input-group search-input">
            <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
            <input type="text" class="form-control" placeholder="Search orders, customers..." id="searchInput" value="{{ request('search') ?? '' }}">
          </div>
          <div class="filter-dropdown">
            <button class="filter-toggle" id="filterToggle"><i class="fas fa-filter"></i> Filter <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i></button>
            <div class="filter-menu" id="filterMenu">
              <!-- Time Period Filter -->
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
                    <input type="radio" name="timePeriod" id="period-custom" {{ request('period') == 'custom' ? 'checked' : '' }}>
                    <label for="period-custom">Custom Range</label>
                  </div>
                </div>
                <div class="date-inputs" id="customDateRange" style="display: {{ request('period') == 'custom' ? 'flex' : 'none' }};">
                  <div class="date-input">
                    <input type="date" id="dateFrom" placeholder="From Date" value="{{ request('date_from') ?? '' }}">
                  </div>
                  <div class="date-input">
                    <input type="date" id="dateTo" placeholder="To Date" value="{{ request('date_to') ?? '' }}">
                  </div>
                </div>
              </div>
              
              <!-- Payment Status Filters -->
              <div class="filter-section">
                <div class="filter-section-title">Payment Status</div>
                <div class="filter-options">
                  <div class="filter-option">
                    <input type="checkbox" id="status-all" {{ empty(request('status')) || in_array('all', request('status', [])) ? 'checked' : '' }}>
                    <label for="status-all">All Statuses</label>
                  </div>
                  <div class="filter-option">
                    <input type="checkbox" id="status-paid" {{ in_array('paid', request('status', [])) ? 'checked' : '' }}>
                    <label for="status-paid">Paid</label>
                  </div>
                  <div class="filter-option">
                    <input type="checkbox" id="status-pending" {{ in_array('pending', request('status', [])) ? 'checked' : '' }}>
                    <label for="status-pending">Pending</label>
                  </div>
                  <div class="filter-option">
                    <input type="checkbox" id="status-unpaid" {{ in_array('unpaid', request('status', [])) ? 'checked' : '' }}>
                    <label for="status-unpaid">Unpaid</label>
                  </div>
                </div>
              </div>
              
              <div class="filter-actions">
                <button class="btn-apply" id="applyFilters">Apply</button>
                <button class="btn-clear" id="clearFilters">Reset</button>
              </div>
            </div>
          </div>
        </div>
        <div class="active-filters" id="activeFilters"></div>
      </div>
    </div>
  </div>



  {{-- Tabs Navigation --}}
  <ul class="nav nav-tabs" id="salesTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab">
        <i></i>Orders
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button" role="tab">
        <i ></i>Payments
      </button>
    </li>
  </ul>

  {{-- Tab Content --}}
  <div class="tab-content" id="salesTabContent">

    {{-- Orders Tab --}}
    <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
      <div class="card table-card">
        <div class="card-body">
          <h5 class="card-title mb-4">Order Records</h5>

          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ORDER ID</th>
                  <th>CUSTOMER</th>
                  <th>DATE</th>
                  <th>ITEMS</th>
                  <th>TOTAL AMOUNT</th>
                  <th>PAYMENT STATUS</th>
                  <th>ACTIONS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><strong>ORD001</strong></td>
                  <td>
                    <div style="font-weight:600">Maria Santos</div>
                    <small class="text-muted">09123456789</small>
                  </td>
                  <td>Nov 25, 2025 04:45 PM</td>
                  <td>
                    <div style="font-weight:600">3 item(s)</div>
                    <small class="text-muted">PRO-001, PRO-003</small>
                  </td>
                  <td><strong class="text-success">₱1,250.75</strong></td>
                  <td>
                    <span class="status-badge status-paid">Paid</span>
                  </td>
                  <td>
                    <div class="btn-group btn-group-sm">
                      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewOrderModal">
                        <i class="fas fa-eye"></i>
                      </button>
                      <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#recordPaymentModal">
                        <i class="fas fa-credit-card"></i>
                      </button>
                      <button class="btn btn-outline-danger">
                        <i class="fas fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
                
                <tr>
                  <td><strong>ORD002</strong></td>
                  <td>
                    <div style="font-weight:600">Juan Dela Cruz</div>
                    <small class="text-muted">09187654321</small>
                  </td>
                  <td>Nov 26, 2025 04:45 PM</td>
                  <td>
                    <div style="font-weight:600">2 item(s)</div>
                    <small class="text-muted">PRO-002</small>
                  </td>
                  <td><strong class="text-success">₱560.25</strong></td>
                  <td>
                    <span class="status-badge status-pending">Pending</span>
                  </td>
                  <td>
                    <div class="btn-group btn-group-sm">
                      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewOrderModal">
                        <i class="fas fa-eye"></i>
                      </button>
                      <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#recordPaymentModal">
                        <i class="fas fa-credit-card"></i>
                      </button>
                      <button class="btn btn-outline-danger">
                        <i class="fas fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
                
                
              </tbody>
            </table>
          </div>

          <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
              Showing 3 of 12 orders
            </div>
            <nav aria-label="Page navigation">
              <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>

    {{-- Payments Tab --}}
    <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
      <div class="card table-card">
        <div class="card-body">
          <h5 class="card-title mb-4">Payment Records</h5>

          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>PAYMENT ID</th>
                  <th>ORDER</th>
                  <th>CUSTOMER</th>
                  <th>AMOUNT</th>
                  <th>METHOD</th>
                  <th>STATUS</th>
                  <th>DATE</th>
                  <th>ACTIONS</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><strong>PAY001</strong></td>
                  <td><a href="#" class="text-decoration-none">ORD001</a></td>
                  <td><div style="font-weight:600">Maria Santos</div></td>
                  <td><strong class="text-success">₱1,250.75</strong></td>
                  <td><span class="method-badge method-cash">Cash</span></td>
                  <td><span class="status-badge status-paid">Paid</span></td>
                  <td>Nov 25, 2025 04:45 PM</td>
                  <td>
                    <div class="btn-group btn-group-sm">
                      <button class="btn btn-outline-primary">
                        <i class="fas fa-receipt"></i>
                      </button>
                      <button class="btn btn-outline-danger">
                        <i class="fas fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
                
                <tr>
                  <td><strong>PAY002</strong></td>
                  <td><a href="#" class="text-decoration-none">ORD002</a></td>
                  <td><div style="font-weight:600">Ana Reyes</div></td>
                  <td><strong class="text-success">₱1,600.00</strong></td>
                  <td><span class="method-badge method-gcash">GCash</span></td>
                  <td><span class="status-badge status-paid">Paid</span></td>
                  <td>Nov 27, 2025 10:45 AM</td>
                  <td>
                    <div class="btn-group btn-group-sm">
                      <button class="btn btn-outline-primary">
                        <i class="fas fa-receipt"></i>
                      </button>
                      <button class="btn btn-outline-danger">
                        <i class="fas fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
              Showing 2 payments
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

{{-- Create Order Modal --}}
<div class="modal fade" id="createOrderModal" tabindex="-1" aria-labelledby="createOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createOrderModalLabel">Create New Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form>
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Customer *</label>
                <select class="form-select" required>
                  <option value="">Select Customer</option>
                  <option value="CUST-001">Maria Santos (09123456789)</option>
                  <option value="CUST-002">Juan Dela Cruz (09187654321)</option>
                  <option value="CUST-003">Ana Reyes (09151234567)</option>
                  <option value="walk-in">Walk-in Customer</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Order Date *</label>
                <input type="datetime-local" class="form-control" value="{{ date('Y-m-d\TH:i') }}" required>
              </div>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label">Products *</label>
            <div class="product-items">
              <div class="product-item row g-2 mb-3">
                <div class="col-md-6">
                  <select class="form-select" required>
                    <option value="">Select Product</option>
                    <option value="PRO-001">Rosey Makeup Kit - ₱899.75</option>
                    <option value="PRO-002">Velvet Dress - ₱560.25</option>
                    <option value="PRO-003">Gift Ribbon - ₱175.50</option>
                    <option value="PRO-004">Scented Candle Set - ₱450.00</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <input type="number" class="form-control" placeholder="Qty" min="1" value="1" required>
                </div>
                <div class="col-md-2">
                  <input type="text" class="form-control" value="₱899.75" readonly>
                </div>
                <div class="col-md-1">
                  <button type="button" class="btn btn-outline-danger btn-sm" disabled>
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </div>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="addProductBtn">
              <i class="fas fa-plus me-1"></i>Add Product
            </button>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Payment Method *</label>
                <select class="form-select" required>
                  <option value="Cash">Cash</option>
                  <option value="GCash">GCash</option>
                  <option value="Credit Card">Credit Card</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Amount Tendered *</label>
                <input type="number" class="form-control" step="0.01" min="0" required>
              </div>
            </div>
          </div>

          <div class="alert alert-info">
            <div class="d-flex justify-content-between">
              <span>Subtotal:</span>
              <strong>₱899.75</strong>
            </div>
            <div class="d-flex justify-content-between mt-1">
              <span>Tax (12%):</span>
              <strong>₱107.97</strong>
            </div>
            <div class="d-flex justify-content-between mt-1">
              <span>Total Amount:</span>
              <strong class="text-success">₱1,007.72</strong>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create Order</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Record Payment Modal --}}
<div class="modal fade" id="recordPaymentModal" tabindex="-1" aria-labelledby="recordPaymentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="recordPaymentModalLabel">Record Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Order *</label>
            <select class="form-select" required>
              <option value="">Select Order</option>
              <option value="ORD-001">ORD001 - Maria Santos (₱1,250.75)</option>
              <option value="ORD-002">ORD002 - Juan Dela Cruz (₱560.25)</option>
            </select>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Payment Method *</label>
                <select class="form-select" required>
                  <option value="Cash">Cash</option>
                  <option value="GCash">GCash</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Status *</label>
                <select class="form-select" required>
                  <option value="Paid">Paid</option>
                  <option value="Pending">Pending</option>
                </select>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Amount *</label>
            <input type="number" class="form-control" step="0.01" min="0.01" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Notes (Optional)</label>
            <textarea class="form-control" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Record Payment</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- View Order Modal --}}
<div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewOrderModalLabel">Order Details - ORD001</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-4">
          <div class="col-md-6">
            <h6>Customer Information</h6>
            <p class="mb-1"><strong>Name:</strong> Maria Santos</p>
            <p class="mb-1"><strong>Phone:</strong> 09123456789</p>
            <p class="mb-0"><strong>Email:</strong> maria.santos@email.com</p>
          </div>
          <div class="col-md-6">
            <h6>Order Information</h6>
            <p class="mb-1"><strong>Order Date:</strong> Nov 25, 2025 04:45 PM</p>
            <p class="mb-1"><strong>Status:</strong> <span class="status-badge status-paid">Paid</span></p>
            <p class="mb-0"><strong>Payment Method:</strong> <span class="method-badge method-cash">Cash</span></p>
          </div>
        </div>

        <h6>Order Items</h6>
        <div class="table-responsive">
          <table class="table table-sm">
            <thead>
              <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Rosey Makeup Kit (PRO-001)</td>
                <td>₱899.75</td>
                <td>1</td>
                <td>₱899.75</td>
              </tr>
              <tr>
                <td>Gift Ribbon (PRO-003)</td>
                <td>₱175.50</td>
                <td>2</td>
                <td>₱351.00</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="row mt-4">
          <div class="col-md-6 offset-md-6">
            <div class="d-flex justify-content-between mb-1">
              <span>Subtotal:</span>
              <strong>₱1,250.75</strong>
            </div>
            <div class="d-flex justify-content-between mb-1">
              <span>Tax (12%):</span>
              <strong>₱150.09</strong>
            </div>
            <div class="d-flex justify-content-between mt-2 pt-2 border-top">
              <span class="h6">Total Amount:</span>
              <strong class="h5 text-success">₱1,400.84</strong>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle for mobile
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
    
    // User dropdown
    const userDropdownToggle = document.getElementById('userDropdownToggle');
    const userDropdownMenu = document.getElementById('userDropdownMenu');
    
    if (userDropdownToggle) {
        userDropdownToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdownMenu.classList.toggle('show');
        });
        
        document.addEventListener('click', function() {
            userDropdownMenu.classList.remove('show');
        });
    }
    
    // Filter toggle
    const filterToggle = document.getElementById('filterToggle');
    const filterMenu = document.getElementById('filterMenu');
    const customDateRange = document.getElementById('customDateRange');
    
    if (filterToggle) {
        filterToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            filterMenu.classList.toggle('show');
            filterToggle.classList.toggle('active');
        });
        
        document.addEventListener('click', function() {
            filterMenu.classList.remove('show');
            filterToggle.classList.remove('active');
        });
    }
    
    // Show/hide custom date range
    document.querySelectorAll('input[name="timePeriod"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.id === 'period-custom') {
                customDateRange.style.display = 'flex';
            } else {
                customDateRange.style.display = 'none';
            }
        });
    });
    
    // Add product functionality
    let productCount = 1;
    const addProductBtn = document.getElementById('addProductBtn');
    const productItems = document.querySelector('.product-items');
    
    if (addProductBtn) {
        addProductBtn.addEventListener('click', function() {
            const newItem = document.createElement('div');
            newItem.className = 'product-item row g-2 mb-3';
            newItem.innerHTML = `
                <div class="col-md-6">
                    <select class="form-select" required>
                        <option value="">Select Product</option>
                        <option value="PRO-001">Rosey Makeup Kit - ₱899.75</option>
                        <option value="PRO-002">Velvet Dress - ₱560.25</option>
                        <option value="PRO-003">Gift Ribbon - ₱175.50</option>
                        <option value="PRO-004">Scented Candle Set - ₱450.00</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control" placeholder="Qty" min="1" value="1" required>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" value="₱0.00" readonly>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-product">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            productItems.appendChild(newItem);
            
            // Add event listener to new remove button
            newItem.querySelector('.remove-product').addEventListener('click', function() {
                this.closest('.product-item').remove();
            });
        });
    }
    
    // Remove product buttons
    document.querySelectorAll('.remove-product').forEach(button => {
        if (button.disabled) return;
        button.addEventListener('click', function() {
            this.closest('.product-item').remove();
        });
    });
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                // Perform search
                console.log('Searching for:', this.value);
            }
        });
    }
});
</script>
</body>
</html>
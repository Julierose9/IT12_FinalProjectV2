<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cashier Dashboard | Dora's Oshoppe</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    .sidebar-toggle { display: none; position: fixed; top: 15px; left: 15px; z-index: 1001;
      background: var(--primary-color); color: white; border: none; border-radius: 8px;
      width: 40px; height: 40px; font-size: 1.2rem; }
    .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0,0,0,0.5); z-index: 999; }
    .sidebar-overlay.active { display: block; }
    .content-wrap { margin-left: 240px; padding: 28px; transition: all 0.3s ease; }
    .topbar { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 16px; margin-bottom: 22px; }
    .page-title-section h4 { margin-bottom: 4px; }
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
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 12px;
        margin-bottom: 30px;
    }
    .action-card {
        background: white;
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        cursor: pointer;
        border: 1px solid transparent;
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .action-card:hover {
        transform: translateY(-2px);
        border-color: var(--primary-color);
        box-shadow: 0 4px 12px rgba(59, 49, 131, 0.1);
        color: inherit;
    }
    .action-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
        font-size: 1.2rem;
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
    .action-title {
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 2px;
        color: var(--primary-color);
    }
    .action-desc {
        font-size: 0.75rem;
        color: var(--secondary-color);
        line-height: 1.2;
    }
    .chart-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: var(--card-shadow);
        margin-bottom: 24px;
        height: 350px;
    }
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .chart-title {
        font-weight: 600;
        font-size: 1rem;
        color: var(--primary-color);
        margin: 0;
    }
    .mini-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 30px;
    }
    .mini-stat-card {
        background: white;
        border-radius: 10px;
        padding: 16px;
        box-shadow: var(--card-shadow);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .mini-stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .mini-stat-icon.primary {
        background: #efeaff;
        color: var(--primary-color);
    }
    .mini-stat-icon.success {
        background: #e8f5e8;
        color: var(--success-color);
    }
    .mini-stat-icon.warning {
        background: #fff3cd;
        color: var(--warning-color);
    }
    .mini-stat-info {
        flex: 1;
    }
    .mini-stat-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
        line-height: 1.2;
    }
    .mini-stat-label {
        font-size: 0.75rem;
        color: var(--secondary-color);
        line-height: 1.2;
    }
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
    .search-filter-section {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        flex-wrap: nowrap;
    }
    .search-input {
        flex: 1;
        min-width: 200px;
    }
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
    .user-section .filter-container {
        width: 100%;
    }
    @media (max-width: 991.98px) {
      .sidebar { transform: translateX(-100%); width: 280px; box-shadow: 2px 0 10px rgba(0,0,0,0.1); }
      .sidebar.mobile-open { transform: translateX(0); }
      .sidebar-toggle, .sidebar-overlay { display: block; }
      .content-wrap { margin-left: 0; padding: 70px 16px 16px; }
      .topbar { flex-direction: column; align-items: stretch; }
      .user-section, .filter-container { align-items: stretch; min-width: 100%; }
      .chart-card { height: 300px; }
      .quick-actions { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 575.98px) {
      .content-wrap { padding: 70px 8px 8px; }
      .quick-actions { grid-template-columns: 1fr; }
      .mini-stats { grid-template-columns: 1fr; }
      .chart-card { height: 250px; padding: 12px; }
    }
  </style>
</head>
<body>
@php
    $today = \Carbon\Carbon::today();
    $todaySales = $todaySales ?? ['total_sales' => 0, 'total_orders' => 0, 'total_items' => 0, 'average_order_value' => 0];
    $weeklyStats = $weeklyStats ?? ['total_sales' => 0, 'growth' => 0];
    $monthlyStats = $monthlyStats ?? ['total_sales' => 0, 'growth' => 0];
    $recentOrders = $recentOrders ?? collect([]);
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
<button class="sidebar-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button>
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
            <a class="nav-link active" href="{{ route('cashier.dashboard') }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#salesSubmenu">
                <i class="fas fa-cash-register"></i>
                <span>Transactions</span>
            </a>
            <div class="collapse" id="salesSubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link" href="{{ route('cashier.sales') }}">
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
<main class="content-wrap" id="contentWrap">
    <div class="topbar">
        <div class="page-title-section">
            <h4 class="mb-1">Cashier Dashboard</h4>
            <small class="text-muted">Welcome back, {{ $employeeName }}</small>
        </div>
        <div class="user-section">
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
            <div class="filter-container">
                <div class="search-filter-section">
                    <div class="input-group search-input">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search transactions..." id="searchInput">
                    </div>
                    <div class="date-picker-container">
                        <div class="input-group">
                            <input type="date" class="form-control" id="dateFilter" value="{{ $today->format('Y-m-d') }}">
                            <button class="btn btn-outline-primary" type="button" id="applyDateFilter">
                                <i class="fas fa-calendar-check"></i>
                            </button>
                        </div>
                    </div>
                    <div class="filter-dropdown">
                        <button class="filter-toggle" id="filterToggle">
                            <i class="fas fa-filter"></i>
                            <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
                        </button>
                        <div class="filter-menu" id="filterMenu" style="display: none;">
                            <div class="filter-section">
                                <div class="filter-section-title">Dashboard View</div>
                                <div class="filter-options">
                                    <div class="filter-option">
                                        <input type="radio" name="dashboardView" id="view-today" checked>
                                        <label for="view-today">Today's Overview</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="radio" name="dashboardView" id="view-week">
                                        <label for="view-week">Weekly Overview</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="radio" name="dashboardView" id="view-month">
                                        <label for="view-month">Monthly Overview</label>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-section">
                                <div class="filter-section-title">Chart Display</div>
                                <div class="filter-options">
                                    <div class="filter-option">
                                        <input type="checkbox" id="chart-sales" checked>
                                        <label for="chart-sales">Sales Chart</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="chart-products" checked>
                                        <label for="chart-products">Products Chart</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="chart-trend" checked>
                                        <label for="chart-trend">Trend Chart</label>
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
    <div class="quick-actions">
        <a href="{{ route('cashier.sales') }}" class="action-card primary">
            <div class="action-icon">
                <i class="fas fa-plus"></i>
            </div>
            <div class="action-title">New Sale</div>
            <div class="action-desc">Record transaction</div>
        </a>
        <a href="{{ route('cashier.daily.sales') }}" class="action-card success">
            <div class="action-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="action-title">Sales Report</div>
            <div class="action-desc">View analytics</div>
        </a>
        <a href="{{ route('cashier.transaction.history') }}" class="action-card warning">
            <div class="action-icon">
                <i class="fas fa-history"></i>
            </div>
            <div class="action-title">History</div>
            <div class="action-desc">Past transactions</div>
        </a>
        <a href="#" class="action-card danger" id="endShiftBtn">
            <div class="action-icon">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <div class="action-title">End Shift</div>
            <div class="action-desc">Shift report</div>
        </a>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <h6 class="chart-title">Today's Sales by Hour</h6>
                    <small class="text-muted">Real-time updates</small>
                </div>
                <canvas id="salesByHourChart"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h6 class="chart-title">Top Products Today</h6>
                    <small class="text-muted">Best sellers</small>
                </div>
                <canvas id="topProductsChart"></canvas>
            </div>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-header">
            <h6 class="chart-title">Sales Trend (Last 7 Days)</h6>
            <small class="text-muted">Daily comparison</small>
        </div>
        <canvas id="salesTrendChart"></canvas>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
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
    
    document.getElementById('userDropdownToggle')?.addEventListener('click', function(e) {
        e.stopPropagation();
        const menu = document.getElementById('userDropdownMenu');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', function() {
        document.getElementById('userDropdownMenu').style.display = 'none';
    });

    const salesByHourCtx = document.getElementById('salesByHourChart');
    if (salesByHourCtx) {
        const hours = Array.from({length: 24}, (_, i) => `${i}:00`);
        const salesData = Array.from({length: 24}, () => Math.floor(Math.random() * 1000) + 500);
        
        new Chart(salesByHourCtx, {
            type: 'bar',
            data: {
                labels: hours,
                datasets: [{
                    label: 'Sales (₱)',
                    data: salesData,
                    backgroundColor: 'rgba(59, 49, 131, 0.7)',
                    borderColor: '#3b3183',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Sales: ₱${context.raw.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }

    const topProductsCtx = document.getElementById('topProductsChart');
    if (topProductsCtx) {
        const productNames = ['Makeup Kit', 'Perfume', 'Gift Box', 'Candle Set', 'Handbag'];
        const productSales = [1250, 980, 870, 650, 520];
        
        new Chart(topProductsCtx, {
            type: 'doughnut',
            data: {
                labels: productNames,
                datasets: [{
                    data: productSales,
                    backgroundColor: [
                        'rgba(59, 49, 131, 0.8)',
                        'rgba(35, 176, 122, 0.8)',
                        'rgba(240, 138, 36, 0.8)',
                        'rgba(224, 82, 82, 0.8)',
                        'rgba(2, 132, 199, 0.8)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ₱${context.raw.toLocaleString()}`;
                            }
                        }
                    }
                }
            }
        });
    }

    const salesTrendCtx = document.getElementById('salesTrendChart');
    if (salesTrendCtx) {
        const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Today'];
        const salesTrendData = [4500, 5200, 4800, 6100, 5800, 7200, 6800];
        const ordersTrendData = [12, 15, 14, 18, 16, 22, 20];
        
        new Chart(salesTrendCtx, {
            type: 'line',
            data: {
                labels: days,
                datasets: [
                    {
                        label: 'Sales (₱)',
                        data: salesTrendData,
                        borderColor: '#3b3183',
                        backgroundColor: 'rgba(59, 49, 131, 0.1)',
                        tension: 0.4,
                        fill: true,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Orders',
                        data: ordersTrendData,
                        borderColor: '#23b07a',
                        backgroundColor: 'rgba(35, 176, 122, 0.1)',
                        tension: 0.4,
                        fill: true,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Sales (₱)'
                        },
                        ticks: {
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Orders'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                    }
                }
            }
        });
    }

    document.getElementById('endShiftBtn')?.addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to end your shift? This will generate a shift report.')) {
            const btn = this;
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            btn.disabled = true;
            
            setTimeout(() => {
                alert('Shift report generated successfully!');
                btn.innerHTML = originalHTML;
                btn.disabled = false;
            }, 1500);
        }
    });

    setInterval(() => {
        console.log('Refreshing dashboard data...');
    }, 300000);

    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
</body>
</html>
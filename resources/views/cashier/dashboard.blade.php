<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cashier Dashboard | Dora's Oshoppe</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --sidebar-width: 240px;
      --primary-color: #3b3183;
      --primary-light: #efeaff;
      --primary-soft: rgba(59, 49, 131, 0.12);
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

    .sidebar.mobile-open {
      transform: translateX(0);
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
      margin-top: 18px;
    }
    
    .content-wrap { 
      margin-left: 240px; 
      transition: all 0.3s ease;
      height: 100vh;
      overflow-y: auto;
      background: var(--light-bg);
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
    input[type="date"]::-webkit-calendar-picker-indicator {
  opacity: 0;
  cursor: pointer;
}

    /* Stats Cards with Purple Theme */
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
      font-size: 1.4rem;
    }
    
    .icon-primary,
.icon-success,
.icon-warning,
.icon-danger,
.icon-info {
  background: rgba(59, 49, 131, 0.12); /* soft purple */
  color: var(--primary-color);
}
    
    .stat-badge {
      position: absolute;
      top: 10px;
      right: 10px;
      background: var(--primary-light);
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

    .chart-card {
      background: white;
      border-radius: 12px;
      padding: 20px;
      box-shadow: var(--card-shadow);
      margin-bottom: 24px;
      height: 350px;
      border-top: 3px solid var(--primary-color); /* Purple accent */
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
      
      .date-filter-section {
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
      
      .chart-card {
        height: 300px;
      }
    }
    
    @media (max-width: 576px) {
      .chart-card {
        height: 250px;
      }
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
    <div class="page-header-container">
      <div class="page-title-section">
        <h4 class="mb-1">Cashier Dashboard</h4>
        <p class="text-muted mb-0">Today's performance and quick actions</p>
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
        
        <div class="date-filter-section">
          <div class="date-picker-container">
            <div class="input-group">
              <input type="date" class="form-control" id="dateFilter" value="{{ $today->format('Y-m-d') }}">
              <span class="input-group-text" id="calendarTrigger">
                <i class="fas fa-calendar-alt"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="main-content">
    <!-- Quick Actions - Styled as stat-cards with purple theme -->
    <div class="row g-3 mb-4">
      <div class="col-xl-4 col-md-6">
        <a href="{{ route('cashier.sales') }}" class="stat-card">
          <div class="card p-3">
            <span class="stat-badge">Start Sale</span>
            <div class="d-flex">
              <div class="stat-icon me-3 icon-primary">
                <i class="fas fa-plus"></i>
              </div>
              <div class="flex-fill d-flex flex-column">
                <small class="text-muted">New Sale</small>
                <div class="mt-auto text-end" style="font-weight:700; font-size:20px;">
                  Process Transaction
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xl-4 col-md-6">
        <a href="{{ route('cashier.daily.sales') }}" class="stat-card">
          <div class="card p-3">
            <span class="stat-badge">View Report</span>
            <div class="d-flex">
              <div class="stat-icon me-3 icon-success">
                <i class="fas fa-chart-line"></i>
              </div>
              <div class="flex-fill d-flex flex-column">
                <small class="text-muted">Today's Sales</small>
                <div class="mt-auto text-end" style="font-weight:700; font-size:20px;" id="todaySales">
                  ₱{{ number_format($todaySales['total_sales'] ?? 0, 2) }}
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-xl-4 col-md-6">
        <a href="{{ route('cashier.transaction.history') }}" class="stat-card">
          <div class="card p-3">
            <span class="stat-badge">View History</span>
            <div class="d-flex">
              <div class="stat-icon me-3 icon-info">
                <i class="fas fa-history"></i>
              </div>
              <div class="flex-fill d-flex flex-column">
                <small class="text-muted">Recent Orders</small>
                <div class="mt-auto text-end" style="font-weight:700; font-size:20px;" id="todayOrders">
                  {{ $todaySales['total_orders'] ?? 0 }}
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>

    <!-- Charts -->
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
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"><script>
  // Mobile sidebar toggle
  const sidebar = document.getElementById('sidebar');
  const mobileMenuToggle = document.getElementById('mobileMenuToggle');
  const sidebarOverlay = document.getElementById('sidebarOverlay');

  mobileMenuToggle.addEventListener('click', function() {
    sidebar.classList.toggle('mobile-open');
    sidebarOverlay.classList.toggle('active');
  });

  sidebarOverlay.addEventListener('click', function() {
    sidebar.classList.remove('mobile-open');
    sidebarOverlay.classList.remove('active');
  });

  // User dropdown
  const userDropdownToggle = document.getElementById('userDropdownToggle');
  const userDropdownMenu = document.getElementById('userDropdownMenu');
  
  userDropdownToggle.addEventListener('click', function(e) {
    e.stopPropagation();
    userDropdownMenu.style.display = userDropdownMenu.style.display === 'block' ? 'none' : 'block';
  });
  
  document.addEventListener('click', function() {
    userDropdownMenu.style.display = 'none';
  });

  // Date picker trigger
  const dateFilter = document.getElementById('dateFilter');
  const calendarTrigger = document.getElementById('calendarTrigger');

  calendarTrigger.addEventListener('click', () => {
    if (dateFilter.showPicker) {
      dateFilter.showPicker();
    } else {
      dateFilter.focus();
    }
  });

  // You can add date filter logic here if needed (e.g., fetch new data on change)
  dateFilter.addEventListener('change', function() {
    // Optional: Implement AJAX reload similar to admin dashboard
  });
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
        fetch('{{ route("cashier.api.dashboard.stats") }}')
            .then(response => response.json())
            .then(data => {
                const hours = data.sales_by_hour.map(item => `${String(item.hour).padStart(2, '0')}:00`);
                const salesData = data.sales_by_hour.map(item => item.sales || 0);
                
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
            })
            .catch(error => console.log('Error loading sales by hour:', error));
    }

    const topProductsCtx = document.getElementById('topProductsChart');
    if (topProductsCtx) {
        fetch('{{ route("cashier.api.dashboard.stats") }}')
            .then(response => response.json())
            .then(data => {
                const productNames = data.top_products.map(p => p.ProductName);
                const productSales = data.top_products.map(p => parseFloat(p.total_sales) || 0);
                const colors = [
                    'rgba(59, 49, 131, 0.8)',
                    'rgba(35, 176, 122, 0.8)',
                    'rgba(240, 138, 36, 0.8)',
                    'rgba(224, 82, 82, 0.8)',
                    'rgba(2, 132, 199, 0.8)'
                ];
                
                new Chart(topProductsCtx, {
                    type: 'doughnut',
                    data: {
                        labels: productNames,
                        datasets: [{
                            data: productSales,
                            backgroundColor: colors.slice(0, productNames.length),
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
            })
            .catch(error => console.log('Error loading top products:', error));
    }

    const salesTrendCtx = document.getElementById('salesTrendChart');
    if (salesTrendCtx) {
        fetch('{{ route("cashier.api.dashboard.stats") }}')
            .then(response => response.json())
            .then(data => {
                const days = data.sales_trend.map(item => {
                    const date = new Date(item.date);
                    return date.toLocaleDateString('en-US', { weekday: 'short' });
                });
                const salesTrendData = data.sales_trend.map(item => parseFloat(item.total_sales) || 0);
                const ordersTrendData = data.sales_trend.map(item => item.order_count || 0);
                
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
            })
            .catch(error => console.log('Error loading sales trend:', error));
    }

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
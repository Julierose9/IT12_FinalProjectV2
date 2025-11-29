<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard | Dora's Oshopee</title>

  <!-- Bootstrap + FontAwesome + Poppins -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'Poppins', sans-serif; background:#f5f7fb; }
    .sidebar { 
      min-width: 220px; 
      max-width: 220px; 
      background: #fff; 
      border-right:1px solid #eef2f7; 
      height:100vh; 
      position:fixed; 
      top:0; 
      left:0; 
      padding:22px;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }
    .brand { display:flex; align-items:center; gap:10px; margin-bottom:18px; flex-shrink: 0; }
    .brand img { width:80px; height:auto; }
    .sidebar .nav-link { 
      color:#5b5f72; 
      padding:10px 8px; 
      border-radius:10px; 
      font-size: 0.95rem;
    }
    .sidebar .nav-link.active { background:#efeaff; color:#3b3183; font-weight:600; }
    .sidebar .nav-link:hover { background:#f8f9fa; }
    .content-wrap { margin-left:240px; padding:28px; }
    .topbar { 
      background:transparent; 
      display:flex; 
      gap:16px; 
      align-items:flex-start; 
      justify-content:space-between; 
      margin-bottom:22px; 
    }
    .search-input { 
      max-width: 400px; 
      width: 100%; 
      min-width: 300px;
    }
    .stat-card { border-radius:12px; }
    .stat-icon { 
        width:44px; 
        height:44px; 
        border-radius:10px; 
        display:flex; 
        align-items:center; 
        justify-content:center; 
        flex-shrink: 0;
    }
    .card-small { border-radius:12px; }
    
    /* Scrollable sidebar navigation */
    .sidebar-nav {
      flex: 1;
      overflow-y: auto;
      overflow-x: hidden;
      margin-top: 18px;
    }
    
    /* Custom scrollbar for sidebar */
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
    
    /* Dropdown menu styling */
    .nav .nav-link.dropdown-toggle::after {
      float: right;
      margin-top: 6px;
    }
    
    .nav .nav.flex-column.ms-3 {
      border-left: 2px solid #eef2f7;
      margin-left: 12px !important;
      padding-left: 8px;
    }
    
    /* Submenu items styling */
    .nav .nav.flex-column.ms-3 .nav-link {
      padding: 8px 12px;
      font-size: 0.95rem;
      border-radius: 6px;
    }
    
    /* Updated user info styling - Picture left, text right */
    .user-section {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 16px;
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
      color: #6c757d;
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
      color: #3b3183;
    }
    
    /* Search and filter section */
    .search-filter-section {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    
    /* Filter dropdown styling */
    .filter-dropdown {
      position: relative;
    }
    
    .filter-toggle {
      background: #fff;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 10px 12px;
      display: flex;
      align-items: center;
      gap: 6px;
      color: #5b5f72;
      transition: all 0.2s;
      cursor: pointer;
      min-width: 100px;
    }
    
    .filter-toggle:hover {
      background: #f8f9fa;
      border-color: #c1c1c1;
    }
    
    .filter-toggle.active {
      background: #3b3183;
      color: white;
      border-color: #3b3183;
    }
    
    .filter-menu {
      position: absolute;
      top: 100%;
      right: 0;
      background: white;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 16px;
      min-width: 220px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      z-index: 1000;
      margin-top: 8px;
      display: none;
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
      color: #3b3183;
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
    
    .date-inputs {
      display: flex;
      gap: 8px;
      margin-top: 8px;
    }
    
    .date-input {
      flex: 1;
    }
    
    .date-input input {
      width: 100%;
      padding: 6px 8px;
      border: 1px solid #dee2e6;
      border-radius: 4px;
      font-size: 0.875rem;
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
      background: #3b3183;
      color: white;
    }

    .btn-apply:hover {
      background: #2a2265;
    }

    .btn-clear {
      background: #6c757d;
      color: white;
    }

    .btn-clear:hover {
      background: #5a6268;
    }

    /* Active filter indicator - UPDATED */
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
      color: #6c757d;
      padding: 0;
      width: 16px;
      height: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* UPDATED: Container for search/filter and active filters */
    .filter-container {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 8px;
      margin-top: 20px;
    }

    @media (max-width: 991px) {
      .sidebar { 
        position:relative; 
        width:100%; 
        height:auto; 
        max-height: 80vh;
        border-right:none; 
        padding:12px 16px; 
        display:flex; 
        overflow:auto; 
      }
      .content-wrap { margin-left:0; padding:16px; }
      
      .topbar {
        flex-direction: column;
        align-items: stretch;
        gap: 20px;
      }
      
      .user-section {
        align-items: stretch;
      }
      
      .search-filter-section {
        justify-content: center;
        flex-wrap: wrap;
      }
      
      .search-input {
        min-width: 250px;
        max-width: 100%;
      }
      
      .filter-menu {
        right: auto;
        left: 0;
        min-width: 220px;
      }
      
      .filter-toggle {
        min-width: 90px;
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
    }
  </style>
</head>
<body>

{{-- Sidebar --}}
<aside class="sidebar">
  <div class="brand">
    <img src="{{ asset('images/logo_.png') }}" alt="Logo">
    <div>
      <div style="font-weight:600">Dora's Oshoppe</div>
      <small class="text-muted">Gift Shop</small>
    </div>
  </div>

  {{-- Scrollable Navigation --}}
  <div class="sidebar-nav">
    <nav class="nav flex-column">
      {{-- Dashboard --}}
      <a class="nav-link active" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-home me-2"></i> Dashboard
      </a>

      {{-- Accounts --}}
      <a class="nav-link" href="{{ route('admin.accounts.index') }}">
        <i class="fas fa-user-circle me-2"></i> Accounts
      </a>

      {{-- Records with Submenu --}}
      <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#recordsSubmenu">
        <i class="fas fa-archive me-2"></i> Records
      </a>
      
      <div class="collapse" id="recordsSubmenu">
        <div class="nav flex-column ms-3">
          <a class="nav-link" href="{{ route('admin.records.suppliers.index') }}">
            <i class="fas fa-truck me-2"></i> Suppliers
          </a>
          <a class="nav-link" href="{{ route('admin.records.employees.index') }}">
            <i class="fas fa-users me-2"></i> Employees
          </a>
          <a class="nav-link" href="{{ route('admin.records.products.index') }}">
            <i class="fas fa-box me-2"></i> Products
          </a>
        </div>
      </div>

      {{-- Transactions Dropdown --}}
      <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#transactionsSubmenu">
        <i class="fas fa-exchange-alt me-2"></i> Inventory
      </a>
      <div class="collapse" id="transactionsSubmenu">
        <div class="nav flex-column ms-3">
          {{-- Stock In --}}
          <a class="nav-link" href="{{ route('admin.transactions.stock-in.index') }}">
            <i class="fas fa-arrow-circle-down me-2"></i> Stock In
          </a>

          {{-- Pullouts --}}
          <a class="nav-link" href="{{ route('admin.transactions.pullouts.index') }}">
            <i class="fas fa-arrow-circle-up me-2"></i> Pullouts
          </a>
        </div>
      </div>

      {{-- Reports with Submenu --}}
      <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#reportsSubmenu">
        <i class="fas fa-chart-bar me-2"></i> Reports
      </a>
      <div class="collapse" id="reportsSubmenu">
        <div class="nav flex-column ms-3">
          <a class="nav-link" href="{{ route('admin.reports.transaction') }}">
            <i class="fas fa-file-invoice-dollar me-2"></i> Transaction 
          </a>
          <a class="nav-link" href="{{ route('admin.reports.inventory') }}">
            <i class="fas fa-clipboard-list me-2"></i> Inventory
          </a>
        </div>
      </div>
    </nav>
  </div>
</aside>

  {{-- Content --}}
  <main class="content-wrap">
    {{-- Topbar --}}
    <div class="topbar">
      <div class="d-flex align-items-center gap-3">
        <h4 class="mb-0">Dashboard</h4>
        <small class="text-muted">Overview</small>
      </div>

      <div class="user-section">
        <!-- User Info Section with Dropdown -->
        <div class="user-dropdown">
          <button class="user-dropdown-toggle" id="userDropdownToggle">
            <img src="{{ asset('images/logo_.png') }}" alt="avatar" class="user-avatar">
            <div class="user-details">
              <div class="user-name">Dora</div>
              <div class="user-role">Administrator</div>
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
              <input class="form-control" placeholder="Search..." />
            </div>
            
            <!-- Relevant Filter Dropdown -->
            <div class="filter-dropdown">
              <button class="filter-toggle" id="filterToggle">
                <i class="fas fa-filter"></i>
                <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
              </button>
              
              <div class="filter-menu" id="filterMenu" style="display: none;">
                <!-- Time Period Filter -->
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
                  <div class="date-inputs" id="customDateRange" style="display: none;">
                    <div class="date-input">
                      <input type="date" id="dateFrom" placeholder="From Date">
                    </div>
                    <div class="date-input">
                      <input type="date" id="dateTo" placeholder="To Date">
                    </div>
                  </div>
                </div>
                
                <!-- Stock Level Filters -->
                <div class="filter-section">
                  <div class="filter-section-title">Stock Alerts</div>
                  <div class="filter-options">
                    <div class="filter-option">
                      <input type="checkbox" id="stock-low" checked>
                      <label for="stock-low">Show Low Stock</label>
                    </div>
                    <div class="filter-option">
                      <input type="checkbox" id="stock-expiry" checked>
                      <label for="stock-expiry">Show Expiry Alerts</label>
                    </div>
                    <div class="filter-option">
                      <input type="checkbox" id="stock-movement" checked>
                      <label for="stock-movement">Show Stock Movements</label>
                    </div>
                  </div>
                </div>
                
                <!-- Product Category Filters -->
                <div class="filter-section">
                  <div class="filter-section-title">Product Categories</div>
                  <div class="filter-options">
                    <div class="filter-option">
                      <input type="checkbox" id="category-all" checked>
                      <label for="category-all">All Categories</label>
                    </div>
                    <div class="filter-option">
                      <input type="checkbox" id="category-beauty">
                      <label for="category-beauty">Beauty & Cosmetics</label>
                    </div>
                    <div class="filter-option">
                      <input type="checkbox" id="category-clothing">
                      <label for="category-clothing">Clothing</label>
                    </div>
                    <div class="filter-option">
                      <input type="checkbox" id="category-accessories">
                      <label for="category-accessories">Accessories</label>
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
          
          <!-- Active Filters Display - NOW POSITIONED BELOW SEARCH/FILTER -->
          <div class="active-filters" id="activeFilters">
            <!-- Filter tags will be dynamically added here -->
          </div>
        </div>
      </div>
    </div>

   <div class="row g-3 mb-4">

  <div class="col-md-3">
    <div class="card p-3 stat-card">
      <div class="d-flex">
        <div class="stat-icon me-3" style="background:#f3d6ff;">
          <i class="fas fa-box" style="color:#5a3e6b;"></i>
        </div>

        <div class="flex-fill d-flex flex-column">
          <small class="text-muted">Stock-In Storage</small>

          <div class="mt-auto text-end" style="font-weight:700; font-size:20px;">
            9
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card p-3 stat-card">
      <div class="d-flex">
        <div class="stat-icon me-3" style="background:#fff2e0;">
          <i class="fas fa-arrow-up" style="color:#f08a24;"></i>
        </div>

        <div class="flex-fill d-flex flex-column">
          <small class="text-muted">Stock-Out today</small>
          <div class="mt-auto text-end" style="font-weight:700; font-size:20px;">
            300
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card p-3 stat-card">
      <div class="d-flex">
        <div class="stat-icon me-3" style="background:#fff8e1;">
          <i class="fas fa-clock" style="color:#ff9800;"></i>
        </div>

        <div class="flex-fill d-flex flex-column">
          <small class="text-muted">Products Near Expiry</small>
          <div class="mt-auto text-end" style="font-weight:700; font-size:20px;">
            7
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card p-3 stat-card">
      <div class="d-flex">
        <div class="stat-icon me-3" style="background:#fff0f0;">
          <i class="fas fa-exclamation-triangle" style="color:#e05252;"></i>
        </div>

        <div class="flex-fill d-flex flex-column">
          <small class="text-muted">Low Stock Items</small>
          <div class="mt-auto text-end" style="font-weight:700; font-size:20px;">
            8
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

    {{-- Charts + lists --}}
    <div class="row g-3">
      <div class="col-lg-7">
        <div class="card p-3 card-small mb-3">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <strong>Stock Movement Trend</strong>
            <small class="text-muted">This week</small>
          </div>
          <canvas id="trendChart" height="110"></canvas>
        </div>

        <div class="card p-3 card-small">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <strong>Top Moving Products</strong>
            <small class="text-muted">Today</small>
          </div>

          <ul class="list-unstyled mb-0">
            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
              <div>
                <div style="font-weight:600">Rosey Makeup Kit</div>
                <small class="text-muted">SKU: RMK-001</small>
              </div>
              <div>
                <span class="badge bg-light text-dark">120 units</span>
              </div>
            </li>

            <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
              <div>
                <div style="font-weight:600">Velvet Dress</div>
                <small class="text-muted">SKU: VD-221</small>
              </div>
              <div><span class="badge bg-light text-dark">98 units</span></div>
            </li>

            <li class="d-flex justify-content-between align-items-center py-2">
              <div>
                <div style="font-weight:600">Gift Ribbon</div>
                <small class="text-muted">SKU: GR-07</small>
              </div>
              <div><span class="badge bg-light text-dark">76 units</span></div>
            </li>
          </ul>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="card p-3 card-small mb-3">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <strong>Inventory Turnover Rate</strong>
            <small class="text-muted">Monthly</small>
          </div>
          <canvas id="areaChart" height="140"></canvas>
        </div>

        <div class="card p-3 card-small">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <strong>Stock vs Recorded</strong>
            <small class="text-muted">Discrepancy Analysis</small>
          </div>
          <canvas id="barChart" height="140"></canvas>
        </div>
      </div>
    </div>
  </main>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Filter functionality
    const filterToggle = document.getElementById('filterToggle');
    const filterMenu = document.getElementById('filterMenu');
    const activeFilters = document.getElementById('activeFilters');
    const customDateRange = document.getElementById('customDateRange');
    
    // User dropdown functionality
    const userDropdownToggle = document.getElementById('userDropdownToggle');
    const userDropdownMenu = document.getElementById('userDropdownMenu');
    
    // Store current filters
    let currentFilters = {
      timePeriod: 'This Week',
      stockAlerts: ['Low Stock', 'Expiry Alerts', 'Stock Movements'],
      categories: ['All Categories']
    };
    
    // Filter toggle
    filterToggle.addEventListener('click', function(e) {
      e.stopPropagation();
      const isVisible = filterMenu.style.display === 'block';
      filterMenu.style.display = isVisible ? 'none' : 'block';
      filterToggle.classList.toggle('active', !isVisible);
    });
    
    // User dropdown toggle
    userDropdownToggle.addEventListener('click', function(e) {
      e.stopPropagation();
      const isVisible = userDropdownMenu.style.display === 'block';
      userDropdownMenu.style.display = isVisible ? 'none' : 'block';
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
      filterMenu.style.display = 'none';
      filterToggle.classList.remove('active');
      userDropdownMenu.style.display = 'none';
    });
    
    // Prevent closing when clicking inside the filter menu
    filterMenu.addEventListener('click', function(e) {
      e.stopPropagation();
    });
    
    // Prevent closing when clicking inside the user dropdown
    userDropdownMenu.addEventListener('click', function(e) {
      e.stopPropagation();
    });
    
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
    
    // Apply filters
    document.getElementById('applyFilters').addEventListener('click', function() {
      filterMenu.style.display = 'none';
      filterToggle.classList.remove('active');
      
      // Update current filters based on selections
      updateCurrentFilters();
      
      // Update active filters display
      updateActiveFilters();
      
      // Here you would typically refresh dashboard data based on filters
      console.log('Filters applied - refreshing dashboard data...');
    });
    
    // Clear filters
    document.getElementById('clearFilters').addEventListener('click', function() {
      // Clear all checkboxes and radios
      document.querySelectorAll('.filter-option input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = false;
      });
      
      // Set default values
      document.getElementById('period-today').checked = false;
      document.getElementById('period-week').checked = true;
      document.getElementById('period-month').checked = false;
      document.getElementById('stock-low').checked = true;
      document.getElementById('stock-expiry').checked = true;
      document.getElementById('stock-movement').checked = true;
      document.getElementById('category-all').checked = true;
      
      // Hide custom date range
      customDateRange.style.display = 'none';
      
      // Update current filters to defaults
      currentFilters = {
        timePeriod: 'This Week',
        stockAlerts: ['Low Stock', 'Expiry Alerts', 'Stock Movements'],
        categories: ['All Categories']
      };
      
      // Update active filters
      updateActiveFilters();
    });
    
    function updateCurrentFilters() {
      // Update time period
      if (document.getElementById('period-today').checked) {
        currentFilters.timePeriod = 'Today';
      } else if (document.getElementById('period-week').checked) {
        currentFilters.timePeriod = 'This Week';
      } else if (document.getElementById('period-month').checked) {
        currentFilters.timePeriod = 'This Month';
      } else if (document.getElementById('period-custom').checked) {
        const fromDate = document.getElementById('dateFrom').value;
        const toDate = document.getElementById('dateTo').value;
        currentFilters.timePeriod = `Custom: ${fromDate} to ${toDate}`;
      }
      
      // Update stock alerts
      currentFilters.stockAlerts = [];
      if (document.getElementById('stock-low').checked) {
        currentFilters.stockAlerts.push('Low Stock');
      }
      if (document.getElementById('stock-expiry').checked) {
        currentFilters.stockAlerts.push('Expiry Alerts');
      }
      if (document.getElementById('stock-movement').checked) {
        currentFilters.stockAlerts.push('Stock Movements');
      }
      
      // Update categories
      currentFilters.categories = [];
      if (document.getElementById('category-all').checked) {
        currentFilters.categories.push('All Categories');
      } else {
        if (document.getElementById('category-beauty').checked) {
          currentFilters.categories.push('Beauty & Cosmetics');
        }
        if (document.getElementById('category-clothing').checked) {
          currentFilters.categories.push('Clothing');
        }
        if (document.getElementById('category-accessories').checked) {
          currentFilters.categories.push('Accessories');
        }
      }
    }
    
    function updateActiveFilters() {
      // Clear existing filter tags
      activeFilters.innerHTML = '';
      
      // Check if we have any non-default filters
      const hasCustomFilters = 
        currentFilters.timePeriod !== 'This Week' ||
        currentFilters.stockAlerts.length < 3 ||
        currentFilters.categories.length !== 1 || 
        currentFilters.categories[0] !== 'All Categories';
      
      if (!hasCustomFilters) {
        // No custom filters applied, hide the active filters section
        activeFilters.classList.remove('has-filters');
        return;
      }
      
      // Show active filters section
      activeFilters.classList.add('has-filters');
      
      // Add time period filter tag if not default
      if (currentFilters.timePeriod !== 'This Week') {
        const timeTag = createFilterTag(`Time: ${currentFilters.timePeriod}`, 'timePeriod');
        activeFilters.appendChild(timeTag);
      }
      
      // Add stock alert filter tags if not all are selected
      if (currentFilters.stockAlerts.length < 3) {
        currentFilters.stockAlerts.forEach(alert => {
          const alertTag = createFilterTag(alert, `stock-${alert.toLowerCase().replace(' ', '-')}`);
          activeFilters.appendChild(alertTag);
        });
      }
      
      // Add category filter tags if not "All Categories"
      if (currentFilters.categories.length > 0 && 
          (currentFilters.categories.length > 1 || currentFilters.categories[0] !== 'All Categories')) {
        currentFilters.categories.forEach(category => {
          const categoryTag = createFilterTag(category, `category-${category.toLowerCase().replace(' & ', '-').replace(' ', '-')}`);
          activeFilters.appendChild(categoryTag);
        });
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
      // Remove the specific filter and update the UI
      if (filterType === 'timePeriod') {
        document.getElementById('period-week').checked = true;
        currentFilters.timePeriod = 'This Week';
      } else if (filterType.startsWith('stock-')) {
        const filterName = filterType.replace('stock-', '').replace('-', ' ');
        const index = currentFilters.stockAlerts.indexOf(
          filterName.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
        );
        if (index > -1) {
          currentFilters.stockAlerts.splice(index, 1);
        }
      } else if (filterType.startsWith('category-')) {
        const filterName = filterType.replace('category-', '').replace('-', ' ');
        const index = currentFilters.categories.indexOf(
          filterName.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
        );
        if (index > -1) {
          currentFilters.categories.splice(index, 1);
        }
      }
      
      // Update the checkboxes/radios to reflect the change
      updateFilterInputs();
      
      // Update active filters display
      updateActiveFilters();
      
      // Here you would typically refresh dashboard data
      console.log('Filter removed - refreshing dashboard data...');
    }
    
    function updateFilterInputs() {
      // Update time period radio
      if (currentFilters.timePeriod === 'Today') {
        document.getElementById('period-today').checked = true;
      } else if (currentFilters.timePeriod === 'This Week') {
        document.getElementById('period-week').checked = true;
      } else if (currentFilters.timePeriod === 'This Month') {
        document.getElementById('period-month').checked = true;
      }
      
      // Update stock alert checkboxes
      document.getElementById('stock-low').checked = currentFilters.stockAlerts.includes('Low Stock');
      document.getElementById('stock-expiry').checked = currentFilters.stockAlerts.includes('Expiry Alerts');
      document.getElementById('stock-movement').checked = currentFilters.stockAlerts.includes('Stock Movements');
      
      // Update category checkboxes
      document.getElementById('category-all').checked = currentFilters.categories.includes('All Categories');
      document.getElementById('category-beauty').checked = currentFilters.categories.includes('Beauty & Cosmetics');
      document.getElementById('category-clothing').checked = currentFilters.categories.includes('Clothing');
      document.getElementById('category-accessories').checked = currentFilters.categories.includes('Accessories');
    }
    
    // Initialize Bootstrap collapse for submenus
    var transactionsCollapse = new bootstrap.Collapse(document.getElementById('transactionsSubmenu'), {
      toggle: false
    });
    
    var reportsCollapse = new bootstrap.Collapse(document.getElementById('reportsSubmenu'), {
      toggle: false
    });

    // Trend line chart
    new Chart(document.getElementById('trendChart'), {
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
        plugins: { legend: { display: false } },
        scales: {
          y: { beginAtZero: true, ticks: { stepSize: 50 } }
        }
      }
    });

    // Area chart
    new Chart(document.getElementById('areaChart'), {
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
      options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });

    // Bar chart
    new Chart(document.getElementById('barChart'), {
      type: 'bar',
      data: {
        labels: ['Prod A','Prod B','Prod C','Prod D'],
        datasets: [{
          label: 'Discrepancy',
          data: [5, 12, 8, 3],
          backgroundColor: ['#ff8a8a','#ffd27a','#9ad0ff','#c7b3ff']
        }]
      },
      options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });
  </script>
</body>
</html>
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
    :root {
      --sidebar-width: 240px;
      --primary-color: #3b3183;
      --secondary-color: #efeaff;
    }
    
    body { 
      font-family: 'Poppins', sans-serif; 
      background: #f5f7fb; 
      margin: 0;
      padding: 0;
      overflow: hidden;
      height: 100vh;
    }
    
    /* Main Layout Container */
    .main-container {
      display: flex;
      height: 100vh;
      overflow: hidden;
    }
    
    /* Fixed Sidebar */
    .sidebar { 
      width: var(--sidebar-width);
      background: #fff; 
      border-right: 1px solid #eef2f7; 
      height: 100vh;
      padding: 22px; 
      display: flex; 
      flex-direction: column;
      position: fixed;
      left: 0;
      top: 0;
      z-index: 1000;
      overflow-y: auto;
    }
    
    .brand { 
      display: flex; 
      align-items: center; 
      gap: 10px; 
      margin-bottom: 18px; 
      flex-shrink: 0;
    }
    
    .brand img { 
      width: 80px; 
      height: auto; 
    }
    
    .sidebar .nav-link { 
      color: #5b5f72; 
      padding: 10px 8px; 
      border-radius: 10px; 
      font-size: 0.95rem; 
      transition: all 0.3s ease;
    }
    
    .sidebar .nav-link.active { 
      background: var(--secondary-color); 
      color: var(--primary-color); 
      font-weight: 600; 
    }
    
    .sidebar .nav-link:hover { 
      background: #f8f9fa; 
    }
    
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
    
    /* Scrollable Main Content */
    .content-wrap { 
      margin-left: var(--sidebar-width);
      flex: 1;
      display: flex;
      flex-direction: column;
      height: 100vh;
      overflow: hidden;
    }
    
    /* Topbar - Fixed */
    .topbar-container {
      background: #f5f7fb;
      padding: 28px 28px 0 28px;
      flex-shrink: 0;
    }
    
    .topbar { 
      display: flex; 
      justify-content: space-between; 
      align-items: flex-start; 
      margin-bottom: 22px; 
      gap: 16px; 
      flex-wrap: wrap;
    }
    
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
      cursor: pointer; 
      padding: 8px; 
      border-radius: 8px; 
      transition: all 0.3s ease;
    }
    
    .user-info:hover { 
      background: #f8f9fa; 
    }
    
    .user-avatar { 
      width: 44px; 
      height: 44px; 
      border-radius: 10px; 
      object-fit: cover; 
    }
    
    /* Scrollable Content Area */
    .scrollable-content {
      flex: 1;
      padding: 0 28px 28px 28px;
      overflow-y: auto;
      background: #f5f7fb;
    }
    
    /* Stat Cards */
    .stat-card { 
      border-radius: 12px; 
      transition: transform 0.2s ease;
    }
    
    .stat-card:hover {
      transform: translateY(-2px);
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
    }
    
    /* Chart Containers */
    .chart-container {
      position: relative;
      height: 100%;
      min-height: 200px;
    }
    
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

/* Responsive adjustments */
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

        /* Active filter indicator */
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

        /* Container for search/filter and active filters */
        .filter-container {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
            margin-top: 20px;
            width: 100%;
        }

    
    /* Search and Filter */
    .search-input { 
      max-width: 400px; 
      width: 100%; 
      min-width: 300px;
    }
    
    /* Mobile Menu Toggle */
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
    
    /* Responsive Design */
    @media (max-width: 1200px) {
      .chart-container {
        min-height: 180px;
      }
    }
    
    @media (max-width: 992px) {
      .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
      }
      
      .sidebar.mobile-open {
        transform: translateX(0);
      }
      
      .content-wrap {
        margin-left: 0;
      }
      
      .mobile-menu-toggle {
        display: block;
      }
      
      .topbar-container,
      .scrollable-content {
        padding-left: 20px;
        padding-right: 20px;
      }
      
      .topbar {
        flex-direction: column;
        align-items: stretch;
      }
      
      .user-section {
        align-items: stretch;
      }
      
      .search-input {
        max-width: 100% !important;
        min-width: auto !important;
      }
    }
    
    @media (max-width: 768px) {
      .stat-card {
        margin-bottom: 15px;
      }
      
      .chart-container {
        min-height: 160px;
      }
      
      .topbar-container,
      .scrollable-content {
        padding: 15px;
      }
    }
    
    @media (max-width: 576px) {
      h4 {
        font-size: 1.3rem;
      }
      
      .user-info {
        flex-direction: column;
        text-align: center;
      }
      
      .brand img {
        width: 60px;
      }
    }
    
    /* Custom Scrollbar */
    .scrollable-content::-webkit-scrollbar {
      width: 6px;
    }
    
    .scrollable-content::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }
    
    .scrollable-content::-webkit-scrollbar-thumb {
      background: #c1c1c1;
      border-radius: 10px;
    }
    
    .scrollable-content::-webkit-scrollbar-thumb:hover {
      background: #a8a8a8;
    }
    
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
  </style>
</head>
<body>

<!-- Mobile Menu Toggle -->
<button class="mobile-menu-toggle" id="mobileMenuToggle">
  <i class="fas fa-bars"></i>
</button>

<div class="main-container">
  {{-- Fixed Sidebar --}}
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
            <div class="collapse " id="recordsSubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link" href="{{ route('admin.supplier') }}">
                        <i class="fas fa-truck"></i>
                        <span>Suppliers</span>
                    </a>
                    <a class="nav-link" href="{{ route('admin.employees') }}">
                        <i class="fas fa-users"></i>
                        <span>Employees</span>
                    </a>
                    <a class="nav-link " href="{{ route('admin.products') }}">
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

  {{-- Main Content Area --}}
  <div class="content-wrap">
    {{-- Fixed Topbar --}}
    <div class="topbar-container">
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
                        <div class="user-name">{{ Auth::user()->Username ?? 'Dora' }}</div>
                        <div class="user-role">{{ Auth::user()->Role ?? 'Administrator' }}</div>
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
    <div class="search-filter-row">
        <!-- Search Input -->
        <div class="input-group search-input">
            <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
            <input type="text" class="form-control" placeholder="Search Product ID, Name, Category..." 
                   id="searchInput" value="{{ request('search') ?? '' }}">
        </div>
        
        <!-- Filter Dropdown -->
        <div class="filter-dropdown">
            <button class="filter-toggle" id="filterToggle">
                <i class="fas fa-filter"></i> 
                Filter 
                <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
            </button>
            <div class="filter-menu" id="filterMenu">
                <!-- Your filter content here -->
                <div class="filter-section">
                    <div class="filter-section-title">Stock Status</div>
                    <div class="filter-options">
                        <!-- Your filter options -->
                    </div>
                </div>
                <!-- ... rest of filter content ... -->
                <div class="filter-actions">
                    <button class="btn-apply" id="applyFilters">Apply</button>
                    <button class="btn-clear" id="clearFilters">Reset</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Active Filters Display -->
    <div class="active-filters" id="activeFilters"></div>
</div>
        </div>
      </div>
    </div>

    {{-- Scrollable Content --}}
    <div class="scrollable-content">
      {{-- Stat Cards --}}
      <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
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

        <div class="col-xl-3 col-md-6">
          <div class="card p-3 stat-card">
            <div class="d-flex">
              <div class="stat-icon me-3" style="background:#fff2e0;">
                <i class="fas fa-arrow-up" style="color:#f08a24;"></i>
              </div>
              <div class="flex-fill d-flex flex-column">
                <small class="text-muted">Stock-Out Today</small>
                <div class="mt-auto text-end" style="font-weight:700; font-size:20px;">
                  300
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6">
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

        <div class="col-xl-3 col-md-6">
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

      {{-- Charts + Lists --}}
      <div class="row g-3">
        {{-- Left Column --}}
        <div class="col-lg-8">
          {{-- Stock Movement Trend --}}
          <div class="card p-3 card-small mb-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <strong>Stock Movement Trend</strong>
              <small class="text-muted">This week</small>
            </div>
            <div class="chart-container">
              <canvas id="trendChart"></canvas>
            </div>
          </div>

          {{-- Additional Charts Row --}}
          <div class="row g-3">
            <div class="col-md-6">
              <div class="card p-3 card-small">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <strong>Sales by Category</strong>
                  <small class="text-muted">Monthly</small>
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
                  <small class="text-muted">By Category</small>
                </div>
                <div class="chart-container">
                  <canvas id="doughnutChart"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Right Column --}}
        <div class="col-lg-4">
          {{-- Top Moving Products --}}
          <div class="card p-3 card-small mb-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
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
              <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <div>
                  <div style="font-weight:600">Gift Ribbon</div>
                  <small class="text-muted">SKU: GR-07</small>
                </div>
                <div><span class="badge bg-light text-dark">76 units</span></div>
              </li>
              <li class="d-flex justify-content-between align-items-center py-2">
                <div>
                  <div style="font-weight:600">Pearl Necklace</div>
                  <small class="text-muted">SKU: PN-115</small>
                </div>
                <div><span class="badge bg-light text-dark">65 units</span></div>
              </li>
            </ul>
          </div>

          {{-- Inventory Turnover Rate --}}
          <div class="card p-3 card-small">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <strong>Inventory Turnover Rate</strong>
              <small class="text-muted">Monthly</small>
            </div>
            <div class="chart-container">
              <canvas id="areaChart"></canvas>
            </div>
          </div>
        </div>
      </div>

      {{-- Bottom Row --}}
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
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Mobile menu toggle
  document.getElementById('mobileMenuToggle')?.addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('mobile-open');
  });

  // User dropdown functionality
  document.getElementById('userDropdownToggle')?.addEventListener('click', function(e) {
    e.stopPropagation();
    const menu = document.getElementById('userDropdownMenu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
  });

  // Close dropdown when clicking outside
  document.addEventListener('click', function() {
    document.getElementById('userDropdownMenu').style.display = 'none';
  });

  // Close mobile menu when clicking on a link
  document.querySelectorAll('.sidebar .nav-link').forEach(link => {
    link.addEventListener('click', function() {
      if (window.innerWidth <= 992) {
        document.getElementById('sidebar').classList.remove('mobile-open');
      }
    });
  });

  // Handle window resize
  window.addEventListener('resize', function() {
    if (window.innerWidth > 992) {
      document.getElementById('sidebar').classList.remove('mobile-open');
    }
  });

  // Initialize all charts when the page loads
  document.addEventListener('DOMContentLoaded', function() {
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
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          y: { beginAtZero: true, ticks: { stepSize: 50 } },
          x: { grid: { display: false } }
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

    // Pie Chart - Sales by Category
    new Chart(document.getElementById('pieChart'), {
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

    // Doughnut Chart - Inventory Value
    new Chart(document.getElementById('doughnutChart'), {
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

    // Radar Chart - Supplier Performance
    new Chart(document.getElementById('radarChart'), {
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
  });
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Products | Dora's Oshoppe</title>
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

    /* Required field asterisk */
    .form-label.required::after {
      content: " *";
      color: var(--danger-color);
    }

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

    /* Table */
    .table-card { border-radius: 12px; border: none; box-shadow: var(--card-shadow); overflow: hidden; }
    .table th { font-weight: 600; color: #5b5f72; font-size: 0.85rem; text-transform: uppercase;
      letter-spacing: 0.5px; padding: 12px 16px; white-space: nowrap; }
    .table td { padding: 16px; vertical-align: middle; border-color: #f1f3f4; }
    .status-badge { padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 500; }
    .status-active {  color: var(--success-color); }
    .status-inactive { color: var(--danger-color); }

    /* Tabs */
    .nav-tabs .nav-link { color: #5b5f72; border: none; padding: 12px 20px; font-weight: 500; }
    .nav-tabs .nav-link.active { color: var(--primary-color); background-color: #efeaff; border-bottom: 2px solid var(--primary-color); }

    /* Responsive */
    @media (max-width: 991.98px) {
      .sidebar { transform: translateX(-100%); width: 280px; box-shadow: 2px 0 10px rgba(0,0,0,0.1); }
      .sidebar.mobile-open { transform: translateX(0); }
      .sidebar-toggle, .sidebar-overlay { display: block; }
      .content-wrap { margin-left: 0; padding: 70px 16px 16px; }
      .topbar { flex-direction: column; align-items: stretch; }
      .user-section, .filter-container { align-items: stretch; min-width: 100%; }
      .search-input { min-width: 100%; }
      
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
    @media (max-width: 575.98px) {
      .content-wrap { padding: 70px 8px 8px; }
      .table th, .table td { padding: 10px 6px; font-size: 0.85rem; }
      .action-buttons { flex-direction: column; }
    }

    /* Supplier info in select */
    .supplier-option {
        display: flex;
        flex-direction: column;
    }
    .supplier-name {
        font-weight: 500;
    }
    .supplier-info {
        font-size: 0.85em;
        color: #6c757d;
    }

    /* ID info display */
    .id-info {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 10px;
        margin-top: 5px;
    }
    .id-info small {
        font-size: 0.85em;
        color: #6c757d;
    }
    
    /* Alert Styles */
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
.table td {
    padding: 12px 16px;
    vertical-align: top;
    border-color: #f1f3f4;
}

.product-description {
    display: -webkit-box;
    -webkit-line-clamp: 2; 
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    max-height: 2.8em; 
    line-height: 1.4em;
}
  </style>
</head>
<body>
@php
    // Create empty collection if $recentStock doesn't exist
    $recentStock = $recentStock ?? collect([]);

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
            <small> Gift Shop</small>
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
                    <a class="nav-link" href="{{ route('admin.employees') }}">
                        <i class="fas fa-users"></i>
                        <span>Employees</span>
                    </a>
                    <a class="nav-link active" href="{{ route('admin.products') }}">
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

<!-- Main Content -->
<main class="content-wrap" id="contentWrap">
    <!-- Top Header: Title + User (fixed) -->
    <div class="topbar">
      <div class="page-title-section">
        <h4 class="mb-1">Products Management</h4>
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
            
        
        <!-- Search and Filter Section -->
        <div class="filter-container">
          <div class="search-filter-section">
            <div class="input-group search-input">
              <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
              <input class="form-control" placeholder="Search products..." id="searchInput" />
            </div>
            
            <div class="filter-dropdown">
              <button class="filter-toggle" id="filterToggle">
                <i class="fas fa-filter"></i>
                <span>Filter</span>
                <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
              </button>
              
              <div class="filter-menu" id="filterMenu" style="display: none;">
                <!-- Category Filter -->
                <div class="filter-section">
                  <div class="filter-section-title">Filter by Category</div>
                  <div class="filter-options">
                    <div class="filter-option">
                      <input type="checkbox" id="cat-all" checked>
                      <label for="cat-all">All Categories</label>
                    </div>
                    @foreach($categories as $cat)
                    <div class="filter-option">
                      <input type="checkbox" id="cat-{{ $cat->CategoryID }}">
                      <label for="cat-{{ $cat->CategoryID }}">{{ $cat->CategoryName }}</label>
                    </div>
                    @endforeach
                  </div>
                </div>
                
                <!-- Status Filter -->
                <div class="filter-section">
                  <div class="filter-section-title">Filter by Status</div>
                  <div class="filter-options">
                    <div class="filter-option">
                      <input type="checkbox" id="status-all" checked>
                      <label for="status-all">All Status</label>
                    </div>
                    <div class="filter-option">
                      <input type="checkbox" id="status-active">
                      <label for="status-active">Active</label>
                    </div>
                    <div class="filter-option">
                      <input type="checkbox" id="status-inactive">
                      <label for="status-inactive">Inactive</label>
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

    {{-- Success/Error Messages --}}
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

    @if(session('warning'))
      <div class="alert alert-warning alert-dismissible fade show">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if(session('info'))
      <div class="alert alert-info alert-dismissible fade show">
        <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i>Please fix the following errors:
        <ul class="mb-0 mt-2">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

  <!-- Tabs -->
  <div class="mb-4">
    <ul class="nav nav-tabs" id="productsTabs" role="tablist">
      <li class="nav-item">
        <button class="nav-link active px-4 py-2 fw-medium" data-bs-toggle="tab" data-bs-target="#categories">
          Categories
        </button>
      </li>
      <li class="nav-item">
        <button class="nav-link px-4 py-2 fw-medium" data-bs-toggle="tab" data-bs-target="#products">
          Products
        </button>
      </li>
    </ul>
  </div>

  <div class="tab-content">
    <!-- Categories Tab -->
    <div class="tab-pane fade show active" id="categories">
      <div class="card table-card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h5 class="card-title mb-0">Product Categories</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal"><i class="fas fa-plus me-2"></i>Add New Category</button>
          </div>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead><tr><th>Category ID</th><th>Name</th><th>Products</th><th>Actions</th></tr></thead>
              <tbody id="categoriesTableBody">
                @foreach($categories as $category)
                <tr data-category="{{ $category->CategoryName }}">
                  <td><strong>{{ $category->CategoryID }}</strong></td>
                  <td><div style="font-weight:600">{{ $category->CategoryName }}</div></td>
                  <td><span class="badge bg-primary">{{ $category->products_count ?? 0 }}</span></td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary edit-category" data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                      data-id="{{ $category->CategoryID }}" data-name="{{ $category->CategoryName }}"><i class="fas fa-pencil"></i></button>
                    <button class="btn btn-sm btn-outline-danger delete-category" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal"
                      data-id="{{ $category->CategoryID }}" data-name="{{ $category->CategoryName }}"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    {{-- Products Tab --}}
<div class="tab-pane fade" id="products" role="tabpanel">
  {{-- Products Table --}}
  <div class="card table-card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="card-title mb-0">Product List</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
          <i class="fas fa-plus me-2"></i>Add New Product
        </button>
      </div>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Product ID</th>
              <th>Product Name</th>
              <th>SKU Number</th>
              <th>Category</th>
              <th>Supplier</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
<tbody id="productsTableBody">
    @foreach($products as $product)
    {{-- Check if this is an actual product and not a summary/total object --}}
    @if(!is_string($product) && !is_array($product))
    <tr>
        <td><strong>{{ $product->ProductID ?? $product->product_id ?? 'N/A' }}</strong></td>
        <td>
        <div>
        <div style="font-weight:600">{{ $product->ProductName ?? $product->product_name ?? 'N/A' }}</div>
        @if(isset($product->ProductDescription) || isset($product->product_description))
            @php
                $description = $product->ProductDescription ?? $product->product_description ?? '';
                $shortDescription = strlen($description) > 100 ? substr($description, 0, 100) . '...' : $description;
            @endphp
            <div class="product-description text-muted small mt-1">
                {{ $shortDescription }}
            </div>
        @endif
    </div>
</td>
        <td><strong>{{ $product->SKUNumber ?? $product->sku_number ?? 'N/A' }}</strong></td>
        <td>
            <span class="badge bg-light text-dark">{{ $product->category->CategoryName ?? $product->category_name ?? 'Uncategorized' }}</span>
        </td>
        <td>
            <small class="text-muted">{{ $product->supplier->SupplierName ?? $product->supplier_name ?? 'N/A' }}</small>
        </td>
        <td>
            @php
                $status = $product->ProductStatus ?? $product->product_status ?? 'Active';
            @endphp
            @if(strtolower($status) === 'inactive')
            <span class="status-badge status-inactive">Inactive</span>
            @else
            <span class="status-badge status-active">Active</span>
            @endif
        </td>
        <td>
            <div class="btn-group">
                @php
                    $productId = $product->ProductID ?? $product->product_id ?? null;
                    $productName = $product->ProductName ?? $product->product_name ?? '';
                    $productDescription = $product->ProductDescription ?? $product->product_description ?? '';
                    $categoryId = $product->CategoryID ?? $product->category_id ?? '';
                    $supplierId = $product->SupplierID ?? $product->supplier_id ?? '';
                    $skuNumber = $product->SKUNumber ?? $product->sku_number ?? '';
                    $productStatus = $product->ProductStatus ?? $product->product_status ?? 'Active';
                @endphp
                
                @if($productId)
                <button class="btn btn-sm btn-outline-primary edit-product" 
                        data-bs-toggle="modal" 
                        data-bs-target="#editProductModal"
                        data-product-id="{{ $productId }}"
                        data-product-name="{{ $productName }}"
                        data-product-description="{{ $productDescription }}"
                        data-category-id="{{ $categoryId }}"
                        data-supplier-id="{{ $supplierId }}"
                        data-sku-number="{{ $skuNumber }}"
                        data-product-status="{{ $productStatus }}">
                    <i class="fas fa-pencil"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger delete-product" 
                        data-bs-toggle="modal" 
                        data-bs-target="#deleteProductModal"
                        data-product-id="{{ $productId }}"
                        data-product-name="{{ $productName }}">
                    <i class="fas fa-trash"></i>
                </button>
                @endif
            </div>
        </td>
    </tr>
    @endif
    @endforeach
</tbody>
        </table>
      </div>

      {{-- Simple product count --}}
      <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
          Total: {{ $products->count() ?? count($products) }} product(s)
        </div>
      </div>
    </div>
  </div>
</div>
  </div>

</main>

{{-- Add Product Modal --}}
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <form action="{{ route('admin.products.store') }}" method="POST" id="addProductForm">
          @csrf
          
          <!-- Row 1: Supplier and Category -->
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="SupplierID" class="form-label required">Supplier</label>
                <select class="form-select" id="SupplierID" name="SupplierID" required>
                  <option value="">Select Supplier</option>
                  @foreach($suppliers as $supplier)
                  <option value="{{ $supplier->SupplierID }}">
                    {{ $supplier->SupplierName }}
                    @if($supplier->ContactNumber)
                      ({{ $supplier->ContactNumber }})
                    @endif
                  </option>
                  @endforeach
                </select>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="mb-3">
                <label for="CategoryID" class="form-label required">Category</label>
                <select class="form-select" id="CategoryID" name="CategoryID" required>
                  <option value="">Select Category</option>
                  @foreach($categories as $category)
                  <option value="{{ $category->CategoryID }}" data-prefix="{{ $category->CategoryPrefix ?? substr(strtoupper($category->CategoryName), 0, 3) }}">
                    {{ $category->CategoryName }}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <!-- Row 2: Product Name and SKU Preview -->
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="ProductName" class="form-label required">Product Name</label>
                <input type="text" class="form-control" id="ProductName" name="ProductName" required
                       placeholder="Enter product name">
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">SKU Number</label>
                <div class="form-control" style="background-color: #f8f9fa;">
                  <div id="skuPreview" class="text-muted">Select a category to preview SKU</div>
                </div>
                <small class="text-muted">Auto-generated based on category</small>
              </div>
            </div>
          </div>

          <!-- Row 3: Description -->
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="ProductDescription" class="form-label">Description</label>
                <textarea class="form-control" id="ProductDescription" name="ProductDescription" 
                          rows="3" placeholder="Enter product description (optional)"></textarea>
              </div>
            </div>
          </div>

          <!-- Row 4: Status and Product ID Info -->
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="ProductStatus" class="form-label required">Status</label>
                <select class="form-select" id="ProductStatus" name="ProductStatus" required>
                  <option value="Active" selected>Active</option>
                  <option value="Inactive">Inactive</option>
                </select>
              </div>
            </div>
            
           
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-plus me-2"></i>Create Product
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Edit Product Modal --}}
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editProductForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <!-- Row 1: Supplier and Category -->
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_SupplierID" class="form-label required">Supplier</label>
                <select class="form-select" id="edit_SupplierID" name="SupplierID" required>
                  <option value="">Select Supplier</option>
                  @foreach($suppliers as $supplier)
                  <option value="{{ $supplier->SupplierID }}">
                    {{ $supplier->SupplierName }}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_CategoryID" class="form-label required">Category</label>
                <select class="form-select" id="edit_CategoryID" name="CategoryID" required>
                  <option value="">Select Category</option>
                  @foreach($categories as $category)
                  <option value="{{ $category->CategoryID }}">{{ $category->CategoryName }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <!-- Row 2: Product Name and SKU Number -->
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_ProductName" class="form-label required">Product Name</label>
                <input type="text" class="form-control" id="edit_ProductName" name="ProductName" required>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">SKU Number</label>
                <div class="form-control" style="background-color: #f8f9fa;">
                  <strong id="edit_SKUNumber_display"></strong>
                </div>
                <input type="hidden" id="edit_SKUNumber" name="SKUNumber">
              </div>
            </div>
          </div>

          <!-- Row 3: Description -->
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="edit_ProductDescription" class="form-label">Description</label>
                <textarea class="form-control" id="edit_ProductDescription" name="ProductDescription" rows="3"></textarea>
              </div>
            </div>
          </div>

          <!-- Row 4: Status and Product ID -->
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_ProductStatus" class="form-label required">Status</label>
                <select class="form-select" id="edit_ProductStatus" name="ProductStatus" required>
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                </select>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Product ID</label>
                <div class="form-control" style="background-color: #f8f9fa;">
                  <strong id="edit_ProductID_display"></strong>
                </div>
                <input type="hidden" id="edit_ProductID" name="ProductID">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Product</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="addCategoryModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{ route('admin.categories.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        
        <div class="modal-header">
          <h5 class="modal-title">Add New Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Category ID</label>
            <div class="id-info">
              <div class="text-muted">Auto-generated </div>
            </div>
          </div>
          
          <div class="mb-3">
            <label class="form-label required">Category Name</label>
            <input type="text" name="CategoryName" class="form-control" required 
                   placeholder="e.g., Toys, Gifts, Decorations" value="{{ old('CategoryName') }}">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">
            <i></i>Create Category
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- Edit Category Modal --}}
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editCategoryForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_CategoryID" class="form-label">Category ID</label>
            <div class="id-info">
              <div class="text-muted">Category ID cannot be changed</div>
            </div>
          </div>
          <div class="mb-3">
            <label for="edit_CategoryName" class="form-label required">Category Name</label>
            <input type="text" class="form-control" id="edit_CategoryName" name="CategoryName" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update Category</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Delete Product Confirmation Modal --}}
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteProductModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this product? This action cannot be undone.</p>
        <p><strong id="deleteProductName"></strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <form id="deleteProductForm" method="POST" style="display: inline;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Delete Product</button>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Delete Category Confirmation Modal --}}
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteCategoryModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this category? This action cannot be undone.</p>
        <p><strong id="deleteCategoryName"></strong></p>
        <div class="alert alert-warning">
          <i class="fas fa-exclamation-triangle me-2"></i>
          If there are products assigned to this category, they will become uncategorized.
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <form id="deleteCategoryForm" method="POST" style="display: inline;">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Delete Category</button>
        </form>
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

    // ========== FILTER DROPDOWN ==========
    const filterToggle = document.getElementById('filterToggle');
    const filterMenu = document.getElementById('filterMenu');
    const activeFilters = document.getElementById('activeFilters');
    const searchInput = document.getElementById('searchInput');
    const productsTableBody = document.getElementById('productsTableBody');
    
    // Store current filters
    let currentFilters = {
        categories: [],
        status: [],
        search: ''
    };
    
    // Filter toggle
    filterToggle?.addEventListener('click', function(e) {
        e.stopPropagation();
        const isVisible = filterMenu.style.display === 'block';
        filterMenu.style.display = isVisible ? 'none' : 'block';
        filterToggle.classList.toggle('active', !isVisible);
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        filterMenu.style.display = 'none';
        filterToggle.classList.remove('active');
    });
    
    // Prevent closing when clicking inside the filter menu
    filterMenu?.addEventListener('click', function(e) {
        e.stopPropagation();
    });
    
    // Search functionality
    searchInput?.addEventListener('input', function() {
        currentFilters.search = this.value.toLowerCase();
        filterProducts();
    });
    
    // Apply filters
    document.getElementById('applyFilters')?.addEventListener('click', function() {
        filterMenu.style.display = 'none';
        filterToggle.classList.remove('active');
        
        // Update current filters based on selections
        updateCurrentFilters();
        
        // Update active filters display
        updateActiveFilters();
        
        // Filter products
        filterProducts();
    });
    
    // Clear filters
    document.getElementById('clearFilters')?.addEventListener('click', function() {
        // Clear all checkboxes
        document.querySelectorAll('.filter-option input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        
        // Set default values
        document.getElementById('cat-all').checked = true;
        document.getElementById('status-all').checked = true;
        
        // Clear search
        searchInput.value = '';
        
        // Update current filters to defaults
        currentFilters = {
            categories: [],
            status: [],
            search: ''
        };
        
        // Update active filters
        updateActiveFilters();
        
        // Reset product display
        filterProducts();
    });
    
    function updateCurrentFilters() {
        // Update categories
        currentFilters.categories = [];
        if (document.getElementById('cat-all').checked) {
            // If "All Categories" is checked, collect all category names
            @foreach($categories as $cat)
                currentFilters.categories.push('{{ $cat->CategoryName }}');
            @endforeach
        } else {
            // Collect selected categories
            @foreach($categories as $cat)
                if (document.getElementById('cat-{{ $cat->CategoryID }}').checked) {
                    currentFilters.categories.push('{{ $cat->CategoryName }}');
                }
            @endforeach
        }
        
        // Update status
        currentFilters.status = [];
        if (document.getElementById('status-all').checked) {
            currentFilters.status.push('Active', 'Inactive');
        } else {
            if (document.getElementById('status-active').checked) {
                currentFilters.status.push('Active');
            }
            if (document.getElementById('status-inactive').checked) {
                currentFilters.status.push('Inactive');
            }
        }
    }
    
    function updateActiveFilters() {
        // Clear existing filter tags
        activeFilters.innerHTML = '';
        
        // Check if we have any non-default filters
        const hasCustomFilters = 
            currentFilters.categories.length !== {{ count($categories) }} ||
            currentFilters.status.length !== 2 ||
            currentFilters.search !== '';
        
        if (!hasCustomFilters) {
            // No custom filters applied, hide the active filters section
            activeFilters.classList.remove('has-filters');
            return;
        }
        
        // Show active filters section
        activeFilters.classList.add('has-filters');
        
        // Add category filter tags if not all are selected
        if (currentFilters.categories.length !== {{ count($categories) }}) {
            currentFilters.categories.forEach(category => {
                const categoryTag = createFilterTag(`Category: ${category}`, `category-${category.toLowerCase().replace(' ', '-')}`);
                activeFilters.appendChild(categoryTag);
            });
        }
        
        // Add status filter tags if not all are selected
        if (currentFilters.status.length !== 2) {
            currentFilters.status.forEach(status => {
                const statusTag = createFilterTag(`Status: ${status}`, `status-${status.toLowerCase()}`);
                activeFilters.appendChild(statusTag);
            });
        }
        
        // Add search filter tag if not empty
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
        // Remove the specific filter and update the UI
        if (filterType.startsWith('category-')) {
            const filterName = filterType.replace('category-', '').replace('-', ' ');
            const index = currentFilters.categories.indexOf(
                filterName.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
            );
            if (index > -1) {
                currentFilters.categories.splice(index, 1);
            }
        } else if (filterType.startsWith('status-')) {
            const filterName = filterType.replace('status-', '');
            const index = currentFilters.status.indexOf(
                filterName.charAt(0).toUpperCase() + filterName.slice(1)
            );
            if (index > -1) {
                currentFilters.status.splice(index, 1);
            }
        } else if (filterType === 'search') {
            currentFilters.search = '';
            searchInput.value = '';
        }
        
        // Update the checkboxes to reflect the change
        updateFilterInputs();
        
        // Update active filters display
        updateActiveFilters();
        
        // Refresh product display
        filterProducts();
    }
    
    function updateFilterInputs() {
        // Update category checkboxes
        document.getElementById('cat-all').checked = currentFilters.categories.length === {{ count($categories) }};
        
        // Update status checkboxes
        document.getElementById('status-all').checked = currentFilters.status.length === 2;
        document.getElementById('status-active').checked = currentFilters.status.includes('Active');
        document.getElementById('status-inactive').checked = currentFilters.status.includes('Inactive');
    }
    
    function filterProducts() {
        const rows = productsTableBody.getElementsByTagName('tr');
        let visibleCount = 0;
        
        for (let row of rows) {
            const productName = row.cells[1].textContent.toLowerCase();
            const productId = row.cells[0].textContent.toLowerCase();
            const category = row.cells[3].textContent.trim();
            const status = row.cells[5].textContent.trim();
            
            // Check search filter
            const searchMatch = currentFilters.search === '' || 
                               productName.includes(currentFilters.search) || 
                               productId.includes(currentFilters.search);
            
            // Check category filter
            const categoryMatch = currentFilters.categories.length === 0 || 
                                 currentFilters.categories.includes(category);
            
            // Check status filter
            const statusMatch = currentFilters.status.length === 0 || 
                               currentFilters.status.includes(status);
            
            // Show/hide row based on filters
            if (searchMatch && categoryMatch && statusMatch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        }
        
        // Update total count if needed
        const totalCountElement = document.querySelector('.text-muted');
        if (totalCountElement) {
            totalCountElement.textContent = `Total: ${visibleCount} product(s)`;
        }
    }
    
    // Initialize filtering on page load
    filterProducts();
    
    // Edit Product Modal
    const editProductButtons = document.querySelectorAll('.edit-product');
    editProductButtons.forEach(button => {
        button.addEventListener('click', function() {
            const form = document.getElementById('editProductForm');
            form.action = `/admin/products/${this.dataset.productId}`;
            
            document.getElementById('edit_ProductID').value = this.dataset.productId;
            document.getElementById('edit_ProductID_display').textContent = this.dataset.productId;
            document.getElementById('edit_ProductName').value = this.dataset.productName;
            document.getElementById('edit_ProductDescription').value = this.dataset.productDescription || '';
            document.getElementById('edit_CategoryID').value = this.dataset.categoryId || '';
            document.getElementById('edit_SupplierID').value = this.dataset.supplierId || '';
            document.getElementById('edit_SKUNumber').value = this.dataset.skuNumber;
            document.getElementById('edit_SKUNumber_display').textContent = this.dataset.skuNumber;
            document.getElementById('edit_ProductStatus').value = this.dataset.productStatus;
        });
    });
    
    // Delete Product Modal
    const deleteProductButtons = document.querySelectorAll('.delete-product');
    deleteProductButtons.forEach(button => {
        button.addEventListener('click', function() {
            const form = document.getElementById('deleteProductForm');
            form.action = `/admin/products/${this.dataset.productId}`;
            document.getElementById('deleteProductName').textContent = this.dataset.productName;
        });
    });
    
    // Edit Category Modal
    const editCategoryButtons = document.querySelectorAll('.edit-category');
    editCategoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const form = document.getElementById('editCategoryForm');
            form.action = `/admin/categories/${this.dataset.id}`;
            
            document.getElementById('edit_CategoryID').value = this.dataset.id;
            document.getElementById('edit_CategoryName').value = this.dataset.name;
        });
    });
    
    // Delete Category Modal
    const deleteCategoryButtons = document.querySelectorAll('.delete-category');
    deleteCategoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const form = document.getElementById('deleteCategoryForm');
            form.action = `/admin/categories/${this.dataset.id}`;
            document.getElementById('deleteCategoryName').textContent = this.dataset.name;
        });
    });
    
    // SKU Preview functionality
    document.getElementById('CategoryID')?.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const prefix = selected.dataset.prefix || selected.text.substring(0,3).toUpperCase();
        document.getElementById('skuPreview').textContent = prefix + 'XXXX';
    });
    
    // Auto-hide alerts after 5 seconds (like in employees page)
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
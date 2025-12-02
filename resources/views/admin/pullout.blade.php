<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Pullouts | Dora's Oshopee</title>

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

    /* Table styling */
    .table-card {
      border-radius: 12px;
      border: none;
      box-shadow: 0 2px 4px rgba(0,0,0,0.04);
    }
    
    .table th {
      border-top: none;
      font-weight: 600;
      color: #5b5f72;
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      padding: 12px 16px;
    }
    
    .table td {
      padding: 16px;
      vertical-align: middle;
      border-color: #f1f3f4;
    }
    
    .status-badge {
      padding: 0;
      border-radius: 0;
      font-size: 0.75rem;
      font-weight: 500;
      background-color: transparent !important;
  }

  .status-damaged {
      color: #e05252;
  }

  .status-expired {
      color: #f08a24;
  }

  .status-return {
      color: #23b07a;
  }

    /* Modal styling */
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
      color: #3b3183;
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

  {{-- Content --}}
  <main class="content-wrap">
    {{-- Topbar --}}
    <div class="topbar">
      <div class="d-flex align-items-center gap-3">
        <h4 class="mb-0">Pullouts Management</h4>
      </div>

      <div class="user-section">
        <!-- User Info Section with Dropdown -->
        <div class="user-dropdown">
          <button class="user-dropdown-toggle" id="userDropdownToggle">
            <img src="{{ asset('images/logo_.png') }}" alt="avatar" class="user-avatar">
            <div class="user-details">
              <div class="user-name">Dora</div>
              <div class="user-role">Admin</div>
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
              <input class="form-control" placeholder="Search pullout records..." />
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
                
                <!-- Reason Filters -->
                <div class="filter-section">
                  <div class="filter-section-title">Pullout Reason</div>
                  <div class="filter-options">
                    <div class="filter-option">
                      <input type="checkbox" id="reason-damaged" checked>
                      <label for="reason-damaged">Damaged</label>
                    </div>
                    <div class="filter-option">
                      <input type="checkbox" id="reason-expired" checked>
                      <label for="reason-expired">Expired</label>
                    </div>
                    <div class="filter-option">
                      <input type="checkbox" id="reason-return" checked>
                      <label for="reason-return">Return</label>
                    </div>
                    <div class="filter-option">
                      <input type="checkbox" id="reason-quality" checked>
                      <label for="reason-quality">Quality Control</label>
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

    {{-- Pullouts Table --}}
    <div class="card table-card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
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
                <th>Date Pulled Out</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
@php
    $pullOuts = isset($pullOuts) ? $pullOuts : collect([]);
@endphp

@forelse($pullOuts as $pullOut)
<tr>
    <td>
        <strong>#{{ $pullOut->PullOutID }}</strong>
    </td>
    <td>
        <div class="d-flex align-items-center">
            <div>
                <div style="font-weight:600">{{ $pullOut->product->ProdName ?? 'N/A' }}</div>
                <small class="text-muted">{{ $pullOut->product->ProdID ?? '' }}</small>
            </div>
        </div>
    </td>
    <td>
        <div style="font-weight:600">{{ $pullOut->employee->EmpFName ?? 'N/A' }} {{ $pullOut->employee->EmpLName ?? '' }}</div>
        <small class="text-muted">{{ $pullOut->employee->EmpID ?? '' }}</small>
    </td>
    <td>
        <div style="font-weight:600" class="text-danger">-{{ $pullOut->PullOutQty }}</div>
    </td>
    <td>
        @if($pullOut->PullOutReason === 'Damaged during handling')
            <span class="status-badge status-damaged">Damaged</span>
        @elseif($pullOut->PullOutReason === 'Expired products')
            <span class="status-badge status-expired">Expired</span>
        @else
            <span class="status-badge status-return">Return</span>
        @endif
    </td>
    <td>
        <small class="text-muted">{{ \Carbon\Carbon::parse($pullOut->DatePullOut)->format('M d, Y') }}</small>
    </td>
    <td>
        <div class="btn-group">
            <button class="btn btn-sm btn-outline-primary">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn btn-sm btn-outline-danger">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-center">No pullout records found</td>
</tr>
@endforelse
</tbody>
          </table>
        </div>

        {{-- Simple count --}}
        <div class="d-flex justify-content-between align-items-center mt-4">
          <div class="text-muted">
            Total: {{ count($pullOuts) }} record(s)
          </div>
        </div>
      </div>
    </div>
  </main>

  {{-- Add Pullout Modal --}}
  <div class="modal fade" id="addPulloutModal" tabindex="-1" aria-labelledby="addPulloutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addPulloutModalLabel">New Pullout</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('admin.pullout.store') }}" method="POST">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="ProductID" class="form-label">Product *</label>
                    <select class="form-select" id="ProductID" name="ProductID" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                        <option value="{{ $product->ProductID }}">{{ $product->ProductName }} ({{ $product->ProductID }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="EmployeeID" class="form-label">Employee *</label>
                    <select class="form-select" id="EmployeeID" name="EmployeeID" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                        <option value="{{ $employee->EmployeeID }}">{{ $employee->EmpFName }} {{ $employee->EmpLName }} ({{ $employee->EmployeeID }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="Qty" class="form-label">Quantity *</label>
                    <input type="number" class="form-control" id="Qty" name="Qty" min="1" required>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="Reason" class="form-label">Reason *</label>
                    <select class="form-select" id="Reason" name="Reason" required>
                        <option value="Damaged during handling">Damaged</option>
                        <option value="Expired products">Expired</option>
                        <option value="Customer return - defective">Customer Return</option>
                        <option value="Quality control rejection">Quality Control</option>
                    </select>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="DatePullOut" class="form-label">Date Pulled Out *</label>
                    <input type="date" class="form-control" id="DatePullOut" name="DatePullOut" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Add Pullout</button>
    </div>
</form>
{{-- Edit Pullout Modal --}}
<div class="modal fade" id="editPulloutModal" tabindex="-1" aria-labelledby="editPulloutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPulloutModalLabel">Edit Pullout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editPulloutForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Product *</label>
                                <select class="form-select" name="ProductID" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->ProductID }}">{{ $product->ProdName }} ({{ $product->ProductID }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Employee *</label>
                                <select class="form-select" name="EmployeeID" required>
                                    <option value="">Select Employee</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->EmployeeID }}">{{ $employee->EmpFName }} {{ $employee->EmpLName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Quantity *</label>
                                <input type="number" class="form-control" name="Qty" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Reason *</label>
                                <select class="form-select" name="Reason" required>
                                    <option value="Damaged during handling">Damaged</option>
                                    <option value="Expired products">Expired</option>
                                    <option value="Customer return - defective">Customer Return</option>
                                    <option value="Quality control rejection">Quality Control</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Date Pulled Out *</label>
                                <input type="date" class="form-control" name="DatePullOut" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Pullout</button>
                </div>
            </form>
        </div>
    </div>
</div>
      </div>
    </div>
  </div>

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
      reasons: ['Damaged', 'Expired', 'Return', 'Quality Control'],
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
      
      // Here you would typically refresh pullout data based on filters
      console.log('Filters applied - refreshing pullout data...');
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
      document.getElementById('reason-damaged').checked = true;
      document.getElementById('reason-expired').checked = true;
      document.getElementById('reason-return').checked = true;
      document.getElementById('reason-quality').checked = true;
      document.getElementById('category-all').checked = true;
      
      // Hide custom date range
      customDateRange.style.display = 'none';
      
      // Update current filters to defaults
      currentFilters = {
        timePeriod: 'This Week',
        reasons: ['Damaged', 'Expired', 'Return', 'Quality Control'],
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
      
      // Update reasons
      currentFilters.reasons = [];
      if (document.getElementById('reason-damaged').checked) {
        currentFilters.reasons.push('Damaged');
      }
      if (document.getElementById('reason-expired').checked) {
        currentFilters.reasons.push('Expired');
      }
      if (document.getElementById('reason-return').checked) {
        currentFilters.reasons.push('Return');
      }
      if (document.getElementById('reason-quality').checked) {
        currentFilters.reasons.push('Quality Control');
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
        currentFilters.reasons.length < 4 ||
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
      
      // Add reason filter tags if not all are selected
      if (currentFilters.reasons.length < 4) {
        currentFilters.reasons.forEach(reason => {
          const reasonTag = createFilterTag(reason, `reason-${reason.toLowerCase().replace(' ', '-')}`);
          activeFilters.appendChild(reasonTag);
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
      } else if (filterType.startsWith('reason-')) {
        const filterName = filterType.replace('reason-', '').replace('-', ' ');
        const index = currentFilters.reasons.indexOf(
          filterName.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
        );
        if (index > -1) {
          currentFilters.reasons.splice(index, 1);
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
      
      // Here you would typically refresh pullout data
      console.log('Filter removed - refreshing pullout data...');
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
      
      // Update reason checkboxes
      document.getElementById('reason-damaged').checked = currentFilters.reasons.includes('Damaged');
      document.getElementById('reason-expired').checked = currentFilters.reasons.includes('Expired');
      document.getElementById('reason-return').checked = currentFilters.reasons.includes('Return');
      document.getElementById('reason-quality').checked = currentFilters.reasons.includes('Quality Control');
      
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

    // Auto-set today's date
    document.getElementById('DatePullOut').value = new Date().toISOString().split('T')[0];
  </script>
</body>
</html>
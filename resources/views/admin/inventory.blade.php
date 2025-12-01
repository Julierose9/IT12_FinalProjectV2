<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Inventory Report | Dora's Oshoppe</title>

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
    
    /* Status Text - Updated for Inventory */
    .status-text {
      font-size: 0.875rem;
      font-weight: 500;
    }
    
    .status-instock { 
      color: #23b07a; 
    }
    
    .status-low { 
      color: #e05252; 
    }

    /* Stock Level Indicators */
    .stock-indicator {
      display: flex; align-items: center; gap: 6px; font-size: 0.85rem;
    }
    .stock-bar {
      width: 60px; height: 6px; background: #e9ecef; border-radius: 3px; overflow: hidden;
    }
    .stock-fill {
      height: 100%; border-radius: 3px;
    }
    .stock-high { background: var(--success-color); }
    .stock-medium { background: var(--warning-color); }
    .stock-low { background: var(--danger-color); }
    
    /* Alert badge for low stock */
    .alert-badge {
      background: #fde8e8; color: var(--danger-color); padding: 4px 8px;
      border-radius: 12px; font-size: 0.75rem; font-weight: 500; display: inline-flex;
      align-items: center; gap: 4px;
    }

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
    }
    
    @media (max-width: 575.98px) {
      .content-wrap { padding: 70px 8px 8px; }
      .table th, .table td { padding: 10px 6px; font-size: 0.85rem; }
      .action-buttons { flex-direction: column; }
      .stat-card { padding: 16px; }
      .stat-value { font-size: 1.5rem; }
    }
  </style>
</head>
<body>
@php
    // Create empty collections if variables don't exist
    $products = $products ?? collect([]);
    $categories = $categories ?? collect([]);
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
            <div class="collapse show" id="reportsSubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link" href="{{ route('admin.transaction') }}">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span>Transaction</span>
                    </a>
                    <a class="nav-link active" href="{{ route('admin.inventory') }}">
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
  <div class="topbar">
    <div class="page-title-section">
      <h4 class="mb-1">Inventory Report</h4>
      <small class="text-muted">Monitor stock levels across all products</small>
    </div>
    <div class="user-section">
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
          <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="user-dropdown-item"><i class="fas fa-sign-out-alt me-2"></i> Sign Out</button>
          </form>
        </div>
      </div>

      <div class="filter-container">
        <div class="search-filter-section">
          <div class="input-group search-input">
            <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
            <input type="text" class="form-control" placeholder="Search Product ID, Name, Category..." id="searchInput" value="{{ request('search') ?? '' }}">
          </div>
          <div class="filter-dropdown">
            <button class="filter-toggle" id="filterToggle"><i class="fas fa-filter"></i> Filter <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i></button>
            <div class="filter-menu" id="filterMenu">
              <!-- Stock Status Filter -->
              <div class="filter-section">
                <div class="filter-section-title">Stock Status</div>
                <div class="filter-options">
                  <div class="filter-option">
                    <input type="checkbox" id="status-all" 
                      {{ empty(request('status')) || in_array('all', request('status', [])) ? 'checked' : '' }}>
                    <label for="status-all">All Status</label>
                  </div>
                  <div class="filter-option">
                    <input type="checkbox" id="status-instock" 
                      {{ empty(request('status')) || in_array('instock', request('status', [])) ? 'checked' : '' }}>
                    <label for="status-instock">In Stock</label>
                  </div>
                  <div class="filter-option">
                    <input type="checkbox" id="status-low" 
                      {{ empty(request('status')) || in_array('low', request('status', [])) ? 'checked' : '' }}>
                    <label for="status-low">Low Stock</label>
                  </div>
                </div>
              </div>
              
              <!-- Category Filters -->
              <div class="filter-section">
                <div class="filter-section-title">Product Categories</div>
                <div class="filter-options">
                  <div class="filter-option">
                    <input type="checkbox" id="category-all" 
                      {{ empty(request('category')) || in_array('all', request('category', [])) ? 'checked' : '' }}>
                    <label for="category-all">All Categories</label>
                  </div>
                  @foreach($categories as $category)
                  <div class="filter-option">
                    <input type="checkbox" id="category-{{ $category->id }}" 
                      name="category[]" value="{{ $category->id }}"
                      {{ in_array($category->id, request('category', [])) ? 'checked' : '' }}>
                    <label for="category-{{ $category->id }}">{{ $category->CatName }}</label>
                  </div>
                  @endforeach
                </div>
              </div>
              
              <!-- Stock Level Filters -->
              <div class="filter-section">
                <div class="filter-section-title">Stock Level</div>
                <div class="filter-options">
                  <div class="filter-option">
                    <input type="radio" name="stock_level" id="stock-all" value="all"
                      {{ request('stock_level', 'all') == 'all' ? 'checked' : '' }}>
                    <label for="stock-all">All Levels</label>
                  </div>
                  <div class="filter-option">
                    <input type="radio" name="stock_level" id="stock-critical" value="critical"
                      {{ request('stock_level') == 'critical' ? 'checked' : '' }}>
                    <label for="stock-critical">Critical (Below Reorder)</label>
                  </div>
                  <div class="filter-option">
                    <input type="radio" name="stock_level" id="stock-medium" value="medium"
                      {{ request('stock_level') == 'medium' ? 'checked' : '' }}>
                    <label for="stock-medium">Medium Stock</label>
                  </div>
                  <div class="filter-option">
                    <input type="radio" name="stock_level" id="stock-high" value="high"
                      {{ request('stock_level') == 'high' ? 'checked' : '' }}>
                    <label for="stock-high">High Stock</label>
                  </div>
                </div>
              </div>
              
              <!-- Date Range Filter -->
              <div class="filter-section">
                <div class="filter-section-title">Last Updated Date</div>
                <div class="date-inputs">
                  <div class="date-input">
                    <small>From:</small>
                    <input type="date" name="date_from" id="dateFrom" value="{{ request('date_from') ?? '' }}">
                  </div>
                  <div class="date-input">
                    <small>To:</small>
                    <input type="date" name="date_to" id="dateTo" value="{{ request('date_to') ?? '' }}">
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



  {{-- Inventory Table --}}
  <div class="card table-card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h5 class="card-title mb-0">Inventory Status</h5>
        <div class="d-flex gap-2">
          <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->except(['export', 'page']), ['export' => 'csv'])) }}" 
             class="btn btn-success">
            <i class="fas fa-file-export me-2"></i>Export CSV
          </a>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Product ID</th>
              <th>Product</th>
              <th>Category</th>
              <th>Current Stock</th>
              <th>Reorder Level</th>
              <th>Status</th>
              <th>Last Updated</th>
            </tr>
          </thead>
          <tbody id="inventoryTableBody">
            @forelse($products as $product)
            <tr>
              <td>
                <strong>#{{ $product->ProdID ?? 'N/A' }}</strong>
              </td>
              <td>
                <div class="d-flex align-items-center">
                  <div>
                    <div style="font-weight:600">{{ $product->ProdName ?? 'Unknown Product' }}</div>
                    <small class="text-muted">SKU: {{ $product->ProdID ?? 'N/A' }}</small>
                  </div>
                </div>
              </td>
              <td>
                <div style="font-weight:600">{{ $product->category->CatName ?? 'Uncategorized' }}</div>
              </td>
              <td>
                <div class="stock-indicator">
                  <strong>{{ $product->CurrentStock ?? 0 }}</strong>
                  <div class="stock-bar">
                    @php
                      $stockPercentage = min(100, max(0, ($product->CurrentStock / max(1, $product->ReorderLvl * 3)) * 100));
                      $stockClass = '';
                      if ($product->CurrentStock <= $product->ReorderLvl) {
                        $stockClass = 'stock-low';
                      } elseif ($product->CurrentStock <= $product->ReorderLvl * 2) {
                        $stockClass = 'stock-medium';
                      } else {
                        $stockClass = 'stock-high';
                      }
                    @endphp
                    <div class="stock-fill {{ $stockClass }}" style="width: {{ $stockPercentage }}%"></div>
                  </div>
                </div>
              </td>
              <td>{{ $product->ReorderLvl ?? 0 }}</td>
              <td>
                @if(($product->CurrentStock ?? 0) <= ($product->ReorderLvl ?? 0))
                  <span class="status-text status-low">
                    <i class="fas fa-exclamation-triangle me-1"></i> Low Stock
                  </span>
                  @if(($product->CurrentStock ?? 0) == 0)
                    <span class="alert-badge ms-2">Out of Stock!</span>
                  @endif
                @else
                  <span class="status-text status-instock">
                    <i class="fas fa-check-circle me-1"></i> In Stock
                  </span>
                @endif
              </td>
              <td>
                <small class="text-muted">
                  @if(isset($product->updated_at))
                    {{ $product->updated_at->format('M d, Y H:i') }}
                  @else
                    {{ date('M d, Y') }}
                  @endif
                </small>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h5>No inventory data found</h5>
                <p class="text-muted">No products have been added to the inventory.</p>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
<div class="d-flex justify-content-between align-items-center mt-4">
  <div class="text-muted">
    @if(method_exists($products, 'total'))
      Total: {{ $products->total() }} product(s)
    @else
      Total: {{ $products->count() }} product(s)
    @endif
  </div>
  <div>
    @if(method_exists($products, 'links'))
      {{ $products->appends(request()->except('page'))->links() }}
    @endif
  </div>
</div>
  </div>

</main>

{{-- View Product Details Modal --}}
<div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewProductModalLabel">Product Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Product ID</label>
              <input type="text" class="form-control" id="viewProductId" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">SKU</label>
              <input type="text" class="form-control" id="viewProductSKU" readonly>
            </div>
          </div>
        </div>
        
        <div class="row mb-3">
          <div class="col-md-8">
            <div class="mb-3">
              <label class="form-label">Product Name</label>
              <input type="text" class="form-control" id="viewProductName" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Category</label>
              <input type="text" class="form-control" id="viewProductCategory" readonly>
            </div>
          </div>
        </div>
        
        <div class="row mb-3">
          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Current Stock</label>
              <input type="text" class="form-control" id="viewProductStock" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Reorder Level</label>
              <input type="text" class="form-control" id="viewProductReorder" readonly>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label class="form-label">Status</label>
              <input type="text" class="form-control" id="viewProductStatus" readonly>
            </div>
          </div>
        </div>
        
        <div class="row mb-3">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Price</label>
              <input type="text" class="form-control" id="viewProductPrice" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Total Value</label>
              <input type="text" class="form-control" id="viewProductValue" readonly>
            </div>
          </div>
        </div>
        
        <div class="mb-3">
          <label class="form-label">Stock Level Visualization</label>
          <div class="stock-visualization">
            <div class="d-flex justify-content-between mb-1">
              <small>0</small>
              <small id="viewProductReorderLabel">Reorder Level</small>
              <small id="viewProductHighLabel">High Stock</small>
            </div>
            <div class="progress" style="height: 20px;">
              <div class="progress-bar bg-success" id="viewProductStockBar" role="progressbar"></div>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Created</label>
              <input type="text" class="form-control" id="viewProductCreated" readonly>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Last Updated</label>
              <input type="text" class="form-control" id="viewProductUpdated" readonly>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <a href="#" class="btn btn-primary" id="editProductBtn">
          <i class="fas fa-edit me-2"></i>Edit Product
        </a>
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
    
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                applyFilters();
            }
        });
    }
    
    // Filter functionality
    const activeFilters = document.getElementById('activeFilters');
    const applyFiltersBtn = document.getElementById('applyFilters');
    const clearFiltersBtn = document.getElementById('clearFilters');
    
    // Initialize active filters from URL parameters
    updateActiveFiltersFromURL();
    
    // Apply filters
    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', function() {
            applyFilters();
        });
    }
    
    // Clear filters
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', function() {
            clearFilters();
        });
    }
    
    function applyFilters() {
        const params = new URLSearchParams();
        
        // Search
        if (searchInput.value) {
            params.set('search', searchInput.value);
        }
        
        // Status
        const statuses = [];
        if (document.getElementById('status-instock').checked) {
            statuses.push('instock');
        }
        if (document.getElementById('status-low').checked) {
            statuses.push('low');
        }
        if (statuses.length > 0 && !document.getElementById('status-all').checked) {
            params.set('status', statuses.join(','));
        }
        
        // Categories
        const categories = [];
        document.querySelectorAll('input[name="category[]"]:checked').forEach(cb => {
            if (cb.value !== 'all') {
                categories.push(cb.value);
            }
        });
        if (categories.length > 0 && !document.getElementById('category-all').checked) {
            params.set('category', categories.join(','));
        }
        
        // Stock level
        const stockLevel = document.querySelector('input[name="stock_level"]:checked');
        if (stockLevel && stockLevel.value !== 'all') {
            params.set('stock_level', stockLevel.value);
        }
        
        // Date range
        const dateFrom = document.getElementById('dateFrom').value;
        const dateTo = document.getElementById('dateTo').value;
        if (dateFrom) params.set('date_from', dateFrom);
        if (dateTo) params.set('date_to', dateTo);
        
        // Redirect with filters
        window.location.href = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
    }
    
    function clearFilters() {
        window.location.href = window.location.pathname;
    }
    
    function updateActiveFiltersFromURL() {
        const params = new URLSearchParams(window.location.search);
        const filters = [];
        
        // Search
        if (params.get('search')) {
            filters.push({
                type: 'search',
                text: 'Search: ' + params.get('search')
            });
        }
        
        // Status
        const statuses = params.get('status');
        if (statuses) {
            const statusTexts = statuses.split(',').map(s => s === 'instock' ? 'In Stock' : 'Low Stock');
            filters.push({
                type: 'status',
                text: 'Status: ' + statusTexts.join(', ')
            });
        }
        
        // Categories
        const categories = params.get('category');
        if (categories) {
            // In a real app, you would fetch category names from the server
            filters.push({
                type: 'category',
                text: 'Categories: ' + categories.split(',').length + ' selected'
            });
        }
        
        // Stock level
        const stockLevel = params.get('stock_level');
        if (stockLevel && stockLevel !== 'all') {
            const levelTexts = {
                'critical': 'Critical Stock',
                'medium': 'Medium Stock',
                'high': 'High Stock'
            };
            filters.push({
                type: 'stock_level',
                text: 'Stock Level: ' + (levelTexts[stockLevel] || stockLevel)
            });
        }
        
        // Date range
        const dateFrom = params.get('date_from');
        const dateTo = params.get('date_to');
        if (dateFrom || dateTo) {
            const fromText = dateFrom ? new Date(dateFrom).toLocaleDateString() : 'Any';
            const toText = dateTo ? new Date(dateTo).toLocaleDateString() : 'Any';
            filters.push({
                type: 'date',
                text: 'Date: ' + fromText + ' to ' + toText
            });
        }
        
        // Update active filters display
        if (filters.length > 0) {
            activeFilters.classList.add('has-filters');
            activeFilters.innerHTML = filters.map(filter => 
                `<div class="filter-tag">
                    <span>${filter.text}</span>
                    <button class="filter-tag-remove" data-type="${filter.type}">×</button>
                </div>`
            ).join('');
            
            // Add remove functionality
            document.querySelectorAll('.filter-tag-remove').forEach(btn => {
                btn.addEventListener('click', function() {
                    const type = this.dataset.type;
                    const params = new URLSearchParams(window.location.search);
                    
                    if (type === 'search') {
                        params.delete('search');
                        searchInput.value = '';
                    } else if (type === 'status') {
                        params.delete('status');
                        document.getElementById('status-all').checked = true;
                        document.getElementById('status-instock').checked = true;
                        document.getElementById('status-low').checked = true;
                    } else if (type === 'category') {
                        params.delete('category');
                        document.getElementById('category-all').checked = true;
                    } else if (type === 'stock_level') {
                        params.delete('stock_level');
                        document.getElementById('stock-all').checked = true;
                    } else if (type === 'date') {
                        params.delete('date_from');
                        params.delete('date_to');
                        document.getElementById('dateFrom').value = '';
                        document.getElementById('dateTo').value = '';
                    }
                    
                    window.location.href = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
                });
            });
        } else {
            activeFilters.classList.remove('has-filters');
            activeFilters.innerHTML = '';
        }
    }
    
    // View Product Modal (sample functionality - would need actual product data)
    const viewProductModal = document.getElementById('viewProductModal');
    if (viewProductModal) {
        viewProductModal.addEventListener('show.bs.modal', function(event) {
            // This would be populated with actual product data from the server
            // For now, just showing sample data
            const button = event.relatedTarget;
            const productId = button.getAttribute('data-product-id') || 'PRD-001';
            
            document.getElementById('viewProductId').value = productId;
            document.getElementById('viewProductSKU').value = productId;
            document.getElementById('viewProductName').value = 'Sample Product';
            document.getElementById('viewProductCategory').value = 'Sample Category';
            document.getElementById('viewProductStock').value = '45';
            document.getElementById('viewProductReorder').value = '20';
            document.getElementById('viewProductStatus').value = 'In Stock';
            document.getElementById('viewProductPrice').value = '₱299.99';
            document.getElementById('viewProductValue').value = '₱13,499.55';
            document.getElementById('viewProductCreated').value = 'Nov 1, 2025';
            document.getElementById('viewProductUpdated').value = 'Nov 26, 2025 16:44';
            
            // Stock visualization
            const stockBar = document.getElementById('viewProductStockBar');
            stockBar.style.width = '75%';
            stockBar.textContent = '45 units';
            
            document.getElementById('viewProductReorderLabel').textContent = 'Reorder (20)';
            document.getElementById('viewProductHighLabel').textContent = 'High (60)';
            
            // Set edit button URL
            document.getElementById('editProductBtn').href = '/admin/products/' + productId + '/edit';
        });
    }
    
    // Show success/error messages
    @if(session('success'))
        showAlert('success', '{{ session('success') }}');
    @endif
    
    @if(session('error'))
        showAlert('error', '{{ session('error') }}');
    @endif
    
    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.style.position = 'fixed';
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '1050';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }
});
</script>
</body>
</html>
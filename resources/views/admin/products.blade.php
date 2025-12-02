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
    .status-badge { padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 500; }
    .status-active { background: #e8f5e8; color: var(--success-color); }
    .status-inactive { background: #f8f9fa; color: var(--danger-color); }

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
    }
    @media (max-width: 575.98px) {
      .content-wrap { padding: 70px 8px 8px; }
      .table th, .table td { padding: 10px 6px; font-size: 0.85rem; }
      .action-buttons { flex-direction: column; }
    }
  </style>
</head>
<body>
@php
    // Create empty collection if $recentStock doesn't exist
    $recentStock = $recentStock ?? collect([]);
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
  <div class="topbar">
    <div class="page-title-section">
      <h4 class="mb-1">Products Management</h4>
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
            <input type="text" class="form-control" placeholder="Search products..." id="searchInput">
          </div>
          <div class="filter-dropdown">
            <button class="filter-toggle" id="filterToggle"><i class="fas fa-filter"></i> Filter <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i></button>
            <div class="filter-menu" id="filterMenu">
              <div class="filter-section">
                <div class="filter-section-title">Category</div>
                <div class="filter-options">
                  <div class="filter-option"><input type="checkbox" id="cat-all" checked><label for="cat-all">All Categories</label></div>
                  @foreach($categories as $cat)
                    <div class="filter-option"><input type="checkbox" id="cat-{{ $cat->CategoryID }}"><label for="cat-{{ $cat->CategoryID }}">{{ $cat->CategoryName }}</label></div>
                  @endforeach
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

  <!-- Tabs -->
  <ul class="nav nav-tabs mb-4" id="productsTabs" role="tablist">
    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#categories"><i></i>Categories</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#pricing"><i ></i>Pricing</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#products"><i></i>Products</button></li>
  </ul>

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
              <thead><tr><th>Category ID</th><th>Name</th><th>Products</th><th>Created</th><th>Actions</th></tr></thead>
              <tbody id="categoriesTableBody">
                @foreach($categories as $category)
                <tr data-category="{{ $category->CategoryName }}">
                  <td><strong>{{ $category->CategoryID }}</strong></td>
                  <td><div style="font-weight:600">{{ $category->CategoryName }}</div></td>
                  <td><span class="badge bg-primary">{{ $category->products_count ?? 0 }}</span></td>
                  <td><small class="text-muted">{{ $category->created_at->format('M d, Y') }}</small></td>
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

      {{-- Pricing Tab --}}
      <div class="tab-pane fade" id="pricing" role="tabpanel">
        <div class="card table-card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h5 class="card-title mb-0">Product Pricing</h5>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updatePricingModal">
                <i class="fas fa-edit me-2"></i>Update Pricing
              </button>
            </div>

            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>SKU Number</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Retail Price</th>
                    <th>Cost Price</th>
                    <th>Markup Rate</th>
                    <th>Effective Date</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($products as $product)
                  @if($product->pricing)
                  <tr>
                    <td><strong>#{{ $product->SKUNumber }}</strong></td>
                    <td>{{ $product->ProductName }}</td>
                    <td><span class="badge bg-light text-dark">{{ $product->category->CategoryName ?? 'Uncategorized' }}</span></td>
                    <td><strong>₱{{ number_format($product->pricing->RetailPrice, 2) }}</strong></td>
                    <td>₱{{ number_format($product->pricing->OriginalPrice, 2) }}</td>
                    <td>
                      <span class="{{ $product->pricing->MarkupRate >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ number_format($product->pricing->MarkupRate, 1) }}%
                      </span>
                    </td>
                    <td>{{ $product->pricing->EffectiveDate->format('M d, Y') }}</td>
                    <td>
                      <button class="btn btn-sm btn-outline-primary update-single-price" 
                              data-bs-toggle="modal" 
                              data-bs-target="#updateSinglePriceModal"
                              data-product-id="{{ $product->SKUNumber }}"
                              data-product-name="{{ $product->ProductName }}"
                              data-retail-price="{{ $product->pricing->RetailPrice }}"
                              data-cost-price="{{ $product->pricing->OriginalPrice }}">
                        <i class="fas fa-edit"></i>
                      </button>
                    </td>
                  </tr>
                  @endif
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
                    <th>SKU Number</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Reorder Level</th>
                    <th>Supplier</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="productsTableBody">
                  @foreach($products as $product)
                  <tr>
                    <td>
                      <strong>#{{ $product->SKUNumber }}</strong>
                    </td>
                    <td>
                      <div class="d-flex align-items-center">
                        <div>
                          <div style="font-weight:600">{{ $product->ProductName }}</div>
                          <small class="text-muted">{{ Str::limit($product->ProductDescription, 30) }}</small>
                        </div>
                      </div>
                    </td>
                    <td>
                      <span class="badge bg-light text-dark">{{ $product->category->CategoryName ?? 'Uncategorized' }}</span>
                    </td>
                    <td>
                      <span class="text-muted">{{ $product->ReorderLevel }}</span>
                    </td>
                    <td>
                      <small class="text-muted">{{ $product->supplier->SupplierName ?? 'N/A' }}</small>
                    </td>
                    <td>
                      @if($product->ProductStatus === 'Inactive')
                        <span class="status-badge status-inactive">Inactive</span>
                      @else
                        <span class="status-badge status-active">Active</span>
                      @endif
                    </td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-sm btn-outline-primary edit-product" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editProductModal"
                                data-product-id="{{ $product->SKUNumber }}"
                                data-product-name="{{ $product->ProductName }}"
                                data-product-description="{{ $product->ProductDescription }}"
                                data-category-id="{{ $product->CategoryID }}"
                                data-reorder-level="{{ $product->ReorderLevel }}"
                                data-supplier-id="{{ $product->SupplierID }}"
                                data-product-status="{{ $product->ProductStatus }}">
                          <i class="fas fa-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger delete-product" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteProductModal"
                                data-product-id="{{ $product->SKUNumber }}"
                                data-product-name="{{ $product->ProductName }}">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            {{-- Recent Stock Ins Section --}}
            <div class="card mt-4">
              <div class="card-body">
                <h5 class="card-title mb-3">Recent Stock Ins</h5>
                <div class="table-responsive">
                  <table class="table table-sm">
                    <thead>
                      <tr>
                        <th>Stock In ID</th>
                        <th>Product</th>
                        <th>Supplier</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Date Received</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($recentStock as $stock)
                      <tr>
                        <td>{{ $stock->StockInID }}</td>
                        <td>{{ $stock->product->ProductName ?? 'N/A' }}</td>
                        <td>{{ $stock->supplier->SupplierName ?? 'N/A' }}</td>
                        <td>{{ $stock->Qty }}</td>
                        <td>
                          <span class="badge {{ $stock->ProdStatus == 'Received' ? 'bg-success' : ($stock->ProdStatus == 'Defective' ? 'bg-danger' : 'bg-warning') }}">
                            {{ $stock->ProdStatus }}
                          </span>
                        </td>
                        <td>{{ $stock->DateRcvd->format('M d, Y') }}</td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="6" class="text-center">No recent stock records</td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            {{-- Simple product count --}}
            <div class="d-flex justify-content-between align-items-center mt-4">
              <div class="text-muted">
                Total: {{ count($products) }} product(s)
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
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ProductName" class="form-label">Product Name *</label>
                                <input type="text" class="form-control" id="ProductName" name="ProductName" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="SKUNumber" class="form-label">SKU Number *</label>
                                <input type="text" class="form-control" id="SKUNumber" name="SKUNumber" required>
                                <small class="text-muted">Unique identifier for the product</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="ProductDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="ProductDescription" name="ProductDescription" rows="2"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="CategoryID" class="form-label">Category *</label>
                                <select class="form-select" id="CategoryID" name="CategoryID" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->CategoryID }}">{{ $category->CategoryName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="SupplierID" class="form-label">Supplier *</label>
                                <select class="form-select" id="SupplierID" name="SupplierID" required>
                                    <option value="">Select Supplier</option>
                                    @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->SupplierID }}">{{ $supplier->SupplierName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ReorderLevel" class="form-label">Reorder Level</label>
                                <input type="number" class="form-control" id="ReorderLevel" name="ReorderLevel" min="0" value="10">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ProductStatus" class="form-label">Status</label>
                                <select class="form-select" id="ProductStatus" name="ProductStatus" required>
                                    <option value="Active" selected>Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="OriginalPrice" class="form-label">Cost Price *</label>
                                <input type="number" class="form-control" id="OriginalPrice" name="OriginalPrice" min="0" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="RetailPrice" class="form-label">Retail Price *</label>
                                <input type="number" class="form-control" id="RetailPrice" name="RetailPrice" min="0" step="0.01" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="initial_quantity" class="form-label">Initial Stock Quantity (Optional)</label>
                                <input type="number" class="form-control" id="initial_quantity" name="initial_quantity" min="0" value="0">
                                <small class="text-muted">Add initial stock for this product. Can be added later in Stock In.</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Product</button>
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
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="edit_ProductName" class="form-label">Product Name *</label>
                  <input type="text" class="form-control" id="edit_ProductName" name="ProductName" required>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="edit_SKUNumber" class="form-label">SKU Number *</label>
                  <input type="text" class="form-control" id="edit_SKUNumber" name="SKUNumber" readonly>
                  <small class="text-muted">SKU Number cannot be changed</small>
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="edit_ProductDescription" class="form-label">Description</label>
              <textarea class="form-control" id="edit_ProductDescription" name="ProductDescription" rows="3"></textarea>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="edit_CategoryID" class="form-label">Category</label>
                  <select class="form-select" id="edit_CategoryID" name="CategoryID">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->CategoryID }}">{{ $category->CategoryName }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="edit_ReorderLevel" class="form-label">Reorder Level *</label>
                  <input type="number" class="form-control" id="edit_ReorderLevel" name="ReorderLevel" min="0" required>
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="mb-3">
                  <label for="edit_ProductStatus" class="form-label">Status</label>
                  <select class="form-select" id="edit_ProductStatus" name="ProductStatus">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="edit_SupplierID" class="form-label">Supplier</label>
              <select class="form-select" id="edit_SupplierID" name="SupplierID">
                <option value="">Select Supplier</option>
                @foreach($suppliers as $supplier)
                <option value="{{ $supplier->SupplierID }}">{{ $supplier->SupplierName }}</option>
                @endforeach
              </select>
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

  {{-- Update Pricing Modal (Bulk) --}}
  <div class="modal fade" id="updatePricingModal" tabindex="-1" aria-labelledby="updatePricingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updatePricingModalLabel">Update Product Pricing</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('admin.products.update-pricing') }}" method="POST" id="updatePricingForm">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="pricingProduct" class="form-label">Select Product</label>
              <select class="form-select" id="pricingProduct" name="product_id" required>
                <option value="">Select Product</option>
                @foreach($products as $product)
                @if($product->pricing)
                <option value="{{ $product->SKUNumber }}" 
                        data-retail-price="{{ $product->pricing->RetailPrice }}" 
                        data-cost-price="{{ $product->pricing->OriginalPrice }}">
                  {{ $product->ProductName }} (Current: ₱{{ number_format($product->pricing->RetailPrice, 2) }})
                </option>
                @endif
                @endforeach
              </select>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="newRetailPrice" class="form-label">New Retail Price *</label>
                  <input type="number" class="form-control" id="newRetailPrice" name="retail_price" min="0" step="0.01" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="newCostPrice" class="form-label">New Cost Price *</label>
                  <input type="number" class="form-control" id="newCostPrice" name="original_price" min="0" step="0.01" required>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Update Pricing</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Update Single Product Price Modal --}}
  <div class="modal fade" id="updateSinglePriceModal" tabindex="-1" aria-labelledby="updateSinglePriceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateSinglePriceModalLabel">Update Price</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateSinglePriceForm" method="POST">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Product</label>
              <input type="text" class="form-control" id="singleProductName" readonly>
              <input type="hidden" id="singleProductId" name="product_id">
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="singleNewRetailPrice" class="form-label">New Retail Price *</label>
                  <input type="number" class="form-control" id="singleNewRetailPrice" name="retail_price" min="0" step="0.01" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="singleNewCostPrice" class="form-label">New Cost Price *</label>
                  <input type="number" class="form-control" id="singleNewCostPrice" name="original_price" min="0" step="0.01" required>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Update Price</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Add Category Modal --}}
  <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('admin.categories.store') }}" method="POST" id="addCategoryForm">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="CategoryName" class="form-label">Category Name *</label>
              <input type="text" class="form-control" id="CategoryName" name="CategoryName" required>
            </div>
            <div class="mb-3">
              <label for="CategoryID" class="form-label">Category ID *</label>
              <input type="text" class="form-control" id="CategoryID" name="CategoryID" required>
              <small class="text-muted">e.g., CAT007</small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Create Category</button>
          </div>
        </form>
      </div>
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
              <label for="edit_CategoryName" class="form-label">Category Name *</label>
              <input type="text" class="form-control" id="edit_CategoryName" name="CategoryName" required>
            </div>
            <div class="mb-3">
              <label for="edit_CategoryID" class="form-label">Category ID *</label>
              <input type="text" class="form-control" id="edit_CategoryID" name="CategoryID" readonly>
              <small class="text-muted">Category ID cannot be changed</small>
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
    <div="modal-dialog">
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
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#productsTableBody tr');
            
            rows.forEach(row => {
                const productName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const sku = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                
                if (productName.includes(searchTerm) || sku.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Edit Product Modal
    const editProductButtons = document.querySelectorAll('.edit-product');
    editProductButtons.forEach(button => {
        button.addEventListener('click', function() {
            const form = document.getElementById('editProductForm');
            form.action = `/admin/products/${this.dataset.productId}`;
            
            document.getElementById('edit_SKUNumber').value = this.dataset.productId;
            document.getElementById('edit_ProductName').value = this.dataset.productName;
            document.getElementById('edit_ProductDescription').value = this.dataset.productDescription || '';
            document.getElementById('edit_CategoryID').value = this.dataset.categoryId || '';
            document.getElementById('edit_ReorderLevel').value = this.dataset.reorderLevel;
            document.getElementById('edit_SupplierID').value = this.dataset.supplierId || '';
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
    
    // Update Single Price Modal
    const updateSinglePriceButtons = document.querySelectorAll('.update-single-price');
    updateSinglePriceButtons.forEach(button => {
        button.addEventListener('click', function() {
            const form = document.getElementById('updateSinglePriceForm');
            form.action = `/admin/products/${this.dataset.productId}/update-pricing`;
            
            document.getElementById('singleProductId').value = this.dataset.productId;
            document.getElementById('singleProductName').value = this.dataset.productName;
            document.getElementById('singleNewRetailPrice').value = this.dataset.retailPrice;
            document.getElementById('singleNewCostPrice').value = this.dataset.costPrice;
        });
    });
    
    // Update Pricing Modal - Auto fill prices
    const pricingProductSelect = document.getElementById('pricingProduct');
    if (pricingProductSelect) {
        pricingProductSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                document.getElementById('newRetailPrice').value = selectedOption.dataset.retailPrice;
                document.getElementById('newCostPrice').value = selectedOption.dataset.costPrice;
            }
        });
    }
    
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
</html>
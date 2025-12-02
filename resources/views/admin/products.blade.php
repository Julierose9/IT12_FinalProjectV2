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
    /* Search & Filter - Left aligned version */
    .filter-container {
        display: flex;
        flex-direction: column;
        gap: 8px;
        width: 100%;
    }

    .search-filter-section {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-input {
        max-width: 400px;
        width: 100%;
        min-width: 250px;
        flex: 1;
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
        flex-shrink: 0;
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
        padding: 16px;
        min-width: 240px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-top: 8px;
        display: none;
        z-index: 1000;
    }

    .filter-menu.show {
        display: block;
    }

    .active-filters {
        display: none;
        gap: 8px;
        flex-wrap: wrap;
        width: 100%;
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
    }

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
    <!-- Top Header: Title + User (fixed) -->
    <div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="mb-0 fw-semibold">Products Management</h4>

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
  </div>

  <!-- Tabs + Search Filter Row — perfectly aligned -->
  <div class=" border-2 pb-2 mb-4">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
      <!-- Tabs on the left -->
      <ul class="nav nav-tabs mb-0" id="productsTabs" role="tablist">
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

      <!-- Search + Filter on the right -->
      <div class="d-flex align-items-center gap-3">
        <div class="input-group" style="width: 320px;">
          <span class="input-group-text bg-white border-end-0">
            <i class="fas fa-search text-muted"></i>
          </span>
          <input type="text" class="form-control border-start-0" placeholder="Search products..." id="searchInput">
        </div>

        <div class="filter-dropdown position-relative">
          <button class="btn btn-outline-secondary d-flex align-items-center gap-2 filter-toggle" id="filterToggle">
            <i class="fas fa-filter"></i>  <span>Filter</span>
            <i class="fas fa-chevron-down small"></i>
          </button>

          <div class="filter-menu position-absolute end-0 mt-2 bg-white border rounded-3 shadow-lg p-3" id="filterMenu"
               style="width:280px; display:none; z-index:1050;">
            <h6 class="fw-bold mb-3">Filter by Category</h6>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="cat-all" checked>
              <label class="form-check-label small" for="cat-all">All Categories</label>
            </div>
            @foreach($categories as $cat)
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="cat-{{ $cat->CategoryID }}">
              <label class="form-check-label small" for="cat-{{ $cat->CategoryID }}">{{ $cat->CategoryName }}</label>
            </div>
            @endforeach
            <hr class="my-3">
            <div >
              <button class="btn btn-primary btn-sm flex-fill" id="applyFilters">Apply</button>
              <button class="btn btn-outline-secondary btn-sm flex-fill" id="clearFilters">Clear</button>
            </div>
          </div>
        </div>
      </div>
    </div>
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
                <tr>
                  <td>
                    <strong>{{ $product->ProductID }}</strong>
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
                    <strong>#{{ $product->SKUNumber }}</strong>
                  </td>
                  <td>
                    <span class="badge bg-light text-dark">{{ $product->category->CategoryName ?? 'Uncategorized' }}</span>
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
                              data-product-id="{{ $product->ProductID }}"
                              data-product-name="{{ $product->ProductName }}"
                              data-product-description="{{ $product->ProductDescription }}"
                              data-category-id="{{ $product->CategoryID }}"
                              data-supplier-id="{{ $product->SupplierID }}"
                              data-sku-number="{{ $product->SKUNumber }}"
                              data-product-status="{{ $product->ProductStatus }}">
                        <i class="fas fa-pencil"></i>
                      </button>
                      <button class="btn btn-sm btn-outline-danger delete-product" 
                              data-bs-toggle="modal" 
                              data-bs-target="#deleteProductModal"
                              data-product-id="{{ $product->ProductID }}"
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
                <label class="form-label">Product ID</label>
                <div class="id-info">
                    <div class="text-muted">Auto-generated </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="ProductName" class="form-label">Product Name *</label>
                <input type="text" class="form-control" id="ProductName" name="ProductName" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="CategoryID" class="form-label">Category *</label>
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
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="SupplierID" class="form-label">Supplier *</label>
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
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">SKU Preview</label>
                <div class="form-control" style="background-color: #f8f9fa;">
                    <div id="skuPreview" class="text-muted">Select a category to preview SKU</div>
                </div>
                <small class="text-muted">Auto-generated based on category prefix</small>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="ProductStatus" class="form-label">Status *</label>
                <select class="form-select" id="ProductStatus" name="ProductStatus" required>
                    <option value="Active" selected>Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label for="ProductDescription" class="form-label">Description</label>
        <textarea class="form-control" id="ProductDescription" name="ProductDescription" rows="3"></textarea>
    </div>

    <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">
            <i></i>Create Product
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
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_ProductName" class="form-label">Product Name *</label>
                <input type="text" class="form-control" id="edit_ProductName" name="ProductName" required>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_CategoryID" class="form-label">Category *</label>
                <select class="form-select" id="edit_CategoryID" name="CategoryID" required>
                  <option value="">Select Category</option>
                  @foreach($categories as $category)
                  <option value="{{ $category->CategoryID }}">{{ $category->CategoryName }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_SKUNumber" class="form-label">SKU Number</label>
                <div class="form-control" style="background-color: #f8f9fa;">
                  <strong id="edit_SKUNumber_display"></strong>
                </div>
                <input type="hidden" id="edit_SKUNumber" name="SKUNumber">
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_ProductStatus" class="form-label">Status *</label>
                <select class="form-select" id="edit_ProductStatus" name="ProductStatus" required>
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                </select>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="edit_ProductDescription" class="form-label">Description</label>
            <textarea class="form-control" id="edit_ProductDescription" name="ProductDescription" rows="3"></textarea>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_SupplierID" class="form-label">Supplier *</label>
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
          
            <label class="form-label">Category Name <span class="text-danger">*</span></label>
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
            <label for="edit_CategoryID" class="form-label">Category ID </label>
            <div class="id-info">
                    <div class="text-muted">Category ID cannot be changed </div>
                </div>
          </div>
          <div class="mb-3">
            <label for="edit_CategoryName" class="form-label">Category Name *</label>
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

    filterToggle?.addEventListener('click', function (e) {
        e.stopPropagation();
        filterMenu.style.display = filterMenu.style.display === 'block' ? 'none' : 'block';
        filterToggle.classList.toggle('active');
    });

    // Close filter when clicking outside
    document.addEventListener('click', function () {
        filterMenu.style.display = 'none';
        filterToggle.classList.remove('active');
    });

    // Prevent closing when clicking inside filter menu
    filterMenu?.addEventListener('click', function (e) {
        e.stopPropagation();
    });
    
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#productsTableBody tr');
            
            rows.forEach(row => {
                const productName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const sku = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const productId = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                
                if (productName.includes(searchTerm) || sku.includes(searchTerm) || productId.includes(searchTerm)) {
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
    const categorySelect = document.getElementById('CategoryID');
    const skuPreview = document.getElementById('skuPreview');
    
    if (categorySelect && skuPreview) {
        categorySelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const prefix = selectedOption.dataset.prefix;
            
            if (prefix) {
                skuPreview.innerHTML = ` (Auto-generated)`;
            } else {
                skuPreview.textContent = 'Select a category to preview SKU';
            }
        });
    }
    
    // Auto-capitalize SKU prefix in category forms
    document.getElementById('CategoryPrefix')?.addEventListener('input', function() {
        this.value = this.value.toUpperCase().substring(0, 3);
    });

    document.getElementById('edit_CategoryPrefix')?.addEventListener('input', function() {
        this.value = this.value.toUpperCase().substring(0, 3);
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
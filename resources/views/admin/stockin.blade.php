<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Stock In | Dora's Oshoppe</title>
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
    .page-title-section h4 { margin-bottom: 4px; color: var(--primary-color); }
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

    /* Tabs */
    .nav-tabs {
      border-bottom: 1px solid #eef2f7;
      margin-bottom: 24px;
    }
    .nav-tabs .nav-link { 
      color: #5b5f72; 
      border: none; 
      padding: 12px 20px; 
      font-weight: 500;
      border-radius: 8px 8px 0 0;
      margin-right: 4px;
      transition: all 0.2s ease;
    }
    .nav-tabs .nav-link:hover {
      color: var(--primary-color);
      background-color: rgba(239, 234, 255, 0.3);
    }
    .nav-tabs .nav-link.active { 
      color: var(--primary-color); 
      background-color: #efeaff; 
      border-bottom: 2px solid var(--primary-color); 
    }

    /* Table */
    .table-card { 
      border-radius: 12px; 
      border: none; 
      box-shadow: var(--card-shadow); 
      overflow: hidden; 
      margin-bottom: 24px;
    }
    .table-card .card-body {
      padding: 24px;
    }
    .table th { 
      font-weight: 600; 
      color: #5b5f72; 
      font-size: 0.85rem; 
      text-transform: uppercase;
      letter-spacing: 0.5px; 
      padding: 12px 16px; 
      white-space: nowrap; 
      background: #f8f9fa;
      border-bottom: 1px solid #eef2f7;
    }
    .table td { 
      padding: 16px; 
      vertical-align: middle; 
      border-color: #f1f3f4; 
    }
    .table-hover tbody tr:hover {
      background-color: rgba(59, 49, 131, 0.03);
    }

    /* Badges */
    .badge {
      font-weight: 500;
      padding: 5px 10px;
    }
    .badge.bg-success { background-color: var(--success-color) !important; }
    .badge.bg-warning { background-color: var(--warning-color) !important; }
    .badge.bg-danger { background-color: var(--danger-color) !important; }
    .badge.bg-primary { background-color: var(--primary-color) !important; }

    /* Forms */
    .form-label {
      font-weight: 500;
      font-size: 0.9rem;
      margin-bottom: 6px;
      color: #5b5f72;
    }
    .form-control, .form-select {
      border-radius: 8px;
      border: 1px solid #dee2e6;
      padding: 10px 12px;
      font-size: 0.95rem;
      transition: all 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.2rem rgba(59, 49, 131, 0.1);
    }
    
    /* Buttons */
    .btn {
      border-radius: 8px;
      padding: 10px 16px;
      font-weight: 500;
      font-size: 0.9rem;
      transition: all 0.2s ease;
    }
    .btn-primary {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
    }
    .btn-primary:hover {
      background-color: #2a2462;
      border-color: #2a2462;
    }
    .btn-outline-primary {
      color: var(--primary-color);
      border-color: var(--primary-color);
    }
    .btn-outline-primary:hover {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
    }
    .btn-sm {
      padding: 6px 12px;
      font-size: 0.85rem;
    }

    /* Action Cards */
    .action-card {
      border-radius: 12px;
      border: none;
      box-shadow: var(--card-shadow);
      transition: all 0.3s ease;
      overflow: hidden;
      background: white;
      height: 100%;
      cursor: pointer;
    }
    .action-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 12px rgba(0,0,0,0.08);
    }
    .action-card .card-body {
      padding: 30px;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }
    .action-card-icon {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
      font-size: 28px;
    }
    .action-card-title {
      font-weight: 600;
      color: var(--primary-color);
      margin-bottom: 10px;
    }
    .action-card-text {
      color: var(--secondary-color);
      font-size: 0.9rem;
      margin-bottom: 20px;
    }

    /* Responsive */
    @media (max-width: 991.98px) {
      .sidebar { 
        transform: translateX(-100%); 
        width: 280px; 
        box-shadow: 2px 0 10px rgba(0,0,0,0.1); 
      }
      .sidebar.mobile-open { transform: translateX(0); }
      .sidebar-toggle, .sidebar-overlay { display: block; }
      .content-wrap { 
        margin-left: 0; 
        padding: 70px 16px 16px; 
      }
      .topbar { 
        flex-direction: column; 
        align-items: stretch; 
      }
      .user-section, .filter-container { 
        align-items: stretch; 
        min-width: 100%; 
      }
      .nav-tabs .nav-link {
        padding: 10px 12px;
        font-size: 0.9rem;
      }
    }
    @media (max-width: 575.98px) {
      .content-wrap { padding: 70px 8px 8px; }
      .table th, .table td { padding: 10px 6px; font-size: 0.85rem; }
      .action-buttons { flex-direction: column; }
      .nav-tabs .nav-link {
        padding: 8px 10px;
        font-size: 0.85rem;
      }
    }
    @media (max-width: 400px) {
      .sidebar {
        width: 250px;
      }
      .brand img {
        width: 35px;
        height: 35px;
      }
      .sidebar .nav-link {
        padding: 10px 6px;
        font-size: 0.9rem;
      }
      .action-card .card-body {
        padding: 20px;
      }
      .nav-tabs {
        flex-wrap: nowrap;
        overflow-x: auto;
      }
      .nav-tabs .nav-link {
        white-space: nowrap;
      }
    }
  </style>
</head>
<body>

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

            <a class="nav-link dropdown-toggle active" href="#" data-bs-toggle="collapse" data-bs-target="#transactionsSubmenu">
                <i class="fas fa-exchange-alt"></i>
                <span>Inventory</span>
            </a>
            <div class="collapse show" id="transactionsSubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link active" href="{{ route('admin.stockin') }}">
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
      <h4 class="mb-1">Stock In Management</h4>
      <small class="text-muted">Receive and manage inventory items</small>
    </div>
    <div class="user-section">
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
          <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="user-dropdown-item"><i class="fas fa-sign-out-alt me-2"></i> Sign Out</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Tabs -->
  <ul class="nav nav-tabs mb-4" id="stockinTabs" role="tablist">
    <li class="nav-item">
      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#stockRecords">
        <i class="fas fa-list me-2"></i>Stock Records
      </button>
    </li>
    <li class="nav-item">
      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#stockActions">
        <i class="fas fa-plus-circle me-2"></i>Add Stock
      </button>
    </li>
  </ul>

  <div class="tab-content">
    <!-- Stock Records Tab -->
    <div class="tab-pane fade show active" id="stockRecords">
      <div class="card table-card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title mb-0">Recent Stock Ins</h5>
            <div class="btn-group">
              <button class="btn btn-outline-primary btn-sm active" id="showAllStock">All</button>
              <button class="btn btn-outline-primary btn-sm" id="showExistingStock">Existing</button>
              <button class="btn btn-outline-primary btn-sm" id="showNewStock">New</button>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-hover" id="stockInTable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Type</th>
                  <th>Product/Item</th>
                  <th>Supplier</th>
                  <th>Qty</th>
                  <th>Status</th>
                  <th>Date Received</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($stockIns as $stock)
                <tr class="{{ $stock->ProductID ? 'existing-product' : 'new-item' }}">
                  <td><strong>#{{ $stock->StockInID }}</strong></td>
                  <td>
                    @if($stock->ProductID)
                      <span class="badge bg-success">Existing</span>
                    @else
                      <span class="badge bg-warning">New Item</span>
                    @endif
                  </td>
                  <td>
                    @if($stock->ProductID)
                      <div>
                        <div style="font-weight:600">{{ $stock->product->ProductName ?? 'N/A' }}</div>
                        <small class="text-muted">SKU: {{ $stock->product->SKUNumber ?? 'N/A' }}</small>
                      </div>
                    @else
                      <div>
                        <div style="font-weight:600">{{ $stock->temp_product_name ?? 'New Item' }}</div>
                        <small class="text-muted">Temp SKU: {{ $stock->temp_sku ?? 'TEMP' }}</small>
                      </div>
                    @endif
                  </td>
                  <td>{{ $stock->supplier->SupplierName ?? 'N/A' }}</td>
                  <td><span class="badge bg-primary">{{ $stock->Qty }}</span></td>
                  <td>
                    <span class="badge 
                      @if($stock->ProdStatus == 'Good') bg-success
                      @elseif($stock->ProdStatus == 'Damaged') bg-danger
                      @else bg-warning @endif">
                      {{ $stock->ProdStatus }}
                    </span>
                  </td>
                  <td>{{ \Carbon\Carbon::parse($stock->DateRevd)->format('M d, Y') }}</td>
                  <td>
                    @if(!$stock->ProductID)
                      <a href="{{ route('admin.products') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-exchange-alt me-1"></i>Convert
                      </a>
                    @else
                      <button class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-eye me-1"></i>View
                      </button>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          @if($stockIns->count() == 0)
            <div class="text-center py-5">
              <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
              <h5>No Stock Records Found</h5>
              <p class="text-muted">Start by adding stock to existing products or creating new items.</p>
            </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Stock Actions Tab -->
    <div class="tab-pane fade" id="stockActions" role="tabpanel">
      <div class="row">
        <div class="col-md-6 mb-4">
          <div class="action-card" data-bs-toggle="modal" data-bs-target="#existingProductModal">
            <div class="card-body">
              <div class="action-card-icon" style="background: #e8f5e9; color: var(--success-color);">
                <i class="fas fa-box"></i>
              </div>
              <h5 class="action-card-title">Stock Existing Product</h5>
              <p class="action-card-text">Add stock to products already in your catalog</p>
              <button class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Add Stock
              </button>
            </div>
          </div>
        </div>
        
        <div class="col-md-6 mb-4">
          <div class="action-card" data-bs-toggle="modal" data-bs-target="#newItemModal">
            <div class="card-body">
              <div class="action-card-icon" style="background: #fff3e0; color: var(--warning-color);">
                <i class="fas fa-plus-circle"></i>
              </div>
              <h5 class="action-card-title">Stock New Item</h5>
              <p class="action-card-text">Receive new items not yet in your product catalog</p>
              <button class="btn btn-primary">
                <i class="fas fa-box me-2"></i>Stock New Item
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

{{-- Modal: Stock Existing Product --}}
<div class="modal fade" id="existingProductModal" tabindex="-1" aria-labelledby="existingProductModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="existingProductModalLabel">
          <i class="fas fa-box me-2"></i>Stock Existing Product
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.stockin.existing') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="existingProductID" class="form-label">Select Product *</label>
            <select class="form-select" id="existingProductID" name="ProductID" required>
              <option value="">Choose a product...</option>
              @foreach($existingProducts as $product)
              <option value="{{ $product->ProductID }}">
                {{ $product->SKUNumber }} - {{ $product->ProductName }}
              </option>
              @endforeach
            </select>
          </div>
          
          <div class="mb-3">
            <label for="existingSupplierID" class="form-label">Supplier *</label>
            <select class="form-select" id="existingSupplierID" name="SupplierID" required>
              <option value="">Select Supplier</option>
              @foreach($suppliers as $supplier)
              <option value="{{ $supplier->SupplierID }}">{{ $supplier->SupplierName }}</option>
              @endforeach
            </select>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="existingQty" class="form-label">Quantity *</label>
                <input type="number" class="form-control" id="existingQty" name="Qty" min="1" required>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="mb-3">
                <label for="existingProdStatus" class="form-label">Status</label>
                <select class="form-select" id="existingProdStatus" name="ProdStatus">
                  <option value="Good">Good</option>
                  <option value="Damaged">Damaged</option>
                  <option value="Expired">Expired</option>
                  <option value="Returned">Returned</option>
                </select>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="existingDateRevd" class="form-label">Date Received *</label>
            <input type="date" class="form-control" id="existingDateRevd" name="DateRevd" value="{{ date('Y-m-d') }}" required>
          </div>

          <div class="mb-3">
            <label for="existingRemarks" class="form-label">Remarks</label>
            <textarea class="form-control" id="existingRemarks" name="Remarks" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Add Stock</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Modal: Stock New Item --}}
<div class="modal fade" id="newItemModal" tabindex="-1" aria-labelledby="newItemModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newItemModalLabel">
          <i class="fas fa-plus-circle me-2"></i>Stock New Item
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.stockin.newitem') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="alert alert-info mb-3">
            <i class="fas fa-info-circle me-2"></i>
            This item will be available in the "Products" page to convert to a permanent product.
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="newProductName" class="form-label">Product Name *</label>
                <input type="text" class="form-control" id="newProductName" name="ProductName" required>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="mb-3">
                <label for="newSKUNumber" class="form-label">SKU Number *</label>
                <div class="input-group">
                  <input type="text" class="form-control" id="newSKUNumber" name="SKUNumber" required>
                  <button type="button" class="btn btn-outline-secondary" onclick="generateTempSKU()">
                    <i class="fas fa-sync-alt"></i>
                  </button>
                </div>
                <small class="text-muted">Assign a temporary SKU</small>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="newProductDescription" class="form-label">Description</label>
            <textarea class="form-control" id="newProductDescription" name="ProductDescription" rows="2"></textarea>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="newCategoryID" class="form-label">Suggested Category</label>
                <select class="form-select" id="newCategoryID" name="CategoryID">
                  <option value="">Select Category</option>
                  @foreach($categories as $category)
                  <option value="{{ $category->CategoryID }}">{{ $category->CategoryName }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="mb-3">
                <label for="newSupplierID" class="form-label">Supplier *</label>
                <select class="form-select" id="newSupplierID" name="SupplierID" required>
                  <option value="">Select Supplier</option>
                  @foreach($suppliers as $supplier)
                  <option value="{{ $supplier->SupplierID }}">{{ $supplier->SupplierName }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="newQty" class="form-label">Quantity *</label>
                <input type="number" class="form-control" id="newQty" name="Qty" min="1" required>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="mb-3">
                <label for="newProdStatus" class="form-label">Status</label>
                <select class="form-select" id="newProdStatus" name="ProdStatus">
                  <option value="Good">Good</option>
                  <option value="Damaged">Damaged</option>
                </select>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="mb-3">
                <label for="newDateRevd" class="form-label">Date Received *</label>
                <input type="date" class="form-control" id="newDateRevd" name="DateRevd" value="{{ date('Y-m-d') }}" required>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="newCostPrice" class="form-label">Cost Price</label>
            <div class="input-group">
              <span class="input-group-text">₱</span>
              <input type="number" class="form-control" id="newCostPrice" name="CostPrice" min="0" step="0.01">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Stock Item</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Mobile sidebar toggle
  const sidebar = document.getElementById('sidebar');
  const toggle = document.getElementById('sidebarToggle');
  const overlay = document.getElementById('sidebarOverlay');
  
  toggle.addEventListener('click', () => {
    sidebar.classList.toggle('mobile-open');
    overlay.classList.toggle('active');
    document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
  });
  
  overlay.addEventListener('click', () => {
    sidebar.classList.remove('mobile-open');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  });

  // User dropdown
  document.getElementById('userDropdownToggle')?.addEventListener('click', function(e) {
    e.stopPropagation();
    document.getElementById('userDropdownMenu').classList.toggle('show');
  });

  // Close dropdowns when clicking outside
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.user-dropdown')) {
      document.getElementById('userDropdownMenu')?.classList.remove('show');
    }
  });

  // Table filtering
  document.getElementById('showAllStock')?.addEventListener('click', function() {
    document.querySelectorAll('#stockInTable tbody tr').forEach(tr => tr.style.display = '');
    updateActiveButtons(this);
  });
  
  document.getElementById('showExistingStock')?.addEventListener('click', function() {
    document.querySelectorAll('#stockInTable tbody tr').forEach(tr => {
      tr.style.display = tr.classList.contains('existing-product') ? '' : 'none';
    });
    updateActiveButtons(this);
  });
  
  document.getElementById('showNewStock')?.addEventListener('click', function() {
    document.querySelectorAll('#stockInTable tbody tr').forEach(tr => {
      tr.style.display = tr.classList.contains('new-item') ? '' : 'none';
    });
    updateActiveButtons(this);
  });

  function updateActiveButtons(activeButton) {
    document.querySelectorAll('.btn-group .btn').forEach(btn => {
      btn.classList.remove('active');
    });
    activeButton.classList.add('active');
  }

  // Generate temporary SKU
  function generateTempSKU() {
    const name = document.getElementById('newProductName').value.trim();
    let initials = 'TEMP';
    
    if (name) {
      initials = name.split(' ')
        .map(word => word.charAt(0).toUpperCase())
        .join('')
        .substring(0, 3);
    }
    
    const randomNum = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
    document.getElementById('newSKUNumber').value = `${initials}-${randomNum}`;
  }

  // Auto-generate temp SKU when product name is entered
  document.getElementById('newProductName')?.addEventListener('blur', function() {
    if (!document.getElementById('newSKUNumber').value) {
      generateTempSKU();
    }
  });

  // Tab switching with URL hash
  document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash;
    if (hash) {
      const tabBtn = document.querySelector(`button[data-bs-target="${hash}"]`);
      if (tabBtn) {
        new bootstrap.Tab(tabBtn).show();
      }
    }
    
    // Update URL hash when tabs are clicked
    document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(tab => {
      tab.addEventListener('shown.bs.tab', function(e) {
        window.location.hash = e.target.getAttribute('data-bs-target');
      });
    });
  });
</script>
</body>
</html>
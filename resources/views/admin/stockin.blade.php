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

        body { 
            font-family: 'Poppins', sans-serif; 
            background: var(--light-bg);
            padding-top: 0;
        }

        /* ========== SIDEBAR STYLES ========== */
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

        .sidebar.collapsed { min-width: 70px; max-width: 70px; }
        .sidebar.collapsed .brand-text,
        .sidebar.collapsed .nav-link span:not(.fa),
        .sidebar.collapsed .nav-link .fa-chevron-down { display: none; }
        .sidebar.collapsed .brand { justify-content: center; }
        .sidebar.collapsed .nav-link { justify-content: center; text-align: center; }
        .sidebar.collapsed .nav-link i { margin-right: 0; }

        .brand { display: flex; align-items: center; gap: 10px; margin-bottom: 18px; flex-shrink: 0; }
        .brand img { width: 40px; height: 40px; object-fit: contain; }
        .brand-text { flex: 1; }

        .sidebar .nav-link { 
            color: #5b5f72; padding: 12px 8px; border-radius: 10px; font-size: 0.95rem;
            display: flex; align-items: center; transition: all 0.2s ease;
        }
        .sidebar .nav-link.active { background: #efeaff; color: var(--primary-color); font-weight: 600; }
        .sidebar .nav-link:hover { background: #f8f9fa; transform: translateX(2px); }
        .sidebar .nav-link i { width: 20px; margin-right: 10px; text-align: center; }

        .sidebar-nav { flex: 1; overflow-y: auto; margin-top: 18px; }
        .nav .nav.flex-column.ms-3 { border-left: 2px solid #eef2f7; margin-left: 12px !important; padding-left: 8px; }
        .nav .nav.flex-column.ms-3 .nav-link { padding: 10px 12px; font-size: 0.9rem; border-radius: 6px; }

        .sidebar-toggle { display: none; position: fixed; top: 15px; left: 15px; z-index: 1001;
            background: var(--primary-color); color: white; border: none; border-radius: 8px;
            width: 40px; height: 40px; align-items: center; justify-content: center; font-size: 1.2rem; }
        .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); z-index: 999; }

        /* ========== CONTENT AREA ========== */
        .content-wrap { margin-left: 240px; padding: 28px; transition: all 0.3s ease; }
        .content-wrap.expanded { margin-left: 0; }

        .topbar { display: flex; gap: 16px; align-items: flex-start; justify-content: space-between;
            margin-bottom: 22px; flex-wrap: wrap; }
        .page-title-section { flex: 1; min-width: 250px; }

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
        .filter-section-title { font-weight: 600; font-size: 0.875rem; margin-bottom: 8px; color: var(--primary-color); }
        .filter-option { display: flex; align-items: center; gap: 8px; padding: 6px 0; cursor: pointer; }
        .filter-option label { cursor: pointer; font-size: 0.875rem; margin: 0; }

        .filter-actions { display: flex; gap: 8px; margin-top: 12px; padding-top: 12px; border-top: 1px solid #eef2f7; }
        .btn-apply, .btn-clear { flex: 1; border: none; padding: 8px 16px; border-radius: 4px; font-size: 0.875rem; cursor: pointer; }
        .btn-apply { background: var(--primary-color); color: white; }
        .btn-apply:hover { background: #2a2265; }
        .btn-clear { background: var(--secondary-color); color: white; }
        .btn-clear:hover { background: #5a6268; }

        .active-filters { display: none; align-items: center; gap: 8px; margin-bottom: 16px; flex-wrap: wrap; width: 100%; justify-content: flex-end; }
        .active-filters.has-filters { display: flex; }
        .filter-tag { background: #e9ecef; border: 1px solid #dee2e6; border-radius: 16px; padding: 4px 12px;
            font-size: 0.8rem; display: flex; align-items: center; gap: 6px; }
        .filter-tag-remove { background: none; border: none; cursor: pointer; color: var(--secondary-color);
            padding: 0; width: 16px; height: 16px; display: flex; align-items: center; justify-content: center; }

        /* ========== TABLE ========== */
        .table-card { border-radius: 12px; border: none; box-shadow: var(--card-shadow); overflow: hidden; }
        .table th { border-top: none; font-weight: 600; color: #5b5f72; font-size: 0.85rem; text-transform: uppercase;
            letter-spacing: 0.5px; padding: 12px 16px; white-space: nowrap; }
        .table td { padding: 16px; vertical-align: middle; border-color: #f1f3f4; }
        .status-badge { padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 500; white-space: nowrap; }
        .status-good { background: #d4edda; color: var(--success-color); }
        .status-damaged { background: #f8d7da; color: var(--danger-color); }

        .action-buttons { display: flex; gap: 4px; flex-wrap: nowrap; }
        .action-buttons .btn { padding: 6px 8px; font-size: 0.8rem; }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 991.98px) {
            .sidebar { position: fixed; transform: translateX(-100%); z-index: 1000; width: 280px; max-width: 280px; box-shadow: 2px 0 10px rgba(0,0,0,0.1); }
            .sidebar.mobile-open { transform: translateX(0); }
            .sidebar-toggle, .sidebar-overlay { display: flex !important; }
            .content-wrap { margin-left: 0; padding: 70px 16px 16px; }
            .topbar { flex-direction: column; align-items: stretch; gap: 20px; }
            .user-section, .search-filter-section { min-width: 100%; }
        }

        @media (max-width: 575.98px) {
            .content-wrap { padding: 70px 8px 8px; }
            .table th, .table td { padding: 10px 6px; font-size: 0.85rem; }
        }
    </style>
</head>
<body>

<!-- Mobile Sidebar Toggle -->
<button class="sidebar-toggle" id="sidebarToggle">
    <i class="fas fa-bars"></i>
</button>
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
            <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
            <a class="nav-link" href="{{ route('admin.accounts') }}"><i class="fas fa-user-circle"></i> <span>Accounts</span></a>

            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#recordsSubmenu">
                <i class="fas fa-archive"></i> <span>Records</span>
            </a>
            <div class="collapse" id="recordsSubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link" href="{{ route('admin.supplier') }}"><i class="fas fa-truck"></i> <span>Suppliers</span></a>
                    <a class="nav-link" href="{{ route('admin.employees') }}"><i class="fas fa-users"></i> <span>Employees</span></a>
                    <a class="nav-link" href="{{ route('admin.products') }}"><i class="fas fa-box"></i> <span>Products</span></a>
                </div>
            </div>

            <a class="nav-link dropdown-toggle active" href="#" data-bs-toggle="collapse" data-bs-target="#inventorySubmenu">
                <i class="fas fa-exchange-alt"></i> <span>Inventory</span>
            </a>
            <div class="collapse show" id="inventorySubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link active" href="{{ route('admin.stockin') }}"><i class="fas fa-arrow-circle-down"></i> <span>Stock In</span></a>
                    <a class="nav-link" href="{{ route('admin.pullout') }}"><i class="fas fa-arrow-circle-up"></i> <span>Pullouts</span></a>
                </div>
            </div>

            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#reportsSubmenu">
                <i class="fas fa-chart-bar"></i> <span>Reports</span>
            </a>
            <div class="collapse" id="reportsSubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link" href="{{ route('admin.transaction') }}"><i class="fas fa-file-invoice-dollar"></i> <span>Transaction</span></a>
                    <a class="nav-link" href="{{ route('admin.inventory') }}"><i class="fas fa-clipboard-list"></i> <span>Inventory</span></a>
                </div>
            </div>
        </nav>
    </div>
</aside>

<main class="content-wrap" id="contentWrap">
    <div class="topbar">
        <div class="page-title-section">
            <h4 class="mb-1">Stock In Management</h4>
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

            <div class="filter-container">
                <div class="search-filter-section">
                    <div class="input-group search-input">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search stock records..." id="searchInput">
                    </div>

                    <div class="filter-dropdown">
                        <button class="filter-toggle" id="filterToggle">
                            <i class="fas fa-filter"></i> <span>Filter</span>
                            <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
                        </button>

                        <div class="filter-menu" id="filterMenu">
                            <div class="filter-section">
                                <div class="filter-section-title">Item Type</div>
                                <div class="filter-options">
                                    <div class="filter-option"><input type="checkbox" id="type-all" checked><label for="type-all">All Types</label></div>
                                    <div class="filter-option"><input type="checkbox" id="type-existing"><label for="type-existing">Existing Product</label></div>
                                    <div class="filter-option"><input type="checkbox" id="type-new"><label for="type-new">New Item</label></div>
                                </div>
                            </div>

                            <div class="filter-section">
                                <div class="filter-section-title">Condition</div>
                                <div class="filter-options">
                                    <div class="filter-option"><input type="checkbox" id="status-all" checked><label for="status-all">All Conditions</label></div>
                                    <div class="filter-option"><input type="checkbox" id="status-good"><label for="status-good">Good</label></div>
                                    <div class="filter-option"><input type="checkbox" id="status-damaged"><label for="status-damaged">Damaged</label></div>
                                    <div class="filter-option"><input type="checkbox" id="status-expired"><label for="status-expired">Expired</label></div>
                                </div>
                            </div>

                            <div class="filter-actions">
                                <button class="btn-apply" id="applyFilters">Apply Filters</button>
                                <button class="btn-clear" id="clearFilters">Reset Filters</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="active-filters" id="activeFilters"></div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card table-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <h5 class="card-title mb-0">Stock In Records</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStockModal">
                    <i class="fas fa-plus me-2"></i>Add Stock
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="stockTable">
                    <thead class="table-light">
                        <tr>
                            <th>#ID</th>
                            <th>Type</th>
                            <th>Product / Item</th>
                            <th>Supplier</th>
                            <th>Qty</th>
                            <th>Status</th>
                            <th>Date Received</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stockIns as $stock)
                        <tr data-type="{{ $stock->ProductID ? 'existing' : 'new' }}" data-status="{{ $stock->ProdStatus }}">
                            <td><strong>#{{ $stock->StockInID }}</strong></td>
                            <td>
                                @if($stock->ProductID)
                                    <span class="badge bg-success">Existing</span>
                                @else
                                    <span class="badge bg-warning text-dark">New Item</span>
                                @endif
                            </td>
                            <td>
                                @if($stock->ProductID)
                                    <div class="fw-semibold">{{ $stock->product->ProductName }}</div>
                                    <small class="text-muted">SKU: {{ $stock->product->SKUNumber }}</small>
                                @else
                                    <div class="fw-semibold">{{ $stock->temp_product_name ?? 'New Item' }}</div>
                                    <small class="text-muted">Temp SKU: {{ $stock->temp_sku ?? '—' }}</small>
                                @endif
                            </td>
                            <td>{{ $stock->supplier->SupplierName ?? '—' }}</td>
                            <td><span class="badge bg-primary fs-6">{{ $stock->Qty }}</span></td>
                            <td>
                                <span class="badge bg-{{ $stock->ProdStatus == 'Good' ? 'success' : 'danger' }}">
                                    {{ $stock->ProdStatus }}
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($stock->DateRevd)->format('M d, Y') }}</td>
                            <td>
                                @if(!$stock->ProductID)
                                    <a href="{{ route('admin.products') }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-exchange-alt"></i> Convert
                                    </a>
                                @else
                                    <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-eye"></i></button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <h5>No stock records found</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Unified Add Stock Modal -->
<div class="modal fade" id="addStockModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-3">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold"><i ></i>Add Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.stockin.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Product Selection -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Product <span class="text-danger">*</span></label>
                        <select class="form-select" id="productSelect" name="ProductID" required>
                            <option value="">→ Stock Existing Product</option>
                            @foreach($existingProducts as $p)
                                <option value="{{ $p->ProductID }}"
                                    data-price="{{ $p->pricing?->OriginalPrice ?? 0 }}"
                                    data-markup="{{ $p->pricing?->MarkupRate ?? 25 }}">
                                    {{ $p->SKUNumber }} - {{ $p->ProductName }}
                                </option>
                            @endforeach
                            <option value="new">+ Stock New Product / Item</option>
                        </select>
                    </div>

                    <!-- New Product Fields -->
                    <div id="newProductFields" style="display:none;">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="newProductName">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">SKU Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="newSKUNumber" placeholder="e.g. ITEM001">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description (optional)</label>
                                <textarea class="form-control" name="newDescription" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Pricing -->
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">Cost Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" step="0.01" class="form-control" id="originalPrice" name="OriginalPrice" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Markup (%) <span class="text-danger">*</span></label>
                            <input type="number" step="0.1" class="form-control" id="markupRate" value="25">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Retail Price</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control fw-bold text-success" id="retailPrice" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-4">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" min="1" class="form-control" name="Qty" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date Received <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="DateRevd" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" name="ProdStatus" required>
                                <option value="Good">Good</option>
                                <option value="Damaged">Damaged</option>
                                <option value="Expired">Expired</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Supplier <span class="text-danger">*</span></label>
                            <select class="form-select" name="SupplierID" required>
                                <option value="">Choose supplier...</option>
                                @foreach($suppliers as $s)
                                    <option value="{{ $s->SupplierID }}">{{ $s->SupplierName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Reorder Level</label>
                            <input type="number" class="form-control" name="ReorderLevel" value="10">
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Expiration Date (optional)</label>
                        <input type="date" class="form-control" name="ExpirationDate">
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Add Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>
</main>

<!-- Add Stock Modal (unchanged from your original) -->
<div class="modal fade" id="addStockModal" tabindex="-1"> ... </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Same JS as Suppliers page (adapted for Stock In)
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const contentWrap = document.getElementById('contentWrap');

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
    

    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('mobile-open');
        sidebarOverlay.classList.toggle('active');
        document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
    });

    sidebarOverlay.addEventListener('click', () => {
        sidebar.classList.remove('mobile-open');
        sidebarOverlay.classList.remove('active');
        document.body.style.overflow = '';
    });

    // Close sidebar on link click (mobile)
    document.querySelectorAll('.sidebar .nav-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 992) {
                sidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // Filter system
    const filterToggle = document.getElementById('filterToggle');
    const filterMenu = document.getElementById('filterMenu');
    const activeFilters = document.getElementById('activeFilters');
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('stockTableBody');
    const totalCount = document.getElementById('totalCount');

    let currentFilters = { type: ['All Types'], status: ['All Conditions'], search: '' };

    filterToggle.addEventListener('click', e => {
        e.stopPropagation();
        const visible = filterMenu.style.display === 'block';
        filterMenu.style.display = visible ? 'none' : 'block';
        filterToggle.classList.toggle('active', !visible);
    });

    document.getElementById('applyFilters').addEventListener('click', () => {
        filterMenu.style.display = 'none';
        filterToggle.classList.remove('active');
        updateCurrentFilters();
        updateActiveFilters();
        filterRows();
    });

    document.getElementById('clearFilters').addEventListener('click', () => {
        document.querySelectorAll('.filter-option input[type="checkbox"]').forEach(cb => cb.checked = cb.id.includes('-all'));
        searchInput.value = '';
        currentFilters = { type: ['All Types'], status: ['All Conditions'], search: '' };
        updateActiveFilters();
        filterRows();
    });

    searchInput.addEventListener('input', () => {
        currentFilters.search = searchInput.value.toLowerCase();
        filterRows();
    });

    function updateCurrentFilters() {
        currentFilters.type = document.getElementById('type-all').checked ? ['All Types'] : 
            ['existing', 'new'].filter(t => document.getElementById('type-'+t).checked);

        currentFilters.status = document.getElementById('status-all').checked ? ['All Conditions'] :
            ['Good', 'Damaged', 'Expired'].filter(s => document.getElementById('status-'+s.toLowerCase()).checked);
    }

    function updateActiveFilters() {
        activeFilters.innerHTML = '';
        const hasFilters = currentFilters.search || 
            currentFilters.type[0] !== 'All Types' || 
            currentFilters.status[0] !== 'All Conditions';

        if (!hasFilters) return activeFilters.classList.remove('has-filters');

        activeFilters.classList.add('has-filters');

        if (currentFilters.search) {
            activeFilters.innerHTML += `<div class="filter-tag">Search: "${currentFilters.search}" <button class="filter-tag-remove" data-filter="search">×</button></div>`;
        }
        currentFilters.type.filter(t => t !== 'All Types').forEach(t => {
            activeFilters.innerHTML += `<div class="filter-tag">Type: ${t === 'existing' ? 'Existing' : 'New Item'} <button class="filter-tag-remove" data-filter="type-${t}">×</button></div>`;
        });
        currentFilters.status.filter(s => s !== 'All Conditions').forEach(s => {
            activeFilters.innerHTML += `<div class="filter-tag">Status: ${s} <button class="filter-tag-remove" data-filter="status-${s.toLowerCase()}">×</button></div>`;
        });

        activeFilters.querySelectorAll('.filter-tag-remove').forEach(btn => {
            btn.addEventListener('click', () => {
                const f = btn.dataset.filter;
                if (f === 'search') { searchInput.value = ''; currentFilters.search = ''; }
                else if (f.startsWith('type-')) {
                    const val = f.split('-')[1];
                    document.getElementById('type-'+val).checked = false;
                    if (currentFilters.type.length === 1) document.getElementById('type-all').checked = true;
                }
                else if (f.startsWith('status-')) {
                    const val = f.split('-')[1].charAt(0).toUpperCase() + f.split('-')[1].slice(1);
                    document.getElementById('status-'+val.toLowerCase()).checked = false;
                    if (currentFilters.status.length === 1) document.getElementById('status-all').checked = true;
                }
                updateCurrentFilters();
                updateActiveFilters();
                filterRows();
            });
        });
    }

    function filterRows() {
        let visible = 0;
        tableBody.querySelectorAll('tr').forEach(row => {
            if (row.cells.length < 2) { row.style.display = ''; return; }
            const text = row.textContent.toLowerCase();
            const type = row.dataset.type;
            const status = row.dataset.status;

            const matchSearch = currentFilters.search === '' || text.includes(currentFilters.search);
            const matchType = currentFilters.type[0] === 'All Types' || currentFilters.type.includes(type);
            const matchStatus = currentFilters.status[0] === 'All Conditions' || currentFilters.status.includes(status);

            row.style.display = (matchSearch && matchType && matchStatus) ? '' : 'none';
            if (matchSearch && matchType && matchStatus) visible++;
        });
        totalCount.textContent = visible;
    }

    document.addEventListener('click', () => {
        filterMenu.style.display = 'none';
        filterToggle.classList.remove('active');
        document.getElementById('userDropdownMenu').style.display = 'none';
    });
    filterMenu.addEventListener('click', e => e.stopPropagation());
    document.getElementById('userDropdownToggle').addEventListener('click', e => {
        e.stopPropagation();
        document.getElementById('userDropdownMenu').style.display =
            document.getElementById('userDropdownMenu').style.display === 'block' ? 'none' : 'block';
    });

    // Initial filter
    filterRows();

    // Auto-hide alerts
    document.querySelectorAll('.alert').forEach(a => setTimeout(() => bootstrap.Alert.getOrCreateInstance(a)?.close(), 5000));
</script>
</body>
</html>
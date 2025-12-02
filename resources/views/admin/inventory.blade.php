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
      --light-bg: #f5f7fb;
      --card-shadow: 0 2px 4px rgba(0,0,0,0.04);
    }
    body { font-family: 'Poppins', sans-serif; background: var(--light-bg); padding-top: 0; }

    /* Sidebar - identical to Accounts & Transaction */
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

    /* Mobile */
    .sidebar-toggle { display: none; position: fixed; top: 15px; left: 15px; z-index: 1001;
      background: var(--primary-color); color: white; border: none; border-radius: 8px;
      width: 40px; height: 40px; font-size: 1.2rem; }
    .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; }

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


    /* Table */
    .table-card { border-radius: 12px; border: none; box-shadow: var(--card-shadow); overflow: hidden; }
    .table th { font-weight: 600; color: #5b5f72; font-size: 0.85rem; text-transform: uppercase;
      letter-spacing: 0.5px; padding: 12px 16px; white-space: nowrap; }
    .table td { padding: 16px; vertical-align: middle; }
    .status-badge { padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 500; }
    .status-instock { background: #e8f5e8; color: #23b07a; }
    .status-low { background: #fde8e8; color: #e05252; }

    /* Stock Bar */
    .stock-bar { width: 60px; height: 6px; background: #e9ecef; border-radius: 3px; overflow: hidden; display: inline-block; }
    .stock-fill { height: 100%; border-radius: 3px; }
    .stock-high { background: #23b07a; }
    .stock-medium { background: #f08a24; }
    .stock-low { background: #e05252; }

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
      <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
      <a class="nav-link" href="{{ route('admin.accounts') }}"><i class="fas fa-user-circle"></i> <span>Accounts</span></a>

      <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#recordsSubmenu">
        <i class="fas fa-archive"></i> <span>Records</span>
      </a>
      <div class="collapse" id="recordsSubmenu">
        <div class="nav flex-column ms-3">
          <a class="nav-link" href="{{ route('admin.supplier') }}"><i class="fas fa-truck"></i> Suppliers</a>
          <a class="nav-link" href="{{ route('admin.employees') }}"><i class="fas fa-users"></i> Employees</a>
          <a class="nav-link" href="{{ route('admin.products') }}"><i class="fas fa-box"></i> Products</a>
        </div>
      </div>

      <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#transactionsSubmenu">
        <i class="fas fa-exchange-alt"></i> <span>Inventory</span>
      </a>
      <div class="collapse" id="transactionsSubmenu">
        <div class="nav flex-column ms-3">
          <a class="nav-link" href="{{ route('admin.stockin') }}"><i class="fas fa-arrow-circle-down"></i> Stock In</a>
          <a class="nav-link" href="{{ route('admin.pullout') }}"><i class="fas fa-arrow-circle-up"></i> Pullouts</a>
        </div>
      </div>

      <a class="nav-link dropdown-toggle active" href="#" data-bs-toggle="collapse" data-bs-target="#reportsSubmenu">
        <i class="fas fa-chart-bar"></i> <span>Reports</span>
      </a>
      <div class="collapse show" id="reportsSubmenu">
        <div class="nav flex-column ms-3">
          <a class="nav-link" href="{{ route('admin.transaction') }}"><i class="fas fa-file-invoice-dollar"></i> Transaction</a>
          <a class="nav-link active" href="{{ route('admin.inventory') }}"><i class="fas fa-clipboard-list"></i> Inventory</a>
        </div>
      </div>
    </nav>
  </div>
</aside>

<main class="content-wrap" id="contentWrap">
  <div class="topbar">
    <div class="page-title-section">
      <h4 class="mb-1">Inventory Report</h4>
      <small class="text-muted">Monitor stock levels across all products</small>
    </div>

    <div class="user-section">
      <!-- User Dropdown -->
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
          <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="user-dropdown-item"><i class="fas fa-sign-out-alt me-2"></i> Sign Out</button>
          </form>
        </div>
      </div>

      <!-- Search & Filter -->
      <div class="filter-container">
        <div class="search-filter-section">
          <div class="input-group search-input">
            <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
            <input type="text" class="form-control" placeholder="Search Product ID, Name, Category..." id="searchInput">
          </div>

          <div class="filter-dropdown">
            <button class="filter-toggle" id="filterToggle">
              <i class="fas fa-filter"></i> Filter <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
            </button>
            <div class="filter-menu" id="filterMenu">
              <div class="filter-section mb-3">
                <div class="filter-section-title">Stock Status</div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="status-instock" checked>
                  <label class="form-check-label" for="status-instock">In Stock</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="status-low" checked>
                  <label class="form-check-label" for="status-low">Low Stock</label>
                </div>
              </div>
              <div class="filter-actions mt-3">
                <button class="btn btn-sm btn-primary w-100" id="applyFilters">Apply Filters</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Inventory Table -->
  <div class="card table-card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="card-title mb-0">Current Inventory</h5>
        <a href="{{ route('admin.inventory') }}?export=csv" class="btn btn-success btn-sm">
          <i class="fas fa-file-csv me-1"></i> Export CSV
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Product ID</th>
              <th>Product Name</th>
              <th>Category</th>
              <th>Stock</th>
              <th>Reorder Level</th>
              <th>Status</th>
              <th>Last Updated</th>
            </tr>
          </thead>
          <tbody>
            @forelse($products ?? [] as $p)
            <tr>
              <td><strong>#{{ $p->ProdID ?? $p->id }}</strong></td>
              <td>
                <div style="font-weight:600">{{ $p->ProdName }}</div>
                <small class="text-muted">SKU: {{ $p->ProdID ?? $p->id }}</small>
              </td>
              <td>{{ $p->category?->CatName ?? 'Uncategorized' }}</td>
              <td>
                <div style="display:flex; align-items:center; gap:8px;">
                  <strong>{{ $p->CurrentStock ?? 0 }}</strong>
                  <div class="stock-bar">
                    @php
                      $percent = $p->CurrentStock > 0 ? min(100, ($p->CurrentStock / max(1, ($p->ReorderLvl ?? 1) * 3)) * 100) : 0;
                      $fill = $p->CurrentStock <= ($p->ReorderLvl ?? 0) ? 'stock-low' :
                              ($p->CurrentStock <= ($p->ReorderLvl ?? 0) * 2 ? 'stock-medium' : 'stock-high');
                    @endphp
                    <div class="stock-fill {{ $fill }}" style="width:{{ $percent }}%"></div>
                  </div>
                </div>
              </td>
              <td>{{ $p->ReorderLvl ?? 0 }}</td>
              <td>
                @if(($p->CurrentStock ?? 0) <= ($p->ReorderLvl ?? 0))
                  <span class="status-badge status-low">Low Stock</span>
                  @if(($p->CurrentStock ?? 0) == 0)
                    <span class="status-badge status-low ms-2">Out of Stock!</span>
                  @endif
                @else
                  <span class="status-badge status-instock">In Stock</span>
                @endif
              </td>
              <td>{{ $p->updated_at?->format('M d, Y H:i') ?? '—' }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center py-5 text-muted">No products found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="text-muted mt-3">
        Total: {{ count($products ?? []) }} product(s)
      </div>
    </div>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Identical JS from Accounts & Transaction pages
  document.getElementById('sidebarToggle').addEventListener('click', () => {
    document.getElementById('sidebar').classList.toggle('mobile-open');
    document.getElementById('sidebarOverlay').classList.toggle('active');
  });
  document.getElementById('sidebarOverlay').addEventListener('click', () => {
    document.getElementById('sidebar').classList.remove('mobile-open');
    document.getElementById('sidebarOverlay').classList.remove('active');
  });

  document.getElementById('userDropdownToggle').addEventListener('click', e => {
    e.stopPropagation();
    document.getElementById('userDropdownMenu').classList.toggle('show');
  });
  document.addEventListener('click', () => document.getElementById('userDropdownMenu').classList.remove('show'));

  document.getElementById('filterToggle').addEventListener('click', e => {
    e.stopPropagation();
    const menu = document.getElementById('filterMenu');
    menu.classList.toggle('show');
    document.getElementById('filterToggle').classList.toggle('active');
  });
  document.addEventListener('click', () => {
    document.getElementById('filterMenu').classList.remove('show');
    document.getElementById('filterToggle').classList.remove('active');
  });

  // Live search
  document.getElementById('searchInput')?.addEventListener('keyup', function() {
    const term = this.value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
    });
  });
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Suppliers | Dora's Oshoppe</title>
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

        .sidebar.collapsed {
            min-width: 70px;
            max-width: 70px;
        }

        .sidebar.collapsed .brand-text,
        .sidebar.collapsed .nav-link span:not(.fa),
        .sidebar.collapsed .nav-link .fa-chevron-down {
            display: none;
        }

        .sidebar.collapsed .brand {
            justify-content: center;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            text-align: center;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }

        .brand { 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            margin-bottom: 18px; 
            flex-shrink: 0; 
        }

        .brand img { 
            width: 100px; 
            height: 100px;
            object-fit: contain;
        }

        .brand-text {
            flex: 1;
        }

        .sidebar .nav-link { 
            color: #5b5f72; 
            padding: 12px 8px; 
            border-radius: 10px; 
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link.active { 
            background: #efeaff; 
            color: var(--primary-color); 
            font-weight: 600; 
        }

        .sidebar .nav-link:hover { 
            background: #f8f9fa; 
            transform: translateX(2px);
        }

        .sidebar .nav-link i { 
            width: 20px;
            margin-right: 10px;
            text-align: center;
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
        
        .nav .nav-link.dropdown-toggle::after {
            float: right;
            margin-top: 6px;
            margin-left: auto;
        }
        
        .nav .nav.flex-column.ms-3 {
            border-left: 2px solid #eef2f7;
            margin-left: 12px !important;
            padding-left: 8px;
        }
        
        .nav .nav.flex-column.ms-3 .nav-link {
            padding: 10px 12px;
            font-size: 0.9rem;
            border-radius: 6px;
        }

        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        /* ========== CONTENT AREA ========== */
        .content-wrap { 
            margin-left: 240px; 
            padding: 28px;
            transition: all 0.3s ease;
        }

        .content-wrap.expanded {
            margin-left: 0;
        }

        .topbar { 
            background: transparent; 
            display: flex; 
            gap: 16px; 
            align-items: flex-start; 
            justify-content: space-between; 
            margin-bottom: 22px; 
            flex-wrap: wrap;
        }

        .page-title-section {
            flex: 1;
            min-width: 250px;
        }

        .search-input { 
            max-width: 400px; 
            width: 100%; 
            min-width: 250px;
        }

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

.search-filter-section {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    justify-content: space-between;
    width: 100%;
}

.filter-container {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 8px;
    width: 100%;
}

.search-filter-row {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
    flex-wrap: nowrap;
}

.search-input {
    flex: 1;
    min-width: 250px;
    max-width: 500px;
}

.filter-dropdown {
    position: relative;
    flex-shrink: 0;
}

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
}a
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

        .filter-container {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
            margin-top: 20px;
            width: 100%;
        }

        .table-card {
            border-radius: 12px;
            border: none;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #5b5f72;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 16px;
            white-space: nowrap;
        }
        
        .table td {
            padding: 16px;
            vertical-align: middle;
            border-color: #f1f3f4;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            white-space: nowrap;
        }
        
        .status-active {
            color: var(--success-color);
        }
        
        .status-inactive {
            color: var(--danger-color);
        }

        .action-buttons {
            display: flex;
            gap: 4px;
            flex-wrap: nowrap;
        }

        .action-buttons .btn {
            padding: 6px 8px;
            font-size: 0.8rem;
        }

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
            color: var(--primary-color);
        }

        @media (max-width: 1199.98px) {
            .sidebar {
                min-width: 200px;
                max-width: 200px;
            }
            
            .content-wrap {
                margin-left: 220px;
                padding: 24px;
            }
        }

        @media (max-width: 991.98px) {
            .sidebar { 
                position: fixed;
                transform: translateX(-100%);
                z-index: 1000;
                width: 280px;
                max-width: 280px;
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .sidebar-toggle {
                display: flex;
            }

            .content-wrap { 
                margin-left: 0; 
                padding: 70px 16px 16px;
            }
            
            .topbar {
                flex-direction: column;
                align-items: stretch;
                gap: 20px;
            }
            
            .page-title-section {
                min-width: 100%;
                text-align: center;
            }
            
            .user-section {
                align-items: stretch;
                min-width: 100%;
            }
            
            .search-filter-section {
                justify-content: center;
                flex-wrap: wrap;
            }
            
            .search-input {
                min-width: 100%;
                max-width: 100%;
            }
            
            .filter-menu {
                right: auto;
                left: 0;
                min-width: 280px;
            }
            
            .filter-toggle {
                min-width: 120px;
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

            .user-dropdown {
                width: 100%;
            }

            .user-dropdown-toggle {
                width: 100%;
                justify-content: center;
            }

            .table-responsive {
                border-radius: 8px;
            }

            .table th,
            .table td {
                padding: 12px 8px;
                font-size: 0.9rem;
            }

            .action-buttons {
                flex-direction: column;
                gap: 4px;
            }

            .action-buttons .btn {
                padding: 4px 6px;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 767.98px) {
            .content-wrap {
                padding: 70px 12px 12px;
            }

            .topbar {
                margin-bottom: 16px;
            }

            .table-card .card-body {
                padding: 16px;
            }

            .table th,
            .table td {
                padding: 10px 6px;
                font-size: 0.85rem;
            }

            .status-badge {
                padding: 4px 8px;
                font-size: 0.7rem;
            }

            .modal-dialog {
                margin: 20px auto;
            }

            .filter-menu {
                min-width: 250px;
            }

            .search-filter-section {
                flex-direction: column;
            }

            .search-input,
            .filter-toggle {
                width: 100%;
            }

            .table th:nth-child(4),
            .table td:nth-child(4),
            .table th:nth-child(5), 
            .table td:nth-child(5) {
                display: none;
            }
        }

        @media (max-width: 575.98px) {
            .content-wrap {
                padding: 70px 8px 8px;
            }

            .sidebar {
                width: 100%;
                max-width: 100%;
            }

            .table-responsive {
                font-size: 0.8rem;
            }

            .table th,
            .table td {
                padding: 8px 4px;
            }

            .modal-dialog {
                margin: 10px auto;
            }

            .modal-body .row {
                margin-left: -8px;
                margin-right: -8px;
            }

            .modal-body .col-md-6 {
                padding-left: 8px;
                padding-right: 8px;
            }

            .btn-group {
                flex-direction: column;
                width: 100%;
            }

            .btn-group .btn {
                border-radius: 4px !important;
                margin-bottom: 4px;
            }

            .table th:nth-child(3), 
            .table td:nth-child(3) {
                display: none;
            }
        }

        @media print {
            .sidebar,
            .topbar .user-section,
            .btn,
            .action-buttons {
                display: none !important;
            }

            .content-wrap {
                margin-left: 0 !important;
                padding: 0 !important;
            }

            .table-card {
                box-shadow: none !important;
                border: 1px solid #dee2e6 !important;
            }
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .sidebar-overlay.active {
            display: block;
        }
    </style>
</head>
<body>
@php
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
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a class="nav-link" href="{{ route('admin.accounts') }}">
                <i class="fas fa-user-circle"></i>
                <span>Accounts</span>
            </a>

            <a class="nav-link dropdown-toggle active" href="#" data-bs-toggle="collapse" data-bs-target="#recordsSubmenu">
                <i class="fas fa-archive"></i>
                <span>Records</span>
            </a>
            <div class="collapse show" id="recordsSubmenu">
                <div class="nav flex-column ms-3">
                    <a class="nav-link active" href="{{ route('admin.supplier') }}">
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
<main class="content-wrap" id="contentWrap">
    {{-- Topbar --}}
    <div class="topbar">
        <div class="page-title-section">
            <h4 class="mb-1">Supplier Management</h4>
        </div>

        <div class="user-section">
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
            
            
            <div class="filter-container">
                <div class="search-filter-section">
                    <div class="input-group search-input">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search suppliers..." id="searchInput">
                    </div>
                    
                    <div class="filter-dropdown">
                        <button class="filter-toggle" id="filterToggle">
                            <i class="fas fa-filter"></i>
                            <span>Filter</span>
                            <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
                        </button>
                        
                        <div class="filter-menu" id="filterMenu" style="display: none;">
                            <!-- Status Filters -->
                            <div class="filter-section">
                                <div class="filter-section-title">Supplier Status</div>
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
                            
                            <!-- Products Filters -->
                            <div class="filter-section">
                                <div class="filter-section-title">Products Supplied</div>
                                <div class="filter-options">
                                    <div class="filter-option">
                                        <input type="checkbox" id="products-all" checked>
                                        <label for="products-all">All Suppliers</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="products-with">
                                        <label for="products-with">With Products</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="products-without">
                                        <label for="products-without">Without Products</label>
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

    {{-- Success Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Warning Alert for Inactive Suppliers with Products --}}
    @php
        $inactiveSuppliersWithProducts = collect($suppliers)->filter(function($supplier) {
            return $supplier->Status === 'Inactive' && ($supplier->products_count ?? 0) > 0;
        });
    @endphp
    
    @if($inactiveSuppliersWithProducts->count() > 0)
        <div class="alert alert-warning alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Warning:</strong> {{ $inactiveSuppliersWithProducts->count() }} 
            supplier{{ $inactiveSuppliersWithProducts->count() > 1 ? 's are' : ' is' }} 
            marked as Inactive but still have products associated. These products cannot be ordered.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Suppliers Table --}}
    <div class="card table-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <h5 class="card-title mb-0">Supplier Records</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                    <i class="fas fa-plus me-2"></i>New Supplier
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>SUPPLIER ID</th>
                            <th>SUPPLIER NAME</th>
                            <th>CONTACT</th>
                            <th>ADDRESS</th>
                            <th>PRODUCTS</th>
                            <th>STATUS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="suppliersTableBody">
                        @forelse($suppliers as $supplier)
                        <tr>
                            <td>
                                <strong>{{ $supplier->SupplierID }}</strong>
                            </td>
                            <td>
                                <div class="fw-600">{{ $supplier->SupplierName }}</div>
                                <small class="text-muted">Supplier</small>
                            </td>
                            <td>
                                {{ $supplier->SupplierContactNo }}
                                @if($supplier->Status === 'Inactive' && ($supplier->products_count ?? 0) > 0)
                                    <br><small class="text-danger"><i class="fas fa-exclamation-circle"></i> Products restricted</small>
                                @endif
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 200px;" title="{{ $supplier->Address }}">
                                    {{ $supplier->Address }}
                                </div>
                            </td>
                            <td>
                                <strong class="text-primary">{{ $supplier->products_count ?? 0 }}</strong>
                            </td>
                            <td>
                                <span class="status-badge {{ $supplier->Status === 'Active' ? 'status-active' : 'status-inactive' }}">
                                    {{ $supplier->Status }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewModal{{ $supplier->id }}" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $supplier->id }}" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $supplier->id }}" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                                No suppliers found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    <i class="fas fa-list me-2"></i>Total: <span id="totalCount">{{ $suppliers->count() }}</span> supplier{{ $suppliers->count() != 1 ? 's' : '' }}
                </div>
            </div>
        </div>
    </div>
</main>

{{-- ADD SUPPLIER MODAL --}}
<div class="modal fade" id="addSupplierModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.supplier.store') }}" method="POST" id="addSupplierForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Supplier Name <span class="text-danger">*</span></label>
                            <input type="text" name="SupplierName" class="form-control {{ $errors->has('SupplierName') ? 'is-invalid' : '' }}" value="{{ old('SupplierName') }}" required>
                            @if($errors->has('SupplierName'))
                                <div class="invalid-feedback">{{ $errors->first('SupplierName') }}</div>
                            @endif
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" name="SupplierContactNo" class="form-control {{ $errors->has('SupplierContactNo') ? 'is-invalid' : '' }}" 
                                   value="{{ old('SupplierContactNo') }}" 
                                   pattern="09[0-9]{9}" 
                                   maxlength="11"
                                   placeholder="09XXXXXXXXX"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)"
                                   required>
                            @if($errors->has('SupplierContactNo'))
                                <div class="invalid-feedback">{{ $errors->first('SupplierContactNo') }}</div>
                            @endif
                        </div>
                        <div class="col-12">
                            <label class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea name="Address" class="form-control {{ $errors->has('Address') ? 'is-invalid' : '' }}" rows="3" required>{{ old('Address') }}</textarea>
                            @if($errors->has('Address'))
                                <div class="invalid-feedback">{{ $errors->first('Address') }}</div>
                            @endif
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="Status" class="form-select" required>
                                <option value="Active" selected>Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            <div class="mt-2">
                                <div class="alert alert-info" id="inactiveWarning" style="display: none;">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <small>Inactive suppliers cannot have products ordered from them.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Supplier</button>
                </div>
            </div>
        </form>
    </div>
</div>

@foreach($suppliers as $supplier)
    {{-- VIEW MODAL - Updated to match Add modal style --}}
    <div class="modal fade" id="viewModal{{ $supplier->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Supplier Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Supplier ID</label>
                            <input type="text" class="form-control readonly-field" value="{{ $supplier->SupplierID }}" readonly>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label">Supplier Name</label>
                            <input type="text" class="form-control readonly-field" value="{{ $supplier->SupplierName }}" readonly>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="text" class="form-control readonly-field" value="{{ $supplier->SupplierContactNo ?? '—' }}" readonly>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label">Address</label>
                            <textarea class="form-control readonly-field" rows="3" readonly>{{ $supplier->Address ?? '—' }}</textarea>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label">Products Supplied</label>
                            <input type="text" class="form-control readonly-field" value="{{ $supplier->products_count ?? 0 }} product{{ ($supplier->products_count ?? 0) != 1 ? 's' : '' }}" readonly>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label">Status</label>
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control readonly-field me-2" value="{{ $supplier->Status }}" readonly style="flex: 1;">
                               
                            </div>
                            @if($supplier->Status === 'Inactive' && ($supplier->products_count ?? 0) > 0)
                                <div class="text-danger mt-1">
                                    <i class="fas fa-exclamation-triangle"></i> Products cannot be ordered from this supplier
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label">Date Added</label>
                            <input type="text" class="form-control readonly-field" value="{{ \Carbon\Carbon::parse($supplier->created_at)->format('M d, Y h:i A') }}" readonly>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label">Last Updated</label>
                            <input type="text" class="form-control readonly-field" value="{{ \Carbon\Carbon::parse($supplier->updated_at)->format('M d, Y h:i A') }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editModal{{ $supplier->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('admin.supplier.update', $supplier->SupplierID) }}" method="POST" id="editForm{{ $supplier->id }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Supplier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Supplier Name <span class="text-danger">*</span></label>
                                <input type="text" name="SupplierName" class="form-control {{ $errors->has('SupplierName') ? 'is-invalid' : '' }}" 
                                       value="{{ old('SupplierName', $supplier->SupplierName) }}" required>
                                @if($errors->has('SupplierName'))
                                    <div class="invalid-feedback">{{ $errors->first('SupplierName') }}</div>
                                @endif
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                                <input type="text" name="SupplierContactNo" class="form-control {{ $errors->has('SupplierContactNo') ? 'is-invalid' : '' }}"
                                       value="{{ old('SupplierContactNo', $supplier->SupplierContactNo) }}" 
                                       pattern="09[0-9]{9}" 
                                       maxlength="11"
                                       placeholder="09XXXXXXXXX"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)"
                                       required>
                                @if($errors->has('SupplierContactNo'))
                                    <div class="invalid-feedback">{{ $errors->first('SupplierContactNo') }}</div>
                                @endif
                                <small class="text-muted">Must be exactly 11 digits and start with 09 (e.g., 09123456789)</small>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address <span class="text-danger">*</span></label>
                                <textarea name="Address" class="form-control {{ $errors->has('Address') ? 'is-invalid' : '' }}" rows="3" required>{{ old('Address', $supplier->Address) }}</textarea>
                                @if($errors->has('Address'))
                                    <div class="invalid-feedback">{{ $errors->first('Address') }}</div>
                                @endif
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="Status" class="form-select" required onchange="showInactiveWarningEdit(this, {{ $supplier->products_count ?? 0 }})">
                                    <option value="Active" {{ $supplier->Status == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ $supplier->Status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <div class="mt-2">
                                    <div class="alert alert-warning" id="inactiveWarningEdit{{ $supplier->id }}" style="display: {{ $supplier->Status == 'Inactive' && ($supplier->products_count ?? 0) > 0 ? 'block' : 'none' }};">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <small>This supplier has {{ $supplier->products_count ?? 0 }} product(s). If set to Inactive, these products cannot be ordered.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Supplier</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- DELETE MODAL --}}
    <div class="modal fade" id="deleteModal{{ $supplier->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.supplier.destroy', $supplier->SupplierID) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">Delete Supplier</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to <strong>permanently delete</strong> this supplier?</p>
                        <div class="alert alert-danger">
                            <strong>{{ $supplier->SupplierName }}</strong><br>
                            <small>{{ $supplier->SupplierID }}</small>
                        </div>
                        @if(($supplier->products_count ?? 0) > 0)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                This supplier has {{ $supplier->products_count ?? 0 }} product(s). Deleting this supplier will affect those products.
                            </div>
                        @endif
                        <p class="text-danger"><strong>This action cannot be undone.</strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete Permanently</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Mobile sidebar functionality
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const contentWrap = document.getElementById('contentWrap');

    sidebarToggle.addEventListener('click', function() {
        sidebar.classList.toggle('mobile-open');
        sidebarOverlay.classList.toggle('active');
        document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
    });

    sidebarOverlay.addEventListener('click', function() {
        sidebar.classList.remove('mobile-open');
        sidebarOverlay.classList.remove('active');
        document.body.style.overflow = '';
    });

    // Close sidebar when clicking on a link (mobile)
    document.querySelectorAll('.sidebar .nav-link').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                sidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // Filter functionality
    const filterToggle = document.getElementById('filterToggle');
    const filterMenu = document.getElementById('filterMenu');
    const activeFilters = document.getElementById('activeFilters');
    const searchInput = document.getElementById('searchInput');
    const suppliersTableBody = document.getElementById('suppliersTableBody');
    const totalCount = document.getElementById('totalCount');
    
    // User dropdown functionality
    const userDropdownToggle = document.getElementById('userDropdownToggle');
    const userDropdownMenu = document.getElementById('userDropdownMenu');
    
    // Store current filters
    let currentFilters = {
        status: ['All Status'],
        products: ['All Suppliers'],
        search: ''
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
    
    // Search functionality
    searchInput.addEventListener('input', function() {
        currentFilters.search = this.value.toLowerCase();
        filterSuppliers();
    });
    
    // Apply filters
    document.getElementById('applyFilters').addEventListener('click', function() {
        filterMenu.style.display = 'none';
        filterToggle.classList.remove('active');
        
        // Update current filters based on selections
        updateCurrentFilters();
        
        // Update active filters display
        updateActiveFilters();
        
        // Filter suppliers
        filterSuppliers();
    });
    
    // Clear filters
    document.getElementById('clearFilters').addEventListener('click', function() {
        // Clear all checkboxes
        document.querySelectorAll('.filter-option input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        
        // Set default values
        document.getElementById('status-all').checked = true;
        document.getElementById('products-all').checked = true;
        
        // Clear search
        searchInput.value = '';
        
        // Update current filters to defaults
        currentFilters = {
            status: ['All Status'],
            products: ['All Suppliers'],
            search: ''
        };
        
        // Update active filters
        updateActiveFilters();
        
        // Reset supplier display
        filterSuppliers();
    });
    
    function updateCurrentFilters() {
        // Update status
        currentFilters.status = [];
        if (document.getElementById('status-all').checked) {
            currentFilters.status.push('All Status');
        } else {
            if (document.getElementById('status-active').checked) {
                currentFilters.status.push('Active');
            }
            if (document.getElementById('status-inactive').checked) {
                currentFilters.status.push('Inactive');
            }
        }
        
        // Update products
        currentFilters.products = [];
        if (document.getElementById('products-all').checked) {
            currentFilters.products.push('All Suppliers');
        } else {
            if (document.getElementById('products-with').checked) {
                currentFilters.products.push('With Products');
            }
            if (document.getElementById('products-without').checked) {
                currentFilters.products.push('Without Products');
            }
        }
    }
    
    function updateActiveFilters() {
        // Clear existing filter tags
        activeFilters.innerHTML = '';
        
        // Check if we have any non-default filters
        const hasCustomFilters = 
            currentFilters.status.length !== 1 || 
            currentFilters.status[0] !== 'All Status' ||
            currentFilters.products.length !== 1 || 
            currentFilters.products[0] !== 'All Suppliers' ||
            currentFilters.search !== '';
        
        if (!hasCustomFilters) {
            // No custom filters applied, hide the active filters section
            activeFilters.classList.remove('has-filters');
            return;
        }
        
        // Show active filters section
        activeFilters.classList.add('has-filters');
        
        // Add status filter tags if not "All Status"
        if (currentFilters.status.length > 0 && 
            (currentFilters.status.length > 1 || currentFilters.status[0] !== 'All Status')) {
            currentFilters.status.forEach(status => {
                const statusTag = createFilterTag(`Status: ${status}`, `status-${status.toLowerCase().replace(' ', '-')}`);
                activeFilters.appendChild(statusTag);
            });
        }
        
        // Add products filter tags if not "All Suppliers"
        if (currentFilters.products.length > 0 && 
            (currentFilters.products.length > 1 || currentFilters.products[0] !== 'All Suppliers')) {
            currentFilters.products.forEach(product => {
                const productTag = createFilterTag(`Products: ${product}`, `products-${product.toLowerCase().replace(' ', '-')}`);
                activeFilters.appendChild(productTag);
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
        if (filterType.startsWith('status-')) {
            const filterName = filterType.replace('status-', '').replace('-', ' ');
            const index = currentFilters.status.indexOf(
                filterName.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
            );
            if (index > -1) {
                currentFilters.status.splice(index, 1);
            }
        } else if (filterType.startsWith('products-')) {
            const filterName = filterType.replace('products-', '').replace('-', ' ');
            const index = currentFilters.products.indexOf(
                filterName.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
            );
            if (index > -1) {
                currentFilters.products.splice(index, 1);
            }
        } else if (filterType === 'search') {
            currentFilters.search = '';
            searchInput.value = '';
        }
        
        // Update the checkboxes to reflect the change
        updateFilterInputs();
        
        // Update active filters display
        updateActiveFilters();
        
        // Refresh supplier display
        filterSuppliers();
    }
    
    function updateFilterInputs() {
        // Update status checkboxes
        document.getElementById('status-all').checked = currentFilters.status.includes('All Status');
        document.getElementById('status-active').checked = currentFilters.status.includes('Active');
        document.getElementById('status-inactive').checked = currentFilters.status.includes('Inactive');
        
        // Update products checkboxes
        document.getElementById('products-all').checked = currentFilters.products.includes('All Suppliers');
        document.getElementById('products-with').checked = currentFilters.products.includes('With Products');
        document.getElementById('products-without').checked = currentFilters.products.includes('Without Products');
    }
    
    function filterSuppliers() {
        const rows = suppliersTableBody.getElementsByTagName('tr');
        let visibleCount = 0;
        
        for (let row of rows) {
            if (row.cells.length < 2) continue; // Skip empty rows
            
            const name = row.cells[1].textContent.toLowerCase();
            const status = row.cells[5].textContent.trim();
            const productsCount = parseInt(row.cells[4].textContent.trim()) || 0;
            
            // Check search filter
            const searchMatch = currentFilters.search === '' || 
                               name.includes(currentFilters.search) ||
                               row.textContent.toLowerCase().includes(currentFilters.search);
            
            // Check status filter
            const statusMatch = currentFilters.status.includes('All Status') || currentFilters.status.includes(status);
            
            // Check products filter
            let productsMatch = false;
            if (currentFilters.products.includes('All Suppliers')) {
                productsMatch = true;
            } else {
                if (currentFilters.products.includes('With Products') && productsCount > 0) {
                    productsMatch = true;
                }
                if (currentFilters.products.includes('Without Products') && productsCount === 0) {
                    productsMatch = true;
                }
            }
            
            // Show/hide row based on filters
            if (searchMatch && statusMatch && productsMatch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        }
        
        // Update total count
        totalCount.textContent = visibleCount;
    }
    
    // Initialize filtering on page load
    document.addEventListener('DOMContentLoaded', function() {
        filterSuppliers();
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            sidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    // Auto-hide alerts after 5 seconds
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Show/hide inactive supplier warning in add modal
    document.querySelector('select[name="Status"]').addEventListener('change', function() {
        const warning = document.getElementById('inactiveWarning');
        if (this.value === 'Inactive') {
            warning.style.display = 'block';
        } else {
            warning.style.display = 'none';
        }
    });

    // Show/hide inactive supplier warning in edit modal
    function showInactiveWarningEdit(selectElement, productsCount) {
        const supplierId = selectElement.closest('form').id.replace('editForm', '');
        const warning = document.getElementById('inactiveWarningEdit' + supplierId);
        
        if (selectElement.value === 'Inactive' && productsCount > 0) {
            warning.style.display = 'block';
        } else {
            warning.style.display = 'none';
        }
    }

    // Form validation for contact number
    const addSupplierForm = document.getElementById('addSupplierForm');
    if (addSupplierForm) {
        addSupplierForm.addEventListener('submit', function(event) {
            const contactInput = document.querySelector('input[name="SupplierContactNo"]');
            const contactValue = contactInput.value;
            
            // Check if contact number is exactly 11 digits and starts with 09
            if (contactValue.length !== 11 || !/^09\d{9}$/.test(contactValue)) {
                event.preventDefault();
                contactInput.classList.add('is-invalid');
                contactInput.nextElementSibling.textContent = 'Contact number must be exactly 12 digits.';
                contactInput.focus();
            }
        });
    }

    // Add validation for edit forms
    document.querySelectorAll('[id^="editForm"]').forEach(form => {
        form.addEventListener('submit', function(event) {
            const contactInput = this.querySelector('input[name="SupplierContactNo"]');
            const contactValue = contactInput.value;
            
            // Check if contact number is exactly 11 digits and starts with 09
            if (contactValue.length !== 11 || !/^09\d{9}$/.test(contactValue)) {
                event.preventDefault();
                contactInput.classList.add('is-invalid');
                if (!contactInput.nextElementSibling.classList.contains('text-muted')) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = 'Contact number must be exactly 12 digits.';
                    contactInput.parentNode.insertBefore(errorDiv, contactInput.nextElementSibling);
                } else {
                    contactInput.nextElementSibling.nextElementSibling.textContent = 'Contact number must be exactly 12 digits.';
                }
                contactInput.focus();
            }
        });
    });

    // Format contact number input to show "+63" or "09" format
    document.querySelectorAll('input[name="SupplierContactNo"]').forEach(input => {
        input.addEventListener('input', function() {
            // Remove non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Ensure it starts with 09 (Philippines mobile format)
            if (this.value.length > 0 && !this.value.startsWith('09')) {
                // If it starts with 9, add 0 at the beginning
                if (this.value.startsWith('9')) {
                    this.value = '0' + this.value;
                }
                // If it starts with 63, convert to 09 format
                else if (this.value.startsWith('63')) {
                    this.value = '0' + this.value.substring(2);
                }
            }
            
            // Limit to 11 digits
            if (this.value.length > 11) {
                this.value = this.value.substring(0, 11);
            }
        });
        
        input.addEventListener('blur', function() {
            if (this.value.length > 0 && this.value.length !== 11) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });
</script>
</body>
</html>
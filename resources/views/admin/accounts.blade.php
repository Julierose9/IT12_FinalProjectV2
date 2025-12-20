<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Accounts | Dora's Oshoppe</title>
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

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            margin-top: 18px;
        }
        
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

        .role-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            white-space: nowrap;
        }
        
        .role-admin {
            color: var(--primary-color);
        }
        
        .role-cashier {
            color: #1a73e8;
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

            .status-badge,
            .role-badge {
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

            .table th:nth-child(3), 
            .table td:nth-child(3),
            .table th:nth-child(6), 
            .table td:nth-child(6) {
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

            .table th:nth-child(2),
            .table td:nth-child(2) {
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

        select option:disabled {
            color: #6c757d;
            background-color: #f8f9fa;
        }

        .readonly-field {
            background-color: #f8f9fa;
            color: #6c757d;
            cursor: not-allowed;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
            width: 100%;
        }
        
        .email-suggestion {
            font-size: 0.85rem;
            color: var(--primary-color);
            margin-top: 4px;
            display: none;
        }
        
        .email-suggestion.show {
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
            <a class="nav-link active" href="{{ route('admin.accounts') }}">
                <i class="fas fa-user-circle"></i>
                <span>Accounts</span>
            </a>

            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#recordsSubmenu">
                <i class="fas fa-archive"></i>
                <span>Records</span>
            </a>
            <div class="collapse" id="recordsSubmenu">
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
            <h4 class="mb-1">Account Management</h4>
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
                        <input type="text" class="form-control" placeholder="Search accounts..." id="searchInput">
                    </div>
                    
                    <div class="filter-dropdown">
                        <button class="filter-toggle" id="filterToggle">
                            <i class="fas fa-filter"></i>
                            <span>Filter</span>
                            <i class="fas fa-chevron-down ms-1" style="font-size: 0.8rem;"></i>
                        </button>
                        
                        <div class="filter-menu" id="filterMenu" style="display: none;">
                            <div class="filter-section">
                                <div class="filter-section-title">Account Role</div>
                                <div class="filter-options">
                                    <div class="filter-option">
                                        <input type="checkbox" id="role-all" checked>
                                        <label for="role-all">All Roles</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="role-admin">
                                        <label for="role-admin">Administrator</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="role-cashier">
                                        <label for="role-cashier">Cashier</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="filter-section">
                                <div class="filter-section-title">Account Status</div>
                                <div class="filter-options">
                                    <div class="filter-option">
                                        <input type="checkbox" id="status-active" checked>
                                        <label for="status-active">Active</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="status-inactive" checked>
                                        <label for="status-inactive">Inactive</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="filter-section">
                                <div class="filter-section-title">Employee Link</div>
                                <div class="filter-options">
                                    <div class="filter-option">
                                        <input type="checkbox" id="link-all" checked>
                                        <label for="link-all">All Accounts</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="link-linked">
                                        <label for="link-linked">Linked to Employee</label>
                                    </div>
                                    <div class="filter-option">
                                        <input type="checkbox" id="link-external">
                                        <label for="link-external">External Accounts</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="filter-actions">
                                <button class="btn-apply" id="applyFilters">Apply Filters</button>
                                <button class="btn-clear" id="clearFilters">Reset Filters</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="active-filters" id="activeFilters">
                </div>
            </div>
        </div>
    </div>

    {{-- Accounts Table --}}
    <div class="card table-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <h5 class="card-title mb-0">User Accounts</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccountModal">
                    <i class="fas fa-plus me-2"></i>New Account
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ACCOUNT ID</th>
                            <th>EMAIL</th>
                            <th class="d-none d-md-table-cell">EMPLOYEE</th>
                            <th>ROLE</th>
                            <th>STATUS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="accountsTableBody">
                        @forelse($accounts as $account)
                        <tr>
                            <td>
                                <strong>ACC{{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}</strong>
                            </td>
                            <td>
                                <div class="fw-600">{{ $account->Username }}</div>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <div class="fw-600">{{ $account->FullName }}</div>
                                <small class="text-muted">
                                    {{ $account->EmployeeID ? str_pad($account->EmployeeID, 3, '0', STR_PAD_LEFT) : 'No Employee Linked' }}
                                </small>
                            </td>
                            <td>
                                <span class="role-badge {{ $account->Role === 'Admin' ? 'role-admin' : 'role-cashier' }}">
                                    {{ $account->Role }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-active">Active</span>
                            </td>
                           
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewModal{{ $account->UserID }}" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $account->UserID }}" title="Edit">
                                        <i class="fas fa-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $account->UserID }}" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                                No accounts found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    <i class="fas fa-list me-2"></i>Total: <span id="totalCount">{{ $accounts->count() }}</span> record{{ $accounts->count() !== 1 ? 's' : '' }}
                </div>
            </div>
        </div>
    </div>
</main>

{{-- CREATE MODAL --}}
<div class="modal fade" id="addAccountModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('admin.accounts.store') }}" method="POST" id="createAccountForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Link to Employee <span class="text-danger">*</span></label>
                            <select class="form-select" name="employee_id" id="employee_id" required>
                                <option value="">Select Employee</option>
                                @foreach($allEmployees as $emp)
                                    @php
                                        $hasAccount = in_array($emp->EmployeeID, $employeesWithAccounts);
                                        $middle = $emp->EmployeeMName ? ' ' . $emp->EmployeeMName . ' ' : ' ';
                                        $fullName = $emp->EmployeeFName . $middle . $emp->EmployeeLName;
                                        $empCode = str_pad($emp->EmployeeID, 3, '0', STR_PAD_LEFT);
                                        // Use correct property name from query (capital R), with fallback
                                        $role = $emp->Role ?? $emp->role ?? '';
                                    @endphp
                                    <option value="{{ $emp->EmployeeID }}"
                                        data-role="{{ $role }}"
                                        {{ $hasAccount ? 'disabled' : '' }}>
                                        {{ $fullName }} ({{ $empCode }})
                                        @if($hasAccount) - Already has account @endif
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Only Cashier/Admin employees without existing accounts are shown</small>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Detected Role</label>
                            <input type="text" class="form-control readonly-field" id="detected_role_display" readonly placeholder="Select an employee to see role">
                            <input type="hidden" name="role" id="role_hidden">
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Email / Username <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="account_email" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" required minlength="6">
                            <small class="text-muted">Minimum 6 characters</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </div>
            </div>
        </form>
    </div>
</div>
@foreach($accounts as $account)
    {{-- VIEW MODAL - Updated to match Add modal style --}}
    <div class="modal fade" id="viewModal{{ $account->UserID }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i ></i>Account Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Account ID</label>
                            <input type="text" class="form-control readonly-field" value="ACC{{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}" readonly>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label">Email / Username</label>
                            <input type="text" class="form-control readonly-field" value="{{ $account->Username }}" readonly>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label">Employee Name</label>
                            <input type="text" class="form-control readonly-field" value="{{ $account->FullName }}" readonly>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label">Employee ID</label>
                            <input type="text" class="form-control readonly-field" value="{{ $account->EmployeeID ? str_pad($account->EmployeeID, 3, '0', STR_PAD_LEFT) : '—' }}" readonly>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control readonly-field" value="{{ $account->Role }}" readonly>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label">Status</label>
                            <input type="text" class="form-control readonly-field" value="Active" readonly>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label">Date Created</label>
                            <input type="text" class="form-control readonly-field" value="{{ \Carbon\Carbon::parse($account->created_at)->format('M d, Y H:i') }}" readonly>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <label class="form-label">Last Updated</label>
                            <input type="text" class="form-control readonly-field" value="{{ \Carbon\Carbon::parse($account->updated_at)->format('M d, Y H:i') }}" readonly>
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
    <div class="modal fade" id="editModal{{ $account->UserID }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('admin.accounts.update', $account->UserID) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i ></i>Edit Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Email / Username</label>
                                <input type="email" name="email" class="form-control" value="{{ $account->Username }}" required>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <label class="form-label">Role</label>
                                <div class="readonly-field">{{ $account->Role }}</div>
                                <input type="hidden" name="role" value="{{ $account->Role }}">
                                <small class="text-muted">Role cannot be changed</small>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Linked Employee</label>
                                @if($account->EmployeeID)
                                    <div class="readonly-field">{{ $account->FullName }} (EMP{{ str_pad($account->EmployeeID, 3, '0', STR_PAD_LEFT) }})</div>
                                    <input type="hidden" name="employee_id" value="{{ $account->EmployeeID }}">
                                @else
                                    <div class="readonly-field">External Account (No Employee Linked)</div>
                                    <input type="hidden" name="employee_id" value="">
                                @endif
                                <small class="text-muted">Employee link cannot be changed</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Account</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- DELETE MODAL --}}
    <div class="modal fade" id="deleteModal{{ $account->UserID }}" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.accounts.destroy', $account->UserID) }}" method="POST">
                @csrf @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger"><i class="fas fa-trash me-2"></i>Delete Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to <strong>permanently delete</strong> this account?</p>
                        <div class="alert alert-danger">
                            <strong>{{ $account->FullName }}</strong><br>
                            <small>{{ $account->Username }}</small>
                        </div>
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
    const accountsTableBody = document.getElementById('accountsTableBody');
    const totalCount = document.getElementById('totalCount');
    
    // User dropdown functionality
    const userDropdownToggle = document.getElementById('userDropdownToggle');
    const userDropdownMenu = document.getElementById('userDropdownMenu');
    
    // Store current filters
    let currentFilters = {
        roles: ['All Roles'],
        status: ['Active', 'Inactive'],
        link: ['All Accounts'],
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
        filterAccounts();
    });
    
    // Apply filters
    document.getElementById('applyFilters').addEventListener('click', function() {
        filterMenu.style.display = 'none';
        filterToggle.classList.remove('active');
        
        // Update current filters based on selections
        updateCurrentFilters();
        
        // Update active filters display
        updateActiveFilters();
        
        // Filter accounts
        filterAccounts();
    });
    
    // Clear filters
    document.getElementById('clearFilters').addEventListener('click', function() {
        // Clear all checkboxes
        document.querySelectorAll('.filter-option input[type="checkbox"]').forEach(checkbox => {
            checkbox.checked = false;
        });
        
        // Set default values
        document.getElementById('role-all').checked = true;
        document.getElementById('status-active').checked = true;
        document.getElementById('status-inactive').checked = true;
        document.getElementById('link-all').checked = true;
        
        // Clear search
        searchInput.value = '';
        
        // Update current filters to defaults
        currentFilters = {
            roles: ['All Roles'],
            status: ['Active', 'Inactive'],
            link: ['All Accounts'],
            search: ''
        };
        
        // Update active filters
        updateActiveFilters();
        
        // Reset account display
        filterAccounts();
    });
    
    function updateCurrentFilters() {
        // Update roles
        currentFilters.roles = [];
        if (document.getElementById('role-all').checked) {
            currentFilters.roles.push('All Roles');
        } else {
            if (document.getElementById('role-admin').checked) {
                currentFilters.roles.push('Admin');
            }
            if (document.getElementById('role-cashier').checked) {
                currentFilters.roles.push('Cashier');
            }
        }
        
        // Update status
        currentFilters.status = [];
        if (document.getElementById('status-active').checked) {
            currentFilters.status.push('Active');
        }
        if (document.getElementById('status-inactive').checked) {
            currentFilters.status.push('Inactive');
        }
        
        // Update employee link
        currentFilters.link = [];
        if (document.getElementById('link-all').checked) {
            currentFilters.link.push('All Accounts');
        } else {
            if (document.getElementById('link-linked').checked) {
                currentFilters.link.push('Linked');
            }
            if (document.getElementById('link-external').checked) {
                currentFilters.link.push('External');
            }
        }
    }
    
    function updateActiveFilters() {
        // Clear existing filter tags
        activeFilters.innerHTML = '';
        
        // Check if we have any non-default filters
        const hasCustomFilters = 
            currentFilters.roles.length !== 1 || 
            currentFilters.roles[0] !== 'All Roles' ||
            currentFilters.status.length < 2 ||
            currentFilters.link.length !== 1 || 
            currentFilters.link[0] !== 'All Accounts' ||
            currentFilters.search !== '';
        
        if (!hasCustomFilters) {
            activeFilters.classList.remove('has-filters');
            return;
        }
        
        activeFilters.classList.add('has-filters');
        
        if (currentFilters.roles.length > 0 && 
            (currentFilters.roles.length > 1 || currentFilters.roles[0] !== 'All Roles')) {
            currentFilters.roles.forEach(role => {
                const roleTag = createFilterTag(`Role: ${role}`, `role-${role.toLowerCase()}`);
                activeFilters.appendChild(roleTag);
            });
        }
        
        if (currentFilters.status.length < 2) {
            currentFilters.status.forEach(status => {
                const statusTag = createFilterTag(`Status: ${status}`, `status-${status.toLowerCase()}`);
                activeFilters.appendChild(statusTag);
            });
        }
        
        if (currentFilters.link.length > 0 && 
            (currentFilters.link.length > 1 || currentFilters.link[0] !== 'All Accounts')) {
            currentFilters.link.forEach(link => {
                const linkTag = createFilterTag(`Link: ${link}`, `link-${link.toLowerCase()}`);
                activeFilters.appendChild(linkTag);
            });
        }
        
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
        if (filterType.startsWith('role-')) {
            const filterName = filterType.replace('role-', '');
            const index = currentFilters.roles.indexOf(
                filterName.charAt(0).toUpperCase() + filterName.slice(1)
            );
            if (index > -1) currentFilters.roles.splice(index, 1);
        } else if (filterType.startsWith('status-')) {
            const filterName = filterType.replace('status-', '');
            const index = currentFilters.status.indexOf(
                filterName.charAt(0).toUpperCase() + filterName.slice(1)
            );
            if (index > -1) currentFilters.status.splice(index, 1);
        } else if (filterType.startsWith('link-')) {
            const filterName = filterType.replace('link-', '');
            const index = currentFilters.link.indexOf(
                filterName.split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')
            );
            if (index > -1) currentFilters.link.splice(index, 1);
        } else if (filterType === 'search') {
            currentFilters.search = '';
            searchInput.value = '';
        }
        
        updateFilterInputs();
        updateActiveFilters();
        filterAccounts();
    }
    
    function updateFilterInputs() {
        document.getElementById('role-all').checked = currentFilters.roles.includes('All Roles');
        document.getElementById('role-admin').checked = currentFilters.roles.includes('Admin');
        document.getElementById('role-cashier').checked = currentFilters.roles.includes('Cashier');
        
        document.getElementById('status-active').checked = currentFilters.status.includes('Active');
        document.getElementById('status-inactive').checked = currentFilters.status.includes('Inactive');
        
        document.getElementById('link-all').checked = currentFilters.link.includes('All Accounts');
        document.getElementById('link-linked').checked = currentFilters.link.includes('Linked');
        document.getElementById('link-external').checked = currentFilters.link.includes('External');
    }
    
    function filterAccounts() {
        const rows = accountsTableBody.getElementsByTagName('tr');
        let visibleCount = 0;
        
        for (let row of rows) {
            if (row.cells.length < 2) continue;
            
            const email = row.cells[1].textContent.toLowerCase();
            const role = row.cells[3].textContent.trim();
            const status = row.cells[4].textContent.trim();
            const employeeCell = row.cells[2];
            const hasEmployeeLink = employeeCell ? !employeeCell.textContent.includes('No Employee Linked') : false;
            
            const searchMatch = currentFilters.search === '' || 
                               email.includes(currentFilters.search) ||
                               row.textContent.toLowerCase().includes(currentFilters.search);
            
            const roleMatch = currentFilters.roles.includes('All Roles') || currentFilters.roles.includes(role);
            const statusMatch = currentFilters.status.includes(status);
            
            let linkMatch = false;
            if (currentFilters.link.includes('All Accounts')) {
                linkMatch = true;
            } else {
                if (currentFilters.link.includes('Linked') && hasEmployeeLink) linkMatch = true;
                if (currentFilters.link.includes('External') && !hasEmployeeLink) linkMatch = true;
            }
            
            if (searchMatch && roleMatch && statusMatch && linkMatch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        }
        
        totalCount.textContent = visibleCount;
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        filterAccounts();
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            sidebar.classList.remove('mobile-open');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    // === Auto-display employee role in Create Account Modal ===
const employeeSelect = document.getElementById('employee_id');
const detectedRoleDisplay = document.getElementById('detected_role_display');
const roleHiddenInput = document.getElementById('role_hidden');

if (employeeSelect && detectedRoleDisplay && roleHiddenInput) {
    employeeSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        // Debug: Log the selected option to see what data-role contains
        console.log('Selected option:', selectedOption);
        console.log('data-role attribute:', selectedOption.getAttribute('data-role'));
        
        // Get the role from data-role attribute
        const role = selectedOption.getAttribute('data-role');
        
        // Update role display
        if (role && role.trim() !== '') {
            detectedRoleDisplay.value = role;
            roleHiddenInput.value = role;
        } else if (this.value === '') {
            detectedRoleDisplay.value = '';
            roleHiddenInput.value = '';
            detectedRoleDisplay.placeholder = 'Select an employee to see role';
        } else {
            detectedRoleDisplay.value = 'No role registered';
            roleHiddenInput.value = '';
        }
    });
}

// Also, let's add a test function to check all option elements
document.addEventListener('DOMContentLoaded', function() {
    // Check if employee select exists and has options
    if (employeeSelect) {
        console.log('Employee select options:');
        for (let i = 0; i < employeeSelect.options.length; i++) {
            const option = employeeSelect.options[i];
            console.log(`Option ${i}:`, {
                text: option.text,
                value: option.value,
                'data-role': option.getAttribute('data-role'),
                disabled: option.disabled
            });
        }
    }
});

    // Reset create modal form when opened
    const addAccountModal = document.getElementById('addAccountModal');
    const createAccountForm = document.getElementById('createAccountForm');

    if (addAccountModal) {
        addAccountModal.addEventListener('show.bs.modal', function() {
            if (createAccountForm) {
                createAccountForm.reset();
            }
            
            if (employeeSelect) {
                employeeSelect.selectedIndex = 0;
                // Trigger change event to reset role display
                employeeSelect.dispatchEvent(new Event('change'));
            }
        });
    }

    // Form validation before submission
    if (createAccountForm) {
        createAccountForm.addEventListener('submit', function(event) {
            const selectedOption = employeeSelect.options[employeeSelect.selectedIndex];
            
            // Check if employee is selected
            if (!employeeSelect.value) {
                event.preventDefault();
                alert('Please select an employee.');
                employeeSelect.focus();
                return false;
            }
            
            // Check if selected employee already has an account
            if (selectedOption && selectedOption.disabled) {
                event.preventDefault();
                alert('This employee already has an account. Please select a different employee.');
                employeeSelect.focus();
                return false;
            }

            // Validate role is Cashier or Admin
            const selectedRole = roleHiddenInput.value;
            if (!['Cashier', 'Admin'].includes(selectedRole)) {
                event.preventDefault();
                alert('Only Cashier and Admin roles can have accounts. Please select a valid employee.');
                employeeSelect.focus();
                return false;
            }

            return true;
        });
    }
</script>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inventory Report - Dora's Oshoppe</title>

    <style>
        body {
            font-family: DejaVu Sans, Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #2c2c2c;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .container {
            width: 100%;
            padding: 20px 30px;
        }

        /* HEADER */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 3px solid #3b3183;
            padding-bottom: 10px;
        }

        .logo {
            width: 110px;
            vertical-align: middle;
        }

        .title-section {
            text-align: right;
            vertical-align: middle;
        }

        h1 {
            color: #3b3183;
            font-size: 24px;
            margin: 0;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .subtitle {
            font-size: 12px;
            color: #666;
        }

        /* META */
        .meta {
            font-size: 11px;
            color: #555;
            margin: 15px 0 20px;
            display: table;
            width: 100%;
        }

        .meta div {
            display: table-cell;
        }

        /* STATS */
        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 25px;
            border-spacing: 10px;
        }

        .stat-card {
            display: table-cell;
            background: #f4f5fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 14px;
            text-align: center;
            width: 25%;
        }

        .stat-title {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 6px;
        }

        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #3b3183;
            margin-bottom: 4px;
        }

        .stat-note {
            font-size: 9px;
            color: #777;
        }

        /* TABLE */
        h2 {
            font-size: 14px;
            color: #3b3183;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        th {
            background: #3b3183;
            color: #fff;
            padding: 9px;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border: 1px solid #3b3183;
        }

        td {
            padding: 8px;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background: #f9f9fc;
        }

        .text-right {
            text-align: right;
        }

        /* STATUS */
        .status-badge {
            padding: 4px 9px;
            border-radius: 12px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            color: #fff;
        }

        .status-in-stock { background: #28a745; }
        .status-low-stock { background: #fd7e14; }
        .status-out-stock { background: #dc3545; }

        /* FOOTER TOTAL */
        tfoot td {
            background: #3b3183;
            color: #fff;
            font-weight: bold;
            font-size: 11px;
        }

        /* FOOTER */
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 9px;
            color: #777;
        }

        .page-number {
            position: fixed;
            bottom: 15px;
            right: 25px;
            font-size: 9px;
            color: #666;
        }
    </style>
</head>

<body>
<div class="container">

    <!-- HEADER -->
    <div class="header">
    <img src="{{ public_path('images/logo1.png') }}" class="logo">
    <div class="title-section">
            <h1>Inventory Report</h1>
            <div class="subtitle">Dora's Oshoppe – Gift Shop</div>
        </div>
    </div>

    <!-- META -->
    <div class="meta">
        <div>Generated on: {{ $generatedAt->format('F d, Y h:i A') }}</div>
        <div style="text-align:right;">Report Date: {{ $generatedAt->format('F d, Y') }}</div>
    </div>

    <!-- STATS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-title">Total Products</div>
            <div class="stat-value">{{ $products->count() }}</div>
            <div class="stat-note">Active items</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Inventory Value</div>
            <div class="stat-value">₱{{ number_format($grandTotalValue ?? 0, 2) }}</div>
            <div class="stat-note">Cost-based</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Low Stock</div>
            <div class="stat-value">{{ $lowStockCount ?? 0 }}</div>
            <div class="stat-note">Needs reorder</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Out of Stock</div>
            <div class="stat-value">{{ $outOfStockCount ?? 0 }}</div>
            <div class="stat-note">Urgent</div>
        </div>
    </div>

    <!-- TABLE -->
    <h2>Product Inventory Details</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>SKU</th>
                <th>Product</th>
                <th>Category</th>
                <th>Unit</th>
                <th>Supplier</th>
                <th class="text-right">Stock</th>
                <th class="text-right">Reorder</th>
                <th>Status</th>
                <th class="text-right">Cost</th>
                <th class="text-right">Price</th>
                <th class="text-right">Value</th>
                <th>Updated</th>
            </tr>
        </thead>

        <tbody>
        @php $computedGrandTotal = 0; @endphp
        @foreach($products as $product)
            @php
                $cost = $product->pricing->OriginalPrice ?? 0;
                $value = $product->current_stock * $cost;
                $computedGrandTotal += $value;

                if ($product->current_stock <= 0) {
                    $status = 'Out of Stock';
                    $class = 'status-out-stock';
                } elseif ($product->current_stock <= ($product->ReorderLvl ?? 10)) {
                    $status = 'Low Stock';
                    $class = 'status-low-stock';
                } else {
                    $status = 'In Stock';
                    $class = 'status-in-stock';
                }
            @endphp
            <tr>
                <td>{{ $product->ProductID }}</td>
                <td>{{ $product->SKUNumber }}</td>
                <td>{{ $product->ProductName }}</td>
                <td>{{ $product->category->CategoryName ?? 'N/A' }}</td>
                <td>{{ $product->unit_of_measure ?? 'pcs' }}</td>
                <td>{{ $product->supplier->SupplierName ?? 'N/A' }}</td>
                <td class="text-right">{{ $product->current_stock }}</td>
                <td class="text-right">{{ $product->ReorderLvl ?? 5 }}</td>
                <td><span class="status-badge {{ $class }}">{{ $status }}</span></td>
                <td class="text-right">₱{{ number_format($cost, 2) }}</td>
                <td class="text-right">₱{{ number_format($product->pricing->RetailPrice ?? 0, 2) }}</td>
                <td class="text-right">₱{{ number_format($value, 2) }}</td>
                <td>{{ optional($product->updated_at)->format('Y-m-d') }}</td>
            </tr>
        @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="11">Grand Total Inventory Value</td>
                <td class="text-right">₱{{ number_format($computedGrandTotal, 2) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        Confidential – Dora's Oshoppe Gift Shop | Generated by Inventory System
    </div>

    <div class="page-number">
        Page {PAGENO} of {nbpg}
    </div>

</div>
</body>
</html>

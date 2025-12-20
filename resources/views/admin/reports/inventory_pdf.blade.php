<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inventory Report - Dora's Oshoppe</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 30px;
            background: #fff;
        }
        .container {
            max-width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px double #3b3183;
        }
        .logo {
            width: 120px;
            height: auto;
            margin-bottom: 15px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .header h1 {
            margin: 10px 0 5px;
            font-size: 28px;
            font-weight: 700;
            color: #3b3183;
            letter-spacing: 1px;
        }
        .header .subtitle {
            font-size: 16px;
            color: #666;
            margin: 0;
        }
        .report-title {
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0;
            color: #3b3183;
        }
        .generated {
            font-size: 12px;
            color: #777;
            margin-top: 10px;
        }
        .summary {
            display: flex;
            justify-content: space-around;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            flex-wrap: wrap;
            gap: 20px;
        }
        .summary-item {
            text-align: center;
            min-width: 150px;
        }
        .summary-item .value {
            font-size: 22px;
            font-weight: bold;
            color: #3b3183;
        }
        .summary-item .label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
            font-size: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border-radius: 10px;
            overflow: hidden;
        }
        th {
            background: linear-gradient(to bottom, #3b3183, #2a2265);
            color: white;
            padding: 12px 10px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
            font-size: 10px;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        tr:hover {
            background-color: #f1f3f5;
        }
        .text-right {
            text-align: right;
            font-weight: 600;
        }
        .status-in-stock {
            color: #23b07a;
            font-weight: bold;
            background: rgba(35, 176, 122, 0.1);
            padding: 4px 8px;
            border-radius: 4px;
        }
        .status-low-stock {
            color: #f08a24;
            font-weight: bold;
            background: rgba(240, 138, 36, 0.1);
            padding: 4px 8px;
            border-radius: 4px;
        }
        .status-out-of-stock {
            color: #e05252;
            font-weight: bold;
            background: rgba(224, 82, 82, 0.1);
            padding: 4px 8px;
            border-radius: 4px;
        }
        .total-row {
            background: linear-gradient(to right, #3b3183, #2a2265);
            color: white;
            font-weight: bold;
            font-size: 14px;
        }
        .total-row td {
            padding: 15px 10px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 2px solid #eee;
            padding-top: 15px;
        }
        @page {
            margin: 1cm;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('images/logo1.png') }}" alt="Dora's Oshoppe Logo" class="logo">
            <h1>Dora's Oshoppe</h1>
            <p class="subtitle">Gift Shop Inventory Report</p>
            <p class="generated">Generated on: {{ $generatedAt->format('F j, Y \a\t g:i A') }}</p>
        </div>

        <div class="summary">
            <div class="summary-item">
                <div class="value">{{ $products->count() }}</div>
                <div class="label">Total Products</div>
            </div>
            <div class="summary-item">
                <div class="value">{{ $products->where('current_stock', '>', 0)->count() }}</div>
                <div class="label">In Stock</div>
            </div>
            <div class="summary-item">
                <div class="value">{{ $products->where('current_stock', '<=', \DB::raw('COALESCE(ReorderLvl, 5)'))->where('current_stock', '>', 0)->count() }}</div>
                <div class="label">Low Stock</div>
            </div>
            <div class="summary-item">
                <div class="value">{{ $products->where('current_stock', '<=', 0)->count() }}</div>
                <div class="label">Out of Stock</div>
            </div>
            <div class="summary-item">
                <div class="value">₱{{ number_format($products->sum(\DB::raw('current_stock * COALESCE((SELECT OriginalPrice FROM pricing WHERE pricing.ProductID = products.ProductID AND pricing.IsActive = "yes" ORDER BY EffectiveDate DESC LIMIT 1), 0)')), 2) }}</div>
                <div class="label">Total Inventory Value (Cost)</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>SKU</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th class="text-right">Current Stock</th>
                    <th class="text-right">Reorder Level</th>
                    <th>Status</th>
                    <th class="text-right">Cost Price</th>
                    <th class="text-right">Retail Price</th>
                    <th class="text-right">Total Value (Cost)</th>
                    <th>Last Updated</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    @php
                        $status = 'In Stock';
                        $statusClass = 'status-in-stock';
                        if ($product->current_stock <= 0) {
                            $status = 'Out of Stock';
                            $statusClass = 'status-out-of-stock';
                        } elseif ($product->current_stock <= ($product->ReorderLvl ?? 5)) {
                            $status = 'Low Stock';
                            $statusClass = 'status-low-stock';
                        }
                        $costPrice = $product->pricing?->OriginalPrice ?? 0;
                        $retailPrice = $product->pricing?->RetailPrice ?? 0;
                        $totalValue = $product->current_stock * $costPrice;
                    @endphp
                    <tr>
                        <td><strong>{{ $product->ProductID }}</strong></td>
                        <td>{{ $product->SKUNumber }}</td>
                        <td>{{ $product->ProductName }}</td>
                        <td>{{ $product->category?->CategoryName ?? 'Uncategorized' }}</td>
                        <td class="text-right"><strong>{{ $product->current_stock }}</strong></td>
                        <td class="text-right">{{ $product->ReorderLvl ?? 5 }}</td>
                        <td class="{{ $statusClass }}">{{ $status }}</td>
                        <td class="text-right">₱{{ number_format($costPrice, 2) }}</td>
                        <td class="text-right">₱{{ number_format($retailPrice, 2) }}</td>
                        <td class="text-right">₱{{ number_format($totalValue, 2) }}</td>
                        <td>{{ optional($product->updated_at)->format('M j, Y g:i A') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="9" style="text-align: right;">GRAND TOTAL INVENTORY VALUE (COST):</td>
                    <td colspan="2">₱{{ number_format($products->sum(function($p) { return $p->current_stock * ($p->pricing?->OriginalPrice ?? 0); }), 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="footer">
            <p>This report was generated automatically by the Dora's Oshoppe Management System.</p>
            <p>&copy; {{ date('Y') }} Dora's Oshoppe. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
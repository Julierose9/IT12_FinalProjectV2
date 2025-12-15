<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inventory Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { margin-bottom: 6px; }
        .meta { color: #555; margin-bottom: 14px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        th { background: #f5f5f5; font-weight: bold; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>Inventory Report</h2>
    <div class="meta">Generated at: {{ $generatedAt->format('M d, Y h:i A') }}</div>

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
                <th class="text-right">Cost</th>
                <th class="text-right">Price</th>
                <th class="text-right">Total Value (Cost)</th>
                <th>Last Updated</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                @php
                    $status = 'In Stock';
                    if ($product->current_stock <= 0) {
                        $status = 'Out of Stock';
                    } elseif ($product->current_stock <= ($product->ReorderLvl ?? 5)) {
                        $status = 'Low Stock';
                    }
                    $costPrice = $product->pricing->OriginalPrice ?? 0;
                    $retailPrice = $product->pricing->RetailPrice ?? 0;
                    $totalValue = $product->current_stock * $costPrice;
                @endphp
                <tr>
                    <td>{{ $product->ProductID }}</td>
                    <td>{{ $product->SKUNumber }}</td>
                    <td>{{ $product->ProductName }}</td>
                    <td>{{ $product->category?->CategoryName ?? 'Uncategorized' }}</td>
                    <td class="text-right">{{ $product->current_stock }}</td>
                    <td class="text-right">{{ $product->ReorderLvl ?? 5 }}</td>
                    <td>{{ $status }}</td>
                    <td class="text-right">{{ number_format($costPrice, 2) }}</td>
                    <td class="text-right">{{ number_format($retailPrice, 2) }}</td>
                    <td class="text-right">{{ number_format($totalValue, 2) }}</td>
                    <td>{{ optional($product->updated_at)->format('Y-m-d H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>


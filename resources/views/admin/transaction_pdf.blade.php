<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Report - Dora's Oshoppe</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #3b3183;
        }
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 12px;
        }
        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding: 12px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .summary-item {
            text-align: center;
            flex: 1;
        }
        .summary-item .value {
            font-size: 16px;
            font-weight: bold;
            color: #3b3183;
        }
        .summary-item .label {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 9px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
        }
        .status-completed {
            color: #23b07a;
            font-weight: bold;
        }
        .status-cancelled {
            color: #e05252;
            font-weight: bold;
        }
        .total-row {
            background-color: #e9ecef;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }
        .items-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .items-list li {
            margin-bottom: 2px;
            font-size: 9px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Dora's Oshoppe</h1>
        <p>Gift Shop Transaction Report</p>
        <p>Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <div class="value">{{ $totalOrders }}</div>
            <div class="label">Total Transactions</div>
        </div>
        <div class="summary-item">
            <div class="value">₱{{ number_format($totalAmount, 2) }}</div>
            <div class="label">Total Amount</div>
        </div>
        <div class="summary-item">
            <div class="value">{{ $orders->where('OrderStatus', 'Completed')->count() }}</div>
            <div class="label">Completed</div>
        </div>
        <div class="summary-item">
            <div class="value">{{ $orders->where('OrderStatus', 'Cancelled')->count() }}</div>
            <div class="label">Cancelled</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Cashier</th>
                <th>Items</th>
                <th>Amount</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->OrderID }}</td>
                <td>
                    @if($order->employee)
                        {{ $order->employee->EmployeeFName }} {{ $order->employee->EmployeeLName }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    <ul class="items-list">
                        @foreach($order->items as $item)
                        <li>{{ $item->Quantity }}x {{ $item->product->ProductName ?? 'Unknown Product' }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>₱{{ number_format($order->TotalAmount ?? $order->GrandTotal ?? 0, 2) }}</td>
                <td>{{ $order->PaymentMethod ?? $order->payment->PaymentType ?? 'Cash' }}</td>
                <td class="status-{{ strtolower($order->OrderStatus) }}">{{ $order->OrderStatus }}</td>
                <td>{{ \Carbon\Carbon::parse($order->OrderDateTime)->format('M j, Y g:i A') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" style="text-align: right; font-weight: bold;">TOTAL:</td>
                <td style="font-weight: bold;">₱{{ number_format($totalAmount, 2) }}</td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>This report was generated automatically by the Dora's Oshoppe Management System.</p>
        <p>&copy; {{ date('Y') }} Dora's Oshoppe. All rights reserved.</p>
    </div>
</body>
</html>
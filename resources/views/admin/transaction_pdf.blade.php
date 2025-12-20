<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Report - Dora's Oshoppe</title>
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
        .status-completed {
            color: #23b07a;
            font-weight: bold;
            background: rgba(35, 176, 122, 0.1);
            padding: 4px 8px;
            border-radius: 4px;
        }
        .status-cancelled {
            color: #e05252;
            font-weight: bold;
            background: rgba(224, 82, 82, 0.1);
            padding: 4px 8px;
            border-radius: 4px;
        }
        .items-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .items-list li {
            margin-bottom: 4px;
            padding-left: 10px;
            position: relative;
        }
        .items-list li:before {
            content: "•";
            color: #3b3183;
            font-weight: bold;
            position: absolute;
            left: 0;
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
        .page-break {
            page-break-after: always;
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
            <p class="subtitle">Gift Shop Transaction Report</p>
            <p class="generated">Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</p>
        </div>

        <div class="summary">
            <div class="summary-item">
                <div class="value">{{ $totalOrders }}</div>
                <div class="label">Total Transactions</div>
            </div>
            <div class="summary-item">
                <div class="value">₱{{ number_format($totalAmount, 2) }}</div>
                <div class="label">Total Sales Amount</div>
            </div>
            <div class="summary-item">
                <div class="value">{{ $orders->where('OrderStatus', 'Completed')->count() }}</div>
                <div class="label">Completed Orders</div>
            </div>
            <div class="summary-item">
                <div class="value">{{ $orders->where('OrderStatus', 'Cancelled')->count() }}</div>
                <div class="label">Cancelled Orders</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Cashier</th>
                    <th>Items</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Date & Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><strong>{{ $order->OrderID }}</strong></td>
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
                            <li>{{ $item->Quantity }} × {{ $item->product->ProductName ?? 'Unknown Product' }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td><strong>₱{{ number_format($order->TotalAmount ?? $order->GrandTotal ?? 0, 2) }}</strong></td>
                    <td>{{ ucfirst($order->PaymentMethod ?? $order->payment->PaymentType ?? 'Cash') }}</td>
                    <td class="status-{{ strtolower($order->OrderStatus) }}">{{ $order->OrderStatus }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->OrderDateTime)->format('M j, Y g:i A') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" style="text-align: right;">GRAND TOTAL:</td>
                    <td colspan="4">₱{{ number_format($totalAmount, 2) }}</td>
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
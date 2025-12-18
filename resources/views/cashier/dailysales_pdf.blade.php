<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Daily Sales Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            font-size: 12px;
        }
        
        .container {
            width: 100%;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3b3183;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 24px;
            color: #3b3183;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 11px;
            color: #666;
            margin: 2px 0;
        }
        
        .summary {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }
        
        .summary-item {
            flex: 1;
            min-width: 150px;
            padding: 12px;
            background: #f5f7fb;
            border-left: 4px solid #3b3183;
            border-radius: 4px;
        }
        
        .summary-item-label {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .summary-item-value {
            font-size: 18px;
            font-weight: bold;
            color: #3b3183;
        }
        
        .table-section {
            margin-top: 20px;
        }
        
        .table-title {
            font-size: 14px;
            font-weight: bold;
            color: #3b3183;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 8px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        thead {
            background: #3b3183;
            color: white;
        }
        
        th {
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #3b3183;
        }
        
        td {
            padding: 10px;
            border: 1px solid #eee;
            font-size: 11px;
        }
        
        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        tbody tr:hover {
            background: #f0f0f0;
        }
        
        tfoot tr {
            background: #efeaff;
            font-weight: bold;
        }
        
        tfoot td {
            border: 1px solid #3b3183;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .currency {
            color: #23b07a;
            font-weight: bold;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Daily Sales Report</h1>
            <p><strong>Dora's Oshoppe</strong></p>
            <p>Date: {{ $selectedDate->format('F d, Y') }}</p>
            <p>Generated: {{ now()->format('M d, Y h:i A') }}</p>
        </div>

        <!-- Summary Section -->
        <div class="summary">
            <div class="summary-item">
                <div class="summary-item-label">Total Transactions</div>
                <div class="summary-item-value">{{ $totalTransactions }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-item-label">Total Sales</div>
                <div class="summary-item-value currency">₱{{ number_format($totalSales, 2) }}</div>
            </div>
            @if($totalTransactions > 0)
            <div class="summary-item">
                <div class="summary-item-label">Average per Transaction</div>
                <div class="summary-item-value currency">₱{{ number_format($totalSales / $totalTransactions, 2) }}</div>
            </div>
            @endif
        </div>

        <!-- Sales Breakdown Table -->
        <div class="table-section">
            <div class="table-title">Sales by Payment Method</div>
            
            @if(!empty($breakdown))
                <table>
                    <thead>
                        <tr>
                            <th>Payment Method</th>
                            <th class="text-right">Transactions</th>
                            <th class="text-right">Total Amount</th>
                            <th class="text-right">% of Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($breakdown as $method => $data)
                        <tr>
                            <td><strong>{{ ucfirst(str_replace('_', ' ', $method)) }}</strong></td>
                            <td class="text-right">{{ $data['orders'] }}</td>
                            <td class="text-right currency">₱{{ number_format($data['sales'], 2) }}</td>
                            <td class="text-right">{{ number_format($data['percentage'], 1) }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td class="text-right"><strong>{{ $totalTransactions }}</strong></td>
                            <td class="text-right currency"><strong>₱{{ number_format($totalSales, 2) }}</strong></td>
                            <td class="text-right"><strong>100%</strong></td>
                        </tr>
                    </tfoot>
                </table>
            @else
                <p style="padding: 20px; text-align: center; color: #999;">No sales data available for the selected date.</p>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This is a computer-generated report. No signature is required.</p>
            <p>© {{ now()->year }} Dora's Oshoppe. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

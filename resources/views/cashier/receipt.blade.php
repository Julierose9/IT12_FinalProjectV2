<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Order #{{ $order->OrderID }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
        }
        .receipt {
            max-width: 400px;
            margin: 0 auto;
            border: 1px dashed #000;
            padding: 20px;
            background: #fff;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        .logo {
            max-width: 120px;
            height: auto;
            margin-bottom: 10px;
        }
        .shop-name {
            font-size: 18px;
            font-weight: bold;
            margin: 5px 0;
        }
        .shop-info {
            font-size: 11px;
            color: #555;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        .order-info {
            margin: 10px 0;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        .items-table th, .items-table td {
            padding: 4px 0;
            text-align: left;
            border-bottom: 1px dashed #aaa;
        }
        .items-table th {
            font-weight: bold;
        }
        .items-table .qty {
            text-align: center;
        }
        .items-table .price {
            text-align: right;
        }
        .total-section {
            margin-top: 15px;
            font-weight: bold;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        .grand-total {
            font-size: 14px;
            border-top: 2px solid #000;
            padding-top: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 11px;
        }
        .thanks {
            font-weight: bold;
            margin-top: 20px;
        }
        @media print {
            body { padding: 0; }
            .receipt { border: none; padding: 0; }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <img src="{{ asset('images/logo_.png') }}" alt="Dora's Oshoppe" class="logo">
            <div class="shop-name">Dora's Oshoppe</div>
            <div class="shop-info">Gift Shop</div>
            <div class="shop-info">Address: [Your Shop Address]</div>
            <div class="shop-info">Contact: [Your Phone Number]</div>
        </div>

        <div class="divider"></div>

        <div class="order-info">
            <div><strong>Order ID:</strong> #{{ $order->OrderID }}</div>
            <div><strong>Date:</strong> {{ $order->OrderDateTime->format('M d, Y h:i A') }}</div>
            <div><strong>Cashier:</strong> {{ $order->employee->EmployeeFName ?? 'System' }} {{ $order->employee->EmployeeLName ?? '' }}</div>
        </div>

        <div class="divider"></div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="qty">Qty</th>
                    <th class="price">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->details as $detail)
                    <tr>
                        <td>{{ $detail->product->ProductName ?? 'N/A' }}</td>
                        <td class="qty">{{ $detail->Quantity }}</td>
                        <td class="price">₱{{ number_format($detail->Subtotal ?? 0, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>₱{{ number_format($order->SubTotal ?? 0, 2) }}</span>
            </div>
            @if($order->DiscountAmount > 0)
                <div class="total-row">
                    <span>Discount:</span>
                    <span>-₱{{ number_format($order->DiscountAmount, 2) }}</span>
                </div>
            @endif
            <div class="total-row grand-total">
                <span>Grand Total:</span>
                <span>₱{{ number_format($order->GrandTotal ?? 0, 2) }}</span>
            </div>
        </div>

        <div class="divider"></div>

        <div class="footer">
            <div class="thanks">Thank you for shopping with us!</div>
            <div>Come again soon!</div>
            <div>Transaction Date: {{ now()->format('M d, Y h:i A') }}</div>
        </div>
    </div>
</body>
</html>
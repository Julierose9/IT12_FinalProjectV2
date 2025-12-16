<div class="transaction-details">
  <div class="row">
    <div class="col-md-6">
      <h6 class="fw-bold mb-3">Order Information</h6>
      <div class="mb-2"><strong>Order ID:</strong> {{ $order->OrderID }}</div>
      <div class="mb-2"><strong>Cashier:</strong> {{ $order->employee->EmployeeFName ?? 'N/A' }} {{ $order->employee->EmployeeLName ?? '' }}</div>
      <div class="mb-2"><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->OrderDateTime)->format('M d, Y h:i A') }}</div>
      <div class="mb-2"><strong>Status:</strong>
        <span class="badge {{ $order->OrderStatus === 'Completed' ? 'bg-success' : 'bg-danger' }}">
          {{ $order->OrderStatus }}
        </span>
      </div>
      <div class="mb-2"><strong>Payment Method:</strong> {{ $order->payment->PaymentType ?? $order->PaymentMethod ?? 'N/A' }}</div>
    </div>
    <div class="col-md-6">
      <h6 class="fw-bold mb-3">Payment Details</h6>
      <div class="mb-2"><strong>Subtotal:</strong> ₱{{ number_format($order->SubTotal ?? 0, 2) }}</div>
      @if($order->DiscountAmount > 0)
      <div class="mb-2"><strong>Discount:</strong> ₱{{ number_format($order->DiscountAmount ?? 0, 2) }}</div>
      @endif
      <div class="mb-2"><strong>Total Amount:</strong> ₱{{ number_format($order->GrandTotal ?? 0, 2) }}</div>
      <div class="mb-2"><strong>Amount Paid:</strong> ₱{{ number_format($order->AmountPaid ?? 0, 2) }}</div>
      <div class="mb-2"><strong>Balance:</strong> ₱{{ number_format($order->Balance ?? 0, 2) }}</div>
    </div>
  </div>

  <hr>

  <h6 class="fw-bold mb-3">Order Items</h6>
  <div class="table-responsive">
    <table class="table table-sm">
      <thead>
        <tr>
          <th>Product</th>
          <th>Quantity</th>
          <th>Unit Price</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        @forelse($order->items ?? $order->details ?? [] as $item)
        <tr>
          <td>{{ $item->product->ProductName ?? 'Unknown Product' }}</td>
          <td>{{ $item->Quantity ?? $item->OrderQty }}</td>
          <td>₱{{ number_format($item->Price ?? 0, 2) }}</td>
          <td>₱{{ number_format(($item->Quantity ?? $item->OrderQty) * ($item->Price ?? 0), 2) }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="text-center text-muted">No items found</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
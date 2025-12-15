<div class="transaction-history-content">
    {{-- Product Info --}}
    <div class="mb-4 p-3 bg-light rounded">
        <div class="row">
            <div class="col-md-6">
                <h6 class="mb-2"><strong>Product Information</strong></h6>
                <p class="mb-1"><strong>Product:</strong> {{ $product->ProductName }}</p>
                <p class="mb-1"><strong>SKU:</strong> {{ $product->SKUNumber }}</p>
                <p class="mb-1"><strong>Category:</strong> {{ $product->category->CategoryName ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="mb-2"><strong>Current Stock</strong></h6>
                <p class="mb-1"><strong>Available:</strong> <span class="badge bg-primary">{{ $currentStock }}</span> units</p>
                <p class="mb-1"><strong>Reorder Level:</strong> {{ $product->ReorderLvl ?? 5 }} units</p>
                @if($product->pricing)
                    <p class="mb-1"><strong>Retail Price:</strong> ₱{{ number_format($product->pricing->RetailPrice, 2) }}</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Tabs for different transaction types --}}
    <ul class="nav nav-tabs mb-3" id="transactionTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="stockin-tab" data-bs-toggle="tab" data-bs-target="#stockin" type="button" role="tab">
                Stock In ({{ $stockIns->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="sales-tab" data-bs-toggle="tab" data-bs-target="#sales" type="button" role="tab">
                Sales ({{ $sales->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pullout-tab" data-bs-toggle="tab" data-bs-target="#pullout" type="button" role="tab">
                Pull Outs ({{ $pullOuts->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="movements-tab" data-bs-toggle="tab" data-bs-target="#movements" type="button" role="tab">
                Movements ({{ $movements->count() }})
            </button>
        </li>
    </ul>

    <div class="tab-content" id="transactionTabsContent">
        {{-- Stock In Tab --}}
        <div class="tab-pane fade show active" id="stockin" role="tabpanel">
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Stock In ID</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Supplier</th>
                            <th>Expiration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stockIns as $stockIn)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($stockIn->DateRcvd)->format('M d, Y') }}</td>
                            <td><code>{{ $stockIn->StockInID }}</code></td>
                            <td><span class="badge bg-success">+{{ $stockIn->Qty }}</span></td>
                            <td>
                                @if($stockIn->ProdStatus == 'Received')
                                    <span class="badge bg-success">Received</span>
                                @elseif($stockIn->ProdStatus == 'Defective')
                                    <span class="badge bg-danger">Defective</span>
                                @else
                                    <span class="badge bg-warning">{{ $stockIn->ProdStatus }}</span>
                                @endif
                            </td>
                            <td>{{ $stockIn->supplier->SupplierName ?? 'N/A' }}</td>
                            <td>{{ $stockIn->ExpirationDate ? \Carbon\Carbon::parse($stockIn->ExpirationDate)->format('M d, Y') : 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">No stock in records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sales Tab --}}
        <div class="tab-pane fade" id="sales" role="tabpanel">
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Order ID</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                            <th>Cashier</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td>{{ $sale->order->OrderDateTime->format('M d, Y h:i A') ?? 'N/A' }}</td>
                            <td><code>{{ $sale->order->OrderID ?? 'N/A' }}</code></td>
                            <td><span class="badge bg-danger">-{{ $sale->OrderQty }}</span></td>
                            <td>₱{{ number_format($sale->UnitPrice ?? 0, 2) }}</td>
                            <td>₱{{ number_format($sale->Subtotal ?? 0, 2) }}</td>
                            <td>
                                @if($sale->order && $sale->order->employee)
                                    {{ $sale->order->employee->EmpFName ?? '' }} {{ $sale->order->employee->EmpLName ?? '' }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">No sales records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pull Out Tab --}}
        <div class="tab-pane fade" id="pullout" role="tabpanel">
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Pull Out ID</th>
                            <th>Quantity</th>
                            <th>Type</th>
                            <th>Reason</th>
                            <th>Employee</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pullOuts as $pullOut)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($pullOut->DatePullOut)->format('M d, Y') }}</td>
                            <td><code>{{ $pullOut->PullOutID }}</code></td>
                            <td><span class="badge bg-warning">-{{ $pullOut->PullOutQty }}</span></td>
                            <td><span class="badge bg-secondary">{{ $pullOut->PullOutType }}</span></td>
                            <td>{{ $pullOut->PullOutReason }}</td>
                            <td>
                                @if($pullOut->employee)
                                    {{ $pullOut->employee->EmpFName ?? '' }} {{ $pullOut->employee->EmpLName ?? '' }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">No pull out records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Movements Tab --}}
        <div class="tab-pane fade" id="movements" role="tabpanel">
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Quantity Change</th>
                            <th>Reference</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movements as $movement)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($movement->ChangeDateTime)->format('M d, Y h:i A') }}</td>
                            <td>
                                @if($movement->ChangeType == 'Decrease')
                                    <span class="badge bg-danger">Decrease</span>
                                @else
                                    <span class="badge bg-success">Increase</span>
                                @endif
                            </td>
                            <td>
                                @if($movement->ChangeType == 'Decrease')
                                    <span class="text-danger">-{{ $movement->QtyChange }}</span>
                                @else
                                    <span class="text-success">+{{ $movement->QtyChange }}</span>
                                @endif
                            </td>
                            <td>
                                @if($movement->reference_type == 'Order')
                                    Order #{{ $movement->reference_id }}
                                @elseif($movement->reference_type == 'stock_in')
                                    Stock In #{{ $movement->reference_id }}
                                @elseif($movement->reference_type == 'pullout')
                                    Pullout #{{ $movement->reference_id }}
                                @else
                                    {{ $movement->reference_id ?? '-' }}
                                @endif
                            </td>
                            <td>{{ $movement->notes ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">No inventory movements found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Summary --}}
    <div class="mt-4 p-3 bg-light rounded">
        <h6 class="mb-3"><strong>Summary</strong></h6>
        <div class="row">
            <div class="col-md-3">
                <div class="text-center">
                    <div class="h5 text-success mb-1">{{ $stockIns->where('ProdStatus', 'Received')->sum('Qty') }}</div>
                    <small class="text-muted">Total Stock In</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="h5 text-danger mb-1">{{ $sales->sum('OrderQty') }}</div>
                    <small class="text-muted">Total Sold</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="h5 text-warning mb-1">{{ $pullOuts->sum('PullOutQty') }}</div>
                    <small class="text-muted">Total Pulled Out</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <div class="h5 text-primary mb-1">{{ $currentStock }}</div>
                    <small class="text-muted">Current Stock</small>
                </div>
            </div>
        </div>
    </div>
</div>


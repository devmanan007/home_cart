@extends('layouts.app')

@section('title', 'Order #' . $order->order_number)

@section('content')
    <section class="bg-dark text-white py-4">
        <div class="container py-3">
            <a href="{{ route('orders') }}" class="btn btn-outline-light btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i>Back to Orders</a>
            <h1 class="display-6 fw-bold">Order #{{ $order->order_number }}</h1>
            <span class="badge {{ $order->getStatusBadgeClass() }} fs-6">{{ ucfirst($order->status) }}</span>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Order Items</h5>
                            @foreach ($order->items as $item)
                                <div class="d-flex justify-content-between align-items-center py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    <div class="d-flex align-items-center">
                                        @if ($item->product)
                                            <img src="{{ $item->product->getPrimaryImagePath() }}" alt="{{ $item->product_name }}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: contain;">
                                        @else
                                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $item->product_name }}</strong>
                                            <small class="text-muted d-block">₹{{ number_format($item->product_price, 2) }} x {{ $item->quantity }}</small>
                                        </div>
                                    </div>
                                    <strong>₹{{ number_format($item->total, 2) }}</strong>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Shipping Address</h5>
                            <p class="text-muted mb-0">
                                {{ $order->shipping_name }}<br>
                                {{ $order->shipping_address }}<br>
                                {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}<br>
                                {{ $order->shipping_country }}<br>
                                Phone: {{ $order->shipping_phone }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">Order Summary</h5>
                            <div class="bg-light rounded p-3 mb-3">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <small class="text-muted d-block">Order Date</small>
                                        <strong class="small">{{ $order->created_at->format('M d, Y') }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Payment</small>
                                        <strong class="small">{{ $order->payment_method === 'paypal' ? 'PayPal' : 'COD' }}</strong>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Order Status</small>
                                        <span class="badge {{ $order->getStatusBadgeClass() }}">{{ ucfirst($order->status) }}</span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Payment Status</small>
                                        <span class="badge {{ $order->getPaymentStatusBadgeClass() }}">{{ ucfirst($order->payment_status) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span>₹{{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Shipping</span>
                                <span>{{ $order->shipping_cost > 0 ? '₹' . number_format($order->shipping_cost, 2) : 'Free' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tax</span>
                                <span>₹{{ number_format($order->tax, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong class="fs-5">Total</strong>
                                <strong class="fs-5 text-primary">₹{{ number_format($order->total, 2) }}</strong>
                            </div>

                            @if ($order->paypal_transaction_id)
                                <div class="bg-light rounded p-2 mb-3">
                                    <small class="text-muted">PayPal Transaction ID</small><br>
                                    <small class="fw-semibold">{{ $order->paypal_transaction_id }}</small>
                                </div>
                            @endif

                            @if ($order->notes)
                                <div class="bg-light rounded p-3">
                                    <small class="text-muted d-block mb-1">Order Notes</small>
                                    <small>{{ $order->notes }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

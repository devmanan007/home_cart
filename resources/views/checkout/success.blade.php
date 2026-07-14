@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
    <section class="bg-success text-white py-4">
        <div class="container py-3">
            <h1 class="display-6 fw-bold"><i class="bi bi-check-circle me-2"></i>Order Confirmed!</h1>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                                <h3 class="fw-bold mt-3">Thank You For Your Order!</h3>
                                <p class="text-muted">Your order has been placed successfully.</p>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="bg-light rounded p-3">
                                        <small class="text-muted d-block">Order Number</small>
                                        <strong>{{ $order->order_number }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light rounded p-3">
                                        <small class="text-muted d-block">Order Date</small>
                                        <strong>{{ $order->created_at->format('F d, Y, h:i A') }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light rounded p-3">
                                        <small class="text-muted d-block">Payment Method</small>
                                        <strong>{{ $order->payment_method === 'paypal' ? 'PayPal' : 'Cash on Delivery' }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="bg-light rounded p-3">
                                        <small class="text-muted d-block">Payment Status</small>
                                        <span class="badge {{ $order->getPaymentStatusBadgeClass() }}">{{ ucfirst($order->payment_status) }}</span>
                                    </div>
                                </div>
                            </div>

                            <h6 class="fw-bold mb-3">Order Items</h6>
                            @foreach ($order->items as $item)
                                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                    <div>
                                        <strong>{{ $item->product_name }}</strong>
                                        <small class="text-muted d-block">Qty: {{ $item->quantity }} x ₹{{ number_format($item->product_price, 2) }}</small>
                                    </div>
                                    <strong>₹{{ number_format($item->total, 2) }}</strong>
                                </div>
                            @endforeach

                            <hr>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Subtotal</span>
                                <span>₹{{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Shipping</span>
                                <span>{{ $order->shipping_cost > 0 ? '₹' . number_format($order->shipping_cost, 2) : 'Free' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Tax</span>
                                <span>₹{{ number_format($order->tax, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <strong class="fs-5">Total</strong>
                                <strong class="fs-5 text-primary">₹{{ number_format($order->total, 2) }}</strong>
                            </div>

                            <div class="bg-light rounded p-3 mb-4">
                                <h6 class="fw-bold mb-2">Shipping Address</h6>
                                <p class="mb-0 text-muted">
                                    {{ $order->shipping_name }}<br>
                                    {{ $order->shipping_address }}<br>
                                    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}<br>
                                    {{ $order->shipping_country }}<br>
                                    Phone: {{ $order->shipping_phone }}
                                </p>
                            </div>

                            <div class="d-flex gap-3">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-primary"><i class="bi bi-box-seam me-1"></i>View Order</a>
                                <a href="{{ route('shop') }}" class="btn btn-outline-primary"><i class="bi bi-shop me-1"></i>Continue Shopping</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

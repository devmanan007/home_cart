@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
    <section class="bg-dark text-white py-4">
        <div class="container py-3">
            <h1 class="display-6 fw-bold"><i class="bi bi-box-seam me-2"></i>My Orders</h1>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            @if ($orders->count())
                <div class="card border-0 shadow-sm">
                    <div class="table-responsive">
                        <table class="table table align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3">Order #</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th class="text-center pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="ps-3 fw-semibold">{{ $order->order_number }}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>{{ $order->items_count }} item(s)</td>
                                        <td class="fw-semibold">₹{{ number_format($order->total, 2) }}</td>
                                        <td><span class="badge {{ $order->getStatusBadgeClass() }}">{{ ucfirst($order->status) }}</span></td>
                                        <td><span class="badge {{ $order->getPaymentStatusBadgeClass() }}">{{ ucfirst($order->payment_status) }}</span></td>
                                        <td class="text-center pe-3">
                                            <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-box-seam display-1 text-muted"></i>
                    <h4 class="text-muted mt-3">No orders yet</h4>
                    <p class="text-muted">Start shopping to place your first order!</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary btn-lg"><i class="bi bi-shop me-1"></i>Browse Products</a>
                </div>
            @endif
        </div>
    </section>
@endsection

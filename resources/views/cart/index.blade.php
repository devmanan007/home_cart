@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <section class="bg-dark text-white py-4">
        <div class="container py-3">
            <h1 class="display-6 fw-bold"><i class="bi bi-cart3 me-2"></i>Shopping Cart</h1>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            @if (count($items) > 0)
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="border-0 ps-3">Product</th>
                                                <th class="border-0 text-center">Price</th>
                                                <th class="border-0 text-center">Quantity</th>
                                                <th class="border-0 text-center">Total</th>
                                                <th class="border-0 text-center pe-3">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $index => $item)
                                                <tr class="cart-item" data-product-id="{{ $item['product']->id }}">
                                                    <td class="ps-3">
                                                        <div class="d-flex align-items-center">
                                                            <a href="{{ route('shop.show', $item['product']->slug) }}">
                                                                <img src="{{ $item['product']->getPrimaryImagePath() }}" alt="{{ $item['product']->name }}" class="rounded" style="width: 60px; height: 60px; object-fit: contain;">
                                                            </a>
                                                            <div class="ms-3">
                                                                <a href="{{ route('shop.show', $item['product']->slug) }}" class="text-decoration-none text-dark fw-semibold">{{ $item['product']->name }}</a>
                                                                <br><small class="text-muted">{{ $item['product']->category->name }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">₹{{ number_format($item['price'], 2) }}</td>
                                                    <td class="text-center">
                                                        <form action="{{ route('cart.update', $item['product']->id) }}" method="POST" data-ajax-form data-cart-update>
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="input-group input-group-sm mx-auto" style="width: 120px;">
                                                                <button type="button" class="btn btn-outline-secondary" onclick="updateQty(this, -1)">-</button>
                                                                <input type="number" name="quantity" class="form-control text-center" value="{{ $item['quantity'] }}" min="1" max="{{ $item['product']->stock_quantity }}">
                                                                <button type="button" class="btn btn-outline-secondary" onclick="updateQty(this, 1)">+</button>
                                                            </div>
                                                        </form>
                                                    </td>
                                                    <td class="text-center fw-semibold">₹{{ number_format($item['line_total'], 2) }}</td>
                                                    <td class="text-center pe-3">
                                                        <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST" data-ajax-form data-cart-remove>
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Remove">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('shop') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-1"></i>Continue Shopping</a>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">Order Summary</h5>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span id="cart-subtotal">₹{{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Shipping</span>
                                    <span id="cart-shipping">{{ $shipping > 0 ? '₹' . number_format($shipping, 2) : 'Free' }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Tax (5%)</span>
                                    <span id="cart-tax">₹{{ number_format($tax, 2) }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total</strong>
                                    <strong id="cart-total" class="text-primary">₹{{ number_format($total, 2) }}</strong>
                                </div>
                                <a href="{{ route('checkout') }}" class="btn btn-primary w-100 btn-lg">
                                    <i class="bi bi-lock me-1"></i>Proceed to Checkout
                                </a>
                                <p class="text-muted small text-center mt-2">
                                    <i class="bi bi-shield-check me-1"></i>Secure checkout. Free shipping on orders above ₹500.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-cart-x display-1 text-muted"></i>
                    <h4 class="text-muted mt-3">Your cart is empty</h4>
                    <p class="text-muted">Looks like you haven't added any products yet.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary btn-lg"><i class="bi bi-shop me-1"></i>Start Shopping</a>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
function updateQty(btn, change) {
    const input = btn.parentElement.querySelector('input[name="quantity"]');
    const newVal = Math.max(1, parseInt(input.value) + change);
    input.value = newVal;
    input.closest('form').dispatchEvent(new Event('submit', { bubbles: true }));
}
</script>
@endpush

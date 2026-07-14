@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <section class="bg-dark text-white py-4">
        <div class="container py-3">
            <h1 class="display-6 fw-bold"><i class="bi bi-credit-card me-2"></i>Checkout</h1>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <form action="{{ route('checkout.place') }}" method="POST" id="checkoutForm">
                @csrf
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3"><i class="bi bi-geo-alt me-2"></i>Shipping Information</h5>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="shipping_name" class="form-control @error('shipping_name') is-invalid @enderror" value="{{ old('shipping_name', auth()->user()->name) }}" required>
                                        @error('shipping_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                                        <input type="text" name="shipping_phone" class="form-control @error('shipping_phone') is-invalid @enderror" value="{{ old('shipping_phone') }}" required>
                                        @error('shipping_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Address <span class="text-danger">*</span></label>
                                        <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" rows="2" required>{{ old('shipping_address') }}</textarea>
                                        @error('shipping_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">City <span class="text-danger">*</span></label>
                                        <input type="text" name="shipping_city" class="form-control @error('shipping_city') is-invalid @enderror" value="{{ old('shipping_city') }}" required>
                                        @error('shipping_city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">State <span class="text-danger">*</span></label>
                                        <input type="text" name="shipping_state" class="form-control @error('shipping_state') is-invalid @enderror" value="{{ old('shipping_state') }}" required>
                                        @error('shipping_state')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Postal Code <span class="text-danger">*</span></label>
                                        <input type="text" name="shipping_postal_code" class="form-control @error('shipping_postal_code') is-invalid @enderror" value="{{ old('shipping_postal_code') }}" required>
                                        @error('shipping_postal_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Country <span class="text-danger">*</span></label>
                                        <input type="text" name="shipping_country" class="form-control @error('shipping_country') is-invalid @enderror" value="{{ old('shipping_country', 'India') }}" required>
                                        @error('shipping_country')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                @if ($addresses->count())
                                    <hr>
                                    <h6 class="fw-semibold mb-2">Saved Addresses</h6>
                                    <div class="row g-2">
                                        @foreach ($addresses as $address)
                                            <div class="col-md-6">
                                                <div class="form-check card card-body p-3">
                                                    <input class="form-check-input" type="radio" name="address_id" value="{{ $address->id }}" id="addr{{ $address->id }}" data-address="{{ json_encode($address) }}">
                                                    <label class="form-check-label w-100" for="addr{{ $address->id }}">
                                                        <strong>{{ ucfirst($address->label) }}</strong><br>
                                                        <small class="text-muted">{{ $address->full_name }}, {{ $address->address_line_1 }}, {{ $address->city }}, {{ $address->state }}</small>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3"><i class="bi bi-credit-card me-2"></i>Payment Method</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check card card-body p-3 border-2 {{ old('payment_method') === 'cod' ? 'border-primary' : '' }}">
                                            <input class="form-check-input" type="radio" name="payment_method" value="cod" id="payCod" {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}>
                                            <label class="form-check-label w-100" for="payCod">
                                                <i class="bi bi-cash-stack fs-4 text-success d-block mb-1"></i>
                                                <strong>Cash on Delivery</strong>
                                                <small class="text-muted d-block">Pay when you receive your order</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check card card-body p-3 border-2 {{ old('payment_method') === 'paypal' ? 'border-primary' : '' }}">
                                            <input class="form-check-input" type="radio" name="payment_method" value="paypal" id="payPaypal" {{ old('payment_method') === 'paypal' ? 'checked' : '' }}>
                                            <label class="form-check-label w-100" for="payPaypal">
                                                <i class="bi bi-paypal fs-4 text-primary d-block mb-1"></i>
                                                <strong>PayPal</strong>
                                                <small class="text-muted d-block">Pay securely with PayPal</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @error('payment_method')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mt-4">
                            <div class="card-body">
                                <label class="form-label fw-semibold">Order Notes (Optional)</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Any special instructions for your order...">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card border-0 shadow-sm" style="position: sticky; top: 80px;">
                            <div class="card-body">
                                <h5 class="fw-bold mb-3">Order Summary</h5>
                                @foreach ($items as $item)
                                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item['product']->getPrimaryImagePath() }}" alt="" class="rounded me-2" style="width: 40px; height: 40px; object-fit: contain;">
                                            <div>
                                                <small class="fw-semibold">{{ $item['product']->name }}</small><br>
                                                <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                                            </div>
                                        </div>
                                        <small class="fw-semibold">₹{{ number_format($item['line_total'], 2) }}</small>
                                    </div>
                                @endforeach
                                <hr>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span>₹{{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Shipping</span>
                                    <span>{{ $shipping > 0 ? '₹' . number_format($shipping, 2) : 'Free' }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Tax (5%)</span>
                                    <span>₹{{ number_format($tax, 2) }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong class="fs-5">Total</strong>
                                    <strong class="fs-5 text-primary">₹{{ number_format($total, 2) }}</strong>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 btn-lg" id="placeOrderBtn">
                                    <i class="bi bi-check-circle me-1"></i>Place Order
                                </button>
                                <p class="text-muted small text-center mt-2">
                                    <i class="bi bi-shield-check me-1"></i>Your information is secure and encrypted.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.querySelectorAll('[name="address_id"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const addr = JSON.parse(this.dataset.address);
        document.querySelector('[name="shipping_name"]').value = addr.full_name || '';
        document.querySelector('[name="shipping_phone"]').value = addr.phone || '';
        document.querySelector('[name="shipping_address"]').value = (addr.address_line_1 || '') + (addr.address_line_2 ? ', ' + addr.address_line_2 : '');
        document.querySelector('[name="shipping_city"]').value = addr.city || '';
        document.querySelector('[name="shipping_state"]').value = addr.state || '';
        document.querySelector('[name="shipping_postal_code"]').value = addr.postal_code || '';
        document.querySelector('[name="shipping_country"]').value = addr.country || 'India';
    });
});
</script>
@endpush

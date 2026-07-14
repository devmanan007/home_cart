@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
    <section class="bg-dark text-white py-4">
        <div class="container py-3">
            <h1 class="display-6 fw-bold"><i class="bi bi-heart me-2"></i>My Wishlist</h1>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            @if ($wishlists->count())
                <div class="row g-4">
                    @foreach ($wishlists as $wishlist)
                        @php $product = $wishlist->product; @endphp
                        <div class="col-md-6 col-lg-4 col-xl-3" id="wishlist-item-{{ $product->id }}">
                            <div class="card border-0 shadow-sm h-100 product-card">
                                <a href="{{ route('shop.show', $product->slug) }}" class="text-decoration-none">
                                    <div class="bg-light text-center p-4" style="height: 180px;">
                                        <img src="{{ $product->getPrimaryImagePath() }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 140px; object-fit: contain;">
                                    </div>
                                </a>
                                <div class="card-body d-flex flex-column">
                                    <span class="badge bg-primary bg-opacity-10 text-primary align-self-start mb-2">{{ $product->category->name }}</span>
                                    <a href="{{ route('shop.show', $product->slug) }}" class="text-decoration-none">
                                        <h6 class="fw-semibold text-dark">{{ $product->name }}</h6>
                                    </a>
                                    <div class="mt-auto">
                                        <span class="fw-bold text-primary">₹{{ number_format($product->getEffectivePrice(), 2) }}</span>
                                    </div>
                                    <div class="d-flex gap-2 mt-2">
                                        <form action="{{ route('cart.add') }}" method="POST" data-ajax-form class="flex-grow-1">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary btn-sm w-100" {{ !$product->isInStock() ? 'disabled' : '' }}>
                                                <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                            </button>
                                        </form>
                                        <form action="{{ route('wishlist.remove', $product) }}" method="POST" data-ajax-form data-wishlist-remove>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Remove">
                                                <i class="bi bi-heart-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-heart display-1 text-muted"></i>
                    <h4 class="text-muted mt-3">Your wishlist is empty</h4>
                    <p class="text-muted">Save your favorite products here for later.</p>
                    <a href="{{ route('shop') }}" class="btn btn-primary btn-lg"><i class="bi bi-shop me-1"></i>Browse Products</a>
                </div>
            @endif
        </div>
    </section>
@endsection

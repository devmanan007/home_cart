@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <section class="bg-light py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('shop') }}" class="text-decoration-none">Shop</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="text-decoration-none">{{ $product->category->name }}</a></li>
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="bg-light rounded p-4 text-center mb-3">
                        @if ($product->images->count())
                            <img id="mainProductImage" src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 400px; object-fit: contain;">
                        @else
                            <img src="{{ asset('images/placeholder-product.png') }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 400px; object-fit: contain;">
                        @endif
                    </div>
                    @if ($product->images->count() > 1)
                        <div class="d-flex gap-2">
                            @foreach ($product->images as $image)
                                <div class="border rounded p-1" style="cursor: pointer; width: 70px; height: 70px;" onclick="document.getElementById('mainProductImage').src='{{ asset('storage/' . $image->image_path) }}'">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="" class="img-fluid" style="width: 100%; height: 100%; object-fit: contain;">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="col-lg-6">
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-2">{{ $product->category->name }}</span>
                    <h2 class="fw-bold">{{ $product->name }}</h2>

                    @if ($product->sku)
                        <p class="text-muted small">SKU: {{ $product->sku }}</p>
                    @endif

                    <div class="mb-3">
                        @if ($product->sale_price)
                            <span class="text-decoration-line-through text-muted fs-5">₹{{ number_format($product->price, 2) }}</span>
                            <span class="fw-bold text-primary fs-3 ms-2">₹{{ number_format($product->sale_price, 2) }}</span>
                            <span class="badge bg-danger ms-2">{{ $product->getDiscountPercent() }}% OFF</span>
                        @else
                            <span class="fw-bold text-primary fs-3">₹{{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        @if ($product->isInStock())
                            <span class="text-success"><i class="bi bi-check-circle me-1"></i>In Stock ({{ $product->stock_quantity }} available)</span>
                        @else
                            <span class="text-danger"><i class="bi bi-x-circle me-1"></i>Out of Stock</span>
                        @endif
                    </div>

                    @if ($product->weight)
                        <p class="text-muted small"><i class="bi bi-speedometer me-1"></i>Weight: {{ $product->weight }} kg</p>
                    @endif

                    <hr>

                    @if ($product->short_description)
                        <p class="text-muted">{{ $product->short_description }}</p>
                    @endif

                    @if ($product->isInStock())
                        <form action="{{ route('cart.add') }}" method="POST" data-ajax-form class="d-flex align-items-center gap-3 mb-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="input-group" style="width: 140px;">
                                <button type="button" class="btn btn-outline-secondary" onclick="this.nextElementSibling.value = Math.max(1, parseInt(this.nextElementSibling.value) - 1)">-</button>
                                <input type="number" name="quantity" class="form-control text-center" value="1" min="1" max="{{ $product->stock_quantity }}">
                                <button type="button" class="btn btn-outline-secondary" onclick="this.previousElementSibling.value = Math.min({{ $product->stock_quantity }}, parseInt(this.previousElementSibling.value) + 1)">+</button>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-cart-plus me-1"></i>Add to Cart
                            </button>
                        </form>

                        @auth
                            <form action="{{ route('wishlist.add', $product) }}" method="POST" data-ajax-form>
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="bi {{ $inWishlist ? 'bi-heart-fill' : 'bi-heart' }} me-1"></i>
                                    {{ $inWishlist ? 'In Wishlist' : 'Add to Wishlist' }}
                                </button>
                            </form>
                        @endauth
                    @endif
                </div>
            </div>

            @if ($product->description)
                <div class="mt-5">
                    <h4 class="fw-bold mb-3">Product Description</h4>
                    <div class="text-muted" style="line-height: 1.8;">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
            @endif
        </div>
    </section>

    @if ($relatedProducts->count())
        <section class="py-5 bg-light">
            <div class="container">
                <h4 class="fw-bold mb-4">Related Products</h4>
                <div class="row g-4">
                    @foreach ($relatedProducts as $related)
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-0 shadow-sm h-100 product-card">
                                <a href="{{ route('shop.show', $related->slug) }}" class="text-decoration-none">
                                    <div class="bg-white text-center p-3" style="height: 160px;">
                                        <img src="{{ $related->getPrimaryImagePath() }}" alt="{{ $related->name }}" class="img-fluid" style="max-height: 130px; object-fit: contain;">
                                    </div>
                                </a>
                                <div class="card-body">
                                    <a href="{{ route('shop.show', $related->slug) }}" class="text-decoration-none">
                                        <h6 class="fw-semibold text-dark mb-1">{{ $related->name }}</h6>
                                    </a>
                                    <span class="fw-bold text-primary">₹{{ number_format($related->getEffectivePrice(), 2) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

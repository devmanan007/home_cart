@extends('layouts.app')

@section('title', config('app.name'))

@section('content')
    <section class="bg-dark text-white py-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="display-4 fw-bold mb-3">Welcome to {{ config('app.name') }}</h1>
                    <p class="lead mb-4 text-secondary">Premium homemade ghee and seasonal mangoes, delivered fresh to your doorstep. Pure, natural, and made with love.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('shop') }}" class="btn btn-primary btn-lg px-4"><i class="bi bi-shop me-1"></i>Shop Now</a>
                        <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg px-4">Learn More</a>
                    </div>
                </div>
                <div class="col-lg-5 text-center mt-4 mt-lg-0">
                    <i class="bi bi-house-heart display-1 text-primary"></i>
                </div>
            </div>
        </div>
    </section>

    @if ($categories->count())
        <section class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Our Categories</h2>
                    <p class="text-muted">Explore our range of natural products</p>
                </div>
                <div class="row g-4">
                    @foreach ($categories as $category)
                        <div class="col-md-6">
                            <a href="{{ route('shop', ['category' => $category->slug]) }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm h-100 text-center p-4">
                                    <div class="card-body">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                            <i class="bi bi-tag text-primary fs-2"></i>
                                        </div>
                                        <h5 class="card-title fw-semibold text-dark">{{ $category->name }}</h5>
                                        <p class="card-text text-muted small">{{ $category->description ?? $category->active_products_count . ' products available' }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($featuredProducts->count())
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Featured Products</h2>
                    <p class="text-muted">Our most popular items loved by customers</p>
                </div>
                <div class="row g-4">
                    @foreach ($featuredProducts as $product)
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 shadow-sm h-100 product-card">
                                <a href="{{ route('shop.show', $product->slug) }}" class="text-decoration-none">
                                    <div class="bg-white text-center p-4" style="height: 200px;">
                                        <img src="{{ $product->getPrimaryImagePath() }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 160px; object-fit: contain;">
                                    </div>
                                </a>
                                <div class="card-body d-flex flex-column">
                                    <span class="badge bg-primary bg-opacity-10 text-primary align-self-start mb-2">{{ $product->category->name }}</span>
                                    <a href="{{ route('shop.show', $product->slug) }}" class="text-decoration-none">
                                        <h5 class="card-title fw-semibold text-dark">{{ $product->name }}</h5>
                                    </a>
                                    <p class="card-text text-muted small flex-grow-1">{{ Str::limit($product->short_description ?? $product->description, 100) }}</p>
                                    <div class="d-flex align-items-center justify-content-between mt-auto">
                                        @if ($product->sale_price)
                                            <span class="text-decoration-line-through text-muted small">₹{{ number_format($product->price, 2) }}</span>
                                            <span class="fw-bold text-primary fs-5">₹{{ number_format($product->sale_price, 2) }}</span>
                                        @else
                                            <span class="fw-bold text-primary fs-5">₹{{ number_format($product->price, 2) }}</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        <form action="{{ route('cart.add') }}" method="POST" data-ajax-form>
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary btn-sm w-100" {{ !$product->isInStock() ? 'disabled' : '' }}>
                                                <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('shop') }}" class="btn btn-outline-primary btn-lg">View All Products <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
            </div>
        </section>
    @endif

    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Why Choose Us?</h2>
                <p class="text-muted">What makes our products special</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="card-body">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                <i class="bi bi-leaf text-success fs-2"></i>
                            </div>
                            <h5 class="card-title fw-semibold">100% Natural</h5>
                            <p class="card-text text-muted small">All our products are made from pure, natural ingredients with no additives or preservatives.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="card-body">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                <i class="bi bi-truck text-primary fs-2"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Fresh Delivery</h5>
                            <p class="card-text text-muted small">We deliver fresh products right to your doorstep with free shipping on orders above ₹500.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="card-body">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                <i class="bi bi-award text-warning fs-2"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Quality Assured</h5>
                            <p class="card-text text-muted small">Every batch is carefully tested to ensure the highest quality and purity standards.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($recentPosts->count())
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Recent Blog Posts</h2>
                    <p class="text-muted">Latest insights and updates from our team</p>
                </div>
                <div class="row g-4">
                    @foreach ($recentPosts as $post)
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-primary bg-opacity-10 text-primary">{{ $post->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <h5 class="card-title fw-semibold">{{ $post->title }}</h5>
                                    <p class="card-text text-muted small">{{ Str::limit($post->summary ?? $post->content, 120) }}</p>
                                    <a href="{{ route('blogs.show', $post->slug) }}" class="btn btn-outline-primary btn-sm">Read More</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

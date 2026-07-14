@extends('layouts.app')

@section('title', 'Shop')

@section('content')
    <section class="bg-dark text-white py-4">
        <div class="container py-3">
            <h1 class="display-6 fw-bold">Shop</h1>
            <p class="text-secondary mb-0">Fresh homemade ghee and seasonal mangoes</p>
        </div>
    </section>

    <section class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Search</h6>
                            <form action="{{ route('shop') }}" method="GET">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mt-3">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Categories</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <a href="{{ route('shop') }}" class="text-decoration-none {{ !request('category') ? 'text-primary fw-semibold' : 'text-muted' }}">
                                        All Products
                                    </a>
                                </li>
                                @foreach ($categories as $category)
                                    <li class="mb-2">
                                        <a href="{{ route('shop', ['category' => $category->slug]) }}" 
                                           class="text-decoration-none {{ request('category') === $category->slug ? 'text-primary fw-semibold' : 'text-muted' }}">
                                            {{ $category->name }}
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $category->active_products_count }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mt-3">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Sort By</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><a href="{{ route('shop', array_merge(request()->query(), ['sort' => 'newest'])) }}" class="text-decoration-none {{ request('sort', 'newest') === 'newest' ? 'text-primary fw-semibold' : 'text-muted' }}">Newest</a></li>
                                <li class="mb-2"><a href="{{ route('shop', array_merge(request()->query(), ['sort' => 'price_asc'])) }}" class="text-decoration-none {{ request('sort') === 'price_asc' ? 'text-primary fw-semibold' : 'text-muted' }}">Price: Low to High</a></li>
                                <li class="mb-2"><a href="{{ route('shop', array_merge(request()->query(), ['sort' => 'price_desc'])) }}" class="text-decoration-none {{ request('sort') === 'price_desc' ? 'text-primary fw-semibold' : 'text-muted' }}">Price: High to Low</a></li>
                                <li class="mb-2"><a href="{{ route('shop', array_merge(request()->query(), ['sort' => 'name'])) }}" class="text-decoration-none {{ request('sort') === 'name' ? 'text-primary fw-semibold' : 'text-muted' }}">Name A-Z</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    @if ($products->count())
                        <div class="row g-4">
                            @foreach ($products as $product)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card border-0 shadow-sm h-100 product-card">
                                        <a href="{{ route('shop.show', $product->slug) }}" class="text-decoration-none">
                                            <div class="bg-light text-center p-4" style="height: 200px;">
                                                <img src="{{ $product->getPrimaryImagePath() }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 160px; object-fit: contain;">
                                            </div>
                                        </a>
                                        <div class="card-body d-flex flex-column">
                                            <span class="badge bg-primary bg-opacity-10 text-primary align-self-start mb-2">{{ $product->category->name }}</span>
                                            <a href="{{ route('shop.show', $product->slug) }}" class="text-decoration-none">
                                                <h6 class="fw-semibold text-dark mb-2">{{ $product->name }}</h6>
                                            </a>
                                            <p class="text-muted small flex-grow-1">{{ Str::limit($product->short_description ?? Str::limit($product->description, 100), 80) }}</p>
                                            <div class="d-flex align-items-center justify-content-between mt-auto">
                                                <div>
                                                    @if ($product->sale_price)
                                                        <span class="text-decoration-line-through text-muted small">₹{{ number_format($product->price, 2) }}</span>
                                                        <span class="fw-bold text-primary ms-1">₹{{ number_format($product->sale_price, 2) }}</span>
                                                    @else
                                                        <span class="fw-bold text-primary">₹{{ number_format($product->price, 2) }}</span>
                                                    @endif
                                                </div>
                                                @if (!$product->isInStock())
                                                    <span class="badge bg-danger">Out of Stock</span>
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

                        <div class="d-flex justify-content-center mt-4">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-box-seam display-1 text-muted"></i>
                            <h4 class="text-muted mt-3">No products found</h4>
                            <p class="text-muted">Try adjusting your search or filter criteria.</p>
                            <a href="{{ route('shop') }}" class="btn btn-primary">View All Products</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

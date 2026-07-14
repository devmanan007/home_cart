@extends('layouts.app')

@section('title', 'Blogs')

@section('content')
    <section class="bg-dark text-white py-5">
        <div class="container py-3">
            <h1 class="display-5 fw-bold">Blog</h1>
            <p class="lead text-secondary mb-0">Insights, updates, and stories from our team.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                @forelse ($posts as $post)
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4 d-flex flex-column">
                                <span class="badge bg-primary bg-opacity-10 text-primary align-self-start mb-2">{{ $post->created_at->format('M d, Y') }}</span>
                                <h5 class="card-title fw-semibold">{{ $post->title }}</h5>
                                <p class="card-text text-muted small flex-grow-1">{{ Str::limit($post->summary ?? $post->content, 150) }}</p>
                                <a href="{{ route('blogs.show', $post->slug) }}" class="btn btn-outline-primary btn-sm align-self-start">Read More</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-journal-text display-4 text-muted"></i>
                        <p class="text-muted mt-3">No blog posts yet. Check back soon!</p>
                    </div>
                @endforelse
            </div>

            @if ($posts->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection

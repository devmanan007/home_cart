@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <section class="bg-dark text-white py-5">
        <div class="container py-3">
            <a href="{{ route('blogs') }}" class="btn btn-outline-light btn-sm mb-3"><i class="bi bi-arrow-left me-1"></i>Back to Blogs</a>
            <h1 class="display-5 fw-bold">{{ $post->title }}</h1>
            <div class="d-flex align-items-center gap-3 text-secondary">
                <span><i class="bi bi-calendar me-1"></i>{{ $post->created_at->format('F d, Y') }}</span>
                @if ($post->is_published)
                    <span class="badge bg-success">Published</span>
                @endif
            </div>
        </div>
    </section>

    <article class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @if ($post->summary)
                        <p class="lead text-muted fw-semibold mb-4">{{ $post->summary }}</p>
                    @endif

                    <div class="blog-content" style="line-height: 1.8;">
                        {{ $post->content }}
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('blogs') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>All Posts</a>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endsection

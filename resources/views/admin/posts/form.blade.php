@extends('layouts.admin')

@section('title', isset($post) ? 'Edit Post' : 'New Post')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">@yield('title')</h4>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ isset($post) ? route('admin.posts.update', $post) : route('admin.posts.store') }}" method="POST">
                    @csrf
                    @if (isset($post))
                        @method('PUT')
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title ?? '') }}">
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                            <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $post->slug ?? '') }}">
                            @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label for="summary" class="form-label">Summary</label>
                            <textarea id="summary" name="summary" rows="3" class="form-control @error('summary') is-invalid @enderror">{{ old('summary', $post->summary ?? '') }}</textarea>
                            @error('summary')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea id="content" name="content" rows="12" class="form-control @error('content') is-invalid @enderror">{{ old('content', $post->content ?? '') }}</textarea>
                            @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" id="is_published" name="is_published" class="form-check-input" value="1" {{ old('is_published', $post->is_published ?? false) ? 'checked' : '' }}>
                                <label for="is_published" class="form-check-label">Publish immediately</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            {{ isset($post) ? 'Update Post' : 'Create Post' }}
                        </button>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

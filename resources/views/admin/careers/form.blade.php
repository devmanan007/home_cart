@extends('layouts.admin')

@section('title', isset($job) ? 'Edit Job' : 'New Job')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">@yield('title')</h4>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ isset($job) ? route('admin.careers.update', $job) : route('admin.careers.store') }}" method="POST">
                    @csrf
                    @if (isset($job))
                        @method('PUT')
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $job->title ?? '') }}">
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="department" class="form-label">Department <span class="text-danger">*</span></label>
                            <input type="text" id="department" name="department" class="form-control @error('department') is-invalid @enderror" value="{{ old('department', $job->department ?? '') }}">
                            @error('department')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea id="description" name="description" rows="6" class="form-control @error('description') is-invalid @enderror">{{ old('description', $job->description ?? '') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label for="requirements" class="form-label">Requirements <span class="text-danger">*</span></label>
                            <textarea id="requirements" name="requirements" rows="6" class="form-control @error('requirements') is-invalid @enderror">{{ old('requirements', $job->requirements ?? '') }}</textarea>
                            @error('requirements')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input type="checkbox" id="is_active" name="is_active" class="form-check-input" value="1" {{ old('is_active', $job->is_active ?? true) ? 'checked' : '' }}>
                                <label for="is_active" class="form-check-label">Active listing</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            {{ isset($job) ? 'Update Job' : 'Create Job' }}
                        </button>
                        <a href="{{ route('admin.careers.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Careers')

@section('content')
    <section class="bg-dark text-white py-5">
        <div class="container py-3">
            <h1 class="display-5 fw-bold">Careers</h1>
            <p class="lead text-secondary mb-0">Join our team and help us build the future.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            @forelse ($careers as $career)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white py-3" data-bs-toggle="collapse" data-bs-target="#career{{ $career->id }}" style="cursor: pointer;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="fw-semibold mb-1">{{ $career->title }}</h5>
                                <span class="badge bg-primary bg-opacity-10 text-primary">{{ $career->department }}</span>
                            </div>
                            <i class="bi bi-chevron-down text-muted"></i>
                        </div>
                    </div>
                    <div id="career{{ $career->id }}" class="collapse">
                        <div class="card-body">
                            <h6 class="fw-semibold text-muted small text-uppercase">Description</h6>
                            <p class="text-muted">{{ $career->description }}</p>

                            <h6 class="fw-semibold text-muted small text-uppercase mt-3">Requirements</h6>
                            <p class="text-muted mb-0">{{ $career->requirements }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-briefcase display-4 text-muted"></i>
                    <p class="text-muted mt-3">No open positions at the moment. Check back later!</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection

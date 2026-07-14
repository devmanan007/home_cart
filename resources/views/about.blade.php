@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    {{-- Page Header --}}
    <section class="bg-dark text-white py-5">
        <div class="container py-3">
            <h1 class="display-5 fw-bold">About Us</h1>
            <p class="lead text-secondary mb-0">Learn more about our company, our mission, and the team behind it all.</p>
        </div>
    </section>

    {{-- Company Overview --}}
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-3">Company Overview</h2>
                    <p class="text-muted">Founded in 2020, {{ config('app.name') }} has grown from a small startup into a trusted technology partner for businesses worldwide. We specialize in delivering end-to-end digital solutions that drive measurable results.</p>
                    <p class="text-muted">Our team of experienced developers, designers, and strategists work collaboratively to transform complex challenges into elegant, scalable solutions. We believe in building long-term partnerships with our clients, understanding their unique needs, and delivering beyond expectations.</p>
                    <div class="row g-3 mt-3">
                        <div class="col-sm-4">
                            <h3 class="fw-bold text-primary mb-0">50+</h3>
                            <small class="text-muted">Projects Delivered</small>
                        </div>
                        <div class="col-sm-4">
                            <h3 class="fw-bold text-primary mb-0">30+</h3>
                            <small class="text-muted">Happy Clients</small>
                        </div>
                        <div class="col-sm-4">
                            <h3 class="fw-bold text-primary mb-0">5+</h3>
                            <small class="text-muted">Years Experience</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="bi bi-bar-chart-steps text-primary" style="font-size: 12rem;"></i>
                </div>
            </div>
        </div>
    </section>

    {{-- Mission & Vision --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 me-3">
                                    <i class="bi bi-bullseye text-primary fs-4"></i>
                                </div>
                                <h4 class="fw-bold mb-0">Our Mission</h4>
                            </div>
                            <p class="text-muted mb-0">To empower businesses with innovative technology solutions that streamline operations, enhance productivity, and foster sustainable growth. We are committed to delivering excellence in every project and building lasting relationships with our clients.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 me-3">
                                    <i class="bi bi-eye text-success fs-4"></i>
                                </div>
                                <h4 class="fw-bold mb-0">Our Vision</h4>
                            </div>
                            <p class="text-muted mb-0">To be a globally recognized leader in digital transformation, known for our innovative approach, technical expertise, and unwavering commitment to client success. We envision a world where technology seamlessly enables every business to reach its full potential.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Our Team --}}
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Our Team</h2>
                <p class="text-muted">Meet the talented people behind our success</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="card-body">
                            <div class="bg-secondary bg-opacity-10 rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                                <i class="bi bi-person text-secondary fs-1"></i>
                            </div>
                            <h5 class="fw-semibold mb-1">John Doe</h5>
                            <p class="text-primary small mb-2">CEO & Founder</p>
                            <p class="text-muted small mb-0">Visionary leader with 15+ years of industry experience.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="card-body">
                            <div class="bg-secondary bg-opacity-10 rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                                <i class="bi bi-person text-secondary fs-1"></i>
                            </div>
                            <h5 class="fw-semibold mb-1">Jane Smith</h5>
                            <p class="text-primary small mb-2">CTO</p>
                            <p class="text-muted small mb-0">Tech strategist specializing in scalable architecture solutions.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="card-body">
                            <div class="bg-secondary bg-opacity-10 rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                                <i class="bi bi-person text-secondary fs-1"></i>
                            </div>
                            <h5 class="fw-semibold mb-1">Mike Johnson</h5>
                            <p class="text-primary small mb-2">Lead Developer</p>
                            <p class="text-muted small mb-0">Full-stack engineer passionate about clean code and innovation.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 text-center p-4">
                        <div class="card-body">
                            <div class="bg-secondary bg-opacity-10 rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                                <i class="bi bi-person text-secondary fs-1"></i>
                            </div>
                            <h5 class="fw-semibold mb-1">Sarah Williams</h5>
                            <p class="text-primary small mb-2">Design Lead</p>
                            <p class="text-muted small mb-0">Creative designer crafting intuitive and engaging user experiences.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

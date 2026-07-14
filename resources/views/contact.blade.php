@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <section class="bg-dark text-white py-5">
        <div class="container py-3">
            <h1 class="display-5 fw-bold">Contact Us</h1>
            <p class="lead text-secondary mb-0">We'd love to hear from you. Get in touch with our team.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                {{-- Left: Contact Info + Map --}}
                <div class="col-lg-5">
                    <h4 class="fw-bold mb-4">Get in Touch</h4>

                    <div class="d-flex mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 me-3 flex-shrink-0">
                            <i class="bi bi-geo-alt text-primary fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-1">Our Address</h6>
                            <p class="text-muted mb-0">123 Business Avenue, Suite 100<br>New York, NY 10001</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 me-3 flex-shrink-0">
                            <i class="bi bi-envelope text-primary fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-1">Email Us</h6>
                            <p class="text-muted mb-0">info@company.com<br>support@company.com</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 me-3 flex-shrink-0">
                            <i class="bi bi-telephone text-primary fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-1">Call Us</h6>
                            <p class="text-muted mb-0">+1 (555) 123-4567<br>+1 (555) 987-6543</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 me-3 flex-shrink-0">
                            <i class="bi bi-clock text-primary fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-semibold mb-1">Business Hours</h6>
                            <p class="text-muted mb-0">Monday — Friday: 9:00 AM – 6:00 PM<br>Saturday: 10:00 AM – 2:00 PM</p>
                        </div>
                    </div>

                    {{-- Map Placeholder --}}
                    <div class="ratio ratio-16x9 mt-4">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387191.33750346623!2d-74.30933110000001!3d40.697019299999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2s!4v1690000000000"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Office Location">
                        </iframe>
                    </div>
                </div>

                {{-- Right: Contact Form --}}
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="fw-bold mb-1">Send Us a Message</h4>
                            <p class="text-muted small mb-4">Fill out the form below and we'll respond as soon as possible.</p>

                            <form action="{{ route('contact') }}" method="POST">
                                @csrf

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                        <input type="text" id="subject" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}">
                                        @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                        <textarea id="message" name="message" rows="6" class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                                        @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-4 px-4">
                                    <i class="bi bi-send me-1"></i>Send Message
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('layouts.app')

@section('title', 'Contact - ScentScape')
@section('meta_description', 'Contact ScentScape for fragrance support and order questions.')

@section('content')
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title">Contact Us</h1>
                <p class="page-subtitle">Questions about fragrance, orders, or support? Send us a message.</p>
                <div class="breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <i class="fas fa-chevron-right"></i>
                    <span>Contact</span>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-section section">
        <div class="container">
            <div class="contact-cards-row">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email Us</h3>
                    <p>Our concierge team is here to help</p>
                    <a href="mailto:info@scentscape.com">info@scentscape.com</a>
                    <a href="mailto:support@scentscape.com">support@scentscape.com</a>
                </div>

                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3>Call Us</h3>
                    <p>Mon-Fri from 9am to 6pm</p>
                    <a href="tel:+912234567890">+91 22 3456 7890</a>
                    <a href="tel:+919876543210">+91 98765 43210</a>
                </div>
            </div>

            <div class="contact-form-wrapper">
                <div class="contact-form-header">
                    <span class="section-tag">Send Message</span>
                    <h2 class="contact-form-title">How Can We Help?</h2>
                    <p class="contact-form-subtitle">
                        Reach out for product suggestions, order questions, or assistance with your account.
                    </p>
                </div>

                <form method="POST" action="{{ route('contact.send') }}" class="contact-form">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name"><i class="fas fa-user"></i>Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input" required>
                            @error('name')<span class="form-error">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="email"><i class="fas fa-envelope"></i>Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" required>
                            @error('email')<span class="form-error">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subject"><i class="fas fa-tag"></i>Subject</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}" class="form-input" required>
                        @error('subject')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group">
                        <label for="message"><i class="fas fa-comment"></i>Message</label>
                        <textarea id="message" name="message" rows="6" class="form-input form-textarea" required>{{ old('message') }}</textarea>
                        @error('message')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary submit-btn">
                        Send Message
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection

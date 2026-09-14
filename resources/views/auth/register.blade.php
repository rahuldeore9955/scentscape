@extends('layouts.app')

@section('title', 'Create Account - ScentScape')
@section('meta_description', 'Create a ScentScape account')
@section('body_class', 'auth-page auth-register-page')

@section('content')
    @include('layouts.partials.auth-nav')

    <div class="auth-ambient-glow glow-1"></div>
    <div class="auth-ambient-glow glow-2"></div>

    <section class="auth-minimal-wrapper">
        <div class="auth-minimal-card">
            <div class="auth-card-header">
                <h1 class="auth-card-title">Create Account</h1>
            </div>

            <div class="auth-pill-toggle">
                <a href="{{ route('login') }}" class="auth-pill-btn">Sign In</a>
                <a href="{{ route('register') }}" class="auth-pill-btn active">Register</a>
            </div>

            <div class="auth-form-container active">
                <form method="POST" action="{{ route('register') }}" class="auth-minimal-form">
                    @csrf

                    <div class="auth-input-group">
                        <label for="name">Name</label>
                        <div class="auth-input-field">
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                class="auth-clean-input"
                                placeholder="Your name"
                                required
                                autocomplete="name"
                            >
                        </div>
                        @error('name')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="auth-input-group">
                        <label for="email">Email</label>
                        <div class="auth-input-field">
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="auth-clean-input"
                                placeholder="name@example.com"
                                required
                                autocomplete="email"
                            >
                        </div>
                        @error('email')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="auth-input-group">
                        <label for="phone">Phone Number</label>
                        <div class="auth-input-field">
                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                class="auth-clean-input"
                                inputmode="numeric"
                                pattern="[0-9]{10}"
                                maxlength="10"
                                placeholder="9876543210"
                                required
                                autocomplete="tel"
                            >
                        </div>
                        @error('phone')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="auth-input-group">
                        <label for="password">Password</label>
                        <div class="auth-input-field">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="auth-clean-input"
                                placeholder="At least 6 characters"
                                required
                                autocomplete="new-password"
                            >
                        </div>
                        @error('password')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="auth-input-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <div class="auth-input-field">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="auth-clean-input"
                                placeholder="Repeat password"
                                required
                                autocomplete="new-password"
                            >
                        </div>
                    </div>

                    <div class="auth-remember-row">
                        <label class="auth-minimal-checkbox">
                            <input type="checkbox" name="terms" value="1" required>
                            <span class="custom-check"></span>
                            <span class="check-text">I agree to the terms</span>
                        </label>
                        @error('terms')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <button type="submit" class="auth-action-btn">
                        <span>Create Account</span>
                    </button>
                </form>

                <div class="auth-card-footer">
                    <span>Already registered?</span>
                    <a href="{{ route('login') }}" class="auth-switch-link">Sign in</a>
                </div>
            </div>
        </div>
    </section>
@endsection

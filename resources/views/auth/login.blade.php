@extends('layouts.app')

@section('title', 'Sign In - ScentScape')
@section('meta_description', 'Sign in to ScentScape')
@section('body_class', 'auth-page')

@section('content')
    @include('layouts.partials.auth-nav')

    <div class="auth-ambient-glow glow-1"></div>
    <div class="auth-ambient-glow glow-2"></div>

    <section class="auth-minimal-wrapper">
        <div class="auth-minimal-card">
            <div class="auth-card-header">
                <h1 class="auth-card-title">Sign In</h1>
                <p class="auth-card-subtitle">Welcome back to ScentScape</p>
            </div>

            <div class="auth-pill-toggle">
                <a href="{{ route('login') }}" class="auth-pill-btn active">Sign In</a>
                <a href="{{ route('register') }}" class="auth-pill-btn">Register</a>
            </div>

            <div class="auth-form-container active">
                <form method="POST" action="{{ route('login') }}" class="auth-minimal-form">
                    @csrf

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
                        <label for="password">Password</label>
                        <div class="auth-input-field">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="auth-clean-input"
                                placeholder="Password"
                                required
                                autocomplete="current-password"
                            >
                        </div>
                        @error('password')<span class="form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="auth-remember-row">
                        <label class="auth-minimal-checkbox">
                            <input type="checkbox" name="remember" value="1">
                            <span class="custom-check"></span>
                            <span class="check-text">Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="auth-switch-link">Forgot password?</a>
                    </div>

                    <button type="submit" class="auth-action-btn">
                        <span>Sign In</span>
                    </button>
                </form>

                <div class="auth-card-footer">
                    <span>New here?</span>
                    <a href="{{ route('register') }}" class="auth-switch-link">Create an account</a>
                </div>

                <div class="demo-login-actions" aria-label="Demo sign in options">
                    <span class="demo-login-label">Quick demo access</span>
                    <div class="demo-login-buttons">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <input type="hidden" name="email" value="priya@example.com">
                            <input type="hidden" name="password" value="password">
                            <button type="submit" class="demo-login-btn">
                                <i class="fas fa-user"></i>
                                Demo User
                            </button>
                        </form>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <input type="hidden" name="email" value="admin@scentscape.com">
                            <input type="hidden" name="password" value="password">
                            <button type="submit" class="demo-login-btn admin">
                                <i class="fas fa-shield-halved"></i>
                                Demo Admin
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('layouts.app')

@section('title', 'Forgot Password - ScentScape')
@section('body_class', 'auth-page')

@section('content')
    @include('layouts.partials.auth-nav')

    <div class="auth-ambient-glow glow-1"></div>
    <div class="auth-ambient-glow glow-2"></div>

    <section class="auth-minimal-wrapper">
        <div class="auth-minimal-card">
            <div class="auth-card-header">
                <h1 class="auth-card-title">Forgot Password?</h1>
                <p class="auth-card-subtitle">We'll email you a six-digit code to reset your password.</p>
            </div>

            <div class="auth-form-container active">
                <form method="POST" action="{{ route('password.email') }}" class="auth-minimal-form">
                    @csrf
                    <div class="auth-input-group">
                        <label for="email">Email</label>
                        <div class="auth-input-field">
                            <input id="email" name="email" class="auth-clean-input" type="email" value="{{ old('email') }}" autocomplete="email" placeholder="name@example.com" required autofocus>
                        </div>
                        @error('email')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <button type="submit" class="auth-action-btn"><span>Send Reset Code</span></button>
                </form>

                <div class="auth-card-footer">
                    <a href="{{ route('login') }}" class="auth-switch-link">Back to sign in</a>
                </div>
            </div>
        </div>
    </section>
@endsection

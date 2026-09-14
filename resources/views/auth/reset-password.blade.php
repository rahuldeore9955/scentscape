@extends('layouts.app')

@section('title', 'Reset Password - ScentScape')
@section('body_class', 'auth-page')

@section('content')
    @include('layouts.partials.auth-nav')

    <div class="auth-ambient-glow glow-1"></div>
    <div class="auth-ambient-glow glow-2"></div>

    <section class="auth-minimal-wrapper">
        <div class="auth-minimal-card">
            <div class="auth-card-header">
                <h1 class="auth-card-title">Reset Password</h1>
                <p class="auth-card-subtitle">Enter the code sent to {{ $email }} and choose a new password.</p>
            </div>

            <div class="auth-form-container active">
                <form method="POST" action="{{ route('password.update') }}" class="auth-minimal-form">
                    @csrf
                    <div class="auth-input-group">
                        <label for="otp">Reset Code</label>
                        <div class="auth-input-field">
                            <input id="otp" name="otp" class="auth-clean-input" type="text" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" autocomplete="one-time-code" placeholder="123456" required autofocus>
                        </div>
                        @error('otp')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="auth-input-group">
                        <label for="password">New Password</label>
                        <div class="auth-input-field">
                            <input id="password" name="password" class="auth-clean-input" type="password" autocomplete="new-password" placeholder="At least 6 characters" required>
                        </div>
                        @error('password')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="auth-input-group">
                        <label for="password_confirmation">Confirm New Password</label>
                        <div class="auth-input-field">
                            <input id="password_confirmation" name="password_confirmation" class="auth-clean-input" type="password" autocomplete="new-password" placeholder="Repeat your new password" required>
                        </div>
                    </div>
                    <button type="submit" class="auth-action-btn"><span>Reset Password</span></button>
                </form>
            </div>
        </div>
    </section>
@endsection

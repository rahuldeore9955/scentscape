@extends('layouts.app')

@section('title', 'Verify Your Email - ScentScape')
@section('body_class', 'auth-page')

@section('content')
    @include('layouts.partials.auth-nav')

    <div class="auth-ambient-glow glow-1"></div>
    <div class="auth-ambient-glow glow-2"></div>

    <section class="auth-minimal-wrapper">
        <div class="auth-minimal-card">
            <div class="auth-card-header">
                <h1 class="auth-card-title">Verify Your Email</h1>
                <p class="auth-card-subtitle">Enter the six-digit code sent to {{ $email }}.</p>
            </div>

            <div class="auth-form-container active">
                <form method="POST" action="{{ route('verification.verify') }}" class="auth-minimal-form">
                    @csrf
                    <div class="auth-input-group">
                        <label for="otp">Verification Code</label>
                        <div class="auth-input-field">
                            <input id="otp" name="otp" class="auth-clean-input" type="text" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" autocomplete="one-time-code" placeholder="123456" required autofocus>
                        </div>
                        @error('otp')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <button type="submit" class="auth-action-btn"><span>Verify Email</span></button>
                </form>

                <form method="POST" action="{{ route('verification.resend') }}" class="auth-card-footer">
                    @csrf
                    <span>Didn't receive a code?</span>
                    <button type="submit" class="auth-switch-link" style="border: 0; background: transparent; cursor: pointer;">Resend code</button>
                </form>
            </div>
        </div>
    </section>
@endsection

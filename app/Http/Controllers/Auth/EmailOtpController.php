<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EmailOtpController extends Controller
{
    private const OTP_LIFETIME_MINUTES = 10;

    public function showRegistrationVerification(Request $request): View|RedirectResponse
    {
        $pending = $request->session()->get('registration_otp');

        if (! $pending) {
            return redirect()->route('register')->with('error', 'Start registration to receive a verification code.');
        }

        return view('auth.verify-email', ['email' => $pending['email']]);
    }

    public function verifyRegistration(Request $request): RedirectResponse
    {
        $request->validate(['otp' => ['required', 'digits:6']]);
        $pending = $request->session()->get('registration_otp');

        if (! $this->validOtp($pending, $request->otp)) {
            return back()->withErrors(['otp' => 'That verification code is invalid or has expired.']);
        }

        if (User::where('email', $pending['email'])->exists()) {
            $request->session()->forget('registration_otp');
            return redirect()->route('login')->with('error', 'An account already exists for that email address.');
        }

        $user = User::create([
            'name' => $pending['name'],
            'email' => $pending['email'],
            'phone' => $pending['phone'],
            'password' => $pending['password'],
        ]);
        $user->forceFill(['email_verified_at' => now()])->save();

        $request->session()->forget('registration_otp');
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard.index')->with('success', 'Your email has been verified. Welcome to ScentScape!');
    }

    public function resendRegistrationOtp(Request $request): RedirectResponse
    {
        $pending = $request->session()->get('registration_otp');

        if (! $pending) {
            return redirect()->route('register')->with('error', 'Start registration to receive a verification code.');
        }

        return $this->sendOtp($request, 'registration_otp', $pending['email'], 'account verification');
    }

    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    public function sendPasswordResetOtp(Request $request): RedirectResponse
    {
        $data = $request->validate(['email' => ['required', 'email']]);

        if (! User::where('email', $data['email'])->exists()) {
            return back()->withErrors(['email' => 'We could not find an account with that email address.'])->onlyInput('email');
        }

        return $this->sendOtp($request, 'password_reset_otp', $data['email'], 'password reset');
    }

    public function showResetPassword(Request $request): View|RedirectResponse
    {
        $pending = $request->session()->get('password_reset_otp');

        if (! $pending) {
            return redirect()->route('password.request')->with('error', 'Enter your email address to receive a reset code.');
        }

        return view('auth.reset-password', ['email' => $pending['email']]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'otp' => ['required', 'digits:6'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);
        $pending = $request->session()->get('password_reset_otp');

        if (! $this->validOtp($pending, $data['otp'])) {
            return back()->withErrors(['otp' => 'That reset code is invalid or has expired.']);
        }

        $user = User::where('email', $pending['email'])->first();

        if (! $user) {
            $request->session()->forget('password_reset_otp');
            return redirect()->route('password.request')->with('error', 'Start the password reset process again.');
        }

        $user->update(['password' => Hash::make($data['password'])]);
        $request->session()->forget('password_reset_otp');

        return redirect()->route('login')->with('success', 'Password updated. You can now sign in.');
    }

    private function sendOtp(Request $request, string $sessionKey, string $email, string $purpose): RedirectResponse
    {
        $otp = (string) random_int(100000, 999999);

        try {
            Mail::raw(
                "Your ScentScape {$purpose} code is: {$otp}\n\nThis code expires in ".self::OTP_LIFETIME_MINUTES.' minutes. If you did not request it, you can safely ignore this email.',
                fn ($message) => $message->to($email)->subject('Your ScentScape verification code')
            );
        } catch (\Throwable $exception) {
            report($exception);
            return back()->with('error', 'We could not send the verification email. Please try again shortly.');
        }

        $request->session()->put($sessionKey, array_merge(
            $request->session()->get($sessionKey, []),
            [
                'email' => $email,
                'code' => Hash::make($otp),
                'expires_at' => now()->addMinutes(self::OTP_LIFETIME_MINUTES)->timestamp,
            ]
        ));

        return $sessionKey === 'registration_otp'
            ? redirect()->route('verification.notice')->with('success', 'A six-digit verification code was sent to your email.')
            : redirect()->route('password.reset')->with('success', 'A six-digit reset code was sent to your email.');
    }

    private function validOtp(?array $pending, string $otp): bool
    {
        return $pending
            && now()->timestamp <= $pending['expires_at']
            && Hash::check($otp, $pending['code']);
    }
}

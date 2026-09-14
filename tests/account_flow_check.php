<?php

require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
config(['session.driver' => 'array']);
$session = app('session')->driver('array');
$session->start();
$request = Illuminate\Http\Request::create('/verify-email', 'POST', ['otp' => '123456']);
$request->setLaravelSession($session);
$app->instance('request', $request);
$controller = app(App\Http\Controllers\Auth\EmailOtpController::class);
$email = 'flow-'.bin2hex(random_bytes(8)).'@example.com';
Illuminate\Support\Facades\DB::beginTransaction();
try {
    $session->put('registration_otp', [
        'name' => 'Flow check', 'email' => $email, 'phone' => '9876543210',
        'password' => Illuminate\Support\Facades\Hash::make('test-password'),
        'code' => Illuminate\Support\Facades\Hash::make('123456'),
        'expires_at' => time() + 600,
    ]);
    $response = $controller->verifyRegistration($request);
    $user = Illuminate\Support\Facades\Auth::user();
    if ($response->getTargetUrl() !== route('dashboard.addresses') || !$user->email_verified_at || $session->has('registration_otp')) {
        throw new RuntimeException('Signup verification or address redirect failed');
    }
    $newEmail = 'new-'.$email;
    $session->put('email_change_otp', [
        'user_id' => $user->id, 'email' => $newEmail,
        'code' => Illuminate\Support\Facades\Hash::make('654321'), 'expires_at' => time() + 600,
    ]);
    $controller->verifyEmailChange($request);
    if ($user->fresh()->email !== $email) {
        throw new RuntimeException('Incorrect code changed email');
    }
    $request->merge(['otp' => '654321']);
    $controller->verifyEmailChange($request);
    if ($user->fresh()->email !== $newEmail || $session->has('email_change_otp')) {
        throw new RuntimeException('Valid email change or OTP consumption failed');
    }
    $response = app(App\Http\Controllers\CheckoutController::class)->start($request);
    if ($response->getData(true)['redirect'] !== route('dashboard.addresses')) {
        throw new RuntimeException('Checkout without address did not redirect');
    }
    echo "PASS: verified signup -> address; invalid email OTP rejected; valid OTP consumed; checkout -> address.\n";
} finally {
    Illuminate\Support\Facades\DB::rollBack();
}

@extends('layouts.app')

@section('title', 'Thank You - ScentScape')

@section('content')
    <section class="checkout-page section">
        <div class="container">
            <div class="checkout-summary checkout-success">
                <i class="fas fa-circle-check"></i>
                <span class="section-tag">Payment Successful</span>
                <h1>Thank you for your purchase</h1>
                <p>Your payment was successful. Order {{ $order->order_number }} has been received and is now being processed.</p>
                <div class="checkout-success-actions">
                    <a href="{{ route('checkout.invoice', $order) }}" class="btn btn-primary"><i class="fas fa-file-pdf"></i> Download Invoice</a>
                    <a href="{{ route('dashboard.orders') }}" class="btn btn-outline">View My Orders <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>
@endsection

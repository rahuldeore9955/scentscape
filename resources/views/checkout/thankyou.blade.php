@extends('layouts.app')

@section('title', 'Thank You - ScentScape')

@section('content')
    <section class="checkout-page section">
        <div class="container">
            <div class="checkout-summary checkout-success">
                <i class="fas fa-circle-check"></i>
                <span class="section-tag">Payment Successful</span>
                <h1>Thank you for your order</h1>
                <p>Your order {{ $order->order_number }} has been received and is now being processed.</p>
                <a href="{{ route('dashboard.orders') }}" class="btn btn-primary">View My Orders <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>
@endsection

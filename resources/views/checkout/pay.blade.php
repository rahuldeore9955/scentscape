@extends('layouts.app')

@section('title', 'Complete Payment - ScentScape')

@section('content')
    <section class="checkout-page section">
        <div class="container">
            <div class="checkout-summary">
                <span class="section-tag">Secure Checkout</span>
                <h1>Complete your payment</h1>
                <p>Order {{ $order->order_number }} · Total Rs. {{ number_format((float) $order->total_amount, 2) }}</p>
                <button type="button" id="openRazorpay" class="btn btn-primary">Open Razorpay <i class="fas fa-lock"></i></button>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const button = document.getElementById('openRazorpay');
            const options = {
                key: @json(config('services.razorpay.key_id')),
                amount: {{ (int) round((float) $order->total_amount * 100) }},
                currency: 'INR',
                name: 'ScentScape',
                description: 'Order {{ $order->order_number }}',
                order_id: @json($order->razorpay_order_id),
                handler: function (response) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = @json(route('checkout.verify', $order));
                    form.innerHTML = '<input type="hidden" name="_token" value="' + @json(csrf_token()) + '">' +
                        '<input type="hidden" name="razorpay_payment_id" value="' + response.razorpay_payment_id + '">' +
                        '<input type="hidden" name="razorpay_order_id" value="' + response.razorpay_order_id + '">' +
                        '<input type="hidden" name="razorpay_signature" value="' + response.razorpay_signature + '">';
                    document.body.appendChild(form);
                    form.submit();
                },
                theme: { color: '#d4a574' }
            };
            const open = () => new Razorpay(options).open();
            button.addEventListener('click', open);
            open();
        });
    </script>
@endpush

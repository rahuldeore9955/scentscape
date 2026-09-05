@php($panelType = 'user')
@php($panelLinks = [['label' => 'Overview', 'icon' => 'fas fa-grid-2', 'url' => route('dashboard.index')], ['label' => 'My Orders', 'icon' => 'fas fa-bag-shopping', 'url' => route('dashboard.orders')], ['label' => 'Wishlist', 'icon' => 'fas fa-heart', 'url' => route('dashboard.wishlist')], ['label' => 'Addresses', 'icon' => 'fas fa-location-dot', 'url' => route('dashboard.addresses')], ['label' => 'Profile', 'icon' => 'fas fa-user', 'url' => route('dashboard.profile')]])
@extends('layouts.panel')
@section('title', 'My Orders - ScentScape')
@section('page_heading', 'My Orders')
@section('content')
    <div class="panel-welcome"><span class="panel-eyebrow">My Account</span><h1>My Orders</h1><p>Review your order history and current status.</p></div>
    <section class="panel-card">
        @if($orders->isEmpty())
            <p class="panel-empty">You have not placed any orders yet.</p>
        @else
            <div class="panel-table-wrap"><table class="panel-table"><thead><tr><th>Order</th><th>Date</th><th>Total</th><th>Status</th><th>Tracking</th></tr></thead><tbody>@foreach($orders as $order)<tr><td>{{ $order->order_number }}</td><td>{{ $order->created_at->format('M d, Y') }}</td><td>Rs. {{ number_format((float) $order->total_amount, 2) }}</td><td><span class="panel-status">{{ ucfirst($order->status) }}</span></td><td>@if($order->tracking_number)<strong>{{ $order->courier_name ?: 'Courier' }}</strong><br><small>{{ $order->tracking_number }}</small>@else - @endif</td></tr>@endforeach</tbody></table></div>
        @endif
    </section>
@endsection

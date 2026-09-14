@php
    $panelType = 'user';
    $panelLinks = [
        ['label' => 'Dashboard', 'icon' => 'fas fa-gauge-high', 'url' => route('dashboard.index')],
        ['label' => 'Products', 'icon' => 'fas fa-box-open', 'url' => route('dashboard.products')],
        ['label' => 'My Orders', 'icon' => 'fas fa-bag-shopping', 'url' => route('dashboard.orders')],
        ['label' => 'Profile', 'icon' => 'fas fa-user', 'url' => route('dashboard.profile')],
    ];
@endphp
@extends('layouts.panel')

@section('title', 'My Dashboard - ScentScape')
@section('page_heading', 'Overview')

@section('content')
    <div class="panel-welcome">
        <span class="panel-eyebrow">My Account</span>
        <h1>Welcome back, {{ $user->name }}</h1>
        <p>Keep track of your orders and fragrance collection.</p>
        <p><strong>Phone:</strong> {{ $user->phone ?: 'Not added yet' }}</p>
    </div>

    <div class="panel-stat-grid">
        <div class="panel-stat-card"><i class="fas fa-bag-shopping"></i><div><strong>{{ $user->orders()->count() }}</strong><span>Total Orders</span></div></div>
        <div class="panel-stat-card"><i class="fas fa-crown"></i><div><strong>{{ ucfirst($user->membership_tier) }}</strong><span>Membership</span></div></div>
    </div>

    <section class="panel-card">
        <div class="panel-card-heading"><h2>Recent Orders</h2><a href="{{ route('dashboard.orders') }}">View all <i class="fas fa-arrow-right"></i></a></div>
        @if($orders->isEmpty())
            <p class="panel-empty">You have not placed any orders yet.</p>
        @else
            <div class="panel-table-wrap"><table class="panel-table"><thead><tr><th>Order</th><th>Date</th><th>Total</th><th>Status</th></tr></thead><tbody>@foreach($orders as $order)<tr><td>{{ $order->order_number }}</td><td>{{ $order->created_at->format('M d, Y') }}</td><td>Rs. {{ number_format((float) $order->total_amount, 2) }}</td><td><span class="panel-status">{{ ucfirst($order->status) }}</span></td></tr>@endforeach</tbody></table></div>
        @endif
    </section>
@endsection


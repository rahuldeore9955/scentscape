@php
    $panelType = 'admin';
    $panelLinks = [
        ['label' => 'Dashboard', 'icon' => 'fas fa-gauge-high', 'url' => route('admin.index')],
        ['label' => 'Products', 'icon' => 'fas fa-box', 'url' => route('admin.products.index')],
        ['label' => 'Customers', 'icon' => 'fas fa-users', 'url' => route('admin.users.index')],
        ['label' => 'Orders', 'icon' => 'fas fa-bag-shopping', 'url' => route('admin.orders.index')],
        ['label' => 'Payments', 'icon' => 'fas fa-credit-card', 'url' => route('admin.payments.index')],
    ];
@endphp
@extends('layouts.panel')

@section('title', 'Admin Dashboard - ScentScape')
@section('page_heading', 'Admin Overview')

@section('content')
    <div class="panel-welcome">
        <span class="panel-eyebrow">Administration</span>
        <h1>Store overview</h1>
        <p>Manage products, customers, orders, and payment records from one place.</p>
    </div>

    <div class="panel-stat-grid">
        <div class="panel-stat-card"><i class="fas fa-box"></i><div><strong>{{ $stats['products'] }}</strong><span>Products</span></div></div>
        <div class="panel-stat-card"><i class="fas fa-users"></i><div><strong>{{ $stats['users'] }}</strong><span>Customers</span></div></div>
        <div class="panel-stat-card"><i class="fas fa-bag-shopping"></i><div><strong>{{ $stats['orders'] }}</strong><span>Orders</span></div></div>
        <div class="panel-stat-card"><i class="fas fa-indian-rupee-sign"></i><div><strong>Rs. {{ number_format((float) $stats['paid_total'], 0) }}</strong><span>Payments Received</span></div></div>
    </div>

    <section class="panel-card">
        <div class="panel-card-heading"><h2>Recent Orders</h2><a href="{{ route('admin.orders.index') }}">View all <i class="fas fa-arrow-right"></i></a></div>
        @if($recentOrders->isEmpty())
            <p class="panel-empty">Orders placed by customers will appear here.</p>
        @else
            <div class="panel-table-wrap"><table class="panel-table"><thead><tr><th>Order</th><th>Customer</th><th>Total</th><th>Order Status</th><th></th></tr></thead><tbody>@foreach($recentOrders as $order)<tr><td>{{ $order->order_number }}</td><td>{{ $order->user->name }}</td><td>Rs. {{ number_format((float) $order->total_amount, 2) }}</td><td><span class="admin-status {{ $order->status }}">{{ ucfirst($order->status) }}</span></td><td><a class="panel-link-btn" href="{{ route('admin.orders.show', $order) }}">Manage</a></td></tr>@endforeach</tbody></table></div>
        @endif
    </section>
@endsection


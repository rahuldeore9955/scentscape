@php
    $panelType = 'admin';
    $panelLinks = [['label' => 'Overview', 'icon' => 'fas fa-grid-2', 'url' => route('admin.index')], ['label' => 'Products', 'icon' => 'fas fa-box', 'url' => route('admin.products.index')], ['label' => 'Customers', 'icon' => 'fas fa-users', 'url' => route('admin.users.index')], ['label' => 'Orders', 'icon' => 'fas fa-bag-shopping', 'url' => route('admin.orders.index')], ['label' => 'Payments', 'icon' => 'fas fa-credit-card', 'url' => route('admin.payments.index')]];
@endphp
@extends('layouts.panel')
@section('title', 'Orders - ScentScape Admin')
@section('page_heading', 'Orders')
@section('content')
    <div class="panel-welcome"><span class="panel-eyebrow">Fulfilment</span><h1>Orders</h1><p>Manage order tracking manually and keep payment records in sync.</p></div>
    <section class="panel-card"><div class="panel-table-wrap"><table class="panel-table"><thead><tr><th>Order</th><th>Customer</th><th>Date</th><th>Total</th><th>Payment</th><th>Status</th><th></th></tr></thead><tbody>@forelse($orders as $order)<tr><td>{{ $order->order_number }}</td><td>{{ $order->user->name }}</td><td>{{ $order->created_at->format('M d, Y') }}</td><td>Rs. {{ number_format((float) $order->total_amount, 2) }}</td><td><span class="admin-status {{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span></td><td><span class="admin-status {{ $order->status }}">{{ ucfirst($order->status) }}</span></td><td><a class="panel-link-btn" href="{{ route('admin.orders.show', $order) }}">Manage</a></td></tr>@empty<tr><td colspan="7" class="panel-empty">No orders have been placed yet.</td></tr>@endforelse</tbody></table></div></section>
@endsection

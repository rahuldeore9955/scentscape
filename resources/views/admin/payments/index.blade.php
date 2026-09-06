@php
    $panelType = 'admin';
    $panelLinks = [['label' => 'Dashboard', 'icon' => 'fas fa-gauge-high', 'url' => route('admin.index')], ['label' => 'Products', 'icon' => 'fas fa-box', 'url' => route('admin.products.index')], ['label' => 'Customers', 'icon' => 'fas fa-users', 'url' => route('admin.users.index')], ['label' => 'Orders', 'icon' => 'fas fa-bag-shopping', 'url' => route('admin.orders.index')], ['label' => 'Payments', 'icon' => 'fas fa-credit-card', 'url' => route('admin.payments.index')]];
@endphp
@extends('layouts.panel')
@section('title', 'Payments - ScentScape Admin')
@section('page_heading', 'Payments')
@section('content')
    <div class="panel-welcome"><span class="panel-eyebrow">Payments</span><h1>Payment Records</h1><p>Orders created through checkout appear here. Payment status can be corrected from the order screen.</p></div>
    <section class="panel-card"><div class="panel-table-wrap"><table class="panel-table"><thead><tr><th>Order</th><th>Customer</th><th>Method</th><th>Amount</th><th>Payment Status</th><th></th></tr></thead><tbody>@forelse($payments as $payment)<tr><td>{{ $payment->order_number }}</td><td>{{ $payment->user->name }}</td><td>{{ ucfirst($payment->payment_method) }}</td><td>Rs. {{ number_format((float) $payment->total_amount, 2) }}</td><td><span class="admin-status {{ $payment->payment_status }}">{{ ucfirst($payment->payment_status) }}</span></td><td><a class="panel-link-btn" href="{{ route('admin.orders.show', $payment) }}">View Order</a></td></tr>@empty<tr><td colspan="6" class="panel-empty">No payment records are available yet.</td></tr>@endforelse</tbody></table></div></section>
@endsection


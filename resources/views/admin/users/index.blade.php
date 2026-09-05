@php
    $panelType = 'admin';
    $panelLinks = [['label' => 'Overview', 'icon' => 'fas fa-grid-2', 'url' => route('admin.index')], ['label' => 'Products', 'icon' => 'fas fa-box', 'url' => route('admin.products.index')], ['label' => 'Customers', 'icon' => 'fas fa-users', 'url' => route('admin.users.index')], ['label' => 'Orders', 'icon' => 'fas fa-bag-shopping', 'url' => route('admin.orders.index')], ['label' => 'Payments', 'icon' => 'fas fa-credit-card', 'url' => route('admin.payments.index')]];
@endphp
@extends('layouts.panel')
@section('title', 'Customers - ScentScape Admin')
@section('page_heading', 'Customers')
@section('content')
    <div class="panel-welcome"><span class="panel-eyebrow">Customers</span><h1>Customer Accounts</h1><p>Review saved contact details, delivery addresses, and purchase history.</p></div>
    <section class="panel-card"><div class="panel-table-wrap"><table class="panel-table"><thead><tr><th>Customer</th><th>Phone</th><th>Joined</th><th>Orders</th><th></th></tr></thead><tbody>@forelse($users as $user)<tr><td><strong>{{ $user->name }}</strong><br><small>{{ $user->email }}</small></td><td>{{ $user->phone ?: '-' }}</td><td>{{ $user->created_at->format('M d, Y') }}</td><td>{{ $user->orders_count }}</td><td><a class="panel-link-btn" href="{{ route('admin.users.show', $user) }}">View History</a></td></tr>@empty<tr><td colspan="5" class="panel-empty">No customers have registered yet.</td></tr>@endforelse</tbody></table></div></section>
@endsection

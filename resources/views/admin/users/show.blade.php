@php
    $panelType = 'admin';
    $panelLinks = [['label' => 'Dashboard', 'icon' => 'fas fa-gauge-high', 'url' => route('admin.index')], ['label' => 'Products', 'icon' => 'fas fa-box', 'url' => route('admin.products.index')], ['label' => 'Customers', 'icon' => 'fas fa-users', 'url' => route('admin.users.index')], ['label' => 'Orders', 'icon' => 'fas fa-bag-shopping', 'url' => route('admin.orders.index')], ['label' => 'Payments', 'icon' => 'fas fa-credit-card', 'url' => route('admin.payments.index')]];
@endphp
@extends('layouts.panel')
@section('title', $user->name.' - ScentScape Admin')
@section('page_heading', 'Customer Details')
@section('content')
    <div class="panel-welcome"><span class="panel-eyebrow">Customer</span><h1>{{ $user->name }}</h1><p>{{ $user->email }}@if($user->phone) | {{ $user->phone }}@endif</p></div>
    <section class="panel-card"><div class="panel-card-heading"><h2>Purchase History</h2><a href="{{ route('admin.users.index') }}">Back to customers</a></div>@if($user->orders->isEmpty())<p class="panel-empty">This customer has not placed an order yet.</p>@else<div class="panel-table-wrap"><table class="panel-table"><thead><tr><th>Order</th><th>Date</th><th>Total</th><th>Status</th><th></th></tr></thead><tbody>@foreach($user->orders as $order)<tr><td>{{ $order->order_number }}</td><td>{{ $order->created_at->format('M d, Y') }}</td><td>Rs. {{ number_format((float) $order->total_amount, 2) }}</td><td><span class="admin-status {{ $order->status }}">{{ ucfirst($order->status) }}</span></td><td><a class="panel-link-btn" href="{{ route('admin.orders.show', $order) }}">Manage</a></td></tr>@endforeach</tbody></table></div>@endif</section>
    @php($address = $user->addresses->sortByDesc('is_default')->first())
    <section class="panel-card"><div class="panel-card-heading"><h2>Saved Address</h2></div>@if(!$address)<p class="panel-empty">No delivery address has been saved.</p>@else<div class="address-manage-grid"><article class="address-manage-card default"><div class="address-manage-heading"><h3>Delivery</h3><span>Saved</span></div><p><strong>{{ $address->full_name }}</strong><br>{{ $address->address_line1 }}@if($address->address_line2), {{ $address->address_line2 }}@endif<br>{{ $address->city }}@if($address->district), {{ $address->district }}@endif, {{ $address->state }} {{ $address->pincode }}<br>{{ $address->country }}<br>{{ $address->phone }}</p></article></div>@endif</section>
@endsection


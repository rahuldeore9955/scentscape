@php
    $panelType = 'admin';
    $panelLinks = [['label' => 'Overview', 'icon' => 'fas fa-grid-2', 'url' => route('admin.index')], ['label' => 'Products', 'icon' => 'fas fa-box', 'url' => route('admin.products.index')], ['label' => 'Customers', 'icon' => 'fas fa-users', 'url' => route('admin.users.index')], ['label' => 'Orders', 'icon' => 'fas fa-bag-shopping', 'url' => route('admin.orders.index')], ['label' => 'Payments', 'icon' => 'fas fa-credit-card', 'url' => route('admin.payments.index')]];
@endphp
@extends('layouts.panel')
@section('title', 'Products - ScentScape Admin')
@section('page_heading', 'Products')
@section('content')
    <div class="panel-welcome"><span class="panel-eyebrow">Catalog</span><h1>Products</h1><p>Create products and keep pricing, stock, and storefront visibility current.</p></div>
    <section class="panel-card">
        <div class="panel-card-heading"><h2>Catalog</h2><a class="panel-primary-link" href="{{ route('admin.products.create') }}"><i class="fas fa-plus"></i> Add Product</a></div>
        <div class="panel-table-wrap"><table class="panel-table"><thead><tr><th>Product</th><th>SKU</th><th>Price</th><th>Stock</th><th>Status</th><th></th></tr></thead><tbody>@forelse($products as $product)<tr><td><strong>{{ $product->name }}</strong><br><small>{{ $product->brand }}</small></td><td>{{ $product->sku ?: '-' }}</td><td>Rs. {{ number_format((float) $product->price, 2) }}</td><td>{{ $product->stock }}</td><td><span class="admin-status {{ str_replace('_', '-', $product->status) }}">{{ ucfirst(str_replace('_', ' ', $product->status)) }}</span></td><td class="admin-actions"><a class="panel-link-btn" href="{{ route('admin.products.edit', $product) }}">Edit</a><form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Remove this product from the catalog?')">@csrf @method('DELETE')<button class="panel-delete-btn" type="submit">Remove</button></form></td></tr>@empty<tr><td colspan="6" class="panel-empty">No products are available yet.</td></tr>@endforelse</tbody></table></div>
    </section>
@endsection

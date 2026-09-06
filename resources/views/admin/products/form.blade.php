@php
    $panelType = 'admin'; $editing = $product->exists;
    $panelLinks = [['label' => 'Dashboard', 'icon' => 'fas fa-gauge-high', 'url' => route('admin.index')], ['label' => 'Products', 'icon' => 'fas fa-box', 'url' => route('admin.products.index')], ['label' => 'Customers', 'icon' => 'fas fa-users', 'url' => route('admin.users.index')], ['label' => 'Orders', 'icon' => 'fas fa-bag-shopping', 'url' => route('admin.orders.index')], ['label' => 'Payments', 'icon' => 'fas fa-credit-card', 'url' => route('admin.payments.index')]];
@endphp
@extends('layouts.panel')
@section('title', ($editing ? 'Edit' : 'Add').' Product - ScentScape Admin')
@section('page_heading', $editing ? 'Edit Product' : 'Add Product')
@section('content')
    <div class="panel-welcome"><span class="panel-eyebrow">Catalog</span><h1>{{ $editing ? 'Edit Product' : 'Add Product' }}</h1><p>Product details are shown on the storefront when the product is active.</p></div>
    <section class="panel-card"><form method="POST" action="{{ $editing ? route('admin.products.update', $product) : route('admin.products.store') }}" class="panel-form" enctype="multipart/form-data">@csrf @if($editing) @method('PUT') @endif
        <h2 class="panel-form-section-title">Product Information</h2><div class="panel-form-grid">
            <label>Name<input name="name" value="{{ old('name', $product->name) }}" required></label><label>Brand<input name="brand" value="{{ old('brand', $product->brand) }}" required></label>
            <label>SKU<input name="sku" value="{{ old('sku', $product->sku) }}"></label><label>Size<input name="size" value="{{ old('size', $product->size) }}" placeholder="100ml"></label>
            <label>Category<select name="category">@foreach(['women' => 'Women', 'men' => 'Men', 'unisex' => 'Unisex'] as $value => $label)<option value="{{ $value }}" @selected(old('category', $product->category ?: 'unisex') === $value)>{{ $label }}</option>@endforeach</select></label>
            <label>Status<select name="status">@foreach(['active' => 'Active', 'draft' => 'Draft', 'out_of_stock' => 'Out of stock'] as $value => $label)<option value="{{ $value }}" @selected(old('status', $product->status ?: 'active') === $value)>{{ $label }}</option>@endforeach</select></label>
            <label>Price (Rs.)<input type="number" name="price" min="0" step="0.01" value="{{ old('price', $product->price) }}" required></label><label>Original Price (Rs.)<input type="number" name="original_price" min="0" step="0.01" value="{{ old('original_price', $product->original_price) }}"></label>
            <label>Stock<input type="number" name="stock" min="0" value="{{ old('stock', $product->stock ?? 0) }}" required></label><label>Discount %<input type="number" name="discount" min="0" max="100" value="{{ old('discount', $product->discount ?? 0) }}"></label>
            <label>Badge<input name="badge" value="{{ old('badge', $product->badge) }}" placeholder="bestseller, new, or sale"></label><label>Image URL<input type="url" name="image" value="{{ old('image', $product->image) }}"></label>
            <label>Upload Product Image<input type="file" name="image_upload" accept="image/jpeg,image/png,image/webp"></label>
        </div>
        @if($product->image)<div class="admin-product-image-preview"><img src="{{ $product->image }}" alt="Current product image"><span>Current image</span></div>@endif
        <label class="panel-full-field">Short Description<input name="short_description" value="{{ old('short_description', $product->short_description) }}"></label>
        <label class="panel-full-field">Description<textarea name="description" rows="5">{{ old('description', $product->description) }}</textarea></label>
        <div class="admin-form-actions"><a class="panel-link-btn" href="{{ route('admin.products.index') }}">Cancel</a><button type="submit" class="panel-primary-btn">{{ $editing ? 'Save Changes' : 'Create Product' }}</button></div>
    </form></section>
@endsection


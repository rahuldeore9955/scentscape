@php
    $panelType = 'admin'; $editing = $product->exists;
    $panelLinks = [['label' => 'Dashboard', 'icon' => 'fas fa-gauge-high', 'url' => route('admin.index')], ['label' => 'Products', 'icon' => 'fas fa-box', 'url' => route('admin.products.index')], ['label' => 'Customers', 'icon' => 'fas fa-users', 'url' => route('admin.users.index')], ['label' => 'Orders', 'icon' => 'fas fa-bag-shopping', 'url' => route('admin.orders.index')], ['label' => 'Payments', 'icon' => 'fas fa-credit-card', 'url' => route('admin.payments.index')]];
@endphp
@extends('layouts.panel')
@section('title', ($editing ? 'Edit' : 'Add').' Product - ScentScape Admin')
@section('page_heading', $editing ? 'Edit Product' : 'Add Product')
@section('content')
    @php($extraImages = $product->images ?? [])
    <div class="panel-welcome"><span class="panel-eyebrow">Catalog</span><h1>{{ $editing ? 'Edit Product' : 'Add Product' }}</h1><p>Product details are shown on the storefront when the product is active.</p></div>
    <section class="panel-card"><form method="POST" action="{{ $editing ? route('admin.products.update', $product) : route('admin.products.store') }}" class="panel-form" enctype="multipart/form-data">@csrf @if($editing) @method('PUT') @endif
        <h2 class="panel-form-section-title">Product Information</h2><div class="panel-form-grid">
            <label>Name<input name="name" value="{{ old('name', $product->name) }}" required></label>
            <label>SKU<input name="sku" value="{{ old('sku', $product->sku) }}"></label>
            <label>Category<select name="category">@foreach(['women' => 'Women', 'men' => 'Men', 'unisex' => 'Unisex'] as $value => $label)<option value="{{ $value }}" @selected(old('category', $product->category ?: 'unisex') === $value)>{{ $label }}</option>@endforeach</select></label>
            <label>Status<select name="status">@foreach(['active' => 'Active', 'draft' => 'Draft', 'out_of_stock' => 'Out of stock'] as $value => $label)<option value="{{ $value }}" @selected(old('status', $product->status ?: 'active') === $value)>{{ $label }}</option>@endforeach</select></label>
            <label>Price (Rs.)<input type="number" name="price" min="0" step="0.01" value="{{ old('price', $product->price) }}" required></label><label>Original Price (Rs.)<input type="number" name="original_price" min="0" step="0.01" value="{{ old('original_price', $product->original_price) }}"></label>
            <label>Badge<input name="badge" value="{{ old('badge', $product->badge) }}" placeholder="bestseller, new, or sale"></label>
            <label>Primary Image<input type="file" name="image_upload" accept="image/jpeg,image/png,image/webp"></label>
            <label>Extra Images <span class="admin-field-hint">Up to 4 gallery images</span><input type="file" name="images_upload[]" accept="image/jpeg,image/png,image/webp" multiple></label>
        </div>
        @if($product->image)<div class="admin-product-image-preview"><img src="{{ $product->image }}" alt="Current product image"><span>Current primary image</span></div>@endif
        @if(count($extraImages))
            <section class="admin-extra-images"><h3>Extra Images ({{ count($extraImages) }}/4)</h3><p>Select an image to remove it when you save changes.</p><div class="admin-extra-images-grid">@foreach($extraImages as $image)<label class="admin-extra-image"><img src="{{ $image }}" alt="Extra product image {{ $loop->iteration }}"><span><input type="checkbox" name="remove_images[]" value="{{ $image }}"> Remove</span></label>@endforeach</div></section>
        @endif
        <label class="panel-full-field">Short Description<input name="short_description" value="{{ old('short_description', $product->short_description) }}"></label>
        <label class="panel-full-field">Description<textarea name="description" rows="5">{{ old('description', $product->description) }}</textarea></label>
        <div class="admin-form-actions"><a class="panel-link-btn" href="{{ route('admin.products.index') }}">Cancel</a><button type="submit" class="panel-primary-btn">{{ $editing ? 'Save Changes' : 'Create Product' }}</button></div>
    </form></section>
@endsection


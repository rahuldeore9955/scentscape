@extends('layouts.app')

@php
    $fallbackImages = [
        'https://images.unsplash.com/photo-1541643600914-78b084683601?w=800&h=800&fit=crop&q=80',
        'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=800&h=800&fit=crop&q=80',
        'https://images.unsplash.com/photo-1563170351-be82bc888aa4?w=800&h=800&fit=crop&q=80',
        'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=800&h=800&fit=crop&q=80',
    ];
    $mainImage = $product->image ?: $fallbackImages[0];
    $gallery = $product->images ?: $fallbackImages;
@endphp

@section('title', $product->name . ' - ScentScape')
@section('meta_description', $product->short_description ?: $product->name)

@section('content')
    <section class="product-details-section section" style="padding-top: 130px;">
        <div class="container">
            <div class="product-details-grid">
                <div class="product-images-wrapper">
                    <div class="product-main-image">
                        <img src="{{ $mainImage }}" alt="{{ $product->name }}" id="mainProductImage">
                    </div>

                    <div class="product-thumbnails">
                        @foreach($gallery as $image)
                            <div class="thumbnail {{ $loop->first ? 'active' : '' }}">
                                <img src="{{ $image }}" alt="{{ $product->name }} view {{ $loop->iteration }}">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="product-info-wrapper">
                    <div class="product-header">
                        <span class="product-brand">{{ $product->brand }}</span>
                        <h1 class="product-title-large">{{ $product->name }}</h1>
                    </div>

                    <div class="product-price-section">
                        <div class="price-row">
                            <span class="current-price-large">Rs. {{ number_format((float) $product->price, 2) }}</span>
                            @if($product->original_price)
                                <span class="old-price">Rs. {{ number_format((float) $product->original_price, 2) }}</span>
                            @endif
                        </div>
                        <p class="tax-info">Inclusive of all taxes and free delivery</p>
                    </div>

                    <div class="product-short-desc">
                        <p>{{ $product->description ?: $product->short_description }}</p>
                    </div>

                    @if($product->size)
                        <div class="product-size-single-wrap">
                            <span class="size-single-label">Size:</span>
                            <span class="size-single-value">{{ $product->size }}</span>
                        </div>
                    @endif

                    <div class="product-quantity">
                        <label class="option-label">Quantity</label>
                        <div class="quantity-selector">
                            <button type="button" class="qty-btn minus" aria-label="Decrease quantity">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" class="qty-input" value="1" min="1" max="10" readonly>
                            <button type="button" class="qty-btn plus" aria-label="Increase quantity">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="product-actions">
                        <a href="#" class="btn btn-primary buy-now-btn purchase-trigger" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="Rs. {{ number_format((float) $product->price, 2) }}" data-quantity="1" data-authenticated="{{ auth()->check() ? '1' : '0' }}" style="width: 100%;">
                            <i class="fas fa-bolt"></i>
                            Buy Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

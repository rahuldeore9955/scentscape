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
                        <h1 class="product-title-large">{{ $product->name }}</h1>
                        @if($product->short_description)
                            <div class="product-short-desc">
                                <p>{{ $product->short_description }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="product-attributes">
                        <div class="product-attribute"><span>Category</span><strong>{{ ucfirst($product->category) }}</strong></div>
                        @if($product->size)
                            <div class="product-attribute"><span>Size</span><strong>{{ $product->size }}</strong></div>
                        @endif
                    </div>

                    <div class="product-price-section">
                        <div class="price-row">
                            <span class="current-price-large">Rs. {{ number_format((float) $product->price, 2) }}</span>
                        </div>
                    </div>

                    <div class="product-actions">
                        <a href="#" class="btn btn-primary buy-now-btn purchase-trigger" data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-price="Rs. {{ number_format((float) $product->price, 2) }}" data-authenticated="{{ auth()->check() ? '1' : '0' }}" style="width: 100%;">
                            <i class="fas fa-bolt"></i>
                            Buy Now
                        </a>
                    </div>
                </div>
            </div>

            @if($product->description)
                <section class="product-full-description">
                    <div>{!! nl2br(e($product->description)) !!}</div>
                </section>
            @endif
        </div>
    </section>

@endsection

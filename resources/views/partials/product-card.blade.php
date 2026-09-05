@php
    $fallbackImages = [
        'https://images.unsplash.com/photo-1541643600914-78b084683601?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1615634260167-c8cdede054de?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1523293182086-7651a899d37f?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1563170351-be82bc888aa4?w=500&h=500&fit=crop&q=80',
    ];

    $imageUrl = $product->image ?: $fallbackImages[$loopIndex % count($fallbackImages)];
    $badge = $product->badge;
@endphp

<div class="product-card" data-category="{{ $product->category }} {{ $badge }}">
    @if($badge)
        <div class="product-badge {{ $badge === 'new' ? 'new' : ($badge === 'sale' ? 'sale' : '') }}">
            {{ $badge === 'bestseller' ? 'Best Seller' : ucfirst($badge) }}
        </div>
    @endif

    <div class="product-image">
        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" loading="lazy">
        <div class="product-overlay">
            <a href="{{ route('products.show', $product) }}" class="quick-view-btn">
                <i class="fas fa-eye"></i> Quick View
            </a>
        </div>
        <button class="wishlist-btn" aria-label="Add to wishlist">
            <i class="far fa-heart"></i>
        </button>
    </div>

    <div class="product-info">
        <span class="product-brand">{{ $product->brand }}</span>
        <h3 class="product-name">{{ $product->name }}</h3>

        <div class="product-rating">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
            <span class="rating-count">({{ $product->reviews_count ?? 0 }})</span>
        </div>

        <div class="product-price">
            <span class="current-price">Rs. {{ number_format((float) $product->price, 2) }}</span>
            @if($product->original_price)
                <span class="old-price">Rs. {{ number_format((float) $product->original_price, 2) }}</span>
            @endif
        </div>

        <div class="product-card-btns">
            <a href="{{ route('products.show', $product) }}" class="btn-details">Details</a>
            <a href="#" class="btn-buy purchase-trigger" data-product-id="{{ $product->id }}" data-authenticated="{{ auth()->check() ? '1' : '0' }}">Buy</a>
        </div>
    </div>
</div>

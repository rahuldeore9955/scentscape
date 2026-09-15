@php($panelType = 'user')
@php($panelLinks = [['label' => 'Dashboard', 'icon' => 'fas fa-gauge-high', 'url' => route('dashboard.index')], ['label' => 'My Orders', 'icon' => 'fas fa-bag-shopping', 'url' => route('dashboard.orders')], ['label' => 'Profile', 'icon' => 'fas fa-user', 'url' => route('dashboard.profile')]])
@extends('layouts.panel')

@section('title', 'Products - ScentScape')
@section('page_heading', 'Products')

@section('content')
    <div class="panel-welcome">
        <span class="panel-eyebrow">Shop Fragrances</span>
        <h1>Products</h1>
        <p>Browse the latest fragrances available from ScentScape.</p>
    </div>

    <div class="dashboard-tab-header">
        <h2>{{ $products->count() }} {{ Str::plural('product', $products->count()) }}</h2>
        <form method="GET" action="{{ route('dashboard.products') }}" class="tab-header-actions">
            <div class="search-box-dashboard">
                <i class="fas fa-search"></i>
                <input class="search-input-dashboard" type="search" name="search" value="{{ request('search') }}" placeholder="Search products">
            </div>
            <select class="filter-select-dashboard" name="category" aria-label="Filter by category">
                <option value="">All categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" @selected(request('category') === $category)>{{ ucfirst($category) }}</option>
                @endforeach
            </select>
            <button type="submit" class="panel-primary-btn"><i class="fas fa-filter"></i> Filter</button>
            @if(request()->filled('search') || request()->filled('category'))
                <a href="{{ route('dashboard.products') }}" class="panel-link-btn">Clear</a>
            @endif
        </form>
    </div>

    <div class="products-grid">
        @forelse($products as $product)
            @include('partials.product-card', ['product' => $product, 'loopIndex' => $loop->index])
        @empty
            <p class="panel-empty">No products match your search.</p>
        @endforelse
    </div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.purchase-trigger').forEach((trigger) => {
        trigger.addEventListener('click', async (event) => {
            event.preventDefault();
            trigger.classList.add('is-loading');

            try {
                const response = await fetch('{{ route('checkout.start') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ product_id: trigger.dataset.productId, quantity: 1 }),
                });
                const result = await response.json();
                if (!response.ok) throw new Error(result.message || 'Unable to start checkout.');
                window.location.href = result.redirect;
            } catch (error) {
                alert(error.message);
                trigger.classList.remove('is-loading');
            }
        });
    });
</script>
@endpush

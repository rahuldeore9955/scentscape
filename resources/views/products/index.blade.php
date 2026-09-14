@extends('layouts.app')

@section('title', 'Products - ScentScape Premium Fragrances')
@section('meta_description', 'Shop our full collection of luxury fragrances - ScentScape')

@section('content')
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title">Our Collection</h1>
                <p class="page-subtitle">Discover our handpicked selection of luxury perfumes from prestigious brands.</p>
                <div class="breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <i class="fas fa-chevron-right"></i>
                    <span>Products</span>
                </div>
            </div>
        </div>
    </section>

    <section class="products-section section">
        <div class="container">
            <div class="products-grid">
                @forelse($products as $product)
                    @include('partials.product-card', ['product' => $product, 'loopIndex' => $loop->index])
                @empty
                    <p>No products found.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection

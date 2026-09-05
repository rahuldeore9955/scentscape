@extends('layouts.app')

@section('title', 'Blog - ScentScape')
@section('meta_description', 'Fragrance stories, perfume trends, and expert tips from ScentScape.')

@section('content')
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <h1 class="page-title">Fragrance Stories &amp; Tips</h1>
                <p class="page-subtitle">Discover perfume trends, expert advice, and stories from the world of fragrance.</p>
                <div class="breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <i class="fas fa-chevron-right"></i>
                    <span>Blog</span>
                </div>
            </div>
        </div>
    </section>

    <section class="blogs-section section">
        <div class="container">
            <div class="blogs-grid">
                @foreach($blogs as $blog)
                    <article class="blog-card">
                        <div class="blog-image">
                            <img src="https://images.unsplash.com/{{ $blog['image'] }}?w=600&amp;h=400&amp;fit=crop&amp;q=80" alt="{{ $blog['title'] }}" loading="lazy">
                            <div class="blog-category">{{ $blog['category'] }}</div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span class="blog-date"><i class="far fa-calendar"></i> {{ $blog['date'] }}</span>
                                <span class="blog-read-time"><i class="far fa-clock"></i> {{ $blog['time'] }}</span>
                            </div>
                            <h2 class="blog-title">{{ $blog['title'] }}</h2>
                            <p class="blog-excerpt">{{ $blog['excerpt'] }}</p>
                            <a href="{{ route('blogs.show', $blog['slug']) }}" class="blog-read-more">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection

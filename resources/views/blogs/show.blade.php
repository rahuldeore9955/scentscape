@extends('layouts.app')

@section('title', $blog['title'] . ' - ScentScape')
@section('meta_description', $blog['excerpt'])

@section('content')
    <section class="blog-breadcrumb">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('blogs.index') }}">Blog</a>
                <i class="fas fa-chevron-right"></i>
                <span>{{ $blog['category'] }}</span>
            </div>
        </div>
    </section>

    <section class="blog-details-section section">
        <div class="container">
            <article class="blog-main-content blog-detail-simple">
                <header class="article-header">
                    <div class="article-category"><span class="category-badge">{{ $blog['category'] }}</span></div>
                    <h1 class="article-title">{{ $blog['title'] }}</h1>
                    <div class="article-meta">
                        <div class="article-meta-items"><span class="meta-item"><i class="far fa-calendar"></i>{{ $blog['date'] }}</span><span class="meta-item"><i class="far fa-clock"></i>{{ $blog['time'] }}</span></div>
                    </div>
                </header>

                <div class="article-featured-image">
                    <img src="https://images.unsplash.com/{{ $blog['image'] }}?w=1200&amp;h=600&amp;fit=crop&amp;q=80" alt="{{ $blog['title'] }}">
                </div>

                <div class="article-content">
                    <p class="lead-paragraph">{{ $blog['intro'] }}</p>
                    @foreach($blog['sections'] as $section)
                        <h2>{{ $section['title'] }}</h2>
                        <p>{{ $section['text'] }}</p>
                    @endforeach
                </div>
            </article>
        </div>
    </section>

    <section class="faq-section section" id="faq">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">FAQ</span>
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-subtitle">Quick answers about fragrance selection, care, and shopping.</p>
            </div>
            <div class="faq-grid">
                <div class="faq-item active">
                    <button type="button" class="faq-question" aria-expanded="true" aria-controls="faq-answer-1">
                        <h3>How do I choose the right fragrance?</h3><i class="fas fa-chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="faq-answer" id="faq-answer-1"><p>Start with fragrance families you already enjoy, then test a small selection on your skin and allow time for the scent to develop.</p></div>
                </div>
                <div class="faq-item">
                    <button type="button" class="faq-question" aria-expanded="false" aria-controls="faq-answer-2">
                        <h3>How long does perfume usually last?</h3><i class="fas fa-chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="faq-answer" id="faq-answer-2"><p>Longevity depends on concentration, skin chemistry, weather, and application. Eau de parfum generally lasts longer than eau de toilette.</p></div>
                </div>
                <div class="faq-item">
                    <button type="button" class="faq-question" aria-expanded="false" aria-controls="faq-answer-3">
                        <h3>Where should I store my perfume?</h3><i class="fas fa-chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="faq-answer" id="faq-answer-3"><p>Store bottles upright in a cool, dry, shaded place away from direct sunlight, heat, and sudden temperature changes.</p></div>
                </div>
                <div class="faq-item">
                    <button type="button" class="faq-question" aria-expanded="false" aria-controls="faq-answer-4">
                        <h3>Can I buy a fragrance before creating an account?</h3><i class="fas fa-chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="faq-answer" id="faq-answer-4"><p>An account is required at checkout so your delivery details, order history, and tracking updates can be managed securely.</p></div>
                </div>
            </div>
        </div>
    </section>
@endsection

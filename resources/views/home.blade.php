@extends('layouts.app')

@section('title', 'ScentScape - Premium Fragrances & Perfumes')
@section('meta_description', 'ScentScape - Premium Fragrances & Perfumes E-Commerce')

@section('content')
    <section class="hero" id="home">
        <div class="hero-video-container">
            <video class="hero-video" autoplay muted loop playsinline poster="{{ asset('assets/images/1.webp') }}">
                <source src="{{ asset('assets/videos/perfume-hero.mp4') }}" type="video/mp4">
            </video>
            <div class="hero-overlay"></div>
        </div>

        <div class="hero-content">
            <div class="container">
                <div class="hero-text">
                    <h1 class="hero-title">
                        Luxury Fragrances<br>
                        <span class="gradient-text">Crafted for You</span>
                    </h1>
                    <p class="hero-description">
                        Explore our exclusive collection of premium perfumes from world-renowned brands.
                        Find the perfect fragrance that tells your unique story.
                    </p>
                    <div class="hero-buttons">
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            Shop Now
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="#about" class="btn btn-secondary">Explore Collection</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="scroll-indicator">
            <span>Scroll Down</span>
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <section class="about-section section" id="about">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Our Story</span>
                <h2 class="section-title">About ScentScape</h2>
                <p class="section-subtitle">
                    Crafting olfactory experiences through a careful collection of refined fragrances.
                </p>
            </div>

            <div class="about-content">
                <div class="about-story">
                    <div class="story-image">
                        <img src="https://images.unsplash.com/photo-1541643600914-78b084683601?w=800" alt="Luxury perfume bottles" loading="lazy">
                        <div class="image-overlay">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                    </div>
                    <div class="story-content">
                        <h3>The Art of Fragrance</h3>
                        <p>
                            ScentScape brings together iconic perfumes and distinctive modern scents for people
                            who want their fragrance to feel personal, polished, and memorable.
                        </p>
                        <p>
                            Each product is selected for character, longevity, and the kind of quiet luxury that
                            belongs in everyday rituals as much as special occasions.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="products-section section" id="products">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Our Collection</span>
                <h2 class="section-title">Featured Fragrances</h2>
                <p class="section-subtitle">
                    Discover a handpicked selection of luxury perfumes from prestigious brands.
                </p>
            </div>

            <div class="products-grid">
                @forelse($featuredProducts as $product)
                    @include('partials.product-card', ['product' => $product, 'loopIndex' => $loop->index])
                @empty
                    <p>No featured products are available yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    @php
        $testimonials = [
            ['name' => 'Priya Sharma', 'location' => 'Mumbai, India', 'avatar' => 1, 'text' => 'Absolutely amazing experience! I ordered Chanel No.5 and the delivery was super fast. The packaging was luxurious and the product is 100% authentic. I have never been disappointed and highly recommend ScentScape.'],
            ['name' => 'Rajesh Kumar', 'location' => 'Delhi, India', 'avatar' => 12, 'text' => 'Found my signature scent here! Dior Sauvage is exactly what I was looking for. The website is easy to navigate, the prices are competitive, and the authenticity guarantee gives great peace of mind.'],
            ['name' => 'Ananya Gupta', 'location' => 'Bangalore, India', 'avatar' => 5, 'text' => 'Great collection of luxury perfumes! I purchased YSL Black Opium during the sale and saved quite a bit. The fragrance is long-lasting and genuine, and shipping took only three days.'],
            ['name' => 'Arjun Mehta', 'location' => 'Pune, India', 'avatar' => 33, 'text' => 'Exceptional service from start to finish! Tom Ford Oud Wood arrived in perfect condition with elegant packaging. Their expert recommendations helped me choose the right scent.'],
            ['name' => 'Sneha Patel', 'location' => 'Ahmedabad, India', 'avatar' => 9, 'text' => 'Best online perfume store in India! ScentScape stands out with its authenticity guarantee and excellent customer service. The gift wrapping was beautiful and free.'],
            ['name' => 'Vikram Singh', 'location' => 'Jaipur, India', 'avatar' => 14, 'text' => 'Impressed with the quality and authenticity! Le Labo Santal 33 is my favorite and ScentScape always has it in stock. Customer support answered all my questions promptly.'],
        ];

        $videoReviews = [
            ['name' => 'Meera Joshi', 'title' => 'Unboxing Chanel No.5 - Premium Packaging!'],
            ['name' => 'Rahul Kapoor', 'title' => 'Dior Sauvage Review - My New Favorite!'],
            ['name' => 'Sanya Malhotra', 'title' => 'Fast Delivery & Authentic Products'],
            ['name' => 'Karan Singh', 'title' => 'Tom Ford Collection Haul 2026'],
            ['name' => 'Divya Reddy', 'title' => 'YSL Black Opium - Worth Every Rupee!'],
            ['name' => 'Aditya Sharma', 'title' => 'Le Labo Santal 33 - Luxury Unboxing'],
        ];

        $blogs = [
            ['slug' => 'choose-perfect-fragrance', 'category' => 'Guide', 'image' => 'photo-1523293182086-7651a899d37f', 'date' => 'June 10, 2026', 'time' => '5 min read', 'title' => 'How to Choose the Perfect Fragrance for Every Occasion', 'excerpt' => 'Discover the art of selecting the right perfume for different moments in your life.'],
        ];
    @endphp

    <section class="testimonials-section section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Testimonials</span>
                <h2 class="section-title">What Our Customers Say</h2>
                <p class="section-subtitle">Discover why thousands of fragrance lovers trust ScentScape for their perfect scent.</p>
            </div>

            <div class="testimonials-slider-wrapper">
                <div class="testimonials-slider">
                    @foreach($testimonials as $testimonial)
                        <div class="testimonial-card">
                            <div class="testimonial-header">
                                <img src="https://i.pravatar.cc/150?img={{ $testimonial['avatar'] }}" alt="{{ $testimonial['name'] }}" class="testimonial-avatar" loading="lazy">
                                <div class="testimonial-author-info">
                                    <h4 class="testimonial-author">{{ $testimonial['name'] }}</h4>
                                    <p class="testimonial-location">{{ $testimonial['location'] }}</p>
                                    <div class="testimonial-rating" aria-label="5 out of 5 stars">
                                        @for($star = 0; $star < 5; $star++)<i class="fas fa-star"></i>@endfor
                                    </div>
                                </div>
                            </div>
                            <div class="testimonial-content">
                                <p class="testimonial-text">{{ $testimonial['text'] }}</p>
                                <button type="button" class="read-more-btn">Read More</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="testimonials-slider-controls">
                    <button type="button" class="slider-btn slider-btn-prev" aria-label="Previous testimonial"><i class="fas fa-chevron-left"></i></button>
                    <div class="slider-dots"></div>
                    <button type="button" class="slider-btn slider-btn-next" aria-label="Next testimonial"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </section>

    <section class="video-testimonials-section section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Video Reviews</span>
                <h2 class="section-title">See What Our Customers Say</h2>
                <p class="section-subtitle">Real customers sharing their authentic experiences with ScentScape fragrances.</p>
            </div>

            <div class="video-slider-wrapper">
                <div class="video-slider">
                    @foreach($videoReviews as $review)
                        <div class="video-card" data-youtube-id="Ux2zKPR6RD0">
                            <div class="video-platform-badge youtube"><i class="fab fa-youtube"></i></div>
                            <div class="video-container">
                                <iframe class="testimonial-video-iframe" src="https://www.youtube.com/embed/Ux2zKPR6RD0?rel=0&modestbranding=1&playsinline=1" title="{{ $review['title'] }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
                            </div>
                            <div class="video-info">
                                <h4 class="video-author">{{ $review['name'] }}</h4>
                                <p class="video-description">{{ $review['title'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="video-slider-controls">
                    <button type="button" class="video-slider-btn video-slider-btn-prev" aria-label="Previous video"><i class="fas fa-chevron-left"></i></button>
                    <div class="video-slider-dots"></div>
                    <button type="button" class="video-slider-btn video-slider-btn-next" aria-label="Next video"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </section>

    <section class="blogs-section section">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Our Blog</span>
                <h2 class="section-title">Fragrance Stories &amp; Tips</h2>
                <p class="section-subtitle">Discover the latest trends, expert advice, and captivating stories from the world of perfumery.</p>
            </div>

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
                            <h3 class="blog-title">{{ $blog['title'] }}</h3>
                            <p class="blog-excerpt">{{ $blog['excerpt'] }}</p>
                            <a href="{{ route('blogs.show', $blog['slug']) }}" class="blog-read-more">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="blogs-cta">
                <a href="{{ route('blogs.index') }}" class="btn btn-primary">View All Articles <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>
@endsection

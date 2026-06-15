// ===================================
// ScentScape - JavaScript functionality
// ===================================

document.addEventListener('DOMContentLoaded', function() {
    console.log('ScentScape loaded successfully!');
    
    // ===================================
    // THEME TOGGLE (Dark/Light Mode)
    // ===================================
    const themeToggle = document.querySelector('.theme-toggle');
    const themeIcon = themeToggle.querySelector('i');
    const html = document.documentElement;
    
    // Check for saved theme preference or default to light mode
    const currentTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', currentTheme);
    updateThemeIcon(currentTheme);
    
    themeToggle.addEventListener('click', function() {
        const currentTheme = html.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        
        html.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateThemeIcon(newTheme);
    });
    
    function updateThemeIcon(theme) {
        if (theme === 'dark') {
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        } else {
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        }
    }
    
    // ===================================
    // NAVBAR SCROLL EFFECT
    // ===================================
    const header = document.querySelector('.header');
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
    
    // ===================================
    // MOBILE MENU TOGGLE
    // ===================================
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    menuToggle.addEventListener('click', function() {
        navMenu.classList.toggle('active');
        const icon = this.querySelector('i');
        
        if (navMenu.classList.contains('active')) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });
    
    // Close mobile menu when clicking on a link
    document.querySelectorAll('.nav-menu a').forEach(link => {
        link.addEventListener('click', function() {
            navMenu.classList.remove('active');
            const icon = menuToggle.querySelector('i');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        });
    });
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const isClickInsideMenu = navMenu.contains(event.target);
        const isClickOnToggle = menuToggle.contains(event.target);
        
        if (!isClickInsideMenu && !isClickOnToggle && navMenu.classList.contains('active')) {
            navMenu.classList.remove('active');
            const icon = menuToggle.querySelector('i');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });
    
    // ===================================
    // SMOOTH SCROLLING FOR ANCHOR LINKS
    // ===================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const headerHeight = header.offsetHeight;
                const targetPosition = target.offsetTop - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // ===================================
    // VIDEO PLAYBACK CONTROL (Performance)
    // ===================================
    const heroVideo = document.querySelector('.hero-video');
    
    if (heroVideo) {
        // Pause video when not in viewport (performance optimization)
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    heroVideo.play();
                } else {
                    heroVideo.pause();
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(heroVideo);
    }
    
    // ===================================
    // SHOPPING CART FUNCTIONALITY
    // ===================================
    let cartCount = 0;
    const cartCountElement = document.querySelector('.cart-count');
    
    function updateCartCount(count) {
        cartCount = count;
        cartCountElement.textContent = cartCount;
        
        // Add animation
        cartCountElement.style.transform = 'scale(1.3)';
        setTimeout(() => {
            cartCountElement.style.transform = 'scale(1)';
        }, 300);
    }
    
    // ===================================
    // SEARCH FUNCTIONALITY
    // ===================================
    const searchBtn = document.querySelector('.search-btn');
    
    searchBtn.addEventListener('click', function() {
        // Search functionality will be implemented here
        console.log('Search clicked');
        // You can add a search modal or redirect to search page
    });
    
    // ===================================
    // NEWSLETTER FORM HANDLER
    // ===================================
    const newsletterForm = document.querySelector('.newsletter-form');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const emailInput = this.querySelector('.newsletter-input');
            const email = emailInput.value;
            
            if (email) {
                // Here you would typically send the email to your backend
                console.log('Newsletter subscription:', email);
                alert('Thank you for subscribing! Check your email for confirmation.');
                emailInput.value = '';
            }
        });
    }
    
    // ===================================
    // PRODUCT FILTER FUNCTIONALITY
    // ===================================
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productCards = document.querySelectorAll('.product-card');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            const filterValue = this.getAttribute('data-filter');
            
            productCards.forEach(card => {
                if (filterValue === 'all') {
                    card.style.display = 'block';
                    card.classList.add('show');
                } else {
                    const categories = card.getAttribute('data-category');
                    if (categories.includes(filterValue)) {
                        card.style.display = 'block';
                        card.classList.add('show');
                    } else {
                        card.style.display = 'none';
                        card.classList.remove('show');
                    }
                }
            });
        });
    });
    
    // ===================================
    // WISHLIST FUNCTIONALITY
    // ===================================
    const wishlistButtons = document.querySelectorAll('.wishlist-btn');
    
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            this.classList.toggle('active');
            
            const icon = this.querySelector('i');
            if (this.classList.contains('active')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
            }
        });
    });
    
    // ===================================
    // ADD TO CART FUNCTIONALITY
    // ===================================
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productCard = this.closest('.product-card');
            const productName = productCard.querySelector('.product-name').textContent;
            
            // Update cart count
            updateCartCount(++cartCount);
            
            // Show notification
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-check"></i> Added!';
            this.style.background = '#4CAF50';
            
            setTimeout(() => {
                this.innerHTML = originalText;
                this.style.background = '';
            }, 2000);
            
            console.log('Added to cart:', productName);
        });
    });
    
    // ===================================
    // COUNTER ANIMATION (About Stats)
    // ===================================
    function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-target'));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const updateCounter = () => {
            current += step;
            if (current < target) {
                element.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target.toLocaleString();
            }
        };
        
        updateCounter();
    }
    
    // Intersection Observer for Stats Animation
    const statsSection = document.querySelector('.about-stats');
    
    if (statsSection) {
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px'
        };
        
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statNumbers = entry.target.querySelectorAll('.stat-number');
                    statNumbers.forEach(num => {
                        animateCounter(num);
                    });
                    statsObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        statsObserver.observe(statsSection);
    }
    
    // ===================================
    // TESTIMONIALS SLIDER - CONTINUOUS SMOOTH SCROLLING
    // ===================================
    const testimonialsSlider = document.querySelector('.testimonials-slider');
    const sliderPrevBtn = document.querySelector('.slider-btn-prev');
    const sliderNextBtn = document.querySelector('.slider-btn-next');
    const sliderDotsContainer = document.querySelector('.slider-dots');
    
    if (testimonialsSlider) {
        const testimonialCards = document.querySelectorAll('.testimonial-card');
        let currentIndex = 0;
        let cardsToShow = 3;
        let autoSlideInterval;
        let isSliderPaused = false;
        let isTransitioning = false;
        
        // Clone cards for infinite loop
        function cloneCards() {
            // Clone first set of cards and append to end
            const firstClones = [];
            for (let i = 0; i < cardsToShow; i++) {
                const clone = testimonialCards[i].cloneNode(true);
                clone.classList.add('clone');
                firstClones.push(clone);
                testimonialsSlider.appendChild(clone);
            }
            
            // Clone last set of cards and prepend to start
            const lastClones = [];
            for (let i = testimonialCards.length - cardsToShow; i < testimonialCards.length; i++) {
                const clone = testimonialCards[i].cloneNode(true);
                clone.classList.add('clone');
                lastClones.unshift(clone);
            }
            lastClones.forEach(clone => {
                testimonialsSlider.insertBefore(clone, testimonialsSlider.firstChild);
            });
            
            // Set initial position (offset by cloned cards)
            currentIndex = cardsToShow;
            updateSliderInstant();
        }
        
        // Calculate cards to show based on screen size
        function updateCardsToShow() {
            if (window.innerWidth <= 768) {
                cardsToShow = 1;
            } else if (window.innerWidth <= 1200) {
                cardsToShow = 2;
            } else {
                cardsToShow = 3;
            }
        }
        
        // Create dots
        function createDots() {
            sliderDotsContainer.innerHTML = '';
            const totalDots = testimonialCards.length;
            
            for (let i = 0; i < totalDots; i++) {
                const dot = document.createElement('span');
                dot.classList.add('slider-dot');
                if (i === 0) dot.classList.add('active');
                dot.addEventListener('click', () => {
                    goToSlide(i + cardsToShow);
                    resetAutoSlide();
                });
                sliderDotsContainer.appendChild(dot);
            }
        }
        
        // Update dots
        function updateDots() {
            const dots = document.querySelectorAll('.slider-dot');
            let actualIndex = currentIndex - cardsToShow;
            
            // Handle wrap around
            if (actualIndex < 0) actualIndex = testimonialCards.length + actualIndex;
            if (actualIndex >= testimonialCards.length) actualIndex = actualIndex - testimonialCards.length;
            
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === actualIndex);
            });
        }
        
        // Update slider position with smooth animation
        function updateSlider() {
            if (isTransitioning) return;
            isTransitioning = true;
            
            const allCards = document.querySelectorAll('.testimonial-card');
            const cardWidth = allCards[0].offsetWidth;
            const gap = 30;
            const offset = -(currentIndex * (cardWidth + gap));
            
            testimonialsSlider.style.transition = 'transform 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
            testimonialsSlider.style.transform = `translateX(${offset}px)`;
            
            updateDots();
            updateButtons();
            
            setTimeout(() => {
                isTransitioning = false;
                checkForLoop();
            }, 600);
        }
        
        // Update slider instantly (no animation)
        function updateSliderInstant() {
            const allCards = document.querySelectorAll('.testimonial-card');
            const cardWidth = allCards[0].offsetWidth;
            const gap = 30;
            const offset = -(currentIndex * (cardWidth + gap));
            
            testimonialsSlider.style.transition = 'none';
            testimonialsSlider.style.transform = `translateX(${offset}px)`;
            
            updateDots();
            updateButtons();
        }
        
        // Check if we need to loop
        function checkForLoop() {
            const allCards = document.querySelectorAll('.testimonial-card');
            const maxIndex = allCards.length - cardsToShow;
            
            // If at cloned start, jump to real start
            if (currentIndex <= 0) {
                currentIndex = testimonialCards.length;
                updateSliderInstant();
            }
            
            // If at cloned end, jump to real end
            if (currentIndex >= maxIndex) {
                currentIndex = cardsToShow;
                updateSliderInstant();
            }
        }
        
        // Update button states
        function updateButtons() {
            // Always enable buttons for infinite scroll
            sliderPrevBtn.disabled = false;
            sliderNextBtn.disabled = false;
        }
        
        // Go to specific slide
        function goToSlide(index) {
            if (isTransitioning) return;
            currentIndex = index;
            updateSlider();
        }
        
        // Previous slide
        sliderPrevBtn.addEventListener('click', () => {
            if (isTransitioning) return;
            currentIndex--;
            updateSlider();
            resetAutoSlide();
        });
        
        // Next slide
        sliderNextBtn.addEventListener('click', () => {
            if (isTransitioning) return;
            currentIndex++;
            updateSlider();
            resetAutoSlide();
        });
        
        // Auto slide function - continuous
        function startAutoSlide() {
            if (isSliderPaused) return;
            
            autoSlideInterval = setInterval(() => {
                if (isSliderPaused || isTransitioning) return;
                currentIndex++;
                updateSlider();
            }, 4000);
        }
        
        // Stop auto slide
        function stopAutoSlide() {
            if (autoSlideInterval) {
                clearInterval(autoSlideInterval);
                autoSlideInterval = null;
            }
        }
        
        // Reset auto slide
        function resetAutoSlide() {
            stopAutoSlide();
            if (!isSliderPaused) {
                startAutoSlide();
            }
        }
        
        // Pause on hover
        const sliderWrapper = document.querySelector('.testimonials-slider-wrapper');
        
        sliderWrapper.addEventListener('mouseenter', () => {
            isSliderPaused = true;
            stopAutoSlide();
        });
        
        sliderWrapper.addEventListener('mouseleave', () => {
            isSliderPaused = false;
            startAutoSlide();
        });
        
        // Pause on card hover
        testimonialsSlider.addEventListener('mouseenter', () => {
            isSliderPaused = true;
            stopAutoSlide();
        });
        
        testimonialsSlider.addEventListener('mouseleave', () => {
            isSliderPaused = false;
            startAutoSlide();
        });
        
        // Handle window resize
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                const oldCardsToShow = cardsToShow;
                updateCardsToShow();
                
                if (oldCardsToShow !== cardsToShow) {
                    // Remove clones
                    document.querySelectorAll('.testimonial-card.clone').forEach(clone => clone.remove());
                    // Recreate
                    currentIndex = 0;
                    cloneCards();
                    createDots();
                    resetAutoSlide();
                } else {
                    updateSliderInstant();
                }
            }, 250);
        });
        
        // Handle visibility change
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                isSliderPaused = true;
                stopAutoSlide();
            } else {
                isSliderPaused = false;
                startAutoSlide();
            }
        });
        
        // Initialize
        updateCardsToShow();
        cloneCards();
        createDots();
        startAutoSlide();
    }
    
    // ===================================
    // READ MORE / READ LESS FUNCTIONALITY
    // ===================================
    const readMoreButtons = document.querySelectorAll('.read-more-btn');
    
    readMoreButtons.forEach(button => {
        button.addEventListener('click', function() {
            const testimonialText = this.previousElementSibling;
            const isExpanded = testimonialText.classList.contains('expanded');
            
            if (isExpanded) {
                testimonialText.classList.remove('expanded');
                this.textContent = 'Read More';
                this.classList.remove('expanded');
            } else {
                testimonialText.classList.add('expanded');
                this.textContent = 'Read Less';
                this.classList.add('expanded');
            }
        });
    });
});

    // ===================================
    // VIDEO TESTIMONIALS SLIDER - CONTINUOUS SMOOTH SCROLLING
    // ===================================
    const videoSlider = document.querySelector('.video-slider');
    const videoSliderPrevBtn = document.querySelector('.video-slider-btn-prev');
    const videoSliderNextBtn = document.querySelector('.video-slider-btn-next');
    const videoSliderDotsContainer = document.querySelector('.video-slider-dots');
    
    if (videoSlider) {
        const videoCards = document.querySelectorAll('.video-card');
        let videoCurrentIndex = 0;
        let videoCardsToShow = 4;
        let videoAutoSlideInterval;
        let isVideoSliderPaused = false;
        let isVideoTransitioning = false;
        let currentlyPlayingVideo = null;
        
        // Clone cards for infinite loop
        function cloneVideoCards() {
            // Clone first set of cards and append to end
            for (let i = 0; i < videoCardsToShow; i++) {
                const clone = videoCards[i].cloneNode(true);
                clone.classList.add('clone');
                videoSlider.appendChild(clone);
            }
            
            // Clone last set of cards and prepend to start
            const lastClones = [];
            for (let i = videoCards.length - videoCardsToShow; i < videoCards.length; i++) {
                const clone = videoCards[i].cloneNode(true);
                clone.classList.add('clone');
                lastClones.unshift(clone);
            }
            lastClones.forEach(clone => {
                videoSlider.insertBefore(clone, videoSlider.firstChild);
            });
            
            // Set initial position (offset by cloned cards)
            videoCurrentIndex = videoCardsToShow;
            updateVideoSliderInstant();
            
            // Re-attach event listeners to cloned video play buttons
            attachVideoPlayListeners();
        }
        
        // Calculate cards to show based on screen size
        function updateVideoCardsToShow() {
            if (window.innerWidth <= 576) {
                videoCardsToShow = 1;
            } else if (window.innerWidth <= 992) {
                videoCardsToShow = 2;
            } else if (window.innerWidth <= 1200) {
                videoCardsToShow = 3;
            } else {
                videoCardsToShow = 4;
            }
        }
        
        // Create dots
        function createVideoDots() {
            videoSliderDotsContainer.innerHTML = '';
            const totalDots = videoCards.length;
            
            for (let i = 0; i < totalDots; i++) {
                const dot = document.createElement('span');
                dot.classList.add('video-slider-dot');
                if (i === 0) dot.classList.add('active');
                dot.addEventListener('click', () => {
                    goToVideoSlide(i + videoCardsToShow);
                    resetVideoAutoSlide();
                });
                videoSliderDotsContainer.appendChild(dot);
            }
        }
        
        // Update dots
        function updateVideoDots() {
            const dots = document.querySelectorAll('.video-slider-dot');
            let actualIndex = videoCurrentIndex - videoCardsToShow;
            
            // Handle wrap around
            if (actualIndex < 0) actualIndex = videoCards.length + actualIndex;
            if (actualIndex >= videoCards.length) actualIndex = actualIndex - videoCards.length;
            
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === actualIndex);
            });
        }
        
        // Update slider position with smooth animation
        function updateVideoSlider() {
            if (isVideoTransitioning) return;
            isVideoTransitioning = true;
            
            const allCards = document.querySelectorAll('.video-card');
            const cardWidth = allCards[0].offsetWidth;
            const gap = 25;
            const offset = -(videoCurrentIndex * (cardWidth + gap));
            
            videoSlider.style.transition = 'transform 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
            videoSlider.style.transform = `translateX(${offset}px)`;
            
            updateVideoDots();
            updateVideoButtons();
            
            setTimeout(() => {
                isVideoTransitioning = false;
                checkForVideoLoop();
            }, 600);
        }
        
        // Update slider instantly (no animation)
        function updateVideoSliderInstant() {
            const allCards = document.querySelectorAll('.video-card');
            const cardWidth = allCards[0].offsetWidth;
            const gap = 25;
            const offset = -(videoCurrentIndex * (cardWidth + gap));
            
            videoSlider.style.transition = 'none';
            videoSlider.style.transform = `translateX(${offset}px)`;
            
            updateVideoDots();
            updateVideoButtons();
        }
        
        // Check if we need to loop
        function checkForVideoLoop() {
            const allCards = document.querySelectorAll('.video-card');
            const maxIndex = allCards.length - videoCardsToShow;
            
            // If at cloned start, jump to real start
            if (videoCurrentIndex <= 0) {
                videoCurrentIndex = videoCards.length;
                updateVideoSliderInstant();
            }
            
            // If at cloned end, jump to real end
            if (videoCurrentIndex >= maxIndex) {
                videoCurrentIndex = videoCardsToShow;
                updateVideoSliderInstant();
            }
        }
        
        // Update button states
        function updateVideoButtons() {
            // Always enable buttons for infinite scroll
            videoSliderPrevBtn.disabled = false;
            videoSliderNextBtn.disabled = false;
        }
        
        // Go to specific slide
        function goToVideoSlide(index) {
            if (isVideoTransitioning) return;
            videoCurrentIndex = index;
            updateVideoSlider();
        }
        
        // Previous slide
        videoSliderPrevBtn.addEventListener('click', () => {
            if (isVideoTransitioning) return;
            videoCurrentIndex--;
            updateVideoSlider();
            resetVideoAutoSlide();
        });
        
        // Next slide
        videoSliderNextBtn.addEventListener('click', () => {
            if (isVideoTransitioning) return;
            videoCurrentIndex++;
            updateVideoSlider();
            resetVideoAutoSlide();
        });
        
        // Auto slide function - continuous
        function startVideoAutoSlide() {
            if (isVideoSliderPaused) return;
            
            videoAutoSlideInterval = setInterval(() => {
                if (isVideoSliderPaused || isVideoTransitioning) return;
                videoCurrentIndex++;
                updateVideoSlider();
            }, 4000);
        }
        
        // Stop auto slide
        function stopVideoAutoSlide() {
            if (videoAutoSlideInterval) {
                clearInterval(videoAutoSlideInterval);
                videoAutoSlideInterval = null;
            }
        }
        
        // Reset auto slide
        function resetVideoAutoSlide() {
            stopVideoAutoSlide();
            if (!isVideoSliderPaused) {
                startVideoAutoSlide();
            }
        }
        
        // Pause on hover
        const videoSliderWrapper = document.querySelector('.video-slider-wrapper');
        
        videoSliderWrapper.addEventListener('mouseenter', () => {
            isVideoSliderPaused = true;
            stopVideoAutoSlide();
        });
        
        videoSliderWrapper.addEventListener('mouseleave', () => {
            isVideoSliderPaused = false;
            startVideoAutoSlide();
        });
        
        // Pause on card hover
        videoSlider.addEventListener('mouseenter', () => {
            isVideoSliderPaused = true;
            stopVideoAutoSlide();
        });
        
        videoSlider.addEventListener('mouseleave', () => {
            isVideoSliderPaused = false;
            startVideoAutoSlide();
        });
        
        // Video Play Functionality
        function attachVideoPlayListeners() {
            const allVideoPlayBtns = document.querySelectorAll('.video-play-btn');
            
            allVideoPlayBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    
                    const videoCard = this.closest('.video-card');
                    const video = videoCard.querySelector('.testimonial-video');
                    const overlay = videoCard.querySelector('.video-play-overlay');
                    
                    // Pause any currently playing video
                    if (currentlyPlayingVideo && currentlyPlayingVideo !== video) {
                        currentlyPlayingVideo.pause();
                        currentlyPlayingVideo.currentTime = 0;
                        const prevOverlay = currentlyPlayingVideo.closest('.video-card').querySelector('.video-play-overlay');
                        prevOverlay.classList.remove('playing');
                        const prevPlayBtn = prevOverlay.querySelector('.video-play-btn');
                        prevPlayBtn.innerHTML = '<i class="fas fa-play"></i>';
                    }
                    
                    if (video.paused) {
                        video.play();
                        overlay.classList.add('playing');
                        this.innerHTML = '<i class="fas fa-pause"></i>';
                        currentlyPlayingVideo = video;
                        
                        // Pause slider while video is playing
                        isVideoSliderPaused = true;
                        stopVideoAutoSlide();
                    } else {
                        video.pause();
                        overlay.classList.remove('playing');
                        this.innerHTML = '<i class="fas fa-play"></i>';
                        currentlyPlayingVideo = null;
                        
                        // Resume slider
                        isVideoSliderPaused = false;
                        startVideoAutoSlide();
                    }
                });
            });
            
            // Handle video ended event
            const allVideos = document.querySelectorAll('.testimonial-video');
            allVideos.forEach(video => {
                video.addEventListener('ended', function() {
                    const overlay = this.closest('.video-card').querySelector('.video-play-overlay');
                    const playBtn = overlay.querySelector('.video-play-btn');
                    
                    overlay.classList.remove('playing');
                    playBtn.innerHTML = '<i class="fas fa-play"></i>';
                    this.currentTime = 0;
                    currentlyPlayingVideo = null;
                    
                    // Resume slider
                    isVideoSliderPaused = false;
                    startVideoAutoSlide();
                });
            });
        }
        
        // Handle window resize
        let videoResizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(videoResizeTimeout);
            videoResizeTimeout = setTimeout(() => {
                const oldCardsToShow = videoCardsToShow;
                updateVideoCardsToShow();
                
                if (oldCardsToShow !== videoCardsToShow) {
                    // Remove clones
                    document.querySelectorAll('.video-card.clone').forEach(clone => clone.remove());
                    // Recreate
                    videoCurrentIndex = 0;
                    cloneVideoCards();
                    createVideoDots();
                    resetVideoAutoSlide();
                } else {
                    updateVideoSliderInstant();
                }
            }, 250);
        });
        
        // Handle visibility change
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                isVideoSliderPaused = true;
                stopVideoAutoSlide();
                
                // Pause any playing video
                if (currentlyPlayingVideo) {
                    currentlyPlayingVideo.pause();
                }
            } else {
                isVideoSliderPaused = false;
                startVideoAutoSlide();
            }
        });
        
        // Initialize
        updateVideoCardsToShow();
        cloneVideoCards();
        createVideoDots();
        attachVideoPlayListeners();
        startVideoAutoSlide();
    }


// ===================================
// CONTACT FORM HANDLER
// ===================================
const contactForm = document.getElementById('contactForm');

if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = {
            firstName: this.firstName.value,
            lastName: this.lastName.value,
            email: this.email.value,
            phone: this.phone.value,
            message: this.message.value,
            newsletter: this.newsletter.checked
        };
        
        // Show loading state
        const submitBtn = this.querySelector('.submit-btn');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        submitBtn.disabled = true;
        
        // Simulate form submission (replace with actual API call)
        setTimeout(() => {
            console.log('Contact form submitted:', formData);
            
            // Show success message
            submitBtn.innerHTML = '<i class="fas fa-check"></i> Message Sent!';
            submitBtn.style.background = '#4CAF50';
            
            // Reset form
            this.reset();
            
            // Show alert
            alert('Thank you for contacting us! We will get back to you within 24 hours.');
            
            // Reset button after 3 seconds
            setTimeout(() => {
                submitBtn.innerHTML = originalBtnText;
                submitBtn.style.background = '';
                submitBtn.disabled = false;
            }, 3000);
        }, 2000);
    });
    
    // Real-time validation
    const inputs = contactForm.querySelectorAll('.form-input');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.style.borderColor = '#f44336';
            } else {
                this.style.borderColor = '';
            }
        });
        
        input.addEventListener('input', function() {
            if (this.style.borderColor === 'rgb(244, 67, 54)') {
                this.style.borderColor = '';
            }
        });
    });
}

// ===================================
// FAQ ACCORDION
// ===================================
const faqItems = document.querySelectorAll('.faq-item');

faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');
    
    question.addEventListener('click', () => {
        // Close other items
        const isActive = item.classList.contains('active');
        
        faqItems.forEach(otherItem => {
            otherItem.classList.remove('active');
        });
        
        // Toggle current item
        if (!isActive) {
            item.classList.add('active');
        }
    });
});

// Open first FAQ by default
if (faqItems.length > 0) {
    faqItems[0].classList.add('active');
}


// ===================================
// PRODUCT DETAILS PAGE FUNCTIONALITY
// ===================================

// Product Image Gallery
const thumbnails = document.querySelectorAll('.thumbnail');
const mainImage = document.getElementById('mainProductImage');

if (thumbnails.length > 0 && mainImage) {
    thumbnails.forEach(thumb => {
        thumb.addEventListener('click', function() {
            // Remove active class from all thumbnails
            thumbnails.forEach(t => t.classList.remove('active'));
            // Add active class to clicked thumbnail
            this.classList.add('active');
            // Change main image
            const newImage = this.querySelector('img').src.replace('150', '800');
            mainImage.src = newImage;
        });
    });
}

// Wishlist Toggle (Large Button)
const wishlistBtnLarge = document.querySelector('.wishlist-btn-large');

if (wishlistBtnLarge) {
    wishlistBtnLarge.addEventListener('click', function() {
        this.classList.toggle('active');
        const icon = this.querySelector('i');
        
        if (this.classList.contains('active')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
        }
    });
}

// Size Selection
const sizeButtons = document.querySelectorAll('.size-btn');
const currentPriceLarge = document.querySelector('.current-price-large');

sizeButtons.forEach(button => {
    button.addEventListener('click', function() {
        // Remove active class from all size buttons
        sizeButtons.forEach(btn => btn.classList.remove('active'));
        // Add active class to clicked button
        this.classList.add('active');
        
        // Update price
        const price = this.getAttribute('data-price');
        if (currentPriceLarge) {
            currentPriceLarge.textContent = `₹${parseInt(price).toLocaleString('en-IN')}`;
        }
    });
});

// Quantity Selector
const qtyInput = document.querySelector('.qty-input');
const qtyMinus = document.querySelector('.qty-btn.minus');
const qtyPlus = document.querySelector('.qty-btn.plus');

if (qtyInput && qtyMinus && qtyPlus) {
    qtyMinus.addEventListener('click', function() {
        let value = parseInt(qtyInput.value);
        if (value > 1) {
            qtyInput.value = value - 1;
        }
    });
    
    qtyPlus.addEventListener('click', function() {
        let value = parseInt(qtyInput.value);
        const max = parseInt(qtyInput.getAttribute('max'));
        if (value < max) {
            qtyInput.value = value + 1;
        }
    });
}

// Add to Cart (Product Details)
const addToCartLarge = document.querySelector('.add-to-cart-large');

if (addToCartLarge) {
    addToCartLarge.addEventListener('click', function() {
        const quantity = qtyInput ? parseInt(qtyInput.value) : 1;
        const activeSize = document.querySelector('.size-btn.active');
        const size = activeSize ? activeSize.getAttribute('data-size') : '100ml';
        
        // Update cart count
        if (cartCountElement) {
            updateCartCount(cartCount + quantity);
        }
        
        // Show notification
        const originalText = this.innerHTML;
        this.innerHTML = '<i class="fas fa-check"></i> Added to Cart!';
        this.style.background = '#4CAF50';
        
        setTimeout(() => {
            this.innerHTML = originalText;
            this.style.background = '';
        }, 2000);
        
        console.log(`Added ${quantity} x ${size} to cart`);
    });
}

// Buy Now Button
const buyNowBtn = document.querySelector('.buy-now-btn');

if (buyNowBtn) {
    buyNowBtn.addEventListener('click', function() {
        alert('Proceeding to checkout...');
        // In a real application, this would redirect to checkout
        console.log('Buy now clicked');
    });
}

// Product Tabs
const tabButtons = document.querySelectorAll('.tab-btn');
const tabContents = document.querySelectorAll('.tab-content');

tabButtons.forEach(button => {
    button.addEventListener('click', function() {
        const tabId = this.getAttribute('data-tab');
        
        // Remove active class from all buttons and contents
        tabButtons.forEach(btn => btn.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));
        
        // Add active class to clicked button and corresponding content
        this.classList.add('active');
        document.getElementById(tabId).classList.add('active');
    });
});

// Share Buttons
const shareButtons = document.querySelectorAll('.share-btn');

shareButtons.forEach(button => {
    button.addEventListener('click', function() {
        const platform = this.classList.contains('facebook') ? 'Facebook' :
                        this.classList.contains('twitter') ? 'Twitter' :
                        this.classList.contains('pinterest') ? 'Pinterest' :
                        this.classList.contains('whatsapp') ? 'WhatsApp' : 'Unknown';
        
        console.log(`Share on ${platform}`);
        
        // In a real application, this would open share dialog
        const productUrl = window.location.href;
        const productTitle = document.querySelector('.product-title-large')?.textContent || 'Product';
        
        let shareUrl = '';
        
        switch(platform) {
            case 'Facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(productUrl)}`;
                break;
            case 'Twitter':
                shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(productUrl)}&text=${encodeURIComponent(productTitle)}`;
                break;
            case 'Pinterest':
                shareUrl = `https://pinterest.com/pin/create/button/?url=${encodeURIComponent(productUrl)}&description=${encodeURIComponent(productTitle)}`;
                break;
            case 'WhatsApp':
                shareUrl = `https://wa.me/?text=${encodeURIComponent(productTitle + ' ' + productUrl)}`;
                break;
        }
        
        if (shareUrl) {
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    });
});

// Write Review Button
const writeReviewBtn = document.querySelector('.write-review-btn');

if (writeReviewBtn) {
    writeReviewBtn.addEventListener('click', function() {
        alert('Review form will open here...');
        // In a real application, this would open a review modal
        console.log('Write review clicked');
    });
}

// Load More Reviews
const loadMoreReviews = document.querySelector('.load-more-reviews');

if (loadMoreReviews) {
    loadMoreReviews.addEventListener('click', function() {
        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
        
        // Simulate loading
        setTimeout(() => {
            this.innerHTML = 'Load More Reviews';
            alert('More reviews would load here...');
        }, 1000);
    });
}

// Helpful Button
const helpfulButtons = document.querySelectorAll('.helpful-btn');

helpfulButtons.forEach(button => {
    button.addEventListener('click', function() {
        const icon = this.querySelector('i');
        const countSpan = this.childNodes[2]; // The text node with count
        
        if (!icon.classList.contains('fas')) {
            // Mark as helpful
            icon.classList.remove('far');
            icon.classList.add('fas');
            this.style.borderColor = 'var(--primary-color)';
            this.style.color = 'var(--primary-color)';
            
            // Increment count
            const currentCount = parseInt(countSpan.textContent.trim());
            countSpan.textContent = ' ' + (currentCount + 1);
        }
    });
});


// ===================================
// BLOG DETAILS PAGE FUNCTIONALITY
// ===================================

// Share Buttons (Blog)
const shareBtnsBlog = document.querySelectorAll('.share-btn-blog');

shareBtnsBlog.forEach(button => {
    button.addEventListener('click', function() {
        const articleUrl = window.location.href;
        const articleTitle = document.querySelector('.article-title')?.textContent || 'Article';
        
        let shareUrl = '';
        
        if (this.classList.contains('facebook')) {
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(articleUrl)}`;
        } else if (this.classList.contains('twitter')) {
            shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(articleUrl)}&text=${encodeURIComponent(articleTitle)}`;
        } else if (this.classList.contains('linkedin')) {
            shareUrl = `https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(articleUrl)}&title=${encodeURIComponent(articleTitle)}`;
        } else if (this.classList.contains('pinterest')) {
            shareUrl = `https://pinterest.com/pin/create/button/?url=${encodeURIComponent(articleUrl)}&description=${encodeURIComponent(articleTitle)}`;
        } else if (this.classList.contains('whatsapp')) {
            shareUrl = `https://wa.me/?text=${encodeURIComponent(articleTitle + ' ' + articleUrl)}`;
        }
        
        if (shareUrl) {
            window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    });
});

// Comment Form Handler
const commentFormBlog = document.getElementById('commentForm');

if (commentFormBlog) {
    commentFormBlog.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('.btn');
        const originalText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Posting...';
        submitBtn.disabled = true;
        
        // Simulate comment submission
        setTimeout(() => {
            submitBtn.innerHTML = '<i class="fas fa-check"></i> Comment Posted!';
            submitBtn.style.background = '#4CAF50';
            
            // Reset form
            this.reset();
            
            alert('Thank you for your comment! It will be visible after moderation.');
            
            // Reset button after 2 seconds
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.style.background = '';
                submitBtn.disabled = false;
            }, 2000);
        }, 1500);
    });
}

// Comment Reply Buttons
const replyButtons = document.querySelectorAll('.comment-reply-btn');

replyButtons.forEach(button => {
    button.addEventListener('click', function() {
        const commentItem = this.closest('.comment-item');
        const authorName = commentItem.querySelector('.comment-author').textContent;
        
        // Scroll to comment form
        const commentForm = document.querySelector('.comment-form-wrapper');
        if (commentForm) {
            commentForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
            
            // Focus on textarea
            setTimeout(() => {
                const textarea = commentForm.querySelector('textarea');
                if (textarea) {
                    textarea.focus();
                    textarea.value = `@${authorName} `;
                }
            }, 500);
        }
    });
});

// Sidebar Search
const sidebarSearchForm = document.querySelector('.sidebar-search-form');

if (sidebarSearchForm) {
    sidebarSearchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const searchInput = this.querySelector('.sidebar-search-input');
        const searchTerm = searchInput.value.trim();
        
        if (searchTerm) {
            console.log('Searching for:', searchTerm);
            alert(`Searching for: "${searchTerm}"\n\nSearch results would appear here...`);
            // In a real application, this would redirect to search results page
        }
    });
}

// Newsletter Widget
const widgetNewsletterForm = document.querySelector('.widget-newsletter-form');

if (widgetNewsletterForm) {
    widgetNewsletterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const emailInput = this.querySelector('.form-input');
        const submitBtn = this.querySelector('.btn');
        const originalText = submitBtn.textContent;
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Subscribing...';
        submitBtn.disabled = true;
        
        setTimeout(() => {
            submitBtn.innerHTML = '<i class="fas fa-check"></i> Subscribed!';
            emailInput.value = '';
            
            setTimeout(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }, 2000);
        }, 1000);
    });
}


// ===================================
// AUTHENTICATION PAGE FUNCTIONALITY
// ===================================

// Toggle between Login and Register forms
const authToggleBtns = document.querySelectorAll('.auth-toggle-btn');
const authForms = document.querySelectorAll('.auth-form-container');
const authSwitchLinks = document.querySelectorAll('.auth-switch-link');

// Toggle form using toggle buttons
authToggleBtns.forEach(button => {
    button.addEventListener('click', function() {
        const formType = this.getAttribute('data-form');
        switchAuthForm(formType);
    });
});

// Toggle form using switch links
authSwitchLinks.forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const formType = this.getAttribute('data-switch');
        switchAuthForm(formType);
    });
});

// Switch form function
function switchAuthForm(formType) {
    // Remove active class from all toggle buttons and forms
    authToggleBtns.forEach(btn => btn.classList.remove('active'));
    authForms.forEach(form => form.classList.remove('active'));
    
    // Add active class to selected toggle button
    const activeToggleBtn = document.querySelector(`.auth-toggle-btn[data-form="${formType}"]`);
    if (activeToggleBtn) {
        activeToggleBtn.classList.add('active');
    }
    
    // Show selected form
    const activeForm = document.getElementById(formType + 'Form');
    if (activeForm) {
        activeForm.classList.add('active');
    }
}

// Password Show/Hide Toggle
const passwordToggleBtns = document.querySelectorAll('.password-toggle-btn');

passwordToggleBtns.forEach(button => {
    button.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const passwordInput = document.getElementById(targetId);
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});

// Password Strength Checker
const registerPasswordInput = document.getElementById('registerPassword');
const strengthBar = document.querySelector('.strength-bar-fill');
const strengthText = document.querySelector('.strength-text');

if (registerPasswordInput && strengthBar && strengthText) {
    registerPasswordInput.addEventListener('input', function() {
        const password = this.value;
        const strength = calculatePasswordStrength(password);
        
        // Remove all strength classes
        strengthBar.classList.remove('weak', 'medium', 'strong');
        
        if (password.length === 0) {
            strengthBar.style.width = '0%';
            strengthText.textContent = 'Password strength';
            strengthText.style.color = 'var(--text-muted)';
        } else if (strength < 40) {
            strengthBar.classList.add('weak');
            strengthText.textContent = 'Weak password';
            strengthText.style.color = '#f44336';
        } else if (strength < 70) {
            strengthBar.classList.add('medium');
            strengthText.textContent = 'Medium password';
            strengthText.style.color = '#ff9800';
        } else {
            strengthBar.classList.add('strong');
            strengthText.textContent = 'Strong password';
            strengthText.style.color = '#4CAF50';
        }
    });
}

// Calculate password strength
function calculatePasswordStrength(password) {
    let strength = 0;
    
    // Length
    if (password.length >= 8) strength += 25;
    if (password.length >= 12) strength += 15;
    
    // Contains lowercase
    if (/[a-z]/.test(password)) strength += 15;
    
    // Contains uppercase
    if (/[A-Z]/.test(password)) strength += 15;
    
    // Contains numbers
    if (/\d/.test(password)) strength += 15;
    
    // Contains special characters
    if (/[^a-zA-Z0-9]/.test(password)) strength += 15;
    
    return strength;
}

// Login Form Submission
const loginFormElement = document.getElementById('loginFormElement');

if (loginFormElement) {
    loginFormElement.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            email: this.email.value,
            password: this.password.value,
            remember: this.remember.checked
        };
        
        // Validate
        if (!formData.email || !formData.password) {
            alert('Please fill in all fields');
            return;
        }
        
        // Show loading state
        const submitBtn = this.querySelector('.auth-submit-btn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...';
        submitBtn.disabled = true;
        
        // Simulate login (replace with actual API call)
        setTimeout(() => {
            console.log('Login data:', formData);
            
            // Show success message
            submitBtn.innerHTML = '<i class="fas fa-check"></i> Success!';
            submitBtn.style.background = '#4CAF50';
            
            alert('Login successful! Redirecting to homepage...');
            
            // Reset form
            this.reset();
            
            // In a real application, redirect to dashboard or homepage
            // window.location.href = 'index.html';
            
            // Reset button after 2 seconds
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.style.background = '';
                submitBtn.disabled = false;
            }, 2000);
        }, 1500);
    });
}

// Register Form Submission
const registerFormElement = document.getElementById('registerFormElement');

if (registerFormElement) {
    registerFormElement.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            name: this.name.value,
            email: this.email.value,
            phone: this.phone.value,
            password: this.password.value,
            confirmPassword: this.confirmPassword.value,
            terms: this.terms.checked
        };
        
        // Validate
        if (!formData.name || !formData.email || !formData.phone || !formData.password || !formData.confirmPassword) {
            alert('Please fill in all fields');
            return;
        }
        
        // Check if passwords match
        if (formData.password !== formData.confirmPassword) {
            alert('Passwords do not match!');
            return;
        }
        
        // Check password strength
        const strength = calculatePasswordStrength(formData.password);
        if (strength < 40) {
            alert('Please use a stronger password');
            return;
        }
        
        // Check terms acceptance
        if (!formData.terms) {
            alert('Please accept the Terms & Conditions');
            return;
        }
        
        // Show loading state
        const submitBtn = this.querySelector('.auth-submit-btn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
        submitBtn.disabled = true;
        
        // Simulate registration (replace with actual API call)
        setTimeout(() => {
            console.log('Register data:', formData);
            
            // Show success message
            submitBtn.innerHTML = '<i class="fas fa-check"></i> Account Created!';
            submitBtn.style.background = '#4CAF50';
            
            alert('Account created successfully! Please check your email for verification.');
            
            // Reset form
            this.reset();
            
            // Reset password strength indicator
            if (strengthBar && strengthText) {
                strengthBar.style.width = '0%';
                strengthBar.classList.remove('weak', 'medium', 'strong');
                strengthText.textContent = 'Password strength';
                strengthText.style.color = 'var(--text-muted)';
            }
            
            // Switch to login form
            setTimeout(() => {
                switchAuthForm('login');
            }, 1500);
            
            // Reset button after 2 seconds
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.style.background = '';
                submitBtn.disabled = false;
            }, 2000);
        }, 1500);
    });
}

// Social Login Buttons
const socialLoginBtns = document.querySelectorAll('.auth-social-btn');

socialLoginBtns.forEach(button => {
    button.addEventListener('click', function() {
        const platform = this.classList.contains('google') ? 'Google' : 'Facebook';
        
        console.log(`${platform} login clicked`);
        alert(`${platform} authentication would be initiated here...\n\nIn a production environment, this would redirect to ${platform}'s OAuth flow.`);
        
        // In a real application, this would redirect to OAuth provider
        // For Google: window.location.href = 'https://accounts.google.com/o/oauth2/v2/auth?...';
        // For Facebook: window.location.href = 'https://www.facebook.com/v12.0/dialog/oauth?...';
    });
});

// Real-time Form Validation
const authInputs = document.querySelectorAll('.auth-input');

authInputs.forEach(input => {
    // Validate on blur
    input.addEventListener('blur', function() {
        if (this.hasAttribute('required') && !this.value.trim()) {
            this.style.borderColor = '#f44336';
        } else if (this.type === 'email' && this.value && !isValidEmail(this.value)) {
            this.style.borderColor = '#f44336';
        } else if (this.type === 'tel' && this.value && !isValidPhone(this.value)) {
            this.style.borderColor = '#f44336';
        } else {
            this.style.borderColor = '';
        }
    });
    
    // Remove error on input
    input.addEventListener('input', function() {
        if (this.style.borderColor === 'rgb(244, 67, 54)') {
            this.style.borderColor = '';
        }
    });
});

// Validate confirm password matches
const confirmPasswordInput = document.getElementById('registerConfirmPassword');

if (confirmPasswordInput && registerPasswordInput) {
    confirmPasswordInput.addEventListener('blur', function() {
        if (this.value && this.value !== registerPasswordInput.value) {
            this.style.borderColor = '#f44336';
        }
    });
    
    confirmPasswordInput.addEventListener('input', function() {
        if (this.value === registerPasswordInput.value) {
            this.style.borderColor = '';
        }
    });
}

// Email validation helper
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Phone validation helper (basic validation for Indian numbers)
function isValidPhone(phone) {
    const phoneRegex = /^[\+]?[0-9]{10,15}$/;
    return phoneRegex.test(phone.replace(/[\s\-\(\)]/g, ''));
}

// Forgot Password Link
const forgotPasswordLink = document.querySelector('.forgot-password-link');

if (forgotPasswordLink) {
    forgotPasswordLink.addEventListener('click', function(e) {
        e.preventDefault();
        
        const email = prompt('Please enter your registered email address:');
        
        if (email && isValidEmail(email)) {
            alert(`Password reset link has been sent to ${email}\n\nPlease check your email inbox and spam folder.`);
            console.log('Password reset requested for:', email);
            
            // In a real application, this would call an API to send password reset email
        } else if (email) {
            alert('Please enter a valid email address');
        }
    });
}


// ===================================
// DASHBOARD FUNCTIONALITY
// ===================================

// Dashboard Tab Navigation
const dashboardNavItems = document.querySelectorAll('.dashboard-nav-item');
const dashboardTabs = document.querySelectorAll('.dashboard-tab');

dashboardNavItems.forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Check if logout button
        if (this.classList.contains('logout-btn')) {
            handleLogout();
            return;
        }
        
        const tabName = this.getAttribute('data-tab');
        
        if (tabName) {
            switchDashboardTab(tabName);
        }
    });
});

// View All Links navigation
const viewAllLinks = document.querySelectorAll('[data-navigate]');

viewAllLinks.forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const tabName = this.getAttribute('data-navigate');
        switchDashboardTab(tabName);
    });
});

function switchDashboardTab(tabName) {
    // Remove active from all nav items and tabs
    dashboardNavItems.forEach(item => item.classList.remove('active'));
    dashboardTabs.forEach(tab => tab.classList.remove('active'));
    
    // Add active to selected nav item
    const activeNavItem = document.querySelector(`.dashboard-nav-item[data-tab="${tabName}"]`);
    if (activeNavItem) {
        activeNavItem.classList.add('active');
    }
    
    // Show selected tab
    const activeTab = document.getElementById(tabName + 'Tab');
    if (activeTab) {
        activeTab.classList.add('active');
    }
    
    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Logout Handler
function handleLogout() {
    if (confirm('Are you sure you want to logout?')) {
        console.log('Logging out...');
        
        // Clear any stored user data
        // localStorage.removeItem('userToken');
        
        // Redirect to home page
        alert('You have been logged out successfully!');
        window.location.href = 'index.html';
    }
}

// Profile Form Submit
const profileForm = document.getElementById('profileForm');

if (profileForm) {
    profileForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            firstName: this.firstName.value,
            lastName: this.lastName.value,
            email: this.email.value,
            phone: this.phone.value,
            dateOfBirth: this.dateOfBirth.value,
            gender: this.gender.value,
            bio: this.bio.value
        };
        
        console.log('Profile data:', formData);
        
        // Show loading state
        const submitBtn = this.querySelector('.btn-primary');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        submitBtn.disabled = true;
        
        // Simulate save
        setTimeout(() => {
            submitBtn.innerHTML = '<i class="fas fa-check"></i> Saved!';
            submitBtn.style.background = '#4CAF50';
            
            alert('Profile updated successfully!');
            
            // Update user name in sidebar
            const userName = document.querySelector('.user-name');
            if (userName) {
                userName.textContent = `${formData.firstName} ${formData.lastName}`;
            }
            
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.style.background = '';
                submitBtn.disabled = false;
            }, 2000);
        }, 1500);
    });
}

// Change Password Form
const changePasswordForm = document.getElementById('changePasswordForm');

if (changePasswordForm) {
    changePasswordForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const currentPassword = this.currentPassword.value;
        const newPassword = this.newPassword.value;
        const confirmPassword = this.confirmPassword.value;
        
        // Validate
        if (newPassword !== confirmPassword) {
            alert('New passwords do not match!');
            return;
        }
        
        if (newPassword.length < 8) {
            alert('Password must be at least 8 characters long!');
            return;
        }
        
        console.log('Changing password...');
        
        const submitBtn = this.querySelector('.btn-primary');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
        submitBtn.disabled = true;
        
        // Simulate password change
        setTimeout(() => {
            submitBtn.innerHTML = '<i class="fas fa-check"></i> Updated!';
            submitBtn.style.background = '#4CAF50';
            
            alert('Password updated successfully!');
            
            this.reset();
            
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.style.background = '';
                submitBtn.disabled = false;
            }, 2000);
        }, 1500);
    });
}

// Wishlist Remove Button
const wishlistRemoveBtns = document.querySelectorAll('.wishlist-remove-btn');

wishlistRemoveBtns.forEach(button => {
    button.addEventListener('click', function() {
        const card = this.closest('.wishlist-card');
        
        if (confirm('Remove this item from your wishlist?')) {
            card.style.opacity = '0';
            card.style.transform = 'scale(0.8)';
            
            setTimeout(() => {
                card.remove();
                
                // Update wishlist badge
                const wishlistBadge = document.querySelector('.dashboard-nav-item[data-tab="wishlist"] .nav-badge');
                if (wishlistBadge) {
                    const currentCount = parseInt(wishlistBadge.textContent);
                    wishlistBadge.textContent = currentCount - 1;
                }
            }, 300);
        }
    });
});

// Clear All Wishlist
const clearWishlistBtn = document.querySelector('.clear-wishlist-btn');

if (clearWishlistBtn) {
    clearWishlistBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to clear your entire wishlist?')) {
            const wishlistCards = document.querySelectorAll('.wishlist-card');
            
            wishlistCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.8)';
                    
                    setTimeout(() => {
                        card.remove();
                    }, 300);
                }, index * 100);
            });
            
            // Update badge
            setTimeout(() => {
                const wishlistBadge = document.querySelector('.dashboard-nav-item[data-tab="wishlist"] .nav-badge');
                if (wishlistBadge) {
                    wishlistBadge.textContent = '0';
                }
                
                // Show empty state message
                const wishlistGrid = document.querySelector('.wishlist-grid');
                if (wishlistGrid) {
                    setTimeout(() => {
                        wishlistGrid.innerHTML = '<div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: var(--text-muted);"><i class="fas fa-heart" style="font-size: 3rem; margin-bottom: 20px; opacity: 0.3;"></i><h3>Your wishlist is empty</h3><p>Start adding products you love!</p></div>';
                    }, 1000);
                }
            }, 1500);
        }
    });
}

// Add New Address Button
const addAddressBtns = document.querySelectorAll('.add-address-btn, .add-new-btn');

addAddressBtns.forEach(button => {
    button.addEventListener('click', function() {
        alert('Add Address Form Modal would open here...\n\nIn a real application, this would show a form to add a new delivery address.');
        console.log('Add new address clicked');
    });
});

// Set Default Address
const setDefaultBtns = document.querySelectorAll('.address-footer .btn-link');

setDefaultBtns.forEach(button => {
    button.addEventListener('click', function() {
        // Remove default from all address cards
        document.querySelectorAll('.address-card').forEach(card => {
            card.classList.remove('default');
            const badge = card.querySelector('.default-badge');
            if (badge) badge.remove();
        });
        
        // Add default to this address
        const addressCard = this.closest('.address-card');
        addressCard.classList.add('default');
        
        // Add default badge
        const badge = document.createElement('span');
        badge.className = 'default-badge';
        badge.innerHTML = '<i class="fas fa-check-circle"></i> Default';
        addressCard.insertBefore(badge, addressCard.firstChild);
        
        // Hide "Set as Default" button
        this.style.display = 'none';
        
        alert('Default address updated!');
    });
});

// Edit/Delete Address Buttons
const addressEditBtns = document.querySelectorAll('.address-actions .btn-icon-small');

addressEditBtns.forEach(button => {
    button.addEventListener('click', function() {
        const icon = this.querySelector('i');
        
        if (icon.classList.contains('fa-edit')) {
            alert('Edit Address Form would open here...');
            console.log('Edit address clicked');
        } else if (icon.classList.contains('fa-trash')) {
            if (confirm('Are you sure you want to delete this address?')) {
                const addressCard = this.closest('.address-card');
                addressCard.style.opacity = '0';
                addressCard.style.transform = 'scale(0.8)';
                
                setTimeout(() => {
                    addressCard.remove();
                    alert('Address deleted successfully!');
                }, 300);
            }
        }
    });
});

// Order Actions (Track, View Details, etc.)
const orderActionBtns = document.querySelectorAll('.order-actions button');

orderActionBtns.forEach(button => {
    button.addEventListener('click', function() {
        const orderId = this.closest('.order-card').querySelector('.order-id').textContent;
        const buttonText = this.textContent.trim();
        
        if (buttonText === 'Track Order') {
            alert(`Track Order: ${orderId}\n\nTracking information would be displayed here...`);
            console.log('Track order:', orderId);
        } else if (buttonText === 'View Details') {
            alert(`Order Details: ${orderId}\n\nFull order details would be displayed here...`);
            console.log('View details:', orderId);
        } else if (buttonText === 'Cancel Order') {
            if (confirm(`Cancel order ${orderId}?`)) {
                alert('Order cancelled successfully!');
                // Update status badge
                const statusBadge = this.closest('.order-card').querySelector('.status-badge');
                if (statusBadge) {
                    statusBadge.classList.remove('processing');
                    statusBadge.classList.add('cancelled');
                    statusBadge.textContent = 'Cancelled';
                }
            }
        } else if (buttonText === 'Write Review') {
            alert('Write Review Modal would open here...');
            console.log('Write review for order:', orderId);
        } else if (buttonText === 'Buy Again') {
            alert('Products added to cart!');
            console.log('Buy again:', orderId);
        }
    });
});

// Logout Session Buttons
const logoutSessionBtns = document.querySelectorAll('.logout-session-btn');

logoutSessionBtns.forEach(button => {
    button.addEventListener('click', function() {
        const sessionInfo = this.closest('.session-item').querySelector('h4').textContent;
        
        if (confirm(`Logout from ${sessionInfo}?`)) {
            const sessionItem = this.closest('.session-item');
            sessionItem.style.opacity = '0';
            
            setTimeout(() => {
                sessionItem.remove();
                alert('Session logged out successfully!');
            }, 300);
        }
    });
});

// Toggle Switches (Notifications & 2FA)
const toggleSwitches = document.querySelectorAll('.toggle-switch input');

toggleSwitches.forEach(toggle => {
    toggle.addEventListener('change', function() {
        const optionInfo = this.closest('.notification-option, .security-option').querySelector('h4').textContent;
        const status = this.checked ? 'enabled' : 'disabled';
        
        console.log(`${optionInfo}: ${status}`);
        
        // Show feedback
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--bg-card);
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: var(--shadow-lg);
            z-index: 9999;
            animation: slideInRight 0.3s ease;
        `;
        notification.innerHTML = `<i class="fas fa-check" style="color: #4CAF50; margin-right: 10px;"></i> ${optionInfo} ${status}`;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 2000);
    });
});

// Avatar Edit Button
const avatarEditBtn = document.querySelector('.avatar-edit-btn');

if (avatarEditBtn) {
    avatarEditBtn.addEventListener('click', function() {
        alert('Profile Picture Upload would open here...\n\nIn a real application, this would open a file picker to upload a new profile picture.');
        console.log('Edit avatar clicked');
    });
}

// Search Orders
const searchInputDashboard = document.querySelector('.search-input-dashboard');

if (searchInputDashboard) {
    searchInputDashboard.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const orderCards = document.querySelectorAll('.order-card');
        
        orderCards.forEach(card => {
            const orderId = card.querySelector('.order-id').textContent.toLowerCase();
            const productNames = Array.from(card.querySelectorAll('.order-product-info h4'))
                .map(h4 => h4.textContent.toLowerCase())
                .join(' ');
            
            if (orderId.includes(searchTerm) || productNames.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
}

// Filter Orders
const filterSelect = document.querySelector('.filter-select-dashboard');

if (filterSelect) {
    filterSelect.addEventListener('change', function() {
        const filterValue = this.value;
        const orderCards = document.querySelectorAll('.order-card');
        
        orderCards.forEach(card => {
            const statusBadge = card.querySelector('.status-badge');
            
            if (filterValue === 'all') {
                card.style.display = 'block';
            } else {
                if (statusBadge && statusBadge.classList.contains(filterValue)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            }
        });
    });
}

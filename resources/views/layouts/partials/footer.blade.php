{{-- Footer - converted from ref HTML files --}}
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-brand">
                <div class="footer-logo">
                    <i class="fas fa-spray-can"></i>
                    <span>ScentScape</span>
                </div>
                <p class="footer-description">
                    Discover luxury fragrances from world-renowned brands. We curate the finest collection
                    of premium perfumes to help you find your signature scent.
                </p>
                <div class="footer-social">
                    <a href="#" class="social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link" aria-label="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                    <a href="#" class="social-link" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h3>Explore</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('products.index') }}">Products</a></li>
                    <li><a href="{{ route('blogs.index') }}">Blogs</a></li>
                    <li><a href="{{ route('contact.index') }}">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Latest Blogs</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('blogs.show', 'choose-perfect-fragrance') }}">Choose the Perfect Fragrance</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p class="footer-copyright">
                &copy; {{ date('Y') }} <a href="{{ route('home') }}">ScentScape</a>. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>

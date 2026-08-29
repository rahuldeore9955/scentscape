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
                <h3>Shop</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('products.index', ['category' => 'women']) }}">Women's Perfume</a></li>
                    <li><a href="{{ route('products.index', ['category' => 'men']) }}">Men's Cologne</a></li>
                    <li><a href="{{ route('products.index', ['category' => 'unisex']) }}">Unisex Fragrances</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Customer Service</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('contact.index') }}">Contact Us</a></li>
                    <li><a href="#">Shipping Info</a></li>
                    <li><a href="#">Returns & Refunds</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Get In Touch</h3>
                <ul class="contact-info">
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>123 Fragrance Street, Mumbai, India</span>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:info@scentscape.com">info@scentscape.com</a>
                    </li>
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

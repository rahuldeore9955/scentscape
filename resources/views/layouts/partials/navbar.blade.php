{{-- Navigation Header - converted from ref/index.html --}}
<header class="header {{ !request()->is('/') ? 'scrolled' : '' }}">
    <nav class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="logo">
                    <i class="fas fa-spray-can"></i>
                    <span>ScentScape</span>
                </a>

                {{-- Navigation Menu --}}
                <ul class="nav-menu">
                    <li><a href="{{ route('home') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="{{ request()->is('products*') ? 'active' : '' }}">Products</a></li>
                    <li><a href="{{ route('contact.index') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a></li>
                </ul>

                {{-- Right Side Icons --}}
                <div class="nav-icons">
                    @auth
                        <a href="{{ route('dashboard.index') }}" class="nav-dashboard-btn">
                            <i class="fas fa-user"></i>
                            <span>Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="nav-login-btn">
                            <i class="fas fa-user"></i>
                            <span>Login</span>
                        </a>
                    @endauth
                    <button class="icon-btn menu-toggle" aria-label="Menu">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>
</header>

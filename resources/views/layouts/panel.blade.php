<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'ScentScape panel')">
    <title>@yield('title', 'ScentScape Panel')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="panel-page">
    <div class="panel-shell">
        <aside class="panel-sidebar" id="panelSidebar">
            <a href="{{ route('home') }}" class="panel-logo">
                <i class="fas fa-spray-can"></i>
                <span>ScentScape</span>
            </a>

            <div class="panel-sidebar-label">{{ $panelType === 'admin' ? 'Administration' : 'My Account' }}</div>
            <nav class="panel-nav" aria-label="Panel navigation">
                @foreach($panelLinks as $link)
                    <a href="{{ $link['url'] }}" class="panel-nav-link {{ request()->url() === $link['url'] ? 'active' : '' }}">
                        <i class="{{ $link['icon'] }}"></i>
                        <span>{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <form method="POST" action="{{ route('logout') }}" class="panel-logout-form">
                @csrf
                <button type="submit" class="panel-nav-link panel-logout-link">
                    <i class="fas fa-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>
        </aside>

        <div class="panel-content">
            <header class="panel-topbar">
                <button type="button" class="panel-menu-toggle" id="panelMenuToggle" aria-label="Open navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="panel-topbar-title">@yield('page_heading')</div>
                <div class="panel-user-summary">
                    <span>{{ auth()->user()->name }}</span>
                    <i class="fas fa-user-circle"></i>
                </div>
            </header>

            <main class="panel-main">
                @if(session('success'))
                    <div class="alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert-error">{{ $errors->first() }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const panelToggle = document.getElementById('panelMenuToggle');
        const panelSidebar = document.getElementById('panelSidebar');
        if (panelToggle && panelSidebar) {
            panelToggle.addEventListener('click', () => panelSidebar.classList.toggle('open'));
        }
    </script>
    @stack('scripts')
</body>
</html>

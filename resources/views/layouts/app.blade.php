<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'جمعية السرطان السعودية')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.rtl.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" crossorigin="anonymous">

    <style>
        /* Font Face Declarations */
        @font-face {
            font-family: 'Almarai';
            src: url('{{ asset("fonts/Almarai/Almarai-Regular.ttf") }}') format('truetype');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Almarai';
            src: url('{{ asset("fonts/Almarai/Almarai-Bold.ttf") }}') format('truetype');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Almarai';
            src: url('{{ asset("fonts/Almarai/Almarai-Light.ttf") }}') format('truetype');
            font-weight: 300;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Almarai';
            src: url('{{ asset("fonts/Almarai/Almarai-ExtraBold.ttf") }}') format('truetype');
            font-weight: 800;
            font-style: normal;
            font-display: swap;
        }

        /* Color Variables */
        :root {
            --color-primary: #2a6571;
            --color-secondary: #dcdde6;
            --color-accent: #866eaf;
            --color-light: #6a99cb;
        }

        /* Full height flex layout */
        html, body {
            min-height: 100vh;
            font-family: "Almarai", "Arial", sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        /* Header Styling */
        header {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-accent) 70%, rgba(255, 255, 255, 0.3) 100%);
            flex-shrink: 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        header a {
            color: #fff !important;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        header a:hover {
            color: rgba(255, 255, 255, 0.8) !important;
            transform: translateY(-1px);
        }

        .logo {
            height: 70px;
            width: auto;
            object-fit: contain;
            transition: transform 0.2s ease;
            position: absolute;
            right: -20px;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .brand-title {
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Navigation Styling */
        .main-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }

        .nav-link {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
            text-decoration: none !important;
            color: white !important;
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .nav-link i {
            font-size: 0.9rem;
        }

        /* Mobile Menu */
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.25rem;
            transition: background-color 0.3s ease;
        }

        .mobile-menu-toggle:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Footer Styling */
        footer {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-accent) 100%);
            border-top: 3px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .footer-logo {
            height: 30px;
            width: auto;
            object-fit: contain;
        }

        footer p {
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .main-nav {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-accent) 100%);
                flex-direction: column;
                padding: 1rem;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
                z-index: 1000;
            }

            .main-nav.show {
                display: flex;
            }

            .mobile-menu-toggle {
                display: block;
            }

            .nav-link {
                width: 100%;
                justify-content: center;
                text-align: center;
                padding: 0.75rem 1rem;
            }
        }

        @media (max-width: 768px) {
            .logo {
                height: 50px;
            }

            .brand-title {
                font-size: 1.25rem;
            }

            header .container {
                flex-wrap: wrap;
            }

            .header-brand {
                width: 100%;
                justify-content: center;
                margin-bottom: 0.5rem;
            }

            .mobile-menu-toggle {
                position: absolute;
                top: 1rem;
                left: 1rem;
            }
        }

        @media (max-width: 576px) {
            .brand-title {
                font-size: 1.1rem;
            }

            .nav-link {
                font-size: 0.9rem;
                padding: 0.6rem 0.8rem;
            }
        }

        /* Loading animation for logo */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            animation: fadeIn 0.5s ease-out;
        }

        /* Header container positioning */
        .header-container {
            position: relative;
        }
    </style>
</head>
<body>

{{-- الترويسة --}}
<header class="text-white p-3">
    <div class="container header-container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center header-brand">
                <img src="{{ asset('storage/logo.png') }}"
                     alt="جمعية السرطان السعودية"
                     class="logo me-3"
                     loading="lazy">
            </div>
            <div class="d-flex align-items-center header-brand" style="padding-right: 20px">
                <h2 class="mb-0 brand-title">جمعية السرطان السعودية</h2>
            </div>

            {{-- Mobile Menu Toggle --}}
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                <i class="bi bi-list"></i>
            </button>

            {{-- Navigation Menu --}}
            <nav class="main-nav" id="mainNav">
                <a href="{{ route('home') }}" class="nav-link {{ Request::routeIs('home') ? 'active' : '' }}">
                    <i class="bi bi-house-fill"></i>
                    الرئيسية
                </a>
                <a href="{{ route('support.show') }}" class="nav-link {{ Request::routeIs('support.*') ? 'active' : '' }}">
                    <i class="bi bi-headset"></i>
                    الدعم الفني
                </a>
                <a href="{{ route('future.create') }}" class="nav-link {{ Request::routeIs('future.create') ? 'active' : '' }}">
                    <i class="bi bi-send-fill"></i>
                    رسالة المستقبل
                </a>
                <a href="{{ route('hope.create') }}" class="nav-link {{ Request::routeIs('hope.create') ? 'active' : '' }}">
                    <i class="bi bi-heart-fill"></i>
                    بصمة أمل
                </a>
                <a href="{{ route('hope.show') }}" class="nav-link {{ Request::routeIs('hope.show') ? 'active' : '' }}">
                    <i class="bi bi-stars"></i>
                    قصص الأمل
                </a>
                <a href="{{ route('gift.index') }}" class="nav-link {{ Request::routeIs('gift.*') ? 'active' : '' }}">
                    <i class="bi bi-gift-fill"></i>
                    جدار الهدايا
                </a>
            </nav>
        </div>
    </div>
</header>

{{-- المحتوى --}}
<main class="container mt-4">
    @yield('content')
</main>

{{-- الفوتر --}}
<footer class="text-center text-white py-3 mt-auto">
    <div class="container">
        <div class="d-flex justify-content-center align-items-center mb-2">
            <img src="{{ asset('storage/logo.png') }}"
                 alt="جمعية السرطان السعودية"
                 class="footer-logo me-2"
                 loading="lazy">
        </div>
        <p class="mb-1">
            &copy; {{ date('Y') }} جميع الحقوق محفوظة - جمعية السرطان السعودية
        </p>
        <p class="mb-0">
            Saudi Cancer Foundation
        </p>
    </div>
</footer>

{{-- JavaScript --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>
    function toggleMobileMenu() {
        const nav = document.getElementById('mainNav');
        const toggleBtn = document.querySelector('.mobile-menu-toggle i');

        if (nav.classList.contains('show')) {
            nav.classList.remove('show');
            toggleBtn.className = 'bi bi-list';
        } else {
            nav.classList.add('show');
            toggleBtn.className = 'bi bi-x-lg';
        }
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const nav = document.getElementById('mainNav');
        const toggleBtn = document.querySelector('.mobile-menu-toggle');

        if (!nav.contains(event.target) && !toggleBtn.contains(event.target)) {
            nav.classList.remove('show');
            document.querySelector('.mobile-menu-toggle i').className = 'bi bi-list';
        }
    });

    // Close mobile menu when window is resized to desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth > 992) {
            const nav = document.getElementById('mainNav');
            nav.classList.remove('show');
            document.querySelector('.mobile-menu-toggle i').className = 'bi bi-list';
        }
    });
</script>
</body>
</html>

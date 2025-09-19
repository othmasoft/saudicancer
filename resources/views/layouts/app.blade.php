<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    @include('layouts.head')
</head>
<body>

{{-- الترويسة --}}
<header class="text-white p-3">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img src="{{ asset('storage/logo.png') }}"
                 alt="جمعية السرطان السعودية"
                 class="logo me-3"
                 loading="lazy">
            <h2 class="mb-0 brand-title">جمعية السرطان السعودية</h2>
        </div>
        <nav>
            <a href="{{ route('home') }}">{{ __('app.home') }}</a>
            <a href="{{ route('support.show') }}">{{ __('app.support') }}</a>
            <a href="{{ route('future.create') }}">{{ __('app.future') }}</a>
            <a href="{{ route('future.show') }}">{{ __('app.future') }}</a>
        </nav>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>

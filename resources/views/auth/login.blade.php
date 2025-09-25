@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">

            {{-- Page Header --}}
            <div class="text-center mb-4">
                <div class="mb-3">
                    <i class="bi bi-person-circle display-1 text-primary"></i>
                </div>
                <h1 class="h3 text-primary mb-3">تسجيل الدخول</h1>
                <p class="text-muted">
                    مرحباً بعودتك إلى جمعية السرطان السعودية
                </p>
            </div>

            {{-- Login Form --}}
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">
                        <i class="bi bi-shield-lock-fill me-2"></i>
                        دخول آمن
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email Field --}}
                        <div class="mb-3">
                            <label for="email" class="form-label required">
                                <i class="bi bi-envelope-fill text-primary me-2"></i>
                                البريد الإلكتروني
                            </label>
                            <input type="email"
                                   class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="أدخل بريدك الإلكتروني"
                                   required
                                   autocomplete="email"
                                   autofocus>
                            @error('email')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        {{-- Password Field --}}
                        <div class="mb-3">
                            <label for="password" class="form-label required">
                                <i class="bi bi-lock-fill text-primary me-2"></i>
                                كلمة المرور
                            </label>
                            <div class="input-group">
                                <input type="password"
                                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password"
                                       placeholder="أدخل كلمة المرور"
                                       required
                                       autocomplete="current-password">
                                <button type="button"
                                        class="btn btn-outline-secondary"
                                        id="togglePassword">
                                    <i class="bi bi-eye" id="passwordIcon"></i>
                                </button>
                                @error('password')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Remember Me --}}
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="remember"
                                       id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    <i class="bi bi-bookmark-check me-1"></i>
                                    تذكرني
                                </label>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                تسجيل الدخول
                            </button>
                        </div>

                        {{-- Forgot Password Link --}}
                        <div class="text-center">
                            <small>
                                <a href="#" class="text-decoration-none">
                                    <i class="bi bi-question-circle me-1"></i>
                                    نسيت كلمة المرور؟
                                </a>
                            </small>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-light text-center">
                    <small class="text-muted">
                        ليس لديك حساب؟
                        <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">
                            إنشاء حساب جديد
                        </a>
                    </small>
                </div>
            </div>

            {{-- Security Notice --}}
            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="bi bi-shield-check text-success me-1"></i>
                    تسجيل الدخول آمن ومشفر بالكامل
                </small>
            </div>

        </div>
    </div>

    {{-- Custom CSS --}}
    <style>
        :root {
            --color-primary: #2a6571;
            --color-secondary: #dcdde6;
            --color-accent: #866eaf;
            --color-light: #6a99cb;
        }

        .text-primary { color: var(--color-primary) !important; }
        .bg-primary { background-color: var(--color-primary) !important; }

        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #1e4a52;
            border-color: #1e4a52;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(42, 101, 113, 0.3);
        }

        .required::after {
            content: " *";
            color: #dc3545;
        }

        .form-control:focus {
            border-color: var(--color-accent);
            box-shadow: 0 0 0 0.25rem rgba(134, 110, 175, 0.25);
        }

        .form-control-lg {
            border-width: 2px;
            transition: all 0.3s ease;
        }

        .card {
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .display-1 {
            font-size: 4rem;
            text-shadow: 0 4px 8px rgba(42, 101, 113, 0.2);
        }

        .invalid-feedback {
            font-weight: 500;
        }

        .btn-outline-secondary:hover {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
            color: var(--color-primary);
        }

        .form-check-input:checked {
            background-color: var(--color-accent);
            border-color: var(--color-accent);
        }

        .bg-light {
            background-color: var(--color-secondary) !important;
        }
    </style>

    {{-- JavaScript for Password Toggle --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');

            togglePassword.addEventListener('click', function() {
                // Toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);

                // Toggle the icon
                if (type === 'password') {
                    passwordIcon.className = 'bi bi-eye';
                } else {
                    passwordIcon.className = 'bi bi-eye-slash';
                }
            });

            // Form validation feedback
            const form = document.querySelector('form');
            form.addEventListener('submit', function() {
                const submitBtn = document.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>جاري تسجيل الدخول...';
                submitBtn.disabled = true;
            });
        });
    </script>

@endsection

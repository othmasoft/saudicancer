@extends('layouts.app')

@section('title', 'الخدمات والدعم')

@section('content')

    <div class="row justify-content-center mt-3">
        <div class="col-md-10">



            <div class="row g-4">

                {{-- Support Services Section --}}
                <div class="col-12">
                    <h4 class="text-primary mb-3 border-bottom border-primary pb-2">
                        <i class="bi bi-headset me-2"></i>
                       رسائل الدعم
                    </h4>
                </div>

                {{-- إضافة رسالة دعم --}}
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        <div class="card-body text-center p-3">
                            <div class="icon-circle bg-success mb-3">
                                <i class="bi bi-plus-circle-fill text-white"></i>
                            </div>
                            <h5 class="card-title text-success mb-3">إنشاء رسالة دعم</h5>
                            <p class="card-text text-muted mb-4">
                                تواصل معنا إذا كانت لديك مشكلة أو استفسار
                            </p>
                            <a href="{{ route('support.create') }}" class="btn btn-success btn-lg w-100">
                                <i class="bi bi-envelope-plus me-2"></i>
                                إنشاء رسالة جديدة
                            </a>
                        </div>
                    </div>
                </div>

                {{-- عرض رسائل الدعم --}}
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        <div class="card-body text-center p-3">
                            <div class="icon-circle bg-info mb-3">
                                <i class="bi bi-chat-dots-fill text-white"></i>
                            </div>
                            <h5 class="card-title text-info mb-3">متابعة الرسائل</h5>
                            <p class="card-text text-muted mb-4">
                                تابع حالة رسائلك واطلع على الردود
                            </p>
                            <a href="{{ route('support.show') }}" class="btn btn-info btn-lg w-100">
                                <i class="bi bi-list-check me-2"></i>
                                عرض رسائلي
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Future Messages Section --}}
                <div class="col-12 mt-5">
                    <h4 class="text-primary mb-3 border-bottom border-primary pb-2">
                        <i class="bi bi-clock-history me-2"></i>
                        ضع بصمتك
                    </h4>
                </div>


                {{-- بصمة أمل - إنشاء --}}
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        <div class="card-body text-center p-3">
                            <div class="icon-circle bg-primary mb-3">
                                <i class="bi bi-hand-thumbs-up-fill text-white"></i>
                            </div>
                            <h5 class="card-title text-primary mb-3">ضع بصمة أمل</h5>
                            <p class="card-text text-muted mb-4">
                                ضع بصمتك والهم الاخرين
                            </p>
                            <a href="{{ route('hope.create') }}" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-heart-fill me-2"></i>
                                شارك قصتك
                            </a>
                        </div>
                    </div>
                </div>


                {{-- بصمات الأمل --}}
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        <div class="card-body text-center p-3">
                            <div class="icon-circle bg-accent mb-3">
                                <i class="bi bi-stars text-white"></i>
                            </div>
                            <h5 class="card-title text-accent mb-3">بصمات الأمل</h5>
                            <p class="card-text text-muted mb-4">
عرض البصمات
                            </p>
                            <a href="{{ route('hope.show') }}" class="btn btn-accent btn-lg w-100">
                                <i class="bi bi-book-half me-2"></i>
                                اقرأ القصص
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Community Section --}}
                <div class="col-12 mt-5">
                    <h4 class="text-primary mb-3 border-bottom border-primary pb-2">
                        <i class="bi bi-people-fill me-2"></i>
                        المجتمع والتفاعل
                    </h4>
                </div>

                {{-- رسالة للمستقبل --}}
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        <div class="card-body text-center p-3">
                            <div class="icon-circle bg-warning mb-3">
                                <i class="bi bi-send-fill text-white"></i>
                            </div>
                            <h5 class="card-title text-warning mb-3">رسالة للمستقبل</h5>
                            <p class="card-text text-muted mb-4">
                                اكتب رسالة لنفسك في المستقبل لتحفيزك وإلهامك
                            </p>
                            <a href="{{ route('future.create') }}" class="btn btn-warning btn-lg w-100">
                                <i class="bi bi-calendar-plus me-2"></i>
                                اكتب رسالتك
                            </a>
                        </div>
                    </div>
                </div>

                {{-- جدار الهدايا --}}
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        <div class="card-body text-center p-3">
                            <div class="icon-circle bg-light mb-3">
                                <i class="bi bi-gift-fill text-white"></i>
                            </div>
                            <h5 class="card-title text-light mb-3">جدار الهدايا التفاعلي</h5>
                            <p class="card-text text-muted mb-4">
                                شارك وتلقى الهدايا المعنوية والتشجيع
                            </p>
                            <a href="{{ route('gift.index') }}" class="btn btn-light btn-lg w-100">
                                <i class="bi bi-box2-heart me-2"></i>
                                استكشف الهدايا
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Help Information --}}
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card border-0 bg-light-custom">
                        <div class="card-body text-center py-4">
                            <h5 class="card-title text-primary mb-4">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                كيف يمكننا مساعدتك؟
                            </h5>

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="help-item">
                                        <i class="bi bi-telephone-fill text-success mb-2"></i>
                                        <h6>اتصل بنا</h6>
                                        <small class="text-muted">920000000</small>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="help-item">
                                        <i class="bi bi-envelope-fill text-info mb-2"></i>
                                        <h6>راسلنا</h6>
                                        <small class="text-muted">support@saudicancer.org</small>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="help-item">
                                        <i class="bi bi-clock-fill text-warning mb-2"></i>
                                        <h6>ساعات العمل</h6>
                                        <small class="text-muted">24/7 دعم متواصل</small>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="help-item">
                                        <i class="bi bi-shield-check text-primary mb-2"></i>
                                        <h6>خصوصية آمنة</h6>
                                        <small class="text-muted">بياناتك محمية</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Custom CSS with Enhanced Styling --}}
    <style>
        :root {
            --color-primary: #2a6571;
            --color-secondary: #dcdde6;
            --color-accent: #866eaf;
            --color-light: #6a99cb;
            --color-success: #28a745;
            --color-info: #17a2b8;
            --color-warning: #ffc107;
        }

        /* Color Classes */
        .text-primary { color: var(--color-primary) !important; }
        .bg-primary { background-color: var(--color-primary) !important; }
        .btn-primary { background-color: var(--color-primary); border-color: var(--color-primary); }
        .btn-primary:hover { background-color: #1e4a52; border-color: #1e4a52; }
        .border-primary { border-color: var(--color-primary) !important; }

        .text-accent { color: var(--color-accent) !important; }
        .bg-accent { background-color: var(--color-accent) !important; }
        .btn-accent { background-color: var(--color-accent); border-color: var(--color-accent); color: white; }
        .btn-accent:hover { background-color: #7059a3; border-color: #7059a3; color: white; }

        .text-light { color: var(--color-light) !important; }
        .bg-light { background-color: var(--color-light) !important; }
        .btn-light { background-color: var(--color-light); border-color: var(--color-light); color: white; }
        .btn-light:hover { background-color: #5a8bb8; border-color: #5a8bb8; color: white; }

        .bg-light-custom { background-color: var(--color-secondary) !important; }

        /* Icon Circles */
        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            transition: all 0.3s ease;
        }

        .icon-circle i {
            font-size: 2.5rem;
        }

        /* Card Hover Effects */
        .hover-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .hover-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(42, 101, 113, 0.15) !important;
        }

        .hover-card:hover .icon-circle {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        /* Button Styling */
        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        /* Help Items */
        .help-item {
            text-align: center;
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .help-item:hover {
            transform: translateY(-3px);
        }

        .help-item i {
            font-size: 2rem;
            display: block;
        }

        .help-item h6 {
            font-weight: 600;
            margin-bottom: 0.1rem;
            color: var(--color-primary);
        }

        .card-body {
            padding: 1rem !important; /* بدل 1.5rem أو 2rem */
        }

        .card-title {
            margin-bottom: 0.1rem !important;
        }

        .card-text {
            margin-bottom: 0.5rem !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .icon-circle {
                width: 60px;
                height: 60px;
            }

            .icon-circle i {
                font-size: 2rem;
            }

            .btn-lg {
                font-size: 1rem;
                padding: 0.6rem 1.2rem;
            }
        }

        /* Section Borders */
        .border-bottom {
            border-width: 2px !important;
        }

        /* Custom animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>

@endsection

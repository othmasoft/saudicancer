@extends('layouts.app')

@section('title', 'الدعم الفني - جمعية السرطان السعودية')

@section('content')

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-10">

            {{-- Page Header --}}
            <div class="text-center mb-4">
                <h1 class="display-6 text-primary mb-3">
                    <i class="bi bi-headset"></i>
                    الدعم الفني
                </h1>
                <p class="lead text-muted">
                    نحن هنا لمساعدتك. اختر الخدمة التي تحتاجها
                </p>
            </div>

            {{-- Support Options Cards --}}
            <div class="row g-4">

                {{-- Create Support Message Card --}}
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0 hover-shadow">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-plus-circle-fill text-success" style="font-size: 3rem;"></i>
                            </div>
                            <h4 class="card-title text-success mb-3">إنشاء رسالة دعم جديدة</h4>
                            <p class="card-text text-muted mb-4">
                                هل تواجه مشكلة أو لديك استفسار؟ أرسل لنا رسالة وسنقوم بالرد عليك في أقرب وقت ممكن
                            </p>
                            <a href="{{ route('support.create') }}" class="btn btn-success btn-lg">
                                <i class="bi bi-plus-circle me-2"></i>
                                إنشاء رسالة دعم
                            </a>
                        </div>
                    </div>
                </div>

                {{-- View Messages Card --}}
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0 hover-shadow">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="bi bi-chat-dots-fill text-info" style="font-size: 3rem;"></i>
                            </div>
                            <h4 class="card-title text-info mb-3">عرض رسائل الدعم</h4>
                            <p class="card-text text-muted mb-4">
                                تابع حالة رسائل الدعم الخاصة بك واطلع على الردود من فريق الدعم
                            </p>
                            <a href="{{ route('support.show') }}" class="btn btn-info btn-lg">
                                <i class="bi bi-chat-dots me-2"></i>
                                عرض الرسائل
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Additional Information Section --}}
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4">
                                <i class="bi bi-info-circle text-primary me-2"></i>
                                معلومات مهمة
                            </h5>

                            <div class="row">
                                <div class="col-md-4 text-center mb-3">
                                    <i class="bi bi-clock text-warning" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2">وقت الاستجابة</h6>
                                    <p class="text-muted small">نسعى للرد خلال 24 ساعة</p>
                                </div>

                                <div class="col-md-4 text-center mb-3">
                                    <i class="bi bi-shield-check text-success" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2">الأمان والخصوصية</h6>
                                    <p class="text-muted small">جميع المعلومات محمية وآمنة</p>
                                </div>

                                <div class="col-md-4 text-center mb-3">
                                    <i class="bi bi-people text-info" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2">فريق متخصص</h6>
                                    <p class="text-muted small">فريق دعم مدرب ومتخصص</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact Information --}}
            <div class="row mt-4">
                <div class="col-12">
                    <div class="text-center">
                        <h6 class="text-muted">للاستفسارات العاجلة</h6>
                        <p class="mb-0">
                            <i class="bi bi-telephone-fill text-primary me-2"></i>
                            <strong>920000000</strong>
                            <span class="mx-3">|</span>
                            <i class="bi bi-envelope-fill text-primary me-2"></i>
                            <strong>support@saudicancer.org</strong>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Custom CSS for hover effects --}}
    <style>
        .hover-shadow {
            transition: all 0.3s ease;
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
        }

        .card-body i {
            transition: transform 0.3s ease;
        }

        .card:hover .card-body i {
            transform: scale(1.1);
        }
    </style>

@endsection

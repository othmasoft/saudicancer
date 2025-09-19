@extends('layouts.app')

@section('title', 'عرض رسائل الدعم')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-10">

            {{-- Page Header --}}
            <div class="text-center mb-4">
                <h1 class="display-6 text-primary mb-3">
                    <i class="bi bi-chat-dots"></i>
                    رسائل الدعم
                </h1>
                @auth
                    <p class="lead text-muted">
                        رسائل الدعم الخاصة بك
                    </p>
                @else
                    <p class="lead text-muted">
                        ابحث عن رسائلك باستخدام البريد الإلكتروني
                    </p>
                @endauth
            </div>

            {{-- Search Form for Guests --}}
            @guest
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0">
                            <i class="bi bi-search me-2"></i>
                            البحث عن رسائل الدعم
                        </h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('support.search') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-8 mb-2 mb-md-0">
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email"
                                           value="{{ old('email') }}"
                                           placeholder="أدخل البريد الإلكتروني المستخدم في إرسال الرسالة"
                                           required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-info w-100">
                                        <i class="bi bi-search me-2"></i>
                                        بحث
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endguest

            {{-- Support Messages List --}}
            @if($supports->count() > 0)
                <div class="row">
                    @foreach($supports as $support)
                        <div class="col-12 mb-4">
                            <div class="card shadow-sm border-start border-4 border-{{ $support->priority == 'urgent' ? 'danger' : ($support->priority == 'high' ? 'warning' : ($support->priority == 'medium' ? 'info' : 'success')) }}">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mb-0 me-3">{{ $support->subject }}</h6>
                                        <span class="{{ $support->status_label['class'] }}">
                                            {{ $support->status_label['text'] }}
                                        </span>
                                        <span class="{{ $support->priority_label['class'] }} ms-2">
                                            {{ $support->priority_label['text'] }}
                                        </span>
                                    </div>
                                    <small class="text-muted">
                                        {{ $support->created_at->diffForHumans() }}
                                    </small>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p class="card-text text-muted mb-2">
                                                <strong>من:</strong> {{ $support->name }}
                                                @if($support->phone)
                                                    | <strong>الهاتف:</strong> {{ $support->phone }}
                                                @endif
                                            </p>
                                            <p class="card-text">
                                                {{ Str::limit($support->message, 150) }}
                                            </p>

                                            {{-- Admin Response --}}
                                            @if($support->admin_response)
                                                <div class="alert alert-info mt-3">
                                                    <h6 class="alert-heading">
                                                        <i class="bi bi-reply-fill me-2"></i>
                                                        رد فريق الدعم:
                                                    </h6>
                                                    <p class="mb-0">{{ $support->admin_response }}</p>
                                                    <small class="text-muted">
                                                        {{ $support->responded_at ? $support->responded_at->diffForHumans() : '' }}
                                                    </small>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-md-4 text-end">
                                            <div class="d-flex flex-column gap-2">
                                                <a href="{{ route('support.view', $support->id) }}"
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-eye me-1"></i>
                                                    عرض التفاصيل
                                                </a>

                                                @if($support->status == 'open')
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-clock me-1"></i>
                                                        في انتظار الرد
                                                    </span>
                                                @elseif($support->status == 'responded')
                                                    <span class="badge bg-info">
                                                        <i class="bi bi-check-circle me-1"></i>
                                                        تم الرد
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer text-muted d-flex justify-content-between">
                                    <small>
                                        <i class="bi bi-envelope me-1"></i>
                                        رقم الرسالة: #{{ $support->id }}
                                    </small>
                                    <small>
                                        <i class="bi bi-calendar me-1"></i>
                                        {{ $support->created_at->format('Y/m/d H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {{ $supports->links() }}
                </div>

            @else
                {{-- No Messages Found --}}
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-inbox" style="font-size: 4rem; color: #dee2e6;"></i>
                    </div>
                    <h4 class="text-muted mb-3">لا توجد رسائل دعم</h4>
                    @guest
                        <p class="text-muted mb-4">
                            لم يتم العثور على أي رسائل باستخدام البريد الإلكتروني المدخل
                        </p>
                    @else
                        <p class="text-muted mb-4">
                            لم تقم بإرسال أي رسائل دعم حتى الآن
                        </p>
                    @endauth

                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('support.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle me-2"></i>
                            إرسال رسالة دعم جديدة
                        </a>
                        <a href="{{ route('support.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-right me-2"></i>
                            العودة للرئيسية
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- Custom CSS --}}
    <style>
        .border-start {
            border-left-width: 4px !important;
        }

        .card-header h6 {
            font-weight: 600;
        }

        .badge {
            font-size: 0.75em;
        }

        .alert-info {
            background-color: #f8f9ff;
            border-color: #b8daff;
            color: #004085;
        }

        .btn-outline-primary:hover {
            background-color: #866eaf;
            border-color: #866eaf;
        }
    </style>

@endsection

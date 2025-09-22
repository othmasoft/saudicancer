@extends('layouts.app')

@section('title', 'رسائلي للمستقبل')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-10">

            {{-- Page Header --}}
            <div class="text-center mb-4">
                <h1 class="display-6 text-primary mb-3">
                    <i class="bi bi-clock-history"></i>
                    رسائلي للمستقبل
                </h1>
                @auth
                    <p class="lead text-muted">
                        جميع رسائلك المجدولة والمرسلة
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
                            البحث عن رسائلك
                        </h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('future.search') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-8 mb-2 mb-md-0">
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email"
                                           value="{{ old('email') }}"
                                           placeholder="أدخل البريد الإلكتروني المستخدم في إنشاء الرسائل"
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

            {{-- Action Buttons --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <a href="{{ route('future.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-2"></i>
                        رسالة جديدة
                    </a>
                    <a href="{{ route('future.show') }}" class="btn btn-outline-primary">
                        <i class="bi bi-globe2 me-2"></i>
                        الرسائل العامة
                    </a>
                </div>

                @auth
                    <div class="text-muted">
                        <small>
                            <i class="bi bi-envelope-fill me-1"></i>
                            {{ $messages->total() ?? 0 }} رسالة
                        </small>
                    </div>
                @endauth
            </div>

            {{-- Messages List --}}
            @if($messages->count() > 0)
                <div class="row">
                    @foreach($messages as $message)
                        <div class="col-12 mb-4">
                            <div class="card shadow-sm border-start border-4
                                {{ $message->type == 'motivational' ? 'border-success' :
                                   ($message->type == 'personal' ? 'border-primary' :
                                   ($message->type == 'reminder' ? 'border-warning' : 'border-info')) }}">

                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mb-0 me-3">{{ $message->title }}</h6>
                                        <span class="{{ $message->status_label['class'] }}">
                                            {{ $message->status_label['text'] }}
                                        </span>
                                        <span class="{{ $message->type_label['class'] }} ms-2">
                                            {{ $message->type_label['text'] }}
                                        </span>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted">
                                            @if($message->status == 'scheduled')
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $message->time_remaining }}
                                            @else
                                                <i class="bi bi-check-circle me-1"></i>
                                                {{ $message->created_at->diffForHumans() }}
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p class="card-text text-muted mb-2">
                                                <strong>إلى:</strong> {{ $message->recipient_name }}
                                                @if($message->send_email)
                                                    | <i class="bi bi-envelope-fill text-info"></i>
                                                @endif
                                                @if($message->is_public)
                                                    | <i class="bi bi-globe2 text-success"></i> عامة
                                                @endif
                                            </p>

                                            <p class="card-text">
                                                {{ $message->excerpt }}
                                            </p>

                                            @if($message->description)
                                                <p class="card-text">
                                                    <small class="text-muted">{{ $message->description }}</small>
                                                </p>
                                            @endif
                                        </div>

                                        <div class="col-md-4 text-end">
                                            <div class="d-flex flex-column gap-2">
                                                <a href="{{ route('future.view', $message->id) }}"
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-eye me-1"></i>
                                                    عرض
                                                </a>

                                                @if($message->can_edit && auth()->id() == $message->created_by)
                                                    <a href="{{ route('future.edit', $message->id) }}"
                                                       class="btn btn-outline-warning btn-sm">
                                                        <i class="bi bi-pencil me-1"></i>
                                                        تعديل
                                                    </a>
                                                @endif

                                                @if($message->status == 'scheduled')
                                                    <span class="badge bg-primary">
                                                        <i class="bi bi-calendar me-1"></i>
                                                        {{ $message->scheduled_at->format('Y/m/d') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer text-muted d-flex justify-content-between">
                                    <small>
                                        <i class="bi bi-calendar-event me-1"></i>
                                        @if($message->status == 'scheduled')
                                            سيتم الإرسال في {{ $message->formatted_scheduled_date }}
                                        @else
                                            تم الإنشاء في {{ $message->created_at->format('Y/m/d H:i') }}
                                        @endif
                                    </small>
                                    <small>
                                        <i class="bi bi-stopwatch me-1"></i>
                                        {{ $message->reading_time }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {{ $messages->links() }}
                </div>

            @else
                {{-- No Messages Found --}}
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-inbox" style="font-size: 4rem; color: #dee2e6;"></i>
                    </div>
                    <h4 class="text-muted mb-3">لا توجد رسائل</h4>
                    @guest
                        <p class="text-muted mb-4">
                            لم يتم العثور على أي رسائل باستخدام البريد الإلكتروني المدخل
                        </p>
                    @else
                        <p class="text-muted mb-4">
                            لم تقم بإنشاء أي رسائل للمستقبل حتى الآن
                        </p>
                    @endauth

                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('future.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle me-2"></i>
                            اكتب رسالتك الأولى
                        </a>
                        <a href="{{ route('future.show') }}" class="btn btn-outline-primary">
                            <i class="bi bi-globe2 me-2"></i>
                            تصفح الرسائل العامة
                        </a>
                    </div>
                </div>
            @endif

            {{-- Statistics Card --}}
            @auth
                @if($messages->count() > 0)
                    <div class="card mt-4 border-0 bg-light-custom">
                        <div class="card-body text-center">
                            <h6 class="text-primary mb-3">إحصائياتك</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="statistic-item">
                                        <i class="bi bi-envelope-fill text-primary"></i>
                                        <h6>{{ $messages->where('status', 'scheduled')->count() }}</h6>
                                        <small class="text-muted">مجدولة

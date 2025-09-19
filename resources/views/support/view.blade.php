@extends('layouts.app')

@section('title', 'تفاصيل رسالة الدعم #' . $support->id)

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Back Button --}}
            <div class="mb-3">
                <a href="{{ route('support.show') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-right me-2"></i>
                    العودة لقائمة الرسائل
                </a>
            </div>

            {{-- Support Message Details Card --}}
            <div class="card shadow border-0">
                {{-- Card Header --}}
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-envelope-open-fill me-2"></i>
                            رسالة الدعم #{{ $support->id }}
                        </h5>
                        <div>
                            <span class="{{ $support->status_label['class'] }} me-2">
                                {{ $support->status_label['text'] }}
                            </span>
                            <span class="{{ $support->priority_label['class'] }}">
                                {{ $support->priority_label['text'] }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="card-body p-4">

                    {{-- Message Subject --}}
                    <div class="mb-4">
                        <h4 class="text-primary mb-0">{{ $support->subject }}</h4>
                        <small class="text-muted">
                            <i class="bi bi-calendar-fill me-1"></i>
                            تم الإرسال في {{ $support->created_at->format('Y/m/d') }} الساعة {{ $support->created_at->format('H:i') }}
                            ({{ $support->created_at->diffForHumans() }})
                        </small>
                    </div>

                    {{-- Sender Information --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="border rounded p-3 bg-light">
                                <h6 class="text-muted mb-3">
                                    <i class="bi bi-person-fill me-2"></i>
                                    معلومات المرسل
                                </h6>
                                <p class="mb-2">
                                    <strong>الاسم:</strong> {{ $support->name }}
                                </p>
                                <p class="mb-2">
                                    <strong>البريد الإلكتروني:</strong>
                                    <a href="mailto:{{ $support->email }}">{{ $support->email }}</a>
                                </p>
                                @if($support->phone)
                                    <p class="mb-0">
                                        <strong>رقم الهاتف:</strong>
                                        <a href="tel:{{ $support->phone }}">{{ $support->phone }}</a>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mt-3 mt-md-0">
                            <div class="border rounded p-3 bg-light">
                                <h6 class="text-muted mb-3">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    معلومات الرسالة
                                </h6>
                                <p class="mb-2">
                                    <strong>الأولوية:</strong>
                                    <span class="{{ $support->priority_label['class'] }}">
                                        {{ $support->priority_label['text'] }}
                                    </span>
                                </p>
                                <p class="

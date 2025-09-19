@extends('layouts.app2')

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
                                <p class="mb-2">
                                    <strong>الحالة:</strong>
                                    <span class="{{ $support->status_label['class'] }}">
                                        {{ $support->status_label['text'] }}
                                    </span>
                                </p>
                                <p class="mb-0">
                                    <strong>تاريخ الإنشاء:</strong>
                                    {{ $support->created_at->format('Y/m/d H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Message Content --}}
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">
                            <i class="bi bi-chat-square-text-fill me-2"></i>
                            محتوى الرسالة
                        </h6>
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <p class="mb-0" style="white-space: pre-wrap; line-height: 1.6;">{{ $support->message }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Admin Response --}}
                    @if($support->admin_response)
                        <div class="mb-4">
                            <h6 class="text-success mb-3">
                                <i class="bi bi-reply-all-fill me-2"></i>
                                رد فريق الدعم
                            </h6>
                            <div class="alert alert-success border-0">
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-person-check-fill text-success me-3 mt-1"></i>
                                    <div>
                                        <p class="mb-2" style="white-space: pre-wrap; line-height: 1.6;">{{ $support->admin_response }}</p>
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            تم الرد في {{ $support->responded_at ? $support->responded_at->format('Y/m/d H:i') : 'غير محدد' }}
                                            @if($support->respondedBy)
                                                بواسطة {{ $support->respondedBy->name }}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- No Response Yet --}}
                        <div class="mb-4">
                            <div class="alert alert-info border-0">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-hourglass-split text-info me-3"></i>
                                    <div>
                                        <h6 class="alert-heading mb-1">في انتظار الرد</h6>
                                        <p class="mb-0">سيقوم فريق الدعم بالرد على رسالتك في أقرب وقت ممكن.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-center gap-3 pt-3 border-top">
                        <a href="{{ route('support.show') }}" class="btn btn-outline-primary">
                            <i class="bi bi-list me-2"></i>
                            عرض جميع الرسائل
                        </a>

                        @if($support->status !== 'closed' && $support->status !== 'resolved')
                            <a href="{{ route('support.create') }}" class="btn btn-success">
                                <i class="bi bi-plus-circle me-2"></i>
                                إرسال رسالة جديدة
                            </a>
                        @endif

                        <button onclick="window.print()" class="btn btn-outline-secondary">
                            <i class="bi bi-printer me-2"></i>
                            طباعة
                        </button>
                    </div>

                </div>
            </div>

            {{-- Timeline Card (if there are updates) --}}
            @if($support->updated_at != $support->created_at || $support->admin_response)
                <div class="card mt-4 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 text-muted">
                            <i class="bi bi-clock-history me-2"></i>
                            تاريخ المراسلة
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            {{-- Message Created --}}
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">تم إرسال الرسالة</h6>
                                    <p class="timeline-time text-muted">{{ $support->created_at->format('Y/m/d H:i') }}</p>
                                </div>
                            </div>

                            {{-- Admin Response --}}
                            @if($support->responded_at)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-success"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">تم الرد من فريق الدعم</h6>
                                        <p class="timeline-time text-muted">{{ $support->responded_at->format('Y/m/d H:i') }}</p>
                                    </div>
                                </div>
                            @endif

                            {{-- Last Update --}}
                            @if($support->updated_at != $support->created_at)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-info"></div>
                                    <div class="timeline-content">
                                        <h6 class="timeline-title">آخر تحديث</h6>
                                        <p class="timeline-time text-muted">{{ $support->updated_at->format('Y/m/d H:i') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- Custom CSS with your color palette --}}
    <style>
        :root {
            --color-primary: #2a6571;
            --color-secondary: #dcdde6;
            --color-accent: #866eaf;
            --color-light: #6a99cb;
        }

        .text-primary { color: var(--color-primary) !important; }
        .bg-primary { background-color: var(--color-primary) !important; }
        .bg-light { background-color: var(--color-secondary) !important; }

        .btn-success {
            background-color: var(--color-accent);
            border-color: var(--color-accent);
        }

        .btn-success:hover {
            background-color: #7059a3;
            border-color: #7059a3;
        }

        .btn-outline-primary {
            color: var(--color-primary);
            border-color: var(--color-primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: white;
        }

        .btn-outline-secondary {
            color: var(--color-primary);
            border-color: var(--color-secondary);
        }

        .btn-outline-secondary:hover {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
            color: var(--color-primary);
        }

        .alert-success {
            background-color: rgba(134, 110, 175, 0.1);
            border-color: var(--color-accent);
            color: var(--color-primary);
        }

        .alert-info {
            background-color: rgba(106, 153, 203, 0.1);
            border-color: var(--color-light);
            color: var(--color-primary);
        }

        .text-success {
            color: var(--color-accent) !important;
        }

        .text-info {
            color: var(--color-light) !important;
        }

        /* Timeline Styles */
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: var(--color-secondary);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        .timeline-marker {
            position: absolute;
            left: -23px;
            top: 5px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .timeline-content {
            padding-left: 15px;
        }

        .timeline-title {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 2px;
            color: var(--color-primary);
        }

        .timeline-time {
            font-size: 0.8rem;
            margin-bottom: 0;
        }

        /* Print Styles */
        @media print {
            .btn, .border-top {
                display: none !important;
            }

            .card {
                border: 1px solid #ddd !important;
                box-shadow: none !important;
            }
        }
    </style>

@endsection

@extends('layouts.app4')

@section('title', 'اكتب رسالة للمستقبل')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="flash-message">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="flash-message">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <script>
                setTimeout(() => {
                    let alertBox = document.getElementById('flash-message');
                    if (alertBox) {
                        // Bootstrap 5 dismiss
                        let bsAlert = new bootstrap.Alert(alertBox);
                        bsAlert.close();
                    }
                }, 2000);
            </script>


            {{-- General Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h6 class="alert-heading">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        يرجى تصحيح الأخطاء التالية:
                    </h6>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Page Header --}}
            <div class="text-center mb-5">
                <div class="mb-4">
                    <i class="bi bi-send-fill display-1  "></i>
                </div>
                <h1 class="display-5   mb-3">اكتب رسالة للمستقبل</h1>
                <p class="lead text-muted">
                    اكتب رسالة لنفسك أو لأحبائك ليستلموها في المستقبل<br>
                </p>
            </div>

            {{-- Form Card --}}
            <div class="card shadow border-0">

                <div class="card-body p-4">
                    <form action="{{ route('future.store') }}" method="POST" id="futureMessageForm">
                        @csrf

                        {{-- Email Field --}}
                        <div class="mb-4">
                            <label for="email" class="form-label required fw-bold">
                                <i class="bi bi-envelope-fill text-primary1 me-2"></i>
                                البريد الإلكتروني
                                <span class="text-danger">*</span>
                            </label>
                            <input type="email"
                                   class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', auth()->user()->email ?? '') }}"
                                   required>
                            @error('email')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle text-info me-1"></i>
                                سيتم إرسال الرسالة إلى هذا البريد الإلكتروني في المستقبل
                            </div>
                        </div>

                        {{-- Message Field --}}
                        <div class="mb-4">
                            <label for="message" class="form-label required fw-bold">
                                <i class="bi bi-chat-square-heart-fill text-primary1 me-2"></i>
                                رسالتك للمستقبل
                                <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('message') is-invalid @enderror"
                                      id="message"
                                      name="message"
                                      rows="8"
                                      placeholder="اكتب رسالتك هنا... شارك أحلامك، أهدافك، أو كلمات تشجيعية لنفسك أو لأحبائك.

مثال:
عزيزي أنا المستقبل،
أتمنى أن تكون قد حققت أهدافك التي وضعتها اليوم...
أتمنى أن تكون أقوى وأسعد...

مع كل الحب، أنا من الماضي ❤️"
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-lightbulb text-warning me-1"></i>
                                نصيحة: اكتب بصدق واجعل الرسالة مليئة بالأمل والإيجابية
                            </div>
                        </div>

                        {{-- Hidden Fields with Default Values --}}
                        <input type="hidden" name="title" value="رسالة من الماضي">
                        <input type="hidden" name="recipient_name" value="صديقي العزيز">
                        <input type="hidden" name="message_type" value="personal">
                        <input type="hidden" name="scheduled_date" value="{{ date('Y-m-d', strtotime('+1 year')) }}">
                        <input type="hidden" name="scheduled_time" value="09:00">
                        <input type="hidden" name="send_email" value="1">
                        <input type="hidden" name="is_public" value="0">

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-center gap-3 pt-4 border-top">

                            <button type="submit" class="btn btn-success1 btn-lg px-5">
                                <i class="bi bi-send-fill me-2"></i>
                                إرسال الرسالة للمستقبل
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Info Cards --}}
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card border-0 bg-light-custom h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-calendar-heart text-primary1 mb-2" style="font-size: 2rem;"></i>
                            <h6 class="text-primary1">متى ستصل؟</h6>
                            <small class="text-muted">
                                ستصل رسالتك بعد سنة كاملة من اليوم
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3 mt-md-0">
                    <div class="card border-0 bg-light-custom h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-shield-check text-success mb-2" style="font-size: 2rem;"></i>
                            <h6 class="text-primary1">أمان تام</h6>
                            <small class="text-muted">
                                رسالتك محفوظة بأمان ولن يراها أحد غيرك
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3 mt-md-0">
                    <div class="card border-0 bg-light-custom h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-heart-fill text-danger mb-2" style="font-size: 2rem;"></i>
                            <h6 class="text-primary1">رسالة أمل</h6>
                            <small class="text-muted">
                                مفاجأة جميلة ستذكرك بأحلامك وآمالك
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Examples Card --}}
        </div>
    </div>



    {{-- JavaScript for Preview --}}
    <script>
        function previewMessage() {
            const title = document.getElementById('title').value;
            const content = document.getElementById('content').value;
            const recipientName = document.getElementById('recipient_name').value;

            if (!title || !content) {
                alert('يرجى ملء العنوان والرسالة أولاً');
                return;
            }

            // يمكن فتح نافذة معاينة أو إظهار modal
            const previewWindow = window.open('', '_blank', 'width=600,height=400');
            previewWindow.document.write(`
                <html dir="rtl">
                <head>
                    <title>معاينة الرسالة</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 20px; line-height: 1.6; }
                        .header { border-bottom: 2px solid #2a6571; padding-bottom: 10px; margin-bottom: 20px; }
                        .content { white-space: pre-wrap; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h2>${title}</h2>
                        <p>إلى: ${recipientName || 'صديقي العزيز'}</p>
                    </div>
                    <div class="content">${content}</div>
                </body>
                </html>
            `);
        }

        // Set minimum date to tomorrow
        document.addEventListener('DOMContentLoaded', function() {
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            const minDate = tomorrow.toISOString().split('T')[0];
            document.getElementById('scheduled_date').setAttribute('min', minDate);
        });
    </script>

@endsection

@extends('layouts.app2')

@section('title', 'عرض رسائل الدعم')

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">

            <div class="text-center mb-4">
                <div class="text-center mb-4">
                    <img id="support-image"
                         src="{{ asset('storage/support3.png') }}"
                         alt="جمعية السرطان السعودية"
                         class="img-fluid"
                         style="max-height:500px;"
                         loading="lazy">
                </div>
            </div>

            <div id="last-message">
                @if($support)
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <strong>{{ $support->subject ?? '' }}</strong>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">{{ $support->message }}</p>
                            <small class="text-muted">
                                {{ $support->name ?? '' }}
                            </small>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        لا توجد رسائل
                    </div>
                @endif
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* حركة بسيطة */
        .flash {
            animation: flash-bg 1s ease-in-out 3;
        }
        @keyframes flash-bg {
            0%, 100% { background-color: #fff; }
            50% { background-color: #2a6571; }
        }
    </style>
    <script>
        let lastMessageId = @json($support?->id);

        function fetchLastMessage() {
            $.ajax({
                url: "{{ route('support.show') }}",
                type: "GET",
                dataType: "json",
                success: function (data) {
                    if (data.message) {
                        if (data.message.id !== lastMessageId) {
                            lastMessageId = data.message.id;

                            // تحديث الرسالة
                            $('#last-message').html(`
                        <div class="card shadow-sm flash">
                            <div class="card-header bg-primary text-white">
                                <strong>${data.message.subject ?? ''}</strong>
                            </div>
                            <div class="card-body">
                                <p class="mb-2">${data.message.message}</p>
                                <small class="text-muted">
                                    ${data.message.name ?? ''}
                                </small>
                            </div>
                        </div>
                    `);

                            // شغل حركة الصورة مع الرسالة الجديدة
                            let img = document.getElementById('support-image');
                            img.classList.add('pulse');
                            setTimeout(() => {
                                img.classList.remove('pulse');
                            }, 1000); // نفس مدة الأنيميشن
                        }
                    } else {
                        $('#last-message').html(`
                    <div class="alert alert-info text-center">
                        لا توجد رسائل
                    </div>
                `);
                    }
                }
            });
        }

        // تحديث كل ثانية
        setInterval(fetchLastMessage, 1000);

    </script>
    <style>
        /* حركة تكبير/تصغير (Pulse) */
        .pulse {
            animation: pulse 1s ease-in-out;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

    </style>
@endsection

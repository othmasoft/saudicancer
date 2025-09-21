@extends('layouts.app2')

@section('title', 'إنشاء رسالة دعم جديدة')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Page Header --}}
            <div class="text-center mb-4">
                <h1 class="display-6     mb-3">
                    <i class="bi bi-plus-circle"></i>
                    أكـتـب رسـالة دعـم
                </h1>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show auto-hide" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show auto-hide" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger auto-hide">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li><i class="bi bi-x-circle me-1"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {{-- Support Form Card --}}
            <div class="card shadow border-0">

                <div class="card-body p-4">
                    <form action="{{ route('support.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <!--
                            {{-- Name Field --}}
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label ">
                                    <i class="bi bi-person-fill text-primary me-1"></i>
                                    الاسم الكامل
                                </label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', auth()->user()->name ?? '') }}">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email Field --}}
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label ">
                                    <i class="bi bi-envelope-fill text-primary me-1"></i>
                                    البريد الإلكتروني
                                </label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', auth()->user()->email ?? '') }}">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
-->
                        {{-- Message Field --}}
                        <div class="mb-4">
                            <label for="message" class="form-label required">
                                <i class="bi bi-file-text-fill text-primary me-1"></i>
                                نص الرسالة
                            </label>
                            <textarea class="form-control @error('message') is-invalid @enderror"
                                      id="message"
                                      name="message"
                                      rows="3"
                                      placeholder="أكتب رسالة دعم هنا ..."
                                      required>{{ old('message') }}</textarea>
                            <div class="form-text">الحد الأدنى 10 أحرف</div>
                            @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="d-grid gap-2 d-md-flex justify-content-center">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-send-fill me-2"></i>
                                إرسال الرسالة
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            setTimeout(() => {
                document.querySelectorAll('.auto-hide').forEach(el => {
                    el.classList.remove('show'); // Bootstrap fade out
                    setTimeout(() => el.remove(), 500); // يمسحه بعد ما يختفي
                });
            }, 1000); // 1 ثانية
        });
    </script>


    {{-- Custom CSS --}}
    <style>
        .required::after {
            content: " *";
            color: #dc3545;
        }

        .form-control:focus, .form-select:focus {
            border-color: #866eaf;
            box-shadow: 0 0 0 0.25rem rgba(134, 110, 175, 0.25);
        }

        .btn-success {
            background-color: #866eaf;
            border-color: #866eaf;
        }

        .btn-success:hover {
            background-color: #7059a3;
            border-color: #7059a3;
        }
    </style>
@endsection

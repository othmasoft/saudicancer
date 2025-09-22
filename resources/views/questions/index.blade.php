@extends('layouts.app')

@section('title', 'بنك الأسئلة')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-10">

            {{-- Page Header --}}
            <div class="text-center mb-5">
                <div class="mb-4">
                    <i class="bi bi-patch-question-fill display-1 text-primary"></i>
                </div>
                <h1 class="display-5 text-primary mb-3">بنك الأسئلة</h1>
                <p class="lead text-muted">
                    اختبر معلوماتك الصحية من خلال مجموعة متنوعة من الأسئلة<br>
                    <small class="text-primary">تعلم واكتشف معلومات جديدة حول الصحة والوقاية</small>
                </p>
            </div>

            {{-- Filter and Action Bar --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('questions.index') }}" class="row align-items-end">
                        <div class="col-md-3 mb-2">
                            <label class="form-label">التصنيف</label>
                            <select name="category" class="form-select">
                                <option value="">جميع التصنيفات</option>
                                <option value="health" {{ request('category') == 'health' ? 'selected' : '' }}>صحة عامة</option>
                                <option value="cancer" {{ request('category') == 'cancer' ? 'selected' : '' }}>السرطان</option>
                                <option value="prevention" {{ request('category') == 'prevention' ? 'selected' : '' }}>الوقاية</option>
                                <option value="treatment" {{ request('category') == 'treatment' ? 'selected' : '' }}>العلاج</option>
                                <option value="general" {{ request('category') == 'general' ? 'selected' : '' }}>عام</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-2">
                            <label class="form-label">المستوى</label>
                            <select name="difficulty" class="form-select">
                                <option value="">جميع المستويات</option>
                                <option value="easy" {{ request('difficulty') == 'easy' ? 'selected' : '' }}>سهل</option>
                                <option value="medium" {{ request('difficulty') == 'medium' ? 'selected' : '' }}>متوسط</option>
                                <option value="hard" {{ request('difficulty') == 'hard' ? 'selected' : '' }}>صعب</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-funnel me-2"></i>
                                تصفية
                            </button>
                            <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-2"></i>
                                إعادة تعيين
                            </a>
                        </div>

                        <div class="col-md-3 mb-2 text-end">
                            <a href="{{ route('questions.random') }}" class="btn btn-success">
                                <i class="bi bi-shuffle me-2"></i>
                                سؤال عشوائي
                            </a>
                            <a href="{{ route('questions.quiz') }}" class="btn btn-info">
                                <i class="bi bi-trophy me-2"></i>
                                اختبار سريع
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Questions Grid --}}
            @if($questions->count() > 0)
                <div class="row">
                    @foreach($questions as $index => $question)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 shadow-sm border-0 question-card">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <span class="badge bg-{{ $question->difficulty_color }}">
                                        {{ $question->difficulty_label }}
                                    </span>
                                    <small class="text-muted">
                                        {{ $question->category_label }}
                                    </small>
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <div class="mb-3 flex-grow-1">
                                        <div class="text-center mb-3">
                                            <i class="bi bi-patch-question text-primary" style="font-size: 2rem;"></i>
                                        </div>
                                        <h6 class="card-title">{{ \Str::limit($question->question, 120) }}</h6>
                                    </div>

                                    <div class="text-center mt-auto">
                                        <a href="{{ route('questions.show', $question->id) }}"
                                           class="btn btn-primary btn-sm w-100">
                                            <i class="bi bi-play-circle me-2"></i>
                                            ابدأ الإجابة
                                        </a>
                                    </div>
                                </div>

                                <div class="card-footer bg-transparent text-center">
                                    <small class="text-muted">
                                        <i class="bi bi-hash me-1"></i>
                                        سؤال {{ $questions->firstItem() + $index }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $questions->withQueryString()->links() }}
                </div>

            @else
                {{-- No Questions Found --}}
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-question-diamond" style="font-size: 4rem; color: #dee2e6;"></i>
                    </div>
                    <h4 class="text-muted mb-3">لا توجد أسئلة</h4>
                    <p class="text-muted mb-4">
                        لم يتم العثور على أسئلة تطابق المعايير المحددة
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('questions.index') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-clockwise me-2"></i>
                            عرض جميع الأسئلة
                        </a>
                        <a href="{{ route('questions.random') }}" class="btn btn-success">
                            <i class="bi bi-shuffle me-2"></i>
                            سؤال عشوائي
                        </a>
                    </div>
                </div>
            @endif

            {{-- Statistics Cards --}}
            <div class="row mt-5">
                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-light-custom text-center">
                        <div class="card-body py-3">
                            <i class="bi bi-collection text-primary mb-2" style="font-size: 2rem;"></i>
                            <h5 class="text-primary mb-1">{{ $questions->total() }}</h5>
                            <small class="text-muted">إجمالي الأسئلة</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-light-custom text-center">
                        <div class="card-body py-3">
                            <i class="bi bi-speedometer text-success mb-2" style="font-size: 2rem;"></i>
                            <h5 class="text-success mb-1">سريع</h5>
                            <small class="text-muted">وقت الإجابة</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-light-custom text-center">
                        <div class="card-body py-3">
                            <i class="bi bi-award text-warning mb-2" style="font-size: 2rem;"></i>
                            <h5 class="text-warning mb-1">تعليمي</h5>
                            <small class="text-muted">محتوى مفيد</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card border-0 bg-light-custom text-center">
                        <div class="card-body py-3">
                            <i class="bi bi-shield-check text-info mb-2" style="font-size: 2rem;"></i>
                            <h5 class="text-info mb-1">موثوق</h5>
                            <small class="text-muted">معلومات دقيقة</small>
                        </div>
                    </div>
                </div>
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
        .bg-light-custom { background-color: var(--color-secondary) !important; }

        .question-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .question-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(42, 101, 113, 0.15) !important;
        }

        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }

        .btn-primary:hover {
            background-color: #1e4a52;
            border-color: #1e4a52;
        }

        .btn-success {
            background-color: var(--color-accent);
            border-color: var(--color-accent);
        }

        .btn-success:hover {
            background-color: #7059a3;
            border-color: #7059a3;
        }

        .btn-info {
            background-color: var(--color-light);
            border-color: var(--color-light);
        }

        .btn-info:hover {
            background-color: #5a8bb8;
            border-color: #5a8bb8;
        }

        .display-1 {
            font-size: 4rem;
            text-shadow: 0 4px 8px rgba(42, 101, 113, 0.2);
        }

        .card-title {
            font-size: 0.95rem;
            line-height: 1.4;
            color: var(--color-primary);
            font-weight: 600;
        }

        .badge {
            font-size: 0.75rem;
        }

        /* Animation for cards */
        .question-card {
            animation: fadeInUp 0.6s ease-out;
        }

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

        /* Stagger animation for multiple cards */
        .question-card:nth-child(1) { animation-delay: 0.1s; }
        .question-card:nth-child(2) { animation-delay: 0.2s; }
        .question-card:nth-child(3) { animation-delay: 0.3s; }
        .question-card:nth-child(4) { animation-delay: 0.4s; }
        .question-card:nth-child(5) { animation-delay: 0.5s; }
        .question-card:nth-child(6) { animation-delay: 0.6s; }
    </style>

@endsection

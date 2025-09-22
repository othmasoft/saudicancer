@extends('layouts.app')

@section('title', 'اختبار سريع')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-9">

            {{-- Quiz Header --}}
            <div class="text-center mb-4">
                <div class="mb-3">
                    <i class="bi bi-trophy-fill display-1 text-primary"></i>
                </div>
                <h1 class="display-6 text-primary mb-3">اختبار سريع</h1>
                <p class="lead text-muted">
                    اختبر معلوماتك في {{ $questions->count() }} أسئلة متنوعة
                </p>
            </div>

            {{-- Quiz Progress --}}
            <div class="card mb-4 border-0 bg-light-custom">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">التقدم</small>
                            <div class="fw-bold" id="progressText">السؤال 1 من {{ $questions->count() }}</div>
                        </div>
                        <div class="text-end">
                            <small class="text-muted">الوقت المتبقي</small>
                            <div class="fw-bold text-warning" id="timer">--:--</div>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height: 8px;">
                        <div class="progress-bar bg-primary" id="progressBar" style="width: 0%"></div>
                    </div>
                </div>
            </div>

            {{-- Quiz Form --}}
            <form id="quizForm" action="{{ route('questions.quiz.submit') }}" method="POST">
                @csrf

                @foreach($questions as $index => $question)
                    <div class="card shadow-sm mb-4 question-slide"
                         data-question="{{ $index + 1 }}"
                         style="{{ $index === 0 ? '' : 'display: none;' }}">

                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">
                                    <i class="bi bi-patch-question-fill me-2"></i>
                                    السؤال {{ $index + 1 }}
                                </h6>
                            </div>
                            <div>
                                <span class="badge bg-{{ $question->difficulty_color }}">
                                    {{ $question->difficulty_label }}
                                </span>
                                <span class="badge bg-light text-dark ms-1">
                                    {{ $question->category_label }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="mb-3">
                                    <i class="bi bi-question-circle-fill text-primary" style="font-size: 3rem;"></i>
                                </div>
                                <h4 class="text-primary mb-4">{{ $question->question }}</h4>
                            </div>

                            {{-- Answer Options --}}
                            <div class="d-flex justify-content-center gap-4">
                                <div class="form-check form-check-lg">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="answers[{{ $question->id }}]"
                                           value="1"
                                           id="yes_{{ $question->id }}"
                                           required>
                                    <label class="form-check-label btn btn-outline-success btn-lg px-4"
                                           for="yes_{{ $question->id }}">
                                        <i class="bi bi-check-circle me-2"></i>
                                        نعم
                                    </label>
                                </div>

                                <div class="form-check form-check-lg">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="answers[{{ $question->id }}]"
                                           value="0"
                                           id="no_{{ $question->id }}"
                                           required>
                                    <label class="form-check-label btn btn-outline-danger btn-lg px-4"
                                           for="no_{{ $question->id }}">
                                        <i class="bi bi-x-circle me-2"></i>
                                        لا
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-transparent d-flex justify-content-between">
                            <button type="button"
                                    class="btn btn-outline-secondary prev-btn"
                                    {{ $index === 0 ? 'style=visibility:hidden;' : '' }}
                                    onclick="previousQuestion()">
                                <i class="bi bi-arrow-right me-2"></i>
                                السابق
                            </button>

                            @if($index === $questions->count() - 1)
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    إنهاء الاختبار
                                </button>
                            @else
                                <button type="button" class="btn btn-primary next-btn" onclick="nextQuestion()">
                                    التالي
                                    <i class="bi bi-arrow-left ms-2"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </form>

            {{-- Navigation Info --}}
            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    يمكنك الرجوع للأسئلة السابقة وتعديل إجاباتك قبل إنهاء الاختبار
                </small>
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

        .form-check-input {
            display: none;
        }

        .form-check-label {
            cursor: pointer;
            transition: all 0.3s ease;
            border-width: 2px !important;
            min-width: 120px;
        }

        .form-check-input:checked + .form-check-label {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .form-check-input:checked + .btn-outline-success {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }

        .form-check-input:checked + .btn-outline-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .question-slide {
            transition: all 0.5s ease;
        }

        .question-slide.fade-in {
            animation: slideInRight 0.5s ease-out;
        }

        .question-slide.fade-out {
            animation: slideOutLeft 0.5s ease-out;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideOutLeft {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(-50px);
            }
        }

        .progress-bar {
            background-color: var(--color-primary) !important;
            transition: width 0.3s ease;
        }

        .display-1 {
            text-shadow: 0 4px 8px rgba(42, 101, 113, 0.2);
        }

        .btn-success {
            background-color: var(--color-accent);
            border-color: var(--color-accent);
        }

        .btn-success:hover {
            background-color: #7059a3;
            border-color: #7059a3;
        }
    </style>

    {{-- JavaScript --}}
    <script>
        let currentQuestion = 1;
        const totalQuestions = {{ $questions->count() }};
        let quizStartTime = Date.now();
        let timerInterval;

        // Initialize quiz
        document.addEventListener('DOMContentLoaded', function() {
            startTimer();
            updateProgress();
        });

        function nextQuestion() {
            if (currentQuestion < totalQuestions) {
                // Check if current question is answered
                const currentSlide = document.querySelector(`.question-slide[data-question="${currentQuestion}"]`);
                const selectedAnswer = currentSlide.querySelector('input[type="radio"]:checked');

                if (!selectedAnswer) {
                    alert('يرجى اختيار إجابة قبل الانتقال للسؤال التالي');
                    return;
                }

                // Hide current question
                currentSlide.style.display = 'none';

                // Show next question
                currentQuestion++;
                const nextSlide = document.querySelector(`.question-slide[data-question="${currentQuestion}"]`);
                nextSlide.style.display = 'block';
                nextSlide.classList.add('fade-in');

                updateProgress();

                // Remove animation class
                setTimeout(() => {
                    nextSlide.classList.remove('fade-in');
                }, 500);
            }
        }

        function previousQuestion() {
            if (currentQuestion > 1) {
                // Hide current question
                const currentSlide = document.querySelector(`.question-slide[data-question="${currentQuestion}"]`);
                currentSlide.style.display = 'none';

                // Show previous question
                currentQuestion--;
                const prevSlide = document.querySelector(`.question-slide[data-question="${currentQuestion}"]`);
                prevSlide.style.display = 'block';
                prevSlide.classList.add('fade-in');

                updateProgress();

                // Remove animation class
                setTimeout(() => {
                    prevSlide.classList.remove('fade-in');
                }, 500);
            }
        }

        function updateProgress() {
            const progressPercent = (currentQuestion / totalQuestions) * 100;
            document.getElementById('progressBar').style.width = progressPercent + '%';
            document.getElementById('progressText').textContent = `السؤال ${currentQuestion} من ${totalQuestions}`;
        }

        function startTimer() {
            timerInterval = setInterval(() => {
                const elapsed = Math.floor((Date.now() - quizStartTime) / 1000);
                const minutes = Math.floor(elapsed / 60);
                const seconds = elapsed % 60;
                document.getElementById('timer').textContent =
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }, 1000);
        }

        // Form submission
        document.getElementById('quizForm').addEventListener('submit', function(e) {
            // Stop timer
            clearInterval(timerInterval);

            // Check if all questions are answered
            const totalAnswered = document.querySelectorAll('input[type="radio"]:checked').length;

            if (totalAnswered < totalQuestions) {
                e.preventDefault();
                if (confirm(`لقد أجبت على ${totalAnswered} من ${totalQuestions} أسئلة فقط. هل تريد المتابعة؟`)) {
                    this.submit();
                }
            } else {
                // Show loading state
                const submitBtn = document.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>جاري التقييم...';
                submitBtn.disabled = true;
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                nextQuestion();
            } else if (e.key === 'ArrowRight') {
                previousQuestion();
            } else if (e.key === 'y' || e.key === 'Y' || e.key === 'ن') {
                const currentSlide = document.querySelector(`.question-slide[data-question="${currentQuestion}"]`);
                const yesRadio = currentSlide.querySelector('input[value="1"]');
                yesRadio.checked = true;
            } else if (e.key === 'n' || e.key === 'N' || e.key === 'ل') {
                const currentSlide = document.querySelector(`.question-slide[data-question="${currentQuestion}"]`);
                const noRadio = currentSlide.querySelector('input[value="0"]');
                noRadio.checked = true;
            }
        });

        // Add keyboard shortcut info
        document.addEventListener('DOMContentLoaded', function() {
            const info = document.createElement('div');
            info.className = 'text-center mt-2';
            info.innerHTML = '<small class="text-muted"><i class="bi bi-keyboard me-1"></i>اختصارات: ن=نعم، ل=لا، →=التالي، ←=السابق</small>';
            document.querySelector('.col-md-9').appendChild(info);
        });
    </script>

@endsection

@extends('layouts.app4')

@section('title', 'سؤال وجواب')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Question Card --}}
            <div class="card shadow border-0" id="questionCard">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">
                        <i class="bi bi-question-circle-fill me-2"></i>
                        سؤال وجواب - {{ $question->category_label }}
                    </h5>
                </div>

                <div class="card-body p-5">
                    {{-- Question --}}
                    <div class="text-center mb-4">
                        <div class="mb-4">
                            <i class="bi bi-patch-question-fill display-1 text-primary"></i>
                        </div>
                        <h3 class="text-primary mb-4">{{ $question->question }}</h3>

                        {{-- Difficulty Badge --}}
                        <span class="badge bg-{{ $question->difficulty_color }} mb-4">
                            مستوى {{ $question->difficulty_label }}
                        </span>
                    </div>

                    {{-- Answer Buttons --}}
                    <div class="d-flex justify-content-center gap-4 mb-4" id="answerButtons">
                        <button type="button"
                                class="btn btn-success btn-lg px-5 answer-btn"
                                data-answer="1"
                                onclick="submitAnswer(1)">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            نعم
                        </button>

                        <button type="button"
                                class="btn btn-danger btn-lg px-5 answer-btn"
                                data-answer="0"
                                onclick="submitAnswer(0)">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            لا
                        </button>
                    </div>

                    {{-- Result Area (Hidden initially) --}}
                    <div id="resultArea" class="text-center" style="display: none;">
                        <div id="resultMessage" class="alert mb-4"></div>

                        <div id="explanationArea" class="card bg-light border-0 mb-4" style="display: none;">
                            <div class="card-body">
                                <h6 class="text-primary mb-3">
                                    <i class="bi bi-lightbulb-fill me-2"></i>
                                    شرح الإجابة:
                                </h6>
                                <p id="explanationText" class="mb-0"></p>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-center gap-3">
                            <button type="button" class="btn btn-outline-primary" onclick="getRandomQuestion()">
                                <i class="bi bi-arrow-clockwise me-2"></i>
                                سؤال آخر
                            </button>
                        </div>
                    </div>

                    {{-- Loading Spinner --}}
                    <div id="loadingSpinner" class="text-center" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">جاري التحقق...</span>
                        </div>
                        <p class="mt-2 text-muted">جاري التحقق من إجابتك...</p>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <div class="text-center mt-4 d-none">
                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    <a href="{{ route('questions.random') }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-shuffle me-1"></i>
                        سؤال عشوائي
                    </a>
                    <a href="{{ route('questions.quiz') }}" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-collection-play me-1"></i>
                        اختبار متعدد
                    </a>
                    <a href="{{ route('questions.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-grid me-1"></i>
                        تصفح الأسئلة
                    </a>
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

        .answer-btn {
            min-width: 150px;
            transition: all 0.3s ease;
            font-weight: 600;
            border-radius: 50px;
        }

        .answer-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        .answer-btn:disabled {
            opacity: 0.6;
            transform: none;
            cursor: not-allowed;
        }

        .display-1 {
            font-size: 4rem;
            text-shadow: 0 4px 8px rgba(42, 101, 113, 0.2);
        }

        .card {
            transition: transform 0.2s ease;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-color: #b8daff;
            color: #155724;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f1aeb5 100%);
            border-color: #f5c6cb;
            color: #721c24;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .bg-light {
            background-color: var(--color-secondary) !important;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        .fade-in {
            animation: fadeInUp 0.5s ease-out;
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

        .shake {
            animation: shake 0.6s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .bounce {
            animation: bounce 0.6s ease-in-out;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>

    {{-- JavaScript --}}
    <script>
        const questionId = {{ $question->id }};
        let isAnswered = false;

        function submitAnswer(answer) {
            if (isAnswered) return;

            // Disable buttons and show loading
            disableAnswerButtons();
            showLoading();

            // Send AJAX request
            fetch(`/questions/${questionId}/check`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ answer: answer })
            })
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    showResult(data);
                    isAnswered = true;
                })
                .catch(error => {
                    hideLoading();
                    showError('حدث خطأ في التحقق من الإجابة');
                    enableAnswerButtons();
                });
        }

        function showResult(data) {
            const resultArea = document.getElementById('resultArea');
            const resultMessage = document.getElementById('resultMessage');
            const explanationArea = document.getElementById('explanationArea');
            const explanationText = document.getElementById('explanationText');

            // Show result message
            if (data.is_correct) {
                resultMessage.className = 'alert alert-success mb-4';
                resultMessage.innerHTML = `
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>إجابة صحيحة! 🎉</strong>
                    <br><small>أحسنت، لقد أجبت بشكل صحيح</small>
                `;
                document.getElementById('questionCard').classList.add('bounce');
            } else {
                resultMessage.className = 'alert alert-danger mb-4';
                resultMessage.innerHTML = `
                    <i class="bi bi-x-circle-fill me-2"></i>
                    <strong>إجابة خاطئة 😔</strong>
                    <br><small>الإجابة الصحيحة هي: <strong>${data.correct_answer_text}</strong></small>
                `;
                document.getElementById('questionCard').classList.add('shake');
            }

            // Show explanation if available
            if (data.explanation) {
                explanationText.textContent = data.explanation;
                explanationArea.style.display = 'block';
            }

            // Show result area with animation
            resultArea.style.display = 'block';
            resultArea.classList.add('fade-in');

            // Remove animation classes after completion
            setTimeout(() => {
                document.getElementById('questionCard').classList.remove('bounce', 'shake');
            }, 600);
        }

        function showError(message) {
            const resultArea = document.getElementById('resultArea');
            const resultMessage = document.getElementById('resultMessage');

            resultMessage.className = 'alert alert-warning mb-4';
            resultMessage.innerHTML = `
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                ${message}
            `;

            resultArea.style.display = 'block';
        }

        function showLoading() {
            document.getElementById('loadingSpinner').style.display = 'block';
        }

        function hideLoading() {
            document.getElementById('loadingSpinner').style.display = 'none';
        }

        function disableAnswerButtons() {
            const buttons = document.querySelectorAll('.answer-btn');
            buttons.forEach(btn => {
                btn.disabled = true;
                btn.style.opacity = '0.6';
            });
        }

        function enableAnswerButtons() {
            const buttons = document.querySelectorAll('.answer-btn');
            buttons.forEach(btn => {
                btn.disabled = false;
                btn.style.opacity = '1';
            });
            isAnswered = false;
        }

        function getRandomQuestion() {
            window.location.href = '{{ route("questions.random") }}';
        }

        // Add keyboard support
        document.addEventListener('keydown', function(e) {
            if (isAnswered) return;

            if (e.key === 'y' || e.key === 'Y' || e.key === 'ن') {
                submitAnswer(1);
            } else if (e.key === 'n' || e.key === 'N' || e.key === 'ل') {
                submitAnswer(0);
            }
        });

        // Show keyboard hint

    </script>

@endsection

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display questions list
     */
    public function index(Request $request)
    {
        $query = Question::active()->orderBy('order');

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Filter by difficulty
        if ($request->has('difficulty') && $request->difficulty) {
            $query->byDifficulty($request->difficulty);
        }

        $questions = $query->paginate(12);

        return view('questions.index', compact('questions'));
    }

    /**
     * Show single question for answering
     */
    public function show($id)
    {
        $question = Question::active()->findOrFail($id);

        return view('questions.show', compact('question'));
    }

    /**
     * Get random question
     */
    public function random()
    {
        $question = Question::active()->random(1)->first();

        if (!$question) {
            return redirect()->route('questions.index')
                ->with('error', 'لا توجد أسئلة متاحة حالياً');
        }

        return view('questions.show', compact('question'));
    }

    /**
     * Check answer and return result
     */
    public function checkAnswer(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'answer' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'يرجى اختيار إجابة'
            ], 400);
        }

        $question = Question::active()->findOrFail($id);
        $userAnswer = (bool) $request->answer;
        $isCorrect = $userAnswer === $question->correct_answer;

        $response = [
            'success' => true,
            'is_correct' => $isCorrect,
            'correct_answer' => $question->correct_answer,
            'correct_answer_text' => $question->correct_answer_text,
            'explanation' => $question->explanation,
            'question_id' => $question->id
        ];

        if ($isCorrect) {
            $response['message'] = 'إجابة صحيحة! 🎉';
        } else {
            $response['message'] = 'إجابة خاطئة 😔';
        }

        return response()->json($response);
    }

    /**
     * Get quiz questions
     */
    public function quiz(Request $request)
    {
        $count = $request->get('count', 10);
        $category = $request->get('category');
        $difficulty = $request->get('difficulty');

        $query = Question::active();

        if ($category) {
            $query->byCategory($category);
        }

        if ($difficulty) {
            $query->byDifficulty($difficulty);
        }

        $questions = $query->random($count)->get();

        return view('questions.quiz', compact('questions'));
    }

    /**
     * Submit quiz answers
     */
    public function submitQuiz(Request $request)
    {
        $answers = $request->input('answers', []);
        $results = [];
        $correctCount = 0;
        $totalQuestions = count($answers);

        foreach ($answers as $questionId => $userAnswer) {
            $question = Question::find($questionId);
            if ($question) {
                $isCorrect = (bool)$userAnswer === $question->correct_answer;

                $results[$questionId] = [
                    'question' => $question->question,
                    'user_answer' => (bool)$userAnswer ? 'نعم' : 'لا',
                    'correct_answer' => $question->correct_answer_text,
                    'is_correct' => $isCorrect,
                    'explanation' => $question->explanation
                ];

                if ($isCorrect) {
                    $correctCount++;
                }
            }
        }

        $score = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100) : 0;

        return view('questions.results', compact('results', 'score', 'correctCount', 'totalQuestions'));
    }

    /**
     * Admin: Create new question
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Admin: Store new question
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|min:10',
            'correct_answer' => 'required|boolean',
            'explanation' => 'nullable|string',
            'category' => 'required|in:health,cancer,prevention,treatment,general',
            'difficulty' => 'required|in:easy,medium,hard'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Question::create([
            'question' => $request->question,
            'correct_answer' => $request->correct_answer,
            'explanation' => $request->explanation,
            'category' => $request->category,
            'difficulty' => $request->difficulty,
            'is_active' => true,
            'order' => Question::max('order') + 1
        ]);

        return redirect()->route('admin.questions.index')
            ->with('success', 'تم إضافة السؤال بنجاح');
    }

    /**
     * Get question statistics
     */
    public function getStats()
    {
        $stats = [
            'total' => Question::count(),
            'active' => Question::active()->count(),
            'by_category' => Question::active()->selectRaw('category, count(*) as count')->groupBy('category')->get(),
            'by_difficulty' => Question::active()->selectRaw('difficulty, count(*) as count')->groupBy('difficulty')->get()
        ];

        return response()->json($stats);
    }
}

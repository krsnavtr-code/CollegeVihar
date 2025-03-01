<?php

namespace App\Http\Controllers;

use App\Models\MockTest;
use App\Models\MockQuestion;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    // Show available mock tests for a competitive exam
    public function showMocks($examId)
    {
        $mockTests = MockTest::where('competitive_exam_id', $examId)->with('competitiveExam')->get();
        return view('user.quizzes.mocks', compact('mockTests', 'examId'));
    }

    // Start quiz for a selected mock test
        public function startQuiz($mockTestId)
    {
        $mockTest = MockTest::with(['questions', 'competitiveExam'])->findOrFail($mockTestId);
        $questions = $mockTest->questions->shuffle(); // Shuffle questions for randomness
        session(['quiz_questions' => $questions, 'mock_test_id' => $mockTestId, 'current_question' => 0, 'user_answers' => []]);
        return view('user.quizzes.quiz', compact('mockTest', 'questions'));
    }

    // Handle quiz submission (next question or result)
    public function submitAnswer(Request $request)
    {
        $currentQuestion = session('current_question', 0);
        $questions = session('quiz_questions');
        $userAnswers = session('user_answers', []);

        // Validate answer
        $validatedData = $request->validate([
            'answer' => 'required|in:1,2,3,4',
        ]);

        // Store user's answer
        $userAnswers[$currentQuestion] = $validatedData['answer'];
        session(['user_answers' => $userAnswers]);

        // Move to next question or show result
        $nextQuestion = $currentQuestion + 1;
        if ($nextQuestion < count($questions)) {
            session(['current_question' => $nextQuestion]);
            return response()->json([
                'status' => 'success',
                'question' => $questions[$nextQuestion],
                'current' => $nextQuestion + 1,
                'total' => count($questions),
            ]);
        } else {
            // Calculate result
            $correctAnswers = 0;
            $wrongAnswers = 0;
            foreach ($questions as $index => $question) {
                if ($userAnswers[$index] == $question->correct_answer) {
                    $correctAnswers++;
                } else {
                    $wrongAnswers++;
                }
            }
            $totalQuestions = count($questions);
            $scorePercentage = ($correctAnswers / $totalQuestions) * 100;

            // Store result in database
            Result::create([
                'user_id' => Auth::id(), // Assuming user is authenticated
                'mock_test_id' => session('mock_test_id'),
                'correct_answers' => $correctAnswers,
                'wrong_answers' => $wrongAnswers,
                'score_percentage' => $scorePercentage,
            ]);

            // Clear session data
            session()->forget(['quiz_questions', 'mock_test_id', 'current_question', 'user_answers']);

            return response()->json([
                'status' => 'completed',
                'redirect' => route('quizzes.result', ['mockTestId' => session('mock_test_id')]),
            ]);
        }
    }

    // Show quiz result
    public function showResult($mockTestId)
    {
        $result = Result::where('user_id', Auth::id())->where('mock_test_id', $mockTestId)->latest()->first();
        if (!$result) {
            return redirect()->route('home')->with('error', 'No result found.');
        }
        return view('user.quizzes.result', compact('result'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\MockTest;
use App\Models\MockQuestion;
use App\Models\Result;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


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
            \Log::info('Starting Quiz with Mock Test ID:', ['mockTestId' => $mockTestId]);
            $mockTest = MockTest::with(['questions', 'competitiveExam'])->findOrFail($mockTestId);
            $questions = $mockTest->questions->shuffle(); // Shuffle questions for randomness
            session(['quiz_questions' => $questions, 'mock_test_id' => $mockTestId, 'current_question' => 0, 'user_answers' => []]);
            \Log::info('Session Data Set:', session()->all());
            return view('user.quizzes.quiz', compact('mockTest', 'questions'));
        }

            // Handle quiz submission (next question or result)
          public function submitAnswer(Request $request)
{
    $currentQuestion = session('current_question', 0);
    $questions = session('quiz_questions');
    $userAnswers = session('user_answers', []);
    $mockTestId = session('mock_test_id');
    $email = Session::get('email'); // Get email from session

    \Log::info('Current Session Data:', session()->all()); // Debug log to check session

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

        $otpRecord = Otp::where('email', $email)->where('user_type', 'mock')->first();

        Result::create([
            'user_id' => $otpRecord ? $otpRecord->id : null, // Use otp.id if exists and user_type is "mock"
            'mock_test_id' => $mockTestId,
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
            'score_percentage' => $scorePercentage,
        ]);

        session()->forget(['quiz_questions', 'current_question', 'user_answers']);

        \Log::info('Redirecting to Result with Mock Test ID:', ['mockTestId' => $mockTestId]);

        return response()->json([
            'status' => 'completed',
            'redirect' => route('quizzes.result', ['mockTestId' => $mockTestId]),
        ]);
    }
}

    // Show quiz result
         public function showResult($mockTestId)
        {
            \Log::info('Showing Result for Mock Test ID:', ['mockTestId' => $mockTestId]);

            $email = Session::get('email');

             $otpRecord = Otp::where('email', $email)->where('user_type', 'mock')->first();

            $result = Result::where('mock_test_id', $mockTestId)
                            ->where('user_id', $otpRecord->id)
                            ->latest()
                            ->first();
        
            \Log::info('Result Query Result:', ['result' => $result]);

            if (!$result) {
                \Log::error('No result found for Mock Test ID: ' . $mockTestId);
                return redirect()->route('home')->with('error', 'No result found for this mock test.');
            }

            return view('user.quizzes.result', compact('result'));
        }


}
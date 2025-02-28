<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MCQTest;
use App\Models\CompetitiveExam;

class MCQTestController extends Controller
{
   
    public function index()
    {
        $mcqs = MCQTest::all();
        return view('admin.mcq.index', compact('mcqs'));
    }

   
    public function show($id)
    {
        $mcq = MCQTest::findOrFail($id);
        return view('admin.mcq.view', compact('mcq'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'test_duration' => 'required|integer',
            'question' => 'required|string',
            'answer1' => 'required|string',
            'answer2' => 'required|string',
            'answer3' => 'required|string',
            'answer4' => 'required|string',
            'correct_answer' => 'required|in:1,2,3,4',
            'competitive_exam_id' => 'required|exists:competitive_exams,id',
        ]);

        $mcq = MCQTest::create($request->all());
        return redirect('admin/mcq-test')->with('success', 'Successfully Added');
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'test_duration' => 'integer',
            'question' => 'string',
            'answer1' => 'string',
            'answer2' => 'string',
            'answer3' => 'string',
            'answer4' => 'string',
            'correct_answer' => 'in:1,2,3,4',
            'competitive_exam_id' => 'required|exists:competitive_exams,id',
        ]);

        $mcq = MCQTest::findOrFail($id);
        $mcq->update($request->all());
        return redirect('admin/mcq-test')->with('success', 'Successfully Updated');
    }

   
    public function destroy($id)
    {
        $mcq = MCQTest::findOrFail($id);
        $mcq->delete();
        return response()->json(['message' => 'MCQ deleted successfully']);
    }


    public function showQuiz($competitive_exam_id)
{
    $exam = CompetitiveExam::findOrFail($competitive_exam_id);
    $mcqs = MCQTest::where('competitive_exam_id', $competitive_exam_id)->get();
    
    if ($mcqs->isEmpty()) {
        return redirect()->back()->with('error', 'No MCQs available for this exam.');
    }

    $mcqIds = $mcqs->pluck('id')->toArray();
    session(['current_mcq_index' => 0, 'mcq_ids' => $mcqIds, 'answers' => []]);
    
    $nextmcq = $mcqs->first();
    return view('user.quiz.quiz', compact('nextmcq', 'exam'));
}

public function nextQuiz(Request $request, $competitive_exam_id)
{
    try {
        $exam = CompetitiveExam::findOrFail($competitive_exam_id);
        $mcqIds = session('mcq_ids', []);
        $currentIndex = session('current_mcq_index', 0);
        $answers = session('answers', []);

        \Log::info('Session Data: ', ['mcq_ids' => $mcqIds, 'currentIndex' => $currentIndex, 'answers' => $answers]);

        if ($request->has('answer')) {
            $request->validate(['answer' => 'required|in:1,2,3,4']);
            $currentMcqId = $mcqIds[$currentIndex] ?? null;
            if ($currentMcqId) {
                $currentMcq = MCQTest::findOrFail($currentMcqId);
                $answers[$currentMcqId] = [
                    'given_answer' => $request->answer,
                    'correct_answer' => $currentMcq->correct_answer
                ];
            } else {
                \Log::error('Current MCQ ID is null for index: ' . $currentIndex);
                return response()->json(['error' => 'Invalid quiz state. Please restart the quiz.'], 500);
            }
        }

        $nextIndex = $currentIndex + 1;
        if ($nextIndex < count($mcqIds)) {
            session(['current_mcq_index' => $nextIndex, 'answers' => $answers]);
            $nextmcq = MCQTest::findOrFail($mcqIds[$nextIndex]);
            return response()->json([
                'success' => true,
                'mcq' => [
                    'question' => $nextmcq->question,
                    'answers' => [
                        $nextmcq->answer1,
                        $nextmcq->answer2,
                        $nextmcq->answer3,
                        $nextmcq->answer4
                    ],
                    'id' => $nextmcq->id
                ],
                'feedback' => $request->has('answer') 
                    ? ($answers[$currentMcqId]['given_answer'] == $answers[$currentMcqId]['correct_answer'] 
                        ? ['type' => 'correct', 'message' => 'Correct answer!'] 
                        : ['type' => 'incorrect', 'message' => 'Wrong answer. The correct answer was ' . $answers[$currentMcqId]['correct_answer']])
                    : null,
                'progress' => [
                    'current' => $nextIndex + 1,
                    'total' => count($mcqIds)
                ]
            ]);
        } else {
            $result = new \App\Models\Result();
            $result->competitive_exam_id = $competitive_exam_id;
            $result->total_mcqs = count($answers);
            $result->correct_answers = collect($answers)->filter(function ($answer) {
                return $answer['given_answer'] == $answer['correct_answer'];
            })->count();
            $result->score = (collect($answers)->filter(function ($answer) {
                return $answer['given_answer'] == $answer['correct_answer'];
            })->count() / count($answers)) * 100;
            $result->save();

            // Ensure answers are passed to the session before clearing
            session(['answers' => $answers]); // Store answers temporarily
            session(['current_mcq_index' => 0, 'mcq_ids' => []]); // Clear other session data
            return response()->json(['redirect' => route('exam.result', $competitive_exam_id)]);
        }
    } catch (\Exception $e) {
        \Log::error('Error in nextQuiz: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred. Please try again.'], 500);
    }
}

    public function showResult($competitive_exam_id)
{
    $exam = CompetitiveExam::findOrFail($competitive_exam_id);
    $answers = session('answers', []);
    
    $totalMcqs = count($answers);
    if ($totalMcqs === 0) {
        return redirect()->back()->with('error', 'No answers recorded for this quiz. Please try again.');
    }

    $correctAnswers = collect($answers)->filter(function ($answer) {
        return $answer['given_answer'] == $answer['correct_answer'];
    })->count();
    
    $score = ($correctAnswers / $totalMcqs) * 100;
    
    return view('user.quiz.result', compact('exam', 'correctAnswers', 'totalMcqs', 'score'));
}
}

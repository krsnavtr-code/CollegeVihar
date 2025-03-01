<?php

namespace App\Http\Controllers;

use App\Models\MockTest;
use App\Models\MockQuestion;
use App\Models\CompetitiveExam;
use Illuminate\Http\Request;

class MockTestController extends Controller
{
    // Show the create mock test form
    public function create()
    {
        $exams = CompetitiveExam::all(); // Fetch all competitive exams for dropdown
        return view('admin.mock-tests.create', compact('exams'));
    }

    // Store the mock test and questions
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'test_duration' => 'required|integer',
            'competitive_exam_id' => 'required|exists:competitive_exams,id',
            'questions' => 'required|array',
            'questions.*.question' => 'required|string',
            'questions.*.answer1' => 'required|string',
            'questions.*.answer2' => 'required|string',
            'questions.*.answer3' => 'required|string',
            'questions.*.answer4' => 'required|string',
            'questions.*.correct_answer' => 'required|in:1,2,3,4',
        ]);

        // Create mock test
        $mockTest = MockTest::create([
            'test_duration' => $validatedData['test_duration'],
            'competitive_exam_id' => $validatedData['competitive_exam_id'],
        ]);

        // Create questions
        foreach ($validatedData['questions'] as $questionData) {
            MockQuestion::create([
                'mock_test_id' => $mockTest->id,
                'question' => $questionData['question'],
                'answer1' => $questionData['answer1'],
                'answer2' => $questionData['answer2'],
                'answer3' => $questionData['answer3'],
                'answer4' => $questionData['answer4'],
                'correct_answer' => $questionData['correct_answer'],
            ]);
        }

        return redirect('/admin/mock-test')->with('success', 'Mock test created successfully!');
    }

    // Show all mock tests (index)
    public function index()
    {
        $mockTests = MockTest::with('competitiveExam')->get();
        return view('admin.mock-tests.index', compact('mockTests'));
    }


    // Show a single mock test
        public function show($id)
        {
            $mockTest = MockTest::with('questions', 'competitiveExam')->findOrFail($id);
            return view('admin.mock-tests.show', compact('mockTest'));
        }


    // Show edit form for a mock test
    public function edit($id)
    {
        $mockTest = MockTest::with('questions', 'competitiveExam')->findOrFail($id);
        $exams = CompetitiveExam::all();
        return view('admin.mock-tests.edit', compact('mockTest', 'exams'));
    }

    // Update mock test and questions
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'test_duration' => 'required|integer',
            'competitive_exam_id' => 'required|exists:competitive_exams,id',
            'questions' => 'required|array',
            'questions.*.id' => 'nullable|exists:mock_questions,id',
            'questions.*.question' => 'required|string',
            'questions.*.answer1' => 'required|string',
            'questions.*.answer2' => 'required|string',
            'questions.*.answer3' => 'required|string',
            'questions.*.answer4' => 'required|string',
            'questions.*.correct_answer' => 'required|in:1,2,3,4',
        ]);

        $mockTest = MockTest::findOrFail($id);
        $mockTest->update([
            'test_duration' => $validatedData['test_duration'],
            'competitive_exam_id' => $validatedData['competitive_exam_id'],
        ]);

        // Update or create questions
        foreach ($validatedData['questions'] as $questionData) {
            if (isset($questionData['id'])) {
                // Update existing question
                MockQuestion::findOrFail($questionData['id'])->update([
                    'question' => $questionData['question'],
                    'answer1' => $questionData['answer1'],
                    'answer2' => $questionData['answer2'],
                    'answer3' => $questionData['answer3'],
                    'answer4' => $questionData['answer4'],
                    'correct_answer' => $questionData['correct_answer'],
                ]);
            } else {
                // Create new question
                MockQuestion::create([
                    'mock_test_id' => $mockTest->id,
                    'question' => $questionData['question'],
                    'answer1' => $questionData['answer1'],
                    'answer2' => $questionData['answer2'],
                    'answer3' => $questionData['answer3'],
                    'answer4' => $questionData['answer4'],
                    'correct_answer' => $questionData['correct_answer'],
                ]);
            }
        }

        return redirect('admin/mock-test')->with('success', 'Mock test updated successfully!');
    }

    // Delete mock test (and related questions)
    public function destroy($id)
    {
        $mockTest = MockTest::findOrFail($id);
        $mockTest->questions()->delete(); // Delete related questions
        $mockTest->delete();

        return redirect('admin/mock-test')->with('success', 'Mock test deleted successfully!');
    }
}
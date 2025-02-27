<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MCQTest;

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
}

@extends('admin.components.layout')

@section('main')
<div class="container">
    <h2>Edit MCQ</h2>
    <form action="{{ route('admin.mcq.update', $mcq->id) }}" method="POST">
        @csrf
       
        <section class="panel">
            <div class="field">
                <label>Test Duration (minutes)</label>
                <input type="number" name="test_duration" placeholder="Enter test duration" value="{{ $mcq->test_duration }}" required>
            </div>
            <div class="field">
                <label>Question</label>
                <textarea name="question" placeholder="Enter question" required>{{ $mcq->question }}</textarea>
            </div>
            @for($i = 1; $i <= 4; $i++)
            <div class="field">
                <label>Answer {{ $i }}</label>
                <input type="text" name="answer{{ $i }}" placeholder="Enter Answer {{ $i }}" value="{{ $mcq['answer'.$i] }}" required>
            </div>
            @endfor
            <div class="field">
                <label>Correct Answer</label>
                <select name="correct_answer" required>
                    <option value="1" {{ $mcq->correct_answer == '1' ? 'selected' : '' }}>Answer 1</option>
                    <option value="2" {{ $mcq->correct_answer == '2' ? 'selected' : '' }}>Answer 2</option>
                    <option value="3" {{ $mcq->correct_answer == '3' ? 'selected' : '' }}>Answer 3</option>
                    <option value="4" {{ $mcq->correct_answer == '4' ? 'selected' : '' }}>Answer 4</option>
                </select>
            </div>
            <div class="field">
                <label>Competitive Exam</label>
                <select name="competitive_exam_id" required>
                    @foreach($competitiveExams as $exam)
                        <option value="{{ $exam->id }}" {{ $mcq->competitive_exam_id == $exam->id ? 'selected' : '' }}>{{ $exam->exam_type }}</option>
                    @endforeach
                </select>
            </div>
        </section>
        <div class="text-end p-4">
            <button type="submit" class="btn btn-warning btn-lg">Update MCQ</button>
        </div>
    </form>
</div>
@endsection

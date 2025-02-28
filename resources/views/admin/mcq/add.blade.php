@extends('admin.components.layout')

@section('main')
<div class="container">
    <h2>Add New MCQ</h2>
    <form action="{{ route('admin.mcq.store') }}" method="POST">
        @csrf
        <section class="panel">
            <div class="field">
                <label>Test Duration (minutes)</label>
                <input type="number" name="test_duration" placeholder="Enter test duration" required>
            </div>
            <div class="field">
                <label>Question</label>
                <textarea name="question" placeholder="Enter question" required></textarea>
            </div>
            @for($i = 1; $i <= 4; $i++)
            <div class="field">
                <label>Answer {{ $i }}</label>
                <input type="text" name="answer{{ $i }}" placeholder="Enter Answer {{ $i }}" required>
            </div>
            @endfor
            <div class="field">
                <label>Correct Answer</label>
                <select name="correct_answer" required>
                    <option value="1">Answer 1</option>
                    <option value="2">Answer 2</option>
                    <option value="3">Answer 3</option>
                    <option value="4">Answer 4</option>
                </select>
            </div>
            <div class="field">
                <label>Competitive Exam</label>
                <select name="competitive_exam_id" required>
                    @foreach($competitiveExams as $exam)
                        <option value="{{ $exam->id }}">{{ $exam->exam_type }}</option>
                    @endforeach
                </select>
            </div>
        </section>
        <div class="text-end p-4">
            <button type="submit" class="btn btn-primary btn-lg">Save MCQ</button>
        </div>
    </form>
</div>

@endsection

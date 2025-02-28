@extends('admin.components.layout')

@section('main')
<div class="container">
    <h2>MCQ Details</h2>
    <p><strong>Test Duration:</strong> {{ $mcq->test_duration }} minutes</p>
    <p><strong>Question:</strong> {{ $mcq->question }}</p>
    <ul>
        <li><strong>1:</strong> {{ $mcq->answer1 }}</li>
        <li><strong>2:</strong> {{ $mcq->answer2 }}</li>
        <li><strong>3:</strong> {{ $mcq->answer3 }}</li>
        <li><strong>4:</strong> {{ $mcq->answer4 }}</li>
    </ul>
    <p><strong>Correct Answer:</strong> {{ $mcq->correct_answer }}</p>
    <p><strong>Competitive Exam:</strong> {{ $mcq->competitiveExam->exam_type ?? 'Not assigned' }}</p>
    <a href="{{ route('admin.mcq.index') }}" class="btn btn-primary">Back to MCQs</a>
</div>
@endsection

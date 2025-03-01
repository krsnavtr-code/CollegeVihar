@php
$page_title = 'Test Result';
@endphp

@extends('user.info.layout')
@section('main_section')
<div class="container">
    <h1>Quiz Result</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Correct Answers:</strong> {{ $result['correct'] }}</p>
            <p><strong>Wrong Answers:</strong> {{ $result['wrong'] }}</p>
            <p><strong>Score Percentage:</strong> {{ number_format($result['percentage'], 2) }}%</p>
            <a href="{{ route('quizzes.index', 1) }}" class="btn btn-secondary">Back to Quizzes</a>
        </div>
    </div>
</div>
@endsection
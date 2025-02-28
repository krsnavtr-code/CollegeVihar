@php
$page_title = 'Competitive Test Result';
@endphp

@extends('user.info.layout')
@section('main_section')

<div class="container">
    <h2>{{ $exam->exam_type }} Quiz Result</h2>
    <p><strong>Total MCQs:</strong> {{ $totalMcqs }}</p>
    <p><strong>Correct Answers:</strong> {{ $correctAnswers }}</p>
    <p><strong>Score:</strong> {{ number_format($score, 2) }}%</p>
    <a href="#" class="btn btn-primary">Back to Home</a>
</div>
@endsection
@php
$page_title = 'Quiz Result';
@endphp

@extends('user.info.layout')
@section('main_section')

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-success text-white text-center py-4">
            <h1 class="mb-0">{{ $exam->exam_type }} Quiz Result</h1>
        </div>
        <div class="card-body p-5">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">Total Questions</h5>
                            <p class="card-text display-6">{{ $totalMcqs }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title text-success">Correct Answers</h5>
                            <p class="card-text display-6">{{ $correctAnswers }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title text-info">Score</h5>
                            <p class="card-text display-6">{{ number_format($score, 2) }}%</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="#" class="btn btn-outline-primary btn-lg px-5 py-3">Back to Home</a>
            </div>
        </div>
        <div class="card-footer bg-light text-center py-3">
            
        </div>
    </div>
</div>

@endsection
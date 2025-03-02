@php
$page_title = 'Test Result';
@endphp

@extends('user.info.layout')

@section('main_section')

<style>
    .result-container {
        max-width: 500px;
        width: 100%;
        text-align: center;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        padding: 30px;
        overflow: hidden;
    }

    .result-header {
        background: linear-gradient(135deg, #007bff, #6610f2);
        color: white;
        padding: 15px;
        font-size: 22px;
        font-weight: bold;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .badge-custom {
        font-size: 18px;
        padding: 6px 12px;
    }

    .progress-bar {
        animation: fillProgress 1.5s ease-in-out;
    }

    @keyframes fillProgress {
        from { width: 0%; }
        to { width: {{ $result->score_percentage }}%; }
    }
</style>

<div class="container mt-5 d-flex justify-content-center">
    <div class="result-container">
        <!-- Header Section -->
        <div class="result-header">
            Test Result
        </div>

        <!-- Main Content -->
        <div class="p-4">
            <h4 class="text-secondary mb-3">{{ $result->mockTest->competitiveExam->exam_type }} - Mock Test</h4>

            <p><strong>Correct Answers:</strong> <span class="badge bg-success badge-custom mb-3">{{ $result->correct_answers }}</span></p>
            <p><strong>Wrong Answers:</strong> <span class="badge bg-danger badge-custom">{{ $result->wrong_answers }}</span></p>

            <!-- Score Progress Bar -->
            <div class="mt-3">
                <p><strong>Score Percentage:</strong> {{ number_format($result->score_percentage, 2) }}%</p>
                <div class="progress" style="height: 20px; border-radius: 10px;">
                    <div class="progress-bar bg-primary" role="progressbar" 
                        style="width: {{ $result->score_percentage }}%;" 
                        aria-valuenow="{{ $result->score_percentage }}" 
                        aria-valuemin="0" aria-valuemax="100">
                        {{ number_format($result->score_percentage, 2) }}%
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-4">
                <a href="/" class="btn btn-primary btn-lg">
                    <i class="fas fa-home"></i> Back to Home
                </a>
                
            </div>
        </div>
    </div>
</div>

@endsection

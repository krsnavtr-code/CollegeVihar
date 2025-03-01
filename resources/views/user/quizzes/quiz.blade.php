@php
    $page_title = 'MCQs Test';
@endphp

@extends('user.info.layout')

@section('main_section')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h1 class="text-center text-primary mb-4">{{ $mockTest->competitiveExam->exam_type }} - Mock Test {{ $mockTest->id }}</h1>

        <div id="quiz-container" class="text-center">
            @if($questions->isNotEmpty())
                @php $firstQuestion = $questions->first(); @endphp
                <div class="question card p-3 border-0" data-question-id="{{ $firstQuestion->id }}">
                    <h4 class="mb-3">Question <span id="current-question" class="text-danger">{{ session('current_question', 1) }}</span> of {{ $questions->count() }}</h4>
                    <p id="question-text" class="lead font-weight-bold">{{ $firstQuestion->question }}</p>
                    
                    <ul id="answers-list" class="list-group text-left mt-3">
                        @foreach(range(1, 4) as $index)
                            <li class="list-group-item d-flex align-items-center">
                                <input type="radio" name="answer" value="{{ $index }}" id="answer{{ $index }}" class="mr-2">
                                <label for="answer{{ $index }}" class="m-0">{{ $firstQuestion->{'answer' . $index} }}</label>
                            </li>
                        @endforeach
                    </ul>
                    
                    <button id="submit-answer" class="btn btn-primary btn-lg mt-4" style="background-color: #007bff; border-color: #007bff;">Next</button>
                </div>
            @else
                <p class="text-muted">No questions available for this mock test.</p>
            @endif
        </div>

        
    </div>
</div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    console.log("Quiz Page Loaded");

    $(document).on('click', '#submit-answer', function() {
        let selectedAnswer = $('input[name="answer"]:checked').val();
        if (!selectedAnswer) {
            alert('Please select an answer.');
            return;
        }

        $('#loading').show();
        $('#submit-answer').prop('disabled', true).text('Please wait...');

        $.ajax({
            url: '{{ route('quizzes.submit') }}',
            method: 'POST',
            data: { 
                answer: selectedAnswer, 
                _token: '{{ csrf_token() }}' 
            },
            success: function(response) {
                console.log("Response:", response);

                if (response.status === 'success') {
                    $('#current-question').text(response.current);
                    $('#question-text').text(response.question.question);
                    
                    let answersHtml = '';
                    for (let i = 1; i <= 4; i++) {
                        answersHtml += `<li class='list-group-item d-flex align-items-center'>
                            <input type='radio' name='answer' value='${i}' id='answer${i}' class='mr-2'>
                            <label for='answer${i}' class='m-0'>${response.question['answer' + i]}</label>
                        </li>`;
                    }
                    $('#answers-list').html(answersHtml);

                    $('#submit-answer').prop('disabled', false).text('Next');
                    $('#loading').hide();
                } else if (response.status === 'completed') {
                    window.location.href = response.redirect;
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                $('#loading').hide();
                $('#submit-answer').prop('disabled', false).text('Next');
            }
        });
    });
});
</script>
@endpush